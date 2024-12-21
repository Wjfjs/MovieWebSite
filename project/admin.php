<?php
	session_start();
?>
<head>
	<meta charset="utf-8">
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
			margin: 0% 0% 0% 40%;
		}
		.infoTd {
			width: 327px;
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
		.back, #deleteButton,
		#changeMovie{
			display: inline-block;
			padding: 3px;
			border: 1px solid lightgray;
			border-radius: 3px;
			width: 29%;
			height: 25px;
		}
		#changeInfo, #changeMovie,
		#manageMember {
			display: inline-block;
			padding: 3px;
			border: 1px solid lightgray;
			border-radius: 3px;
			width: 29%;
			height: 25px;
			margin-bottom: 10px;
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
		}
		#infoTable td:last-child {
			text-align: left;
			display: inline-block;
			font-weight: normal;
		}
		#hiden, #deleteButtonHiden {
			margin-right: 10px;
		}
		.deleteButton {
			margin-right: 10px;
		}
		.modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 34px auto;
            padding: 6px;
            width: 1090px;
			position: relative;
        }
		#modalTable {
		}
		#modalTable tr {
			width: 660px;
			border-bottom: 3px solid black;
			margin-top: 15px;
			margin-bottom: 15px;
			display: flex;
			flex-direction: column;
		}
		#modalTable td {
			width: 100%;
			border-bottom: 1px solid black;
			display: block;
			font-weight: normal;
		}
		#modalTable td span {
			display: inline-block;
			width: 450px;
			margin-left: 10px;
		}
		#modalTable td span:first-child {
			vertical-align: top;
			width: 182px;
			font-weight: bold;
			text-align: end;
		}
		.modalInput {
			border: none;
			width: 350px;
			margin-top: 20px;
			margin-bottom: 10px;
			border-bottom: 1px solid;
		}
		#inputDiv {
			background-color: white;
			border: 2px solid;
			position: fixed;
			width: 400px;
			height: 600px;
            top: 78px;
            right: 165px;
			resize: vertical;
            overflow: auto;
			max-width: 400px;
            max-height: 800px;
		}
		#inputDiv textarea {
			resize: vertical;
			overflow: auto;
			width: 100%;
			height: 60px;
		}
		#movieInfoChange {
			position: fixed;
			width: 70px;
			height: 30px;
			top: 39px;
			right: 500px;
		}
		#movieInfoAdd {
			position: fixed;
			width: 70px;
			height: 30px;
			top: 39px;
			right: 420px;
		}
		#movieInfoDelete {
			position: fixed;
			width: 70px;
			height: 30px;
			top: 39px;
			right: 338px;
		}
		#changeUsers {
			display: inline-block;
			text-align: center;
		}
		#memberTable {
			width: 1445px;
			height: auto;
			margin-left: 165px;
		}
		#memberTable input {
			height: 30px;
			width: 117px;
			border: none;
			display: inline-block;
			font-size: 15px;
		}
		#memberTable td {
			padding: 0 10 0 10;
			border: 1px solid;
			text-align: center;
		}
		#pageDiv {
			text-align: center;
			margin: 1% 17% 1% 13%;
		}
		.pageLink {
			margin-right: 10px;
			font-size: 1em;
			font-weight: bold;
			margin: 0% 0.5% 0% 0.5%;
		}
	</style>
	<script type="text/javascript">
		//오류 검사
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
		
		//버튼으로 숨기고 보이게 하기
		function showInfo() {
			var info = document.getElementById("changeInfoTd");
			info.style.display = "inline-block";
		}

		function hidenInfo() {
			var info = document.getElementById("changeInfoTd");
			info.style.display = "none";
		}
		
		function show(i) {
			var yesButton = document.getElementsByClassName('yes');
			var noButton = document.getElementsByClassName('no');
			
			yesButton[i].style.display = 'inline-block';
			noButton[i].style.display = 'inline-block';
		}
		
		function hide(i) {
			var yesButton = document.getElementsByClassName('yes');
			var noButton = document.getElementsByClassName('no');
			
			yesButton[i].style.display = 'none';
			noButton[i].style.display = 'none';
		}
		
		function showMember() {
			var member = document.getElementById("changeUsers");
			member.style.display = "inline-block";
		}
		
		function hidenMember() {
			var member = document.getElementById("changeUsers");
			member.style.display = "none";
		}
		
		//영화 정보 수정창
		function openModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
        }

        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }

	</script>
	
