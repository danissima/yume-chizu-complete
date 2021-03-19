<?php 
	include('config.php');
	$kanjiSelect = $mysqli->query("SELECT kanji_view FROM kanji");
	$wordsSelect = $mysqli->query("SELECT word_kanji FROM words");
	$combsSelect = $mysqli->query("SELECT combination FROM combinations");
	
	$kanjiAmount = $kanjiSelect->{'num_rows'};
	$wordsAmount = $wordsSelect->{'num_rows'} + $combsSelect->{'num_rows'};

	function howMany($word, $amount) {
		if (substr($amount, -1) >= 5 || substr($amount, -2, 1) == 1 && $amount != 1 || substr($amount, -1) == 0) {
			if (mb_substr($word, -1) == 'в') {
				return $amount . ' ' . $word;
			} else {
				return $amount . ' ' . $word . 'ов';
			}
		} else if (substr($amount, -1) >= 2 && substr($amount, -1) <= 4) {
			return $amount . ' ' . $word . 'а';
		} else {
			if (mb_substr($word, -1) == 'в') {
				return $amount . ' ' . $word . 'о';
			} else {
				return $amount . ' ' . $word;
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Yume Chizu</title>
	<link rel="stylesheet" href="styles/header-styles.css">
	<link rel="stylesheet" href="styles/home-styles.css">
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="shortcut icon" href="images/logo.png">
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
				<div class="nav__item-block">
					<a href="#" class="nav__item">Главная</a>
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
	<div class="container main__container">
		<div class="main__inner">
			<div class="main__title-block">
				<h1 class="main__title">Упрости своё изучение японского</h1>
			</div>
			<div class="main__subtitle-block">
				<h2 class="main__subtitle">На сегодняшний день изучено <?=$kanjiAmount?> иероглифов и <?=$wordsAmount?> слов</h2>
			</div>
			
		</div>
	</div>
</div>
</body>
</html>