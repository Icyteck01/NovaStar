<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

if(session_id() == '') {
    session_start();
}
include 'mysqlC.php';

$moneyLost = 0;
$moneyMade = 0;

$sql_notifications = MySQL_Query("SELECT spent,made FROM `cars` ORDER BY `spent` DESC");
while($rowx = mysql_fetch_array($sql_notifications))
{
$moneyLost += $rowx['spent'];
$moneyMade += $rowx['made'];

}
$moneytotal = $moneyMade - $moneyLost;

$table1="";
$sql_notifications = MySQL_Query("SELECT SUM(moneyVar) AS total, carId FROM cars_in_rent GROUP BY (carId) ORDER BY `total` DESC LIMIT 10");
$count = 1;

while($rowx = mysql_fetch_array($sql_notifications))
{
$carId = $rowx['carId'];
$sum = $rowx['total'];

$result2 = MySQL_Query("SELECT * FROM `cars` WHERE id ='$carId'");
$row2 = mysql_fetch_assoc($result2); 


$table1.='<tr>
		  <td>'.$count.'</td>
		  <td><img src="cars/'.$row2['poza'].'" height="39px" ></img> '.$row2['name'].'</td>
		  <td>'.$row2['plate'].'</td>
		  <td><span class="badge bg-green">'.$sum.' &euro;</span></td>
		</tr>';
$count++;
}

$table2="";
$sql_notifications = MySQL_Query("SELECT SUM(`moneySpent`) AS total, `CNP`,`isCompany`,`name`,`email`,`phone`,`bday`,`rentedcars`,`lastSeen` FROM entity_clients GROUP BY (CNP) ORDER BY `total` DESC LIMIT 10");
$count = 1;

