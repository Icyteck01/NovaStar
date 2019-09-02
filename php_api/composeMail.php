<?php
if(session_id() == '') {
	session_start();
}
$subject = "";

$emails = NULL;
$header = "";
$from = "";
$subject = "";
$content = "";
if(isset($_SESSION["IMAPset"]) && $_SESSION["IMAPset"] > 0)
{
	if(isset($_GET["cid"]) && is_numeric($_GET["cid"])){

		$mailbox = 'imap.gmail.com';
		$encryption = 'ssl';
		require_once "Imap.php";
		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		$imap = new Imap($mailbox, $_SESSION['IMAPuser'], $_SESSION['imapPass'], $encryption);
		if($imap->isConnected()===false)
		{
			
		}else{
			
			$imap->selectFolder($_SESSION['selectedBox']);
			$emails = $imap->getMessage($_GET["cid"]);
			$header = $imap->getMessageHeader($emails["uid"]);
			$from = $header->fromaddress;
			$subject = "Re: ".$emails['subject'];
			//$content = "<blockquote>".$emails['body']."</blockquote>";
			
		}
	}
$error =$CFG["Dashboard_15"];
$textarea = "";
$hasAttachementBol = false;
$TEST = "FALSE";
if(isset($_POST['to']) && strlen($_POST['to']) > 4)
{
	$subject = $_POST['subject']; //to check
	$message = '<html><body>'.$_POST['compose-textarea'].'</body></html>'; //to check
    $from_email = 'twfpro@gmail.com'; //sender email
    $recipient_email = $_POST['to'];
	
	if(isset($_FILES['attachment']) && $_FILES['attachment']['size'] > 1)
	{
		//get file details we need
		$file_tmp_name    = $_FILES['attachment']['tmp_name'];
		$file_name        = $_FILES['attachment']['name'];
		$file_size        = $_FILES['attachment']['size'];
		$file_type        = $_FILES['attachment']['type'];
		$file_error       = $_FILES['attachment']['error'];
		$hasAttachementBol = true;
		//read from the uploaded file & base64_encode content for the mail
		$handle = fopen($file_tmp_name, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		$TEST = "TRUE";
		$encoded_content = chunk_split(base64_encode($content));
	}
		
        $boundary = md5("sanwebe");
        //header
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "From:".$from_email."\r\n";
        $headers .= "Reply-To: ".$from_email."" . "\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n";
       
        //plain text
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($message));
		$body .= "--$boundary\r\n";
		   if($hasAttachementBol)
		   {
			//attachment
			  $body = "--$boundary\r\n";
			$body .="Content-Type: $file_type; name=\"$file_name\"\r\n";
			$body .="Content-Disposition: attachment; filename=\"$file_name\"\r\n";
			$body .="Content-Transfer-Encoding: base64\r\n";
			$body .="X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n";
			$body .= $encoded_content;
			 $body = "--$boundary\r\n";
		   }
   
    //$sentMail = mail($recipient_email, $subject, $body, $headers);
    //if($sentMail) //output success or failure messages
    //{      
     //  $error = 'Mail Send!';
    //}else{
      // $error = "Mail Not Sent!";  
    //}
	
require("PHPMailer/PHPMailerAutoload.php");

$from = $_SESSION['IMAPuser'];
$password = $_SESSION['imapPass'];
$mail = new PHPMailer(); // create a new object
if($_SESSION['IMAPset'] == 1)
{
$mail->IsSMTP(); // enable SMTP
}else{
$mail->isMail();	
}
$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->Host = "smtp.gmail.com";
$mail->Port = 587; // or 587
$mail->Username = $from;
$mail->Password = $password;
$mail->SMTPSecure = 'tls';
$mail->From = $from;
$mail->FromName = $from;
$mail->AddAddress($recipient_email, $recipient_email); // Put your email
$mail->WordWrap = 50;
$mail->IsHTML(true);
$mail->Subject = $subject;
$mail->Body = $message;

if(!$mail->Send()) {
	$mail->isMail();
	 if(!$mail->Send()) {
		$error = "Mail Not Sent!" . $mail->ErrorInfo;  
	 }
 } else {
	$error = "Message has been sent!";  
 }	
	
	
	
$from = isset($_POST['to']) ? $_POST['to']:$from;
$subject = isset($_POST['subject']) ? $_POST['subject']:$subject;
$textarea = isset($_POST['compose-textarea']) ? $_POST['compose-textarea']:"";
}
}

	
print'
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<small>'.$_SESSION['unreadMessages'].' '.$CFG["Dashboard_12"].'</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="/Mailbox"><i class="fa fa-envelope-o"></i> Mailbox</a></li>
	<li class="active">Compose</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
	<div class="col-md-12">
	  <div class="box box-primary">
		<div class="box-header with-border">
		  <h3 class="box-title">'.$error.'</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<form method="post">
		  <div class="form-group">
			<input id="to" name="to" class="form-control" value=\''.trim($from).'\' placeholder="To:">
		  </div>
		  <div class="form-group">
			<input id="subject" name="subject" class="form-control" value="'.trim(strip_tags($subject)).'" placeholder="Subject:">
		  </div>
		  <div class="form-group">
			<textarea id="compose-textarea" name="compose-textarea" class="form-control" style="height: 300px">'.$textarea.'</textarea>
		  </div>
		  <!--<div class="form-group">
			<div class="btn btn-default btn-file">
			  <i class="fa fa-paperclip"></i> Attachment
			  <input type="file" id="attachment" name="attachment">
			</div>
			<p class="help-block">Max. 32MB</p>
		  </div>-->
		</div><!-- /.box-body -->
		
		<div class="box-footer">
		  <div class="pull-right">
			<button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> '.$CFG["SEND"].'</button>
		  </div>
		</form>
		  <a href="Mailbox" class="btn btn-default"><i class="fa fa-times"></i> '.$CFG["Discard"].'</a>
		</div><!-- /.box-footer -->
	  </div><!-- /. box -->
	</div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
';
?>