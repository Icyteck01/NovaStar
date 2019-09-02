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

include "../configs.php";

if(!isset($_POST['plate']) || empty($_POST['plate']))
{
	echo "10|".$ERR["PETLPN"];
	exit;
}
if(!isset($_POST['year']) || empty($_POST['year']))
{
	echo "10|".$ERR["PETY"];
	exit;
}
if(!isset($_POST['engine']) || empty($_POST['engine']))
{
	echo "10|".$ERR["PETECC"];
	exit;
}
if(!isset($_POST['gas']))
{
	echo "10|".$ERR["PETFT"];
	exit;
}
if(!isset($_POST['gearbox']))
{
	echo "10|".$ERR["PETGT"];
	exit;
}
if(!isset($_POST['dors']) || empty($_POST['dors']))
{
	echo "10|".$ERR["PETTD"];
	exit;
}
if(!isset($_POST['seat']) || empty($_POST['seat']))
{
	echo "10|".$ERR["PETTS"];
	exit;
}
if(!isset($_POST['km']) || empty($_POST['km']) && strlen($_POST['km']) == 0)
{
	echo "10|".$ERR["PETTKOMTTCHOB"];
	exit;
}
$plate = mysql_real_escape_string($_SESSION['plate']);
$year = mysql_real_escape_string($_POST['year']);
$engine = mysql_real_escape_string($_POST['engine']);
$gas = mysql_real_escape_string($_POST['gas']);
$gearbox = mysql_real_escape_string($_POST['gearbox']);
$dors = mysql_real_escape_string($_POST['dors']);
$seat = mysql_real_escape_string($_POST['seat']);
$km = mysql_real_escape_string($_POST['km']);
$tankFuel = mysql_real_escape_string($_POST['grudgeValue']);
$arraypointDescription = rtrim($_POST['pointDescription'], ",");
$pointDescription = mysql_real_escape_string($arraypointDescription);

try {
$target_dirTT = "../cars/";
$image_name = $plate."_damage.png";
$target_dir = $target_dirTT.$image_name;
$data = $_POST['canvastoDataURL'];
$data = substr($data, strpos($data, ",")+1);
$data = base64_decode($data);
$imgRes = imagecreatefromstring($data);
imagejpeg($imgRes, $target_dir);
} catch (Exception $e) {

}

include '../mysqlC.php';
$sqlQuery = "INSERT INTO cars_temp (`plate`, `year`, `engine`, `gas`, `gearbox`, `doors`, `seets`, `cureentKM`, `defects`, `tankFuel`) VALUES('".$plate."', '".$year."', '".$engine."', '".$gas."', '".$gearbox."', '".$dors."', '".$seat."', '".$km."', '".$pointDescription."', '".$tankFuel."') ON DUPLICATE KEY UPDATE plate='".$plate."', year='".$year."', engine='".$engine."', gas='".$gas."', gearbox='".$gearbox."', gearbox='".$gearbox."', doors='".$dors."', seets='".$seat."', cureentKM='".$km."', defects='".$pointDescription."', tankFuel='".$tankFuel."'";
$query = mysql_query($sqlQuery) or die(mysql_error());
if(!$query)
{
mysql_close();
	header("HTTP/1.0 404 Not Found");
}else{
	mysql_close();
	echo"1|1";
}


?>