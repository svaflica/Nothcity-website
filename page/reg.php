<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require_once("db.php");
require_once("get_text_form.php");

$login = $_POST['userLogin'];
$passw1 = $_POST['userPassword'];
$passw2 = $_POST['passwordRepeat'];
$nick = $_POST['userNik'];

if (isset($_POST['butLog'])) {
	if (!empty($login) && check_login($login)) {
		if (!empty($nick) && check_nick($nick)) {
			if (!empty($passw1) && !empty($passw2) && check_pass($passw1)) {
				if ($passw1 == $passw2) {
					$query = "SELECT * FROM user WHERE login = '$login'";
					$result1 = mysqli_query($link, $query);
					if (mysqli_num_rows($result1) == 0) {
						$query = "SELECT * FROM user_info WHERE nick = '$nick'";
						$result2 = mysqli_query($link, $query);
						if (mysqli_num_rows($result2) == 0) {
							$id = insert_into_logins($login, $passw1);
							insert_into_info($id, $nick);
							$_SESSION['userid'] = $id;
							header("Location: ../index.php");
							exit;
						}
						else $text = "<p id='err'>Такой ник уже используется</p>";
					}
					else $text = "<p id='err'>Такой логин уже используется</p>";
				}
				else $text = "<p id='err'>Пароли не совпадают</p>";
			}
			else $text = "<p id='err'>Некорректно введен пароль</p>";
		}
		else $text = "<p id='err'>Некорректно введен ник</p>";
	}
	else $text = "<p id='err'>Некорректно введен логин</p>";
}
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Регистрация нового пользователя</title>
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
		<section class="login_form">
			<div class="login_wapper">
				<h1>Регистрация</h1>
				
				<?php echo $text; ?>
				<div class="form_reg">
					<div class="form_inputs_reg">
					<form name="registration" method="post">
						<table id="reg_table">
						<div class="inputs">
							<tr>
								<td id="reg" width="20%">Логин:<span class="red">*</span></td>
								<td id="reg" width="60%"><input type="text" name="userLogin" placeholder="Введите логин" value="<?php echo $login; ?>"></td>
								<td id="reg" width="20%"><p class="reg_inf">Минимум 3 символа. Латинские буквы</p></td>
							</tr>
							
							<tr>
								<td id="reg" width="20%">Никнейм:<span class="red">*</span></td>
								<td id="reg" width="60%"><input type="text" name="userNik" placeholder="Введите никнейм" value="<?php echo $nick;?>"></td>
								<td id="reg" width="20%"><p class="reg_inf">Минимум 3 символа. В одной раскладке либо латиница либо кирилица</p></td>
							
							</tr>
							
							<tr>
								<td id="reg" width="20%">Пароль:<span class="red">*</span></td>
								<td id="reg" width="60%"><input type="password" name="userPassword" placeholder="Введите текст"></td>
								<td id="reg" width="20%"><p class="reg_inf">Минимум 6 символов. Должен содержать символы, цифры и латинские буквы</p></td>
							
							</tr>
							
							<tr>
								<td id="reg" width="20%">Повтор пароля:<span class="red">*</span></td>
								<td id="reg" width="60%"><input type="password" name="passwordRepeat" placeholder="Введите текст"></td>
								<td id="reg" width="20%"></td>
							
							</tr>
						</div>
						</table>
						
							<input type="submit" id="regBut" name="butLog" value="Зарегистрироваться">
					
					</form>
					</div>
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