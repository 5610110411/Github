<html>
<head>
    <title>Login PHP</title>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/bootstrap.css">


</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
            <h1>PHP Member</h1>
                <form action="checklogin.php" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email"> 
                    </div>
                    <div class="form=group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password"> 
                    </div>
                
                    <input type="submit" value="Log in" class="btn btn-primary">
                </form>
            </div>
            <div></div>
        </div>
    </div>

    <!--script type="text/javascript" src="js/bootstrap.js"></script-->
</body>

</html>