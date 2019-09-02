<?php
ob_start();
session_start();
print'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>RentIt.Today User Panel</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/auth.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <div id="page-wrapper">
            <div class="container-fluid">
<center><img src="../images/logo.png" alt="" style="margin-top:-90px;"></img></center>
<div class="container">
';

$error = "";
$loginForm ="display: block;";
$registerForm ="display: none;";
$canshow_form = true;
$loginFormA ="active";
$registerFormA ="";
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
$userip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
$userip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
$userip = $_SERVER['REMOTE_ADDR'];
}

if(isset($_POST['login-submit']))
{


$inpUser = $_POST['email'];
$inpPass = $_POST['password'];


if(!isset( $_POST['email'],$_POST['password']))
{
    $message = 'Please make sure you have the filled the form correctly';
	$error.= '
	<div class="alert alert-danger" role="alert">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Error:</span>
	  Please make sure you have the filled the form correctly
	</div>';	
}
elseif (!filter_var($inpUser, FILTER_VALIDATE_EMAIL))
{
	$error.= '
	<div class="alert alert-danger" role="alert">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Error:</span>
	  Incorrect Email
	</div>';	
}
elseif (strlen( $_POST['password']) > 20 || strlen($_POST['password']) < 4)
{
	$error.= '
	<div class="alert alert-danger" role="alert">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Error:</span>
	  Incorrect Length for Password! Must be bettween 20 and 4 characters
	</div>';	
}
elseif (ctype_alnum($_POST['password']) != true)
{
	$error.= '
	<div class="alert alert-danger" role="alert">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Error:</span>
	    Password must be alpha numeric
	</div>';	
}else{

	include '../config.php';
	
	$inpUser = mysql_real_escape_string($inpUser);
	$inpPass = mysql_real_escape_string(encrypt($inpPass));
		$stmtz = sprintf('SELECT * FROM _accounts WHERE userName = "%s" and passWord="%s"', $inpUser, $inpPass);
		$stmtz = mysql_query($stmtz);
		if (mysql_num_rows($stmtz) > 0){
			$row = mysql_fetch_array($stmtz);

			$userID = $row['uid'];
			$_SESSION['uid'] = $userID;
			$_SESSION['userName'] = $row['userName'];
			$_SESSION['lastLogin'] = $row['lastLogin'];
			mysql_query("UPDATE _accounts SET lastLoginIp='$userip' WHERE uid = '$userID'");
			$error.= '
			<div class="alert alert-success" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">axx:</span>
			  Login Success! Please wait...
			</div>';
			mysql_query("UPDATE `_accounts` SET `lastLogin`=NOW() WHERE `uid`=$userID");
			mysql_close();
			$canshow_form = false;
			print'<meta http-equiv="refresh" content="1;url=/user/index">';	
		}else{		
			$error.= '
			<div class="alert alert-danger" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Error:</span>
			  Please make sure you have the filled the form correctly
			</div>';			
		}
}


}

if(isset($_GET['new']))
{
$loginForm ="display: none;";
$registerForm ="display: block;";
}


print $error;
if($canshow_form)
{
print'
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
								<h4>Rentit Login</h4>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="auth" method="post" role="form" style="'.$loginForm.'">
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

';	
}
?>
	
	
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


<script>
$(function() {

    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});	
</script>
</body>

</html>
