<?php
	session_start();

	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');

	$sqlUpdate = 'update member 
					set check_login = \'N\' 
					where user_id = :inputId';
					
	$stidUpdate = oci_parse($conn, $sqlUpdate);

	oci_bind_by_name($stidUpdate, ':inputId', $_SESSION["FId"]);
	oci_execute($stidUpdate);

	oci_free_statement($stidUpdate);
	oci_commit($conn);
	oci_close($conn);

	/* 세션 삭제 */
	unset($_SESSION["FId"]);
	unset($_SESSION["FPw"]);
	unset($_SESSION["FMemberId"]);

	/* 페이지 이동 */
	echo "
		<script type=\"text/javascript\">
			alert(\"로그아웃 되었습니다.\");
			location.href = 'main.php';
		</script>
	";

?>