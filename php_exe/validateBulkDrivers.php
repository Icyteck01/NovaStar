<?php

if(isset($_POST['numberOfDrivers']))
{
	$numberOfDrivers = $_POST['numberOfDrivers'];
	if(!is_numeric($numberOfDrivers))
	{
		header("HTTP/1.0 404 Not Found");
		exit;
	}
	if($numberOfDrivers == 0 && isset($_POST['companyOnOff']) && strtolower($_POST['companyOnOff']) == "false")
	{
	header('Content-Type: application/json');
	print "{ \"result\":1 , \"data\": \"NULL\" }";
		exit;
	}
include "../configs.php";

$CNP_arry = array();
$name_arry = array();
$addres_arry = array();
$email_arry = array();
$phone_arry = array();
$bday_arry = array();
$driver_arry = array();
$driver_licence_arry = array();

if(isset($_POST['CNP_DRIVER']))
{
	foreach ($_POST['CNP_DRIVER'] as $CNP_DRIVER) {
		if(strlen($CNP_DRIVER) < 3)
		{
			print "10|".$ERR["ETDUIN"];
			exit;	
		}
		$CNP_arry[] = $CNP_DRIVER;
	}
}else{
		print "10|".$ERR["ETDUIN"];
		exit;	
}

if(isset($_POST['name_driver']))
{
	foreach ($_POST['name_driver'] as $name_driver) {
		if(strlen($name_driver) < 3)
		{
			print "10|".$ERR["ETDN"];
			exit;	
		}
		$name_arry[] = $name_driver;
	}
}else{
		print "10|".$ERR["ETDN"];
		exit;	
}

if(isset($_POST['address_driver']))
{
	foreach ($_POST['address_driver'] as $address_driver) {
		if(strlen($address_driver) < 3)
		{
			print "10|".$ERR["ETA"];
			exit;	
		}
		$addres_arry[] = $address_driver;
	}
}else{
		print "10|".$ERR["ETA"];
		exit;	
}	


if(isset($_POST['email_driver']))
{
	foreach ($_POST['email_driver'] as $email_driver) {
		if(strlen($email_driver) < 3)
		{
			print "10|".$ERR["ETE"];
			exit;	
		}
		if(!filter_var($email_driver, FILTER_VALIDATE_EMAIL))
		{
			print "10|".$ERR["ITE"];
			exit;	
		}
		$email_arry[] = $email_driver;
	}
}else{
		print "10|".$ERR["ETE"];
		exit;	
}
	
if(isset($_POST['phone_driver']))
{
	foreach ($_POST['phone_driver'] as $phone_driver) {
		if(strlen($phone_driver) < 3)
		{
			print "10|".$ERR["ETP"];
			exit;	
		}
		$phone_arry[] = $phone_driver;
	}
}else{
		print "10|".$ERR["ETP"];
		exit;	
}

if(isset($_POST['bday_driver']))
{
	foreach ($_POST['bday_driver'] as $bday_driver) {
		if(strlen($bday_driver) < 3)
		{
			print "10|".$ERR["ETBD"];
			exit;	
		}

		$test_arr  = explode('/', $bday_driver);
		if(!is_numeric($test_arr[0])){print "10|".$ERR["IBD"]."1";exit;}
		if(!is_numeric($test_arr[1])){print "10|".$ERR["IBD"]."2";exit;}
		if(!is_numeric($test_arr[2])){print "10|".$ERR["IBD"]."3";exit;}
		if (!checkdate($test_arr[1], $test_arr[2], $test_arr[0])) { //( int $month , int $day , int $year )
			print "10|".$ERR["IBD"]."4";
			exit;	
		}	
		$bday_arry[] = $bday_driver;		
	}
}else{
		print "10|".$ERR["ETBD"];
		exit;	
}

if(isset($_POST['driver_licence']))
{
	foreach ($_POST['driver_licence'] as $driver_licence) {
		if(strlen($driver_licence) < 3)
		{
			print "10|".$ERR["EDL"];
			exit;	
		}
		$driver_arry[] = $driver_licence;
	}
}else{
		print "10|".$ERR["EDL"];
		exit;	
}

if(isset($_POST['driver_licence_expire']))
{
	foreach ($_POST['driver_licence_expire'] as $driver_licence_expire) {
		if(strlen($driver_licence_expire) < 3)
		{
			print "10|".$ERR["EDLED"];
			exit;	
		}
		$test_arr  = explode('/', $driver_licence_expire);
		if(!is_numeric($test_arr[0])){print "10|".$ERR["IDLED"];exit;}
		if(!is_numeric($test_arr[1])){print "10|".$ERR["IDLED"];exit;}
		if(!is_numeric($test_arr[2])){print "10|".$ERR["IDLED"];exit;}
		if (!checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
			print "10|".$ERR["IDLED"];
			exit;	
		}	
		$driver_licence_arry[] = $driver_licence_expire;		
	}
}else{
		print "10|".$ERR["EDLED"];
		exit;	
}
$mainJsonArry = array();
for ($i =0; $i<count($CNP_arry); $i++)
{
$array = array(

    "CNP" => $CNP_arry[$i],
    "name" => $name_arry[$i],
    "addres" => $addres_arry[$i],
    "email" => $email_arry[$i],
    "phone" => $phone_arry[$i],
    "bday" => $bday_arry[$i],
    "driver" => $driver_arry[$i],
    "driver_licence" => $driver_licence_arry[$i],
);

$mainJsonArry[] = $array;

}
header('Content-Type: application/json');
print "{ \"result\":1 , \"data\":".json_encode($mainJsonArry)." }";
}else{
	header("HTTP/1.0 404 Not Found");
	exit;
}

?>