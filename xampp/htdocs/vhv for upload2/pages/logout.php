<?php
session_start();
unset($_SESSION['ses_id']);
unset($_SESSION['email']);
unset($_SESSION['status']);
session_destroy();

header("refresh: 3; url=../index.php");


//echo "<meta http-equiv='refresh' content='1;URL=../index.php'>";
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
	body {
		cursor: wait;
		text-align: center;
	}
	h3.green {
		color: #060;
	}
</style>
<title>กำลังกลับสู่หน้าหลัก...</title>
</head>

<body>
	<h3 class="green">ท่านออกจากระบบแล้ว จะกลับสู่หน้าหลักใน 3 วินาที</h3>
</body>
</html>