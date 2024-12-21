<head>
	<meta charset="utf-8">
	<title>회원가입</title>
	<style type="text/css">
		body {
			height: 100%;
			width: 100%;
		}
		
		.title {
			text-align: center;
			margin: 10% 40% 3%;
			border: 1px solid black;
			width: 254px;
			height: 70px;
		}
		
		.signUp {
			width: 234px;
			height: auto;
			border: 1px solid black;
			padding: 10px 10px;
			text-align: center;
			margin: 0% 40%;
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
		
		#signup {
			width: 100%;
			background-color: skyblue;
			border-color: transparent;
			color: white;
			margin-bottom: 2%;
		}
		
		.account {
			display: block;
			padding: 3px;
			border: 1px solid lightgray;
			border-radius: 3px;
			width: 80%;
		}
		
		.account::placeholder {
		  font-size: 10px;
		}
		
		.back {
			display: block;
			padding: 3px;
			border: 1px solid lightgray;
			border-radius: 3px;
			width: 30%;
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
	</style>
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
			
			var inputIdLen = inputId.value.length;
			if( inputIdLen <= 4 || inputIdLen >= 12){
				var errorText = document.querySelector("#idError");
				errorText.textContent = "아이디는 4~12글자만 입력할 수 있습니다.";
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

			
			var inputPasswdLen = inputPasswd.value.length;
			if( inputPasswdLen <= 6 || inputPasswdLen >= 20){
				var errorText = document.querySelector("#passwordError");
				errorText.textContent = "비밀번호는 6~20글자만 입력할 수 있습니다.";
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
			
			var inputVerifyPasswdLen = inputVerifyPasswd.value.length;
			if( inputPasswdLen < 6 || inputPasswdLen > 20){
				var errorText = document.querySelector("#verifyPasswordError");
				errorText.textContent = "비밀번호확인에는 6~20글자만 입력할 수 있습니다.";
				inputPasswd.focus();
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
			
		};
	</script>
</head>
<body>
	<header>
		<div class="title">
			<a href="main.php" style="text-decoration: none; color: black;"><h1>회원가입</h1></a>
		</div>
	</header>
	<form name="signUpForm" class="signUp" method="post" action="signupCheck.php" onsubmit="return check()">
		<span id="ip">ID</span><br>
		<input name='id' type="text" placeholder="영문및숫자의 4~12자리 아이디입력" id="setId" class="account" autofocus>
		<div id="idError" class="error"></div>
		
		<span id="ip">EMAIL</span><br>
		<input name='email' type="text" placeholder="영문및숫자의 이메일입력" id="setEmail" class="account">
		<div id="emailError" class="error"></div>

		<span id="ip">PASSWORD</span><br>
		<input name='passwd' type="text" placeholder="영문및숫자의 6~20자리 비밀번호입력" id="setPassword" class="account">
		<div id="passwdError" class="error"></div>

		<span id="ip">VERIFY PASSWORD</span><br>
		<input name='verifyPasswd' type="text" placeholder="비밀번호 확인" id="setVerifyPassword" class="account">
		<div id="verifyPasswordError" class="error"></div>

		<button type="submit" id="signup" class="account">SignUp</button>
		<div id="signUpError" class="error"></div><br>
		
		<button type="button" id="back" class="back" onclick="history.back()" >Back</button>
	</form>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		// 입력 필드에서 값이 변경될 때마다 AJAX 요청을 보내고 출력 업데이트
		$('#setId').on('input', function(){
			var idValue = $(this).val();
			$.ajax({
				url: 'dupCheck.php',
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
				url: 'dupCheck.php',
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

