<?php
	session_start();
	
	$id = [];
	$passwd = [];
	$memberId = [];
	$checkLogin = [];
	$findId = '';
	$findPasswd = '';
	$findMemberId = '';
	$inputId = $_POST["id"];
	$inputPasswd = $_POST["passwd"];
	
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
	$sqlSelect = 'select u.ID, u.PASSWD, m.MEMBER_ID, m.CHECK_LOGIN from users u 
					join member m on u.ID = m.USER_ID
					where u.ID = :inputId';
	$stidSelect = oci_parse($conn, $sqlSelect);
	oci_bind_by_name($stidSelect, ':inputId', $inputId);
	oci_execute($stidSelect);
	
	$count = 0;
	while (($row = oci_fetch_array($stidSelect, OCI_ASSOC)) != false) {	
		$id[$count] = $row["ID"];
		$passwd[$count] = $row["PASSWD"];
		$memberId[$count] = $row["MEMBER_ID"];
		$checkLogin[$count] = $row["CHECK_LOGIN"];
		$count++;
	}
	
	if ($checkLogin[0] == "Y") {
		echo "
			<script type=\"text/javascript\">
				alert(\"이미 로그인 되어있습니다.\");
				history.back();
			</script>
			";
		exit;
	}
	
	if (preg_match('/^[A-Za-z0-9_]+$/', $inputId) AND preg_match('/^[A-Za-z0-9_]+$/', $inputPasswd)) {
		if (!count($id)) {	//등록된거 찾기
			$_SESSION["FErrorStack"] = 0;
			$_SESSION["FErrorStack"] += 1;
			echo "
			<script type=\"text/javascript\">
				alert(\"등록되지 않은 아이디입니다.\");
				history.back();
			</script>
			";
			exit;
		}
		else {
			for ($i=0; $i<count($id); $i++) {	//같은지 확인
				if ($id[$i] == $inputId) {
					$findId = $id[$i];
					$findPasswd = $passwd[$i];
					$findMemberId = $memberId[$i];
				}
			}
			
				
			
			if($findId == $inputId AND $findPasswd == $inputPasswd) {	//로그인 성공
				$sqlUpdate = 'update member 
								set check_login = \'Y\', login_date = SYSDATE 
								where user_id = :inputId';
								
				$stidUpdate = oci_parse($conn, $sqlUpdate);
				oci_bind_by_name($stidUpdate, ':inputId', $inputId);
				oci_execute($stidUpdate);
				
				oci_free_statement($stidSelect);
				
				oci_commit($conn);
				oci_close($conn);
				
				$_SESSION["FId"] = $findId;
				$_SESSION["FPw"] = $findPasswd;
				$_SESSION["FMemberId"] = $findMemberId;
				
				unset($_SESSION["FErrorStack"]);
				
				if(isset($_SERVER['HTTP_REFERER'])){
					$previousPage = $_SERVER['HTTP_REFERER'];
					echo "
						<script type=\"text/javascript\">
							alert(\"로그인 되었습니다.\");
							location.href = 'main.php';
						</script>
					";
				}
				else {
					echo "
						<script type=\"text/javascript\">
							location.href = 'main.php';
						</script>
					";
				}
			}
			else {	//로그인 실패
				if (!isset($_SESSION["FErrorStack"])) { // 변수가 선언되지 않았을 때 초기화
					$_SESSION["FErrorStack"] = 0;
				}
			
				if ($_SESSION["FErrorStack"] >= 5) {
					echo "
					<script type=\"text/javascript\">
						alert(\"계정을 찾아보세요\");
						history.back();
					</script>
					";
				}
				else {
					$_SESSION["FErrorStack"] += 1;
					echo "
					<script type=\"text/javascript\">
						alert(\"아이디와 비밀번호를 다시 확인하세요.\");
						history.back();
					</script>
					";
				}
				exit;
			}	
		}
	}
	else {
		echo "
		<script type=\"text/javascript\">
			alert(\"아이디와 비밀번호는 영어 및 숫자로만 입력해야 합니다.\");
			history.back();
		</script>
		";
		exit;
	}

?>