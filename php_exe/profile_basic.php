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

$hasUpload = true;
if (empty($_FILES['exampleInputFile']['name']) || strlen($_FILES['exampleInputFile']['name']) < 1) {
    // No file was selected for upload
	$hasUpload = false;
	print "2|2";
	exit;		
}

$uploadOk = 1;
if($hasUpload)
{
	//Upload the file
$target_dir = "../user_img/";
$target_file = $target_dir . $_FILES["exampleInputFile"]["name"];
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$finalPath = $target_dir . "$userID.".$imageFileType;
$finalPathMYSQL = "$userID.".$imageFileType;
$poza = mysql_real_escape_string($finalPathMYSQL);
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
}
if($uploadOk == 0) {	
	echo "50|".$error ;
	exit;
}else{
include '../mysqlC.php';
$query = "UPDATE user_accounts SET image = '$poza' WHERE id='$userID'";
mysql_query($query);
mysql_close();
$_SESSION['image'] = $poza;
setcookie( "theImage", $poza, strtotime( '+30 days' ) );
	print "1|".$poza;
	exit;	
}
?>