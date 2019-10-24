<?php
session_start();
if (!isset($_SESSION['logged'])) {
	header("Location: login.php");
	exit();
}

ini_set("log_errors", 1);
ini_set("error_log", "./error.log");

include 'config.php';
include 'onesignal.php';


if (isset($_POST['send'])) {

	$on = new OneSignal($app_id, $auth_key, $api_logo);

	$title = $_POST['title'];
	$content = $_POST['content'];
	$url = $_POST['url'];
	$res = $on->sendMessage($title, $content, $url, $lang = 'en');

	$book = json_decode($res, true);
	echo $book['recipients'];
}
if (isset($_POST['single'])) {

	$on = new OneSignal($app_id, $auth_key, $api_logo);

	$title = $_POST['title'];
	$content = $_POST['content'];
	$url = $_POST['url'];
	$userid = $_POST['devicesid'];
	$res = $on->singleMessage($title, $content, $url, $userid, $lang = 'en');

	$book = json_decode($res, true);
	echo $book['recipients'];
}
if (isset($_POST['sendafter'])) {

	$on = new OneSignal($app_id, $auth_key, $api_logo);
	$sendaft = $_POST['send_after'];
	$feed = $_POST['feed'];

	$xml = simplexml_load_string(file_get_contents($feed));
	$json = json_encode($xml);
	$array = json_decode($json, TRUE);
	$title = $array['channel']['title'];
	$content = $array['channel']['description'];
	$url = $array['channel']['link'];

	// var_dump($array['channel']['title']);
	// die();
	// $title = $_POST['title'];
	// $content = $_POST['content'];
	// $url = $_POST['url'];
	$res = $on->sendAfter($title, $content, $url, $sendaft, $lang = 'en');

	$book = json_decode($res, true);
	echo $book['recipients'];
}
if (isset($_POST['dailyschedule'])) { //here we save to file

	$schedule = [];
	if (file_get_contents('./schedule.json', FILE_USE_INCLUDE_PATH)) {
		$file = file_get_contents('./schedule.json', FILE_USE_INCLUDE_PATH);
		$schedule = json_decode($file, true);
	}

	$schedule['feed'] = $_POST['feed'];
	// $schedule['time'] = $_POST['time'];
	$schedule['time_from'] = $_POST['time_from'];
	$schedule['time_to'] = $_POST['time_to'];
	$schedule['status'] = $_POST['status'];

	file_put_contents('./schedule.json', json_encode($schedule));

	$result = ["schedule" => "Notification " . ($_POST['status'] == "start" ? "scheduled between " . $schedule['time_from'] . " to " . $schedule['time_to'] . " everyday" : "schedule stopped")];
	echo json_encode($result);
}
