<?php
session_start();
include "../../dblink_ttb.php";

function test_input($data){
    $data = trim($data);
    $data = htmlspecialchars($data);//Convert special characters to HTML entities
    return $data;
}
/*
1 = Admin
2 = User
3 = Boss

*/

// variable
$email = test_input($_POST['email']);
$password = test_input($_POST['password']);

$email = strtolower($email);

if($email == ''){
    echo "Check Email";
}else if($password == ''){
    echo "Check Password";
}else{
   
    $sql = "SELECT * FROM memberttb WHERE email LIKE '$email' AND password LIKE '$password'";
    //echo $sql;
    mysqli_query($link, "SET CHARACTER SET UTF8");
    $filter_Result = mysqli_query($link, $sql);
    $num = mysqli_num_rows($filter_Result);
    if($num <= 0){
        echo "<meta http-equiv='refresh' content='1;URL=login.php'>";
    }else {
        while($user = mysqli_fetch_array($filter_Result)){
            if($user['status'] == 1){
                // Admin case
                $_SESSION['ses_id'] = session_id();
                $_SESSION['email'] = $user['email'];
                $_SESSION['status'] = 1;
                // send to admin page
                echo "<meta http-equiv='refresh' content='1;URL=home.php'>";
            }else if($user['status'] == 2){
                // user case
                $_SESSION['ses_id'] = session_id();
                $_SESSION['email'] = $user['email'];
                $_SESSION['status'] = 2;
                // send to user page
                echo "<meta http-equiv='refresh' content='1;URL=user.php'>";
            }else{
                // Boss case
                $_SESSION['ses_id'] = session_id();
                $_SESSION['email'] = $user['email'];
                $_SESSION['status'] = 3;
                // send to boss page
                echo "<meta http-equiv='refresh' content='1;URL=waitforconfirm.php'>";

            }
        }
    }
}

?>