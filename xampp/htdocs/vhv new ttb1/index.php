
<!doctype html>
<html>
<head>
<title>ระบบ GIS สมุย</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="css/bootstrapPaper.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
	
	#map
	{
      height:450px;
      width:100%;
	}
	
	.panel-footer {
		padding: 10px 15px;
		background-color: #f5f5f5;
		border-top: 1px solid #dddddd;
		border-bottom-right-radius: 2px;
		border-bottom-left-radius: 2px;
		width:100%;
	}

	h1
	{
		color: #99CC00;
		margin: 0px 0px 20px;
		padding: 20px 0px 10px;
		font: bold 30px Verdana, Arial, Helvetica, sans-serif;
		border-bottom: 1px dashed #E6E8ED;
	}

	th{
		text-align: center;
	}

	.centered-form .panel
	{
    	background: rgba(255, 255, 255, 0.8);
    	box-shadow: rgba(0, 0, 0, 0.3) 1px 4px 9px;
	}

	/*color in dropdown list Moo and Tumbon*/
	.form-control-option 
	{
		color: #808B96;
	}

	body{
		font-size:18px;
	}
	/*
	.navbar-inverse{
		color: #99CC00;
	}
	*/

	.navbar-inverse {
    	background-color: #2196f3;
    	border-color: #2196f3;
	}

	.navbar-inverse .navbar-nav>li>a {
    	color: #fff;
	}

	.navbar-inverse .navbar-brand {
    	color: #fff;
	}
	table { 
    	table-layout:fixed;
	}
	td { 
		overflow: hidden; 
		text-overflow: ellipsis; 
		word-wrap: break-word;
	}
	
}
</style>

<script>

</script>

</head>
<body>
<!--  =================== Top bar============================================   -->
	<nav class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class='navbar-brand' href='http://www.kohsamuicity.go.th/frontpage'>เทศบาลนครเกาะสมุย</a>
			<a><img src='pages/phv/pictures/mainLogo.png' class='img-circle' alt='Cinque Terre' width='65' height='65'></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
			<ul class="nav navbar-nav">
				<li><a href='http://www.kohsamuicity.go.th/frontpage'>หน้าหลัก</a></li>
				<li><a href="pages/phv/main.php">GIS อสม.</a></li>
				<li><a href='pages/ttb/login.php'>GIS รพ. 10,000 เตียง</a></li>
			</ul>
			
			</div>
		</div>
	</nav>
	<div class="container">
		<h1 align="center">ระบบสารสนเทศภูมิศาสตร์ อำเภอเกาะสมุย</h1>
		<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
			<a href="pages/phv/main.php" class="btn btn-default btn-lg btn-block">อาสาสมัครสาธารณสุขประจำหมู่บ้าน</a>
			<br>
			<a href="pages/ttb/login.php" class="btn btn-default btn-lg btn-block">โครงการโรงพยาบาล 10,000 เตียง</a>
		</div>
	</div>	
</body>
</html>


