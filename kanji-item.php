<?php
	include('config.php');
	
	$kanjiView = htmlspecialchars($_GET['kanji']);
	
	$selectRadical = $mysqli->query("SELECT kanji_keys.* FROM kanji_keys LEFT JOIN kanji ON kanji.key_num = kanji_keys.key_number WHERE kanji.kanji_view = '$kanjiView'")->fetch_array();
	
	$radicalNumber = $selectRadical['key_number'];
	$radicalView = $selectRadical['key_view'];
	$radicalName = $selectRadical['key_name'];
	
	$selectKanjiItem = $mysqli->query("SELECT * FROM kanji WHERE kanji_view = '$kanjiView'")->fetch_array();
	
	$kanjiOns = preg_split("/;\s/", $selectKanjiItem['kanji_ons_kana']);
	$kanjiKuns = preg_split("/;\s/", $selectKanjiItem['kanji_kuns_kana']);

	$kanjiID = $mysqli->query("SELECT ID FROM kanji WHERE kanji_view = '$kanjiView'")->fetch_array()['ID'];
	$kanjiCombsSelect = $mysqli->query("SELECT `combinations`.* FROM `kanji_combinations` LEFT JOIN `combinations` ON `kanji_combinations`.`combination` = `combinations`.`ID` WHERE (`kanji_combinations`.`kanji` ='$kanjiID')");
	$kanjiCombinations = [];
	while($item = $kanjiCombsSelect->fetch_array()) {
		array_push($kanjiCombinations, $item);
	}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Карточка иероглифа <?=$kanjiView?></title>
	<link rel="stylesheet" href="styles/header-styles.css">
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="shortcut icon" href="images/logo.png">
	<link rel="stylesheet" href="styles/kanji-item-styles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
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
			<div class="inner__header">
				<div class="inner__title-block">
					<h1 class="inner__title">Карточка иероглифа <?=$kanjiView?></h1>
				</div>
				<form action="deleted.php" method="get" class="inner__form">
					<input type="hidden" name="manipulate" value="delete">
					<input type="hidden" name="deletingKanji" value="<?=$kanjiView?>">
					<input type="submit" class="inner__button" value="Удалить">
				</form>
				<form action="change-kanji.php" class="inner__form" method="get" >
					<input type="hidden" name="changingKanji" value="<?=$kanjiView?>">
					<input type='submit' class="inner__button" value="Изменить">
				</form>
			</div>
			<div class="inner__content">
				<div class="content__info">
					<div class="info__view">
						<div class="view__kanji-block">
							<span class="view__kanji"><?=$kanjiView?></span>
						</div>
						<div class="view__radical-block">
							<span class="view__radical">Ключ <?=$radicalNumber?><br><?=$radicalView?> (<?=$radicalName?>)</span>
						</div>
					</div>
					<div class="info__readings info__ons">
						<h3 class="readings__title">Онные чтения:</h3>
						<ul class="readings__list ons__list">
							<?php
								if ($kanjiOns[0]) {
									for($i = 0; $i < count($kanjiOns); $i++) {
										print("<li class='list__item ons__item'>$kanjiOns[$i]</li>");
									}
								}
							?>
						</ul>
					</div>
					<div class="info__readings info__kuns">
						<h3 class="readings__title">Кунные чтения:</h3>
						<ul class="readings__list kuns__list">
							<?php
								if ($kanjiKuns[0]) {
									for($i = 0; $i < count($kanjiKuns); $i++) {
										print("<li class='list__item kuns__item'>$kanjiKuns[$i]</li>");
									}
								}
							?>
						</ul>
					</div>
				</div>
				<div class="content__combinations">
					<div class="combinations__title-block">
						<h2 class="combinations__title">Сочетания</h2>
					</div>
					<div class="combinations__table-block">
					<?php
						if (!$kanjiCombinations[0]) {
							print("<p>Сочетаний пока нет. Но это только пока &#128533;</p>
										 <img class='combinations-null' src='images/tomas1.png' alt='anime-girl'>
							");
						} else {
							print("<table cellspacing='3' bordercolor='black' frame='void' border='1' class='combinations__table'>
											 <tr class='table__row table__head-row'>
											   <th class='table__head-cell table__cell'>Иероглифы</th>
											   <th class='table__head-cell table__cell'>Азбука</th>
											   <th class='table__head-cell table__cell'>Перевод</th>
											 </tr>");
						}
						
						foreach($kanjiCombinations as &$item) {
							$combination = $item['combination'];
							$kana = $item['kana'];
							$translation = $item['translation'];
							print("<tr class='table__row'>
										   <td class='table__cell'>$combination</td>
											 <td class='table__cell'>$kana</td>
											 <td class='table__cell'>$translation</td>
										 </tr>");
						}
						
						print("</table>");
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>

