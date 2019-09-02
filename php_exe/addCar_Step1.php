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

function validate_vin($vin) {
$transliteration = array(
        'A'=>1, 'B'=>2, 'C'=>3, 'D'=>4, 'E'=>5, 'F'=>6, 'G'=>7, 'H'=>8, 
        'J'=>1, 'K'=>2, 'L'=>3, 'M'=>4, 'N'=>5, 'P'=>7, 'R'=>9,
        'S'=>2, 'T'=>3, 'U'=>4, 'V'=>5, 'W'=>6, 'X'=>7, 'Y'=>8, 'Z'=>9,
    );
$weights = array(8,7,6,5,4,3,2,10,0,9,8,7,6,5,4,3,2);	
	
$vin = strtoupper($vin);
$length = strlen($vin);
$sum = 0;	
if($length != 17)
{
	return false;
}	
 for($x=0; $x<$length; $x++)
{
	$char = substr($vin, $x, 1);

	if(is_numeric($char))
	{
		$sum += $char * $weights[$x];
	}
	else
	{
		if(!isset($transliteration[$char]))
		{
			return false;
		}

		$sum += $transliteration[$char] * $weights[$x];
	}
}

$remainder = $sum % 11;
$checkdigit = $remainder == 10 ? 'X' : $remainder;

if(substr($vin, 8, 1) != $checkdigit)
{
	return false;
}
return true;	

}


include "../configs.php";
$tempCarId = 1;

if(!isset($_POST['plate']))
{
	echo "10|".$ERR["PETLPN"];
	exit;
}
if(!isset($_POST['brand']))
{
	echo "20|".$ERR["PETB"];
	exit;
}
if(!isset($_POST['comfort']))
{
	echo "30|".$ERR["PETC"];
	exit;
}
if(!isset($_POST['type']))
{
	echo "40|".$ERR["PETCL"];
	exit;
}

if(!isset($_POST['VIN']) || empty($_POST['VIN']))
{
	echo "10|".$ERR["PEVIN"];
	exit;
}

if(!validate_vin($_POST['VIN']))
{
	echo "10|".$ERR["IVIN"];
	exit;
}

if(empty($_POST['plate']))
{
	echo "10|".$ERR["PETLPN"];
	exit;
}
if(empty($_POST['brand']))
{
	echo "20|".$ERR["PETB"];
	exit;
}
if(empty($_POST['comfort']))
{
	echo "30|".$ERR["PETC"];
	exit;
}
if(empty($_POST['type']))
{
	echo "40|".$ERR["PETCL"];
	exit;
}

if(empty($_POST['type']))
{
	echo "40|".$ERR["PETCL"];
	exit;
}
if (empty($_FILES['exampleInputFile']['name'])) {
    // No file was selected for upload, your (re)action goes here
	echo "190|".$ERR["NIWSFU"];
	exit;
}

$plate = mysql_real_escape_string($_POST['plate']);
$brand = mysql_real_escape_string($_POST['brand']);
$comfort = mysql_real_escape_string($_POST['comfort']);
$type = mysql_real_escape_string($_POST['type']);
$vin = mysql_real_escape_string($_POST['VIN']);
$deds_joined = "";

if(isset($_POST['inventory']))
{
	$deds = array();
	foreach ($_POST['inventory'] as $ded) {
	  $deds[] = mysql_real_escape_string($ded);
	}
	$deds_joined = join(',', $deds);
}

$target_dir = "../cars/";
$target_file = $target_dir . $_FILES["exampleInputFile"]["name"];
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$finalPath = $target_dir . "$plate.".$imageFileType;
$finalPathMYSQL = "$plate.".$imageFileType;
$finalPathMYSQLX = mysql_real_escape_string($finalPathMYSQL);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["exampleInputFile"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $error =  $ERR["FINAI"];
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["exampleInputFile"]["size"] > 500000) {
    $error =  $ERR["SYFITL"];
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $error = $ERR["SOJPGFORMAT"];
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["exampleInputFile"]["tmp_name"], $finalPath)) {
       
		$uploadOk = 1;
    }
}

if($uploadOk == 1) {
	include '../mysqlC.php';
		$query_prepare = "SELECT * FROM `cars` WHERE plate='$plate'";
		$get_info = MySQL_Query($query_prepare) or die(mysql_error($link));
		if(mysql_num_rows($get_info) > 0)
		{
			echo "40|".$ERR["TPACOBAV"];
			mysql_close();
		}else{
			$sqlQuery = "INSERT INTO cars_temp (`plate`, `name`, `comfort`, `poza`, `type`, `echipare`, `VIN`) VALUES('".$plate."', '".$brand."', '".$comfort."', '".$finalPathMYSQLX."', '".$type."', '".$deds_joined."', '".$vin."') ON DUPLICATE KEY UPDATE plate='".$plate."', name='".$brand."', comfort='".$comfort."', poza='".$finalPathMYSQLX."', type='".$type."', echipare='".$deds_joined."', VIN='".$vin."'";
			mysql_query($sqlQuery) or die(mysql_error());
			mysql_close();
			$_SESSION['plate'] = $plate;
			echo "1|$plate";
		}
}else{
	echo "50|".$error ;
}

?>