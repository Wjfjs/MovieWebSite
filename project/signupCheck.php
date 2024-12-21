<?php
	$findId = [];
	$findEmail = [];
	$inputId = $_POST["id"];
	$inputEmail = $_POST["email"];
	$inputPasswd = $_POST["passwd"];
	$inputVerifyPasswd = $_POST["verifyPasswd"];
	
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
	$sqlSelectID = 'select ID from users';
	$sqlSelectEMAIL = 'select EMAIL from users';
					
	$stidSelectID = oci_parse($conn, $sqlSelectID);
	$stidSelectEMAIL = oci_parse($conn, $sqlSelectEMAIL);
	
	oci_execute($stidSelectID);
	oci_execute($stidSelectEMAIL);
	
	$count = 0;
	while (($row = oci_fetch_array($stidSelectID, OCI_ASSOC)) != false) {	
		$findId[$count] = $row["ID"];
		$count++;
	}
	
	$count = 0;
	while (($row = oci_fetch_array($stidSelectEMAIL, OCI_ASSOC)) != false) {	
		$findEmail[$count] = $row["EMAIL"];
		$count++;
	}
	
	oci_free_statement($stidSelectID);
	oci_free_statement($stidSelectEMAIL);
	oci_close($conn);
	
	if (!preg_match('/^[A-Za-z0-9_]+$/', $inputId)) {
		echo "
			<script type=\"text/javascript\">
				alert(\"아이디는 영어 및 숫자로만 입력해야 합니다.\");
				history.back();
			</script>
		";
		exit;
	}
	else {
		$checkId = true;
		foreach ($findId as $id) {
			if ($inputId == $id) {
				$checkId = false;
				break;
			}
		}
	}
	
	if (!preg_match('/^[A-Za-z0-9_]+@[A-Za-z]+\.(com)$/', $inputEmail)) {
		echo "
			<script type=\"text/javascript\">
				alert(\"유효하지 않은 이메일 주소입니다.\");
				history.back();
			</script>
		";
		exit;
	}
	else {
		$checkEmail = true;
		foreach ($findEmail as $email) {
			if ($inputEmail == $email) {
				$checkEmail = false;
				break;
			}
		}
	}
	
	if (!preg_match('/^[A-Za-z0-9_]+$/', $inputPasswd)) {
		echo "
			<script type=\"text/javascript\">
				alert(\"비밀번호는 영어 및 숫자로만 입력해야 합니다.\");
				history.back();
			</script>
		";
		exit;
	}
	
	if ($checkId) {
		
		if ($checkEmail) {
			
			if ($inputPasswd == $inputVerifyPasswd) {
				
				$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
				
				$sqlSelect = 'select MEMBER_ID from member';
				
				$stidCount = oci_parse($conn, $sqlSelect);
				oci_execute($stidCount);
				
				$count = 0;
				while (($row = oci_fetch_array($stidCount, OCI_ASSOC)) != false) {	
					$find[$count] = $row["MEMBER_ID"];
					$count++;
				}
				
				$manageId = '000';
				$memberNum = sprintf('%03d', count($find)+1);
				
				$sqlusers = 'insert into users (ID, PASSWD, EMAIL) 
								values(:getId, :getpasswd, :getEmail)';
								
				$sqlMember = 'insert into member (MEMBER_ID, user_id, manage_member_id) 
								values(:getMemberId, :getId, :getManageId)';
				
				$stidusers = oci_parse($conn, $sqlusers);
				$stidMember = oci_parse($conn, $sqlMember);
				
				oci_bind_by_name($stidusers, ':getId', $inputId);
				oci_bind_by_name($stidusers, ':getpasswd', $inputPasswd);
				oci_bind_by_name($stidusers, ':getEmail', $inputEmail);
				oci_bind_by_name($stidMember, ':getMemberId', $memberNum);
				oci_bind_by_name($stidMember, ':getId', $inputId);
				oci_bind_by_name($stidMember, ':getManageId', $manageId);
				
				oci_execute($stidusers);
				oci_execute($stidMember);
				
				oci_free_statement($stidCount);
				oci_free_statement($stidusers);
				oci_free_statement($stidMember);
				
				oci_commit($conn);
				oci_close($conn);
				
				echo "
					<script type=\"text/javascript\">
						alert(\"회원가입 되었습니다.\");
						location.href = \"login.php\";
					</script>
				";
				
			}
			else {
				echo "
					<script type=\"text/javascript\">
						alert(\"비밀번호가 같지않습니다.\");
						history.back();
					</script>
				";
			}
			
		} else {
			echo "
				<script type=\"text/javascript\">
					alert(\"중복된 이메일입니다.\");
					history.back();
				</script>
			";
		}
		
	} else {
		echo "
			<script type=\"text/javascript\">
				alert(\"중복된 아이디입니다.\");
				history.back();
			</script>
		";
	}
?>
