<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require_once('db.php');
$_SESSION['prev'] = 'subscribers.php?id='.$_GET['id'];
$subs = get_subscribers($_GET['id']);
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Подписчики</title>
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
		<div class="wrapper-subscribers">
			<h1>На <?php echo $_GET['nick']; ?> подписаны</h1>
			<?php while($row=mysqli_fetch_array($subs)) { ?>
			<div class="main-popular">
				<div class="subscribers-img">
					<a href="lk.php?id=<?php echo $row['id']; ?>"><img src="<?php echo $row['photo']; ?>"></a>
				</div>
				<div class="popular-text">
					<h1><a href="lk.php?id=<?php echo $row['id']; ?>"><?php echo $row['nick']; ?></a></h1>
					<p><?php echo $row['about']; ?></p>
				</div>
				
			</div>
			<?php } ?>
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