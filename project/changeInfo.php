<?php
	session_start();
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');

		// 아이디 중복 체크
		if ($_POST['idValue'] != '') {
			$userId = $_SESSION["FId"];
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
				$sqlAlterDropMember = 'alter table member 
										drop constraint USER_ID_FK_member';
				
				$sqlUpdateMember = 'update member set USER_ID = :inputId where USER_ID = :userId';
								
				$sqlUpdateUsersId = 'update users set ID = :inputId where ID = :userId';
				
				$sqlAlterMember = 'alter table member 
										add constraint USER_ID_FK_member 
											foreign key (USER_ID) 
												REFERENCES users (ID)';
				
				$stidAlterDropMember = oci_parse($conn, $sqlAlterDropMember);
				$stidUpdateMember = oci_parse($conn, $sqlUpdateMember);
				$stidUpdateUsersId = oci_parse($conn, $sqlUpdateUsersId);
				$stidAlterMember = oci_parse($conn, $sqlAlterMember);
				
				oci_bind_by_name($stidUpdateMember, ':inputId', $idValue);
				oci_bind_by_name($stidUpdateMember, ':userId', $userId);
				
				oci_bind_by_name($stidUpdateUsersId, ':inputId', $idValue);
				oci_bind_by_name($stidUpdateUsersId, ':userId', $userId);
				
				oci_execute($stidAlterDropMember);
				oci_execute($stidUpdateMember);
				oci_execute($stidUpdateUsersId);
				oci_execute($stidAlterMember);
				
				oci_free_statement($stidAlterDropMember);
				oci_free_statement($stidUpdateMember);
				oci_free_statement($stidUpdateUsersId);
				oci_free_statement($stidAlterMember);
				
				
				oci_commit($conn);
				oci_close($conn);
				
				$_SESSION["FId"] = $idValue;
				echo "success";
				exit;
			}
			
			
		}

		// 이메일 중복 체크
		if ($_POST['emailValue'] != '') {
			$userId = $_SESSION['FId'];
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
				$sqlUpdateUsersEmail = 'update users set EMAIL = :inputEmail where ID = :userId';
				$stidUpdateUsersEmail = oci_parse($conn, $sqlUpdateUsersEmail);
				
				oci_bind_by_name($stidUpdateUsersEmail, ':inputEmail', $emailValue);
				oci_bind_by_name($stidUpdateUsersEmail, ':userId', $userId);
				
				oci_execute($stidUpdateUsersEmail);
				oci_free_statement($stidUpdateUsersEmail);
				
				oci_commit($conn);
				oci_close($conn);
				
				echo "success";
				exit;
			}
		}
		
		// 비밀번호 오류 체크
		if ($_POST['passwdValue'] != '' AND $_POST['checkPasswd'] != '') {
			$userId = $_SESSION["FId"];
			$passwdValue = $_POST['passwdValue'];
			$checkPasswd = $_POST['checkPasswd'];
			$findPasswd = [];

			$sqlSelectPasswd = 'select PASSWD from users where ID = :inputId';
			$stidSelectPasswd = oci_parse($conn, $sqlSelectPasswd);
			oci_bind_by_name($stidSelectPasswd, ':inputId', $userId);
			oci_execute($stidSelectPasswd);

			$count = 0;
			while (($row = oci_fetch_array($stidSelectPasswd, OCI_ASSOC)) != false) {
				$findPasswd[$count] = $row["PASSWD"];
				$count++;
			}

			oci_free_statement($stidSelectPasswd);
			
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
			}
			else if ($passwdValue == $findPasswd[0]) {
				echo "<span style='color:red;'>변경할 비밀번호가 같습니다.</span>";
				oci_close($conn);
				exit;
			}
			else if ($passwdValue != $checkPasswd) {
				echo "<span style='color:red;'>비밀번호가 같지 않습니다.</span>";
				oci_close($conn);
				exit;
			}
			else {
				$sqlUpdateUsersPasswd = 'update users set PASSWD = :inputPasswd where ID = :userId';
				$stidUpdateUsersPasswd = oci_parse($conn, $sqlUpdateUsersPasswd);
				
				oci_bind_by_name($stidUpdateUsersPasswd, ':inputPasswd', $passwdValue);
				oci_bind_by_name($stidUpdateUsersPasswd, ':userId', $userId);
				
				oci_execute($stidUpdateUsersPasswd);
				oci_free_statement($stidUpdateUsersPasswd);
				
				oci_commit($conn);
				oci_close($conn);
				
				unset($_SESSION["FPw"]);
				$_SESSION["FPw"] = $passwdValue;
				
				echo "success";
				exit;
			}
		}
	}
?>