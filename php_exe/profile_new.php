<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

if(session_id() == '') {
    session_start();
}

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] <= 1)
{
	header("HTTP/1.0 404 Not Found");
	exit;
}
include "../configs.php";
if(!isset($_POST['emploieNAME']))
{

	print "10|".$ERR["ERR_21"];
	exit;	
}
$emploieNAME = $_POST['emploieNAME'];
if(!isset($_POST['emploieJOBTITLE']))
{

	print "10|".$ERR["ERR_21"];
	exit;	
}
$emploieJOBTITLE = $_POST['emploieJOBTITLE'];
if(!isset($_POST['emploiePRIV']))
{

	print "10|".$ERR["ERR_21"];
	exit;	
}
$emploiePRIV = $_POST['emploiePRIV'];
if(!isset($_POST['emploiePASS']))
{

	print "10|".$ERR["ERR_21"];
	exit;	
}
$emploiePASS = $_POST['emploiePASS'];
if(!isset($_POST['emploieREALNAME']))
{

	print "10|".$ERR["ERR_21"];
	exit;	
}
$emploieREALNAME = $_POST['emploieREALNAME'];
if (strlen($emploiePASS) > 20 || strlen($emploiePASS) < 4)
{
	print "10|".$ERR["ERR_20"];
	exit;	
}
if (ctype_alnum($emploiePASS) != true)
{
	print "10|".$ERR["ERR_19"];
	exit;	
}
if (ctype_alnum($emploieNAME) != true)
{
	print "10|".$ERR["ERR_22"];
	exit;	
}


$emploieREALNAME = mysql_real_escape_string($emploieREALNAME);
$emploieNAME = mysql_real_escape_string($emploieNAME);
$emploiePASS = mysql_real_escape_string($emploiePASS);
$emploieJOBTITLE = mysql_real_escape_string($emploieJOBTITLE);
$emploiePRIV = mysql_real_escape_string($emploiePRIV);

include '../mysqlC.php';
$query = "INSERT INTO `crs`.`user_accounts` (`id`, `email`, `password`, `name`, `jobTitle`, `image`, `privilege`, `lastLogin`, `lastLoginIp`, `joinDate`, `totalDeals`, `badDeals`, `goodDeals`, `IMAPset`, `IMAPuser`, `imapPass`, `moneyMade`)
 VALUES (NULL, '$emploieNAME', '$emploiePASS', '$emploieREALNAME', '$emploieJOBTITLE', 'default.jpg', '$emploiePRIV', '', '', CURRENT_TIMESTAMP, '0', '0', '0', '0', '', '', '0')";
mysql_query($query);
mysql_close();
print "1|1";
?>