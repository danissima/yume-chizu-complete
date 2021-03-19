<?php
include('config.php');

$find = $_GET['search'];
$selectSearchedKanji = $mysqli->query("SELECT * FROM kanji WHERE kanji_search LIKE '%$find%'");
$selectKanjiIfRadical = $mysqli->query("SELECT `kanji`.* FROM `kanji_keys` LEFT JOIN `kanji` ON `kanji`.`key_num` = `kanji_keys`.`key_number` WHERE (`kanji_keys`.`key_view` = '$find' OR `kanji_keys`.`key_number` = '$find' OR `kanji_keys`.`key_name` = '$find')");
$selectSearchedRadicals = $mysqli->query("SELECT * FROM kanji_keys WHERE key_view LIKE '%$find%' OR key_number LIKE '%$find%' OR key_name LIKE '%$find%'");
$selectSearchedWords = $mysqli->query("SELECT * FROM words WHERE word_kanji LIKE '%$find%' OR kana LIKE '%$find%' OR translation LIKE '%$find%'");
$selectSearchedCombs = $mysqli->query("SELECT * FROM combinations WHERE combination LIKE '%$find%' OR kana LIKE '%$find%' OR translation LIKE '%$find%'");

$searchedKanji = queryResultToArr($selectSearchedKanji);
$searchedKanjiIfRadical = queryResultToArr($selectKanjiIfRadical);
if ($searchedKanjiIfRadical) {
	$searchedKanji = $searchedKanjiIfRadical;
}
$searchedRadicals = queryResultToArr($selectSearchedRadicals); 
$searchedWords = queryResultToArr($selectSearchedWords);
$searchedCombs = queryResultToArr($selectSearchedCombs);


