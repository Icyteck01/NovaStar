<?php
if(session_id() == '') {
    session_start();
}
include "configs.php";

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] >= 1)
{
include 'mysqlC.php';
if(isset($_GET['cid']) && is_numeric($_GET['cid']))
{
	$cid = mysql_real_escape_string($_GET['cid']);
	$sql_notifications = MySQL_Query("SELECT * FROM `entity_clients` WHERE id = $cid");
	
}else{
	$sql_notifications = MySQL_Query("SELECT * FROM `entity_clients`");
}
$result ="";
while($row = mysql_fetch_array($sql_notifications))
{
$result .='	
  <tr id="all_can_hide_'.$row['id'].'"> 
  '.($_SESSION['privilege'] > 2 ? '<td>
  <a href="#" data-zxc="'.$row['id'].'" data-xxy="'.$row['name'].'" data-toggle="tooltip" data-placement="bottom" title="'.$CFG["DELETECONTACT"].'" class="btn btn-danger btn-xs flat DELETECONTACT">
  <i class="fa fa-eraser"></i></a></td>':'<td><i class="fa fa-smile-o"></i></td>').'
	<td>'.strtoupper($row['name']).'</td>
	<td>'.strtoupper($row['phone']).'</td>
	<td>'.strtoupper($row['bday']).'</td>
	'.($_SESSION['privilege'] >= 2 ? '<td>'.strtoupper($row['moneySpent']).'</td>':'').'
  </tr>';		  
}
mysql_close();
$boday = '
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	'.(isset($_GET['cid'])?$CFG["Dashboard_8"]:$CFG["Dashboard_9"]).'
  </h1>
  <ol class="breadcrumb">
	<li><a style="cursor:pointer"><i class="fa fa-dashboard"></i> '.$CFG["Dashboard_1"].'</a></li>
	<li class="active">'.(isset($_GET['cid'])?$CFG["Dashboard_8"]:$CFG["Dashboard_9"]).'</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box box-success">
		<div id="overlayst1" class="overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>	
		<div class="box-header">
		  <h3 class="box-title">'.$CFG["ALL"].' '.$CFG["CARS"].'</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		  <table id="example1" class="table table-bordered table-hover  dt-responsive nowrap" cellspacing="0" width="100%">
			<thead>
			  <tr>
				'.($_SESSION['privilege'] >= 2 ? '<th>'.strtoupper($CFG['OPTIONS']).'</th>':'').'
				<th>'.$CFG["NAME"].'</th>
				<th>'.$CFG["PHONE"].'</th>
				<th>'.$CFG["BIRTHDAY"].'</th>
				'.($_SESSION['privilege'] >= 2 ? '<th>'.$CFG['MONEYSPENT'].'</th>':'').'
			  </tr>
			</thead>
			<tbody>
				'.$result.'
			</tbody>
		  </table>
		</div><!-- /.box-body -->
		<div class="box-footer" style="'.(isset($_GET['cid'])?"":"display:none").'">
            	<a href="/View-User" class="btn btn-info flat"><i class="fa fa-eye"></i> '.$CFG["VIEW_ALL"].'</a>
         </div>
	  </div><!-- /.box -->


	</div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
';	
echo $boday;
}
?>