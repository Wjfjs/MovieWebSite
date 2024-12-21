<?php
	session_start();
	date_default_timezone_set('Asia/Seoul');
?>
<html>
	<head>
		<title>회원 정보</title>
		<style type="text/css">
			body {
				height: 100%;
				width: 100%;
			}
			.title {
				text-align: center;
				margin: 5% 40% 3%;
				border: 1px solid black;
				width: 347px;
				height: 70px;
			}
			.findPasswd {
				width: 234px;
				height: auto;
				border: 1px solid black;
				padding: 10px 10px;
				text-align: center;
				margin: 0% 40%;
			}
			#mainTable {
				height: auto;
				margin: 0% 0% 0% 30%;
			}
			.infoTd {
				width: 627px;
				height: 40%;
				border: 1px solid black;
				padding: 10px 10px;
				vertical-align : top;
				display: inline-block;
			}
			.changeInfoTd {
				width: 234px;
				height: 40%;
				border: 1px solid black;
				padding: 13px 10px;
				margin-left: 4px;
				text-align: left;
				vertical-align: top;
				display: none;
			}
			#ip {
				margin-left: 1px;
				float: left;
			}
			input {
				margin: 0px 0px;
			}
			a {
				text-decoration: none;
				color: black;
			}
			.title a {
				font-size: 13px;
			}
			.find {
				margin-top: 2%;
				font-weight: bold;
			}
			#find {
				width: 100%;
				margin: 3% 0%;
				background-color: skyblue;
				border-color: transparent;
				color: white;
			}
			.account {
				display: block;
				padding: 3px;
				border: 1px solid lightgray;
				border-radius: 3px;
				width: 100%;
				height: 1%;
			}
			.account::placeholder {
			  font-size: 10px;
			}
			button {
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
			
			.back, #deleteButton {
				display: inline-block;
				padding: 3px;
				border: 1px solid lightgray;
				border-radius: 3px;
				width: 13%;
				height: 25px;
			}
			#changeInfo {
				display: inline-block;
				padding: 3px;
				border: 1px solid lightgray;
				border-radius: 3px;
				width: 13%;
				height: 25px;
				float: right;
			}
			#infoTable {
				width: 100%;
				height: auto;
			}
			#infoTable tr {
				display: block;
				margin-bottom: 20px;
				text-align: center;
			}
			#infoTable td {
				width: 45%;
				font-weight: bold;
				text-align: right;
				display: inline-block;
				margin-right: 10px;
				vertical-align: top;
			}
			#infoTable td:last-child {
				text-align: left;
				display: inline-block;
				font-weight: normal;
			}
			.hiden {
				display: none;
			}
			#likeMovieP {
				width: 150px;
				height: 50px;
				word-wrap: break-word;
				margin: 0% 0%;
			}
			#contentsP {
				word-wrap: break-word;
				width: 300px;
				margin: 0;
			}
			#contentsTable {
				width: 100%;
				height: auto;
				text-align: center;
			}
			#pageDiv {
				margin: 2% 0%;
				font-size: 14px;
				text-align: center;
			}
			.pageLink {
				text-align: center;
				margin-right: 5px;
				font-size: 1em;
			}
			.deleteContents {
				display: inline-block;
				margin-left: 5px;
				background: none;
				border: 0;
				cursor: pointer;
			}
			.deleteContents img {
				height: 20px;
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				$('#setId').on('input', function(){
					var idValue = $(this).val();
					
					$.ajax({
						url: 'dupInfo.php',
						type: 'POST',
						data: {idValue: idValue},
						success: function(response){
							$('#idError').html(response);
						}
					});
				});
				
				$('#setEmail').on('input', function(){
					var emailValue = $(this).val();
					
					$.ajax({
						url: 'dupInfo.php',
						type: 'POST',
						data: {emailValue: emailValue},
						success: function(response){
							$('#emailError').html(response);
						}
					});
				});
				
				$('#setPassword').on('input', function(){
					var passwdValue = $(this).val();
					
					$.ajax({
						url: 'dupInfo.php',
						type: 'POST',
						data: {passwdValue: passwdValue},
						success: function(response){
							$('#passwordError').html(response);
						}
					});
				});
				
				$('#setVerifyPassword').on('input', function(){
					var passwdValue = $('#setPassword').val();
					var checkPasswd = $(this).val();
					
					
					
					$.ajax({
						url: 'dupInfo.php',
						type: 'POST',
						data: {passwdValue:passwdValue, checkPasswd: checkPasswd},
						success: function(response){
							$('#verifyPasswordError').html(response);
						}
					});
				});
				
				$('#save').click(function(e) {
					var idValue = $('#setId').val();
					var emailValue = $('#setEmail').val();
					var passwdValue = $('#setPassword').val();
					var checkPasswd = $('#setVerifyPassword').val();

					if (idValue === "" && emailValue === "" && passwdValue === "" && checkPasswd === "") {
						$('#saveError').html("변경된 값이 없습니다.");
						return;
					}
					
					if (idValue !== '') {
						$.ajax({
							url: 'changeInfo.php',
							type: 'POST',
							data: {
								idValue: idValue
							},
							success: function(response){
								if (response === "success") {
									$('#getId').html(idValue);
								}
								else {
									$('#saveError').html(response);
								}
							}
						});
					}
					
					if (emailValue !== '') {
						$.ajax({
							url: 'changeInfo.php',
							type: 'POST',
							data: {
								emailValue: emailValue
							},
							success: function(response){
								if (response === "success") {
									$('#getEmail').html(emailValue);
								}
								else {
									$('#saveError').html(response);
								}
							}
						});
					}
					
					if (passwdValue !== '' && checkPasswd !== '') {
						$.ajax({
							url: 'changeInfo.php',
							type: 'POST',
							data: {
								passwdValue: passwdValue,
								checkPasswd: checkPasswd
							},
							success: function(response){
								if (response === "success") {
									$('#getPasswd').html(passwdValue);
								}
								else {
									$('#saveError').html(response);
								}
							}
						});
					}
					
				});
			});
		</script>

		<script type="text/javascript">
			function check() {
					
				var inputId = document.getElementById("setId");
				var inputEmail= document.getElementById("setEmail");
				var inputPasswd = document.getElementById("setPassword");
				var inputVerifyPasswd = document.getElementById("setVerifyPassword");
				
				
				if (inputId.value == "") {
					var errorText = document.querySelector("#idError");
					errorText.textContent = "아이디를 입력하세요.";
					inputId.focus();
					return false;
				}
				else {
					var errorText = document.querySelector("#idError");
					errorText.textContent = "";
				};
				
				if (inputEmail.value == "") {
					var errorText = document.querySelector("#emailError");
					errorText.textContent = "이메일을 입력하세요.";
					inputEmail.focus();
					return false;
				}
				else {
					var errorText = document.querySelector("#emailError");
					errorText.textContent = "";
				};

				
				if (inputPasswd.value == "") {
					var errorText = document.querySelector("#passwordError");
					errorText.textContent = "비밀번호를 입력하세요.";
					inputPasswd.focus();
					return false;
				}
				else {
					var errorText = document.querySelector("#passwordError");
					errorText.textContent = "";
				};
				
				if (inputVerifyPasswd.value == "") {
					var errorText = document.querySelector("#verifyPasswordError");
					errorText.textContent = "비밀번호확인을 입력하세요.";
					inputVerifyPasswd.focus();
					return false;
				}
				else {
					var errorText = document.querySelector("#verifyPasswordError");
					errorText.textContent = "";
				};
				
				if (inputPasswd.value != inputVerifyPasswd.value) {
					var errorText = document.querySelector("#verifyPasswordError");
					errorText.textContent = "비밀번호가 같지않습니다.";
					inputVerifyPasswd.focus();
					return false;
				}
				else {
					var errorText = document.querySelector("#verifyPasswordError");
					errorText.textContent = "";
				};
				
			}
			
			//삭제 버튼
			function deleteContents(i, movieNo) {	//삭제 버튼을 눌렀을 때
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
		
			function showInfo() {
				var info = document.getElementById("changeInfoTd");
				info.style.display = "inline-block";
			}

			function hidenInfo() {
				var info = document.getElementById("changeInfoTd");
				info.style.display = "none";
			}
			
			function show() {
				var yesButton = document.getElementById("yes");
				var noButton = document.getElementById("no");
				yesButton.style.display = "inline-block";
				noButton.style.display = "inline-block";
			}
			
			function hiden() {
				var yesButton = document.getElementById("yes");
				var noButton = document.getElementById("no");
				yesButton.style.display = "none";
				noButton.style.display = "none";
			}

		</script>
		
	</head>
	<body>
		<header>
			<div class="title">
				<a href="main.php" style="text-decoration: none; color: black;"><h1>사용자 정보</h1></a>
			</div>
		</header>
		<table id="mainTable">
			<tr>
				<td class="infoTd">
					<?php
						$userId = isset($_SESSION["FId"]) ? $_SESSION["FId"] : "";
						$userEmail = '';
						$userpasswd = '';
						$userMemberId = '';
						$userLoginDate = '';
						$likeMovieName = [];
						$commentMovie = [];
						
						$conn = oci_connect('dbuser191719', '71205409', 'azza.gwangju.ac.kr/orcl', 'Al32UTF8');
						$sqlSelect = "select u.*, m.MEMBER_ID, TO_CHAR(m.LOGIN_DATE, 'YYYY-MM-DD') LOGIN_DATE, m.LIKE_MOVIE_NO
										from users u
											join member m 
												on u.ID = m.USER_ID
										where u.ID = :inputId";
						
						$sqlSelectNotice = "select CONTENTS, MOVIE_NO, TO_CHAR(UP_DATE, 'YYYY-MM-DD HH24:MI:SS') UP_DATE
											from notice
											where NOTICE_MEMBER_ID = :memberId
											order by UP_DATE desc";
						
						$stidSelect = oci_parse($conn, $sqlSelect);
						oci_bind_by_name($stidSelect, ':inputId', $userId);
						
						oci_execute($stidSelect);
						
						$count = 0;
						while (($row = oci_fetch_array($stidSelect, OCI_ASSOC)) != false) {	
							$getId[$count] = $row["ID"];
							$getPasswd[$count] = $row["PASSWD"];
							$getEmail[$count] = $row["EMAIL"];
							$getMemberId[$count] = $row["MEMBER_ID"];
							$getLoginDate[$count] = $row["LOGIN_DATE"];
							$getLikeMovieNo[$count] = $row["LIKE_MOVIE_NO"];
 							$count++;
						}
						
						$stidSelectNotice = oci_parse($conn, $sqlSelectNotice);
						oci_bind_by_name($stidSelectNotice, ':memberId', $getMemberId[0]);
						oci_execute($stidSelectNotice);
						
						$count = 0;
						while (($row = oci_fetch_array($stidSelectNotice, OCI_ASSOC)) != false) {	
							$getContents[$count] = $row["CONTENTS"];
							$getMovie_no[$count] = $row["MOVIE_NO"];
							$getUpdate[$count] = $row["UP_DATE"];
 							$count++;
						}
						
						$likeNo = explode(',', trim($getLikeMovieNo[0]));
						
						echo "<table id='infoTable'>";
							echo "<tr>";
									echo "<td>ID : </td>";
									echo "<td id='getId'>".$getId[0]."</td>";
							echo "</tr>";
							echo "<tr>";
									echo "<td>EMAIL : </td>";
									echo "<td id='getEmail'>".$getEmail[0]."</td>";
							echo "</tr>";
							echo "<tr>";
									echo "<td>PASSWD : </td>";
									echo "<td id='getPasswd'>".$getPasswd[0]."</td>";
							echo "</tr>";
							echo "<tr>";
									echo "<td>Member ID : </td>";
									echo "<td>".$getMemberId[0]."</td>";
							echo "</tr>";
							echo "<tr>";
									echo "<td>LAST LOGIN : </td>";
									echo "<td>".$getLoginDate[0]."</td>";
							echo "</tr>";
							echo "<tr>";
									echo "<td>LIKE MOVIE NO : </td>";
									echo "<td>";
											echo "<p id='likeMovieP'>";
												for ($i=0; $i<count($likeNo); $i++) {
													if ($i != count($likeNo)-1) {
														echo "<a href=movie?NO=".$likeNo[$i].">
															".$likeNo[$i].",
														</a>";
													}
													else {
														echo "<a href=movie?NO=".$likeNo[$i].">
															".$likeNo[$i]."
														</a>";
													}
													
												}
											echo "</p>";
										echo "</td>";
							echo "</tr>";
						echo "</table>";
						
						echo "<table id='contentsTable'>";
								echo "<caption style='font-weight: bold; font-size: 20px; margin-bottom: 10px;'>
										<작성 댓글>
									</caption>";
								if (isset($getContents)) {
									echo "<tr style='font-weight: bold;'>";
											echo "<td> 영화 번호 </td>";
											echo "<td> 작성 댓글 </td>";
											echo "<td> 작성 날짜 </td>";
											echo "<td></td>";
									echo "</tr>";
									
									$dataPerPage = 10; // 한 페이지에 표시할 데이터 수
									$totalItems = count($getContents); // 총 데이터 수
									$totalPages = ceil($totalItems / $dataPerPage); // 총 페이지 수

									if (!isset($_GET['page'])) {
										$currentPage = 1;
									} else {
										$currentPage = $_GET['page'];
									}

									$startIndex = ($currentPage - 1) * $dataPerPage; //0
									$endIndex = min($startIndex + $dataPerPage, $totalItems);
									
									//댓글 표시
									for ($i = $startIndex; $i < $endIndex; $i++) {
										$_SESSION["update"] = serialize($getUpdate);
										
										echo "<tr>";
												echo "<td style='width: 50px;'>
														<a href='movie.php?NO=".$getMovie_no[$i]."'>".$getMovie_no[$i]."</a>
													</td>";
												echo "<td style='width: 300px;'>
														<p id='contentsP'>
															".$getContents[$i]."
														</p>
													</td>";
												echo "<td style='width: 164px;'>"
														.$getUpdate[$i]."
													</td>";
												echo "<td>
														<button class='deleteContents' type='button' 
																onclick='deleteContents({$i}, {$getMovie_no[$i]})'>
															<img src='IMAGE/DELETE.png'>
														</button>
													</td>";
										echo "</tr>";
									}
								}
								else {
									echo "<caption style='margin-bottom: 20px;'> 댓글이 없습니다. </caption>";
								}
								
						echo "</table>";
						
						echo "<div id='pageDiv'>";	//페이지 숫자 표시
								for ($page = 1; $page <= $totalPages; $page++) {
									echo "<a class='pageLink' href='?page=" . $page . "'>" . $page . "</a>";
								}
						echo "</div>";
						
						oci_free_statement($stidSelectNotice);
						oci_free_statement($stidSelect);
						oci_close($conn);
					?>
					
					<form id="deleteInfo" method="post" action="deleteInfo.php?userId=<?php echo $getId[0]; ?>&memberId=<?php echo $getMemberId[0]; ?>">
						<button id="deleteButton" type="button" onclick="show()">계정 삭제</button>
						<input class="hiden" id="yes" type="submit" name="deleteAccount" value="예"><button class="hiden" id="no" type="button" onclick="hiden()">아니요</button>
					</form>
					
					<button type="button" id="back" class="back" onclick="history.back()" >뒤로가기</button>
					<button type="button" id="changeInfo" onclick="showInfo()">정보수정</button>
					
				</td>
				<td class="changeInfoTd" id="changeInfoTd">
					<form class="showPassword" method="post" action="changeInfo.php" onsubmit="return check()" id="infoForm">
						<input name='id' type="text" placeholder="영문및숫자의 4~12자리 아이디입력" id="setId" class="account" autofocus>
						<div id="idError" class="error"></div>
						
						<input name='email' type="text" placeholder="영문및숫자의 이메일입력" id="setEmail" class="account">
						<div id="emailError" class="error"></div>
						
						<input name='passwd' type="text" placeholder="영문및숫자의 6~20자리 비밀번호입력" id="setPassword" class="account">
						<div id="passwordError" class="error"></div>
						
						<input name='verifyPasswd' type="text" placeholder="비밀번호 확인" id="setVerifyPassword" class="account">
						<div id="verifyPasswordError" class="error"></div><br>
						
						<div id="saveError" class="error"></div>
						<button class="inputPassword" id="save" type="button">변경 사항 저장</button><br>
						<button class="inputPassword" id="closeInfo" type="button" onclick="hidenInfo()">닫기</button>
					</form>
				</td>
			</tr>
		</table>
	</body>
</html>