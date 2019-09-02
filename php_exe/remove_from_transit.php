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

if(isset($_POST['type'],$_POST['moneySpent'],$_POST['kmOnBoard'],$_POST['id'],$_POST['cureentKM'],$_POST['fuelTank'],$_POST['moneySpent'],$_POST['carid']))
{

$moneySpent = $_POST['moneySpent'];
$kmOnBoard = $_POST['kmOnBoard'];
$id = $_POST['id'];
$cureentKM = $_POST['cureentKM'];
$tankFuel = $_POST['fuelTank'];
$carid = $_POST['carid'];
$type = $_POST['type'];
if(!is_numeric($type))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}
if(!is_numeric($carid))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

if(!is_numeric($tankFuel))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

if(!is_numeric($moneySpent))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}
if(!is_numeric($kmOnBoard))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}
if(!is_numeric($id))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}
if(!is_numeric($cureentKM))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}
if($cureentKM > $kmOnBoard)
{
	
	print "10|".$CFG['HMICZXC'];
	
}

if($tankFuel > 8)
{
	$tankFuel = 8;
}
if($tankFuel < 0)
{
	$tankFuel = 0;
}
$moneySpent = mysql_real_escape_string($moneySpent);
$kmOnBoard = mysql_real_escape_string($kmOnBoard);

$id = mysql_real_escape_string($id);
$cureentKM = mysql_real_escape_string($cureentKM);
$tankFuel = mysql_real_escape_string($tankFuel);
$carid = mysql_real_escape_string($carid);

$table = "";

switch($type)
{
	case 0://transit
	  $table = "cars_in_transit";
	break;
	case 1://service
	 $table = "cars_in_service";
	break;	
	case 2://service
	 $table = "cars_in_rent";
	break;		
}

if(strlen($table) < 2)
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

include '../mysqlC.php';

if(mysql_query("UPDATE cars SET spent ='$moneySpent', tankFuel ='$tankFuel', cureentKM ='$kmOnBoard' WHERE id='$id'"))
{
	if(mysql_query("UPDATE $table SET status =1 WHERE id = '$carid'"))
	{
		print "1|1";
		mysql_close();
		exit;
	}
}


header("HTTP/1.0 404 Not Found");

}else{
	header("HTTP/1.0 404 Not Found");
	exit;
}


?>