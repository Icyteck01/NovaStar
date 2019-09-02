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
$sql_notifications = MySQL_Query("SELECT * FROM `cars_in_rent` WHERE status=0");
$result ="";
while($rowx = mysql_fetch_array($sql_notifications))
{
	
$carid = $rowx['carId'];
$caridd = $rowx['id'];
$query_prepare = "SELECT * FROM `cars` WHERE id='$carid' AND deleted = 0";
$get_info = MySQL_Query($query_prepare);
if(mysql_num_rows($get_info) > 0)
{
$row = mysql_fetch_array($get_info);
$now = strtotime($rowx['pickupDate']); // or your date as well
$your_date = strtotime($rowx['dropDate']);
$result .='	
  <tr id="transit_can_hide_'.$row['id'].'">
	<td>
	<a href="View-Car-'.$row['id'].'" data-toggle="tooltip" data-placement="bottom" title="'.$CFG["VIEW"].'" class="btn btn-primary btn-xs flat"><i class="fa fa-eye"></i></a>
	<a data-type="2" data-carid="'.$caridd.'" data-vak="'.$row['id'].'" data-vax="'.$row['cureentKM'].'" data-toggle="tooltip" title="'.$CFG["returnVehicule"].'" data-placement="bottom" class="btn btn-warning btn-xs flat remove_car_from_rent"><i class="fa fa-home"></i></a>
	</td>  
	<td><img src="cars/'.$row['poza'].'" height="39px" ></img></td>
	<td>'.$row['plate'].'</td>
	<td>'.strtoupper($row['VIN']).'</td>
	<td>'.$row['name'].'</td>
	<td>'.getComfortById($row['type']).'</td>
	<td>'.getGasById($row['gas']).'</td>
	<td>'.getGearById($row['gearbox']).'</td>
	<td>'.$rowx['pickupDate'].' </td>
	<td>'.$rowx['dropDate'].' </td>
	<td>'.$rowx['noDays'].'</td>
	<td>'.$rowx['moneyVar'].' '.$CFG["CURENCY_VAR"].' / '.$CFG["DAY"].'</td>
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
	'.$CFG["CarManager_2"].'
  </h1>
  <ol class="breadcrumb">
	<li><a style="cursor:pointer"><i class="ion ion-model-s"></i> '.$CFG["CarManager_1"].'</a></li>
	<li class="active">'.$CFG["CarManager_2"].'</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box box-info">
		<div class="box-header">
		  <h3 class="box-title">'.$CFG["CarManager_3"].'</h3>
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
				<th>'.$CFG["PickupDate"].'</th>
				<th>'.$CFG["DropoffDate"].'</th>
				<th>'.$CFG["TOTAL"].' '.$CFG["DAY"].'</th>
				<th>'.$CFG["VAL"].'</th>
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