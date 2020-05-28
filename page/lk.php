<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require_once('db.php');

$_SESSION['prev'] = 'lk.php?id='.$_GET['id'];
$text = "Не указано";
$user = get_user_by_id($_GET['id']);
$subs = get_number_subscribers($_GET['id']);
$subs2 = get_number_subscriptions($_GET['id']);
$posts = get_number_posts($_GET['id']);
$post = get_posts_by_user_id($_GET['id']);
$user = mysqli_fetch_array($user);
if ($_POST['follow']) {
	if (!isset($_SESSION['userid'])) {
		header("Location: login.php");
		exit;
	}
	insert_into_sub($_GET['id'], $_SESSION['userid']);
	header("Refresh: 0");
}
else if ($_POST['unfollow']) {
	delete_subscriber($_GET['id'], $_SESSION['userid']);
	header("Refresh: 0");
}
else if ($_POST['exit']) {
	$_SESSION['userid'] = "";
	session_destroy();
	header("Location: ../index.php");
	exit;
}
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Личный кабинет</title>
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
	<div class="userInf">
		<div class="leftSection">
			<div class="aboutPerson">
				<img src="<?php echo $user['photo'] ?>">
				<p><a href="subscribers.php?id=<?php echo $_GET['id']; ?>&nick=<?php echo $user['nick']; ?>">Подписчиков: <?php echo $subs; ?></a></p>
				<p><a href="subscriptions.php?id=<?php echo $_GET['id']; ?>&nick=<?php echo $user['nick']; ?>">Подписок:  <?php echo $subs2; ?></a></p>
				<p>Публикаций: <?php echo $posts; ?></p>
				<?php if ($_SESSION['userid'] == $_GET['id']) { ?>
				<p><a href="changeInfo.php">Редактировать профиль</a></p>
				<p><a href="newpost.php?id=<?php echo $_GET['id']; ?>">Новая публикация</a>	</p>
				<form name="FollowForm" method="post">
					<input type="submit" name="exit" value="Выйти">
				<?php } else { ?>
				<form name="FollowForm" method="post">
					<?php if (!is_subscriber($_GET['id'], $_SESSION['userid'])) { ?>
					<input type="submit" name="follow" value="Подписаться">
					<?php } else { ?>
					<input type="submit" name="unfollow" value="Отписаться">
					<?php } ?>
				<?php } ?>
				</form>
			</div>
		</div>
		<div class="rightSection">
			
			<table>
			<h1><?php echo $user['nick']; ?></h1>
				<tr>
					<td>Имя:</td>
					<td>
						<?php
							echo(!empty($user['name']) ? $user['name'] : $text);
						?>
					</td>
				</tr>
				<tr>
					<td>Фамилия:</td>
					<td>
						<?php
							echo(!empty($user['surname']) ? $user['surname'] : $text);
						?>
					</td>
				</tr>
				<tr>
					<td>Пол:</td>
					<td>
						<?php
							echo(!empty($user['gender']) ? $user['gender'] : $text);
						?>
					</td>
				</tr>
				<tr>
					<td>Дата рождения:</td>
					<td>
						<?php
							echo(!empty($user['birth']) && $user['birth'] >= '1970-01-01' ? date("d.m.Y", strtotime($user['birth'])) : $text);
						?>
					</td>
				</tr>
				<tr>
					<td>Страна:</td>
					<td>
						<?php
							echo(!empty($user['country']) ? $user['country'] : $text);
						?>
					</td>
				</tr>
				<tr>
					<td>Город:</td>
					<td>
						<?php
							echo(!empty($user['city']) ? $user['city'] : $text);
						?>
					</td>
				</tr>
				<tr>
					<td>Email:</td>
					<td>
						<?php
							echo(!empty($user['email']) ? $user['email'] : $text);
						?>
					</td>
				</tr>
				<tr>
					<td  valign="top">О себе:</td>
					<td>
						<?php
							echo(!empty($user['about']) ? $user['about'] : $text);
						?>
					</td>
				</tr>
			</table>
		</div>	
	</div>
	<div class="lk_wrapper">
		<h1>Публикации <?php echo $user['nick']; ?></h1>
		<?php
			while ($row = mysqli_fetch_array($post)) {
			?>
			<div class="main-popular">
				<div class="popular-img">
					<img src="<?php echo $row['photo']; ?>">
				</div>
				<div class="popular-text">
					<h1><?php echo $row['name']; ?></h1>
					<p class="date"><?php echo date("d.m.Y H:i", strtotime($row['date'])); ?></p>
					<p><?php echo $row['description']; ?></p>
					<img src="../image/like-after.png" class="like"><?php echo $row['l_num']; ?>
					<img src="../image/comment.png" class="like"><?php echo $row['c_num']; ?>
					<a href="showpost.php?id=<?php echo $row['id']; ?>">Читать дальше</a>
				</div>		
			</div>
			<?php
			}
			?>
		<br>
	<a href="userposts.php?id=<?php echo $_GET['id']; ?>&nick=<?php echo $user['nick']; ?>" id="popularLink">Больше публикаций <?php echo $user['nick']; ?></a>
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