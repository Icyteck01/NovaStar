<?php
header('Content-Type: application/json');
if(isset($_POST['operation']))
{
	if(session_id() == '') {
		session_start();
	}
	if(!isset($_SESSION["IMAPset"]) && $_SESSION["IMAPset"] == 0)
	{
		print '{"result":false}';
		exit;
	}
	$ope = $_POST['operation'];
	$box = "INBOX";
	$folders = $_SESSION['folders'];
	try {
	if(is_numeric($ope) && strlen($folders[0]))
	{
		$box = $folders[$ope];
	}
	} catch (Exception $e) {
		$tttArr = array("INBOX", "[Gmail]/All Mail", "[Gmail]/Drafts", "[Gmail]/Important", "[Gmail]/Sent Mail", "[Gmail]/Spam", "[Gmail]/Starred", "[Gmail]/Trash");
		$box = $tttArr[$ope];	
	}
	
	
	
	
	if(isset($_SESSION["id"]))
	{
		$mailbox = 'imap.gmail.com';
		$encryption = 'ssl';
		require_once "../Imap.php";
		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		$imap = new Imap($mailbox, $_SESSION['IMAPuser'], $_SESSION['imapPass'], $encryption);
		if($imap->isConnected()===false)
		{
			
		}else{
			include "../mysqlC.php";
			$folders = $imap->getFolders();
			$box = $folders[$ope];
			$imap->selectFolder($box);
			$overallMessages = $imap->countMessages();
			$unreadMessages = $imap->countUnreadMessages();
			
			$emails = $imap->getMessages(false);
			$id = $_SESSION["id"];		
			$emailsx = count($emails)>0?base64_encode(gzcompress(serialize($emails))):"";
			mysql_query("INSERT INTO `user_emails` (`uid`, `folderName`, `overallMessages`, `unreadMessages`,`mailBody`) VALUES ('$id', '$box', '$overallMessages', '$unreadMessages', '$emailsx') ON DUPLICATE KEY UPDATE overallMessages='$overallMessages',unreadMessages='$unreadMessages',mailBody='$emailsx', retrivedTime=CURRENT_TIMESTAMP") or die(mysql_error($link));
			$array = array();
			$array["result"] = true;
			$array["overallMessages"] = $overallMessages;
			$array["box"] = $folders[$ope];
			$array["unreadMessages"] = $unreadMessages;
			$array["folders"] = json_encode($folders);
			$array["emails"] = json_encode($emails);
			$_SESSION["emails"] = $emails;
			$_SESSION['unreadMessages'] = $unreadMessages;					
			$_SESSION['overallMessages'] = $overallMessages;
			$_SESSION['selectedBox'] = $folders[$ope];
			mysql_close();
			print trim(json_encode($array));	
			exit;
		}
	}
}


print '{"result":false}';
?>