</head>
<body>
	<header>
		<div class="title">
			<a href="main.php" style="text-decoration: none; color: black;"><h1>관리자</h1></a>
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
					$sqlSelect = "select u.*, m.MEMBER_ID, TO_CHAR(m.LOGIN_DATE, 'YYYY-MM-DD') LOGIN_DATE
									from users u
										join member m 
											on u.ID = m.USER_ID
									where u.ID = :inputId";
					
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
						$count++;
					}
					
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
					echo "</table>";
					
					oci_free_statement($stidSelect);
				?>
				
				<button type="button" id="changeMovie" onclick="openModal()">영화정보관리</button><br>
				<button type="button" id="changeInfo" onclick="showInfo()">정보수정</button><br>
				<button type="button" id="manageMember" onclick="showMember()">회원 관리</button><br>
				<button type="button" id="back" class="back" onclick="history.back()" >뒤로가기</button>
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
	
	<div id="changeUsers">
		<?php
			$sqlSelectJoin = "select u.*, m.MEMBER_ID, TO_CHAR(m.LOGIN_DATE, 'YYYY-MM-DD HH24:MI:SS') LOGIN_DATE,
								m.CHECK_LOGIN, m.LIKE_MOVIE_NO, m.MANAGE_MEMBER_ID
							from users u
								join member m 
									on u.ID = m.USER_ID
							order by m.MEMBER_ID";
								
			$stidSelectJoin = oci_parse($conn, $sqlSelectJoin);
			oci_execute($stidSelectJoin);
			
			$count = 0;
			while (($row = oci_fetch_array($stidSelectJoin, OCI_ASSOC)) != false) {	
				$id[$count] = $row["ID"];
				$passwd[$count] = $row["PASSWD"];
				$email[$count] = $row["EMAIL"];
				$memberId[$count] = $row["MEMBER_ID"];
				$loginDate[$count] = $row["LOGIN_DATE"];
				$checkLogin[$count] = $row["CHECK_LOGIN"];
				$likeMovieNo[$count] = $row["LIKE_MOVIE_NO"];
				$manageMemberId[$count] = $row["MANAGE_MEMBER_ID"];
				$count++;
			}
			
			oci_free_statement($stidSelectJoin);
			
			$dataPerPage = 5; // 한 페이지에 표시할 데이터 수
			$totalItems = count($id); // 총 데이터 수
			$totalPages = ceil($totalItems / $dataPerPage); // 총 페이지 수

			if (!isset($_GET['page'])) {
				$currentPage = 1;
			} else {
				$currentPage = $_GET['page'];
			}

			$startIndex = ($currentPage - 1) * $dataPerPage; //0
			$endIndex = min($startIndex + $dataPerPage, $totalItems);
			echo "<table id='memberTable'>";	//영화 정보 표시
				for ($i = $startIndex; $i < $endIndex; $i++) {
					echo "<tr style='font-weight: bold;'>";
						echo "<td> 회원 번호 </td>";
						echo "<td> 사용자 아이디 </td>";
						echo "<td> 사용자 이메일 </td>";
						echo "<td> 로그인 상태 </td>";
						echo "<td> 로그인한 시간 </td>";
						echo "<td> 좋아요한 영화 번호 </td>";
						echo "<td> 관리 회원 번호 </td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td style='width: 80px; text-align: center;'>" . $memberId[$i] . "</td>";
						echo "<td style='width: 170px; text-align: left;'>" . $id[$i] . "</td>";
						echo "<td style='width: 220px; text-align: left;'>" . $email[$i] . "</td>";
						echo "<td style='width: 60px; text-align: center;'>" . $checkLogin[$i] . "</td>";
						echo "<td style='width: 160px; text-align: left;'>" . $loginDate[$i] . "</td>";
						echo "<td style='width: 160px; text-align: left;'><p>
								<form method='POST'>
									<input type='text' name='manageLikeMovieNo_" . $i . "' value='" . $likeMovieNo[$i] . "'>
									<button id='likeMovieSubmit' name='likeMovieNoChange_" . $i . "' type='submit'>적용</button>
								</form>
							</p></td>";
						echo "<td style='width: 80px; text-align: center;'>" . $manageMemberId[$i] . "</td>";
						
						//manageMemberId 업데이트
						// 업데이트된 값을 받아옴
						if (isset($_POST['likeMovieNoChange_' . $i])) {
							$newLikeMovieNo = $_POST['manageLikeMovieNo_' . $i];
							
							$sqlUpdateMember = "UPDATE member 
												SET LIKE_MOVIE_NO = :newLikeMovieNo 
												where MEMBER_ID = :memberId";
							
							$stidUpdateMember = oci_parse($conn, $sqlUpdateMember);
							
							oci_bind_by_name($stidUpdateMember, ':newLikeMovieNo', $newLikeMovieNo);
							oci_bind_by_name($stidUpdateMember, ':memberId', $memberId[$i]);
							
							oci_execute($stidUpdateMember);
							oci_commit($conn);
							
							oci_free_statement($stidUpdateMember);
						}
						
						echo "<td style='border: none; text-align: left; width: 265px;'>";
							echo '<form id="deleteInfo" method="post" action="deleteInfo.php?userId=' . $id[$i] . '&memberId=' . $memberId[$i] . '">';
								echo '<button class="deleteButton" type="button" onclick="show(' . $i . ')">계정 삭제</button>';
								echo '<button style="display: none;" id="deleteButtonHiden" class="yes" type="submit" name="deleteMember">삭제</button>';
								echo '<button style="display: none;" id="hiden" class="no" type="button" onclick="hide(' . $i . ')">아니요</button>';
							echo "</form>";
						echo "</td>";
					echo "</tr>";
				}
			echo "</table>";
			echo "<div id='pageDiv'>";	//페이지 숫자 표시
				for ($page = 1; $page <= $totalPages; $page++) {
					echo "<a class='pageLink' href='?page=" . $page . "'>" . $page . "</a>";
				}
				echo '<br><br><button class="inputPassword" id="closeInfo" type="button" onclick="hidenMember()">닫기</button>';
			echo "</div>";
		?>
	</div>

	<div id="myModal" class="modal">
        <div class="modal-content">
            <span onclick="closeModal()" style="float: right; cursor: pointer;">&times;</span>
			
