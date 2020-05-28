<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require('db.php');

$_SESSION['prev'] = 'userposts.php?id='.$_GET['id'];
$posts = get_posts_by_user_id2($_GET['id']);
	
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Полезные статьи</title>
	<link rel="stylesheet" href="../css/style2.css" type="text/css">
</head>
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
		
		<div class="wrapper-populare">
			<h2>Публикации пользователя <?php echo $_GET['nick']; ?></h2>
			<div class="content">
			
				<div class="publication">
					<?php while ($row=mysqli_fetch_array($posts)) { ?>
					<div class="main-popular">
						<div class="popular-img">
							<img src="<?php echo $row['photo']; ?>">
						</div>
						<div class="popular-text">
							<h1><?php echo $row['name']; ?></h1>
							<p class="date"><?php echo $row['nick']." ".date("d.m.Y H:i", strtotime($row['date'])); ?></p>
							<p><?php echo $row['description']; ?></p>
							<img src="../image/like-after.png" class="like"><?php echo $row['l_num']; ?>
							<img src="../image/comment.png" class="like"><?php echo $row['c_num']; ?>
							<a href="showpost.php?id=<?php echo $row['id']; ?>">Читать дальше</a>
						</div>		
					</div>
					<?php } ?>
				</div>
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