while($rowx = mysql_fetch_array($sql_notifications))
{

$sum = $rowx['total'];

$table2.='<tr>
			  <td>'.$count.'</td>
			  <td><i class="fa fa-user-plus"></i> '.$rowx['name'].'</td>
			  <td>'.$rowx['phone'].'</td>
			  <td><span class="badge bg-green">'.$sum.' &euro;</span></td>
		 </tr>';
$count++;
}
$thisMonthStart = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
$thisMonthEnd = date('Y-m-d', mktime(0, 0, 0, date('m')+1, 0, date('Y')));
$lastMonthStart = date('Y-m-d', mktime(0, 0, 0, date('m')-1, 1, date('Y')));
$thisTime = strtotime($thisMonthStart);
$endTime = strtotime($thisMonthEnd);
$thislastTime = strtotime($lastMonthStart);
$arrayThisMonth = array();
$arrayPastMonth = array();
$dates = array();
$valueNow = array();
$valueLast = array();
while($thisTime <= $endTime)
{
	$arrayThisMonthValue = array();
	$arrayPastMonthValue = array();
    $thisDate1 = date('Y-m-d', $thisTime);
    $thisDateX = date('Y-m-d', $thisTime);
	$thisTime2 = date('Y-m-d', strtotime('+1 day', $thisTime));
	$result = mysql_query("SELECT COALESCE(SUM(moneyVar),0) AS moneyVar FROM cars_in_rent WHERE madeDate BETWEEN '$thisDate1' AND '$thisTime2' ORDER BY `moneyVar`");
		if($result){
			$count=mysql_num_rows($result);		
			if($count > 0)
			{
				$result_row = mysql_fetch_array($result);
				$arrayThisMonthValue["value"] = $result_row['moneyVar'];
				$arrayThisMonthValue["date"] = $thisDate1;
				$dates[] = $thisDateX;
				$valueNow[]  = $result_row['moneyVar'];
			}else{
				$arrayThisMonthValue["value"] = 0;
				$arrayThisMonthValue["date"] = $thisDate1;
				$dates[] = $thisDateX;
				$valueNow[] = 0;
			}
		}else{
				$arrayThisMonthValue["value"] = 0;
				$arrayThisMonthValue["date"] = $thisDate1;
				$dates[] = $thisDateX;
				$valueNow[] = 0;
			
		}
	$arrayThisMonth[] = $arrayThisMonthValue;
	$thislast1 = date('Y-m-d', $thislastTime);
	$thislastX = date('d', $thislastTime);
	$thislast2 = date('Y-m-d', strtotime('+1 day', $thislastTime));	
	$result2 = mysql_query("SELECT COALESCE(SUM(moneyVar),0) AS moneyVar FROM cars_in_rent WHERE madeDate BETWEEN '$thislast1' AND '$thislast2' ORDER BY `moneyVar`");	
		if($result2){
			$countc=mysql_num_rows($result2);		
			if($countc > 0)
			{
				$result_row2 = mysql_fetch_array($result2);
				$arrayPastMonthValue["value"] = $result_row2['moneyVar'];
				$arrayPastMonthValue["date"] = $thislast1;
				$valueLast[] = $result_row2['moneyVar'];
				
			}else{
				$arrayPastMonthValue["value"] = 0;
				$arrayPastMonthValue["date"] = $thislast1;
				$valueLast[] = 0;
			}
		}else{
				$arrayPastMonthValue["value"] = 0;
				$arrayPastMonthValue["date"] = $thislast1;
				$valueLast[] = 0;
			
		}	
	$arrayPastMonth[] = $arrayPastMonthValue;
	$thislastTime =  strtotime('+1 day', $thislastTime); // increment for loop
    $thisTime = strtotime('+1 day', $thisTime); // increment for loop
}
print'
<div class="content-wrapper">
<script>
$dates = '.json_encode($dates).'
$valueNow = '.json_encode($valueNow).'
$valueLast = '.json_encode($valueLast).'
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	'.$CFG["Dashboard_1"].'
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> '.$CFG["Dashboard_2"].'</a></li>
	<li class="active">'.$CFG["Dashboard_1"].'</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Info boxes -->
  <div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
	  <div class="info-box">
		<span class="info-box-icon bg-red"><i class="ion ion-settings"></i></span>
		<div class="info-box-content">
		  <span class="info-box-text">'.$CFG["Dashboard_3"].'</span>
		  <span class="info-box-number">-'.$moneyLost.'<small>&euro;</small></span>
		</div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div><!-- /.col -->

	<!-- fix for small devices only -->
	<div class="clearfix visible-sm-block"></div>

	<div class="col-md-4 col-sm-6 col-xs-12">
	  <div class="info-box">
		<span class="info-box-icon bg-green"><i class="ion ion-model-s"></i></span>
		<div class="info-box-content">
		  <span class="info-box-text">'.$CFG["Dashboard_5"].'</span>
		  <span class="info-box-number">'.$moneyMade.'<small>&euro;</small></span>
		</div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div><!-- /.col -->
	<div class="col-md-4 col-sm-6 col-xs-12">
	  <div class="info-box">
		<span class="info-box-icon bg-yellow"><i class="ion ion-calculator"></i></span>
		<div class="info-box-content">
		  <span class="info-box-text">'.$CFG["Dashboard_4"].'</span>
		  <span class="info-box-number">'.$moneytotal.'<small>&euro;</small></span>
		</div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div><!-- /.col -->
  </div><!-- /.row -->

  <!-- Main row -->
  <div class="row">
	<!-- Left col -->
	<div class="col-md-12">
	  <div class="box">
		<div class="box-header with-border">
		  <h3 id="cartTitle" class="box-title">'.$CFG["calendar_30"].'</h3>
		  <div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<div class="btn-group">
			  <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
			  <ul class="dropdown-menu" role="menu">
				<li><a href="#" id="displayFirstCart">'.$CFG["calendar_27"].'</a></li>
				<li><a href="#" id="displaySecondCart">'.$CFG["calendar_28"].'</a></li>
			  </ul>
			</div>
			<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		  </div>
		</div><!-- /.box-header -->
		<div class="box-body">
		  <div class="row">
			<div class="col-md-12">
			  <p class="text-center">
				<strong id="fillDatesCanvas"></strong>
			  </p>
			  <div class="chart">
				<!-- Sales Chart Canvas -->
				<canvas id="salesChart" style="height: 180px;"></canvas>
			  </div>		  
			</div><!-- /.col -->

		  </div><!-- /.row -->
	  </div><!-- /.box -->
	</div><!-- /.col -->

	  <!-- MAP & BOX PANE -->
	  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">'.$CFG["Dashboard_6"].'</h3>
			  <div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			  </div>  
		</div><!-- /.box-header -->
		<div class="box-body">
		  <table class="table table-bordered">
			<tr>
			  <th style="width: 10px">#</th>
			  <th>'.$CFG["BRAND"].'</th>
			  <th>'.$CFG["PLATE"].'</th>
			  <th style="width: 40px">'.$CFG["TOTAL"].'</th>
			</tr>
			'.$table1.'
		  </table>
		</div><!-- /.box-body -->
	  </div><!-- /.box -->
	</div><!-- /.col -->
	
	<div class="col-md-12">
	  <!-- MAP & BOX PANE -->
	  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">'.$CFG["Dashboard_7"].'</h3>
			  <div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			  </div>  
		</div><!-- /.box-header -->
		<div class="box-body">
		  <table class="table table-bordered">
			<tr>
			  <th style="width: 10px">#</th>
			  <th>'.$CFG["BRAND"].'</th>
			  <th>'.$CFG["PLATE"].'</th>
			  <th style="width: 40px">'.$CFG["TOTAL"].'</th>
			</tr>
			'.$table2.'
		  </table>
		</div><!-- /.box-body -->
	  </div><!-- /.box -->
	</div><!-- /.col -->
	
	<div class="col-md-12" >


 <div class="row" style="display:none">
	<div class="col-md-12">
	  <div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title">Top Profit Brands</h3>
			  <div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			  </div>  
		</div><!-- /.box-header -->
		<div class="box-body">
		  <table class="table table-bordered">
			<tr>
			  <th style="width: 10px">#</th>
			  <th>Brand</th>
			  <th>Progress</th>
			  <th style="width: 40px">Label</th>
			</tr>
			<tr>
			  <td>1.</td>
			  <td>Logan</td>
			  <td>
				<div class="progress progress-xs">
				  <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
				</div>
			  </td>
			  <td><span class="badge bg-red">55%</span></td>
			</tr>
			<tr>
			  <td>2.</td>
			  <td>Matiz</td>
			  <td>
				<div class="progress progress-xs">
				  <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
				</div>
			  </td>
			  <td><span class="badge bg-yellow">70%</span></td>
			</tr>
			<tr>
			  <td>3.</td>
			  <td>Trabant</td>
			  <td>
				<div class="progress progress-xs progress-striped active">
				  <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
				</div>
			  </td>
			  <td><span class="badge bg-light-blue">30%</span></td>
			</tr>
			<tr>
			  <td>4.</td>
			  <td>Skoda</td>
			  <td>
				<div class="progress progress-xs progress-striped active">
				  <div class="progress-bar progress-bar-success" style="width: 90%"></div>
				</div>
			  </td>
			  <td><span class="badge bg-green">90%</span></td>
			</tr>
			<tr>
			  <td>5.</td>
			  <td>Audi</td>
			  <td>
				<div class="progress progress-xs progress-striped active">
				  <div class="progress-bar progress-bar-success" style="width: 90%"></div>
				</div>
			  </td>
			  <td><span class="badge bg-green">90%</span></td>
			</tr>
		  </table>
		</div><!-- /.box-body -->
		<div class="box-footer clearfix">
		  <ul class="pagination pagination-sm no-margin pull-right">
			<li><a href="#">&laquo;</a></li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">&raquo;</a></li>
		  </ul>
		</div>
	  </div><!-- /.box -->
	</div><!-- /.col -->	
  </div><!-- /.row -->	
</div><!-- /.row -->	
</section><!-- /.content -->
</div><!-- /.content-wrapper -->';
mysql_close();
?>