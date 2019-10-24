<?php
ini_set("log_errors", 1);
ini_set("error_log", "./error.log");

include 'onesignal.php';
// require __DIR__ . '/vendor/autoload.php';
// require_once('./php/autoloader.php');

include_once('simplepie/autoloader.php');

include_once('simplepie/idn/idna_convert.class.php');

include_once('simple_html_dom.php');


function getFirstImg($html)
{
    $dom  = new \DOMDocument();
    $dom->loadHTML(json_encode($html));

    $dom->preserveWhiteSpace = false;

    $images = [];
    foreach ($dom->getElementsByTagName('img') as $image) {
        $images[] = $image->getAttribute('src');
    }
    // var_dump($images);
    // die();

    return $images[0];
}

function getFeed($rssurl)
{
    if (isset($_COOKIE['rss_post_links'])) {
        $rss_post_links = json_decode($_COOKIE['rss_post_links'], true);
    } else {
        $rss_post_links = array();
    }

    $returnArr = array();

    $returnArr['success'] = 0;

    $returnArr['msg'] = 'Something wrong';

    $returnArr['data'] = array();

    //$rssurl = 'http://rss.cnn.com/rss/edition.rss';

    //$rssurl = 'http://mashable.com/social-media/feed/';


    try {

        // Create a new instance of the SimplePie object

        $feed = new SimplePie();

        // Use the URL that was passed to the page in SimplePie

        $feed->set_feed_url($rssurl);

        // Trigger force-feed

        $feed->force_feed(true);

        // Initialize the whole SimplePie object.  Read the feed, process it, parse it, cache it, and

        // all that other good stuff.  The feed's information will not be available to SimplePie before

        // this is called.

        $success = $feed->init();

        if ($feed->error()) {

            $returnArr['success'] = 0;

            $returnArr['msg'] = $feed->error();

            return json_encode($returnArr);
        }


        // We'll make sure that the right content type and character encoding gets set automatically.

        // This function will grab the proper character encoding, as well as set the content type to text/html.

        $feed->handle_content_type();

        $returnArr = array();

        $items = $feed->get_items();

        $content = '';

        $img = '';

        $gotUniqueData = false;

        foreach ($items as $item) {

            if ($gotUniqueData)
                break;

            $title = $item->get_title();

            $content = ($item->get_content()) ? $item->get_content() : $item->get_description();

            // Check for enclosures.  If an item has any, set the first one to the $enclosure variable.

            if ($enclosure = $item->get_enclosure(0)) {

                if ($enclosure->get_thumbnail()) {

                    $img = $enclosure->get_thumbnail();
                } else if ($content) {

                    $description = $content;

                    $desc_dom = str_get_html($description);

                    $image = $desc_dom->find('img', 0);

                    if (isset($image->src))
                        $img = $image->src;
                    else
                        $img = 'https://suite.social/apps/notify/admin/suite_80px.jpg';
                }
            }

            $link = $item->get_permalink();

            if (!in_array($link, $rss_post_links)) {

                $rss_post_links[] = $link;

                setcookie("rss_post_links", json_encode($rss_post_links));

                $gotUniqueData = true;
            }
        }

        $content = str_replace('"', "'", $content);  //double quotes for mailto: emails.

        $strip_tags = trim(strip_tags($content));

        $content = trim($content);


        if ($gotUniqueData) {

            $returnData = array();

            $message2 = ($strip_tags) ? $strip_tags : $content;

            $message2 = substr($message2, 0, 350);

            $returnData['title'] = $title;

            $returnData['message'] = $message2;

            $returnData['link'] = $link;

            $returnData['img'] = $img;
        } else {
            $returnData = array();

            $message2 = ($strip_tags) ? $strip_tags : $content;

            $message2 = substr($message2, 0, 350);

            $returnData['title'] = $title;

            $returnData['message'] = $message2;

            $returnData['link'] = $link;

            $returnData['img'] = $img;

            $rss_post_links = array();

            $rss_post_links[] = $link;

            setcookie("rss_post_links", json_encode($rss_post_links));
        }


        $returnArr['success'] = 1;

        $returnArr['msg'] = 'got data from rss feed';

        $returnArr['data'] = $returnData;
        return $returnArr;
    } catch (Exception $exc) {

        return $exc->getTraceAsString();
    }
}

//receives a simple pie item
function getImage($item)
{
    $htmlDOM = new simple_html_dom();
    $htmlDOM->load($item->get_content());
    $image = $htmlDOM->find('img', 0);
    return $image->src;
}

function runschedule()
{
    include 'config.php';

    $on = new OneSignal($app_id, $auth_key, $api_logo);


    $file = file_get_contents('./schedule.json', FILE_USE_INCLUDE_PATH);
    $schedule = json_decode($file, true);

    if ($schedule['status'] == "start") {


        $feed = new SimplePie();
        $feed->set_feed_url($schedule['feed']);
        $feed->init();
        $feed->handle_content_type();

        $sent_posts = [];

        if (!empty($schedule['sent_posts'])) {
            $sent_posts = $schedule['sent_posts'];
        }


        foreach ($feed->get_items() as $item) {
            // var_dump($item->get_date());

            if (!in_array($item->get_date(), $sent_posts)) {
                $sent_posts[] = $item->get_date();

                $title = $item->get_title();
                $content = !empty($item->get_description()) ? $item->get_description() : "";
                $url = !empty($item->get_link()) ? $item->get_link() : "";
                $chrome_web_icon = !empty(getImage($item)) ? getImage($item) : "";

                $start = strtotime($schedule['time_from']);
                $end =  strtotime($schedule['time_to']);

                // $randomDate = date("Y-m-d H:i:s", rand($start, $end));
                $randomTime = date("h:i A", rand($start, $end));

                // die($randomTime);

                $res = $on->sendDaily($title, $content, $url, $randomTime, $chrome_web_icon);
                break;
            }
        }


        $schedule['sent_posts'] = $sent_posts;
        file_put_contents('./schedule.json', json_encode($schedule));
    }
}
