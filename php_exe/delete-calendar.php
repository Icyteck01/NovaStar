<?php

if(session_id() == '') {
    session_start();
}
if(!isset($_SESSION['privilege']) || !isset($_SESSION['id']))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}
if(isset($_POST["cid"])) {
include '../configs.php';
$id = mysql_real_escape_string($_POST['cid']);

if(preg_match('/[^a-zA-Z 0-9 -]/i', $id))
{
  print "13|".$CFG['EVTISNOTVALID'];
  exit;
}

include '../mysqlC.php';


if(mysql_query("DELETE FROM calendar WHERE uid='$id'"))
{
   mysql_query("DELETE FROM notifications WHERE calid='$id'");
   print "1|";	
}else{
   print "13|".$CFG['EVTISNOTVALID'];
}

mysql_close();
}






?>