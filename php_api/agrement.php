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

if(isset($_SESSION['privilege']) && $_SESSION['privilege'] > 0)
{
	
include 'mysqlC.php';
$sql_notifications = MySQL_Query("SELECT * FROM `cars` pm WHERE pm.id NOT IN (SELECT pd.carId FROM `cars_in_transit` pd WHERE pd.status=0) AND pm.id NOT IN (SELECT px.carId FROM `cars_in_service` px WHERE px.status=0) AND pm.id NOT IN (SELECT pd.carId FROM `cars_in_rent` pd WHERE pd.status=0) ORDER BY `id` ASC");
$result ="";
$sssRow = array();
while($row = mysql_fetch_assoc($sql_notifications))
{
$result .='	
  <tr>
	<td>
	<label><input id="iCheck-'.$row['id'].'" value="'.$row['id'].'" type="checkbox" class="minimal-red selectThisCar"></label>
	<a href="Edit-Car-'.$row['id'].'" target="_BLANK" class="btn btn-primary btn-xs flat"><i class="fa fa-eye"></i></a>
	
	</td>  
	<td><img src="cars/'.$row['poza'].'" height="39px" ></img><span class="pull-right">'.strtoupper($row['plate']).'</span></td>
	<td>'.strtoupper($row['VIN']).'</td>
	<td>'.strtoupper($row['name']).'</td>
	<td>'.strtoupper(getComfortById($row['type'])).'</td>
	<td>'.strtoupper(getGasById($row['gas'])).'</td>
	<td>'.strtoupper(getGearById($row['gearbox'])).'</td>
  </tr>';
$sssRow[$row['id']] = $row;
}

mysql_close();



$boday =  '
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<script>
$cars = '.json_encode($sssRow).';
</script>
<section class="content-header">
  <h1>
	'.$CFG["NEWAGREEMENT"].'
  </h1>
  <ol class="breadcrumb">
	<li><a style="cursor:pointer"><i class="fa fa-dashboard"></i> '.$CFG["Dashboard_1"].'</a></li>
	<li class="active">'.$CFG["NEWAGREEMENT"].'</li>
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
		  <li id="step4" class="disabled"><a id="step4a" aria-expanded="false" href="#tab_3-3" data-toggle="tab">'.$CFG["Summary"].'</a></li>
		  <li id="step4" class="disabled"><a id="step5a" aria-expanded="false" href="#tab_3-4" data-toggle="tab">'.$CFG["FINISH"].'</a></li>
		</ul>
			<div class="header">
			<div class="progress progress-sm active">
				<div id="progress-bar" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
				  <span class="sr-only">20% Complete</span>
				</div>
			</div>			
			</div>	
		<form id="general_form" role="form" method="POST">
		<div class="tab-content">
		<div class="tab-pane" id="tab_3-4">
			<div class="alert alert-success alert-dismissable">
			<h4><i class="icon fa fa-check"></i> '.$CFG["CONGRATZ"].'</h4>
			'.$CFG["Adatahbs"].'
			</div>
			<div id="contractPDFToShow" class="row">
			 
			</div>			
		</div>		
		<div class="tab-pane" id="tab_3-3">
			<div class="box box-info">
				<div id="overlayst4" class="overlay">
				  <i class="fa fa-refresh fa-spin"></i>
				</div>		
				<div class="box-header with-border">
				  <h3 class="box-title"> '.$CFG["Summary"].' <small>'.$CFG["DESC_NOTE"].'</small></h3>				  
				</div><!-- /.box-header -->
				 <div id="toPrint" class="box-body">
				  <div class="col-xs-12">
					<div class="table-responsive">
					  <table id="clinet_info_toshow" class="table table-striped">
						<tr>
						  <th style="width:50%">'.$CFG["DESC_CLIENT_INFO"].'</th>
						  <td></td>
						</tr>			  
						<tr>
						  <th style="width:50%">'.$CFG["LBL_CNP"].':</th>
						  <td id="RENTAL_DETAILS_LBL_CNP">1850605134230</td>
						</tr>
						<tr>
						  <th>'.strtoupper($CFG["NAME"]).':</th>
						  <td id="RENTAL_DETAILS_NAME">BD.FERDINAND Nr.61 BL.A7</td>
						</tr>						
						<tr>
						  <th>'.strtoupper($CFG["ADDRESS"]).':</th>
						  <td id="RENTAL_DETAILS_ADDRESS">BD.FERDINAND Nr.61 BL.A7</td>
						</tr>
						<tr>
						  <th>'.strtoupper($CFG["PHONE"]).':</th>
						  <td id="RENTAL_DETAILS_PHONE">0724627057</td>
						</tr>
						<tr>
						  <th>'.strtoupper($CFG["Email"]).':</th>
						  <td id="RENTAL_DETAILS_Email">0724627057</td>
						</tr>
						<tr>
						  <th>'.strtoupper($CFG["DESC_DRIVERS_LICENCEID"]).':</th>
						  <td id="RENTAL_DETAILS_EDL">#######</td>
						</tr>				
					  </table>
					</div>
				</div><!-- /.col -->									  
				<div class="col-xs-12">
					<div class="table-responsive">
					  <table id="additional_drivers" class="table table-striped">				
					  </table>
					</div>
				</div><!-- /.col -->	
				<div class="col-xs-12">
					<div class="table-responsive">
					  <table class="table table-striped">		  
						<tr>
						  <th style="width:50%">'.$CFG["RENTAL_DETAILS"].'</th>
						  <td></td>
						</tr>				  
						<tr>
						  <th style="width:50%">'.strtoupper($CFG["PickupDate"]).':</th>
						  <td id="RENTAL_DETAILS_PickupDate">FROM CONSTANTA, at 27/10/2001 20:40:60 PM</td>
						</tr>
						<tr>
						  <th>'.strtoupper($CFG["DropoffDate"]).':</th>
						  <td id="RENTAL_DETAILS_DropoffDate"> IN CONSTANTA, at 30/10/2001 20:40:60 PM</td>
						</tr>
						<tr>
						  <th style="width:50%"></th>
						  <td></td>
						</tr>						
						<tr>
						  <th style="width:50%">'.$CFG["CAR_DETAILS"].'</th>
						  <td></td>
						</tr>				  
						<tr>
						  <th style="width:50%">'.$CFG["BRAND"].':</th>
						  <td id="RENTAL_DETAILS_BRAND"> Audi A5</td>
						</tr>			  
						<tr>
						  <th style="width:50%">'.$CFG["PLATE"].':</th>
						  <td id="RENTAL_DETAILS_PLATE"> CT-85-VIS</td>
						</tr>
						<tr>
						  <th>'.$CFG["VIN"].':</th>
						  <td id="RENTAL_DETAILS_VIN">1HGBH41JXMN109186</td>
						</tr>								
						<tr>
						  <th>'.$CFG["KMONBOARD"].':</th>
						  <td id="RENTAL_DETAILS_KMONBOARD">72,231</td>
						</tr>
						<tr>
						  <th>'.$CFG["FUEL"].':</th>
						  <td><canvas id="pieChart" style="width:40px;height:20px;"></canvas><d class="badge">1/2</d></td>
						</tr>	
						<tr>
						  <th>'.$CFG["YEAR"].':</th>
						  <td id="RENTAL_DETAILS_Year">2013</td>
						</tr>	
					  </table>
					</div>
				  </div><!-- /.col -->			  
					<div class="col-xs-12">				
						<div class="table-responsive">
						  <table id="prepeddasd" class="table table-striped">
	
						  </table>
						</div>						
					</div><!-- /.col -->					  
				 </div>
				  <div class="box-footer">
						<button id="backContract" name="backContract" type="submit" value="Save" class="btn btn-warning pull-left"><i class="fa fa-arrow-left"></i> '.$CFG["BACK"].'</button>
						<button id="finContract" name="finContract" type="submit" value="Save" class="btn btn-success pull-right">'.$CFG["FINISH"].' <i class="fa fa-check"></i></button>	
				  </div>	
				  </div>
		</div>
		  <div class="tab-pane active" id="tab_1-1">
				<div class="box box-primary">
				<div id="overlayst1" class="overlay">
				  <i class="fa fa-refresh fa-spin"></i>
				</div>				
				<div class="box-header with-border">
				  <h3 class="box-title"> '.$CFG["DESC_RENTERINFO"].' 
						  <div class="btn-group btn-toggle"> 
							<a class="btn btn-default btn-sm">'.$CFG["DESC_ENTITY"].'</a>
							<a class="btn btn-success btn-sm active">'.$CFG["DESC_INDIVIDUAL"].'</a>
						  </div></h3>				  
				</div><!-- /.box-header -->
					  <div class="box-body">
						<div class="form-group">
						<label id="cnpLabel"></label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-barcode"></i>
						  </div>							
							  <input id="CNP" name="CNP" capital="true" type="text" search="byID" class="form-control" placeholder="" value="" data-mask>
						</div>	
						</div>	
						<div class="form-group">	
						<label id="nameLabel"></label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-user"></i>
						  </div>							
							  <input id="name" name="name" capital="true" type="text" class="form-control" placeholder="" value="" data-mask>
						</div>
						</div>
						<div class="form-group">
						<label>'.$CFG["ADDRESS"].'</label>						
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-map-marker"></i>
						  </div>							
							  <input id="address" name="address" capital="true" type="text" class="form-control" placeholder="'.$CFG["EG_ADDRESS"].'" value="">
						</div>
						</div>
						 
						<div class="form-group">
						<label>'.$CFG["Email"].'</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-envelope"></i>
						  </div>							
							  <input id="email" name="email" type="email" class="form-control" placeholder="" value="">
						</div>
						</div>
						
						<div class="form-group">	
						<label>'.$CFG["PHONE"].'</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-phone"></i>
						  </div>						
						
							  <input id="phone" name="phone" type="text" pattern="[^0-9 +]" class="form-control" placeholder="" value="" data-mask>
						</div>		
						</div>
						<div id="hideBday" class="form-group">
						<div class="form-group">
						<label>'.$CFG["BIRTHDAY"].'</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-birthday-cake"></i>
						  </div>
							 <input id="bday" name="bday"  class="form-control" data-inputmask="\'alias\': \'yyyy/mm/dd\'" data-mask="" type="text">
						</div>
						</div>
						
						
						<div class="form-group">	
						<label>'.$CFG["DESC_DRIVERS_LICENCEID"].'</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-credit-card"></i>
						  </div>						

							  <input id="licence" name="licence" type="text" class="form-control" placeholder="" value="" data-mask>
						</div>		
						</div>	

						<div class="form-group">
						<label>'.$CFG["DESC_DRIVERS_EXPIRE_RE"].'</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-credit-card"></i>
						  </div>
							 <input id="licence_expire" name="licence_expire"  class="form-control" data-inputmask="\'alias\': \'yyyy/mm/dd\'" data-mask="" type="text">
						</div>						
						</div>	
						
						</div>	
				  </div><!-- /.box-body -->
				  <div class="box-footer">
					<button id="general" name="general" type="submit" value="Save" class="btn btn-success pull-right">'.$CFG["NEXT"].' <i class="fa fa-arrow-right"></i></button>
				  </div>	
				  </div>	
				</div><!-- /.tab-pane -->
		  <div class="tab-pane" id="tab_2-2">
				<div class="box box-warning">
				<div id="overlayst2" class="overlay">
				  <i class="fa fa-refresh fa-spin"></i>
				</div>			
				<div class="box-header with-border">
				  <h3 class="box-title">'.$CFG["DESC_DRIVERINFO"].'</h3>
				</div><!-- /.box-header -->
							  <div class="box-body">
								<div class="form-group">
								  <label>'.$CFG["HOWMANYDRIVERS"].'</label>
								  <select id="noOfDrivers" class="form-control">
									<option value="0">'.$CFG["ONLYRENTER"].'</option>
									<option value="1">1 '.$CFG["DESC_DRIVER"].'</option>
									<option value="2">2 '.$CFG["DESC_DRIVER_S"].'</option>
								  </select>
								</div>				  
							<div id="CLONEDRIVER">
								
							</div>		
						  </div><!-- /.box-body -->
					  <div class="box-footer">
						<button id="technicalback" name="technical" type="submit" value="Save" class="btn btn-warning pull-left"><i class="fa fa-arrow-left"></i> '.$CFG["BACK"].'</button>
						<button id="technical" type="submit" value="Save" class="btn btn-success pull-right">'.$CFG["NEXT"].' <i class="fa fa-arrow-right"></i></button>
					  </div>	
				</div>
		  </div><!-- /.tab-pane -->
		  
		  <div class="tab-pane" id="tab_3-2">
		<div class="box box-danger">
		<div id="overlayst3" class="overlay">
		  <i class="fa fa-refresh fa-spin"></i>
		</div>			
		<div class="box-header with-border">
		  <h3 class="box-title">'.$CFG["DESC_CARINFO"].'</h3>
		</div><!-- /.box-header -->
			  <div class="box-body">
			  
		  <table id="example1" class="table table-bordered table-hover dt-responsive nowrap" cellspacing="0" width="100%">
			<thead>
			  <tr>
			    <th>'.$CFG["OPTIONS"].'</th>
				<th>'.$CFG["CAR"].'</th>
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
			<div class="form-group">	
			<label>'.$CFG["PickupDate"].' '.$CFG["location"].'</label>
			<div class="input-group">
			  <div class="input-group-addon">
				<i class="fa fa-map-marker"></i>
			  </div>						

				  <input id="pickup" name="pickup" autocomplete="on" capital="true" type="text" class="form-control" placeholder="'.$CFG["EG_LOC1"].'" value="" data-mask>
			</div>		
			</div>	
			<div class="form-group">	
			<label>'.$CFG["DropoffDate"].' '.$CFG["location"].'</label>
			<div class="input-group">
			  <div class="input-group-addon">
				<i class="fa  fa-map-marker"></i>
			  </div>						

				  <input id="return" name="return" autocomplete="on" capital="true" type="text" class="form-control" placeholder="'.$CFG["EG_LOC2"].'" value="" data-mask>
			</div>		
			</div>			
				<div class="form-group">
				<label>'.$CFG["RESERVATION"].'</label>
				<div class="input-group">
				  <div class="input-group-addon">
					<i class="fa fa-calendar"></i>
				  </div>
					 <input id="reservation" name="reservation"  class="form-control" type="text">
				</div>						
				</div>
				<div class="form-group">
				<label>'.$CFG["DESC_PRICEPERDAY"].'</label>
					<div class="input-group">
					  <div class="input-group-addon">
						<i class="fa fa-euro"></i>
					  </div>
						 <input id="pricePerDay" name="pricePerDay" pattern="[^0-9]" class="form-control" type="text">
					</div>						
				</div>		
				<div class="form-group">
				<label>'.$CFG["DESC_FRANCHISE"].'</label>
					<div class="input-group">
					  <div class="input-group-addon">
						<i class="fa fa-euro"></i>
					  </div>
						 <input id="franchise" name="franchise" pattern="[^0-9]" class="form-control" type="text">
					</div>						
				</div>	

				<div class="form-group">
					<label>'.$CFG["OPTIONAL_ITEMS"].'</label>
                    <select id="optionale" name="optionale[]" class="form-control select3" multiple="multiple" data-placeholder="'.$CFG["OPTIONAL_ITEMS"].'" style="width: 100%;">
					';
					
					$inv_arr = explode(',', $_SESSION["EXTRA_ITEMS"]);
					foreach($inv_arr as $val) {
					$clean_val = explode('_', $val);
					//0 = ID, 1=PRICE, 2=Name
					$boday .= '<option value="'.$val.'">'.$clean_val[2].' '.$CFG["AT"].' '.$clean_val[1].'/'.$CFG["DAY_R"].'</option>';
					}					
					$boday .= '
					</select>

				</div>	
			  </div><!-- /.box-body -->
			  <div class="box-footer">
				<button id="servicesaveback" name="servicesave" type="submit" value="Save" class="btn btn-warning pull-left"><i class="fa fa-arrow-left"></i> '.$CFG["BACK"].'</button>
				<button id="servicesave" name="servicesave"  type="submit" value="Save" class="btn btn-success pull-right">'.$CFG["NEXT"].' <i class="fa fa-arrow-right"></i></button>					
			  </div>
		</div>
		  </div><!-- /.tab-pane -->
		</div><!-- /.tab-content -->
	  </div><!-- nav-tabs-custom -->
	  </form>
	  
<div id="onseHideNform" style="display:none">

<div class="form-group">
<label>'.$CFG["LBL_CNP"].'</label>
<div class="input-group">
  <div class="input-group-addon">
	<i class="fa fa-barcode"></i>
  </div>							
	  <input id="CNP_DRIVER" name="CNP_DRIVER[]" capital="true" type="text" class="form-control"  search="byID" placeholder="'.$CFG["DESC_CNP"].'" value="" data-mask>
</div>	
</div>	
<div class="form-group">	
<label>'.$CFG["NAME"].'</label>
<div class="input-group">
  <div class="input-group-addon">
	<i class="fa fa-user"></i>
  </div>							
	  <input id="name_driver" name="name_driver[]" capital="true" type="text" class="form-control" placeholder="'.$CFG["DESC_NAME"].'" value="" data-mask>
</div>
</div>
<div class="form-group">
<label>'.$CFG["ADDRESS"].'</label>						
<div class="input-group">
  <div class="input-group-addon">
	<i class="fa fa-map-marker"></i>
  </div>							
	  <input id="address_driver" name="address_driver[]" capital="true" type="text" class="form-control" placeholder="'.$CFG["EG_ADDRESS"].'" value="">
</div>
</div>
 
<div class="form-group">
<label>'.$CFG["Email"].'</label>
<div class="input-group">
  <div class="input-group-addon">
	<i class="fa fa-envelope"></i>
  </div>							
	  <input id="email_driver" name="email_driver[]" type="email" class="form-control" placeholder="" value="">
</div>
</div>

<div class="form-group">	
<label>'.$CFG["PHONE"].'</label>
<div class="input-group">
  <div class="input-group-addon">
	<i class="fa fa-phone"></i>
  </div>						

	  <input id="phone_driver" name="phone_driver[]" type="text" class="form-control" placeholder="" value="" data-mask>
</div>		
</div>

<div class="form-group">
<label>'.$CFG["BIRTHDAY"].'</label>
<div class="input-group">
  <div class="input-group-addon">
	<i class="fa fa-birthday-cake"></i>
  </div>
	 <input id="bday_driver" name="bday_driver[]"  class="form-control" data-inputmask="\'alias\': \'yyyy/mm/dd\'" data-mask="" type="text">
</div>						
</div>	

<div class="form-group">	
<label>'.$CFG["DESC_DRIVERS_LICENCEID"].'</label>
<div class="input-group">
  <div class="input-group-addon">
	<i class="fa fa-credit-card"></i>
  </div>						

	  <input id="driver_licence" name="driver_licence[]" type="text" class="form-control" placeholder="" value="" data-mask>
</div>		
</div>	

<div class="form-group">
<label>'.$CFG["DESC_DRIVERS_EXPIRE_RE"].'</label>
<div class="input-group">
  <div class="input-group-addon">
	<i class="fa fa-credit-card"></i>
  </div>
	 <input id="driver_licence_expire" name="driver_licence_expire[]"  class="form-control" data-inputmask="\'alias\': \'yyyy/mm/dd\'" data-mask="" type="text">
</div>						
</div>	

</div>	  
	  
	  
	  
	</div>	
</div>

  <!-- Your Page Content Here -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->
';
print $boday;
}
?>