<?php
session_start();

if($_POST) {
	$msg = "";
	$login = $_POST['login'];
	$password = $_POST['pswd'];
	$type = $_POST['type'];
	
	//ถ้าเป็นผู้ทดสอบ
	if($type == "tester") {
		if($login === "admin" && $password === "abc456") {
			$_SESSION['user'] = "tester";
			header("Location: index.php");
			exit;
		}
		else { 
			$msg = "ท่านกำหนด Login หรือ Password ไม่ถูกต้อง";
		}
	}
	else if($type == "testee") {
		include "dblink.php";
		$sql = "SELECT testee_id, firstname, lastname FROM testee WHERE login = '$login' AND password = '$password'";
		$result = mysqli_query($link, $sql);
		if(!$result) {
			$msg = "เกิดข้อผิดพลาด กรุณาลองใหม่";
		}
		else {
			$r = mysqli_num_rows($result);
			if($r == 1) {
				$row = mysqli_fetch_array($result);
				$_SESSION['user'] = "testee";
				$_SESSION['testee_id'] = $row[0];
				$_SESSION['testee_name'] = $row[1] . "  " . $row[2]; 
				
				mysqli_close($link);
				header("location: index.php");
				exit;
			}
			else {
				$msg = "ท่านกำหนด Login หรือ Password ไม่ถูกต้อง";
			}
		}
		mysqli_close($link);
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Web Testing</title>
<style>
	@import "global.css";

	form {
		width: 600px;
		border: solid 0px green;
		border-radius: 8px;
		margin: 10px auto 15px;
		padding: 10px 0px;
		background: #cee;
	}
	form input:not([type=radio]) {
		width: 200px;
		background: #ffd;
		border: solid 1px gray;
		padding: 2px;
		color: blue;
	}
	form label {
		display: inline-block;
		width: 200px;
		text-align: right;
		padding: 5px;
	}
	form div {
		text-align:center;
		margin: 10px;
	}
	button {
		background: steelblue;
		color: white;
		border: solid 1px orange;
		padding: 3px;
		width: 80px;
	}
	button:hover {
		color: aqua;
		cursor: pointer;
	}
	h4.error {
		color: red;
		text-align: center;
	}
</style>
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/jquery.blockUI.js"></script>
<script>
$(function() {
	$('button').click(function() {
		if($(':text').val() == "")  {
			alert('ท่านยังไม่ได้กำหนด Login');
		}
		else if($(':password').val() == "") {
			alert('ท่านยังไม่ได้กำหนด Password');
		}
		else if($(':radio:checked').length == 0) {
			alert('ท่านยังไม่ได้เลือก User Type');
		}
		else {
			$('form').submit();
		}
	});
});
</script>
<body>
<div id="container">
<?php include "header.php"; ?>

<article>
<section id="top">
	<h3>เข้าสู่ระบบ</h3>
    <span>ต้องเข้าสู่ระบบก่อนการใช้งานทั้งหมด</span>
</section>
<section id="content">
<?php  echo '<h4 class="error">'.$msg.'</h4>';   ?>
<form method="post">
    <label>Login:</label><input type="text" name="login" required><br>
    <label>Password:</label><input type="password" name="pswd" required><br>
    <label>User Type:</label>
     	<input type="radio" name="type" value="testee">ผู้เข้าทดสอบ
        <input type="radio" name="type" value="tester">ผู้ทดสอบ
       <br>
    <div><button type="button" id="ok">ตกลง</button><br><br>
    หากยังไม่มี Login และ Password สามารถ <a href="register.php">ลงทะเบียนที่นี่</a></div>
</form>
</section>
</article>

<?php include "footer.php"; ?>
</div>
</html>