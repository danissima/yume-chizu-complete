<?php
	include('config.php');

// getting inputs information
	$action = $_GET['manipulate']; // change or add
	$newKanjiView = htmlspecialchars($_GET['newKanjiView']);
	$newKanjiRadical = preg_replace('/\D/', '', htmlspecialchars($_GET['newKanjiRadical']));

	$newKanjiOnsReadings = $_GET['newKanjiOnsReading'];
	$newKanjiKunsReadings = $_GET['newKanjiKunsReading'];
	$newKanjiOnsMeanings = $_GET['newKanjiOnsMeaning'];
	$newKanjiKunsMeanings = $_GET['newKanjiKunsMeaning'];
	
	$prevCombinations = $_GET['prevComb'];
	$selectDelCombs = $mysqli->query("SELECT combination FROM combinations WHERE combination LIKE '%$newKanjiView%'");
	$delCombs = [];
	while ($item = $selectDelCombs->fetch_array()['combination']) {
		array_push($delCombs, $item);
	}

	$combinationsKanji = array_filter($_GET['combinationsKanji']);
	$combinationsKana = array_filter($_GET['combinationsKana']);
	$combinationsTranslation = array_filter($_GET['combinationsTranslation']);

//distributing ons, kuns and combs to arrays
	$newKanjiOns = distribute(array($newKanjiOnsReadings, $newKanjiOnsMeanings)); 
	$newKanjiKuns = distribute(array($newKanjiKunsReadings, $newKanjiKunsMeanings));
	if ($combinationsKanji[0]) {
		$combinations = distribute(array($combinationsKanji, $combinationsKana, $combinationsTranslation));
	}

//creating a search tags
	$newKanjiSearch = array();
	
	array_push($newKanjiSearch, $newKanjiView);
	array_push($newKanjiSearch, readingsToSearch($newKanjiOns));
	array_push($newKanjiSearch, readingsToSearch($newKanjiKuns));
	$newKanjiSearch = implode(', ', $newKanjiSearch);

	function readingsToSearch($readings) {
		$readings = preg_replace('/\d\)\s?/', '', $readings);
		$readings = preg_split('/;\s/', $readings);
		foreach($readings as &$item) {
			$item = preg_replace('/ - /', ', ', $item);
		}
		return implode(', ', $readings);
	}
	function distribute($items) {
		$arrResult = array();
		for($i = 0; $i < count($items[0]); $i++) {
			if (count($items) == 2) {
				$reading = $items[0];
				$meaning = $items[1];
				if (!$meaning[$i]) {
					array_push($arrResult, "$reading[$i]");
				} else {
					array_push($arrResult, "$reading[$i] - $meaning[$i]");
				}
			} else {
				$kanji = $items[0];
				$kana = $items[1];
				$translation = $items[2];
				array_push($arrResult, array($kanji[$i], $kana[$i], $translation[$i]));
			}
		}
		if (count($items) == 2) { return implode('; ', $arrResult); } 
		else { return $arrResult; }
	}

