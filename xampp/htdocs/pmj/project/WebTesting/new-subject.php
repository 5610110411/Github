<?php
include "check-user.php";
//ต้องเป็นผู้ทดสอบเท่านั้นที่จะเปิดเพจนี้ได้(ป้องกันการเปิดเพจนี้โดยตรงของผู้เข้าทดสอบ)
if($_SESSION['user'] != "tester") {
	die("For Tester Only");
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
		width: 850px;
		border: solid 0px green;
		border-radius: 8px;
 		margin: 15px auto 2px;
		padding: 10px 0px;
		background: #cee;
	}
	form input:not([type=radio]) {
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
	form label#time {
		width: 238px !important;
	}
	form div {
		text-align:center;
		margin-top: 10px;
	}
	form button {
		background: steelblue;
		color: white;
		border: solid 1px orange;
		padding: 3px;
		width: 80px;
		margin-right: 50px;
	}
	form button:hover {
		color: aqua;
		cursor: pointer;
	}
	form input[name=subject] {
		width: 400px;	
	}
	form input[type=date] {
		margin: 2px;
	}
	blockquote {
		font-style: italic;
		text-align: center;
		margin: auto;
		padding-top: 5px;
		color: brown;
	}
	section#content h4 {
		text-align: center;
		color: green;
	}
	section#content h4.err {
		color: red;
	}
	section#content h4 img {
		margin-right: 3px;
		vertical-align: middle;
	}
</style>
<script src="js/jquery-2.1.1.min.js"></script>
<script>
$(function() {
	$('#ok').click(function(event) { 
		if($(':text').val().length == 0) {
			alert('ท่านยังไม่ได้กำหนดหัวข้อการทดสอบ');
			return;
		}
		
		if($(':radio:checked').length == 0) {
			alert('ท่านยังไม่ได้กำหนดวันเวลาที่จะทดสอบ');
			return;
        }
		$('form').submit();
	});
	
	$('#cancel').click(function() {
		window.location = 'index.php';
	});
});
</script>
</head>

<body>
<?php
$msg = "";

if($_POST) {
	include "dblink.php";
	
	$subject = $_POST['subject'];
	$date_test = $_POST['date'];
	$time_start = "";
	$time_end = "";
	if($_POST['datetime']=="yes") {
		$time_start = $_POST['time_start'];
		$time_end = $_POST['time_end'];
	}
	
	$sql = "REPLACE INTO subject VALUES(
				'', '$subject', '$date_test', '$time_start', '$time_end')";
	
	if(@mysqli_query($link, $sql)) {
		$msg = '<h4><img src="images/ok.png">จัดเก็บข้อมูลแล้ว...เพิ่มหัวข้อถัดไปหรือกลับ <a href="index.php">หน้าหลัก</a></h4>';
	}
	else {
		$msg = '<h4 class="err"><img src="images/no.png">เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาลองใหม่</h4>';
	}
	
	mysqli_close($link);
}
?>
<div id="container">
<?php include "header.php"; ?>

<article>
<section id="top">
	<h3>เพิ่มหัวข้อการทดสอบ</h3>
    <span>หากกำหนดวันเวลา จะทำให้ผู้เข้าทดสอบสามารถทำแบบทดสอบได้เฉพาะในวันและช่วงเวลาที่กำหนดเท่านั้น</span>
</section>

<section id="content">
<?php echo $msg;  ?>
<form method="post">
	<label>หัวข้อการทดสอบ:</label><input type="text" name="subject"><br>
    <label>วันเวลาที่จะทดสอบ:</label><input type="radio" name="datetime" value="no">ไม่กำหนด (ทดสอบเมื่อไหร่ก็ได้)<br>
    <label></label><input type="radio" name="datetime" value="yes">กำหนดวันเวลา
     	<input type="date" name="date"> <input type="time" name="time_start"> - <input type="time" name="time_end">
    
    <br><br>
    <div>
     	<button type="button" id="ok">ตกลง</button>
         <a href="index.php">ยกเลิก</a>
	</div>
</form>
<blockquote>หากอิลิเมนต์ในการกำหนดวันเดือนปีและเวลาเป็นช่อง text ธรรมดา แสดงว่าเบราเซอร์ที่ท่านกำลังใช้อยู่ <br>อาจยังไม่สนับสนุนอิลิเมนต์เหล่านี้ เราแนะนำให้ใช้ Chrome หรือ Opera เวอร์ชั่นล่าสุด</blockquote><br>
</section>

</article>
<?php include "footer.php"; ?>
</div>
</body>
</html>