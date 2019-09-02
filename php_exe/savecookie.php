<?php
if(session_id() == '') {
    session_start();
}
if(isset($_POST['open']) && is_numeric($_POST['open']))
{
	$value = "";
	$num = $_POST['open'];
	if($num == 1)
	{
		$value = "sidebar-collapse";
	}
	$_SESSION['sidebar'] ="$value";
	print "OK";
}
?>