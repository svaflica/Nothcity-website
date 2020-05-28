<?php
	session_start();
	$tmp_file_name = $_FILES["file_upload"]["tmp_name"];
	$filename = date("l_dS_of_F_Y_his_A");
	$file_type = pathinfo($_FILES["file_upload"]["name"], PATHINFO_EXTENSION);
	$dest_file_name = $_SERVER['DOCUMENT_ROOT']."/photo/".$filename.".".$file_type;
	move_uploaded_file($tmp_file_name, $dest_file_name);
	echo json_encode( array('name' => "../photo/".$filename.".".$file_type, 'width' => $_POST['width']));
	exit;
?>