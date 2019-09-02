<?php
if(session_id() == '') {
    session_start();
}
include "configs.php";
$can_show = false;
$row = null;

$isInService = false;
$isInTransit = false;
$isInRent = false;


if(is_numeric($cid) && $cid > 0)
{
	
	include 'mysqlC.php';
	    $plate = mysql_real_escape_string($cid);
		$query_prepare = "SELECT * FROM `cars` WHERE id='$plate'";
		$get_info = MySQL_Query($query_prepare) or die(mysql_error($link));
		if(mysql_num_rows($get_info) > 0)
		{
				$row = mysql_fetch_array($get_info);	
				$can_show = true;
		}
		
		
		$query_prepare = "SELECT * FROM `cars_in_transit` WHERE carId='$plate' AND status = 0";
		$get_info = MySQL_Query($query_prepare);
		if(mysql_num_rows($get_info) > 0)
		{
				$isInTransit = true;
		}		
		$query_prepare = "SELECT * FROM `cars_in_service` WHERE carId='$plate' AND status = 0";
		$get_info = MySQL_Query($query_prepare);
		if(mysql_num_rows($get_info) > 0)
		{
				$isInService = true;
		}		
		$query_prepare = "SELECT * FROM `cars_in_rent` WHERE carId='$plate' AND status = 0";
		$get_info = MySQL_Query($query_prepare);
		if(mysql_num_rows($get_info) > 0)
		{
				$isInRent = true;
		}		
	mysql_close();
}else{
	 print '
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit/View Car
            <small>Not Found</small>
          </h1>
          <ol class="breadcrumb">
			<li><a style="cursor:pointer"><i class="ion ion-model-s"></i> Car Manager</a></li>
			<li class="active">Edit/View</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
		<div class="row">
            <div class="col-md-12">
              <div class="box box-default">
                <div class="box-body">
                  <div class="alert alert-danger alert-dismissable">
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    '.$CFG["NOT_FOUND_CAR"].'
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  ';
}


$boday = "";
$boday .=  '
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	Edit/View Car
  </h1>
  <ol class="breadcrumb">
	<li><a style="cursor:pointer"><i class="ion ion-model-s"></i> Car Manager</a></li>
	<li class="active">Edit/View</li>
  </ol>
