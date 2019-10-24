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
