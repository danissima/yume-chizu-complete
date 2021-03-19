<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="styles/header-styles.css">
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="shortcut icon" href="images/logo.png">
	<link rel="stylesheet" href="styles/add-kanji-styles.css">
	<script type="module" src="scripts/add-kanji-script.js" defer></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Изменение иероглифа</title>
</head>
<body>
<?php
	include('config.php');
	$changingKanji = htmlspecialchars($_GET['changingKanji']);
	$selectInfo = $mysqli->query("SELECT * FROM kanji WHERE kanji_view = '$changingKanji'")->fetch_array();
	$kanjiRadical = $selectInfo['key_num'];
	$kanjiOns = explode('; ', $selectInfo['kanji_ons_kana']);
	$kanjiKuns = explode('; ', $selectInfo['kanji_kuns_kana']);
	
	$kanjiCombinations = [];
	$kanjiID = $mysqli->query("SELECT ID FROM kanji WHERE kanji_view = '$changingKanji'")->fetch_array()['ID'];
	$kanjiCombsSelect = $mysqli->query("SELECT `combinations`.* FROM `kanji_combinations` LEFT JOIN `combinations` ON `kanji_combinations`.`combination` = `combinations`.`ID` WHERE (`kanji_combinations`.`kanji` = '$kanjiID')");
	while($item = $kanjiCombsSelect->fetch_array()) {
		array_push($kanjiCombinations, $item);
	}
	
	$selectRadicals = $mysqli->query("SELECT * FROM kanji_keys");
	$arrRadicals = [];
	
	while($item = $selectRadicals->fetch_array()) {
		array_push($arrRadicals, $item);
	}
?>
<header class="header">
	<div class="container header__container">
		<div class="header__inner">
			<div class="header__logo">
				<div class="logo__image-block">
					<img src="images/logo.png" alt="Kanagawa wave" class="logo__image">
				</div>
				<div class="logo__title-block">
					<span class="logo__title">Yume<br>Chizu</span>
				</div>
			</div>
			<nav class="header__nav">
				<a href="index.php" class="nav__item">Главная</a>
				<a href="kanji.php" class="nav__item">Иероглифы</a>
				<a href="words.php" class="nav__item">Слова</a>
				<a href="quiz.php" class="nav__item">Квесты</a>
			</nav>
		</div>
	</div>
