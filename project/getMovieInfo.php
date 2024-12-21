<?php
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
	$sqlSelectMovie = "SELECT * FROM movie ORDER BY no";
	$stidSelectMovie = oci_parse($conn, $sqlSelectMovie);
	oci_execute($stidSelectMovie);

	$column = array(
		'NO', 'KR_NAME', 'EN_NAME', 'DRCTR', 'MAKR', 'INCME',
		'DISTB', 'MK_DATE', 'COUNTRY', 'SCRN_COUNT', 'VIEW_COUNT',
		'GENRE', 'GRAND', 'POSTER', 'TRAILER', 'STORY', 'RUN_TIME', 'LIKE_NUM', 'OPEN_NUM', 'MANAGE_MEMBER_ID'
	);

	$tableHtml = "<div id='modalDiv'>";
	$tableHtml .= "<table id='modalTable'>";

	while (($row = oci_fetch_array($stidSelectMovie, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
		$tableHtml .= "<tr>";
		foreach ($column as $col) {
			$value = $row[$col];
			$tableHtml .= "<td style='margin-bottom: 7px;'>";
			$tableHtml .= "<span>".$col."</span>";
			$tableHtml .= "<span> : ".($value !== null ? htmlentities($value, ENT_QUOTES) : "&nbsp")."</span>";
			$tableHtml .= "</td>";
		}
		$tableHtml .= "</tr>";
	}

	$tableHtml .= "</table>";
	$tableHtml .= "</div>";

	oci_free_statement($stidSelectMovie);
	oci_close($conn);

	echo $tableHtml;
?>