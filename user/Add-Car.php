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
                        <h1 class="page-header">'.(!$hasRow? "":$row['name']).'</h1>
                    ';
//Salveaza
if(isset($_POST['save']) ) {
$upload_dir = "../assets/img/preview/cars/";
$allowed =  array('png' ,'jpg');
$filename = $_FILES['poza']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);
$qqqq = mysql_query("SHOW TABLE STATUS WHERE name = 'cars'");
$idrow = mysql_fetch_array($qqqq);
$id=$idrow['Auto_increment'];
$target_file = $upload_dir . $id.'.'.$ext;
$name = $_POST['name'];
$comfort = $_POST['comfort'];
$poza = $id.'.'.$ext;
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
$continee = true;
if(!in_array($ext,$allowed)) {
	print '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>Format poza invalid.(doar jpg si png)</div>';
	$continee = false;
}

if ($continee && move_uploaded_file($_FILES['poza']['tmp_name'], $target_file)) {
} else {
if($_FILES['poza']['error'][0] > 0)
{
	print '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>Nu pot incarca fisierul!</div>';		
	$continee = false;
}

}
if($continee)
{
mysql_query("INSERT INTO `cars` (`name`, `comfort`, `poza`, `engine`, `doors`, `seets`, `gearbox`, `gas`, `type`, `year`, `price`, `price4`, `price8`, `price15`, `price31`, `franciza`) VALUES ('$name', '$comfort', '$poza', '$engine', '$doors', '$seets', '$gearbox', '$gas', '$type', '$year', '$price', '$price4', '$price8', '$price15', '$price31', '$franciza');");
print '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>Adaugat</div>';
print '<meta http-equiv="refresh" content="3;url=Edit-Car?uid='.$id.'" />';
}
}					
mysql_close($link);					
print'
<form action="Add-Car" method="POST" enctype="multipart/form-data">
<div class="col-lg-6">
<h3>General</h3>
<hr>

<div class="form-group">
	<label>Poza</label>
	<input id="poza" name="poza" value="'.($hasRow ? $row['poza']:"").'" type="file"/>
	<input id="poza" name="poza2" value="'.($hasRow ? $row['poza']:"").'" type="hidden"/>
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
	<option value="0" '.($hasRow && $row['gearbox'] == 0 ? "selected":"").'>Manuala</option>
	<option value="1" '.($hasRow && $row['gearbox'] == 1 ? "selected":"").'>Automata</option>
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
<div class="form-group">
	<label>Pret/zi</label>
	<input class="form-control" name="price" value="'.($hasRow ? $row['price']:"").'"/>
	<p class="help-block">Pretul este in &euro; ex:40</p>
</div>
<div class="form-group">
	<label>Pret/4 zile</label>
	<input class="form-control" name="price4" value="'.($hasRow ? $row['price4']:"").'"/>
	<p class="help-block">Pretul este in &euro; ex:35</p>
</div>
<div class="form-group">
	<label>Pret/8 zile</label>
	<input class="form-control" name="price8" value="'.($hasRow ? $row['price8']:"").'"/>
	<p class="help-block">Pretul este in &euro; ex:30</p>
</div>
<div class="form-group">
	<label>Pret/15 zile</label>
	<input class="form-control" name="price15" value="'.($hasRow ? $row['price15']:"").'"/>
	<p class="help-block">Pretul este in &euro; ex:25</p>
</div>
<div class="form-group">
	<label>Pret/31 zile</label>
	<input class="form-control" name="price31" value="'.($hasRow ? $row['price31']:"").'"/>
	<p class="help-block">Pretul este in &euro; ex:20</p>
</div>
<div class="form-group">
	<label>Franciza</label>
	<input class="form-control" name="franciza" value="'.($hasRow ? $row['franciza']:"").'"/>
	<p class="help-block">Pretul este in &euro; ex:300</p>
</div>
<hr>
<div class="form-group">
<input name="save" class="btn btn-success" type="submit" value="Adauga"/>
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
</body>

</html>
