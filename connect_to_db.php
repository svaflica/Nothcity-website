<?php
	$link = mysqli_connect("localhost", "root", "");
	if ($link) {
		echo "Connection success!<br>";
		$db = "db";
		$select = mysqli_select_db($link, $db);
		if ($select) {
			echo "DB selected<br>";
/*			$query = "CREATE TABLE user_info (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), user_id INT, nick VARCHAR(50), name VARCHAR(50), surname VARCHAR(50), email VARCHAR(50), country VARCHAR(50), city VARCHAR(50), birth DATE, about VARCHAR (255))";
*/
/*			$query = "CREATE TABLE subscriber (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), user_id INT, sub_id INT)";
*/
/*			$query = "CREATE TABLE post (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), user_id INT, name VARCHAR(100), description VARCHAR(100), content VARCHAR (5000))";
*/
/*			$query = "CREATE TABLE photo (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), post_id INT, path VARCHAR (255))";
*/
/*			$query = "CREATE TABLE post_like (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), user_id INT, post_id INT)";
*/
			$query = "CREATE TABLE comment_like (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), user_id INT, comment_id INT)";
			/*$query = "CREATE TABLE passwords (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), user_id INT NOT NULL, password VARCHAR(100) NOT NULL, date DATETIME NOT NULL)";*/
			/*$query = "CREATE TABLE comment (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), user_id INT, post_id INT, content VARCHAR(250), date DATETIME)";*/
			$create_tbl = mysqli_query($link, $query);
			if ($create_tbl) {
				echo "Table successfully created";
			}
			else {
				echo "Table wasn't created";
			}
		}
		else {
			echo "DB wasn't selected";
		}
	}
	else
		echo "No connection";
?>