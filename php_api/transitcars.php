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

if(isset($_SESSION['privilege']) || $_SESSION['privilege'] > 0)
{
	
include 'mysqlC.php';
$sql_notifications = MySQL_Query("SELECT * FROM `cars_in_transit` WHERE status=0");
$result ="";
while($rowx = mysql_fetch_array($sql_notifications))
{
	
$carid = $rowx['carId'];
$caridd = $rowx['id'];
$query_prepare = "SELECT * FROM `cars` WHERE id='$carid' AND deleted=0";
$get_info = MySQL_Query($query_prepare);
if(mysql_num_rows($get_info) > 0)
{
$row = mysql_fetch_array($get_info);
$now = time(); // or your date as well
$your_date = strtotime($rowx['since']);
$datediff = $now - $your_date;
$daydiff=floor($datediff/(60*60));

$result .='
  <tr id="transit_can_hide_'.$row['id'].'">
	<td>
	<a href="View-Car-'.$row['id'].'" data-toggle="tooltip" data-placement="bottom" title="'.$CFG["VIEW"].'" class="btn btn-primary btn-xs flat"><i class="fa fa-eye"></i></a>
	<a data-type="0" data-carid="'.$caridd.'" data-vak="'.$row['id'].'" data-vax="'.$row['cureentKM'].'" data-toggle="tooltip" title="'.$CFG["returnVehicule"].'" data-placement="bottom" class="btn btn-warning btn-xs flat remove_car_from_transit"><i class="fa fa-home"></i></a>
	</td> 
	<td><img src="cars/'.$row['poza'].'" height="39px" ></img></td>
	<td>'.$row['plate'].'</td>
	<td>'.strtoupper($row['VIN']).'</td>
	<td>'.$row['name'].'</td>
	<td>'.getComfortById($row['type']).'</td>
	<td>'.getGasById($row['gas']).'</td>
	<td>'.getGearById($row['gearbox']).'</td>
	<td data-toggle="tooltip" data-placement="bottom" title="'.$daydiff.' '.$CFG["HOUR"].' '.$CFG["AGO"].'">'.$rowx['since'].'</td>
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
	'.$CFG["CarManager_8"].'
  </h1>
  <ol class="breadcrumb">
	<li><a style="cursor:pointer"><i class="ion ion-model-s"></i> '.$CFG["CarManager_1"].'</a></li>
	<li class="active">'.$CFG["CarManager_8"].'</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box box-warning">
		<div class="box-header">
		  <h3 class="box-title">'.$CFG["CarManager_9"].'</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		  <table id="example1" class="table table-bordered table-hover  dt-responsive nowrap"  cellspacing="0" width="100%">
			<thead>
			  <tr>
			    <th>'.$CFG["OPTIONS"].'</th>
				<th>'.$CFG["PICTURE"].'</th>
				<th>'.$CFG["PLATE"].'</th>
				<th>'.$CFG["VIN"].'</th>
				<th>'.$CFG["BRAND"].'</th>
				<th>'.$CFG["COMFORT"].'</th>
				<th>'.$CFG["FUEL_TYPE"].'</th>
				<th>'.$CFG["TRANSMISSION_TYPE"].'</th>
				<th>'.$CFG["SINCE"].'</th>
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