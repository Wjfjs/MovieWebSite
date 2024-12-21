<head>
	<meta charset="utf-8">
	<title>로그인</title>
	<style type="text/css">
		body {
			height: 100%;
			width: 100%;
		}
		a {
			text-decoration: none;
			color: black;
		}
		.title {
			text-align: center;
			margin: 10% 40% 3%;
			border: 1px solid black;
			width: 254px;
			height: 70px;
		}
		.login, .infoDiv {
			width: 234px;
			height: auto;
			border: 1px solid black;
			padding: 10px 10px;
			text-align: center;
			margin: 0% 40%;
		}
		.infoDiv {
			text-align: left;
			padding-bottom: 10px;
		}
		.changeInfo {
			display: block;
			float: left;
		}
		.deleteInfo {
			display: block;
			float: right;
		}
		.showPassword {
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
		#loginId, #signup, #find {
			width: 100%;
			background-color: skyblue;
			border-color: transparent;
			color: white;
		}
		.account {
			display: block;
			padding: 3px;
			border: 1px solid lightgray;
			border-radius: 3px;
			width: 80%;
		}
		button {
			cursor: pointer;
		}
		.error {
			text-align: left;
			font-size: 1px;
			height: 10px;
			color: red;
			font-weight: 700;
			padding-bottom: 10px;
			margin: 0px 10px;
		}
		
		.back {
			display: block;
			padding: 3px;
			border: 1px solid lightgray;
			border-radius: 3px;
			width: 30%;
		}
	</style>

	<script type="text/javascript">
		function check() {
			
			var inputId = document.getElementById("idId");
			var inputPasswd = document.getElementById("passwdId");
			
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
			
			var inputIdLen = inputId.value.length;
			if( inputIdLen < 4 || inputIdLen > 12){
				var errorText = document.querySelector("#idError");
				errorText.textContent = "아이디는 4~12글자만 입력할 수 있습니다.";
				inputId.focus();
				return false;
			}
			else {
				var errorText = document.querySelector("#idError");
				errorText.textContent = "";
			};
			
			if (inputPasswd.value == '') {
				var errorText = document.querySelector("#passwdError");
				errorText.textContent = "비밀번호를 입력하세요.";
				inputPasswd.focus();
				return false;
			}
			else {
				var errorText = document.querySelector("#passwdError");
				errorText.textContent = "";
			};
			
			var inputPasswdLen = inputPasswd.value.length;
			if( inputPasswdLen < 6 || inputPasswdLen > 20){
				var errorText = document.querySelector("#passwdError");
				errorText.textContent = "비밀번호는는 6~20글자만 입력할 수 있습니다.";
				inputPasswd.focus();
				return false;
			}
			else {
				var errorText = document.querySelector("#passwdError");
				errorText.textContent = "";
			};
			
		};
	</script>

</head>
<body>
	<header>
		<div class="title">
			<a href="main.php"><h1>로그인</h1></a>
		</div>
	</header>
	<form name="loginForm" class="login" method="post" action="loginCheck.php" onsubmit="return check()">
		<span id="ip">ID</span><br>
		<input name="id" type="text" placeholder="아이디 4~12자리" id="idId" class="account" autofocus>
		<div id="idError" class="error"></div>

		<span id="ip">PASSWORD</span><br>
		<input name="passwd" type="password" placeholder="비밀번호 6~20자리" id="passwdId" class="account">
		<div id="passwdError" class="error"></div>

		<button type="submit" id="loginId" class="account">Login</button>
		<div id="loginError" class="error"></div>

		<a href="signup.php"><span>회원가입</span></a><br>
		<a href="findPassword.php"><span>아이디 비밀번호 찾기</span></a><br><br>
		<button type="button" id="back" class="back" onclick="history.back()" >Back</button>
	</form>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		// 입력 필드에서 값이 변경될 때마다 AJAX 요청을 보내고 출력 업데이트
		$('#idId').on('input', function(){
			var idValue = $(this).val();
			$.ajax({
				url: 'dupLoginCheck.php',
				type: 'POST',
				data: {idValue: idValue},
				success: function(response){
					$('#idError').html(response);
				}
			});
		});
		$('#passwdId').on('input', function(){
			var passwdValue = $(this).val();
			$.ajax({
				url: 'dupLoginCheck.php',
				type: 'POST',
				data: {passwdValue: passwdValue},
				success: function(response){
					$('#passwdError').html(response);
				}
			});
		});
	});
</script>
