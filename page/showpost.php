<?php
session_start();
header('Content-type: text/html; charset=utf-8');
require_once("db.php");

$_SESSION['prev'] = 'showpost.php?id='.$_GET['id'];
$post = mysqli_fetch_array(select_post_by_id($_GET['id']));
$is_like = isset($_SESSION['userid']) && is_there_like($_GET['id'], $_SESSION['userid']);
$comments = select_comment_by_post_id($_GET['id']);
if ($_POST['AddComment']) {
	if ($_SESSION['userid']) {
		if (!empty($_POST['commText']) && strlen($_POST['commText']) <= 255) {
			insert_comment($_SESSION['userid'], $_GET['id'], $_POST['commText']);
			header("Refresh: 0");
		}
	}
	else {
		header("Location: login.php");
		exit;
	}
}
else if ($_POST['set_like']) {
	if ($_SESSION['userid']) {
		insert_like($_GET['id'], $_SESSION['userid']);
		header("Refresh: 0");
	}
	else {
		header("Location: login.php");
		exit;
	}
}
else if ($_POST['del_like']) {
	if ($_SESSION['userid']) {
		delete_like($_GET['id'], $_SESSION['userid']);
		header("Refresh: 0");
	}
	else {
		header("Location: login.php");
		exit;
	}
}
?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Название поста</title>
	<link rel="stylesheet" href="../css/style2.css" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet"></head>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script>
	window.addEventListener('resize', event => {
		var iframe = (isGecko) ? document.getElementById("framePost") : frames["framePost"];
		iframe.height = iframe.contentWindow.document.body.scrollHeight + "px";
	}, false);
	</script>
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
		<div class="postContent">
			<div class="autorPost">
				<div class="autor">
					<a href="lk.php?id=<?php echo $post['user_id']; ?>"><p class="autorName"><?php echo $post['nick'] ?></p></a>
					<a href="lk.php?id=<?php echo $post['user_id']; ?>"><img src="<?php echo $post['photo']; ?>"></a>
				</div>
				<div class="post">
					<input type="text" name="text" value='<?php echo $post['content']; ?>' hidden>
					<h1><?php echo $post['name']; ?></h1>
					<p class="date"><?php echo date("d.m.Y H:i", strtotime($post['date'])); ?></p>
					<iframe id='framePost' name='framePostId'></iframe>
					<form name="likeForm" method="post">
						<input type='submit' value="  " class='likeButton' style="background-image: url(<?php echo ($is_like ? '../image/like-after.png' : '../image/like-before.png'); ?>); background-repeat: no-repeat; background-position: center; background-size: 15px; border:0px; background-color: #e9e7e7; cursor: pointer; margin-top: 3px; margin-right: 3px; width:15px; cursor: pointer;" name="<?php echo ($is_like ? 'del_like' : 'set_like'); ?>"/><?php echo $post['l_num']; ?>
						<img src="../image/comment.png" class="like"><?php echo $post['c_num']; ?>
					</form>
					
				</div>
			</div>
			
			<div class="coments">
				<h2>Комментарии</h2>
				<?php while($row=mysqli_fetch_array($comments)) { ?>
				<div class="comment">
					<div class="autor">
						<a href="lk.php?id=<?php echo $row['id']; ?>"><p class="autorName"><?php echo $row['nick']; ?></p></a>
						<a href="lk.php?id=<?php echo $row['id']; ?>"><img src="<?php echo $row['photo']; ?>"></a>
					</div>
					
					<div class="commentText">
						<p class="date"><?php echo date("d.m.Y H:i", strtotime($row['date'])); ?></p>
						<p><?php echo $row['content']; ?></p>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="addCom">
				<div class="form_inputs" style="margin-right:0px">
					<form name="AddCommentForm" method="post">
						<textarea rows="6" name="commText"></textarea><br>
						<input type="submit" name="AddComment" value="Отправить комментарий">
					</form>
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
	<script>
		var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

		var iframe = (isGecko) ? document.getElementById("framePost") : frames["framePost"];
		var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
		var iDoc = (isGecko) ? iframe.contentDocument : iframe.document;

		iHTML = "<html><head><\/head>";
		iHTML += "<body style='overflow-wrap: break-word; text-align:justify;'>";
		iHTML += document.getElementsByName("text")[0].value;
		iHTML += "<\/body><\/html>";
		iDoc.open();
		iDoc.write(iHTML);
		iDoc.close();
		iframe.height = iframe.contentWindow.document.body.scrollHeight + "px";
	</script>
</body>
</html>