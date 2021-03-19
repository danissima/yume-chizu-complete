<?php
	include('config.php');
	$deletingKanji = $_GET['deletingKanji'];
	$deleteKanji = $mysqli->query("DELETE FROM kanji WHERE `kanji`.`kanji_view` = '$deletingKanji'");
	$deleteCombs = $mysqli->query("DELETE FROM combinations WHERE `combinations`.`combination` LIKE '%$deletingKanji%'");
	$deleteWords = $mysqli->query("DELETE FROM words WHERE `words`.`word_kanji` LIKE '%$deletingKanji%'");
	header('Location: kanji.php');
?>