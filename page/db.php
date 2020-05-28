<?php
require("db1.php");

function insert_into_logins($login, $passw) {
	require("db1.php");
	$passw = md5($passw);
	$query = "INSERT INTO user (login) VALUES ('$login')";
	$result = mysqli_query($link, $query);
	$id = mysqli_insert_id($link);
	$query = "INSERT INTO passwords (user_id, password, date) VALUES ('$id', '$passw', now())";
	$result = mysqli_query($link, $query);
	$id1 = mysqli_insert_id($link);
	$query = "UPDATE user SET password_id='$id1' WHERE id='$id'";
	$result = mysqli_query($link, $query);
	return $id;
}

function update_password($passw, $id) {
	require("db1.php");
	$query = "INSERT INTO passwords (user_id, password, date) VALUES ('$id', '$passw', now())";
	$result = mysqli_query($link, $query);
	$id1 = mysqli_insert_id($link);
	$query = "UPDATE user SET password_id='$id1' WHERE id='$id'";
	$result = mysqli_query($link, $query);
}

function was_in_db($passw, $id) {
	require("db1.php");
	$query = "SELECT COUNT(*) AS num FROM passwords WHERE password='$passw' AND user_id='$id'";
	$result = mysqli_query($link, $query);
	$result = mysqli_fetch_array($result);
	return $result['num'] > 0;
}

function get_log_pas($login, $passw) {
	require("db1.php");
	$query = "SELECT user.id AS id, login, password FROM user JOIN passwords ON password_id=passwords.id WHERE login='$login' AND password='$passw'";
	$result = mysqli_query($link, $query);
	return $result;
}

function insert_into_info($id, $nick) {
	require("db1.php");
	$query = "INSERT INTO user_info (user_id, photo, nick) VALUES (
		'$id', '../photo/default.jpg', '$nick'
	)";
	$result = mysqli_query($link, $query);
}

function get_user_by_id($id) {
	require("db1.php");
	$query = "SELECT * FROM user_info JOIN (SELECT user.id, login, password FROM user JOIN passwords ON password_id=passwords.id) k ON k.id=user_id WHERE user_id='$id'";
	$result = mysqli_query($link, $query);
	return $result;
}

function insert_into_post($user_id, $name, $descr, $post, $cat_id) {
	require("db1.php");
	$query = "INSERT INTO post (user_id, name, description, content, date, category_id) VALUES (
		'$user_id', '$name', '$descr', '$post', now(), '$cat_id'
	)";
	$result = mysqli_query($link, $query);
	return mysqli_insert_id($link);
}

function add_photo_to_post($id, $path) {
	require("db1.php");
	$query = "UPDATE post SET photo='$path' WHERE id='$id'";
	$result = mysqli_query($link, $query);
}

function select_post_by_name($userid, $name) {
	require("db1.php");
	$query = "SELECT * FROM post WHERE user_id='$userid' AND name='$name'";
	$result = mysqli_query($link, $query);
	return $result;
}

function select_post_by_id($id) {
	require("db1.php");
	$query = "SELECT ui.user_id AS user_id, nick, p.name AS name, description, ui.photo AS photo, p.date AS date, p.content AS content, COUNT(DISTINCT l.id) AS l_num, COUNT(DISTINCT c.id) AS c_num FROM post p LEFT JOIN post_like l ON l.post_id=p.id LEFT JOIN comment c ON c.post_id=p.id JOIN user_info ui ON ui.user_id=p.user_id WHERE p.id='$id'";
	$result = mysqli_query($link, $query);
	return $result;
}

function insert_into_photo($post_id, $path) {
	require("db1.php");
	$query = "INSERT INTO photo (post_id, path) VALUES (
		'$post_id', '$path'
	)";
	$result = mysqli_query($link, $query);
}

function get_post_to_show() {
	require("db1.php");
	$query = "SELECT p.id, p.name, p.description, u.user_id, nick FROM post p JOIN user_info u ON p.user_id = u.user_id";
	$result = mysqli_query($link, $query);
	return $result;
}

