<?php
session_start();
header('Content-type: text/html; charset=utf-8');
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>О нас для читателей</title>
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
			<h2>О нас для читателей</h2>
			<div class="aboutImg">
				<img src="../image/aboutRead.jpg">
			</div>
			<div class="aboutText">
				<p>Рады видеть вас на нашем сайте, дорогой читатель, который желает увидеть самые дальние и скрытые уголки нашей планеты.</p>
				<P>Сайт Nothcity призван помочь вам найти именно тот формат подачи информации о путешествиях, который хотите видеть Вы. На нашем ресурсе находится сотни блогеров, которые постоянно делятся с вами своими красочными возможно, необычными, уникальными, но неизменно увлекательными путешествиями.</P>
				<p>Почему мы путешествуем? Мы путешествуем, потому что считаем, что жизнь в этом мире не ограничивается проживанием в четырех стенах квартиры, не должна проходить в стремлении подняться по карьерной лестнице и не заканчивается с рождением детей. Мир – это огромная планета, где можно жить путешествуя, наслаждаться красотой природы, знакомиться с интересными людьми. И это – наша жизнь!</p>
				<p>Мы убеждены, что путешествуя, человек становится богаче, мудрее и добрее. Во время каждой поездки появляется возможность узнать больше о других культурах и обычаях, о жизни, радостях и страданиях других людей. Путешественник расширяет свое мировоззрение, начинает ценить то, что действительно имеет ценность, обретает любовь и познает смысл жизни. И именно этим мы ходим поделиться с вами. Начинайте читать нас прямо сейчас, у нас много удивительных историй для вас.</p>
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