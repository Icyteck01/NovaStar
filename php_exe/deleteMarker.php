<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
if(session_id() == '') {
    session_start();
}
if(!isset($_SESSION['privilege']) && $_SESSION['privilege'] <= 1)
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

if(isset($_POST['uid']) && is_numeric($_POST['uid']))
{
	include '../mysqlC.php';	
	$carID = mysql_real_escape_string($_POST['uid']);
	if(MySQL_Query("UPDATE `cars` SET `deleted` = '1' WHERE `id` ='$carID'"))
	{
		print "1|1";
	}else{
		header("HTTP/1.0 404 Not Found");
	}
	mysql_close();
	exit;
}
header("HTTP/1.0 404 Not Found");
exit;
?>