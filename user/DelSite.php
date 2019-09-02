<?php

function isValid($str) {
  $allowed = array("=", ".", "-", "_", ",", " ", "[", "]", ":", "+", "|", "!", "%", "&", "@", "/", "*", "?", "#", "'");
  if(empty($str))
  {
  return true;
  
  }
  if (ctype_alnum(str_replace($allowed, '', $str ) ) ) {
    return true;
  } else {
    return false;
  }
}

session_start();
if(isset($_SESSION['uid']) && isset($_GET['uid']))
{
$idui = $_GET['uid'];  //URL
$userID = $_SESSION['uid'];
if(!is_numeric($idui))
{
print 'Invalid input.';
mysql_close();
die();
exit;
}
include '../config.php';
$inpUser = mysql_real_escape_string($idui);
$stmtzq = sprintf('SELECT * FROM cars WHERE id = "%s"', $inpUser);
$stmtz = mysql_query($stmtzq);
if (mysql_num_rows($stmtz) > 0){
	 $row = mysql_fetch_array($stmtz);
	 $poza = $row['poza'];
	 $upload_dir = "../assets/img/preview/cars/";
	 unlink($upload_dir.$poza);
	 $query2 = sprintf('DELETE FROM `cars` WHERE id = "%s"', mysql_real_escape_string($idui));
	 mysql_query($query2);
	 print "deleted";
	 print'<meta http-equiv="refresh" content="2;url=index">';
}
mysql_close();
header("Location: index");
}
?>