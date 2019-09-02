<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

if(session_id() == '') {
    session_start();
}
if(!isset($_SESSION['privilege']) || !isset($_SESSION['id']))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

include '../configs.php';

if(isset($_POST["uid"],$_POST["type"]) && is_numeric($_POST['uid']) && is_numeric($_POST['type'])) {
$userID = $_SESSION['id'];	
$id = mysql_real_escape_string($_POST['uid']);	
$operation = mysql_real_escape_string($_POST['type']);	


include '../mysqlC.php';
if($operation == 0){
$sql = "INSERT INTO `cars_in_service` (`carId`,`status`) VALUES ('$id', '0');";
}else{
$sql = "INSERT INTO `cars_in_transit` (`carId`,`employeeID`, `status`) VALUES ('$id', '$userID', '0');";
}
if(mysql_query($sql))
{
	print "1|";
}else{
	print "10|".$CFG['formDataInvalid'];
}

mysql_close();
}else{
	print "10|".$CFG['formDataInvalid'];
}
?>