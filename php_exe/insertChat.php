<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
if(session_id() == '') {
    session_start();
}
include "../configs.php";
$array = array();
if(isset($_SESSION["id"],$_POST['msg']))
{

header('Content-Type: application/json');
$query = "SELECT * FROM `chat` ORDER BY `chat`.`timestamp` DESC";
$get_info = MySQL_Query($query);
$my_ID = $_SESSION["id"];
$image = $_SESSION['image'];
$name = $_SESSION['name'];

$msg = $_POST['msg'];
if(preg_match('/[^a-zA-Z 0-9 .,!?@_:;]/i', $msg))
{
	$array["result"] = false;
	$array["msg"] = $CFG["Dashboard_35"];
    exit;
}
$msg = base64_encode($msg);
include "../mysqlC.php";
$array = array();
$count = 0;
if(mysql_query("INSERT INTO `chat` (`uid`, `name`, `img`, `text`) VALUES ('$my_ID', '$name', '$image', '$msg')"))
{
$array["result"] = true;
}
$query = "SELECT * FROM `chat` ORDER BY `chat`.`timestamp` DESC";
$get_info = MySQL_Query($query);
while($row = mysql_fetch_assoc($get_info)){
$row["isMe"] = $my_ID == $row['uid'];
$row["text"] = base64_decode($row['text']);
$array[] = $row;
$count++;
}
if($count > 49)
{
	mysql_query("DELETE FROM chat ORDER BY timestamp ASC LIMIT 30");
}

print json_encode($array);
mysql_close();
exit;
}
$array = array();
$array["result"] = false;
$array["msg"] = $CFG["Dashboard_35"];
print json_encode($array);
?>