<?php
	session_start();
	include 'checkloginTime.php';
	header('Content-Type: text/html; charset=utf-8');
?>
<html>
	<style type="text/css">
		.title {
			text-align: center;
			font-size: 3em;
		}
		.title a::after {
			position: absolute; 
			content:""; 
			display: block; 
			border-bottom: 2px solid #000; 
			transition: all 250ms ease-out; 
			left: 50%; 
			width: 0;
		}
		.title a:hover::after {
			transition: all 250ms ease-out; 
			left: 0%; 
			width: 100%;
		}
		.LOGOUT , .USERINFO, .ADMIN {
			float: right;
			margin-bottom: 10px;
			text-decoration: none;
			color: black;
			background-color: white;
			border: none;
			cursor: pointer;
		}
		.ADMIN, .USERINFO {
			margin-right: 25px;
		}
		.LOGIN, .SIGNUP {
			display: inline-block;
			float: right;
			margin-right: 17px;
			background-color: white;
			border: none;
			cursor: pointer;
		}
		#loginP {
			margin-right: 3%;
			text-align: right;
		}
		.loginForm {
			margin: 22% 0%;
		}
		a {
			text-decoration: none;
			color: black;
		}
		body {
			margin: 0;
			padding: 0;
			position: relative;
			height: 2300px;
		}
		}
		#loginDiv {
			margin-top: 21px;
			text-align: right;
			width: 100%;
			height: 165px;
			position: absolute;
			top: 0;
		}
		#searchDiv {
			background: lightsteelblue;;
			height: 129px;
			width: 100%;
			position: absolute;
			top: 186px;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		#listDiv {
			margin: 0% 0% auto;
			width: 100%;
			height: auto;
			position: absolute;
			top: 333px;
			left: 0%;
			display: flex;
			flex-direction: column;
			flex-wrap: wrap;
			align-content: center;
		}
		#searchSubmit {
			margin-left: 4px;
			width: 5%;
		}
		#searchForm {
			width: 100%;
			max-width: 1200px;
		}
		#searcInputhDiv {
			margin: 0% 0% 1% 0%;
			text-align: center;
			display: flex;
		}
		#searchInput {
			width: 109%;
			padding: 10px;
			box-sizing: border-box;
		}
		#checkboxForm {
			text-align: left;
			margin: 0% 0% 1%;
			width: auto;
		}
		#selectForm {
			margin-right: 1%;
			text-align: left;
			float: left;
			width: 7%;
		}
		#mainTable {
			width: 100%;
			height: 50%;
			text-align: center;
		}
		#upperTable, #bottomTable {
			display: inline-block;
			border-collapse: collapse;
			width: 100%;
			height: 100%;
		}
		#upperTable, #bottomTable tr {
			width: 100%;
			height: 100%;
		}
		#bottomTable td {
			padding: 5px;
		}
		#upperTable td {
			border-bottom: 1px solid black;
			border-right: 1px solid black;	
			text-align: left;
			padding: 2px;
			width: 100px;
		}
		#upperTable td:last-child {
			border-bottom: 1px solid black;
			width: 800px;
		}
		#upperTable tr:last-child, #upperTable p {
			height: 173px;
		}
		#upperTable p {
			overflow-y: auto;
		}
		#imgTable {
			display: inline-block;
		}
		#posterImg {
			width: 200px;
			height: 300px;
			object-fit: cover;
			max-width: 200px;
			max-height: 300px;
		}
		#likeImgTr {
			padding: 0px;
		}
		#likeImg {
			height: auto;
			width: 40px;
		}
		#likeButton {
			background: no-repeat;
			width: 10%;
			height: 10%;
			border: 0;
			outline: 0;
			cursor: pointer;
		}
		#movieBox {
			width: 900px;
			height: 300px;
			display: flex;
			align-items: flex-start;
			flex-direction: row;
			justify-content: flex-start;
		}
		#bottomDiv {
			text-align: center;
			margin-top: 5px;
			margin-bottom: 10px;
		}
		section {
			height: 100vh;
			display: block;
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
		}
		#pageDiv {
			text-align: center;
		}
		.pageLink {
			margin-right: 10px;
		}
		.credit {
			position: absolute;
			left: 0px;
			width: 100%;
			margin-top: 30px;
			height: auto;
			background-color: lightcoral;
			clear: both;
			padding: 4px;
			text-align: left;
			float: left;
		}
		#c1 {
			display: inline-block;
			margin-left: 200px;
		}
		#c2 {
			display: inline-block;
			text-align: right;
			float: right;
			margin-right: 200px;
		}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
		//삭제 버튼
		function likeButton(movieNO) {
			var id = '<?php echo $_SESSION['FId']; ?>';
			if (id == '') {
				alert("로그인이 필요합니다.");
			}
			else {
				$.ajax({
					url: 'checkLike.php?movieNO',
					type: 'POST',
					data: { movieNO: movieNO },
					success: function(response) {
						location.reload();
					}
				});
			}
		}
	</script>

	<head>
		<title>영화 정보 사이트</title>	
		<script type="text/javascript" src="main.js"></script>
		<script type="text/javascript" src="randomRecommender.js"></script>
	</head>
	<body>
		<?php
			{
				$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'AL32UTF8');

				$searchInput = isset($_POST['search']) ? trim($_POST['search']) : '';
				$column = isset($_POST['column']) ? $_POST['column'] : array();
				$sort = isset($_POST['sort']) ? $_POST['sort'] : '';

				$sqlInput = 'SELECT * FROM movie';

				if (!empty($searchInput) || !empty($column)) {
					$conditions = array();
					$genreConditions = array();

					if (!empty($searchInput)) {
						$searchName = "%" . str_replace(' ', '', strtolower($searchInput)) . "%";
						$conditions[] = "LOWER(REPLACE(KR_NAME, ' ', '')) LIKE :searchName OR LOWER(REPLACE(EN_NAME, ' ', '')) LIKE :searchName";
					}

					if (!empty($column)) {
						foreach ($column as $key => $genre) {
							$genreConditions[] = "GENRE LIKE '%' || :genre{$key} || '%'";
						}
					}

					if (!empty($conditions) && !empty($genreConditions)) {
						$sqlInput .= " WHERE (" . implode(" AND ", $conditions) . ") AND (" . implode(" OR ", $genreConditions) . ")";
					} elseif (!empty($conditions)) {
						$sqlInput .= " WHERE " . implode(" AND ", $conditions);
					} elseif (!empty($genreConditions)) {
						$sqlInput .= " WHERE " . implode(" OR ", $genreConditions);
					}
				}

				if ($sort == 'RUN_TIME') {
					$sqlInput .= ' ORDER BY RUN_TIME';
				} elseif ($sort == "VIEW_COUNT") {
					$sqlInput .= ' ORDER BY VIEW_COUNT';
				}  elseif ($sort == "EN_NAME") {
					$sqlInput .= ' ORDER BY EN_NAME';
				}  elseif ($sort == "LIKE_NUM") {
					$sqlInput .= ' ORDER BY LIKE_NUM';
				} elseif ($sort == "OPEN_NUM") {
					$sqlInput .= ' ORDER BY OPEN_NUM';
				} elseif ($sort == "MK_DATE") {
					$sqlInput .= ' ORDER BY MK_DATE DESC';
				} else {
					$sqlInput .= ' ORDER BY KR_NAME';
				}

				$stid = oci_parse($conn, $sqlInput);

				if (!empty($searchInput)) {
					oci_bind_by_name($stid, ':searchName', $searchName);
				}

				if (!empty($column)) {
					foreach ($column as $key => $genre) {
						oci_bind_by_name($stid, ":genre{$key}", $column[$key]);
					}
				}

				oci_execute($stid);

				$count = 0;
				$title = ['한글 제목: ', '영어 제목: ', '제작 연도: ', '관람 연령: ', '장르: ', '줄거리'];
				$movieNO = array();
				$krName = array();
				$enName = array();
				$mkDate = array();
				$grand = array();
				$genre = array();
				$poster = array();
				$likeNum = array();
				$story = array();
				
				while (($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
					$movieNO[$count] = $row["NO"];
					$krName[$count] = $row["KR_NAME"];
					$enName[$count] = $row["EN_NAME"];
					$mkDate[$count] = $row["MK_DATE"];
					$grand[$count] =  $row["GRAND"];
					$genre[$count] =  $row["GENRE"];
					$poster[$count] = $row["POSTER"];
					$likeNum[$count] = $row["LIKENUM"];
					$story[$count] = $row["STORY"];
					$count++;
				}
				
				oci_free_statement($stid);
			}
		?>
		<div id = "loginDiv">	<!-- 로그인, 제목 -->
			<div class="title"><a href="main.php">MIS</a></div><br>
			
			<?php //로그인, 로그아웃 기능
				session_start();

				$id = isset($_SESSION["FId"]) ? $_SESSION["FId"] : "";
				$memberId = isset($_SESSION["FMemberId"]) ? $_SESSION["FMemberId"] : "";
				
				if(!$id){	//로그인 전
			?>
				<p id = "loginP">
					<a href="login.php" class="LOGIN">로그인</a>
					<a href="signup.php" class="LOGIN">회원가입</a>
				</p>
			<?php 
				} else{	//로그인 후 
			?>
				<p id = "loginP">
					"<?php 
						echo $id; 
					?>"님, 안녕하세요.
				</p>
				<p id = "loginP">
					<?php 
						if($memberId == "000"){	//관리자
					?>
							<a href="logout.php" class="LOGOUT">로그아웃</a>
							<a href="admin.php" class="ADMIN">관리자</a>
					
					<?php 
						} else {	//회원
					?>
							<a href="logout.php" class="LOGOUT">로그아웃</a>
							<a href="userInfo.php" class="USERINFO">정보수정</a>
					<?php 
						};
					?>
				</p>
				
			<?php 
				};
			?>
		
		</div>
		
		<div id="searchDiv">	<!-- 검색창, 체크박스, 옵션 -->
			<form method="post" id="searchForm">
				<div id="searcInputhDiv">	<!-- 검색창 -->
					<input id="searchInput" type="search" name="search" role="combobox" placeholder="검색어 입력" value="<?php echo isset($_POST['search']) ? htmlentities($_POST['search']) : ''; ?>">
					<input id="searchSubmit" type="submit" value="검색">
				</div>
				<div id="checkboxForm">	<!-- 체크박스 -->
					<label>장르별</label>
					<label><input type="checkbox" name="column[]" value="액션" <?php if (in_array("액션", $column)) echo 'checked'; ?>>액션</label>
					<label><input type="checkbox" name="column[]" value="드라마" <?php if (in_array("드라마", $column)) echo 'checked'; ?>>드라마</label>
					<label><input type="checkbox" name="column[]" value="다큐멘터리" <?php if (in_array("다큐멘터리", $column)) echo 'checked'; ?>>다큐멘터리</label>
					<label><input type="checkbox" name="column[]" value="미스터리" <?php if (in_array("미스터리", $column)) echo 'checked'; ?>>미스터리</label>
					<label><input type="checkbox" name="column[]" value="애니메이션" <?php if (in_array("애니메이션", $column)) echo 'checked'; ?>>애니메이션</label>
					<label><input type="checkbox" name="column[]" value="공포(호러)" <?php if (in_array("공포(호러)", $column)) echo 'checked'; ?>>공포(호러)</label>
					<label><input type="checkbox" name="column[]" value="멜로/로맨스" <?php if (in_array("멜로/로맨스", $column)) echo 'checked'; ?>>멜로/로맨스</label>
					<label><input type="checkbox" name="column[]" value="SF" <?php if (in_array("SF", $column)) echo 'checked'; ?>>SF</label>
				</div>
				<div id="optionForm">	<!-- 정렬 -->
					<select name="sort">
						<option value="">기본</option>
						<option value="RUN_TIME" <?php if ($sort == 'RUN_TIME') echo 'selected'; ?>>상영시간</option>
						<option value="LIKE_NUM" <?php if ($sort == 'LIKE_NUM') echo 'selected'; ?>>좋아요순</option>
						<option value="OPEN_NUM" <?php if ($sort == 'OPNE_NUM') echo 'selected'; ?>>조회순</option>
						<option value="VIEW_COUNT" <?php if ($sort == 'VIEW_COUNT') echo 'selected'; ?>>관객수</option>
						<option value="EN_NAME" <?php if ($sort == 'EN_NAME') echo 'selected'; ?>>알파벳순</option>
						<option value="MK_DATE" <?php if ($sort == 'MK_DATE') echo 'selected'; ?>>제작연도순</option>
					</select>
				</div>
			</form>
		</div>
		
	<?php	//좋아요 기능
		$checkLogin = [];	//로그인 확인
		$likeImg = ['like', 'afterLike'];	//좋아요 이미지
		$checkLike = 0;
		
		$sqlSelectMember = 'select CHECK_LOGIN, LIKE_MOVIE_NO
						from member
						where USER_ID = :id';

		$stidSelectMember = oci_parse($conn, $sqlSelectMember);
		oci_bind_by_name($stidSelectMember, ':id', $id);
		oci_execute($stidSelectMember);

		$count = 0;
		while (($row = oci_fetch_array($stidSelectMember, OCI_ASSOC)) != false) {    
			$checkLogin[$count] = $row["CHECK_LOGIN"];
			$likeMovie[$count] = $row["LIKE_MOVIE_NO"];
			$count++;
		}
		
		oci_free_statement($stidSelectMember);
		
	?>
		
	<?php	//영화 정보 나열
		$dataPerPage = 5; // 한 페이지에 표시할 데이터 수
		$totalItems = count($krName); // 총 데이터 수
		$totalPages = ceil($totalItems / $dataPerPage); // 총 페이지 수

		if (!isset($_GET['page'])) {
			$currentPage = 1;
		} else {
			$currentPage = $_GET['page'];
		}

		$startIndex = ($currentPage - 1) * $dataPerPage; //0
		$endIndex = min($startIndex + $dataPerPage, $totalItems);

		echo "<div id='listDiv'>";	//영화 총 데이터 표시

		for ($i = $startIndex; $i < $endIndex; $i++) {
			if (!$id) {	//로그인한 유저인지 확인
				$checkLike = 0;
			}
			else {
				$findNo = '';
				$likeNo = explode(',', trim($likeMovie[0]));
				
				foreach ($likeNo as $no) {
					if ($movieNO[$i] == $no) {
						$findNo = $no;
					}
				}

				if ($findNo == $movieNO[$i]) {	//메인에 표시할 이미지의 정하기위해
					$checkLike = 1;
				} 
				else {
					$checkLike = 0;
				}
			}
			
			echo "<div id='movieBox'>";
				echo "<table id=\"imgTable\">";	//영화 포스터 표시
					echo "<tr>";
						echo "<td><a href='movie.php?NO=" . $movieNO[$i] . "'><img id='posterImg' src='IMAGE/" . $poster[$i] . "'/></a></td>";
					echo "</tr>";
				echo "</table>";

				echo "<table id='upperTable'>";	//영화 정보 표시
					echo "<tr>";
						echo "<td>" . $title[0] . "</td>";
						echo "<td><a href='movie.php?NO=" . $movieNO[$i] . "'>" . $krName[$i] . "</a></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>" . $title[1] . "</td>";
						echo "<td><a href='movie.php?NO=" . $movieNO[$i] . "'>" . $enName[$i] . "</a></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>" . $title[2] . "</td>";
						echo "<td>" . $mkDate[$i] . "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>" . $title[3] . "</td>";
						echo "<td>" . $grand[$i] . "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>" . $title[4] . "</td>";
						echo "<td><a href='movie.php'>" . $genre[$i] . "</a></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>" . $title[5] . "</td>";
						echo "<td><p>" . $story[$i] . "</p></td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";

			echo "<div id='bottomDiv'>";	//영화 등급, 좋아요 표시
				echo "<table id='bottomTable'>";
					echo "<tr id='likeImgTr'>";
						echo "<td><img id='likeImg' src='IMAGE/" . $grand[$i] . "'/></td>";
							echo "<td>";
									//좋아요 표시
									echo "<button id='likeButton' type='button' name='likeButton' onclick='likeButton({$movieNO[$i]})'>";
										echo "<img style='width: 40px; height: auto; ' src='IMAGE/".$likeImg[$checkLike].".png'>";
									echo "</button>";
							
							echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";
		}
			echo "<div id='pageDiv'>";	//페이지 숫자 표시
				for ($page = 1; $page <= $totalPages; $page++) {
					echo "<a class='pageLink' href='?page=" . $page . "'>" . $page . "</a>";
				}
				echo '<footer class="credit">
					<div id="c1">
						참고자료
						<p>
							나무위키 / ChatGPT
						</p>
					</div>
					<div id="c2">
						만든이
						<p>
							7조 윤희혁 / 조민혁
						</p>
					</div>
				</footer>';
			echo "</div>";
		
		echo "</div>";
		
		oci_close($conn);
	?>
	</body>
</html>

<!-- 오류
다른 페이지에서 검색했을 때 검색 기능이 작동하지 않음

 -->