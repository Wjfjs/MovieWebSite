<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// 이메일 중복 체크
		if (isset($_POST['emailValue'])) {
			$emailValue = $_POST['emailValue'];

			if (!preg_match('/^[A-Za-z0-9]+@[A-Za-z]+\.(com)$/', $emailValue)) {
				echo "<span style='color:red;'>유효하지 않은 이메일 주소입니다.</span>";
				exit;
			} else {
				echo "";
			}
		}
		
		
		if (isset($_POST['findValue'])) {
			$findId = [];
			$findEmail = [];
			$findPasswd = [];
			$inputEmail = $_POST['findValue'];
			
			$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
			$sqlSelect = 'select ID, EMAIL, PASSWD from users 
							where EMAIL = :inputEmail';
								
			$stidSelect = oci_parse($conn, $sqlSelect);
			oci_bind_by_name($stidSelect, ':inputEmail', $inputEmail);
			
			oci_execute($stidSelect);
			
			$count = 0;
			while (($row = oci_fetch_array($stidSelect, OCI_ASSOC)) != false) {
				$findId[$count] = $row["ID"];
				$findEmail[$count] = $row["EMAIL"];
				$findPasswd[$count] = $row["PASSWD"];
				$count++;
			}
			
			if (!isset($findId[0], $findEmail[0], $findPasswd[0])) {
				echo "<span style='color:red;'>아이디와 비밀번호가 없습니다.</span>";
				oci_close($conn);
				exit;
			}
			
			if ($findId[0] != null OR $findEmail[0] != null) {
				echo "아이디: " . ($findId[0] ? $findId[0] : "설정되지 않음") . "<br> 이메일: " . ($findEmail[0] ? $findEmail[0] : "설정되지 않음") . "<br> 비밀번호: " . ($findPasswd[0] ? $findPasswd[0] : "설정되지 않음");
				oci_free_statement($stidSelect);
				oci_close($conn);
			}
			else {
				echo "<span style='color:red;'>이메일을 입력해야 합니다.</span>";
			}
		}

	}
?>