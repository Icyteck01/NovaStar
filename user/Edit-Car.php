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
include 'WEB-INF/nav.php';
include '../config.php';
$row = "";
$hasRow = false;
if(isset($_GET['uid']) && is_numeric($_GET['uid'])) {	
	$id=mysql_real_escape_string($_GET['uid']);
	$query_prepare = "SELECT * FROM `cars` WHERE id=$id";
	$get_info = MySQL_Query($query_prepare) or die(mysql_error($link));
	if(mysql_num_rows($get_info) > 0)
	{
		$row = mysql_fetch_array($get_info);
		$hasRow = true;
	}
	
}

print'
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">'.$row['name'].'</h1>
                    ';
//Salveaza
if(isset($_POST['save']) ) {
$upload_dir = "../assets/img/preview/cars/";
$allowed =  array('png' ,'jpg');
$filename = $_FILES['poza']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);
$id = $hasRow ? mysql_real_escape_string($_GET['uid']):0;
$target_file = $upload_dir . $id.'.'.$ext;
$name = $_POST['name'];
$comfort = $_POST['comfort'];
$poza = isset($_FILES['poza']) ? $id.'.'.$ext:$hasRow ? $row['poza']:"";
$engine = $_POST['engine'];
$doors = $_POST['doors'];
$seets = $_POST['seets'];
$gearbox = $_POST['gearbox'];
$gas = $_POST['gas'];
$type = $_POST['type'];
$year = $_POST['year'];
$price = $_POST['price'];
$price4 = $_POST['price4'];
$price8 = $_POST['price8'];
$price15 = $_POST['price15'];
$price31 = $_POST['price31'];
$franciza = $_POST['franciza'];
$discount = $_POST['discount'];
$discount4 = $_POST['discount4'];
$discount8 = $_POST['discount8'];
$discount15 = $_POST['discount15'];
$discount31 = $_POST['discount31'];

$continee = true;
if(isset($_FILES['poza']) && count($_FILES['poza']['error']) == 1 && $_FILES['poza']['error'][0] > 0 && !in_array($ext,$allowed)) {
	print '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>Format poza invalid.(doar jpg si png)</div>';
	$continee = false;
}

if ($continee && move_uploaded_file($_FILES['poza']['tmp_name'], $target_file)) {
} else {
if(isset($_FILES['poza']) && count($_FILES['poza']['error']) == 1 && $_FILES['poza']['error'][0] > 0)
{
	print '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>Nu pot incarca fisierul!</div>';		
	$continee = false;
}

}
	if($id == 0) {
	//insert
		mysql_query("INSERT INTO `cars` (`name`, `comfort`, `poza`, `engine`, `doors`, `seets`, `gearbox`, `gas`, `type`, `year`, `price`, `price4`, `price8`, `price15`, `price31`, `franciza`, `discount`, `discount4`, `discount8`, `discount15`, `discount31`,) VALUES ('$name', '$comfort', '$poza', '$engine', '$doors', '$seets', '$gearbox', '$gas', '$type', '$year', '$price', '$price4', '$price8', '$price15', '$price31', '$franciza','$discount', '$discount4', '$discount8', '$discount15', '$discount31');");
		print '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>Adaugat</div>';
	}else{
	//Update
		mysql_query("UPDATE `cars` SET discount=$discount, discount4=$discount4, discount8=$discount8, discount15=$discount15, discount31=$discount31, name='$name', comfort='$comfort', poza='$poza', engine='$engine', doors='$doors', seets='$seets', gearbox='$gearbox', gas='$gas', type='$type', year='$year', price='$price', price4='$price4', price8='$price8', price15='$price15', price31='$price31', franciza='$franciza' WHERE `cars`.`id` =$id;");
		print '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>Salvat cu succes</div>';
	}
		if($continee)
		{
			print '<META HTTP-EQUIV="refresh" CONTENT="4">';
		}
}					
mysql_close($link);					
print'
<form action="Edit-Car?uid='.(isset($_GET['uid']) ? $_GET['uid']:"").'" method="POST" enctype="multipart/form-data">
<div class="col-lg-12">
<img src="../assets/img/preview/cars/'.($hasRow ? $row['poza']:"").'" alt="Fara Poza" height="220" width="370"></img>
</div>
<div class="col-lg-6">
<h3>General</h3>
<hr>

