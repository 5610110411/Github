<?php
//session_start();
include "../../dblink_ttb.php";

  function databaseQuery($sql)
  {
    include "../../dblink_ttb.php";
    //$link = mysqli_connect("localhost", "root", "", "wifi_regis") or die(mysqli_connect_error());
    mysqli_query($link, "SET CHARACTER SET UTF8");
    $result = mysqli_query($link, $sql);
    //mysqli_close($link);
    return $result;
  }

/*
1 = Admin
2 = User
3 = Boss

*/

// variable
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
//$password = md5($_POST['password']);
$password = ($_POST['password']);

if($email == ''){
  echo "<script type='text/javascript'>
          alert('กรุณากรอกอีเมล');
          window.location='signup.php';
        </script>";
}if($password == ''){
  echo "<script type='text/javascript'>
        alert('กรุณากรอกรหัสผ่าน');
        window.location='signup.php';
      </script>";
}else{
    $sql = "SELECT * FROM memberttb WHERE email LIKE '$email' AND password LIKE '$password'";
    //echo $sql;
    mysqli_query($link, "SET CHARACTER SET UTF8");
    $filter_Result = mysqli_query($link, $sql);
    $num = mysqli_num_rows($filter_Result);
    if($num == 0){ // no data => Allow adding
        $timestamp = date('Y-m-d G:i:s');
        $sql   = "INSERT INTO `memberttb`(`timestamp`, `firstname`, `lastname`, `email`, `password`, `status`) 
                    VALUES ('$timestamp', '$firstname' , '$lastname', '$email', '$password', '0')";
        $result = databaseQuery($sql);
        echo "<script type='text/javascript'>
          alert('บันทึกข้อมูลเสร็จสิ้น กรุณารอการตอบกลับผ่าน E-mail');
          window.location='login.php';
        </script>";    
    }
    else if($num >= 1){
        echo "<script type='text/javascript'>
          alert('E-mail ของท่านได้ทำการลงทะเบียนเรียบร้อยแล้ว');
          window.location='login.php';
        </script>";
    }
    else{
        echo "<script type='text/javascript'>
          alert('พบข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่ โทร 097-351-8111');
          window.location='login.php';
        </script>";
    }
}
?>