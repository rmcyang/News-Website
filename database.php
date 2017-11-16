<?php
$mysqli = new mysqli('localhost', 'minchu', 'minchu', 'news_website');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>