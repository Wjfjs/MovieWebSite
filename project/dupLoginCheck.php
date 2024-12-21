<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['idValue'])) {
			$idValue = $_POST['idValue'];
			if (!preg_match('/^[A-Za-z0-9_]+$/', $idValue)) {
					echo "<span style='color:red;'>아이디는 영어 및 숫자로만 입력해야 합니다.</span>";
				exit;
			} 
			else {
				echo "";
			}
		}
	
		if (isset($_POST['passwdValue'])) {
			$passwdValue = $_POST['passwdValue'];
			if (!preg_match('/^[A-Za-z0-9_]+$/', $passwdValue)) {
				echo "<span style='color:red;'>비밀번호는 영어 및 숫자로만 입력해야 합니다.</span>";
				exit;
			} 
			else {
				echo "";
			}
			
		}
	}
?>