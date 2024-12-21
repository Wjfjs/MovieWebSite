<?php
	session_start();
	date_default_timezone_set('Asia/Seoul');	
	
	if ($_POST['contentsInput'] != '') {
		$memberId = $_SESSION["FMemberId"];
		$movieNo = $_SESSION["movieNo"];
		$countContents = $_SESSION["countContents"];
		$countContents++;
		$contents = $_POST['contentsInput'];
		$update = date('Y-m-d H:i:s');
		$getUpdate = unserialize($_SESSION["update"]);
		$getUpdate[$countContents] = $update;
		$_SESSION["update"] = serialize($getUpdate);
		
		$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'AL32UTF8');
		$sqlInsertNotice = 'insert into notice (NOTICE_MEMBER_ID, CONTENTS, MOVIE_NO) 
							values(:memberId , :contents, :movieNo)';
							
		$stidInsertNotice = oci_parse($conn, $sqlInsertNotice);
		oci_bind_by_name($stidInsertNotice, ':memberId', $memberId);
		oci_bind_by_name($stidInsertNotice, ':contents', $contents);
		oci_bind_by_name($stidInsertNotice, ':movieNo', $movieNo);
		oci_execute($stidInsertNotice);
		
		oci_commit($conn);
		oci_free_statement($stidInsertNotice);
		oci_close($conn);
		
		unset($_SESSION["countContents"]);
		// 성공적으로 댓글을 작성한 후, 새로운 댓글을 화면에 추가합니다.
		 echo json_encode(array(
			'user' => $_SESSION["FId"],
			'contents' => $contents,
			'update' => $update,
			'movieNo' => $movieNo,
			'movieI' => $countContents
		));
	}
?>