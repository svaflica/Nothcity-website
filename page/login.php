<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require_once("db.php");
require_once("get_text_form.php");
$login = clean($_POST['userLogin']);
$passw = $_POST['userPassword'];
if (isset($_POST['butLog'])) {
	if (!empty($login) && !empty($passw)) {
		$passw = md5($passw);
		$res = get_log_pas($login, $passw);
		$res = mysqli_fetch_array($res);
		if (!empty($res)) {
			$_SESSION['userid'] = $res['id'];
			header("Location: ../index.php");
			exit;
		}
		else
			$text = "<p id='err'>Неверный логин или пароль</p>";
	}
	else
		$text = "<p id='err'>Неверный логин или пароль</p>";
}
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
	<link rel="stylesheet" href="../css/style2.css" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet"></head>
<body>
	<header>
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
		<section class="login_form">
			<div class="login_wapper">
				<h1>Вход на сайт</h1>
				<?php echo $text; ?>
				<div class="form">
					<form name="login" method="post">
						<div class="form_inputs">
							<p>Логин:
							<input type="text" name="userLogin" placeholder="Введите логин"></p>
							<p>Пароль:
							<input type="password" name="userPassword" placeholder="Введите текст"></p>
							<p>
								<input type="submit" name="butLog" value="Вход">
								<a href="reg.php" id="reg">Регистрация</a>
							</p>
						</div>
					</form>
				</div>
			</div>
		</section>
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