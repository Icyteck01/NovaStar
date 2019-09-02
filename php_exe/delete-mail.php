<?php

if(session_id() == '') {
    session_start();
}

if(isset($_SESSION["IMAPset"]) && $_SESSION["IMAPset"] > 0)
{
	if(isset($_POST["cid"]) && is_numeric($_POST["cid"])){

		$mailbox = 'imap.gmail.com';
		$encryption = 'ssl';
		require_once "../Imap.php";
		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		$imap = new Imap($mailbox, $_SESSION['IMAPuser'], $_SESSION['imapPass'], $encryption);
		if($imap->isConnected()===false)
		{
			
		}else{
			$folder = $_SESSION['selectedBox'];
			$imap->selectFolder($_SESSION['selectedBox']);
			$emails = $imap->getMessage($_POST["cid"]);
			$imap->deleteMessage($emails["uid"],true);
			$_SESSION["emails"] = $imap->getMessages(false);
			include "../mysqlC.php";
				$id = $_SESSION["id"];
				$messages = $imap->getMessages(false);
				$overallMessages = $imap->countMessages();
				$unreadMessages = $imap->countUnreadMessages();		
				$_SESSION['unreadMessages']	= $unreadMessages;			
				$emails = count($messages)>0?base64_encode(gzcompress(serialize($messages))):"";
				mysql_query("INSERT INTO `user_emails` (`uid`, `folderName`, `overallMessages`, `unreadMessages`,`mailBody`) VALUES ('$id', '$folder', '$overallMessages', '$unreadMessages', '$emails') ON DUPLICATE KEY UPDATE overallMessages='$overallMessages',unreadMessages='$unreadMessages',mailBody='$emails', retrivedTime=CURRENT_TIMESTAMP") or die(mysql_error($link));
			mysql_close();
			print "1";
			exit;
		
		}
		
		print "2";
		exit;
	}
	
	print "3";
}

?>