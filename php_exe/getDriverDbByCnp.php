<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

if(session_id() == '') {
    session_start();
}
include "../configs.php";

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] < 1)
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

if(isset($_POST['ISCOMPANY'],$_POST['SERCHBY'],$_POST['VALUE']))
{
	
$ISCOMPANY = $_POST['ISCOMPANY'];
$SERCHBY = $_POST['SERCHBY'];
$VALUE = $_POST['VALUE'];
if(!is_numeric($VALUE))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}
$VALUE = mysql_real_escape_string($VALUE);
$query = "";
switch($SERCHBY)
{
	case "byID":
		if(strtolower($ISCOMPANY) == "true")
		{
			$query = "SELECT * FROM `entity_clients` WHERE isCompany='1' AND CNP like '$VALUE%'";
		}else{
			$query = "SELECT * FROM `entity_clients` WHERE isCompany='0' AND  CNP like '$VALUE%'";
			
		}
	break;
}

if(strlen($query) > 0)
{
include '../mysqlC.php';

$get_info = MySQL_Query($query);
if(mysql_num_rows($get_info) == 1)
{
	$row = mysql_fetch_assoc($get_info);
	header('Content-Type: application/json');
	print '{"result":true,"data":'.json_encode($row).'}';
}else{
	header('Content-Type: application/json');
	print '{"result":false}';
}
mysql_close();
}else{
	header("HTTP/1.0 404 Not Found");
	exit;	
}
}else{
	header("HTTP/1.0 404 Not Found");
	exit;
}
?>