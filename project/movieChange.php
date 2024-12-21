<?php
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
	$user = $_POST['user'];
	$no = $_POST['no'];
	
	$sqlSelectMovie = "select MANAGE_MEMBER_ID
				from movie
				where NO = :no";
	
	$stidSelectMovie = oci_parse($conn, $sqlSelectMovie);
	oci_bind_by_name($stidSelectMovie, ':no', $no);
	oci_execute($stidSelectMovie);
	
	$count = 0;
	while (($row = oci_fetch_array($stidSelectMovie, OCI_ASSOC)) != false) {	
		$getId[$count] = $row["MANAGE_MEMBER_ID"];
		$count++;
	}
	$manage = explode(',', trim($getId[0]));
	
	oci_free_statement($stidSelectMovie);

	if (!empty($no) && in_array($user, $manage)) {
		$fields = array(
			'krName' => 'KR_NAME',
			'enName' => 'EN_NAME',
			'drctr' => 'DRCTR',
			'makr' => 'MAKR',
			'incme' => 'INCME',
			'distb' => 'DISTB',
			'mkDate' => 'MK_DATE',
			'country' => 'COUNTRY',
			'scrnCount' => 'SCRN_COUNT',
			'viewCount' => 'VIEW_COUNT',
			'genre' => 'GENRE',
			'grand' => 'GRAND',
			'poster' => 'POSTER',
			'trailer' => 'TRAILER',
			'story' => 'STORY',
			'runTime' => 'RUN_TIME',
			'likeNum' => 'LIKE_NUM',
			'openNum' => 'OPEN_NUM',
			'manageId' => 'MANAGE_MEMBER_ID'
		);

		foreach ($fields as $input => $column) {
			if (!empty($_POST[$input])) {
				$value = $_POST[$input];
				$sqlUpdateMovie = "UPDATE movie SET $column = :value WHERE NO = :no";
				$stidUpdateMovie = oci_parse($conn, $sqlUpdateMovie);
				oci_bind_by_name($stidUpdateMovie, ':value', $value);
				oci_bind_by_name($stidUpdateMovie, ':no', $no);
				oci_execute($stidUpdateMovie);
				oci_free_statement($stidUpdateMovie);
			}
		}

		oci_commit($conn);
	}

	oci_close($conn);
?>