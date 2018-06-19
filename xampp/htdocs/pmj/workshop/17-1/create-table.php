<?php
$link = @mysqli_connect("localhost", "root", "", "vhv")
 				or die(mysqli_connect_error());

//ถ้ายังไม่มีฐานข้อมูลให้สร้างขึ้นมาใหม่
$sql = "CREATE DATABASE IF NOT EXISTS vhv";
mysqli_query($link, $sql);
mysqli_select_db($link, "vhv");

//ถ้ายังไม่มีตารางให้สร้างขึ้นใหม่
$sql = "CREATE TABLE IF NOT EXISTS member(
			id  MEDIUMINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
			email  VARCHAR(200) UNIQUE,
			password VARCHAR(20),
			name VARCHAR(150),
			verify VARCHAR(6))";
			
mysqli_query($link, $sql);
mysqli_close($link);
?>