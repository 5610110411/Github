<?php
    session_start();
    // check login
   /* 
    if($_SESSION['ses_id'] == undefined){
        $ses_id = NULL;
    }else{
        $ses_id = $_SESSION['ses_id'];
    }
    */

    //http://localhost/login/admin.php
    if(!isset($_SESSION['ses_id'])){
        echo "<meta http-equiv='refresh' content='1;URL=index.php'>";
    }else if($_SESSION['status'] != 1){
        echo "<meta http-equiv='refresh' content='1;URL=logout.php'>";
    }else{
?>


<h1>Admin page</h1>
<a href="logout.php" class"btn btn-primary">logout</a>
<?php
    }
?>