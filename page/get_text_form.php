<?php
	function clean($value = "") {
		$value = trim($value);
		$value = stripslashes($value);
		$value = strip_tags($value);
		$value = htmlspecialchars($value);

		return $value;
	}
	function check_login($value = "") {
		return preg_match("/^[A-Za-z_0-9!@#№$%^&?*+=-_.,:;\|\/<>`~]{3,20}$/", $value);
	}
	function check_nick($value = "") {
		return preg_match("/^([А-Яа-я_0-9!@#№$%^&?*+=-_.,:;\|\/<>`~]{3,20})|([A-Za-z_0-9!@#№$%^&?*+=-_.,:;\|\/<>`~]{3,20})$/", $value);
	}
	function check_pass($value = "") {
		return preg_match("/^(?=.*[0-9])(?=.*[!@#№$%^&?*+=-_.,:;\|\/<>`~])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#№$%^&?*+=-_.,:;\|\/<>`~]{6,20}$/", $value);
	}
?>