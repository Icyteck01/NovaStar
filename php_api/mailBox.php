<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<?php print $CFG["Mailbox"]; ?>
	<small><?php print $_SESSION['unreadMessages'].' '.$CFG["Dashboard_12"];?></small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="/Mailbox" class="active"><i class="fa fa-envelope-o"></i> <?php print $CFG["Mailbox"]; ?></a></li>
  </ol>
</section>
<?php
if(session_id() == '') {
	session_start();
}
$folders = $_SESSION['folders'];
$_SESSION['folders'] = count($folders) > 0 ? $_SESSION['folders']:array("INBOX", "[Gmail]/All Mail", "[Gmail]/Drafts", "[Gmail]/Important", "[Gmail]/Sent Mail", "[Gmail]/Spam", "[Gmail]/Starred", "[Gmail]/Trash");

print '
<script>
$overallMessages = '.$_SESSION['overallMessages'].';
$unreadMessages = '.$_SESSION['unreadMessages'].';
$folders = '.json_encode($_SESSION['folders']).';
$emails = '.json_encode($_SESSION['emails']).';
</script>
';

$_SESSION['selectedBox'] = strLen($_SESSION['folders'][0]) > 0 ? $_SESSION['folders'][0]:"INBOX";
?>
<!-- Main content -->
<section class="content">
  <div class="row">
	<div class="col-md-3">
	  <a href="Mailbox-New" class="btn btn-primary btn-block margin-bottom"><?php print $CFG["COMPOSE"];?></a>
	  <div class="box box-solid">
		<div class="overlayxy1 overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>		  
		<div class="box-header with-border">
		  <h3 class="box-title"><?php print $CFG["Folders"];?></h3>
		  <div class="box-tools">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		  </div>
		</div>
		<div class="box-body no-padding">
		  <ul class="nav nav-pills nav-stacked">
		  <?php
			//var_dump($_SESSION['folders']);
			$i=0;
			if(isset($_SESSION['folders']) && count($_SESSION['folders']) > 0)
			{
				foreach($_SESSION['folders'] as $folder)
				{
				
					$folder = $folder;
					
					if(strpos(strtolower($folder), "inbox") > -1)
					{
						print'<li id="goToInbox" data-aasd="'.$i.'" class="rmxClass active"><a href="#"><i class="fa fa-inbox"></i> Inbox <span class="label label-primary pull-right unreadMessagesClassUpdate">'.$_SESSION['unreadMessages'].'</span></a></li>';
					}
					elseif(strpos(strtolower($folder), "sent")  > -1)
					{
						print'<li id="goToSent" data-aasd="'.$i.'" class="rmxClass"><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>';
					}			
					elseif(strpos(strtolower($folder), "draft")  > -1)
					{
						print'<li id="goToDrafts" data-aasd="'.$i.'" class="rmxClass"><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>';
					}			
					elseif(strpos(strtolower($folder), "spam")  > -1)
					{
						print'<li id="goToJunk" data-aasd="'.$i.'" class="rmxClass"><a href="#"><i class="fa fa-filter"></i> Junk </a></li>';
					}		
					elseif(strpos(strtolower($folder), "trash")  > -1)
					{
						print'<li id="goToTrash" data-aasd="'.$i.'" class="rmxClass"><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>';
					}else{
						print'<li id="goToUnknown" data-aasd="'.$i.'" class="rmxClass"><a href="#"><i class="fa fa-folder-o"></i>'.str_replace("[Gmail]/","",$folder).'</li>';
					}
						$i++;
				}
			}
			?>
  		   </ul>
		</div><!-- /.box-body -->
	  </div><!-- /. box -->

	</div><!-- /.col -->
	<div class="col-md-9">
	  <div class="box box-primary">
		<div class="overlayxy1 overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>		  
		<div class="box-header with-border">
		  <h3 class="box-title" id="currentDirectory">Inbox</h3>
		  <div class="box-tools pull-right">
			<div class="has-feedback">
			  <input id="searchMail" type="text" class="form-control input-sm" placeholder="<?php print $CFG["Search"];?>">
			  <span class="glyphicon glyphicon-search form-control-feedback"></span>
			</div>
		  </div><!-- /.box-tools -->
		</div><!-- /.box-header -->
		<div class="box-body no-padding">
		  <div class="table-responsive mailbox-messages">
			<table class="table table-hover table-striped">
			  <tbody id="mailsContent">
				<!-- MAIL CONTENT -->
			  </tbody>
			</table><!-- /.table -->
		  </div><!-- /.mail-box-messages -->
		</div><!-- /.box-body -->
		<div class="box-footer no-padding">
		  <div class="mailbox-controls">
			<button class="btn btn-default btn-sm refrshBox"><i class="fa fa-refresh"></i></button>
			<div class="pull-right">
			   <p class="mailCount"> 1-50/200</p>
			  <div class="btn-group">
				<button class="btn btn-default btn-sm btnBackMail"><i class="fa fa-chevron-left"></i></button>
				<button class="btn btn-default btn-sm btnNextMail"><i class="fa fa-chevron-right"></i></button>
			  </div><!-- /.btn-group -->
			</div><!-- /.pull-right -->
		  </div>
		</div>
	  </div><!-- /. box -->
	</div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
