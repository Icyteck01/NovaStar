<?php
if(session_id() == '') {
    session_start();
}
include "configs.php";

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] >= 2)
{
include 'mysqlC.php';
if(isset($_GET['cid']) && is_numeric($_GET['cid']))
{
	$cid = mysql_real_escape_string($_GET['cid']);
	$sql_notifications = MySQL_Query("SELECT * FROM `cars_in_rent` WHERE id = $cid");
	
}else{
	$sql_notifications = MySQL_Query("SELECT * FROM `cars_in_rent`");
}
$result ="";
while($row = mysql_fetch_array($sql_notifications))
{
$clientId = $row['clientId'];
$contractId = $row['contractiID'];
$query_prepare = "SELECT * FROM `entity_clients` WHERE id='$clientId'";
$get_info = MySQL_Query($query_prepare);
if(mysql_num_rows($get_info) > 0)
{
$rowx = mysql_fetch_array($get_info);
$carId = $row["carId"];
$plate = "";
$query_preparex = "SELECT * FROM `cars` WHERE id='$carId'";
$get_infox = MySQL_Query($query_preparex);
if(mysql_num_rows($get_infox) > 0)
{
$rowY = mysql_fetch_array($get_infox);
$plate = $rowY['plate'];
}
$result .='	
  <tr id="all_can_hide_'.$row['id'].'"> 
  '.($_SESSION['privilege'] > 2 ? '<td>
  <a href="/Print?id='.$contractId.'" target="_BLANK" data-toggle="tooltip" data-placement="bottom" title="'.$CFG["VIEW"].'" class="btn btn-info btn-xs flat"><i class="fa fa-eye"></i></a>
  <a href="#" data-toggle="tooltip" data-zxc="'.$row['id'].'" data-xxy="'.$rowx['name'].'" data-placement="bottom" title="'.$CFG["DELETE"].'" class="btn btn-danger btn-xs flat DELETECONTRACTBYID"><i class="fa fa-eraser"></i></a>
  </td>':'<td><i class="fa fa-smile-o"></i></td>').'
	<td>'.strtoupper($rowx['name']).'</td>
	<td>'.strtoupper($rowx['phone']).'</td>
	<td>'.$plate.'</td>
	
	'.($_SESSION['privilege'] >= 2 ? '<td>'.strtoupper($row['moneyVar'] * $row['noDays']).'</td>':'').'
	<td>'.strtoupper($row['madeDate']).'</td>
	<td>'.strtoupper($row['pickupDate']).'</td>
	<td>'.strtoupper($row['dropDate']).'</td>
  </tr>';	
}  
}
mysql_close();
$boday = '
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	'.(isset($_GET['cid'])?$CFG["Dashboard_11"]:$CFG["Dashboard_10"]).'
  </h1>
  <ol class="breadcrumb">
	<li><a style="cursor:pointer"><i class="fa fa-dashboard"></i> '.$CFG["Dashboard_1"].'</a></li>
	<li class="active">'.(isset($_GET['cid'])?$CFG["Dashboard_11"]:$CFG["Dashboard_10"]).'</li>
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
		  <h3 class="box-title">'.$CFG["ALL"].' Clients</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		  <table id="example1" class="table table-bordered table-hover  dt-responsive nowrap" cellspacing="0" width="100%">
			<thead>
			  <tr>
				'.($_SESSION['privilege'] >= 2 ? '<th>'.strtoupper($CFG['OPTIONS']).'</th>':'').'
				<th>'.$CFG["NAME"].'</th>
				<th>'.$CFG["PHONE"].'</th>
				<th>'.$CFG["PLATE"].'</th>
				'.($_SESSION['privilege'] >= 2 ? '<th>'.strtoupper($CFG['MONEYMADE']).'</th>':'').'
				<th>'.$CFG["DATE"].'</th>
				<th>'.$CFG["PickupDate"].'</th>
				<th>'.$CFG["DropoffDate"].'</th>
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