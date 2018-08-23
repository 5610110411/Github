<html>
<head>
    <title>ระบบสารสนเทศภูมิศาสตร์</title>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <!--link rel="stylesheet" href="css/bootstrap.css"-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/bootstrapPaper.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
	.login-form {
		width: 380px;
    	margin: 50px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
    </style>
</head>
<body>
<?php include('topbarNormalUser.php'); ?>

<div class="login-form">
    <form action="signupprocess.php" method="post">
        <h2 class="text-center">ลงทะเบียน</h2>       
        <div class="form-group">
            <input type="text" class="form-control" placeholder="ชื่อ" name="firstname" id="firstname">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="นามสกุล" name="lastname" id="lastname">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="E-Mail" name="email" id="email">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">ลงทะเบียน</button>
        </div>
        <div class="form-group">
            <p class="text-center"><a href="login.php">ยกเลิก</a></p>
        </div> 
    </form>

</div>
</body>

</html>