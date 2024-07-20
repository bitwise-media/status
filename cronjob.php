<?php
require(__dir__ . '/database.php');

$websites = parse_ini_file('websites.ini');

function check_website ($url) {
	$ch = curl_init();
	$timeout = 5;

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

foreach ($websites as $title => $url) {
	$output = check_website($url);
	$isUp = false;

	if (($output == NULL) || ($output === false)) {
		$isUp = false;
	} else {
		$isUp = true;
	}

	// read the database
	$database = new Database($title);
	$data = $database->read();

	// add result to database
	$data[] = $isUp;
	$database->write($data);
}