</section>
<!-- Main content -->
<section class="content" style='.($row['deleted'] == 1 ? "display:none":"").'>
 <div class="row">
 
 			<div class="col-md-12" >
					<div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">'.$CFG["MAIN_OPTIONS"].'</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
					  </div><!-- /.box-header -->
						<div class="box-body">
						<!-- 
						  <a class="btn btn-primary btn-flat">
							 <i class="fa fa-ambulance"></i> '.$CFG["SERVICE"].' <b id="Service_ON_OFF" >'.($isInService?"ON":"OFF").'</b>
						  </a>		 -->
						  <a class="btn btn-warning btn-flat clearNotifications" data-toggle="tooltip" data-placement="bottom" title="'.$CFG["NOTIFCIATION_ALL_CLEAR"].'" data-id="'.$row['id'].'" data-platex="'.$row['plate'].'">
							 <i class="fa fa-bell-o "></i> '.$CFG["Clear_Notifications"].'
						  </a>							  
						  <span class=" pull-right">
						  <a class="btn btn-danger btn-flat delete_thisCar" style="'.($_SESSION['privilege'] >= 2 ? "":"display:none").'" data-toggle="tooltip" data-placement="bottom" title="'.$CFG["PERMENANET_DELETE"].'" data-id="'.$row['id'].'" data-plate="'.$row['plate'].'">
							 <i class="fa fa-eraser "></i> '.$CFG["DELETE"].'
						  </a>
						  </span>
						</div>
					</div>
				</div> 
				
 			<div class="col-md-12">
					<div class="box box-info" >
					<div class="box-header with-border">
					  <h3 class="box-title">'.$CFG["STATISTICS"].'</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
					  </div><!-- /.box-header -->
						<div class="box-body">
					<table class="table table-striped">
							<tbody>							
							<tr>
							  <th>'.$CFG["NAME"].'</th>
							  <th>'.$CFG["VAL"].'</th>
							</tr>
							<tr>
							  <td><img src="cars/'.$row['poza'].'" height="39px" ></img> '.$row['name'].'</td>
							  <td>'.$row['plate'].'</td>
							</tr>
							<tr>
							  <td>'.$CFG["STATUS"].'</td>';
							  if($isInService)
							  {
								$boday .=  '<td><b>'.$CFG["SERVICE"].'</b></td>';
							  }
							  elseif($isInTransit)
							  {
								$boday .=  '<td><b>'.$CFG["TRANSIT"].'</b></td>';  
							  }
							  elseif($isInRent)
							  {
								$boday .=  '<td><b>'.$CFG["RENTED"].'</b></td>';  
							  }							  		  
							  else{ 
								$boday .=  '<td><b>'.$CFG["REDY"].'</b></td>';   
							  }
							  $boday .=  '
							</tr>								
							<tr>
							  <td>'.$CFG["KMONBOARD"].'</td>
							  <td>'.$row['cureentKM'].'</td>
							</tr>		
							<tr>
							  <td>'.$CFG["INSPECT_KM"].'</td>
							  <td>'.$row['inspectionKM'].'</td>
							</tr>							
							
							<tr style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
							  <td>'.$CFG["MONEYSPENT"].'</td>
							  <td>'.$row['spent'].' '.$CFG["CURENCY_VAR"].'</td>
							</tr style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">							
							<tr>
							  <td>'.$CFG["MONEYMADE"].'</td>
							  <td>'.$row['made'].' '.$CFG["CURENCY_VAR"].'</td>
							</tr>							
														
						  </tbody></table>
						</div>
					</div>
			</div>
				
			<form id="general_form" role="form" data-id="'.$cid.'" method="POST">
				<div class="col-md-12">
				<div class="box box-primary collapsed-box" style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
				<div id="overlayst1" class="overlay">
				  <i class="fa fa-refresh fa-spin"></i>
				</div>				
				<div class="box-header with-border">
				  <h3 class="box-title">'.$CFG["GENERAL_INFORMATION"].'</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
				</div>
				  </div><!-- /.box-header -->
					
					  <div class="box-body">					  
					   <div class="form-group">
						<label>'.$CFG["PLATE"].'</label>
							  <input id="plate" name="plate" type="text" class="form-control" value="'.$row['plate'].'" data-mask>
						</div>	
						<div class="form-group">	
						<label>'.$CFG["VIN"].'</label>
							  <input id="VIN" name="VIN" type="text" class="form-control" placeholder="'.$CFG["VIN_EX"].'" value="'.$row['VIN'].'" data-mask>
						</div>						
						<div class="form-group">
						  <label for="brand">'.$CFG["BRAND"].'</label>
						  <input id="brand" name="brand" class="form-control" value="'.$row['name'].'" pattern="[^a-zA-Z 0-9]" placeholder="Audi A3" type="text">
						</div>
						<div class="form-group">
						  <label for="comfort">'.$CFG["COMFORT"].'</label>
						  <input id="comfort" name="comfort" class="form-control" value="'.$row['comfort'].'" pattern="[^a-zA-Z 0-9]" placeholder="S Line" type="text">
						</div>					
						<div class="form-group">
						<label>'.$CFG["CLASS"].'</label>
						<select class="form-control" id="type" name="type">
							<option value="1" '.($row['type'] == 1 ? "selected":"").'>Economic</option>
							<option value="2" '.($row['type'] == 2 ? "selected":"").'>Business</option>
							<option value="3" '.($row['type'] == 3 ? "selected":"").'>Premium</option>
							<option value="4" '.($row['type'] == 4 ? "selected":"").'>Lux</option>
						</select>
						</div>
                  <div class="form-group">
                    <label>'.$CFG["INVENTORY"].'</label>
                    <select id="inventory" name="inventory[]" class="form-control select2" multiple="multiple" data-placeholder="'.$CFG["INV_PLACEHOLDER"].'" style="width: 100%;">';
					$inv_arr = explode(',', $CFG["INVENTORY_ITEMS"]);
					$inv_arr_SQL = explode(',', $row['echipare']);
					
					foreach($inv_arr_SQL as $val) {
						$clean_val = strip_tags($val);
						$boday .= '<option selected>'.$clean_val.'</option>';
					}
					$boday .= '
                    </select>
				 </div><!-- /.form-group -->			 
					<div class="form-group">
					  <label for="exampleInputFile"> <img id="exampleInputFileTmp" src="cars/'.$row['poza'].'" class="img-responsive" width="35%" alt="'.$CFG["PICTURE"].'"></label>
					  <input id="poza" name="poza" type="hidden" value="'.$row['poza'].'">
					  <input id="exampleInputFile" name="exampleInputFile" type="file">
					</div>	
					  </div><!-- /.box-body -->
					  <div class="box-footer">
						<button type="submit" value="Save" class="btn btn-success pull-right save_now_button">'.$CFG["SAVE"].' <i class="fa fa-save"></i></button>	
					  </div>	
				</div>
			</div>					
			<div class="col-md-12">				
		<div class="box box-warning collapsed-box" style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
		<div id="overlayst2" class="overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>			
		<div class="box-header with-border" >
		  <h3 class="box-title">'.$CFG["TECHNICAL_INFORMATION"].'</h3>
			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
				
			</div>
		</div><!-- /.box-header -->
			  <div class="box-body" >
				<div class="form-group" style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
				<label>'.$CFG["YEAR"].'</label>
				  <input id="year" name="year" type="text" class="form-control" value="'.$row['year'].'" data-inputmask="\'mask\': \'9999\'" data-mask>
				</div>	
				<div class="form-group" style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
				  <label for="engine">'.$CFG["ENGINE"].'</label>
				  <input name="engine" class="form-control" id="engine" value="'.$row['engine'].'" pattern="[^0-9]" placeholder="2000">
				</div>
				<div class="form-group" style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
					<label>'.$CFG["FUEL_TYPE"].'</label>
					<select class="form-control" name="gas">
					<option value="0" '.($row['gas'] == 0 ? "selected":"").'>'.$CFG["BENZINA"].'</option>
					<option value="1" '.($row['gas'] == 1 ? "selected":"").'>'.$CFG["DIZEL"].'</option>
					<option value="2" '.($row['gas'] == 2 ? "selected":"").'>'.$CFG["GAZ"].'</option>
					</select>
				</div>	
				<div class="form-group" style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
				<label>'.$CFG["TRANSMISSION_TYPE"].'</label>
				<select class="form-control" name="gearbox">
				<option value="0" '.($row['gearbox'] == 0 ? "selected":"").'>'.$CFG["MANUALA"].'</option>
				<option value="1" '.($row['gearbox'] == 1 ? "selected":"").'>'.$CFG["AUTOMATA"].'</option>
				</select>
				</div>
				<div class="form-group" style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
				  <label for="dors">'.$CFG["DORS"].'</label>
				  <input name="dors" class="form-control" id="dors" value="'.$row['doors'].'" placeholder="5" pattern="[^0-9]" type="text" >
				</div>
				<div class="form-group" style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
				  <label for="seat">'.$CFG["SEATS"].'</label>
				  <input name="seat" class="form-control" id="seat" value="'.$row['seets'].'" placeholder="8" pattern="[^0-9]" type="text">
				</div>		
				<div class="form-group" style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
				  <label for="km">'.$CFG["KMONBOARD"].'</label>
				  <input name="km" class="form-control" id="km" value="'.$row['cureentKM'].'" placeholder="100000" pattern="[^0-9]" type="text">
				</div>	
				<div class="form-group">';

				$img = "cars/".$row['plate']."_damage.png";
				$imgPath = "dist/img/damage.png";
				if (file_exists($img)) {
					$imgPath = $img;
				}
				
				$defects_arr = explode(',', $row['defects']);
				$defects = "";
				foreach($defects_arr as $val) {
					$defects .= '<p>'.$val.'</p>';
				}
				$boday .='
				
				<label>'.$CFG["DMGRI"].' <a id="redrawCanavas" href="#" class="btn btn-success btn-xs"><i class="fa fa-trash"></i></a></label>
					<div class="row"> 
						<div class="col-md-12">
						  <div id="canavasContainer" class="pre-scrollable">
							<canvas id="canvas" data-src="'.$imgPath.'" data-defects="'.$row['defects'].'" style="width: 1508px;height: 1066px;">
							  '.$CFG["NO_CANAVAS_SUPPORT"].'
							</canvas>
						  </div>
						</div>
					</div>
					<hr>
					<label>'.$CFG["DMGRP"].'</label>
					<div class="row"> 
						<div class="col-md-12">
						  <div id="bodyResultPoints" class="pre-scrollable">
									'.$defects.'
						  </div>
						</div>
					</div>
				</div>	
				  <div class="form-group">
						<label>'.$CFG["FUEL_TANK"].'</label>
						<div class="row"> 
							<div class="col-lg-2" style="float: none;margin: 0 auto;">
								<canvas id="pieChart" fuelleft="'.$row['tankFuel'].'" class="img-responsive"></canvas>
							</div>
						</div>
						<input id="fuelInTank" name="fuelInTank" type="text" value="'.$row['tankFuel'].'/8"  />
				  </div>					
				<!--<div class="form-group">
				  <div class="btn-group btn-toggle pull-left"> 
					<a class="btn btn-default">'.$CFG["SERVICE"].' ON</a>
					<a class="btn btn-danger active">'.$CFG["SERVICE"].' OFF</a>
				  </div>
				</div> -->				
			  </div><!-- /.box-body -->
			  <div class="box-footer">
				<button type="submit" value="Save" class="btn btn-success pull-right save_now_button">'.$CFG["SAVE"].' <i class="fa fa-save"></i></button>	
			  </div>	
		</div>
		</div>
		<div class="col-md-12">
		<div class="box box-danger collapsed-box" style="'.($_SESSION['privilege'] > 1 ? "":"display:none").'">
		<div id="overlayst3" class="overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>			
		<div class="box-header with-border">
		  <h3 class="box-title">'.$CFG["SERVICE_INFORMATION"].'</h3>
			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
				
			</div>
		  </div><!-- /.box-header -->
			  <div class="box-body">
				<div class="form-group">
				  <label for="inspection">'.$CFG["INSPECT_KM"].'</label>
				  <input name="inspection" class="form-control" id="inspection" value="'.$row['inspectionKM'].'" pattern="[^0-9]" placeholder="15000" type="text">
				</div>		
				<div class="form-group" style="display:None">
				  <label for="service">'.$CFG["SERVICE_KM"].'</label>
				  <input name="service" class="form-control" id="service" value="'.$row['revisionKM'].'" pattern="[^0-9]" placeholder="60000" type="text">
				</div>							
			  </div><!-- /.box-body -->
			  <div class="box-footer">
				<button type="submit" value="Save" class="btn btn-success pull-right save_now_button">'.$CFG["SAVE"].' <i class="fa fa-save"></i></button>						
			  </div>	
		</div>

	</div>	
</div>
<!-- Your Page Content Here -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
';

if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] > 0)
{
	if($can_show)
	{
	echo $boday;
	}
}
?>