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
	h2.blue {
		color: #0c7cd5;
	}
</style>
<title>กำลังกลับสู่หน้าหลัก...</title>
</head>

<body>
	<h2 class="blue">ท่านออกจากระบบแล้ว จะกลับสู่หน้าหลักใน <span class="blue" id="countdowntimer">3</span> วินาที</h2>
	

	<script type="text/javascript">
		var timeleft = 3;
		var downloadTimer = setInterval(function(){
		timeleft--;
		document.getElementById("countdowntimer").textContent = timeleft;
		if(timeleft <= 0)
			clearInterval(downloadTimer);
		},1000);
	</script>
</body>
</html>