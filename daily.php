<?php
ini_set("log_errors", 1);
ini_set("error_log", "./error.log");

include 'onesignal.php';

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

function runschedule()
{
    include 'config.php';

    $on = new OneSignal($app_id, $auth_key, $api_logo);


    $file = file_get_contents('./schedule.json', FILE_USE_INCLUDE_PATH);
    $schedule = json_decode($file, true);

    if ($schedule['status'] == "start") {

        $xml = simplexml_load_string(file_get_contents($schedule['feed']));
        // file_put_contents('./xml.json', file_get_contents($schedule['feed']));
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);

        $sent_posts = [];

        // var_dump($array);
        // die();

        if (!empty($schedule['sent_posts'])) {
            $sent_posts = $schedule['sent_posts'];
        }

        foreach ($array['channel']['item'] as $item) {
            if (!in_array($item['pubDate'], $sent_posts)) {
                $sent_posts[] = $item['pubDate'];

                $title = $item['title'];
                $content = !empty($item['description']) ? $item['description'] : "";
                $url = $item['link'];
                // $url = $item['link'];
                // $chrome_web_icon = getFirstImg($item);
                // var_dump($chrome_web_icon);
                // var_dump($chrome_web_icon);
                // die();

                $res = $on->sendDaily($title, $content, $url, $schedule['time'], "", $lang = 'en');
                break;
            }
        }


        $schedule['sent_posts'] = $sent_posts;

        // die();

        file_put_contents('./schedule.json', json_encode($schedule));




        // $book = json_decode($res, true);
        // echo $book['recipients'];
    }
}
