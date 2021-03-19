<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ключи</title>
	<link rel="stylesheet" href="styles/header-styles.css">
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="shortcut icon" href="images/logo.png">
	<link rel="stylesheet" href="styles/radical-styles.css">
	<script type="module" src="scripts/radicalScript.js" defer></script>
</head>
<body>
<?php 
	include('config.php');

	$selectRadicals = $mysqli->query("SELECT * FROM kanji_keys ORDER BY key_number");
	$radicals = [];
	while($item = $selectRadicals->fetch_array()) {
		array_push($radicals, $item);
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
				<div class="nav__item-block">
					<a href="index.php" class="nav__item">Главная</a>
				</div>
				<div class="nav__item-block">
					<a href="kanji.php" class="nav__item">Иероглифы</a>
				</div>
				<div class="nav__item-block">
					<a href="words.php" class="nav__item">Слова</a>
				</div>
				<div class="nav__item-block">
					<a href="quiz.php" class="nav__item">Квесты</a>
				</div>
			</nav>
		</div>
	</div>
</header>
<div class="main">
	<div class="container">
		<div class="main__inner">
			<div class="inner__title-block">
				<h1 class="inner__title">Ключи</h1>
			</div>
			<div class="inner__interactions-block">
				<div class="inner__interactions">
					<form action="search.php" class="interactions__search-block">
						<input type="search" name="search" class="interactions__search" placeholder="Найти что-нибудь">
						<input type="image" src="images/search.png" class="interactions__search-image">
					</form>
				</div>
			</div>
			<div class="inner__content">
				<div class="content__form-block">
					<form action="add-radicals.php" class="content__form" method="get">
						<div class="form__item-block">
							<div class="form__item-title-block">
								<h3 class="form__item-title">Новый ключ: </h3>
								<button type="button" class="radical__add button__add form__button">&#43;</button>
							</div>
							<div class="item__table-block">
								<table cellspacing='3' border='0' class="form__table">
									<thead>
										<tr class="table__row table__head-row">
											<th class="table__cell table__head-cell">Ключ</th>
											<th class="table__cell table__head-cell">Номер</th>
											<th class="table__cell table__head-cell">Название</th>
										</tr>
									</thead>
									<tbody class="radicals__table">
										<tr class="table__row">
											<td class="table__cell"><input placeholder="Введи ключ" name="radicalView[]" type="text" class="form__item form__item_no-margin"></td>
											<td class="table__cell"><input placeholder="Введи номер" name="radicalNumber[]" type="text" class="form__item form__item_no-margin"></td>
											<td class="table__cell"><input placeholder="Введи название" name="radicalName[]" type="text" class="form__item form__item_no-margin"></td>
											<td class='table__cell'><button type='button' class='radical__remove manipulate__button'>&times;</button></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="form__submit">
							<input type="submit" value="Добавить ключ" class="form__button form__button-submit">
							<input type="hidden" value="add" name="action">
						</div>
					</form>
				</div>
				<div class="content__item">
					<div class="item__table-block">
						<table cellspacing='3' border='1' bordercolor="black" frame="void" class="form__table">
							<thead>
								<tr class="table__row table__head-row">
									<th class="table__cell table__head-cell">Ключ</th>
									<th class="table__cell table__head-cell">Номер</th>
									<th class="table__cell table__head-cell">Название</th>
									<th class="table__cell table__head-cell">&#129303;</th> 
								</tr>
							</thead>
							<tbody class="radicals__table">
								<?php 
									foreach ($radicals as $item) {
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
</body>
</html>
