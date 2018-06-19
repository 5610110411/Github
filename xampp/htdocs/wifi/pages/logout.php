<?php
header("refresh: 20; url=../index.php");
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
	h2.green {
		color: #060;
	}
</style>
<title>กำลังกลับสู่หน้าหลัก...</title>
</head>

<body>
	<h2 class="green">โปรดรอการตอบกลับจากเจ้าหน้าที่ทางอีเมล <?php echo $_GET['email']; ?></h2>
	<h2 class="green">กำลังกลับสู่หน้าหลักใน <span class="green" id="countdowntimer">20</span> วินาที</h2>
	

	<script type="text/javascript">
		var timeleft = 20;
		var downloadTimer = setInterval(function(){
		timeleft--;
		document.getElementById("countdowntimer").textContent = timeleft;
		if(timeleft <= 0)
			clearInterval(downloadTimer);
		},1000);
	</script>
</body>
</html>