<?php
			echo "<div id='modalDiv'>";
				echo "<div id='searchForm'>";
					echo "<form id='searchForm'>";
						echo "<input id='searchInput' type='text'; class='searchInput' id='search' placeholder='검색어 입력'>";
					
						echo '<select id="searchSelect" name="sort">
								<option value="asc">내림순</option>
								<option value="desc">오름순</option>
							</select>';
							
						echo '<button id="searchButton" type="button">검색</button>';
					echo "</form>";
				echo "</div>";
				
				echo "<form method='POST'>";
					echo "<table id='modalTable'>\n";

					echo "</table>\n";
					
					echo "<button id='movieInfoChange' type='button' onclick='applyChanges()'>적용하기</button>";
					echo "<button id='movieInfoAdd' type='button' onclick='movieInfoAdd()'>추가하기</button>";
					echo "<button id='movieInfoDelete' type='button' onclick='movieInfoDelete()'>삭제하기</button>";
					echo "<div id='inputDiv'>";
						
						echo "<div id='error'></div>";
						
						echo "<input type='text'; class='modalInput' id='NO' value='' placeholder='변경할 영화의 NO 및 추가할 영화의 NO'>";
						echo "<input type='text'; class='modalInput' id='KR_NAME' value='' placeholder='KR_NAME'>";
						echo "<input type='text'; class='modalInput' id='EN_NAME' value='' placeholder='EN_NAME'>";
						echo "<input type='text'; class='modalInput' id='DRCTR' value='' placeholder='DRCTR'>";
						echo "<input type='text'; class='modalInput' id='MAKR' value='' placeholder='MAKR'>";
						echo "<input type='text'; class='modalInput' id='INCME' value='' placeholder='INCME'>";
						echo "<input type='text'; class='modalInput' id='DISTB' value='' placeholder='DISTB'>";
						echo "<input type='text'; class='modalInput' id='MK_DATE' value='' placeholder='MK_DATE'>";
						echo "<input type='text'; class='modalInput' id='COUNTRY' value='' placeholder='COUNTRY'>";
						echo "<input type='text'; class='modalInput' id='SCRN_COUNT' value='' placeholder='SCRN_COUNT'>";
						echo "<input type='text'; class='modalInput' id='VIEW_COUNT' value='' placeholder='VIEW_COUNT'>";
						echo "<input type='text'; class='modalInput' id='GENRE' value='' placeholder='GENRE'>";
						echo "<input type='text'; class='modalInput' id='GRAND' value='' placeholder='GRAND'>";
						echo "<input type='text'; class='modalInput' id='POSTER' value='' placeholder='POSTER'>";
						echo "<input type='text'; class='modalInput' id='TRAILER' value='' placeholder='TRAILER'>";
						echo "<textarea type='text'; class='modalInput' id='STORY' value='' placeholder='STORY'></textarea>";
						echo "<input type='text'; class='modalInput' id='RUN_TIME' value='' placeholder='RUN_TIME'>";
						echo "<input type='text'; class='modalInput' id='LIKE_NUM' value='' placeholder='LIKE_NUM'>";
						echo "<input type='text'; class='modalInput' id='OPEN_NUM' value='' placeholder='OPEN_NUM'>";
						echo "<input type='text'; class='modalInput' id='MANAGE_MEMBER_ID' value='' placeholder='MANAGE_MEMBER_ID'>";
					
					echo "</div>";
					
				echo "</form>";
			echo "</div>";
