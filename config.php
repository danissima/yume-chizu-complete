<?php

$db_host = 'eu-cdbr-west-03.cleardb.net';
$db_user = 'bb18f3fbe9be1a';
$db_password = 'f9c711dd';
$db_name = 'heroku_6b87e0e662de725';

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
$mysqli->query("SET NAMES 'utf-8'");

if ($mysqli->connect__errno) {
	echo 'oshibka u tebya, dura4ok';
}

?>