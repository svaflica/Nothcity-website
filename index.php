<?php
	session_start();
	header('Content-type: text/html; charset=utf-8');
	$_SESSION['prev'] = '../index.php';

	require("page/db.php");
	$top_blog = get_top_3_users();
	$posts = get_top_3_posts();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Главная</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="../css/style2.css" type="text/css">
	<link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
</head>
<body>
<header>
		<!--<div class="header_logo">
			<a href="home.php"><img src="../image/logoName1.png" alt="Главная"></a>
		</div>-->
		<a href="index.php"><div class="header_logo"><p>Nothcity</p></div><a>
		<nav>
			<div class="topnav" id="myTopnav">
				<a href="page/populare.php">Популярное</a>
				<a href="page/blogers.php">Блогеры</a>
				<a href="page/lifehack.php">Полезные статьи</a>
				<?php
				if (isset($_SESSION['userid'])) {
				?>
				<a href="page/lk.php?id=<?php echo $_SESSION['userid']; ?>">Личный кабинет</a>
				<?php
				} else {
				?>
				<a href="page/login.php" id="login">Вход</a>
				<?php
				}
				?>
				<a href="#" id="menu" class="icon">&#9776;</a>
			</div>
		</nav>
	</header>
	<main>
		<div class="main_welcome">
			<h1>Путешествуй с нами</h1>
			<p>Начни вести свой блог о путешествиях прямо сейчас.</p>
		<div/>
	</main>
	<div class="wrapper">
		<h1>Популярные статьи</h1>
		<div class="publication">
		<?php while($row = mysqli_fetch_array($posts)) { ?>
		<div class="main-popular">
			<div class="popular-img">
				<img src="<?php echo substr($row['photo'], 1); ?>">
			</div>
			<div class="popular-text">
				<h1><?php echo $row['name']; ?></h1>
				<p class="date"><?php echo $row['nick']." ".date("d.m.Y H:i", strtotime($row['date'])); ?></p>
				<p><?php echo $row['description']; ?></p>
				<img src="./image/like-after.png" class="like"><?php echo $row['l_num']; ?>
				<img src="./image/comment.png" class="like"><?php echo $row['c_num']; ?>
				<a href="page/showpost.php?id=<?php echo $row['id']; ?>">Читать дальше</a>
			</div>
		</div>
		<?php } ?>
		</div>
	<br>
	<a href="page/populare.php" id="popularLink">Больше публикаций</a>
	</div>
	<div class="main__blogers">
		<div class="wrapper">
			<h1>Популярные блогеры</h1>
			<div class="bloger__cards">
				<?php
					while ($row=mysqli_fetch_array($top_blog)) {
				?>
				<div class="card">
					<div class="photo"><a href="page/lk.php?id=<?php echo $row['id']; ?>"><img src="<?php echo substr($row['photo'], 1); ?>"></a>
					</div>
					<h4><?php echo $row['nick']; ?></h4>
					<h5><?php echo $row['num']; ?> подписчиков</h5>
					<p><?php echo $row['about']; ?></p>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<footer>
		<div class="footeContent">
			<div class="info">
				<div class="links">
					<a href="page/populare.php">Популярное</a><br>
					<a href="page/blogers.php">Блогеры</a><br>
					<a href="page/lifehack.php">Полезные статьи</a><br>
				</div>
				<div class="links">
					<a href="page/aboutusBlog.php">О нас для блогеров</a><br>
					<a href="page/aboutusRead.php">О нас для читателей</a><br>
				</div>
				<div class="social">
					<a href="#"><img src="image/vk.png"></a>
					<a href="#"><img src="image/twitter.png"></a>
					<a href="#"><img src="image/facebook.png"></a>
					<a href="#"><img src="image/telegram.png"></a>			
				</div>
			</div>
			<p>Авторские права © 2020 Все права защищены - Nothcity</p>
		</div>
	</footer>
	<script src="../js/script.js"></script>
</body>
</html>