function insert_into_sub($user_id, $sub_id) {
	require("db1.php");
	$query = "INSERT INTO subscriber (user_id, sub_id) VALUES (
		'$user_id', '$sub_id'
	)";
	$result = mysqli_query($link, $query);
}

function is_subscriber($user_id, $sub_id) {
	require("db1.php");
	$query = "SELECT COUNT(*) AS num FROM subscriber WHERE user_id='$user_id' AND sub_id='$sub_id'";
	$result = mysqli_query($link, $query);
	$result = mysqli_fetch_array($result);
	return $result['num'] == 1;
}

function get_number_subscribers($user_id) {
	require("db1.php");
	$query = "SELECT COUNT(DISTINCT sub_id) AS num FROM subscriber WHERE user_id='$user_id'";
	$result = mysqli_query($link, $query);
	$result = mysqli_fetch_array($result);
	return $result['num'];
}

function get_subscribers($user_id) {
	require("db1.php");
	$query = "SELECT ui.user_id AS id, nick, photo, about FROM user_info ui JOIN subscriber s ON ui.user_id=s.sub_id WHERE s.user_id='$user_id' ORDER BY s.user_id DESC";
	$result = mysqli_query($link, $query);
	return $result;
}

function get_subscriptions($user_id) {
	require("db1.php");
	$query = "SELECT ui.user_id AS id, nick, photo, about FROM user_info ui JOIN subscriber s ON ui.user_id=s.user_id WHERE s.sub_id='$user_id' ORDER BY s.sub_id DESC";
	$result = mysqli_query($link, $query);
	return $result;
}

function get_number_subscriptions($user_id) {
	require("db1.php");
	$query = "SELECT COUNT(DISTINCT sub_id) AS num FROM subscriber WHERE sub_id='$user_id'";
	$result = mysqli_query($link, $query);
	$result = mysqli_fetch_array($result);
	return $result['num'];
}

function delete_subscriber($user_id, $sub_id) {
	require("db1.php");
	$query = "DELETE FROM subscriber WHERE user_id='$user_id' AND sub_id='$sub_id'";
	$result = mysqli_query($link, $query);
}

function get_number_post_likes($post_id) {
	require("db1.php");
	$query = "SELECT COUNT(DISTINCT post_id) AS num FROM post_like WHERE post_id='$post_id'";
	$result = mysqli_query($link, $query);
	$result = mysqli_fetch_array($result);
	return $result['num'];
}

function delete_post_like($user_id, $post_id) {
	require("db1.php");
	$query = "DELETE FROM post_like WHERE user_id='$user_id' AND post_id='$post_id'";
	$result = mysqli_query($link, $query);
}

function get_number_comment_likes($post_id) {
	require("db1.php");
	$query = "SELECT COUNT(DISTINCT post_id) AS num FROM comment_like WHERE comment_id='$post_id'";
	$result = mysqli_query($link, $query);
	$result = mysqli_fetch_array($result);
	return $result['num'];
}

function delete_comment_like($user_id, $post_id) {
	require("db1.php");
	$query = "DELETE FROM comment_like WHERE user_id='$user_id' AND comment_id='$post_id'";
	$result = mysqli_query($link, $query);
}

function get_number_posts($user_id) {
	require("db1.php");
	$query = "SELECT COUNT(*) AS num FROM post WHERE user_id='$user_id'";
	$result = mysqli_query($link, $query);
	$result = mysqli_fetch_array($result);
	return $result['num'];
}

function get_null($str) {
	if (empty($str))
		return NULL;
	return "'".$str."'";
}

function update_user_info($nick, $name, $surname, $gender, $date, $country, $city, $email, $about, $id) {
	require("db1.php");
	$query = "UPDATE user_info SET
			nick='$nick', name=NULLIF('$name',''),
			surname=NULLIF('$surname',''), gender=NULLIF('$gender',''),
			birth=NULLIF('$date',''), country=NULLIF('$country', ''),
			city=NULLIF('$city',''), email=NULLIF('$email',''),
			about=NULLIF('$about', '')
			WHERE user_id='$id'
		";
	mysqli_query($link, $query);
}

function update_login($id, $login) {
	require("db1.php");
	$query = "UPDATE user SET
				login='$login'
				WHERE id='$id'";
	mysqli_query($link, $query);
}