</header>
<div class="main">
	<div class="container main__container">
		<div class="main__inner">
			<div class="inner__title-block">
				<h1 class="inner__title">Изменение иероглифа <?=$changingKanji?></h1>
			</div>
			<div class="inner__content">
				<form action="manipulate.php" method="get" class="content__form">
					<div class="form__item-block form__item-block_row">
						<span for="kanji-view" class="form__item-title">Новый иероглиф: </span>
						<input required name="newKanjiView" placeholder="Введи иероглиф" type="text" class="form__item form__item_small" id="kanji-view" value="<?=$changingKanji?>">
						<input type="hidden" name="prevKanji" value="<?=$changingKanji?>">
					</div>
					<div class="form__item-block form__item-block_row">
						<span class="form__item-title">Ключ иероглифа: </span>
						<select id="kanji-radical" name="newKanjiRadical" class="form__item form__select form__item_small">
							<?php
								for($i = 0; $i < count($arrRadicals); $i++) {
									$radicalNum = $arrRadicals[$i]['key_number'];
									$radicalView = $arrRadicals[$i]['key_view'];
									$radicalName = $arrRadicals[$i]['key_name'];
									if ($radicalNum == $kanjiRadical) {
										print("<option selected>$radicalName $radicalNum - $radicalView</option>");
									} else {
										print("<option>$radicalName $radicalNum - $radicalView</option>");
									}
								}
							?>
						</select>
					</div>
					<div class="form__item-block">
						<div class="form__item-title-block">
							<h3 class="form__item-title">Онные чтения: </h3>
							<button form="" class="ons__add button__add form__button">&#43;</button>
						</div>
						<div class="item__table-block">
							<table cellspacing='4' border='0' class="form__table">
								<thead>
									<tr class="table__row table__head-row">
										<th class="table__cell table__head-cell">Чтение</th>
										<th class="table__cell table__head-cell">Значение</th>
									</tr>
								</thead>
								<tbody class="ons__table">
								<?php
									foreach($kanjiOns as &$item) {
										$item = explode(' - ', $item);
										print("<tr class='table__row'>
													   <td class='table__cell'><textarea placeholder='Введи он' name='newKanjiOnsReading[]' class='form__textarea form__item form__item_no-margin'>$item[0]</textarea></td>
														 <td class='table__cell'><textarea placeholder='Введи значение' name='newKanjiOnsMeaning[]' class='form__textarea form__item form__item_no-margin'>$item[1]</textarea></td>
														 <td class='table__cell'><button type='button' class='on__remove manipulate__button'>&times;</button></td>

												   </tr>");
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="form__item-block">
						<div class="form__item-title-block">
							<h3 class="form__item-title">Kунные чтения: </h3>
							<button form="" class="kuns__add button__add form__button">&#43;</button>
						</div>
						<div class="item__table-block">
							<table cellspacing='4' border='0' class="form__table">
								<thead>
									<tr class="table__row table__head-row">
										<th class="table__cell table__head-cell">Чтение</th>
										<th class="table__cell table__head-cell">Значение</th>
									</tr>
								</thead>
								<tbody class="kuns__table">
								<?php
									foreach($kanjiKuns as &$item) {
										$item = explode(' - ', $item);
										print("<tr class='table__row'>
													  <td class='table__cell'><textarea placeholder='Введи кун' name='newKanjiKunsReading[]' class='form__textarea form__item form__item_no-margin'>$item[0]</textarea></td>
														<td class='table__cell'><textarea placeholder='Введи значение' name='newKanjiKunsMeaning[]' class='form__textarea form__item form__item_no-margin'>$item[1]</textarea></td>
														<td class='table__cell'><button type='button' class='kun__remove manipulate__button'>&times;</button></td>
													 </tr>");
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="form__item-block form__combinations-block">
						<div class="form__item-title-block">
							<span for="kanji-combinations" class="form__item-title">Сочетания иероглифа: </span>
							<button form="" class="combinations__add button__add form__button">&#43;</button>
						</div>
						<div class="item__table-block">
							<table cellspacing='4' border='0' class="form__table">
								<thead>
									<tr class="table__row table__head-row">
										<th class="table__cell table__head-cell">Иероглифы</th>
										<th class="table__cell table__head-cell">Азбука</th>
										<th class="table__cell table__head-cell">Перевод</th>
									</tr>
								</thead>
								<tbody class="combinations__table">
								<?php
									if ($kanjiCombinations[0]) {
										foreach($kanjiCombinations as &$item) {
											$combination = $item['combination'];
											$kana = $item['kana'];
											$translation = $item['translation'];
											print("<tr class='table__row'>
															 <td class='table__cell'><input value='$combination' placeholder='Введи сочетание' type='text' class='form__item form__item_no-margin' name='combinationsKanji[]'><input type='hidden' name='prevComb[]' value='$combination'></td>
															 <td class='table__cell'><input value='$kana' placeholder='Введи написание азбукой' type='text' class='form__item form__item_no-margin' name='combinationsKana[]'></td>
															 <td class='table__cell'><input value='$translation' placeholder='Введи перевод' type='text' class='form__item form__item_no-margin' name='combinationsTranslation[]'></td>
															 <td class='table__cell'><button type='button' class='combination__remove manipulate__button'>&times;</button></td>

														 </tr>");
										}
									} else {
											print("<tr class='table__row'>
															 <td class='table__cell'><input placeholder='Введи сочетание' type='text' class='form__item form__item_no-margin' name='combinationsKanji[]'></td>
															 <td class='table__cell'><input placeholder='Введи написание азбукой' type='text' class='form__item form__item_no-margin' name='combinationsKana[]'></td>
															 <td class='table__cell'><input placeholder='Введи перевод' type='text' class='form__item form__item_no-margin' name='combinationsTranslation[]'></td>
															 <td class='table__cell'><button type='button' class='combination__remove manipulate__button'>&times;</button></td>

														 </tr>");
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="form__submit">
						<input type="hidden" value="change" name="manipulate">
						<input type="submit" value="Изменить иероглиф" class="form__button form__button-submit">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>