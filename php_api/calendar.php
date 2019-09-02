<?php



if(session_id() == '') {
    session_start();
}
if(!isset($_SESSION['privilege']) || !isset($_SESSION['id']))
{
	header("HTTP/1.0 404 Not Found");
	exit;
}

include 'mysqlC.php';
$userID = mysql_real_escape_string($_SESSION['id']);
$sql = "SELECT * FROM calendar WHERE userId=".$userID;
$query = mysql_query($sql);

$cal = array();

while($row = mysql_fetch_assoc($query))
{
	$cal[] = $row;
}

mysql_close();
print'
<script>
var $things = '.json_encode($cal).';
</script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	'.$CFG["Calendar"].'
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
	<div class="col-md-3">
	  <div class="box box-solid">
		<div class="box-header with-border">
		  <h4 class="box-title">'.$CFG["calendar_19"].'</h4>
		</div>
		<div class="box-body">
		  <!-- the events -->
		  <div id="external-events">

		  </div>
		</div><!-- /.box-body -->
	  </div><!-- /. box -->
	  <div class="box box-solid">
		<div class="overlayxy1 overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>		  
		<div class="box-header with-border">
		  <h3 class="box-title">'.$CFG["calendar_20"].'</h3>
		</div>
		<div class="box-body">
		  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
			<!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
			<ul class="fc-color-picker" id="color-chooser">
			  <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
			</ul>
		  </div><!-- /btn-group -->
		  <div class="input-group">
			<input id="new-event" type="text" pattern="[^a-zA-Z 0-9 .,!?@]" capital="true" class="form-control" placeholder="'.$CFG["calendar_21"].'">
			<div class="input-group-btn">
			  <button id="add-new-event" type="button" class="btn btn-primary btn-flat">'.$CFG["calendar_22"].'</button>
			</div><!-- /btn-group -->
		  </div><!-- /input-group -->
		</div>
	  </div>
	</div><!-- /.col -->
	<div class="col-md-9">
	  <div class="box box-primary">
		<div class="overlayxy1 overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>		  
		<div class="box-body no-padding">
		  <!-- THE CALENDAR -->
		  <div id="calendar"></div>
		</div><!-- /.box-body -->
	  </div><!-- /. box -->
	</div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->';
?>