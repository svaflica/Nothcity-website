<?php
error_reporting(0);
$link = mysqli_connect("localhost", "root", "");
$db = "db";
$select = mysqli_select_db($link, $db);
mysqli_set_charset($link, "utf8");
?>