<?php
session_start();
header('Content-type: text/html; charset=utf-8');
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>О нас блогерам</title>
	<link rel="stylesheet" href="../css/style2.css" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet"></head>
<body>
	<header>
		<!--<div class="header_logo">
			<a href="home.php"><img src="../image/logoName1.png" alt="Главная"></a>
		</div>-->
		<a href="../index.php"><div class="header_logo"><p>Nothcity</p></div></a>
		<nav>
			<div class="topnav" id="myTopnav">
				<a href="populare.php">Популярное</a>
				<a href="blogers.php">Блогеры</a>
				<a href="lifehack.php">Полезные статьи</a>
				<?php
				if (isset($_SESSION['userid'])) {
				?>
				<a href="lk.php?id=<?php echo $_SESSION['userid']; ?>">Личный кабинет</a>
				<?php
				} else {
				?>
				<a href="login.php" id="login">Вход</a>
				<?php
				}
				?>
				<a href="#" id="menu" class="icon">&#9776;</a>
			</div>
		</nav>
	</header>
	<main>
		<div class="contentAbout">
			<h2>О нас для блогеров</h2>
			<div class="aboutImg">
				<img src="../image/aboutBloger.jpg">
			</div>
			<div class="aboutText">
				<p>Рады видеть вас на нашем сайте, дорогой блогер, который желает поделиться своими путешествиями с людьми.</p>
				<P>Сайт Nothcity призван показать, насколько счастливым и свободным человек может быть, путешествуя по нашей планете – открывая для себя другие страны и города, встречая на своем пути потрясающие по своей красоте места и таких удивительных и разных людей, стирая все границы на карте и в своей голове.</P>
				<p>Многие думают, что все это очень сложно. Страховки, визы, брони, билеты, транспорт, язык в чужой стране, границы. На самом же деле все границы существуют только в голове! Нет ничего сложного, нет ничего страшного, есть только удовольствие, получаемое от путешествий по всему миру, и ощущение безграничной свободы! Гораздо сложнее научиться достойно зарабатывать в интернете, но и это вполне реально.</p>
				<p>И именно на нашем сайте вы сможете найти то, что вам так нужно: аудиторию. Аудиторию, которая ждет ваши публикации, которой интересно читать именно ваш блог. Здесь вы можете начать делать свои первые шаги, в сторону заработка за то, что вы путешествуете по миру, и узнаете новые и интересные места. Начни вести свой блог прямо сейчас, сделай первый шаг к своей мечте. </p>
			</div>
		</div>
	</main>

<footer>
		<div class="footeContent">
			<div class="info">
				<div class="links">
					<a href="populare.php">Популярное</a><br>
					<a href="blogers.php">Блогеры</a><br>
					<a href="lifehack.php">Полезные статьи</a><br>
				</div>
				<div class="links">
					<a href="aboutusBlog.php">О нас для блогеров</a><br>
					<a href="aboutusRead.php">О нас для читателей</a><br>
				</div>
				<div class="social">
					<a href="#"><img src="../image/vk.png"></a>
					<a href="#"><img src="../image/twitter.png"></a>
					<a href="#"><img src="../image/facebook.png"></a>
					<a href="#"><img src="../image/telegram.png"></a>			
				</div>
			</div>
			<p>Авторские права © 2020 Все права защищены - Nothcity</p>
		</div>
	</footer>
	<script src="../js/script.js"></script>
</body>
</html>