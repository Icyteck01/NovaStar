<?php
if(session_id() == '') {
    session_start();
}

include "configs.php";
$boday =  '
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	'.$CFG["CarManager_12"].'
  </h1>
  <ol class="breadcrumb">
	<li><a style="cursor:pointer"><i class="ion ion-model-s"></i> '.$CFG["CarManager_1"].'</a></li>
	<li class="active">'.$CFG["CarManager_12"].'</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
 <div class="row">
 
<div class="col-md-12">
	  <div class="nav-tabs">
		<ul class="nav nav-tabs">
		  <li id="step1" class="active disabled"><a id="step1a" aria-expanded="true" href="#tab_1-1" data-toggle="tab">'.$CFG["STEP"].' 1</a></li>
		  <li id="step2" class="disabled"><a id="step2a" aria-expanded="false" href="#tab_2-2" data-toggle="tab">'.$CFG["STEP"].' 2</a></li>
		  <li id="step3" class="disabled"><a id="step3a" aria-expanded="false" href="#tab_3-2" data-toggle="tab">'.$CFG["STEP"].' 3</a></li>
		  <li id="step4" class="disabled"><a id="step4a" aria-expanded="false" href="#tab_3-3" data-toggle="tab">'.$CFG["FINISH"].'</a></li>
		</ul>
			<div class="header">
			<div class="progress progress-sm active">
				<div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
				  <span class="sr-only">20% Complete</span>
				</div>
			</div>			
			</div>	
		<div class="tab-content">
		<div class="tab-pane" id="tab_3-3">
			<div class="alert alert-success alert-dismissable">
			<h4><i class="icon fa fa-check"></i> '.$CFG["CONGRATZ"].'</h4>
			'.$CFG["ANEWCAR"].'
			</div>
		</div>
		  <div class="tab-pane active" id="tab_1-1">
				<div class="box box-primary">
				<div id="overlayst1" class="overlay">
				  <i class="fa fa-refresh fa-spin"></i>
				</div>				
				<div class="box-header with-border">
				  <h3 class="box-title">'.$CFG["STEP"].' 1/3 <small>'.$CFG["GENERAL_INFORMATION"].'</small></h3>
				</div><!-- /.box-header -->
					<form id="general_form" role="form" method="POST">
					  <div class="box-body">	
						<div class="form-group">	
						<label>'.$CFG["VIN"].'</label>
							  <input id="VIN" name="VIN" type="text" class="form-control" placeholder="'.$CFG["VIN_EX"].'" value="'.$row['VIN'].'" data-mask>
						</div>						  
						<div class="form-group">					   
						<label>'.$CFG["PLATE"].'</label>
							  <input id="plate" name="plate" type="text" pattern="[^a-zA-Z 0-9]" placeholder="CT-85-VIS"  class="form-control" data-mask>
						</div>						
						<div class="form-group">
						  <label for="brand">'.$CFG["BRAND"].'</label>
						  <input id="brand" name="brand" class="form-control" pattern="[^a-zA-Z 0-9]" placeholder="Audi A3" type="text">
						</div>
						<div class="form-group">
						  <label for="comfort">'.$CFG["COMFORT"].'</label>
						  <input id="comfort" name="comfort" class="form-control" pattern="[^a-zA-Z 0-9]" placeholder="S Line" type="text">
						</div>					
						<div class="form-group">
						<label>'.$CFG["CLASS"].'</label>
						<select class="form-control" id="type" name="type">
							<option value="1">Economic</option>
							<option value="2">Business</option>
							<option value="3">Premium</option>
							<option value="4">Lux</option>
						</select>
						</div>
					  <div class="form-group">
						<label>Inventory</label>
						<select id="inventory" name="inventory[]" class="form-control select2" multiple="multiple" data-placeholder="'.$CFG["INV_PLACEHOLDER"].'" style="width: 100%;">
						'.str_replace(',', '', $CFG["INVENTORY_ITEMS"]).'
						</select>
					 </div><!-- /.form-group -->			 
					<div class="form-group">
					  <label for="exampleInputFile"> <img id="exampleInputFileTmp" src="" class="img-responsive" width="35%" alt="'.$CFG["PICTURE"].'"></label>
					  <input id="exampleInputFile" name="exampleInputFile" type="file">
					</div>	
					  </div><!-- /.box-body -->
					  <div class="box-footer">
						<button id="general" name="general" type="submit" value="Save" class="btn btn-success pull-right">'.$CFG["NEXT"].' <i class="fa fa-arrow-right"></i></button>
					  </div>
					</form>		
				</div>

		  </div><!-- /.tab-pane -->
		  <div class="tab-pane" id="tab_2-2">
		<div class="box box-warning">
		<div id="overlayst2" class="overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>			
		<div class="box-header with-border">
		  <h3 class="box-title">'.$CFG["STEP"].' 2/3 <small>'.$CFG["TECHNICAL_INFORMATION"].' <d id="extraInfoS2"></d></small></h3>
		</div><!-- /.box-header -->
			<form id="technical_form" role="form" method="POST">
			  <div class="box-body">
				<div class="form-group">
				<label>'.$CFG["YEAR"].'</label>
				  <input id="year" name="year" type="text" class="form-control" data-inputmask="\'mask\': \'9999\'" data-mask>
				</div>	
				<div class="form-group">
				  <label for="engine">'.$CFG["ENGINE"].'</label>
				  <input name="engine" class="form-control" id="engine" pattern="[^0-9]" placeholder="2000">
				</div>
				<div class="form-group">
					<label>'.$CFG["FUEL_TYPE"].'</label>
					<select class="form-control" name="gas">
					<option value="0" selected>'.$CFG["BENZINA"].'</option>
					<option value="1">'.$CFG["DIZEL"].'</option>
					<option value="2">'.$CFG["GAZ"].'</option>
					</select>
				</div>			
				<div class="form-group">
				<label>'.$CFG["TRANSMISSION_TYPE"].'</label>
				<select class="form-control" name="gearbox">
				<option value="0">'.$CFG["MANUALA"].'</option>
				<option value="1">'.$CFG["AUTOMATA"].'</option>
				</select>
				</div>
				<div class="form-group">
				  <label for="dors">'.$CFG["DORS"].'</label>
				  <input name="dors" class="form-control" id="dors" placeholder="5" pattern="[^0-9]" type="text" >
				</div>
				<div class="form-group">
				  <label for="seat">'.$CFG["SEATS"].'</label>
				  <input name="seat" class="form-control" id="seat" placeholder="8" pattern="[^0-9]" type="text">
				</div>		
				<div class="form-group">
				  <label for="km">'.$CFG["KMONBOARD"].'</label>
				  <input name="km" class="form-control" id="km" placeholder="100000" pattern="[^0-9]" type="text">
				</div>	
				<div class="form-group">
				<label>'.$CFG["DMGRI"].' <a id="redrawCanavas" href="#" class="btn btn-success btn-xs"><i class="fa fa-trash"></i></a></label>
					<div class="row"> 
						<div class="col-md-12">
						  <div id="canavasContainer" class="pre-scrollable">
							<canvas id="canvas" style="width: 1508px;height: 1066px;">
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
									
						  </div>
						</div>
					</div>
				</div>
				  <div class="form-group">
						<label>'.$CFG["FUEL_TANK"].'</label>
						<div class="row"> 
							<div class="col-lg-2" style="float: none;margin: 0 auto;">
								<canvas id="pieChart" class="img-responsive"></canvas>
							</div>
						</div>
						<input id="fuelInTank" name="fuelInTank" type="text" value=""  />
				  </div>				
			  </div><!-- /.box-body -->
			  <div class="box-footer">
				<button id="technicalback" name="technical" type="submit" value="Save" class="btn btn-warning pull-left"><i class="fa fa-arrow-left"></i> '.$CFG["BACK"].'</button>
				<button id="technical" type="submit" value="Save" class="btn btn-success pull-right">'.$CFG["NEXT"].' <i class="fa fa-arrow-right"></i></button>
			  </div>
			</form>		
		</div>
		  </div><!-- /.tab-pane -->
		  <div class="tab-pane" id="tab_3-2">
		<div class="box box-danger">
		<div id="overlayst3" class="overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>			
		<div class="box-header with-border">
		  <h3 class="box-title">'.$CFG["STEP"].' 3/3 <small>'.$CFG["SERVICE_INFORMATION"].' <d id="extraInfoS3"></d></small></h3>
		</div><!-- /.box-header -->
			<form id="service_form" role="form" method="POST">
			  <div class="box-body">
				<div class="form-group">
				  <label for="inspection">'.$CFG["INSPECT_KM"].'</label>
				  <input name="inspection" class="form-control" id="inspection" pattern="[^0-9]" placeholder="15000" type="text">
				</div>		
				<div class="form-group" style="display:none">
				  <label for="service">'.$CFG["SERVICE_KM"].'</label>
				  <input name="service" class="form-control" id="service" pattern="[^0-9]" value="00" placeholder="60000" type="text">
				</div>							
			  </div><!-- /.box-body -->
			  <div class="box-footer">
				<button id="servicesaveback" name="servicesave" type="submit" value="Save" class="btn btn-warning pull-left"><i class="fa fa-arrow-left"></i> '.$CFG["BACK"].'</button>
				<button id="servicesave" name="servicesave" type="submit" value="Save" class="btn btn-success pull-right">'.$CFG["FINISH"].' <i class="fa fa-check"></i></button>						
			  </div>
			</form>		
		</div>
		  </div><!-- /.tab-pane -->
		</div><!-- /.tab-content -->
	  </div><!-- nav-tabs-custom -->
	</div>	
</div>

  <!-- Your Page Content Here -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->
';
if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] >= 2)
{
	echo $boday;
}
?>