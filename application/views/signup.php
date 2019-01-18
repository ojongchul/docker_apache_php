<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
	Signup
	<div class="container">
		<div class="rows">
			<label>email</label>
			<input type="text" id="idus-email" class="form-control">

			<label>password</label>
			<input type="password" id="idus-password" class="form-control">
			<input type="password" id="idus-password-confirm" class="form-control">

			<label>name</label>
			<input type="text" id="idus-name" class="form-control">

			<label>phone</label>
			<input type="text" id="idus-phone" class="form-control">

			<label>affiliate</label>
			<input type="text" id="idus-affiliate" class="form-control">

			<label><input type="checkbox" value="1" id="event">쿠폰/이벤트 알림 받기(선택)</label>
		</div>
		<div class="rows">
			<button class="btn btn-success" onclick="fcSave()">회원가입하기</button>
		</div>
	</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
function fcSave() {
	var email = $("#idus-email").val();
	var password = $("#idus-password").val();
	var password_confirm = $("#idus-password-confirm").val();
	var name = $("#idus-name").val();
	var phone = $("#idus-phone").val();
	var affiliate= $("#idus-affiliate").val();
	var event = $("#idus-event").val();

	if(!fcCheckNull(email)) {
		alert("이메일을 입력해주세요");
		return;
	}
	if(!fcCheckNull(password)) {
		alert("패스워드를 입력해주세요");
		return;
	}

	if(!fcCheckPassword(password)) {
		alert("패스워드를 다시 확인해주세요");
		return;
	}
	if(!fcComparePassword(password, password_confirm)) {
		alert("패스워드가 일치하지 않습니다.");
		return;
	}

	if(!fcCheckNull(name)) {
		alert("이름을 입력해주세요");
		return;
	}

	if(!fcCheckNull(phone)) {
		alert("연락처를 입력해주세요");
		return;
	}
}

function fcCheckNull(value) {
	if(value == "" || value == undefined) {
		return false;
	} else {
		return true;
	}
}
function fcCheckPassword(password) {
 // check password validate
 // 1. length
 // 2. has special char
 // 3. has capital char
	if(password.length <= 8) { return false;}
	else {return true;}
}

function fcComparePassword(password, password2) { 
 // compare
 // password != password2 return false
	if(password != password2) {
		return false;
	} else {
		return true;
	}
}

</script>
</body>
</html>
