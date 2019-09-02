<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
if(session_id() == '') {
    session_start();
}
$directory = "";
if(isset($_SESSION["IMAPset"]) && $_SESSION["IMAPset"] > 0)
{
$directory = 'IframeMail/'.$_SESSION["id"].'.html';
	if(isset($_GET["cid"]) && is_numeric($_GET["cid"])){

		$mailbox = 'imap.gmail.com';
		$encryption = 'ssl';
		require_once "Imap.php";
		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		$imap = new Imap($mailbox, $_SESSION['IMAPuser'], $_SESSION['imapPass'], $encryption);
		if($imap->isConnected()===false)
		{
			
		}else{
			$box = $_SESSION['selectedBox'];
			$imap->selectFolder($_SESSION['selectedBox']);
			$emails = $imap->getMessage($_GET["cid"]);
			if($emails['unread']) {
				$imap->setUnseenMessage($emails["uid"],true);
				include 'mysqlC.php';
					
				$overallMessages = $imap->countMessages();
				$unreadMessages = $imap->countUnreadMessages();
				$folders = $imap->getFolders();
				$emailsy = $imap->getMessages(false);
				$id = $_SESSION["id"];		
				$emailsx = count($emailsy) > 0 ? base64_encode(gzcompress(serialize($emailsy))):"";
				mysql_query("INSERT INTO `user_emails` (`uid`, `folderName`, `overallMessages`, `unreadMessages`,`mailBody`) VALUES ('$id', '$box', '$overallMessages', '$unreadMessages', '$emailsx') ON DUPLICATE KEY UPDATE overallMessages='$overallMessages',unreadMessages='$unreadMessages',mailBody='$emailsx', retrivedTime=CURRENT_TIMESTAMP") or die(mysql_error($link));					
				$_SESSION["emails"] = $emailsy;
				$_SESSION['unreadMessages'] = $unreadMessages;					
				//$_SESSION['overallMessages'] = $overallMessages;
			}		
			file_put_contents($directory,$emails['body']);
		}
	}
}

print'
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	'.$CFG["Dashboard_13"].'
  </h1>
  <ol class="breadcrumb">
	<li><a href="/Mailbox"><i class="fa fa-envelope-o"></i> '.$CFG["Dashboard_12"].'</a></li>
	<li class="active">Read</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
	<div class="col-md-3">
	  <a href="Mailbox" class="btn btn-primary btn-block margin-bottom text-white">'.$CFG["Dashboard_14"].'</a>
	  <div class="box box-solid">
		<div class="overlayxy1 overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>		  
		<div class="box-header with-border">
		  <h3 class="box-title">Options</h3>
		  <div class="box-tools">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		  </div>
		</div>
		<div class="box-body no-padding">
		  <ul class="nav nav-pills nav-stacked">
			<li><a href="#" id="deleteThisMail" data-value="'.$emails['xuid'].'"><i class="fa fa-trash-o text-red"></i> '.$CFG["DELETE"].'</a></li>
			<li><a href="#" id="replayToThisMail" data-value="'.$emails['xuid'].'"><i class="fa fa-reply text-blue"></i> '.$CFG["REPLAY"].'</a></li>
			<li><a href="#" id="forwardThisMail" data-value="'.$emails['xuid'].'"><i class="fa fa-mail-forward text-yellow"></i> '.$CFG["FORWARD"].'</a></li>
		  </ul>
		</div><!-- /.box-body -->
	  </div><!-- /.box -->
	</div><!-- /.col -->
	';

	print'
	<div class="col-md-9">
	  <div class="box box-primary">
		<div class="overlayxy1 overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>		  
		<div class="box-header with-border">
		  <h3 class="box-title">'.$CFG["Dashboard_16"].'</h3>
		  <div class="box-tools pull-right">
			<a href="#" class="btn btn-box-tool text-white" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
			<a href="#" class="btn btn-box-tool text-white" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
		  </div>
		</div><!-- /.box-header -->
		<div class="box-body no-padding">
		  <div class="mailbox-read-info">
			<h3>'.$emails['subject'].'</h3>
			<h5>From: '.$emails['from'].' <span class="mailbox-read-time pull-right">'.$emails['date'].'</span></h5>
		  </div><!-- /.mailbox-read-info -->
		  <div class="mailbox-read-message">
			   <iframe class="col-md-12"
					   style="height: 400px;"
					   src="'.$directory.'" frameBorder="0">
			   </iframe>	  
			
		  </div><!-- /.mailbox-read-message -->
		</div><!-- /.box-body -->
		<div class="box-footer">
		  <ul class="mailbox-attachments clearfix">
			';
			
			
			
			if(count($emails['attachments']) >  0)
			{
				$count = 0;
				foreach($emails['attachments'] as $attachment)
				{
					if(strpos(strtolower($attachment['name']), "png") > -1 || strpos(strtolower($attachment['name']), "jpg") > -1 || strpos(strtolower($attachment['name']), "gif") > -1)
					{
					//pic
					print '
						<li>
						  <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>
						  <div class="mailbox-attachment-info">
							<a href="#" data-id="'.$count.'" data-uid="'.$emails['uid'].'" target="_blank" class="mailbox-attachment-name dlAttachmentNow"><i class="fa fa-camera"></i> '.$attachment['name'].'</a>
							<span class="mailbox-attachment-size">
							  '.$attachment['size'].' kb
							  <a href="#" data-id="'.$count.'" data-uid="'.$emails['uid'].'" target="_blank" class="btn btn-default btn-xs pull-right dlAttachmentNow"><i class="fa fa-cloud-download"></i></a>
							</span>
						  </div>
						</li>';
					}else{
						print '
						<li>
						  <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>
						  <div class="mailbox-attachment-info">
							<a href="#" data-id="'.$count.'" data-uid="'.$emails['uid'].'"  target="_blank" class="mailbox-attachment-name dlAttachmentNow"><i class="fa fa-paperclip"></i> '.$attachment['name'].'</a>
							<span class="mailbox-attachment-size">
							  '.$attachment['size'].' kb
							  <a href="#" data-id="'.$count.'" data-uid="'.$emails['uid'].'" target="_blank" class="btn btn-default btn-xs pull-right dlAttachmentNow"><i class="fa fa-cloud-download"></i></a>
							</span>
						  </div>
						</li>';		
					}
					$count++;
				}
			}
			
			print'
		  </ul>
		</div><!-- /.box-footer -->
	  </div><!-- /. box -->
	</div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
';
?>