//adding kanji
	if ($action == 'add') { 
		$addKanji = $mysqli->query("INSERT INTO kanji (`ID`, `kanji_view`, `key_num`, `kanji_ons_kana`, `kanji_kuns_kana`, `kanji_search`) VALUES (NULL, '$newKanjiView', '$newKanjiRadical', '$newKanjiOns', '$newKanjiKuns', '$newKanjiSearch')");
		
		//adding to combs tables
		if ($combinationsKanji[0]) {
			for($i = 0; $i < count($combinationsKanji); $i++) {
				$addCombs = $mysqli->query("INSERT INTO combinations (`ID`, `combination`, `kana`, `translation`) VALUES (NULL, '$combinationsKanji[$i]', '$combinationsKana[$i]', '$combinationsTranslation[$i]')");
				
				preg_match_all('/./u', $combinationsKanji[$i], $itemsArr);
				foreach($itemsArr[0] as &$kanji) {
					$combID = $mysqli->query("SELECT ID FROM combinations WHERE combination = '$combinationsKanji[$i]'")->fetch_array()['ID'];
					$kanjiID = $mysqli->query("SELECT ID FROM kanji WHERE kanji_view = '$kanji'")->fetch_array()['ID'];
					$mysqli->query("INSERT INTO kanji_combinations (`combination`, `kanji`) VALUES ('$combID', '$kanjiID')");
				}
			}
		}
		// adding new kuns to words
		if ($newKanjiKunsReadings[0]) {
			for($i = 0; $i < count($newKanjiKunsReadings); $i++) {
				
				$addWordsFromKuns = $mysqli->query("INSERT INTO words (`word_kanji`, `kana`, `translation`) VALUES ('$newKanjiView', '$newKanjiKunsReadings[$i]', '$newKanjiKunsMeanings[$i]')");
			}
		}
	} else if ($action == 'change') {
		//changing kanji
		$prevKanji = $_GET['prevKanji'];
		$kanjiID = $mysqli->query("SELECT ID FROM kanji WHERE `kanji`.`kanji_view` = '$prevKanji'")->fetch_array()['ID'];
		$changeKanji = $mysqli->query("UPDATE kanji SET `kanji_view` = '$newKanjiView', `key_num` = '$newKanjiRadical', `kanji_ons_kana` = '$newKanjiOns', `kanji_kuns_kana` = '$newKanjiKuns', `kanji_search` = '$newKanjiSearch' WHERE `kanji`.`ID` = '$kanjiID'");
		
		//updating combs tables
		if ($combinationsKanji[0]) {
			foreach($delCombs as &$item) {
				if (!in_array($item, $prevCombinations)) {
					$mysqli->query("DELETE FROM combinations WHERE combination = '$item'");
				}
			}
			
			for($i = 0; $i < count($combinationsKanji); $i++) {
				$combExists = $mysqli->query("SELECT combination FROM combinations WHERE combination = '$prevCombinations[$i]'")->{'num_rows'};
				if ($combExists) {
					$combID = $mysqli->query("SELECT ID FROM combinations WHERE combination = '$prevCombinations[$i]'")->fetch_array()['ID'];
					$updateCombs = $mysqli->query("UPDATE combinations SET `combination` = '$combinationsKanji[$i]', `kana` = '$combinationsKana[$i]', `translation` = '$combinationsTranslation[$i]' WHERE `combinations`.`ID` = '$combID'");
				} else {
					$addCombs = $mysqli->query("INSERT INTO combinations (`ID`, `combination`, `kana`, `translation`) VALUES (NULL, '$combinationsKanji[$i]', '$combinationsKana[$i]', '$combinationsTranslation[$i]')");
					preg_match_all('/./u', $combinationsKanji[$i], $itemsArr);
					foreach($itemsArr[0] as &$kanji) {
						$combID = $mysqli->query("SELECT ID FROM combinations WHERE combination = '$combinationsKanji[$i]'")->fetch_array()['ID'];
						$kanjiID = $mysqli->query("SELECT ID FROM kanji WHERE kanji_view = '$kanji'")->fetch_array()['ID'];
						$addKanComb = $mysqli->query("INSERT INTO kanji_combinations (`combination`, `kanji`) VALUES ('$combID', '$kanjiID')");
					}
				}
			}
		}
		//updating words
		if ($newKanjiKunsReadings[0]) {
			for($i = 0; $i < count($newKanjiKunsReadings); $i++) {
				$kunInWords = $mysqli->query("SELECT * FROM words WHERE word_kanji LIKE '%$newKanjiView%' AND kana LIKE '%$newKanjiKunsReadings[$i]%' AND translation LIKE '%$newKanjiKunsMeanings[$i]%'")->fetch_array();
				if (!$kunInWords) {
					$addWordsFromKuns = $mysqli->query("INSERT INTO words (`word_kanji`, `kana`, `translation`) VALUES ('$newKanjiView', '$newKanjiKunsReadings[$i]', '$newKanjiKunsMeanings[$i]')");
				}
			}
		}
	}
	
	header('Location: kanji.php');
?>