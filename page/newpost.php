<?php
session_start();
header('Content-type: text/html; charset=utf-8');
if (!isset($_SESSION['userid'])) {
	$_SESSION['prev'] = '../index.php';
	header("Location: index.php");
	exit;
}
require("db.php");
$cat = get_categories();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>New post</title>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="../css/style2.css" type="text/css">
<script>
function setBold() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

	var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
	var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	iWin.focus();
	iWin.document.execCommand("bold", null, "");
}
function setItal() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

	var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
	var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	iWin.focus();
	iWin.document.execCommand("italic", null, "");
}
function setUnder() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

	var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
	var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	iWin.focus();
	iWin.document.execCommand("underline", null, "");
}
function setImage() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	dialog = $("#getimage").dialog({autoOpen: false});
	dialog.dialog( "open" );

	$('#getimage').submit(function(e) {
		e.preventDefault();
		width = document.getElementById("width").value;
		height = document.getElementById("height").value;
		href = document.getElementsByName("uri")[0].value;
		if (parseInt(width) && parseInt(height)) {
			width = " width=" + width + " height=" + height + " ";
			if (href == "") {
				var time = document.getElementsByName("file_name")[0].value;
				var form = new FormData($(this).get(0));
				form.append('file_name', time);
				form.append('width', width);
				$.ajax({
					url: 'submit.php',
					type: 'POST',
					data: form,
					cache: false,
					dataType: 'json',
					processData: false,
					contentType: false,
					success: function(response){
						href = response.name;
						width = response.width;
						dialog.dialog("close");
						iWin.focus();
						iWin.document.execCommand('insertHTML', false, "<img src='" + href + "' " + width + " >");
					}
				});

			}
			else {
				dialog.dialog("close");
				iWin.focus();
				iWin.document.execCommand('insertHTML', false, "<img src='" + href + "' " + width + " >");
			}
		}
		document.getElementsByName("uri")[0].value = "";
		document.getElementsByName("file_name")[0].value = "";
		document.getElementsByName("file_upload")[0].value = "";
		document.getElementById("width").value = "";
		document.getElementById("height").value = "";
		return false;
	});
//	$("button[id=cancel][name=getimage]").click(function () {
//		document.getElementsByName("uri")[0].value = "";
//		document.getElementsByName("file_name")[0].value = "";
//		document.getElementsByName("file_upload")[0].value = "";
//		document.getElementById("width").value = "";
//		document.getElementById("height").value = "";
//		dialog.dialog("close");
//	});
}
function setCenterAlign() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	iWin.focus();
	iWin.document.execCommand("justifyCenter", false, "");
}
function setLeftAlign() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	iWin.focus();
	iWin.document.execCommand("justifyLeft", false, "");
}
function setRightAlign() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	iWin.focus();
	iWin.document.execCommand("justifyRight", false, "");
}
function setFullAlign() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	iWin.focus();
	iWin.document.execCommand("justifyFull", false, "");
}
function setColor() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	dialog = $("#getcolor").dialog({autoOpen: false});
	dialog.dialog( "open" );
	$("button[id=submit][name=getcolor]").click(function () {
		color = document.getElementsByName("color")[0].value;
		dialog.dialog("close");
		iWin.focus();
		iWin.document.execCommand("foreColor", false, color);
	});
//	$("button[id=cancel][name=getcolor]").click(function () {
//		dialog.dialog("close");
//	});
}
function setFontSize() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	dialog = $("#fontsize").dialog({autoOpen: false});
	dialog.dialog( "open" );
	$("button[id=submit][name=font]").click(function () {
		num = document.getElementsByName("font")[0].value;
		dialog.dialog("close");
		if (parseInt(num)) {
			c = parseInt(num);
			if (c > 0 && c <= 7) {
				iWin.focus();
				iWin.document.execCommand("fontSize", false, num);
			}
		}
		document.getElementsByName("font")[0].value = "";
	});
//	$("button[id=cancel][name=font]").click(function () {
//		dialog.dialog("close");
//	});
}
function setHiliteColor() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	dialog = $("#gethilite").dialog({autoOpen: false});
	dialog.dialog( "open" );
	$("button[id=submit][name=gethilite]").click(function () {
		color = document.getElementsByName("hilitecolor")[0].value;
		dialog.dialog("close");
		iWin.focus();
		iWin.document.execCommand("hiliteColor", false, color);
	});
//	$("button[id=cancel][name=gethilite]").click(function () {
//		dialog.dialog("close");
//	});
}
function setOl() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	iWin.focus();
	iWin.document.execCommand("insertOrderedList", false, "");
}
function setUl() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	iWin.focus();
	iWin.document.execCommand("insertUnorderedList", false, "");
}
function setStrike() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	iWin.focus();
	iWin.document.execCommand("strikeThrough", false, "");
}
function setHREF() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	dialog = $("#gethref").dialog({autoOpen: false});
	dialog.dialog( "open" );
	$("button[id=submit][name=href]").click(function () {
		href = document.getElementsByName("href")[0].value;
		dialog.dialog("close");
		iWin.focus();
		iWin.document.execCommand("createLink", false, href);
		document.getElementsByName("href")[0].value = "";
	});
