<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');

		// 아이디 중복 체크
		if ($_POST['idValue']) {
			$idValue = $_POST['idValue'];
			$findId = [];

			$sqlSelectID = 'select ID from users';
			$stidSelectID = oci_parse($conn, $sqlSelectID);
			oci_execute($stidSelectID);

			$count = 0;
			while (($row = oci_fetch_array($stidSelectID, OCI_ASSOC)) != false) {
				$findId[$count] = $row["ID"];
				$count++;
			}

			oci_free_statement($stidSelectID);

			foreach ($findId as $id) {
				if ($idValue == $id) {
					echo "<span style='color:red;'>중복된 아이디입니다.</span>";
					oci_close($conn);
					exit;
				}
			}

			if (!preg_match('/^[A-Za-z0-9]+$/', $idValue)) {
				echo "<span style='color:red;'>아이디는 영어 및 숫자로만 입력해야 합니다.</span>";
				oci_close($conn);
				exit;
			} 
			else if (strlen($idValue) < 4) {
				echo "<span style='color:red;'>아이디는 4~12글자만 입력할 수 있습니다.</span>";
				exit;
			} 
			else if (strlen($idValue) > 12) {
				echo "<span style='color:red;'>아이디길이가 너무 깁니다.</span>";
				exit;
			}
			else {
				echo "<span style='color:blue;'>사용 가능한 아이디입니다.</span>";
				exit;
			}
		}

		// 이메일 중복 체크
		if ($_POST['emailValue']) {
			$emailValue = $_POST['emailValue'];
			$findEmail = [];

			$sqlSelectEMAIL = 'select EMAIL from users';
			$stidSelectEMAIL = oci_parse($conn, $sqlSelectEMAIL);
			oci_execute($stidSelectEMAIL);

			$count = 0;
			while (($row = oci_fetch_array($stidSelectEMAIL, OCI_ASSOC)) != false) {
				$findEmail[$count] = $row["EMAIL"];
				$count++;
			}

			oci_free_statement($stidSelectEMAIL);

			foreach ($findEmail as $email) {
				if ($emailValue == $email) {
					echo "<span style='color:red;'>중복된 이메일입니다.</span>";
					oci_close($conn);
					exit;
				}
			}

			if (!preg_match('/^[A-Za-z0-9]+@[A-Za-z]+\.(com)$/', $emailValue)) {
				echo "<span style='color:red;'>유효하지 않은 이메일 주소입니다.</span>";
				oci_close($conn);
				exit;
			} 
			else {
				echo "<span style='color:blue;'>사용 가능한 이메일입니다.</span>";
				exit;
			}
		}
		
		// 비밀번호 오류 체크
		if ($_POST['passwdValue']) {
			$passwdValue = $_POST['passwdValue'];
			
			if (!preg_match('/^[A-Za-z0-9]+$/', $passwdValue)) {
				echo "<span style='color:red;'>비밀번호는 영어 및 숫자로만 입력해야 합니다.</span>";
				oci_close($conn);
				exit;
			} 
			else if (strlen($passwdValue) < 6) {
				echo "<span style='color:red;'>비밀번호는 6~20글자만 입력할 수 있습니다.</span>";
				exit;
			} 
			else if (strlen($passwdValue) > 20) {
				echo "<span style='color:red;'>비밀번호길이가 너무 깁니다.</span>";
				exit;
			}
			else if ($passwdValue == $_POST['passwd']) {
				echo "<span style='color:red;'>변경할 비밀번호가 같습니다.</span>";
				exit;
			}
		}
		
		// 비밀번호 확인
		if ($_POST['checkPasswd']) {
			$passwdValue = $_POST['passwdValue'];
			$checkPasswd = $_POST['checkPasswd'];
			if (!preg_match('/^[A-Za-z0-9]+$/', $checkPasswd)) {
				echo "<span style='color:red;'>영어 및 숫자로만 입력해야 합니다.</span>";
				oci_close($conn);
				exit;
			}
			else if (strlen($checkPasswd) < 6) {
				echo "<span style='color:red;'>비밀번호확인은 6~20글자만 입력할 수 있습니다.</span>";
			} 
			else if (strlen($checkPasswd) > 20) {
				echo "<span style='color:red;'>비밀번호길이가 너무 깁니다.</span>";
				exit;
			}
			else if ($passwdValue != $checkPasswd) {
				echo "<span style='color:red;'>비밀번호가 같지 않습니다.</span>";
			}
			else {
				echo "<span style='color:blue;'>비밀번호확인 되었습니다.</span>";
				exit;
			}
		}
	}
?>