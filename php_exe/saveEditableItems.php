<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
header('Content-Type: application/json');
if(session_id() == '') {
    session_start();
}
if(!isset($_SESSION['privilege']) && $_SESSION['privilege'] <= 2)
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

if(isset($_POST['id'],$_POST['name'],$_POST['val']) && is_numeric($_POST['id']))
{
	include '../mysqlC.php';	
	include "../configs.php";	
	$id = $_POST['id'];
	$name = $_POST['name'];
	$val = $_POST['val'];
	$hasBeenSaved = true;
	$return = array();
	$msg = "";
	$id = mysql_real_escape_string($_POST['id']);
	$check = str_replace(' ', '', $name);
	if (ctype_alnum($check) != true)
	{
		$msg = $ERR["ERR_23"];
		$hasBeenSaved = false;
	}	
	$name =  mysql_real_escape_string($_POST['name']);
	$check = str_replace(' ', '', $val);
	if (ctype_alnum($check) != true)
	{
		$msg = $ERR["ERR_24"];
		$hasBeenSaved = false;
	}	
	$val =  mysql_real_escape_string($_POST['val']);	
	if($hasBeenSaved)
	{
		if($id == 0)//new item
		{
			if(mysql_query("INSERT INTO `cars_sellable` (`id`, `name`, `value`) VALUES (NULL, '$name', '$val')"))
			{
				$hasBeenSaved = true;
			}else{
				$msg = $ERR["FEPCAGSD"];
				$hasBeenSaved = false;
			}
		}elseif($id == -1){
			if(mysql_query("DELETE FROM cars_sellable WHERE id='$name'"))
			{
				$hasBeenSaved = true;
			}else{
				$msg = $ERR["FEPCAGSD"];
				$hasBeenSaved = false;
			}
		}else{//update
			if(mysql_query("UPDATE cars_sellable SET name='$name',value='$val' WHERE id='$id'"))
			{
				$hasBeenSaved = true;
			}else{
				$msg = $ERR["FEPCAGSD"];
				$hasBeenSaved = false;
			}
		}
	}
	$return['result'] = $hasBeenSaved;
	$return['msg'] = $msg;
	$data = array();
	if($hasBeenSaved)
	{
		//loop all items to update table
		$sql_notifications = MySQL_Query("SELECT * FROM `cars_sellable`");
		$result ="";
		while($row = mysql_fetch_array($sql_notifications))
		{
			$data[]= $row;
		}
	}
	$return['data'] = $data;
	print json_encode($return);
	mysql_close();
	exit;
}
header("HTTP/1.0 404 Not Found");
exit;
?>