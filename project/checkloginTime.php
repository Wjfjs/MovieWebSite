<?php	//로그인 시간이 2시간 이상이면 로그인 상태를 "N"으로 변경하는 코드
	session_start();
	date_default_timezone_set('Asia/Seoul');
	
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
	$sqlSelectMember = "select MEMBER_ID, USER_ID, TO_CHAR(LOGIN_DATE, 'YYYY-MM-DD HH24:MI') LOGIN_DATE
						from member
						where CHECK_LOGIN = 'Y'";
	$stidSelectMember = oci_parse($conn, $sqlSelectMember);
	oci_execute($stidSelectMember);
	
	$count = 0;
	while (($row = oci_fetch_array($stidSelectMember, OCI_ASSOC)) != false) {	
		$getUserId[$count] = $row["USER_ID"];
		$getLoginDate[$count] = $row["LOGIN_DATE"];
		$getMemberId[$count] = $row["MEMBER_ID"];
		$count++;
	}
	
	oci_free_statement($stidSelectMember);
	
	$timestamp = time();	//현재 시간
	$date = date("Y-m-d H:i", $timestamp); //현재 시간을 2023-06-14 02:52 형식으로 변환
	
	for ($i=0; $i<count($getLoginDate); $i++) {
		$loginDate = new DateTime($getLoginDate[$i]);
		$nowDate = new DateTime($date);

		$interval = $loginDate->diff($nowDate);	//시간 차이를 시간, 분 으로 구해준다

		$hours = $interval->h;
		$minutes = $interval->i;
		
		if ($hours >= 2 AND $minutes >= 0) {
			$sqlUpdateMember = "update member 
								set CHECK_LOGIN = 'N' 
								where MEMBER_ID = :memberId";
								
			$sqlSelectUsers = "select PASSWD
								from users
								where ID = :id";
								
			$stidUpdateMember = oci_parse($conn, $sqlUpdateMember);
			$stidSelectUsers = oci_parse($conn, $sqlSelectUsers);
			oci_bind_by_name($stidUpdateMember, ':memberId', $getMemberId[$i]);
			oci_bind_by_name($stidSelectUsers, ':id', $getUserId[$i]);
			oci_execute($stidUpdateMember);
			oci_execute($stidSelectUsers);
			
			$count = 0;
			while (($row = oci_fetch_array($stidSelectUsers, OCI_ASSOC)) != false) {	
				$userPasswd[$count] = $row["PASSWD"];
				$count++;
			}
			
			oci_free_statement($stidSelectUsers);
			oci_commit($conn);
			oci_free_statement($stidUpdateMember);
			
			unset($_SESSION["$getUserId[$i]"]);
			unset($_SESSION["$userPasswd[$i]"]);
			unset($_SESSION["$getMemberId[$i]"]);
		}
	}
	

	
	
	oci_close($conn);
?>