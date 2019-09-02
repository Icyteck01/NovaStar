<?php
//var_dump($_POST);
//error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
if(session_id() == '') {
    session_start();
}

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] <= 0)
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

include "../configs.php";

if(!isset($_POST['companyOnOff']))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}
if(!isset($_POST['numberOfDrivers']))
{
		header("HTTP/1.0 404 Not Found");
		exit;
}

$numberOfDrivers = $_POST['numberOfDrivers'];
if(!is_numeric($numberOfDrivers))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

if(!isset($_POST['selectThisCar']) || isset($_POST['selectThisCar']) && !is_numeric($_POST['selectThisCar']))
{
	print "10|Please select the car.";
	exit;
}
if(!isset($_POST['reservation']) || isset($_POST['reservation']) && strpos($_POST['reservation'], '-') === false)
{
	print "10|".$CFG["PLEASE_SELECT_PICK"];
	exit;
}
if(!isset($_POST['franchise']) || isset($_POST['franchise']) && !is_numeric($_POST['franchise']))
{
	print "10|".$ERR["PSTFP"];
	exit;
}
if(!isset($_POST['pricePerDay']) || isset($_POST['pricePerDay']) && !is_numeric($_POST['pricePerDay']))
{
	print "10|".$ERR["PSTPPD"];
	exit;
}
if(!isset($_POST['pickup']) || empty($_POST['pickup']))
{
	echo "10|".$ERR["PLEASE_SELECT_PICK_LOC1"];
	exit;
}
if(!isset($_POST['return']) || empty($_POST['return']))
{
	echo "10|".$ERR["PLEASE_SELECT_PICK_LOC2"];
	exit;
}
$isCompany = strtolower($_POST['companyOnOff']) == "true";

if(!isset($_POST['CNP']) || empty($_POST['CNP']))
{
	echo "10|".($isCompany ? $ERR["ERR_1"]:$ERR["ERR_2"]);
	exit;
}
if(!isset($_POST['address']) || empty($_POST['address']))
{
	echo "10|".$isCompany?$ERR["ERR_4"]:$ERR["ERR_3"];
	exit;
}
if(!isset($_POST['name']) || empty($_POST['name']))
{
	echo "10|".$isCompany?$ERR["ERR_12"]:$ERR["ERR_13"];
	exit;
}
if(!isset($_POST['email']) || empty($_POST['email']))
{
	echo "10|".$isCompany?$ERR["ERR_5"]:$ERR["ERR_6"];
	exit;
}
if(!isset($_POST['licence']) || empty($_POST['licence']))
{
	if(!$isCompany)
	{
		echo "10|".$ERR["ERR_10"];
		exit;
	}
}
if(!isset($_POST['licence_expire']) || empty($_POST['licence_expire']))
{
	if(!$isCompany)
	{
		echo "10|".$ERR["ERR_11"];
		exit;
	}
}

if(!$isCompany)
{
	if(!isset($_POST['bday']) || empty($_POST['bday']))
	{
		if(!$isCompany)
		{
			echo "10|".$ERR["ERR_11"];
			exit;
		}
	}

	$test_arr  = explode('/', $_POST['bday']);
	if(!is_numeric($test_arr[0])){print "10|".$ERR["IRD"];exit;}
	if(!is_numeric($test_arr[1])){print "10|".$ERR["IRD"];exit;}
	if(!is_numeric($test_arr[2])){print "10|".$ERR["IRD"];exit;}
	if (!checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
		print "10|".$ERR["IRD"];
		exit;	
	}
}



