<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require_once('db.php');
require_once('get_text_form.php');
$user = mysqli_fetch_array(get_user_by_id($_SESSION['userid']));

$id = $user['user_id'];
$nick = $user['nick'];
$name = $user['name'];
$surname = $user['surname'];
$gender = $user['gender'];
$date = $user['birth'];
$country = $user['country'];
$city = $user['city'];
$email = $user['email'];
$about = $user['about'];
if ($_POST['EditInfo']) {
	$nick = clean($_POST['Nikname']);
	$name = clean($_POST['name']);
	$surname = clean($_POST['surname']);
	$gender = clean($_POST['Gender']);
	$date = clean($_POST['Date']);
	$country = clean($_POST['Country']);
	$city = clean($_POST['City']);
	$email = clean($_POST['Email']);
	$about = clean($_POST['About']);
	$query = "SELECT * FROM user_info WHERE nick = '$nick' AND NOT (user_id=$id)";
	$result2 = mysqli_query($link, $query);
	$result2 = mysqli_fetch_array($result2);
	if (check_nick($nick) && empty($result2)) {
		update_user_info($nick, $name, $surname, $gender, $date, $country, $city, $email, $about, $id);
		$text = "<p id='correct'>Изменения сохранены</p>";
	}
	else $text = "<p id='err'>Попробуйте другой ник</p>";
}
else if ($_POST['NewLog']) {
	$oldlogin = $user['login'];
	$login = clean($_POST['LastLogin']);
	if ($oldlogin == $login) {
		$login = clean($_POST['NewLogin']);
		$query = "SELECT * FROM user WHERE login = '$login' AND NOT (id='$id')";
		$result1 = mysqli_query($link, $query);
		$result1 = mysqli_fetch_array($result1);
		if (check_login($login) && empty($result1)) {
			update_login($id, $login);
			$text1 = "<p id='correct'>Изменения внесены</p>";
		}
		else $text1 = "<p id='err'>Попробуйте другой логин</p>";
	}
	else $text1 = "<p id='err'>Ошибка в старом логине</p>";
}
else if ($_POST['NewPass2']) {
	$oldPassw = $user['password'];
	$oldDate = $user['date'];
	$login = $user['login'];
	$passw = clean($_POST['LastPass']);
	$date = $_POST['date'];
	if ($oldPassw == md5($passw)) {
		$passw = clean($_POST['NewPass']);
		$passw1 = clean($_POST['NewPassTwice']);
		if ($passw == $passw1) {
			if (check_pass($passw)) {
				$passw = md5($passw);
				if (!was_in_db($passw, $id)) {
					update_password($passw, $id);
					$text2 = "<p id='correct'>Изменения внесены</p>";
				}
				else $text2 = "<p id='err'>Вы уже использовали такой пароль</p>";
			}
			else $text2 = "<p id='err'>Некорректный пароль</p>";
		}
		else $text2 = "<p id='err'>Пароли не свопадают!</p>";
	}
	else $text2 = "<p id='err'>Ошибка в старом пароле</p>";
}
else if ($_POST['submit_file']) {
	$tmp_name = $_FILES['photo']['tmp_name'];
	$file_type = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
	$dest_file_name = $_SERVER['DOCUMENT_ROOT']."/photo/".$_SESSION['userid']."_big.".$file_type;
	move_uploaded_file($tmp_name, $dest_file_name);
	$photo = "../photo/".$_SESSION['userid']."_big.".$file_type;
	$query = "UPDATE user_info SET
			photo = '$photo'
			WHERE user_id='$id'
	";
	mysqli_query($link, $query);
	$text0 = "<p id='correct'>Изменения внесены</p>";
}
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Изменение профиля</title>
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

		<div class="login_wapper">
		<h2>Редактирование профиля</h2>
			<div class="form_inputs">
				<table>
					<tr><td></td>	<td><h3>Изменить фото</h3></td></tr>
					<form name="EditPhoto" method="post" enctype='multipart/form-data'>
						<tr>
							<td></td><td><?php echo $text0; ?></td>
						</tr>
						<tr>
							<td>Фотография:</td>
							<td><input type="file" name="photo" ></td>
						</tr>
						<tr>
							<td></td><td><input type="submit" name="submit_file" value="Применить"></td>
						</tr>
					</form>
					<tr><td></td>	<td><h3>Изменить данные</h3></td></tr>
					<form name="EditInfoForm" method="post">
						<tr>
							<td></td>
							<td><?php echo $text; ?></td>
						</tr>
						<tr>
							<td>Никнейм:</td>
							<td><input type="text" name="Nikname" value="<?php echo $nick; ?>" ></td>
						</tr>
						<tr>
							<td>Имя:</td>
							<td><input type="text" name="name" value="<?php echo $name; ?>" ></td>
						</tr>
						<tr>
							<td>Фамилия:</td>
							<td><input type="text" name="surname" value="<?php echo $surname; ?>" ></td>
						</tr>
						<tr>
							<td>Пол:</td>
							<td><select size="1" name="Gender">
									<option value="" <?php $gender != "Женский" && $gender != "Мужской" ? "selected" : "" ?> >Выберите пол</option>
									<option value="Мужской" <?php echo $gender == "Мужской" ? "selected" : ""; ?>>Мужской</option>
									<option value="Женский" <?php echo $gender == "Женский" ? "selected" : ""; ?>>Женский</option>
							</td>
						</tr>
						<tr>
							<td>Дата рождения:</td>
							<td><input type="date" name="Date" value="<?php echo $date; ?>" ></td>
						</tr>
						<tr>
							<td>Страна:</td>
							<td><input type="text" name="Country" value="<?php echo $country; ?>" ></td>
						</tr>
						<tr>
							<td>Город:</td>
							<td><input type="text" name="City" value="<?php echo $city; ?>" ></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><input type="email" name="Email" value="<?php echo $email; ?>" ></td>
						</tr>
						<tr>
							<td valign="top">О себе:</td>
							<td><textarea rows="6" name="About"><?php echo $about; ?></textarea></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" name="EditInfo" value="Применить"></td>
						</tr>
						
					
					</form>
					<tr><td></td>	<td><h3>Изменить логин</h3></td></tr>
						<tr>
							<td></td>
							<td><?php echo $text1; ?></td>
						</tr>
					<form name="NewLogForm" method="post">
						<tr>
							<td>Старый логин:</td>
							<td><input type="text" name="LastLogin" ></td>
						</tr>
						<tr>
							<td>Новый логин:</td>
							<td><input type="text" name="NewLogin" ></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" name="NewLog" value="Применить"></td>
						</tr>
						<br>
					
					</form>
					<tr><td></td>	<td><h3>Изменить пароль</h3></td></tr>
						<tr>
							<td></td>
							<td><?php echo $text2; ?></td>
						</tr>
					<form name="NewPassForm" method="post">
						<tr>
							<td>Старый пароль:</td>
							<td><input type="password" name="LastPass" ></td>
						</tr>
						<tr>
						<td>Новый пароль:</td>
							<td><input type="password" name="NewPass" ></td>
						</tr>
						<tr>
							<td>Повторите пароль:</td>
							<td><input type="password" name="NewPassTwice" ></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" name="NewPass2" value="Применить"></td>
						</tr>
					</form>
				</table>
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