<div class="form-group">
	<label>Poza</label>
	<input id="poza" name="poza" value="" type="file"/>
</div>
<div class="form-group">
	<label>Denumire</label>
	<input class="form-control" name="name" value="'.($hasRow ? $row['name']:"").'"/>
	<p class="help-block">ex:Audi A5</p>
</div>
<div class="form-group">
	<label>Echipare</label>
	<input class="form-control" name="comfort" value="'.($hasRow ? $row['comfort']:"").'"/>
	<p class="help-block">ex:S-Line</p>
</div>
<div class="form-group">
	<label>Gama</label>
	<select class="form-control" name="type">
	<option value="1" '.($hasRow && $row['type'] == 1 ? "selected":"").'>Economic</option>
	<option value="2" '.($hasRow && $row['type'] == 2 ? "selected":"").'>Business</option>
	<option value="3" '.($hasRow && $row['type'] == 3 ? "selected":"").'>Premium</option>
	<option value="4" '.($hasRow && $row['type'] == 4 ? "selected":"").'>Lux</option>
	</select>
</div>
<div class="form-group">
	<label>Anul De fabircatie</label>
	<input class="form-control" name="year" value="'.($hasRow ? $row['year']:"").'"/>
	<p class="help-block">ex:2015</p>
</div>
</div>
<div class="col-lg-6">
<h3>Tehnic</h3>
<hr>
<div class="form-group">
	<label>Motor</label>
	<input class="form-control" name="engine" value="'.($hasRow ? $row['engine']:"").'"/>
	<p class="help-block">ex:2500</p>
</div>
<div class="form-group">
	<label>Carburant</label>
	<select class="form-control" name="gas">
	<option value="0" '.($hasRow && $row['gas'] == 0 ? "selected":"").'>Benzina</option>
	<option value="1" '.($hasRow && $row['gas'] == 1 ? "selected":"").'>Motorina</option>
	<option value="2" '.($hasRow && $row['gas'] == 2 ? "selected":"").'>Gaz</option>
	</select>
</div>
<div class="form-group">
	<label>Transmisie</label>
	<select class="form-control" name="gearbox">
	<option value="1" '.($hasRow && $row['gearbox'] == 1 ? "selected":"").'>Manuala</option>
	<option value="0" '.($hasRow && $row['gearbox'] == 0 ? "selected":"").'>Automata</option>
	</select>
</div>
<div class="form-group">
	<label>Numar Usi</label>
	<input class="form-control" name="doors" value="'.($hasRow ? $row['doors']:"").'"/>
	<p class="help-block">ex:5</p>
</div>
<div class="form-group">
	<label>Numar Locuri</label>
	<input class="form-control" name="seets" value="'.($hasRow ? $row['seets']:"").'"/>
	<p class="help-block">ex:4</p>