?>
        </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- 회원 정보 업데이트 -->
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

<!-- 영화 정보 업데이트 -->
<script>
	$(document).ready(function() {
		// 페이지 로드 시 영화 정보를 가져와서 테이블에 표시
		loadMovieInfo()
		// 수정하기 버튼 클릭 시 서버로 수정 요청을 보내고 변경된 정보를 다시 가져와서 테이블 업데이트
		$("#movieInfoChange").click(function() {
			var user = '<?php echo $_SESSION["FMemberId"]; ?>';
			var no = $("#NO").val();
			var krName = $("#KR_NAME").val();
			var enName = $('#EN_NAME').val();
			var drctr = $('#DRCTR').val();
			var makr = $('#MAKR').val();
			var incme = $('#INCME').val();
			var distb = $('#DISTB').val();
			var mkDate = $('#MK_DATE').val();
			var country = $('#COUNTRY').val();
			var scrnCount = $('#SCRN_COUNT').val();
			var viewCount = $('#VIEW_COUNT').val();
			var genre = $('#GENRE').val();
			var grand = $('#GRAND').val();
			var poster = $('#POSTER').val();
			var trailer = $('#TRAILER').val();
			var story = $('#STORY').val();
			var runTime = $('#RUN_TIME').val();
			var likeNum = $('#LIKE_NUM').val();
			var openNum = $('#OPEN_NUM').val();
			var manageId = $('#MANAGE_MEMBER_ID').val();
			
			if (user === "000") {
				if (no === "") {
					$('#error').html("NO값이 없습니다.");
					return;
				}
				else {
					$('#error').html("");
					$.ajax({
						url: "movieChange.php",
						type: "POST",
						data: {
							user: user,
							no: no,
							krName: krName,
							enName: enName,
							drctr: drctr,
							makr: makr,
							incme: incme,
							distb: distb,
							mkDate: mkDate,
							country: country,
							scrnCount: scrnCount,
							viewCount: viewCount,
							genre: genre,
							grand: grand,
							poster: poster,
							trailer: trailer,
							story: story,
							runTime: runTime,
							likeNum: likeNum,
							openNum: openNum,
							manageId: manageId
						},
						success: function() {
							loadMovieInfo();
						},
						error: function() {
							alert("수정에 실패했습니다.");
						}
					});
				}
			}
			else {
				$('#error').html("권한이 없습니다.");
				return;
			}
		});
		
		//추가
		$("#movieInfoAdd").click(function() {
			var user = '<?php echo $_SESSION["FMemberId"]; ?>';
			var no = $("#NO").val();
			var krName = $("#KR_NAME").val();
			var enName = $('#EN_NAME').val();
			var drctr = $('#DRCTR').val();
			var makr = $('#MAKR').val();
			var incme = $('#INCME').val();
			var distb = $('#DISTB').val();
			var mkDate = $('#MK_DATE').val();
			var country = $('#COUNTRY').val();
			var scrnCount = $('#SCRN_COUNT').val();
			var viewCount = $('#VIEW_COUNT').val();
			var genre = $('#GENRE').val();
			var grand = $('#GRAND').val();
			var poster = $('#POSTER').val();
			var trailer = $('#TRAILER').val();
			var story = $('#STORY').val();
			var runTime = $('#RUN_TIME').val();
			var likeNum = $('#LIKE_NUM').val();
			var openNum = $('#OPEN_NUM').val();
			var manageId = $('#MANAGE_MEMBER_ID').val();
			
			if (user === "000") {
				//적어도 하나는 입력되게하는 조건식
				if (no === "" && krName === "" && enName === "" && drctr === "" && makr === "" && incme === "" && distb === "" && mkDate === "" && country === "" && scrnCount === "" && viewCount === "" && genre === "" && grand === "" && poster === "" && trailer === "" && story === "" && runTime === "" && likeNum === "" && openNum === "" && manageId === "") {
					$('#error').html("적어도 하나는 입력해야 합니다.");
					return;
				}
				else {
					$('#error').html("");
					$.ajax({
						url: "addMovie.php",
						type: "POST",
						data: {
							user: user,
							no: no,
							krName: krName,
							enName: enName,
							drctr: drctr,
							makr: makr,
							incme: incme,
							distb: distb,
							mkDate: mkDate,
							country: country,
							scrnCount: scrnCount,
							viewCount: viewCount,
							genre: genre,
							grand: grand,
							poster: poster,
							trailer: trailer,
							story: story,
							runTime: runTime,
							likeNum: likeNum,
							openNum: openNum,
							manageId: manageId
						},
						success: function() {
							loadMovieInfo();
						},
						error: function() {
							alert("추가에 실패했습니다.");
						}
					});
				}
			}
			else {
				$('#error').html("권한이 없습니다.");
				return;
			}
		});
		
		//삭제
		$("#movieInfoDelete").click(function() {
			var user = '<?php echo $_SESSION["FMemberId"]; ?>';
			var no = $("#NO").val();
			
			if (user === "000") {
				//적어도 하나는 입력되게하는 조건식
				if (no === "") {
					$('#error').html("삭제할 영화 번호가 필요합니다.");
					return;
				}
				else {
					$('#error').html("");
					$.ajax({
						url: "deletMovie.php",
						type: "POST",
						data: {
							user: user,
							no: no,
						},
						success: function() {
							alert('영화 번호 '+no+' 가 삭제 되었습니다.');
							loadMovieInfo();
						},
						error: function() {
							alert("삭제에 실패했습니다.");
						}
					});
				}
			}
			else {
				$('#error').html("권한이 없습니다.");
				return;
			}
		});
		
		// 검색 버튼 클릭 시 검색 실행
		$("#searchButton").click(function() {
			executeSearchAndSort();
		});

		// 정렬 옵션 변경 시 정렬 실행
		$("#sort").change(function() {
			executeSearchAndSort();
		});
	});

	function executeSearchAndSort() {
		var searchInput = $("#searchInput").val();
		var sort = $("#searchSelect").val();
		
		$.ajax({
			url: "searchMovie.php",
			type: "POST",
			data: { 
					searchInput: searchInput,
					sort: sort
				},
			success: function(data) {
				$("#modalTable").html(data);
			},
			error: function() {
				alert("검색에 실패했습니다.");
			}
		});
	}
	

	function loadMovieInfo() {
		$.ajax({
			url: "getMovieInfo.php",
			type: "GET",
			success: function(data) {
				$("#modalTable").html(data);
			},
			error: function() {
				alert("영화 정보를 가져오는데 실패했습니다.");
			}
		});
	}
</script>