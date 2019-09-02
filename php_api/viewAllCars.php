<?php
if(session_id() == '') {
    session_start();
}
include "configs.php";


function getGasById($i)
{
	global $CFG;
	switch((int)$i)
	{
		case 0:
		return $CFG["BENZINA"];
		case 1:
		return $CFG["DIZEL"];		
		case 2:
		return $CFG["GAZ"];		
	}
	return "";
}

function getGearById($i)
{
	
	global $CFG;
	switch((int)$i)
	{
		case 0:
		return $CFG["MANUALA"];
		case 1:
		return $CFG["AUTOMATA"];		
	}
	return "";
}

function getComfortById($i)
{
	global $CFG;
	switch((int)$i)
	{
		case 1:
		return "Economic";
		case 2:
		return "Business";	
		case 3:
		return "Premium";	
		case 4:
		return "Lux";			
	}
	return "";
}

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] > 0)
{
	
include 'mysqlC.php';
$data = "0";
$sql_notifications = MySQL_Query("SELECT * FROM `cars_in_service` WHERE status=0");
$result ="";
while($row = mysql_fetch_array($sql_notifications))
{
	$data.=$row['carId'].",";
}
$sql_notifications = MySQL_Query("SELECT * FROM `cars_in_rent` WHERE status=0");
while($row = mysql_fetch_array($sql_notifications))
{
	$data .=$row['carId'].",";
}
$data = trim($data, ",");
$sql_notifications = MySQL_Query("SELECT * FROM `cars` WHERE id NOT IN($data) ORDER BY `id` ASC");
$result ="";
while($row = mysql_fetch_array($sql_notifications))
{
if($row['deleted'] == 0) {
$result .='	
  <tr id="all_can_hide_'.$row['id'].'">
	<td>
	<a href="View-Car-'.$row['id'].'" data-toggle="tooltip" data-placement="bottom" title="'.$CFG["VIEW"].'" class="btn btn-info btn-xs flat"><i class="fa fa-eye"></i></a>
	<a style="'.($_SESSION['privilege'] >= 2 ? "":"display:none").'" class="btn btn-danger btn-xs flat sendToServiceCar" data-id="'.$row['id'].'" data-plate="'.$row['plate'].'" data-placement="bottom"  data-toggle="tooltip" title="'.$CFG["SENDTOSERVICE"].'" ><i class="fa fa-ambulance"></i></a>
	<a class="btn btn-warning btn-xs flat SendToTransit" data-id="'.$row['id'].'" data-plate="'.$row['plate'].'" data-placement="bottom"  data-toggle="tooltip" title="'.$CFG["SENDTOTRANSIT"].'"><i class="fa fa-cab"></i></a>
	</td>  
	<td><img src="cars/'.$row['poza'].'" height="39px" ></img><span class="pull-right">'.strtoupper($row['plate']).'</span></td>
	<td>'.strtoupper($row['VIN']).'</td>
	<td>'.strtoupper($row['name']).'</td>
	<td>'.strtoupper(getComfortById($row['type'])).'</td>
	<td>'.strtoupper(getGasById($row['gas'])).'</td>
	<td>'.strtoupper(getGearById($row['gearbox'])).'</td>
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
	'.$CFG["CarManager_13"].'
  </h1>
  <ol class="breadcrumb">
	<li><a style="cursor:pointer"><i class="ion ion-model-s"></i> '.$CFG["CarManager_1"].'</a></li>
	<li class="active">'.$CFG["CarManager_13"].'</li>
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
		  <h3 class="box-title">'.$CFG["CarManager_13"].'</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		  <table id="example1" class="table table-bordered table-hover  dt-responsive nowrap" cellspacing="0" width="100%">
			<thead>
			  <tr>
			    <th>'.$CFG["OPTIONS"].'</th>
				<th>'.$CFG["PLATE"].'</th>
				<th>'.$CFG["VIN"].'</th>
				<th>'.$CFG["BRAND"].'</th>
				<th>'.$CFG["COMFORT"].'</th>
				<th>'.$CFG["FUEL_TYPE"].'</th>
				<th>'.$CFG["TRANSMISSION_TYPE"].'</th>
			  </tr>
			</thead>
			<tbody>
				'.$result.'
			</tbody>
		  </table>
		</div><!-- /.box-body -->
	  </div><!-- /.box -->


	</div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
';	
echo $boday;
}
?>