</div>
</div>
<h3>Preturi si Oferte</h3>
<hr>
<table class="table table-bordered table-condensed">
    <tbody>
        <tr>
		    <th>Numar Zile</th>
            <th>Pret</th>
            <th>Discount</th>
            <th>Total</th>
        </tr>    
            <tr>
			<td><span>1</span></td>
			<td><span id="p1"><input class="form-control" name="price" value="'.($hasRow ? $row['price']:"").'"/></span></td>
			<td><span id="d1"><input class="form-control ind1" name="discount" value="'.($hasRow ? $row['discount']:"0").'"/></span></td>
			<td><span id="t1">'.($hasRow ? (int)$row['price']-(($hasRow ? $row['discount']:"0") / 100 * $row['price']) :"").'</span></td>
			</tr>
            <tr>
			<td><span>4</span></td>
			<td><span id="p2"><input class="form-control" name="price4" value="'.($hasRow ? $row['price4']:"").'"/></span></td>
			<td><span id="d2"><input class="form-control ind2" name="discount4" value="'.($hasRow ? $row['discount4']:"0").'"/></span></td>
			<td><span id="t2">'.($hasRow ? (int)$row['price4']-(($hasRow ? $row['discount4']:"0") / 100 * $row['price4']) :"").'</span></td>
			</tr>
            <tr>
			<td><span>8</span></td>
			<td><span id="p3"><input class="form-control" name="price8" value="'.($hasRow ? $row['price8']:"").'"/></span></td>
			<td><span id="d3"><input class="form-control ind3" name="discount8" value="'.($hasRow ? $row['discount8']:"0").'"/></span></td>
			<td><span id="t3">'.($hasRow ? (int)$row['price8']-(($hasRow ? $row['discount4']:"0") / 100 * $row['price8']) :"").'</span></td>
			</tr>
			<tr>
			<td><span>15</span></td>
			<td><span id="p4"><input class="form-control" name="price15" value="'.($hasRow ? $row['price15']:"").'"/></span></td>
			<td><span id="d4"><input class="form-control ind4" name="discount15" value="'.($hasRow ? $row['discount15']:"0").'"/></span></td>
			<td><span id="t4">'.($hasRow ? (int)$row['price15']-(($hasRow ? $row['discount4']:"0") / 100 * $row['price15']) :"").'</span></td>
			</tr>
			<tr>
			<td><span>31</span></td>
			<td><span id="p5"><input class="form-control" name="price31" value="'.($hasRow ? $row['price31']:"").'"/></span></td>
			<td><span id="d5"><input class="form-control ind5" name="discount31" value="'.($hasRow ? $row['discount31']:"0").'"/></span></td>
			<td><span id="t5">'.($hasRow ? (int)$row['price31']-(($hasRow ? $row['discount4']:"0") / 100 * $row['price31']) :"").'</span></td>
			</tr>
        
    </tbody>
</table>
<div class="form-group">
	<label>Franciza</label>
	<input class="form-control" name="franciza" value="'.($hasRow ? $row['franciza']:"").'"/>
	<p class="help-block">Pretul este in &euro; ex:300</p>
</div>
<hr>
<div class="form-group">
<input name="save" class="btn btn-success" type="submit" value="Salveaza"/>
<a href="DelSite?uid='.$_GET['uid'].'" onClick="return checkMe()" class="btn btn-danger">Sterge</a>
</div>
</form>

';					
                print'</div></div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
';
?>
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
<script>
$( document ).ready(function() {
	$( ".ind1" ).change(function() {
		var price = $('input[name=price]').val();
		var discount = $('input[name=discount]').val();
		var total = (price - (discount /100 * price));
		$("#t1").text(""+total);
	});
	$( ".ind2" ).change(function() {
		var price = $('input[name=price4]').val();
		var discount = $('input[name=discount4]').val();
		var total = (price - (discount /100 * price));
		$("#t2").text(""+total);
	});	
	$( ".ind3" ).change(function() {
		var price = $('input[name=price8]').val();
		var discount = $('input[name=discount8]').val();
		var total = (price - (discount /100 * price));
		$("#t3").text(""+total);
	});		
	$( ".ind4" ).change(function() {
		var price = $('input[name=price15]').val();
		var discount = $('input[name=discount15]').val();
		var total = (price - (discount /100 * price));
		$("#t4").text(""+total);
	});		
	$( ".ind5" ).change(function() {
		var price = $('input[name=price31]').val();
		var discount = $('input[name=discount31]').val();
		var total = (price - (discount /100 * price));
		$("#t5").text(""+total);
	});		
});
</script>  	
</body>

</html>
