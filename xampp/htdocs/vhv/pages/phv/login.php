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
    <form action="checklogin.php" method="post">
        <h2 class="text-center">เข้าสู่ระบบ</h2>
        <h5 class="text-center">GIS อสม. อำเภอเกาะสมุย</h5>        
        <div class="form-group">
            <input type="text" class="form-control" placeholder="E-Mail" name="email" id="email" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">เข้าสู่ระบบ</button>
        </div>
        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input type="checkbox"> จำรหัสผ่าน</label>
            <a href="#" class="pull-right">ลืมรหัสผ่าน?</a-->
        </div>        
    </form>
    <p class="text-center"><a href="#">สร้างบัญชี</a></p>
</div>
    <!--div class="container">
        <br>
        <br>
        <br>
        <h1 align="center">ระบบสารสนเทศภูมิศาสตร์(GIS) อำเภอเกาะสมุย</h1>
            <br>
            <br>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="/vhv/pages/checklogin.php" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email"> 
                    </div>
                    <div class="form=group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password"> 
                    </div>
                    <div class="form=group">
                        <br>
                        <input type="submit" value="เข้าสู่ระบบ" class="btn btn-info btn-block">
                    </div>
                </form>
            </div>
            <div></div>
        </div>
    </div-->
    <!--script type="text/javascript" src="js/bootstrap.js"></script-->
</body>

</html>