$CNP_arry = array();
$name_arry = array();
$addres_arry = array();
$email_arry = array();
$phone_arry = array();
$bday_arry = array();
$driver_arry = array();
$driver_licence_arry = array();
if($isCompany || $numberOfDrivers > 0) {
$count = 1;
if(isset($_POST['CNP_DRIVER']))
{
	foreach ($_POST['CNP_DRIVER'] as $CNP_DRIVER) {
		if(strlen($CNP_DRIVER) < 3)
		{
			print "10|".$ERR["ETDUIN"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}
		$count++;
		$CNP_arry[] = mysql_real_escape_string($CNP_DRIVER);
	}
}else{
		print "10|".$ERR["ETDUIN"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
		exit;	
}

$count = 1;
if(isset($_POST['name_driver']))
{
	
	foreach ($_POST['name_driver'] as $name_driver) {
		if(strlen($name_driver) < 3)
		{
			print "10|".$ERR["ETDN"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}
		$name_arry[] = mysql_real_escape_string($name_driver);
		$count++;
	}
}else{
		print "10|".$ERR["ETDN"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
		exit;	
}
$count = 1;
if(isset($_POST['address_driver']))
{
	foreach ($_POST['address_driver'] as $address_driver) {
		if(strlen($address_driver) < 3)
		{
			print "10|".$ERR["ETA"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}
		$addres_arry[] = mysql_real_escape_string($address_driver);
		$count++;
	}
}else{
		print "10|".$ERR["ETA"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
		exit;	
}
$count = 1;
if(isset($_POST['email_driver']))
{
	foreach ($_POST['email_driver'] as $email_driver) {
		if(strlen($email_driver) < 3)
		{
			print "10|".$ERR["ETE"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}
		if(!filter_var($email_driver, FILTER_VALIDATE_EMAIL))
		{
			print "10|".$ERR["ITE"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}
		$email_arry[] = mysql_real_escape_string($email_driver);
		$count++;
	}
}else{
		print "10|".$ERR["ETE"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
		exit;	
}
$count = 1;
if(isset($_POST['phone_driver']))
{
	foreach ($_POST['phone_driver'] as $phone_driver) {
		if(strlen($phone_driver) < 3)
		{
			print "10|".$ERR["ETP"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}
		$phone_arry[] = mysql_real_escape_string($phone_driver);
		$count++;
	}
}else{
		print "10|".$ERR["ETP"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
		exit;	
}
$count = 1;
if(isset($_POST['bday_driver']))
{
	foreach ($_POST['bday_driver'] as $bday_driver) {
		if(strlen($bday_driver) < 3)
		{
			print "10|".$ERR["IBD"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}

		$test_arr  = explode('/', $bday_driver);
		if(!is_numeric($test_arr[0])){print "10|".$ERR["IBD"].'('.$CFG["DESC_DRIVER"].' '.$count.')';exit;}
		if(!is_numeric($test_arr[1])){print "10|".$ERR["IBD"].'('.$CFG["DESC_DRIVER"].' '.$count.')';exit;}
		if(!is_numeric($test_arr[2])){print "10|".$ERR["IBD"].'('.$CFG["DESC_DRIVER"].' '.$count.')';exit;}
		if (!checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
			print "10|".$ERR["IBD"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}	
		$bday_arry[] = mysql_real_escape_string($bday_driver);
		$count++;		
	}
}else{
		print "10|".$ERR["IBD"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
		exit;	
}
$count = 1;
if(isset($_POST['driver_licence']))
{
	foreach ($_POST['driver_licence'] as $driver_licence) {
		if(strlen($driver_licence) < 3)
		{
			print "10|".$ERR["EDL"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}
		$driver_arry[] = mysql_real_escape_string($driver_licence);
		$count++;
	}
}else{
		print "10|".$ERR["EDL"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
		exit;	
}
$count = 1;
if(isset($_POST['driver_licence_expire']))
{
	foreach ($_POST['driver_licence_expire'] as $driver_licence_expire) {
		if(strlen($driver_licence_expire) < 3)
		{
			print "10|".$ERR["EDLED"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}
		$test_arr  = explode('/', $driver_licence_expire);
		if(!is_numeric($test_arr[0])){print "10|".$ERR["IDLED"].'('.$CFG["DESC_DRIVER"].' '.$count.')';exit;}
		if(!is_numeric($test_arr[1])){print "10|".$ERR["IDLED"].'('.$CFG["DESC_DRIVER"].' '.$count.')';exit;}
		if(!is_numeric($test_arr[2])){print "10|".$ERR["IDLED"].'('.$CFG["DESC_DRIVER"].' '.$count.')';exit;}
		if (!checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
			print "10|".$ERR["IDLED"].'('.$CFG["DESC_DRIVER"].' '.$count.')';
			exit;	
		}	
		$driver_licence_arry[] = mysql_real_escape_string($driver_licence_expire);
		$count++;		
	}
}else{
		print "10|".$ERR["EDLED"];
		exit;	
}

}

$reservation_array = explode('-',$_POST['reservation']);
$pickUp = trim($reservation_array[0]);
$return = trim($reservation_array[1]);
$selectdCar = mysql_real_escape_string($_POST['selectThisCar']);
$franchise = mysql_real_escape_string($_POST['franchise']);
$pricePerDay = mysql_real_escape_string($_POST['pricePerDay']);
//Entity
$CNP = mysql_real_escape_string($_POST['CNP']);
$name = mysql_real_escape_string($_POST['name']);
$address = mysql_real_escape_string($_POST['address']);
$email = mysql_real_escape_string($_POST['email']);
$phone = mysql_real_escape_string($_POST['phone']);
$bday = mysql_real_escape_string($_POST['bday']);
$licence = mysql_real_escape_string($_POST['licence']);
$licence_expire = mysql_real_escape_string($_POST['licence_expire']);
$pickLocation = mysql_real_escape_string($_POST['pickup']);
$dropLocation = mysql_real_escape_string($_POST['return']);
$deds_joined = "";

if(isset($_POST['optionale']))
{
	$deds = array();
	foreach ($_POST['optionale'] as $ded) {
	  $deds[] = mysql_real_escape_string($ded);
	}
	$deds_joined = join(',', $deds);
}

include '../mysqlC.php';
$ContractId = uniqid();
$date1 = new DateTime($pickUp);
$date2 = new DateTime($return);
$daysTotalDif = $date2->diff($date1);
$days = $daysTotalDif->days;
$hourTotal = $daysTotalDif->h;
//var_dump($daysTotalDif);
if($hourTotal > 2)
{
$days++;	
}
if($days == 0)
{
$days = 1;
}
$total = $pricePerDay * $days;
$_drivers = "";
//Insert Drivers

/*
include '../mysqlC.php';
$ContractId = uniqid();
$date1 = new DateTime($pickUp);
$date2 = new DateTime($return);
$days = $date2->diff($date1)->format("%a");
$total = $pricePerDay * $days;
$_drivers = "";
*/



for ($i =0; $i<count($CNP_arry); $i++)
{
$query = "";
$query_prepare = "SELECT * FROM `entity_clients` WHERE CNP='".$CNP_arry[$i]."'";
$get_info = MySQL_Query($query_prepare) or die(mysql_error($link));
if(mysql_num_rows($get_info) > 0)
{
$query = "UPDATE `entity_clients` SET licenceID='".$driver_arry[$i]."', licenceexp='".$driver_licence_arry[$i]."', name='".$name_arry[$i]."', adress='".$addres_arry[$i]."', email='".$email_arry[$i]."', phone='".$phone_arry[$i]."', bday='".$bday_arry[$i]."' WHERE CNP='".$CNP_arry[$i]."';";
}else{
$query = "INSERT INTO `entity_clients` (`licenceID`, `licenceexp`, `CNP`, `isCompany`, `name`, `email`, `phone`, `bday`, `adress`, `moneySpent`) VALUES ('".$driver_arry[$i]."', '".$driver_licence_arry[$i]."', '".$CNP_arry[$i]."', '0', '".$name_arry[$i]."', '".$email_arry[$i]."', '".$phone_arry[$i]."', '".$bday_arry[$i]."', '".$addres_arry[$i]."', '0')";
}
	if(mysql_query($query) == FALSE)
	{
		print "11|".$ERR["FEPCAGSD"];
		exit;		
	}
	$query_prepare = "SELECT * FROM `entity_clients` WHERE CNP='".$CNP_arry[$i]."'";	
	$get_info = MySQL_Query($query_prepare) or die(mysql_error($link));
	if(mysql_num_rows($get_info) > 0)
	{	$row = mysql_fetch_array($get_info);
		$_drivers .= $row['id'].'_';
}else{
	print "12|".$ERR["FEPCAGSD"];
	exit;
	}
}
//$licence
//$licence_expire

$query = "INSERT INTO `entity_clients` (`licenceID`, `licenceexp`, `CNP`, `isCompany`, `name`, `email`, `phone`, `bday`, `adress`, `moneySpent`) VALUES ('$licence', '$licence_expire', '$CNP','".($isCompany ? 1:0)."', '$name', '$email', '$phone', '$bday', '$address', '$total') ON DUPLICATE KEY UPDATE licenceID = '$licence', licenceexp='$licence_expire', moneySpent=moneySpent+$total, name='$name', adress='$address', email='$email', phone='$phone', bday='$bday';";
if(mysql_query($query) == FALSE)
{
	print "13|".$ERR["FEPCAGSD"];
	exit;		
}

$mainDriverId = 0;

$query_prepare = "SELECT * FROM `entity_clients` WHERE CNP='$CNP'";	
$get_info = MySQL_Query($query_prepare) or die(mysql_error($link));
if(mysql_num_rows($get_info) > 0)
{	$row = mysql_fetch_array($get_info);
	$mainDriverId = $row['id'].'_';
}else{
	print "14|".$ERR["FEPCAGSD"];
	exit;
	}
	
if(!$isCompany && $numberOfDrivers == 0)
{
	$_drivers .= $mainDriverId;
}
$operatorId = $_SESSION['id'];
$query = "INSERT INTO `cars_in_rent` (`extra_items`, `moneyFran`, `noDays`, `carId`, `operatorId`, `pickLocation`, `dropLocation`, `contractiID`, `clientId`, `driversId`, `pickupDate`, `dropDate`, `moneyVar`) VALUES
 ('$deds_joined', '$franchise','$days', '$selectdCar','$operatorId', '$pickLocation', '$dropLocation', '$ContractId', '$mainDriverId', '$_drivers', '$pickUp', '$return', '$pricePerDay');";
MySQL_Query($query) or die(mysql_error($link));
mysql_query("UPDATE cars SET made=made+$total WHERE id=$selectdCar");
print "1|".$ContractId."|".$days;
mysql_close();

?>