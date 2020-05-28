<?php
session_start();
require_once('db.php');
require_once('get_text_form.php');

$name = clean($_POST['name']);
$val = $_POST['content'];
$descr = clean($_POST['descr']);
$cat = $_POST['select'];
if (!empty($name) && !empty($descr) && !empty($val)) {
	$posts = select_post_by_name($_POST['id'], $name);
	if (empty(mysqli_fetch_array($posts))) {
		$post_id = insert_into_post($_POST['id'], $name, $descr, $val, $cat);
		if (!empty($_FILES["photo_upload"]["tmp_name"])) {
			$tmp_file_name = $_FILES["photo_upload"]["tmp_name"];
			$file_type = pathinfo($_FILES["photo_upload"]["name"], PATHINFO_EXTENSION);
			$dat = date("Y-m-d_h-i-s");
			$dest_file_name = $_SERVER['DOCUMENT_ROOT']."/photo/".$dat.".".$file_type;
			move_uploaded_file($tmp_file_name, $dest_file_name);
			$photo = "../photo/".$dat.".".$file_type;
		}
		else $photo = "../photo/default.png";
		
		add_photo_to_post($post_id, $photo);
		$match = array();
		preg_match('/.\/photo\/[A-Za-z0-9_]{1,}.[A-Za-z]{1,}/',$val, $match);
		for ($i = 0; $i < sizeof($match); $i++) {
			insert_into_photo($post_id, $match[$i]);
		}
		echo json_encode(array('status' => 'ok', 'id' => $post_id));
		exit;
	}
}
echo json_encode(array('status' => 'not ok'));
exit;
?>