function get_top_3_users() {
	require("db1.php");
	$query = "SELECT ui.user_id AS id, nick, photo, about, COUNT(DISTINCT sub_id) AS num FROM user_info ui LEFT JOIN subscriber s ON ui.user_id=s.user_id GROUP BY nick ORDER BY num DESC LIMIT 3";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_top_users() {
	require("db1.php");
	$query = "SELECT ui.user_id AS id, nick, ui.photo, about, COUNT(DISTINCT sub_id) AS s_num, COUNT(DISTINCT p.id) AS p_num FROM user_info ui LEFT JOIN subscriber s ON ui.user_id=s.user_id LEFT JOIN post p ON ui.user_id=p.user_id GROUP BY nick ORDER BY s_num DESC";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_author_by_name($name) {
	require("db1.php");
	$name = mb_strtolower($name, 'UTF-8');
	$query = "SELECT ui.user_id AS id, nick, ui.photo, about, COUNT(DISTINCT sub_id) AS s_num, COUNT(DISTINCT p.id) AS p_num FROM user_info ui LEFT JOIN subscriber s ON ui.user_id=s.user_id LEFT JOIN post p ON ui.user_id=p.user_id WHERE LOWER(nick) LIKE '%$name%' GROUP BY nick ORDER BY s_num DESC";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_top_3_posts() {
	require("db1.php");
	$query = "SELECT p.id AS id, nick, p.date AS date, p.photo AS photo, p.name AS name, description, COUNT(DISTINCT l.id) AS l_num, COUNT(DISTINCT c.id) AS c_num FROM post p LEFT JOIN post_like l ON l.post_id=p.id LEFT JOIN comment c ON c.post_id=p.id JOIN user_info ui ON ui.user_id=p.user_id WHERE NOT (category_id=5) GROUP BY p.id ORDER BY l_num DESC LIMIT 3";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_categories() {
	require("db1.php");
	$query = "SELECT * FROM category";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_help_posts() {
	require("db1.php");
	$query = "SELECT p.id AS id, nick, p.date AS date, p.photo AS photo, p.name AS name, description, COUNT(DISTINCT l.id) AS l_num, COUNT(DISTINCT c.id) AS c_num FROM post p LEFT JOIN post_like l ON l.post_id=p.id LEFT JOIN comment c ON c.post_id=p.id JOIN user_info ui ON ui.user_id=p.user_id WHERE category_id=5 GROUP BY p.id ORDER BY l_num DESC";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_help_post_by_name($name) {
	require("db1.php");
	$name = mb_strtolower($name, 'UTF-8');
	$query = "SELECT p.id AS id, nick, p.date AS date, p.photo AS photo, p.name AS name, description, COUNT(DISTINCT l.id) AS l_num, COUNT(DISTINCT c.id) AS c_num FROM post p LEFT JOIN post_like l ON l.post_id=p.id LEFT JOIN comment c ON c.post_id=p.id JOIN user_info ui ON ui.user_id=p.user_id WHERE category_id=5 AND LOWER(p.name) LIKE '%$name%' GROUP BY p.id ORDER BY l_num DESC";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_categories_without_help() {
	require("db1.php");
	$query = "SELECT * FROM category WHERE NOT (id=5)";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_all_popular_posts() {
	require("db1.php");
	$query = "SELECT p.id AS id, nick, p.date AS date, p.photo AS photo, p.name AS name, description, COUNT(DISTINCT l.id) AS l_num, COUNT(DISTINCT c.id) AS c_num FROM post p LEFT JOIN post_like l ON l.post_id=p.id LEFT JOIN comment c ON c.post_id=p.id JOIN user_info ui ON ui.user_id=p.user_id WHERE NOT (category_id=5) GROUP BY p.id ORDER BY l_num DESC";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_post_by_name($name) {
	require("db1.php");
	$name = mb_strtolower($name, 'UTF-8');
	$query = "SELECT p.id AS id, nick, p.date AS date, p.photo AS photo, p.name AS name, description, COUNT(DISTINCT l.id) AS l_num, COUNT(DISTINCT c.id) AS c_num FROM post p LEFT JOIN post_like l ON l.post_id=p.id LEFT JOIN comment c ON c.post_id=p.id JOIN user_info ui ON ui.user_id=p.user_id WHERE NOT (category_id=5) AND LOWER(p.name) LIKE '%$name%' GROUP BY p.id ORDER BY l_num DESC";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_post_by_author($name) {
	require("db1.php");
	$name = mb_strtolower($name, 'UTF-8');
	$query = "SELECT p.id AS id, nick, p.date AS date, p.photo AS photo, p.name AS name, description, COUNT(DISTINCT l.id) AS l_num, COUNT(DISTINCT c.id) AS c_num FROM post p LEFT JOIN post_like l ON l.post_id=p.id LEFT JOIN comment c ON c.post_id=p.id JOIN user_info ui ON ui.user_id=p.user_id WHERE NOT (category_id=5) AND LOWER(nick) LIKE '%$name%' GROUP BY p.id ORDER BY l_num DESC";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_popular_posts_by_id($id) {
	require("db1.php");
	$query = "SELECT p.id AS id, nick, p.date AS date, p.photo AS photo, p.name AS name, description, COUNT(DISTINCT l.id) AS l_num, COUNT(DISTINCT c.id) AS c_num FROM post p LEFT JOIN post_like l ON l.post_id=p.id LEFT JOIN comment c ON c.post_id=p.id JOIN user_info ui ON ui.user_id=p.user_id WHERE category_id='$id' GROUP BY p.id ORDER BY l_num DESC";
	$res = mysqli_query($link, $query);
	return $res;
}

function select_comment_by_post_id($id) {
	require("db1.php");
	$query = "SELECT ui.user_id AS id, nick, photo, content, date FROM comment c JOIN user_info ui ON c.user_id=ui.user_id WHERE post_id='$id'";
	$res = mysqli_query($link, $query);
	return $res;
}

function insert_comment($user_id, $id, $content) {
	require("db1.php");
	$query = "INSERT INTO comment (user_id, post_id, content, date) VALUES ('$user_id', '$id', '$content', now())";
	$res = mysqli_query($link, $query);
	return $res;
}

function get_posts_by_user_id($id) {
	require("db1.php");
	$query = "SELECT p.id AS id, nick, p.date AS date, p.photo AS photo, p.name AS name, description, COUNT(DISTINCT l.id) AS l_num, COUNT(DISTINCT c.id) AS c_num FROM post p LEFT JOIN post_like l ON l.post_id=p.id LEFT JOIN comment c ON c.post_id=p.id JOIN user_info ui ON ui.user_id=p.user_id WHERE p.user_id='$id' GROUP BY p.id ORDER BY date DESC LIMIT 3";
	$res = mysqli_query($link, $query);
	return $res;
}

function is_there_like($post_id, $user_id) {
	require("db1.php");
	$query = "SELECT * FROM post_like WHERE post_id='$post_id' AND user_id='$user_id'";
	$res = mysqli_query($link, $query);
	$res = mysqli_fetch_array($res);
	return !empty($res);
}

function delete_like($post_id, $user_id) {
	require("db1.php");
	$query = "DELETE FROM post_like WHERE post_id='$post_id' AND user_id='$user_id'";
	$res = mysqli_query($link, $query);
}

function insert_like($post_id, $user_id) {
	require("db1.php");
	$query = "INSERT INTO post_like (post_id, user_id) VALUES ('$post_id', '$user_id')";
	$res = mysqli_query($link, $query);
}

function get_posts_by_user_id2($id) {
	require("db1.php");
	$query = "SELECT p.id AS id, nick, p.date AS date, p.photo AS photo, p.name AS name, description, COUNT(DISTINCT l.id) AS l_num, COUNT( DISTINCT c.id) AS c_num FROM post p LEFT JOIN post_like l ON l.post_id=p.id LEFT JOIN comment c ON c.post_id=p.id JOIN user_info ui ON ui.user_id=p.user_id WHERE p.user_id='$id' GROUP BY p.id ORDER BY date DESC";
	$res = mysqli_query($link, $query);
	return $res;
}
?>