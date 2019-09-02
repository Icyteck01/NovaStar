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



if(isset($_POST["id"],$_POST["title"],$_POST["start"],$_POST["end"],$_POST["backgroundColor"])) {
include '../configs.php';

$userID = $_SESSION['id'];	
$id = mysql_real_escape_string($_POST['id']);	
$title = mysql_real_escape_string($_POST['title']);	
$start = $_POST['start'];	
$start = mysql_real_escape_string(str_replace("T", " ", $start));	
$end = $_POST['end'];	
$end = mysql_real_escape_string(str_replace("T", " ", $end));	
$backgroundColor =  mysql_real_escape_string($_POST['backgroundColor']);

if(preg_match('/[^a-zA-Z 0-9 .,!?@]/i', $title))
{
  print "10|".$CFG['EVTISNOTVALID'];
  exit;
}
if(preg_match('/[^a-zA-Z 0-9 .,!?:-]/i', $start))
{
  print "11|".$CFG['EVTISNOTVALID'];
  exit;
}
if(preg_match('/[^a-zA-Z 0-9 .,!?:-]/i', $end))
{
  print "12|".$CFG['EVTISNOTVALID'];
  exit;
}
if(preg_match('/[^a-zA-Z 0-9 -]/i', $id))
{
  print "13|".$CFG['EVTISNOTVALID'];
  exit;
}
if(preg_match('/[^a-zA-Z 0-9 .,!?)(]/i', $backgroundColor))
{
  print "15|".$CFG['EVTISNOTVALID'];
  exit;
}

include '../mysqlC.php';
$sql = "INSERT INTO  calendar  (`uid`, `userId`, `startDate`, `endDate`, `title`, `color`) VALUES ('$id', '$userID', '$start', '$end', '$title','$backgroundColor') ON DUPLICATE KEY UPDATE startDate='$start', endDate='$end'";
if(mysql_query($sql))
{
	print "1|";
}else{
	print "10|".$CFG['EVTISNOTVALID'];
}

mysql_close();
}
?>