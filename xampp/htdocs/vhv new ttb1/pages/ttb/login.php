<html>
<head>
    <title>ระบบสารสนเทศภูมิศาสตร์</title>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <!--link rel="stylesheet" href="css/bootstrap.css"-->
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
<!--  =================== Top bar============================================   -->
<nav class='navbar navbar-inverse'>
	<div class='container'>
		<div class='navbar-header'>
		<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#bs-example-navbar-collapse-2'>
			<span class='sr-only'>Toggle navigation</span>
			<span class='icon-bar'></span>
			<span class='icon-bar'></span>
			<span class='icon-bar'></span>
		</button>
		<a class='navbar-brand' href='http://www.kohsamuicity.go.th/frontpage'>เทศบาลนครเกาะสมุย</a>
		<a><img src='pictures/mainLogo.png' class='img-circle' alt='Cinque Terre' width='60' height='60'></a>
		</div>

		<div class='collapse navbar-collapse' id='bs-example-navbar-collapse-2'>
        <ul class='nav navbar-nav'>
            <li><a href='../../index.php'>หน้าหลัก</a></li>
            <li><a href='../phv/main.php'>GIS อสม.</a></li>
            <li><a href='login.php'>GIS รพ. 10,000 เตียง</a></li>
        </ul>
		</div>
	</div>
</nav>

<div class="login-form">
    <form action="checklogin.php" method="post">
        <h2 class="text-center">เข้าสู่ระบบ</h2>
        <h5 class="text-center">GIS โครงการโรงพยาบาล 10,000 เตียง</h5>         
        <div class="form-group">
            <input type="text" class="form-control" placeholder="E-Mail" name="email" id="email" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </div>
        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input type="checkbox"> จำรหัสผ่าน</label>
            <a href="#" class="pull-right">ลืมรหัสผ่าน?</a-->
        </div>        
    </form>
    <p class="text-center"><a href="signup.php">สร้างบัญชี</a></p>
</div>
</body>

</html>