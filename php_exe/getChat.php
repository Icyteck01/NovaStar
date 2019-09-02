<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
if(session_id() == '') {
    session_start();
}
if(isset($_SESSION["id"]))
{
include "../mysqlC.php";
header('Content-Type: application/json');
$query = "SELECT * FROM `chat` ORDER BY `chat`.`timestamp` DESC";
$get_info = MySQL_Query($query);
$my_ID = $_SESSION["id"];
$array = array();
$count = 0;
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
}
?>