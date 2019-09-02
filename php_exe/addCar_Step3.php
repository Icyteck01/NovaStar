<?php
//var_dump($_POST);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

if(session_id() == '') {
    session_start();
}

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] != 2)
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

include "../configs.php";

if(!isset($_POST['plate']) || empty($_POST['plate']))
{
	echo "10|".$ERR["PETLPN"];
	exit;
}

if(!isset($_POST['inspection']) || empty($_POST['inspection']) && strlen($_POST['inspection']) == 0)
{
	echo "10|".$ERR["PETTKOMWTCSTCOOAKOI"];
	exit;
}

if(!isset($_POST['service']) || empty($_POST['service']) && strlen($_POST['service']) == 0)
{
	echo "10|".$ERR["PETTKOMWTCSTGTSFTI"];
	exit;
}
$plate = mysql_real_escape_string($_SESSION['plate']);
$inspection = mysql_real_escape_string($_POST['inspection']);
$service = mysql_real_escape_string($_POST['service']);


include '../mysqlC.php';
$sqlQuery = "INSERT INTO cars_temp (`plate`, `year`, `engine`) VALUES ('".$plate."', '".$inspection."', '".$service."') ON DUPLICATE KEY UPDATE plate='".$plate."', inspectionKM='".$inspection."', revisionKM='".$service."'";
$query = mysql_query($sqlQuery) or die(mysql_error());
if(!$query)
{
mysql_close();
	header("HTTP/1.0 404 Not Found");
}else{

$query_prepare = "SELECT * FROM `cars_temp` WHERE plate='$plate'";
$get_info = MySQL_Query($query_prepare) or die(mysql_error($link));
if(mysql_num_rows($get_info) > 0)
{
	$row = mysql_fetch_array($get_info);
	$inser_final_query = "INSERT INTO `crs`.`cars` (`id`, `plate`, `name`, `comfort`, `poza`, `engine`, `doors`, `seets`, `gearbox`, `gas`, `type`, `year`, `echipare`, `cureentKM`, `inspectionKM`, `revisionKM`, `defects`, `VIN`, `tankFuel`) VALUES (NULL, '".$row['plate']."', '".$row['name']."', '".$row['comfort']."', '".$row['poza']."', '".$row['engine']."', '".$row['doors']."', '".$row['seets']."', '".$row['gearbox']."', '".$row['gas']."', '".$row['type']."', '".$row['year']."', '".$row['echipare']."', '".$row['cureentKM']."', '".$row['inspectionKM']."', '".$row['revisionKM']."', '".$row['defects']."', '".$row['VIN']."', '".$row['tankFuel']."');";
	$inser_final_queryx = mysql_query($inser_final_query) or die(mysql_error());
	if(!$inser_final_queryx)
	{
		header("HTTP/1.0 404 Not Found");
	}else{
		
		mysql_query("DELETE FROM `cars_temp` WHERE plate='$plate'");
	}
	mysql_close();
	$_SESSION['plate'] = "";
	echo"1|1";		
}else{
	header("HTTP/1.0 404 Not Found");
}	


}

?>