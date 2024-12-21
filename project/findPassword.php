<head>
	<meta charset="utf-8">
	<title>비밀번호 찾기</title>
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
		.findPasswd {
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
			width: 80%;
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
			var inputEmail = document.getElementById("setEmail");
			
			if (inputEmail.value == "") {
				var errorText = document.querySelector("#findId");
				errorText.textContent = "이메일을 입력해야 합니다.";
				inputId.focus();
				return false;
			} else {
				var errorText = document.querySelector("#findId");
				errorText.textContent = "";
			};
		};
	</script>
</head>
<body>
	<header>
		<div class="title">
			<a href="main.php" style="text-decoration: none; color: black;"><h2>아이디 비밀번호 찾기</h2></a>
		</div>
	</header>
	<form name="findForm" class="findPasswd" method="post" action="findPasswordCheck.php" onsubmit="return check()">
		<div style="font-size: 11px; font-weight: bold;">이메일을 입력해야 합니다.</div><br>

		<span id="ip">EMAIL</span><br>
		<input type="text" placeholder="영문및숫자의 이메일입력" id="setEmail" class="account">
		<div id="emailError" class="error"></div>
		
		<div id="findId" class="find"></div>
		
		<button id="find" type="submit" class="account">Find</button>
		<a href="signup.php"><span>회원가입</span></a><br>
		<a href="login.php"><span>로그인</span></a><br><br>
		<button type="button" id="back" class="back" onclick="history.back()" >Back</button>
	</form>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		// 입력 필드에서 값이 변경될 때마다 AJAX 요청을 보내고 출력 업데이트
		$('#setEmail').on('input', function(){
			var emailValue = $(this).val();
			$.ajax({
				url: 'findPasswordCheck.php',
				type: 'POST',
				data: {emailValue: emailValue},
				success: function(response){
					$('#emailError').html(response);
				}
			});
		});
		
		$('#find').on('click', function(e) {
			e.preventDefault();
			var findValue = $('#setEmail').val();
			$.ajax({
				url: 'findPasswordCheck.php',
				type: 'POST',
				data: { findValue: findValue },
				success: function(response){
					$('#findId').html(response);
				}
			});
		});
	});
</script>