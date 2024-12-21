<?php
	session_start();	
	date_default_timezone_set('Asia/Seoul');
	
	$movieNo = $_GET['movieNo'];
	$i = $_GET['i'];
	$memberId = $_SESSION["FMemberId"];
	$getUpdate = unserialize($_SESSION["update"]);
	$update = date('Y-m-d H:i:s', strtotime($getUpdate[$i]));
	
	if (isset($memberId)) {
		if ($memberId == '000') {
			$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'AL32UTF8');
		
			$sqlDeleteNotice = "delete from notice 
								where MOVIE_NO = :movieNo 
									AND UP_DATE = TO_DATE(:upd, 'YYYY-MM-DD HH24:MI:SS')
									AND MANAGE_MEMBER_ID = :memberId";
								
			$stidDeleteNotice = oci_parse($conn, $sqlDeleteNotice);
			oci_bind_by_name($stidDeleteNotice, ':movieNo', $movieNo);
			oci_bind_by_name($stidDeleteNotice, ':upd', $update);
			oci_bind_by_name($stidDeleteNotice, ':memberId', $memberId);
			
			oci_execute($stidDeleteNotice);
			
			unset($_SESSION["update"]);
			oci_commit($conn);
			oci_free_statement($stidDeleteNotice);
			oci_close($conn);
		}
		else {
			$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'AL32UTF8');
		
			$sqlDeleteNotice = "delete from notice 
								where MOVIE_NO = :movieNo 
									AND UP_DATE = TO_DATE(:upd, 'YYYY-MM-DD HH24:MI:SS')
									AND NOTICE_MEMBER_ID = :memberId";
								
			$stidDeleteNotice = oci_parse($conn, $sqlDeleteNotice);
			oci_bind_by_name($stidDeleteNotice, ':movieNo', $movieNo);
			oci_bind_by_name($stidDeleteNotice, ':upd', $update);
			oci_bind_by_name($stidDeleteNotice, ':memberId', $memberId);
			
			oci_execute($stidDeleteNotice);
			
			unset($_SESSION["update"]);
			oci_commit($conn);
			oci_free_statement($stidDeleteNotice);
			oci_close($conn);
		}
	}
?>