function queryResultToArr($queryResult) {
	$result = [];
	while ($item = $queryResult->fetch_array()) {
		array_push($result, $item);
	}
	return $result;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles/header-styles.css">
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="stylesheet" href="styles/search-styles.css">
	<link rel="shortcut icon" href="images/logo.png">
	<link rel="stylesheet" href="styles/kanji-styles.css">
	<link rel="stylesheet" href="styles/words-styles.css">
	<script type="module" src="scripts/radicalScript.js" defer></script>
	<script type="module" src="scripts/wordsScript.js"></script>
	<title>Результаты поиска <?=$find?></title>
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
	<div class="main__inner">
		<div class="inner__title-block">
			<div class="container">
				<h1 class="inner__title">Результаты поиска <?=$find?></h1>
			</div>
		</div>
		<div class="inner__content">
			<?php
			if ($searchedKanji) {
			?>
			<div class="content__kanji content__block">
		 		<div class='container'>
					<div class="kanji__subtitle-block inner__subtitle-block">
						<h2 class="kanji__subtitle inner__subtitle">Найденные иероглифы</h2>
					</div>
					<form class="content__form" action="kanji-item.php" method="get">
						<?php
							print("<div class='content__item'>
													 <div class='item__kanji-list'>");
							foreach ($searchedKanji as &$item) {
								$kanjiItem = $item['kanji_view'];
								print("<button class='kanji-list__item' name='kanji' value='$kanjiItem'>$kanjiItem</button>");
								
							}
							print("</div>
										 </div>");

						?>
					</form>
				</div>
			</div>
			<?php } ?>
			<?php
			if ($searchedWords || $searchedCombs) {
			?>
			<div class="content__words content__block">
				<div class="container">
					<div class="kanji__subtitle-block inner__subtitle-block">
						<h2 class="kanji__subtitle-block inner__subtitle">Найденные слова</h2>
					</div>
					<div class="content__table-block">
						<table class="content__table" cellspacing='3' bordercolor='black' frame='void' border='1'>
							<thead>
								<tr class="table__row table__head-row">
									<th class='table__cell table__head-cell'>Иероглифы</th>
									<th class='table__cell table__head-cell'>Азбука</th>
									<th class='table__cell table__head-cell'>Перевод</th>
									<th class='table__cell table__head-cell'>&#128511;</th>		
								</tr>	
							</thead>
							<tbody class="words__table">
							<?php
								foreach ($searchedWords as $word) {
									$wordId = $word['ID'];
									$wordKanji = $word['word_kanji'];
									$wordKana = $word['kana'];
									$wordTranslation = $word['translation'];
									print("<tr class='table__row'>
												 <input type='hidden' value='$wordId' class='word-id'>
												 <td class='table__cell'>$wordKanji</td>
												 <td class='table__cell'>$wordKana</td>
												 <td class='table__cell'>$wordTranslation</td>
												 <td class='table__cell table__manipulate'><button class='word__change manipulate__button'><span class='manipulate__pen'>&#9999;</span></button></td>
												 <input type='hidden' value='words' class='word-from'>
											 </tr>");
								}
								foreach ($searchedCombs as $comb) {
									$combId = $comb['ID'];
									$combKanji = $comb['combination'];
									$combKana = $comb['kana'];
									$combTranslation = $comb['translation'];
									print("<tr class='table__row'>
												 <input type='hidden' value='$combId' class='word-id'>
												 <td class='table__cell'>$combKanji</td>
												 <td class='table__cell'>$combKana</td>
												 <td class='table__cell'>$combTranslation</td>
												 <td class='table__cell table__manipulate'><button class='word__change manipulate__button'><span class='manipulate__pen'>&#9999;</span></button></td>
												 <input type='hidden' value='combs' class='word-from'>
											 </tr>");
								}


							?>
							</tbody>		
						</table>
					</div>
				</div>
			</div>
			<div class="modal modalWords">
				<div class="container">
					<div class="modal__inner">
						<div class="modal__content">
							<div class="modal__title-block">
								<h1 class="modal__title">Изменить слово</h1>
								<div class="modal__close-block">
									<button class="words-modal__close modal__close form__button">&times;</button>
								</div>
							</div>
							<form action="add-words.php" method="get" class="modal__form">
								<div class="form__table-block">
									<table class="modal__table">
										<thead>
											<tr class="table__row table__head-row">
												<th class="table__cell table__head-cell">Иероглифы</th>
												<th class="table__cell table__head-cell">Азбука</th>
												<th class="table__cell table__head-cell">Перевод</th>
											</tr>
										</thead>
										<tbody class="modal__body">
											<tr class="table__row">
												<td class="table__cell"><input placeholder="Введи слово" class="form__item form__item_no-margin modal__word" type="text" name="wordKanji"></td>
												<td class="table__cell"><input placeholder="Введи написание азбукой" class="form__item form__item_no-margin modal__kana" type="text" name="wordKana"></td>
												<td class="table__cell"><input placeholder="Введи перевод" class="form__item form__item_no-margin modal__translation" type="text" name="wordTranslation"></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="modal__submit">
									<input type="submit" value="Изменить слово" class="form__button form__button-submit">
									<input type="hidden" value="change" name="action">
									<input type="hidden" value="" name="changing" class="changingWord">
									<input type="hidden" value="" name="from" class="from">
								</div>
							</form>
							<form action="add-words.php" method="get" class="modal__form modal__delete">
								<div class="modal__submit">
									<input type="submit" value="Удалить слово" class="form__button form__button-submit">
									<input type="hidden" value="delete" name="action">
									<input type="hidden" value="" name="deleting" class="deletingWord">
									<input type="hidden" value="" name="from" class="from">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<?php
			if ($searchedRadicals) {
			?>
			<div class="content__radicals content__block">
				<div class="container">
					<div class="radicals__subtitle-block inner__subtitle-block">
						<h2 class="radicals__subtitle-block inner__subtitle">Найденные ключи</h2>
					</div>
					<div class="content__table-block">
						<table class="content__table" cellspacing='3' bordercolor='black' frame='void' border='1'>
							<thead>
								<tr class="table__row table__head-row">
									<th class='table__cell table__head-cell'>Ключ</th>
									<th class='table__cell table__head-cell'>Номер</th>
									<th class='table__cell table__head-cell'>Название</th>
									<th class='table__cell table__head-cell'>&#128563;</th>		
								</tr>	
							</thead>
							<tbody class="radicals__table">
							<?php
								foreach ($searchedRadicals as $item) {
									$radicalID = $item['ID'];
									$radicalView = $item['key_view'];
									$radicalNumber = $item['key_number'];
									$radicalName = $item['key_name'];
									print("<tr class='table__row'>
											  <input type='hidden' value='$radicalID' class='radical-id'>
										   	  <td class='table__cell radicals-table__cell'>$radicalView</td>
											  <td class='table__cell radicals-table__cell'>$radicalNumber</td>
											  <td class='table__cell radicals-table__cell'>$radicalName</td>
											  <td class='table__cell radicals-table__cell table__manipulate'><button class='radical__change manipulate__button'><span class='manipulate__pen'>&#9999;</span></button></td>
										   </tr>");
								}
						?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal modalRadicals">
				<div class="container">
					<div class="modal__inner">
						<div class="modal__content">
							<div class="modal__title-block">
								<h1 class="modal__title">Изменить ключ</h1>
								<div class="modal__close-block">
									<button class="radical-modal__close modal__close form__button">&times;</button>
								</div>
							</div>
							<form action="add-radicals.php" method="get" class="modal__form">
								<div class="form__table-block">
									<table class="modal__table">
										<thead>
											<tr class="table__row table__head-row">
												<th class="table__cell table__head-cell">Ключ</th>
												<th class="table__cell table__head-cell">Номер</th>
												<th class="table__cell table__head-cell">Название</th>
											</tr>
										</thead>
										<tbody class="modal__body">
											<tr class="table__row">
												<td class="table__cell"><input placeholder="Введи ключ" class="form__item form__item_no-margin modal__radical" type="text" name="radicalView"></td>
												<td class="table__cell"><input placeholder="Введи номер" class="form__item form__item_no-margin modal__number" type="text" name="radicalNumber"></td>
												<td class="table__cell"><input placeholder="Введи название" class="form__item form__item_no-margin modal__name" type="text" name="radicalName"></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="modal__submit">
									<input type="submit" value="Изменить ключ" class="form__button form__button-submit">
									<input type="hidden" value="change" name="action">
									<input type="hidden" value="" name="changing" class="changingRadical">
								</div>
							</form>
							<form action="add-radicals.php" method="get" class="modal__form modal__delete">
								<div class="modal__submit">
									<input type="submit" value="Удалить ключ" class="form__button form__button-submit">
									<input type="hidden" value="delete" name="action">
									<input type="hidden" value="" name="deleting" class="deletingRadical">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
</body>
</html>
