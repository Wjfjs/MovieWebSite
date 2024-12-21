<?php
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
	$searchInput = isset($_POST['searchInput']) ? $_POST['searchInput'] : '';
	$sort = $_POST['sort'];
	
	$sqlSearchMovie = "SELECT * FROM movie";
	
	if (preg_match("/^[0-9]+$/", $searchInput)) {
		$sqlSearchMovie .= " WHERE NO LIKE :searchInput";
	} 
	else if (preg_match("/^[a-zA-Z]+$/", $searchInput)) {
		$searchInput = $searchInput.'%';
		$sqlSearchMovie .= " WHERE EN_NAME LIKE :searchInput";
	}
	else if (preg_match("/[\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}]+/u", $searchInput)) {
		$searchInput = $searchInput.'%';
		$sqlSearchMovie .= " WHERE KR_NAME LIKE :searchInput";
	}
	else {
		$sqlSearchMovie = "SELECT * FROM movie";
	}
	
	if ($sort === 'asc') {
		$sqlSearchMovie .= " order by NO";
	} 
	else if ($sort === 'desc') {
		$sqlSearchMovie .= " order by NO desc";
	}
	
	$stidSearchMovie = oci_parse($conn, $sqlSearchMovie);
	
	if ($searchInput != '') {
		oci_bind_by_name($stidSearchMovie, ':searchInput', $searchInput);
	}
	
	oci_execute($stidSearchMovie);

	$column = array(
		'NO', 'KR_NAME', 'EN_NAME', 'DRCTR', 'MAKR', 'INCME',
		'DISTB', 'MK_DATE', 'COUNTRY', 'SCRN_COUNT', 'VIEW_COUNT',
		'GENRE', 'GRAND', 'POSTER', 'TRAILER', 'STORY', 'RUN_TIME', 'LIKE_NUM', 'OPEN_NUM', 'MANAGE_MEMBER_ID'
	);

	$tableHtml = "<div id='modalDiv'>";
	$tableHtml .= "<table id='modalTable'>";

	while (($row = oci_fetch_array($stidSearchMovie, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
		$tableHtml .= "<tr>";
		foreach ($column as $col) {
			$value = $row[$col];
			$tableHtml .= "<td style='margin-bottom: 7px;'>";
			$tableHtml .= "<span>" . $col . "</span>";
			$tableHtml .= "<span> : " . ($value !== null ? htmlentities($value, ENT_QUOTES) : "&nbsp") . "</span>";
			$tableHtml .= "</td>";
		}
		$tableHtml .= "</tr>";
	}

	$tableHtml .= "</table>";
	$tableHtml .= "</div>";

	oci_free_statement($stidSearchMovie);
	oci_close($conn);

	echo $tableHtml;
?>