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
	<title>Добавление иероглифа</title>
</head>
<body>
<?php
	include('config.php');
	
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
				<h1 class="inner__title">Добавление нового иероглифа</h1>
			</div>
			<div class="inner__content">
				<form action="manipulate.php" method="get" class="content__form">
					<div class="form__item-block form__item-block_row">
						<h3 class="form__item-title">Новый иероглиф: </h3>
						<input required name="newKanjiView" placeholder="Введи иероглиф" type="text" class="form__item form__item_small" id="kanji-view">
					</div>
					<div class="form__item-block form__item-block_row">
						<h3 class="form__item-title">Ключ иероглифа: </h3>
						<select id="kanji-radical" name="newKanjiRadical" class="form__item form__select form__item_small">
							<?php
								for($i = 0; $i < count($arrRadicals); $i++) {
									$radicalNum = $arrRadicals[$i]['key_number'];
									$radicalView = $arrRadicals[$i]['key_view'];
									$radicalName = $arrRadicals[$i]['key_name'];
									print("<option>$radicalName $radicalNum - $radicalView</option>");
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
									<tr class="table__row">
										<td class="table__cell"><textarea placeholder="Введи он" name="newKanjiOnsReading[]" class="form__textarea form__item form__item_no-margin"></textarea></td>
										<td class="table__cell"><textarea placeholder="Введи значение" name="newKanjiOnsMeaning[]" class="form__textarea form__item form__item_no-margin"></textarea></td>
										<td class='table__cell'><button type='button' class='on__remove manipulate__button'>&times;</button></td>
									</tr>
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
									<tr class="table__row">
										<td class="table__cell"><textarea placeholder="Введи кун" name="newKanjiKunsReading[]" class="form__textarea form__item form__item_no-margin"></textarea></td>
										<td class="table__cell"><textarea placeholder="Введи значение" name="newKanjiKunsMeaning[]" class="form__textarea form__item form__item_no-margin"></textarea></td>
										<td class='table__cell'><button type='button' class='kun__remove manipulate__button'>&times;</button></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="form__item-block form__combinations-block">
						<div class="form__item-title-block">
							<h3 class="form__item-title">Сочетания иероглифа: </h3>
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
									<tr class="table__row">
										<td class="table__cell"><input placeholder="Введи сочетание" type="text" class="form__item form__item_no-margin" name="combinationsKanji[]"></td>
										<td class="table__cell"><input placeholder="Введи написание азбукой" type="text" class="form__item form__item_no-margin" name="combinationsKana[]"></td>
										<td class="table__cell"><input placeholder="Введи перевод" type="text" class="form__item form__item_no-margin" name="combinationsTranslation[]"></td>
										<td class='table__cell'><button type='button' class='combination__remove manipulate__button'>&times;</button></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="form__submit">
						<input type="hidden" name="manipulate" value="add">
						<input type="submit" value="Добавить иероглиф" class="form__button form__button-submit">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>