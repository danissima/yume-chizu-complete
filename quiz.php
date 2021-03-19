<?php
	include('config.php');
	$kanjiSelect = $mysqli->query("SELECT kanji_view FROM kanji");
	$kanjiAmount = $kanjiSelect->{'num_rows'};
	$kanjiArr = [];
	while ($kanjiItem = $kanjiSelect->fetch_array()) {
		array_push($kanjiArr, $kanjiItem[0]);
	}
	$taskKanji = $kanjiArr[rand(0, $kanjiAmount - 1)];
	$quizResults = $mysqli->query("SELECT kanji_search FROM kanji WHERE kanji_view = '$taskKanji'")->fetch_array()[0];	
			
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Квесты</title>
	<link rel="stylesheet" href="styles/header-styles.css">
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="shortcut icon" href="images/logo.png">
	<link rel="stylesheet" href="styles/quiz-styles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="scripts/quizScript.js" defer></script>
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
					<a href="#" class="nav__item">Квесты</a>
				</div>
			</nav>
		</div>
	</div>
</header>
<div class="main">
	<div class="container">
		<div class="main__inner">
			<div class="inner__quiz">
				<div class="inner__subtitle-block">
					<h1 class="inner__subtitle">Проверка знаний!&#9786; <br>Назови чтения и значения данного иероглифа</h1>
				</div>
				<div class="quiz__content">
					<div class="quiz__task quiz__item">
						<div class="task__kanji-block">
							<span class="task__kanji"><?=$taskKanji?></span>
						</div>
						<div class="task__answer-field">
							<div class="answer-field__item-block">
								<p class="answer-field__p" for="answer-field__item1">Оны:</p>
								<input class="answer-field__item" type="text" id="answer-field__item-ons" placeholder="Введите онные чтения">
							</div>
							<div class="answer-field__item-block">
								<p class="answer-field__p" for="answer-field__item2">Куны:</p>
								<input class="answer-field__item" type="text" id="answer-field__item-kuns" placeholder="Введите кунные чтения">
							</div>
							<div class="answer-field__item-block">
								<p class="answer-field__p" for="answer-field__item3">Значения:</p>
								<input class="answer-field__item" type="text" id="answer-field__item-meanings" placeholder="Введите значения">
							</div>
						</div>
					</div>
					<div class="quiz__buttons quiz__item">
						<button class="buttons__item buttons__show-results">Показать ответ</button>
						<button class="buttons__item buttons__check-answers">Проверить</button>
					</div>
					<div class="quiz__results quiz__item">
						<div class="result__item-block results__title-block">
							<h2 class="results__title">Ответ:</h2>
						</div>
						<div class="results__item-block">
							<p class="results__item results__ons"></p>
						</div>
						<div class="results__item-block">
							<p class="results__item results__kuns"></p>
						</div>
						<div class="results__item-block">
							<p class="results__item results__meanings"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	let quizResults = '<?=$quizResults?>';
</script>
</body>
</html>