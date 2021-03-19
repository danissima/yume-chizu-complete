<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Иероглифы</title>
	<link rel="stylesheet" href="styles/header-styles.css">
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="shortcut icon" href="images/logo.png">
	<link rel="stylesheet" href="styles/kanji-styles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="scripts/kanjiScript.js" defer></script>
</head>
<body>
<?php
	include('config.php');
	

	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

	$kol = 5;
	$art = ($page * $kol) - $kol;

	$total = $mysqli->query("SELECT * FROM kanji_keys")->{"num_rows"};
	$str_pag = ceil($total / $kol);

	$radicalsSelect = $mysqli->query("SELECT * from kanji_keys LIMIT $art, $kol");
	
	$radicalsList = [];
	while ($item = $radicalsSelect->fetch_array()) {
		array_push($radicalsList, $item);
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
					<a href="#" class="nav__item">Иероглифы</a>
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
	<div class="main__inner">
		<div class="inner__title-block">
			<div class="container">
				<h1 class="inner__title">Изученные иероглифы</h1>
			</div>
		</div>
		<div class="inner__interactions-block">
			<div class="container">
				<div class="inner__interactions">
					<form action="search.php" class="interactions__search-block">
						<input type="search" name="search" class="interactions__search" placeholder="Найти что-нибудь">
						<input type="image" src="images/search.png" class="interactions__search-image">
					</form>
					<div class="interactions__add-block">
						<a href="add-kanji.php" class="interactions__add">Добавить иероглиф</a>
					</div>
					<div class="interactions__add-block">
						<a href="radicals.php" class="interactions__add">Ключи</a>
					</div>
				</div>
			</div>
		</div>
		<div class="inner__content">
			<div class="content__pages">
				<div class="container">
					<div class="pages__inner">
						<?php
							
							if ($page != 1) $pervpage = "<a class='pages__item pages__item_move' href=kanji.php?page=1><<</a>
	                               <a class='pages__item pages__item_move' href=kanji.php?page=". ($page - 1) ."><</a> ";
							if ($page != $str_pag) $nextpage = " <a class='pages__item pages__item_move' href=kanji.php?page=". ($page + 1) .">></a>
							                                   <a class='pages__item pages__item_move' href=kanji.php?page=" .$str_pag. ">>></a>";

							if($page - 2 > 0) $page2left = " <a class='pages__item pages__item_move' href=kanji.php?page=". ($page - 2) .'>'. ($page - 2) .'</a>';
							if($page - 1 > 0) $page1left = "<a class='pages__item pages__item_move' href=kanji.php?page=". ($page - 1) .'>'. ($page - 1) .'</a>';
							if($page + 2 <= $str_pag) $page2right = "<a class='pages__item pages__item_move' href=kanji.php?page=". ($page + 2) .'>'. ($page + 2) .'</a>';
							if($page + 1 <= $str_pag) $page1right = "<a class='pages__item pages__item_move' href=kanji.php?page=". ($page + 1) .'>'. ($page + 1) .'</a>';

							echo $pervpage.$page2left.$page1left."<b class='pages__selected pages__item'>".$page."</b>".$page1right.$page2right.$nextpage;

						?>
					</div>
				</div>
			</div>
			<form class="content__form" action="kanji-item.php" method="get">
				<?php
					for ($i = 0; $i < count($radicalsList); $i++) {
						$radicalNumber = $radicalsList[$i]['key_number'];
						$radicalView = $radicalsList[$i]['key_view'];
						$radicalName = $radicalsList[$i]['key_name'];

						$selectKanjiOfRadical = $mysqli->query("SELECT kanji_view FROM kanji WHERE key_num = '$radicalNumber'");
						$kanjiOfRadicalList = [];
						while ($item = $selectKanjiOfRadical->fetch_array()) {
							array_push($kanjiOfRadicalList, $item);
						}
						if (count($kanjiOfRadicalList)) {
							print("<div class='content__item'>
											 <div class='container'>
												 <div class='item__radical-block'>	
													 <h2 class='item__radical'>Ключ $radicalNumber:  $radicalView ($radicalName)</h2>
												 </div>
												 <div class='item__kanji-list'>");
							for ($j = 0; $j < count($kanjiOfRadicalList); $j++) {
								$item = $kanjiOfRadicalList[$j]['kanji_view'];
								print("<button class='kanji-list__item' name='kanji' value='$item'>$item</button>");
							}
								print("</div>
										 </div>
									 </div>");
						}
					}

				?>
			</form>
		</div>
	</div>
</div>
</body>
</html>