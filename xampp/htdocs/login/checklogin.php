<?php
session_start();
include("connect.php");

/*
1 = Admin
2 = User
3 = Boss

*/

// variable
$email = $_POST['email'];
$password = md5($_POST['password']);

if($email == ''){
    echo "Check Email";
}else if($password == ''){
    echo "Check Password";
}else{
    $sql = mysql_query("SELECT * FROM user_tbl
                        WHERE email = '$email' 
                        AND password = '$password' ");
    $num = mysql_num_rows($sql);
    if($num <= 0){
        echo "<meta http-equiv='refresh' content='1;URL=index.php'>";
    }else {
        while($user = mysql_fetch_array($sql)){
            
            if($user['status'] == 1){
                // Admin case
                $_SESSION['ses_id'] = session_id();
                $_SESSION['email'] = $user['email'];
                $_SESSION['status'] = 1;
                // send to admin page
                echo "<meta http-equiv='refresh' content='1;URL=admin.php'>";
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
                echo "<meta http-equiv='refresh' content='1;URL=boss.php'>";

            }
        }
    }
}

?>