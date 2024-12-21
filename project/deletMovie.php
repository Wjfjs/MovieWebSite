<?php
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
    $user = $_POST['user'];
    $no = $_POST['no'];
	
	
	
	$sqlDeleteMovie = "delete from movie 
						where NO IN (:no)";
	$stidDeleteMovie = oci_parse($conn, $sqlDeleteMovie);
	oci_bind_by_name($stidDeleteMovie, ':no', $no);
	oci_execute($stidDeleteMovie);
	
	oci_commit($conn);
	oci_free_statement($stidSelectMovie);
	oci_close($conn);
?>