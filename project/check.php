<style>
	body {
		margin: 0 20% auto;
	}
	#searchForm {
		margin: auto;
		margin-top: 20%;
		text-align: center;
	}
	#searchInput {
		width: 100%;
		padding: 10px;
		box-sizing: border-box;
	}
	#checkboxForm {
		margin: auto;
		width: 95%;
	}
	#listDiv {
		
		margin: 0 -15% auto;
		width: 140%;
	}
	#sqlTable {
		width: 100%;
		border-collapse: collapse;
	}
	tr td {
		border-bottom: 1px solid black;
		border-right: 1px none black;	
		text-align: left;
		padding: 2px;	
	}
	#trTitle > td {
		border-right:1px solid black;	
		text-align: center;
	}

</style>
<body>
	<form method = "post">
		<div id="searchForm">
			<input id="searchInput" type="search" name="search" role="combobox"
			placeholder="검색어 입력">
		</div>
		<div id="checkboxForm">
			<label>칼럼별</label>
			<label><input type="checkbox" name="column[]" value="movie_nm" checked="">영화명</label>
			<label><input type="checkbox" name="column[]" value="drctr_nm">감독</label>
			<label><input type="checkbox" name="column[]" value="makr_nm">제작자</label>
			<label><input type="checkbox" name="column[]" value="incme_cmpny_nm">수입회사</label>
			<label><input type="checkbox" name="column[]" value="distb_cmpny_nm">유통회사</label>
			<label><input type="checkbox" name="column[]" value="genre_nm">장르</label>
		</div>
	</form>
	<select>
		<option value="">최신순</option>
		<option value="제작연도순">제작연도순</option>
		<option value="이름순">이름순</option>
		<option value="개봉일순">개봉일순</option>
	</select>
<div id = "listDiv">
<?php
	$column = array('movie_nm', 'drctr_nm', 'makr_nm', 'incme_cmpny_nm', 'distb_cmpny_nm', 'opn_de', 'movie_ty_nm', 'movie_stle_nm', 'nlty_nm', 'tot_scrn_co', 'viewing_nmor_co', 'seoul_viewing', 'genre_nm', 'movie_sdiv_nm');
	$sqlName = "%".trans($_POST["search"])."%";
	$sqlColumn = $_POST["column"];
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');

	if ($sqlName == '%%') {
		echo "<br><B>입력값이 없습니다.</B><br>";
		$sqlNoting = 'select * from csvTest';
		echo $sqlNoting;
		$stid = oci_parse($conn, $sqlNoting);
		oci_execute($stid);
	}
	else {
		$sqlinput = 'select * from csvTest where ';
		for ($i = 0; $i < count($sqlColumn); $i++) {
			for ($j = 0; $j <= count($column); $j++) {
				if ($sqlColumn[$i] == $column[$j]) {
					$sqlinput .= $sqlColumn[$i];
					break;
				}
			}
			$sqlinput .= ' like :sqlName';
			if($i != count($sqlColumn) - 1){
				$sqlinput .= ' OR ';
			}
		}
		
		
		$stid = oci_parse($conn, $sqlinput);
		
		oci_bind_by_name($stid, ":sqlName", $sqlName);	
		echo $sqlinput;
		oci_execute($stid);
	}
?>

<?php
    $genres = array(
        '드라마',
        '액션',
        '코미디',
        '스릴러',
        '공포',
        '범죄',
        '판타지'
    );

  
   
    $selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : '';

  
   
    $searchKeyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

   
    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : '';

   
    $query = "SELECT * FROM movie WHERE genre = :genre AND (KR_NAME LIKE '%' || :keyword || '%' OR EN_NAME LIKE '%' || :keyword || '%') ORDER BY MK_DATE $sortOrder";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':genre', $selectedGenre);
    oci_bind_by_name($stmt, ':keyword', $searchKeyword);
    oci_execute($stmt);

    while (($row = oci_fetch_array($stmt, OCI_ASSOC)) != false) {
        echo "KR Name: " . $row['KR_NAME'] . "<br>";
        echo "EN Name: " . $row['EN_NAME'] . "<br>";
        echo "MK Date: " . $row['MK_DATE'] . "<br>";
        echo "Country: " . $row['COUNTRY'] . "<br>";
        echo "Screen Count: " . $row['SCRN_COUNT'] . "<br>";
        echo "View Count: " . $row['VIEW_COUNT'] . "<br>";
        echo "Genre: " . $row['GENRE'] . "<br>";
        echo "Grand: " . $row['GRAND'] . "<br>";     
    }

    oci_free_statement($stmt);
	oci_free_statement($stid);
	oci_close($conn);
?>

<?php
	function trans($a) {
		$b = preg_replace("/\s+/", "", trim($a));
		$b = strtolower($b);
		return $b;
	}
?>
</div>
</body>
