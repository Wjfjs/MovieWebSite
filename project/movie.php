<?php
	session_start();
	include 'checkloginTime.php';
	
	function changeRotten($enName) {
		$input = $enName;
  
		// 공백을 _로 바꾸기
		$change = str_replace(' ', '_', $input);
		$change = str_replace('-', '_', $change);
	  
		// 특수문자 제거 및 소문자로 변환
		$change = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $change));
		
		return $change;
	}
	function changeMeta($enName) {
		$input = $enName;
  
		// 공백을 -로 바꾸기
		$change = str_replace(' ', '-', $input);
	  
		// 특수문자 제거 및 소문자로 변환
		$change = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '', $change));
		
		return $change;
	}

	function trans($a) {
		$b = preg_replace("/\s+/", "", trim($a));
		$b = strtolower($b);
		return $b;
	}

?>

<?php
	$movieNo = $_GET['NO'];
	
	$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
	$sqlNoting = 'select * from movie where NO = :NO';
	$stid = oci_parse($conn, $sqlNoting);
	oci_bind_by_name($stid, ':NO', $movieNo);
	oci_execute($stid);

	$count = 0;
	while (($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
		$krName[$count] = $row["KR_NAME"];
		$enName[$count] = $row["EN_NAME"];
		$mkDate[$count] = $row["MK_DATE"];
		$country[$count] = $row["COUNTRY"];
		$scrnCount[$count] = $row["SCRN_COUNT"];
		$viewCount[$count] = $row["VIEW_COUNT"];
		$grand[$count] = $row["GRAND"];
		$genre[$count] = $row["GENRE"];
		$poster[$count] = $row["POSTER"];
		$trailer[$count] = $row["TRAILER"];
		$drctr[$count] = $row["DRCTR"];
		$makr[$count] = $row["MAKR"];
		$incme[$count] = $row["INCME"];
		$distb[$count] = $row["DISTB"];
		$likeNum[$count] = $row["LIKE_NUM"];
		$openNum[$count] = $row["OPEN_NUM"];
		$story[$count] = $row["STORY"];
		$runTime[$count] = $row["RUN_TIME"];
		$count++;
	}

	$openNum[0]++;
	$sqlUpadateOpen = 'update movie set OPEN_NUM = :openCount where NO = :NO';
	$stidUpadateOpen = oci_parse($conn, $sqlUpadateOpen);
	oci_bind_by_name($stidUpadateOpen, ':openCount', $openNum[0]);
	oci_bind_by_name($stidUpadateOpen, ':NO', $movieNo);
	oci_execute($stidUpadateOpen);

	oci_free_statement($stidUpadateOpen);
	oci_commit($conn);
	
?>
<html>
	<head>
		<meta charset="utf-8">
		<?php echo "<title>".$krName[0]."</title>"; ?>
		<style type="text/css">
			.MAIN {
				margin: 21px 0px;
			}
			.title {
				text-align: center;
				font-size: 3em;
			}
			.LOGOUT , .USERINFO, .ADMIN {
				float: right;
				margin-bottom: 20px;
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
				margin-bottom: 20px;
				background-color: white;
				border: none;
				cursor: pointer;
			}
			#loginP {
				margin-right: 25px;
				text-align: right;
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

			a {
				text-decoration: none;
				color: black;
			}
			body {
				height: auto;
				width: 1310px;
				margin: 0 auto;
			}
			header section footer {
				position: absolute;
			}
			span#sub {
				position: absolute;
				font-size: 23px;
			}
			span#go {
				float: right;
				font-size: 16px;
			}
			.SiteMain {
				display: block;
				height: auto;
				margin-bottom: 20px;
			}
			.SiteMain iframe {
				width: 1280px;
				height: 720px;
			}
			.s2 {
				display: block;
				height: 407px;
				margin-bottom: 5%;
				margin-left: 14.5px;
			}
			div.video {
				text-align: center;
			}
			.poster img {
				display: inline-block;
				float: left;
				margin: 0px;
				padding: 0px;
				position: relative;
				width: 253.472px;
				height: 362.986px;
			}
			.imfomation {
				margin-left: 20px;
				display: inline-block;
				float: left;
				width: 581px;
			}
			.imfomation2 {
				margin-left: 20px;
				display: inline-block;
				float: left;
				width: 400px;
			}
			div.name {
				display: inline-block;
				float: left;
				margin-bottom: 50px;
				font-weight: bold;
			}
			div.name span {
				font-size: 24px;	
			}
			div.name img {
				position: relative;
				width: 50px;
				height: auto;
				margin-right: 12px;
			}
			div.imgSite {
				display: inline-block;
				float: left;
			}
			div.imgSite a {
				margin-right: 30px;
			}
			.imgSite img {
				position: relative;
				width: 40px;
			}
			span.i {
				font-weight: bold;
				font-size: 23px;
				float: left;
			}
			p.info {
				text-align: left;
			}
			.info span {
				color: darkred;
			}
			span.c {
				font-weight: bold;
				font-size: 23px;
				text-align: left;
				margin-left: 37px;
			}
			.credit {
				display: inline-block;
				width: 1302px;
				height: auto;
				background-color: lightcoral;
				clear: both;
				padding: 4px;
				text-align: left;
				float: left;
			}
			#c1 {
				display: inline-block;
			}
			#c2 {
				display: inline-block;
				text-align: right;
				float: right;
			}
			#contentsDiv {
				font-weight: bold;
				font-size: 23px;
				margin: 0% 1% 0% 15%;
			}
			#contentsTable {
				width: 1000px;
				margin: 0% 0% 0% 2%;
			}
			#contentsUser {
				width: 75px;
				display: inline-block;
				margin-right: 10px;
				margin-bottom: 20px;
				font-weight: bold;
			}
			#contents {
				width: 600px;
				display: inline-block;
				margin-bottom: 20px;
				font-weight: normal;
			}
			#contents p {
				word-wrap: break-word;
			}
			#upDate {
				width: 20%;
				font-size: 10px;
				display: inline-block;
				margin-left: 10px;
			}
			.deleteButton {
				display: inline-block;
				margin-left: 5px;
				background: none;
				border: 0;
				cursor: pointer;
			}
			.deleteButton img {
				height: 20px;
			}
			#deleteContents {
				display: inline-block;
			}
			#comentDiv {
				display: flex;
				margin-bottom: 1%;
			}
			#contentsInput {
				width: 700px;
				height: 50px;
				font-size: 16px;
				margin: 0% 1% 0% 1%;
				resize: none;
			}
			#likeButton {
				background: no-repeat;
				width: 10%;
				height: 10%;
				border: 0;
				outline: 0;
				cursor: pointer;
			}
			.error {
				text-align: left;
				font-size: 10px;
				height: 10px;
				color: red;
				font-weight: 700;
				padding-bottom: 10px;
				margin: 0px 10px;
			}
		</style>
		
	</head>
	<body>
		<header class="MAIN">
			<div>
				<div class="title"><a href="main.php">MIS</a></div><br>
				<?php //로그인, 로그아웃 기능
					session_start();

					$id = isset($_SESSION["FId"]) ? $_SESSION["FId"] : "";
					$memberId = isset($_SESSION["FMemberId"]) ? $_SESSION["FMemberId"] : "";
					
					if(!$id AND $memberId != "000"){	//로그인 전
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
					echo $sqlInput;	//select문 확인용
				?>
			</div>
		</header>

		<section class="SiteMain">
			<div class="video">
	<?php
				$URL = explode(',', $trailer[0]);
				$firstURL = trim($URL[0]);

				if (strpos($firstURL, 'youtu.be') !== false) {
					$videoID = substr($firstURL, strrpos($firstURL, '/') + 1);
					$embedURL = 'https://www.youtube.com/embed/' . $videoID;
					echo "<iframe src='".$embedURL."' title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
				} else {
					echo "유효한 YouTube 동영상 링크를 입력해주세요.";
				}
	?>
			</div>
			<br>
			<div class="s2">
				<div class="poster">
							
	<?php					//영화 포스터
							$poster[0] = str_replace("-", "", $poster[0]);
							echo "<img src='IMAGE/".$poster[0]."' onerror=\"this.onerror=null; this.src='IMAGE/NA.jpg';\">";
	?>			
						
				</div>
				<div class="imfomation">
					<span class="i"><줄거리></span><br>
					<p style="word-wrap: break-word; height: 112px; overflow-y: auto;">
	<?php				//줄거리
						echo "$story[0]";
	?>					
					</p>
					<span class="i"><영화 정보></span><br>
					<p class="info">
	<?php				//영화 정보
						echo "<span>장르:</span> ".$genre[0]." <br>";
						echo "<span>감독:</span> ".$drctr[0]." <br>";
						echo "<span>제작:</span> ".$makr[0]." <br>";
						echo "<span>수입사:</span> ".$incme[0]." <br>";
						echo "<span>유통사:</span> ".$distb[0]." <br>";
						echo "<span>개봉일:</span> ".$mkDate[0]." <br>";
						echo "<span>영화관수:</span> ".$scrnCount[0]." <br>";
						echo "<span>관람수:</span> ".$viewCount[0]." <br>";
						echo "<span>상영시간:</span> ".$runTime[0]." <br>";
						echo "<span>제작국가:</span> ".$country[0]." <br>";
	?>
					</p>
				</div>
					<div class="imfomation2">
	<?php			//영화 제목
					echo "<div class=\"name\">
							<span>".$krName[0]."</span><br>
								".$enName[0]."<br><br>
							<img src='IMAGE/".$grand[0]."'>".$mkDate[0]."<br><br>";
	?>
						<div class="likeClass">	<!-- 좋아요 표시 -->
						<form method="POST">
							<button id="likeButton" type="submit" name="likeButton">
	<?php						
								$userId = $_SESSION["FId"];
								$checkLogin = [];	//로그인 확인
								$likeImg = '';	//좋아요 이미지
								
								$sqlSelectMember = 'select CHECK_LOGIN, LIKE_MOVIE_NO
													from member
													where USER_ID = :userId';

								$stidSelectMember = oci_parse($conn, $sqlSelectMember);
								oci_bind_by_name($stidSelectMember, ':userId', $userId);
								oci_execute($stidSelectMember);

								$count = 0;
								while (($row = oci_fetch_array($stidSelectMember, OCI_ASSOC)) != false) {    
									$checkLogin[$count] = $row["CHECK_LOGIN"];
									$likeMovie[$count] = $row["LIKE_MOVIE_NO"];
									$count++;
								}
								
								$likeNo = explode(',', trim($likeMovie[0]));
								
								

								if (in_array($movieNo, $likeNo)) {
									$likeImg = 'afterLike';
								} else {
									$likeImg = 'like';
								}
								
								//버튼을 눌러야 처리
								if (isset($_POST['likeButton'])) {
									// 좋아요 버튼이 눌렸을 때의 처리
									if ($checkLogin[0] == "Y") {

										// 이미 좋아요한 영화인지 확인
										if (in_array($movieNo, $likeNo)) {	//한 번더 눌르면 좋아요가 사라진다 
											$likeImg = 'like';
											
											$delete .= ','.$movieNo;
											$setMovieNo = implode(',', $likeNo);
											$setMovieNo = str_replace($delete, '', $setMovieNo);
											
											$sqlUpdateMLike = 'update member 
														set LIKE_MOVIE_NO = :setMovieNo 
														where USER_ID = :userId';
																
											$stidUpdateMLike = oci_parse($conn, $sqlUpdateMLike);
											oci_bind_by_name($stidUpdateMLike, ':setMovieNo', $setMovieNo);
											oci_bind_by_name($stidUpdateMLike, ':userId', $userId);
											oci_execute($stidUpdateMLike);
											oci_free_statement($stidUpdateMLike);
											oci_commit($conn);
											
											// 영화의 좋아요 개수 업데이트
											$likeNum[0]--;
											
											$sqlUpdateLike = 'update movie 
														set LIKE_NUM = :likeCount
														where NO = :NO';
											$stidUpdateLike = oci_parse($conn, $sqlUpdateLike);
											oci_bind_by_name($stidUpdateLike, ':likeCount', $likeNum[0]);
											oci_bind_by_name($stidUpdateLike, ':NO', $movieNo);
											oci_execute($stidUpdateLike);
											oci_free_statement($stidUpdateLike);
											oci_commit($conn);
											echo "
												<script type=\"text/javascript\">
													history.back();
												</script>
											";
										}
										else {	//좋아요 추가
											$likeImg = 'afterLike';
											// 좋아요한 영화번호에 현재 영화번호 추가
											$setMovieNo = implode(',', $likeNo);	//배열인 likeNo를 문자열로 변환
											$setMovieNo .= ','.$movieNo;

											// 회원의 좋아요한 영화번호 업데이트
											$sqlUpdateMLike = 'update member 
														set LIKE_MOVIE_NO = :setMovieNo 
														where USER_ID = :userId';
																
											$stidUpdateMLike = oci_parse($conn, $sqlUpdateMLike);
											oci_bind_by_name($stidUpdateMLike, ':setMovieNo', $setMovieNo);
											oci_bind_by_name($stidUpdateMLike, ':userId', $userId);
											oci_execute($stidUpdateMLike);
											oci_free_statement($stidUpdateMLike);
											oci_commit($conn);
											
											// 영화의 좋아요 개수 업데이트
											$likeNum[0]++;
											
											$sqlUpdateLike = 'update movie 
														set LIKE_NUM = :likeCount
														where NO = :NO';
											$stidUpdateLike = oci_parse($conn, $sqlUpdateLike);
											oci_bind_by_name($stidUpdateLike, ':likeCount', $likeNum[0]);
											oci_bind_by_name($stidUpdateLike, ':NO', $movieNo);
											oci_execute($stidUpdateLike);
											oci_free_statement($stidUpdateLike);
											oci_commit($conn);
											echo "
												<script type=\"text/javascript\">
													history.back();
												</script>
											";
										}
										
									}
									else {
										$likeImg = 'like';
										echo "
											<script type=\"text/javascript\">
												alert(\"로그인해야 사용가능합니다.\");		
												history.back();
											</script>
										";	
									}
								}
								echo "<img src='IMAGE/".$likeImg.".png'>
							</button>
						</form><br>";
						if ($likeNum[0] == null) {
							$likeNum[0] = 0;
						}
						echo "<span style='font-size: 20px'>좋아요 수 : ".$likeNum[0]."</span><br>
							<span style='font-size: 20px'>조회 수 : ".$openNum[0]."</span>";
	?>
						</div>
					</div>
	<?php			//평가 정보
					$rottenName = changeRotten($enName[0]);
					$metaName = changeMeta($enName[0]);
					echo "<div class=\"imgSite\">
							<span class='i'><평가 정보></span><br><br>
							<a href='https://www.rottentomatoes.com/m/".$rottenName."'
								 onClick=\"window.open(this.href, '', 'width=600, height=1000, left=700, top=200');
								 return false;\">
							<img src=\"IMAGE/Rotten Tomatoes.png\">TOMATOMETER</a>
							<a href='https://www.metacritic.com/movie/".$metaName."'
								 onClick=\"window.open(this.href, '', 'width=1296, height=750, left=700, top=200');
								 return false;\">
							<img src=\"IMAGE/metacriric.png\">METASCORE</a>";
	?>					
					</div>
				</div>
			</div>
	<?php		//댓글 기능
				$user = [];
				$contents = [];
				$update = [];
				$_SESSION["movieNo"] = $_GET['NO'];
				
				$sqlSelectNotice = "select m.user_id, n.NOTICE_MEMBER_ID, n.contents, TO_CHAR(n.UP_DATE, 'YYYY-MM-DD HH24:MI:SS') UP_DATE
									from notice n 
										join member m 
											on n.notice_member_id = m.member_id
									where n.MOVIE_NO = :movieNo
									order by UP_DATE";
				$stidSelectNotice = oci_parse($conn, $sqlSelectNotice);
				oci_bind_by_name($stidSelectNotice, ':movieNo', $movieNo);
				oci_execute($stidSelectNotice);
				
				$count = 0;
				while (($row = oci_fetch_array($stidSelectNotice, OCI_ASSOC)) != false) {	
					$noticeMember[$count] = $row["NOTICE_MEMBER_ID"];
					$user[$count] = $row["USER_ID"];
					$contents[$count] = $row["CONTENTS"];
					$update[$count] = $row["UP_DATE"];
					$count++;
				}
				
				
	?>
			<div id="contentsDiv">
				<span class="i"><댓글></span><br><br>
				<table id="contentsTable">
					<!-- 댓글 불러오기 -->
					<tbody id="contentsTbody">
						<?php
							if (isset($contents)) {
								$_SESSION["countContents"] = (count($contents));
								$_SESSION["update"] = serialize($update);
								for ($i=0; $i<count($contents); $i++) {
									echo "<tr id='lastTr'>";
										echo "<td id='contentsUser'>".$user[$i]."</td>";
										echo "<td id='contents'><p>".$contents[$i]."</p></td>";
										echo "<td id='upDate'>".$update[$i]."
												<button class='deleteButton' type='button' onclick='deleteButton({$i}, {$movieNo})'>
													<img src='IMAGE/DELETE.png'>
												</button>
											</td>";
									echo "</tr>";
								}
							}
							else {
								echo "<caption style='margin-bottom: 20px;'>댓글이 없습니다.</caption>";
							}
						?>
					</tbody>
					<tbody id="addCotents">
					</tbody>
				</table>
				<!-- 댓글 추가 -->
				<div id="comentDiv">
					<textarea placeholder="댓글을 입력하세요" id="contentsInput" ></textarea>
					<button id="addContentsButton" type="button" onclick="addContents()">댓글 작성</button>
				</div>
				<div id="inputError" class="error" style="font-size: 13px;"></div>
			</div>
		</section>
		
		<footer class="credit">
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
		</footer>
	</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	//댓글 AJAX
	function addContents() {	//댓글 작성 버튼을 눌렀을 때
		var checkLogin = '<?php echo $checkLogin[0]; ?>';
		var contentsInput = $('#contentsInput').val();

		if (checkLogin == 'Y') {	//로그인 유무
			if (contentsInput === "") {
				$('#inputError').html("입력값이 없습니다.");
				return;
			}
			else {
				$.ajax({
					url: "contents.php",
					type: "POST",
					data: {
						contentsInput: contentsInput
					},
					success: function(response){
						var data = JSON.parse(response);
						$('#addCotents').append('<tr><td id="contentsUser">' + data.user + 
												'</td><td id="contents"><p>' + data.contents + 
												'</p></td><td id="upDate">' + data.update + 
												'<button class="deleteButton" type="button" onclick="deleteButton('+ data.movieI +', '+ data.movieNo +
												')"><img src="IMAGE/DELETE.png"></button></td></tr>'
											);
											
						$('#contentsInput').val('');
						$('#inputError').html('');
					},
					error: function(xhr, status, error) {
					  console.log(error);
					}
				});
			}
		}
		else {
			$('#inputError').html("로그인해야 이용가능합니다.");
			return;
		}
	}
	
	//삭제 버튼
	function deleteButton(i, movieNo) {	//삭제 버튼을 눌렀을 때
		var confirmed = confirm('삭제하시겠습니까?');

		if (confirmed) {
			$.ajax({
				url: 'deleteContents.php?movieNo='+movieNo+'&i='+i,
				type: 'POST',
				success: function(response) {
					location.reload();
				},
				error: function() {
					console.log('삭제 오류');
				}
			});
		}
	}
</script>

<?php
	oci_free_statement($stid);
	oci_free_statement($stidSelectMember);
	oci_free_statement($stidSelectNotice);
	oci_close($conn);
?>
