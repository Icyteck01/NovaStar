<?php
include 'WEB-INF/head.php';
?>
<body>
<script language="javascript">
function checkMe() {
    if (confirm("Esti sigur ca vrei sa stergi masina?")) {
        return true;
    } else {
        return false;
    }
}
</script>
    <div id="wrapper">
        <!-- Navigation -->
<?php

function memberType($type)
{
 if($type == 1)
 {
	return "Gold";
 }
 if($type == 2)
 {
	return "Platinum";
 }
 return "Normal";
}
$page = "index";
include 'WEB-INF/nav.php';

print'
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Manage
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> Manage</a>
                            </li>
                        </ol>
                    </div>
					<a href="Add-Car" name="save" class="btn btn-warning" type="submit">Adauga</a>
                </div>
				<div class="row">
                    <div class="col-lg-12">
                        
                        <div class="table-responsive">
';




				 print'
				  <!-- 
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>Total Site Visits as of Today</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
               /.row -->
';
/*
print'
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Country Reached Table for site 1</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Country</th>
                                        <th>Visits</th>
                                    </tr>
                                </thead>
                                <tbody>

								<tr><td>Brazil</td> <td>1265</td></tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
				 </div>	
';
*/
include '../config.php';
print'
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nume</th>
			<th>An</th>
			<th>Motor</th>
			<th>Transmisie</th>
			<th>Combustibil</th>										
			<th>Optiuni</th>
		</tr>
	</thead>
	<tbody>
	<h2>Masinile tale</h2>
	';		
	$query_prepare = "SELECT * FROM `cars` ORDER BY `cars`.`id` DESC";
	$get_info = MySQL_Query($query_prepare) or die(mysql_error($link));
	while($row = mysql_fetch_array($get_info)) {
		$itemId = $row['id'];
		$gas = "";
		switch($row['gas'])
		{
		case 0:
		$gas = "Benzina";
		break;
		case 1:
		$gas = "Motorina";
		break;
		case 2:
		$gas = "Gaz";
		break;
		}	
		print'<tr>
		<td>'.$itemId.'</td>
		<td>'.$row['name'].'</td>
		<td>'.$row['year'].'</td>
		<td>'.$row['engine'].'</td>
		<td>'.($row['gearbox'] == 0 ? "Automata":"Manuala").'</td>
		<td>'.$gas.'</td>
		<td><a href="Edit-Car?uid='.$itemId.'" class="btn btn-success">Editeaza</a> &nbsp; <a href="DelSite?uid='.$itemId.'" onClick="return checkMe()" class="btn btn-danger">Sterge</a></td>
		</tr>';
	}
	mysql_close($link);
	

	print'                                 								
	</tbody>
</table>
</div>
</div>
</div>
';
print'		 				
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
    <!-- Flot Charts JavaScript -->
    <!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
	<script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>	
<script>
$(function() {
    // Area Chart
    <!--Morris.Area({
';	
mysql_close();	
print'       element: \'morris-area-chart\',';
print'       data: [{period: \'2010 Q1\', iphone: 2666, ipad: 1,itouch: 2647}, { period: \'2010 Q2\', iphone: 2778, ipad: 2294, itouch: 2441 }],';
print'       xkey: \'period\',';
print'       ykeys: [\'iphone\', \'ipad\', \'itouch\'],';
print'       labels: [\'Site1\', \'Site2\', \'Site3\'],';
print'       pointSize: 2,';
print'       hideHover: \'auto\',';
print'       resize: true';
print'	
    });



});
-->
</script>
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/flot-data.js"></script>	
</body>

</html>
';
?>