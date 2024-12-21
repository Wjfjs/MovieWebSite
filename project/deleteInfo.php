<?php //계정 삭제
	session_start();
	

	$userId = isset($_GET["userId"]) ? $_GET["userId"] : "";
	$memberId = isset($_GET["memberId"]) ? $_GET["memberId"] : "";
	$checkNoticeMemberId = false;
	
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
	
	$sqlSelectUsers = 'select PASSWD 
						from users
						where ID = :userId';	//notice에 값이 있는지 확인용
	
	$stidSelectUsers = oci_parse($conn, $sqlSelectUsers);
	oci_bind_by_name($stidSelectUsers, ':userId', $userId);
	oci_execute($stidSelectUsers);
	
	$count = 0;
	while (($row = oci_fetch_array($stidSelectUsers, OCI_ASSOC)) != false) {	
		$passwd[$count] = $row["PASSWD"];
		$count++;
	}
	
	$sqlSelectNotice = 'select NOTICE_MEMBER_ID 
						from notice
						where NOTICE_MEMBER_ID = :memberId';	//notice에 값이 있는지 확인용
	
	$stidSelectNotice = oci_parse($conn, $sqlSelectNotice);
	oci_bind_by_name($stidSelectNotice, ':memberId', $memberId);
	oci_execute($stidSelectNotice);
	
	while (($row = oci_fetch_array($stidSelectNotice, OCI_ASSOC)) != false) {	
		if ($memberId = $row["NOTICE_MEMBER_ID"]) {
			$checkNoticeMemberId = true;
			break;
		}
		else {
			$checkNoticeMemberId = false;
		}
		
	}
	
	oci_free_statement($stidSelectNotice);
	oci_free_statement($stidSelectUsers);
	
	$sqlAlterDropMember = 'alter table member 
							drop constraint USER_ID_FK_member';
	$sqlAlterDropManageMember = 'alter table member 
									drop constraint MANAGE_MEMBER_ID_FK';
	$sqlAlterDropNotice = 'alter table notice 
							drop constraint NOTICE_MEMBER_ID_FK';
										
	$sqlDeleteUsers = 'delete from users where ID = :inputId';
	$sqlDeleteMember = 'delete from member where USER_ID = :inputId';
	$sqlDeleteNotice = 'delete from notice where NOTICE_MEMBER_ID = :memberId';
	$sqlDeleteSearch_member = 'delete from search_member whereSEAR_MEMBER_IDID = :memberId';
				
	$sqlAlterMember = 'alter table member 
						add constraint USER_ID_FK_member 
							foreign key (USER_ID) 
								REFERENCES users (ID)';
	$sqlAlterManageMember = 'alter table member 
								add constraint MANAGE_MEMBER_ID_FK 
									foreign key (MANAGE_MEMBER_ID) 
										REFERENCES member (MEMBER_ID)';
	$sqlAlterNotice = 'alter table notice 
						add constraint NOTICE_MEMBER_ID_FK 
							foreign key (NOTICE_MEMBER_ID) 
								REFERENCES member (MEMBER_ID)';
	
	$stidAlterDropMember = oci_parse($conn, $sqlAlterDropMember);
	$stidAlterDropManageMember = oci_parse($conn, $sqlAlterDropManageMember);
	$stidAlterDropNotice = oci_parse($conn, $sqlAlterDropNotice);
	
	$stidDeleteUsers = oci_parse($conn, $sqlDeleteUsers);
	$stidDeleteMember = oci_parse($conn, $sqlDeleteMember);
	$stidDeleteNotice = oci_parse($conn, $sqlDeleteNotice);
	$stidDeleteSearch_member = oci_parse($conn, $sqlDeleteSearch_member);
	
	$stidAlterMember = oci_parse($conn, $sqlAlterMember);
	$stidAlterManageMember = oci_parse($conn, $sqlAlterManageMember);
	$stidAlterNotice = oci_parse($conn, $sqlAlterNotice);
	
	oci_bind_by_name($stidDeleteUsers, ':inputId', $userId);
	oci_bind_by_name($stidDeleteMember, ':inputId', $userId);
	oci_bind_by_name($stidDeleteNotice, ':memberId', $memberId);
	oci_bind_by_name($stidDeleteSearch_member, ':memberId', $memberId);
	
	oci_execute($stidAlterDropMember);
	oci_execute($stidAlterDropManageMember);
	
	if ($checkNoticeMemberId) {
		oci_execute($stidAlterDropNotice);
		oci_execute($stidDeleteNotice);
		oci_execute($stidAlterNotice);
	}
	
	oci_execute($stidDeleteUsers);
	oci_execute($stidDeleteMember);
	
	//oci_execute($stidDeleteSearch_member);
	oci_execute($stidAlterMember);
	oci_execute($stidAlterManageMember);
		
	
	oci_commit($conn);
	
	oci_free_statement($stidAlterDropMember);
	oci_free_statement($stidAlterDropManageMember);
	oci_free_statement($stidAlterDropNotice);
	oci_free_statement($stidDeleteUsers);
	oci_free_statement($stidDeleteMember);
	oci_free_statement($stidDeleteNotice);
	oci_free_statement($stidDeleteSearch_member);
	oci_free_statement($stidAlterMember);
	oci_free_statement($stidAlterManageMember);
	oci_free_statement($stidAlterNotice);
	
	oci_close($conn);
	
	unset($_SESSION[$userId]);
	unset($_SESSION[$passwd[0]]);
	unset($_SESSION[$memberId]);
	
	if (isset($_POST['deleteAccount'])) {
		echo "
			<script type=\"text/javascript\">
				alert(\"계정이 삭제되었습니다.\");
				location.href = 'logout.php';
			</script>
		";
	}
	
	if (isset($_POST['deleteMember'])) {
		echo "
			<script type=\"text/javascript\">
				alert(\"회원 계정이 삭제되었습니다.\");
				history.back();
			</script>
		";
	}
?>