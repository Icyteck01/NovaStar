<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

if(session_id() == '') {
    session_start();
}

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] < 1)
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

include "../configs.php";
$userID = $_SESSION['id'];

if(!isset($_POST['imapMail']))
{

	print "10|".$ERR["ETE"];
	exit;	
}
$imapMail = $_POST['imapMail'];
if(!filter_var($imapMail, FILTER_VALIDATE_EMAIL))
{
	print "10|".$ERR["ITE"];
	exit;	
}

if(!isset($_POST['imapPassword']))
{

	print "10|".$ERR["ERR_15"];
	exit;	
}
$imapPassword = $_POST['imapPassword'];
if(!isset($_POST['multipleimap']))
{

	print "10|".$ERR["ERR_16"];
	exit;	
}
$multipleimap = $_POST['multipleimap'];
if(!is_numeric($multipleimap))
{

	print "10|".$ERR["ERR_16"];
	exit;	
}
$imapMail = mysql_real_escape_string($imapMail);
$multipleimap = mysql_real_escape_string($multipleimap);
$imapPassword = mysql_real_escape_string($imapPassword);
include '../mysqlC.php';
$query = "UPDATE user_accounts SET IMAPset = '$multipleimap',IMAPuser = '$imapMail',imapPass = '$imapPassword' WHERE id='$userID'";
$_SESSION['IMAPset'] = $multipleimap;				
$_SESSION['IMAPuser'] = $imapMail;				
$_SESSION['imapPass'] = $imapPassword;	
mysql_query($query);
mysql_close();
print "1|1";
?>