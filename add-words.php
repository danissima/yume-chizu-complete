<?php 
include('config.php');

$wordKanji = $_GET['wordKanji'];
$wordKana = $_GET['wordKana'];
$wordTranslation = $_GET['wordTranslation'];
$wordFrom = $_GET['from'];
$action = $_GET['action'];

if ($action == 'add' && $wordKana[0]) {
	for($i = 0; $i < count($wordKana); $i++) {
		$itemKanji = $wordKanji[$i];
		$itemKana = $wordKana[$i];
		$itemTranslation = $wordTranslation[$i];
		$mysqli->query("INSERT INTO words (`ID`, `word_kanji`, `kana`, `translation`) VALUES (NULL, '$itemKanji', '$itemKana', '$itemTranslation')");
	}
} else if ($action == 'change') {
	$wordId = $_GET['changing'];
	if ($wordFrom == 'words') {
		$mysqli->query("UPDATE words SET `word_kanji` = '$wordKanji', `kana` = '$wordKana', `translation` = '$wordTranslation' WHERE `words`.`ID` = '$wordId'");
	} else {
		$mysqli->query("UPDATE combinations SET `combination` = '$wordKanji', `kana` = '$wordKana', `translation` = '$wordTranslation' WHERE `combinations`.`ID` = '$wordId'");
	}
} else if ($action == 'delete') {
	$wordId = $_GET['deleting'];
	if ($wordFrom == 'words') {
		$mysqli->query("DELETE FROM words WHERE `words`.`ID` = '$wordId'");
	} else {
		$mysqli->query("DELETE FROM combinations WHERE `combinations`.`ID` = '$wordId'");
	}
}


header('Location: words.php');
?>