//	$("button[id=cancel][name=href]").click(function () {
//		dialog.dialog("close");
//	});
}
function getContent() {
	var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
	var name = document.getElementById("articlename").value;
	var descr = document.getElementById("articledescr").value;
	var text = iWin.document.body.innerHTML;
	var id = <?php echo $_SESSION['userid']; ?>;
	var form = new FormData(document.getElementsByName("post")[0]);
	var sel = document.getElementsByName("select")[0].value;

	form.append('name', name);
	form.append('descr', descr);
	form.append('content', text);
	form.append('id', id);
	form.append('select', sel);
	$.ajax({
		url: 'sendpost.php',
		type: 'POST',
		data: form,
		cache: false,
		processData: false,
        contentType: false,
		dataType: 'json',
		success: function(response){
			if (response['status'] == 'ok') {
				window.location = "../index.php";
			}
			else if (response['status'] == 'error_twice')
				alert("Название такой публикации уже занято");
			else if (response['status'] == 'error_name')
				alert("Не введено имя");
			else if (response['status'] == 'error_descr')
				alert("Не введено описание");
			else if (response['status'] == 'error_val')
				alert("Не введена публикация");
			else
				alert("Не знаю, что вам ответить");
		},
		error: function(response){
		console.log(response);
	}
	});
}
</script>
<link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet"></head>
<body>
<header>
	<a href="../index.html"><div class="header_logo"><p>Nothcity</p></div></a>
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
<div class="form_inputs" id="newpost">
	<form method="post" name="getimage" enctype='multipart/form-data' id="getimage" style="display: none;" onsubmit="return false;" >
		<label for="uri">URI: </label>
		<input type="text" name="uri">
		ИЛИ
		<input type="text" name="file_name" hidden value=<?php echo date("l_dS_of_F_Y_his_A"); ?>>
		<input type="file" name="file_upload" />
		<label for="width">Ширина: </label>
		<input type="text" name="width" id="width">
		<label for="height">Высота: </label>
		<input type="text" name="height" id="height">
		<input type="submit" id="submitimageadding" name="getimage">
	</form>

	<div name='gethref' id='gethref' style='display:none;'>
		<label for="href">Пожалуйста, введите URI: </label>
		<input type="text" name="href">
		<button id="submit" name="href">Ок</button>
	</div>

	<div name='getcolor' id='getcolor' style='display:none;'>
		<label for="color">Пожалуйста, выберите цвет: </label>
		<input type="color" name="color">
		<button id="submit" name="getcolor">Ок</button>
	</div>

	<div name='gethilite' id='gethilite' style='display:none;'>
		<label for="hilitecolor">Пожалуйста, выберите цвет: </label>
		<input type="color" name="hilitecolor">
		<button id="submit" name="gethilite">Ок</button>
	</div>

	<div name="fontsize" id="fontsize" style="display:none;">
		<label for="font">Пожалуйста, выберите размер шрифта (1-7)</label>
		<input type="text" name="font" id="font">
		<button id="submit" name="font">Ок</button>
	</div>

	<h1>Создание новой публикации</h1>
	<form name="post" method="post" enctype='multipart/form-data'  onsubmit="return false;">
	<table>
		<tr>
			<td><label for="name">Заголовок: </label></td>
			<td><input type="text" name="name" id="articlename"></td>
		<br>
		</tr>
		<tr>
			<td><label for="photo"></label>Фото публикации:</label></td>
			<td><input type="file" name="photo_upload" id="articlephoto"></td>
		</tr>
		<tr>
			<td><label for="select"></label>Категория:</label></td>
			<td><select name="select">
				<?php
					while ($row=mysqli_fetch_array($cat)) {
					?>
					<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
					<?php
					}
					?></select></td>
		</tr>
		<tr>
			<td valign="top"><label for="descr">Описание: </label></td>
			<td><textarea rows="6" cols="40" name="descr" id="articledescr"></textarea></td>
		</tr>
	</table>
	<input type='button' onclick='setBold()' class='bold'/>
	<input type='button' onclick='setItal()' class='ital' />
	<input type='button' onclick='setUnder()' class='under' />
	<input type='button' onclick='setImage()' class='imagePic'/>
	<input type='button' onclick='setCenterAlign()' class='aligncenter'/>
	<input type='button' onclick='setLeftAlign()' class='alignleft'/>
	<input type='button' onclick='setRightAlign()' class='alignright'/>
	<input type='button' onclick='setFullAlign()' class='fullalign'/>
	<input type='button' onclick='setColor()' class='color'/>
	<input type='button' onclick='setFontSize()' class='fontsize'/>
	<input type='button' onclick='setHiliteColor()' class='hilitecolor'/>
	<input type='button' onclick='setOl()' class='ol'/>
	<input type='button' onclick='setUl()' class='ul'/>
	<input type='button' onclick='setStrike()' class='s'/>
	<input type='button' onclick='setHREF()' class='href'/>

	<iframe scrolling="yes" frameborder='no' contenteditable="true" sandbox="allow-same-origin allow-scripts" id='frameId' name='frameId' width=97% height="350px"></iframe>
	<br><br>
	<input type="text" name="content" hidden>
	<input type="submit" value='Опубликовать' name='submit' onclick="getContent();" id='postsub'>
	</form>
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
<script type="text/javascript">

$(document).ready(function() {
var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;

var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
var iDoc = (isGecko) ? iframe.contentDocument : iframe.document;

iDoc.open();
iDoc.write("<html><body style='overflow-wrap: break-word; text-align: justify;'><\/body><\/html>");
iDoc.close();
	
if (!iDoc.designMode) alert("You can't");
else iDoc.designMode = (isGecko) ? "on" : "On";
});
</script>
</body>
</html>
