<?php 
include('config.php');

$radicalsViews = $_GET['radicalView'];
$radicalsNumbers = $_GET['radicalNumber'];
$radicalsNames = $_GET['radicalName'];
$action = $_GET['action'];

if ($action == 'add' && $radicalsViews[0]) {
	for($i = 0; $i < count($radicalsViews); $i++) {
		$itemView = $radicalsViews[$i];
		$itemNumber = $radicalsNumbers[$i];
		$itemName = $radicalsNames[$i];
		$mysqli->query("INSERT INTO kanji_keys (`ID`, `key_number`, `key_view`, `key_name`) VALUES (NULL, '$itemNumber', '$itemView', '$itemName')");
	}
} else if ($action == 'change') {
	$radicalID = $_GET['changing'];
	$mysqli->query("UPDATE kanji_keys SET `key_number` = '$radicalsNumbers', `key_view` = '$radicalsViews', `key_name` = '$radicalsNames' WHERE `kanji_keys`.`ID` = '$radicalID'");
} else if ($action == 'delete') {
	$radicalID = $_GET['deleting'];
	$mysqli->query("DELETE FROM kanji_keys WHERE `kanji_keys`.`ID` = '$radicalID'");
}

header('Location: radicals.php');

?>