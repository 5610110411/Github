<?php
    session_start();
    // check login
    if($_SESSION['ses_id'] == ''){
        echo "<meta http-equiv='refresh' content='1;URL=index.php'>";
    }else if($_SESSION['status'] != 2){
        echo "<meta http-equiv='refresh' content='1;URL=logout.php'>";
    }else{
?>


<h1>User page</h1>
<a href="logout.php" class"btn btn-primary">logout</a>
<?php
    }
?>