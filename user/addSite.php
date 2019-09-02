<?php
include 'WEB-INF/head.php';
?>
<body>

    <div id="wrapper">
        <!-- Navigation -->
<?php
include 'WEB-INF/nav.php';
?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
<?php


function validateUrl($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}


function textarea($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = strip_tags($data);
  $data = str_replace(PHP_EOL, '', $data);
  $data = trim(preg_replace('/\s\s+/', ' ', $data));
  return $data;
}

function isValid($str) {
  $allowed = array(".", "-", "_", ",", " ", "[", "]", ":", "+", "|", "!", "%", "&", "@", "/", "*", "?", "#", "'");
  if (ctype_alnum(str_replace($allowed, '', $str ) ) ) {
    return true;
  } else {
    return false;
  }
}

function isValidCustom($str) {
  $allowed = array(",", " ", ":", ".", "-");
  if (ctype_alnum(str_replace($allowed, '', $str ) ) ) {
    return true;
  } else {
    return false;
  }
}

function url_exists($url) {
$headers = @get_headers($url);
if(strpos($headers[0],'200') === false)
{
  return false;
}
else
{
 return true;
}
}

function hasChanged($str, $post) {
$matchesUID = intval(preg_replace('/[^0-9]+/', '', $_GET['uid']), 10);
$row = $_SESSION['sites'][$matchesUID];
$field = base64_decode($row[$str]);
		if(!empty($field) && $field != $post[$str])
		{
			return true;			
		}
			return false;	
}


function goodTypeImage($type) {

	if($type == 1 || $type == 2 || $type == 3 || $type == 6)
	{
		return true;
	}
	return false;
}

function checkRemoteFile($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if(curl_exec($ch)!==FALSE)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function testImage($siteBanner) {

	//check if image exists
	if(checkRemoteFile($siteBanner))
	{
		list($width, $height, $type, $attr) = getimagesize($siteBanner); 
		
		if(goodTypeImage($type))
		{
						
				if($width > 750)
				{
				  return false;
				}
				if($width < 468)
				{
				  return false;
				}
				if($height > 284)
				{
				  return false;
				}
				if($height < 60)
				{
				 return false;
				}
			return true;
		} else {
		 return false;
		}
	}else{
	 return false;
	}
	 return false;
}

if(isset($_SESSION['uid']) && isset($_POST['add']))
{

$goFurther = true;
if(!isset( $_POST['flag'], $_POST['category'], $_POST['siteLink'], $_POST['siteTitle'], $_POST['sideText']))
{
    $message = 'Please make sure you have the filled the form correctly';
$goFurther = true;
}
if( empty($_POST['flag']) || empty($_POST['category']) || empty($_POST['siteLink']) || empty($_POST['siteTitle']) || empty($_POST['sideText']) )
{
$goFurther = false;
$message = 'Please make sure you have the filled the form correctly';
} 

	if($goFurther)
	{
		$siteLink = $_POST['siteLink'];  //URL
		$siteBanner = $_POST['siteBanner']; //
		$siteTitle = $_POST['siteTitle']; // a-zA-Z0-9
		$sideText = $_POST['sideText']; // textarea
		$siteCFtitle = $_POST['siteCFtitle']; //a-z-A-Z0-1 : ,
		$siteCFvalues = $_POST['siteCFvalues'];//a-z-A-Z0-1 : ,
		$category = $_POST['category']; //a-z-A-Z0-1 : ,
		$flag = $_POST['flag']; //a-z-A-Z0-1_. : ,
		$allowed = array(".", "-", "_" , " ", "@", ",", "(", ")", "[", "]", "'");
		if (!empty($siteLink) && !validateUrl($siteLink))
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				Invalid <b>Site URL</b> or URL does not exists
			</div>';			  
		}	
		elseif(hasChanged('siteBanner', $_POST) && !empty($siteBanner) && !testImage($siteBanner))
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				Invalid <b>Banner image</b>.
				<br>Max width 750 Min Width 468
				<br>Max height 284 Min height 60
				<br>We allow only png,jpg,bmp and gif
				<br>Please keep the field blank if you don\'t have a banner.
			</div>';	
		}		
		elseif(!isValid($siteTitle) || empty($siteTitle) )
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				Invalid <b>Site Title</b>! Allowed characters are: A-Z 0-9 [ ] : - + | ! , . % & @ / * _ ? # \'
			</div>';	
		
		}
		elseif(!isValid($sideText) || empty($sideText) )
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				Invalid <b>Site Description</b>! Allowed characters are: A-Z 0-9 [ ] : - + | ! , . % & @ / * _ ? # \'
			</div>';	
		
		}	
		elseif(!isValidCustom($siteCFtitle) && !empty($siteCFtitle) )
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				Invalid <b>Custom Fields Names</b>! Allowed characters are: A-Z 0-9 , : . -
			</div>';	
		
		}
		elseif(!isValidCustom($siteCFtitle) && !empty($siteCFtitle) )
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				Invalid <b>Custom Fields Values</b>! Allowed characters are: A-Z 0-9 , : . -
			</div>';	
		
		}	
		elseif(count(explode(",", $siteCFtitle)) > 3)
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				<b>Custom Fields Names</b> must be divided by comma(",") and have no spaces between!<br>
				Must also not exid 3 custom parameters.
			</div>';	
		
		}	
		elseif(count(explode(",", $siteCFvalues)) > 3)
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				<b>Custom Fields Values</b> must be divided by comma(",") and have no spaces between!<br>
				Must also not exid 3 custom parameters.
			</div>';	
		
		}
		elseif(count(explode(",", $siteCFvalues)) > count(explode(",", $siteCFtitle)))
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				Error:You have more <b>Custom Fields Values</b> then <b>Custom Fields Names</b>
				<br><b>Custom Fields Values</b> then <b>Custom Fields Names</b> must be the same e.g.: 
				<br>Custom Field Name = Language:
				<br>Custom Field Value = English:
				<br>Must also not exid 3 custom parameters.
			</div>';	
		
		}
		elseif(count(explode(",", $siteCFvalues)) < count(explode(",", $siteCFtitle)))
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				Error:You have more <b>Custom Fields Names</b> then <b>Custom Fields Values</b>
				<br><b>Custom Fields Values</b> then <b>Custom Fields Names</b> must be the same e.g.: 
				<br>Custom Field Name = Language:
				<br>Custom Field Value = English:
				<br>Must also not exid 3 custom parameters.
			</div>';	
		
		}	
		elseif(strlen($siteTitle) > 40 || strlen($siteTitle) < 6)
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				Invalid <b>Site Title</b> length, must be minimum 6 and maximum 40 characters!<br>
				<br>Your length:'.strlen($siteTitle).'
			</div>';	
		
		}	
		elseif(strlen($sideText) > 600  || strlen($sideText) < 80)
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				Invalid <b>Site Description</b> length, must be minimum 80 and maximum 600 characters!
				<br>Your length:'.strlen($sideText).'
			</div>';	
		
		}				
		else{	
		$siteLink = base64_encode($siteLink);
		$siteBanner = base64_encode($siteBanner); 
		$siteTitle = base64_encode($siteTitle); 
		$sideText = base64_encode($sideText);
		$siteCFtitle = base64_encode($siteCFtitle); 
		$siteCFvalues = base64_encode($siteCFvalues);
		$category = intval(preg_replace('/[^0-9]+/', '', $category), 10); 
		$flag = base64_encode($flag); 		
			
		
		include '../mysql_connect.php';		
		$stmtz = sprintf('SELECT * FROM _sites WHERE siteLink = "%s"', mysql_real_escape_string($siteLink));
		$stmtz = mysql_query($stmtz);	
		if (mysql_num_rows($stmtz) > 0)
		{
			print '
			<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
				ERROR <b>Site URL</b> has been already used!
			</div>';	
		
		}else{		
			$userID = $_SESSION['uid'];
			$stmt = sprintf("INSERT INTO `_sites` (`userId` ,`siteLink` ,`siteBanner` ,`siteTitle` ,`sideText` ,`siteCFtitle` ,`siteCFvalues` ,`category` ,`flag`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
			mysql_real_escape_string($userID),
			mysql_real_escape_string($siteLink),
			mysql_real_escape_string($siteBanner),
			mysql_real_escape_string($siteTitle),
			mysql_real_escape_string($sideText),
			mysql_real_escape_string($siteCFtitle),
			mysql_real_escape_string($siteCFvalues),
			mysql_real_escape_string($category),
			mysql_real_escape_string($flag)
			);
			mysql_query($stmt);
			
			$query = "SELECT * FROM _sites WHERE userId=$userID ORDER BY userId DESC" ;
			$sites = array();
			$query = mysql_query($query);
			if (mysql_num_rows($query) > 0) {
				while ($row = mysql_fetch_array($query)) {
					 $sites[$row['uid']] = $row;
					 if($siteTitle == $row['siteTitle']){
						$time_betwin_votes = 1296000; //15 days
					    $timestamp=time()+$time_betwin_votes;
						$timenowput = time();
						$tuneLeft = $timestamp-$timenowput;
						mysql_query("INSERT INTO `sharkgames`.`_memberTyps` (`uid` ,`member_type` ,`end_date` ,`now` ,`time_left` ) VALUES ('".$row['uid']."' , '1', $timestamp, $timenowput, $tuneLeft);");
					 }
					}
			}		
			$_SESSION['sites'] = $sites;		
			mysql_close();
				print
				'
				<div class="alert alert-success" role="alert">
				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				  <span class="sr-only">axx:</span>
				  Site details saved with Success, this changes will be visible in the next 30 minutes.
				  <br> Please click on preview to see how your site will appear.
				  <br> Please wait...
				</div>';
				//print'<meta http-equiv="refresh" content="5;url=sites?uid='.count($_SESSION['sites']).'">';		
			}
		}
	}else{

print '
<div class="alert alert-danger" role="alert">
<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
<span class="sr-only">Error:</span>
'.$message.'
</div>';	



}


}


if(isset($_SESSION['uid']) && isset($_GET['new']))
{

print'
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-index"></i>  <a href="index.html">index</a>
                            </li>
                            <li>
                                <i class="fa fa-arrows-v"></i> Sites
                            </li>
                            <li class="active">
                                <i class="fa fa-fw fa-wrench"></i>  Add new Site
                            </li>							
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
';

print '
                <div class="row">
                    <div class="col-lg-12">

                        <form role="form" action="addSite?new=true" method="POST">
						
						';
						$cdir = scandir('../images/flags');
						
						print '
                            <div class="form-group">
                                <label>Host Location *</label>	
							<div class="dropdown">	
								<select class="form-control" name="flag">
								<option value="" class="dropdown" '.(isset($_POST['flag']) ? "":"selected").'>Where do you host your server?</option>
								';
									   foreach ($cdir as $key => $value)
									   {
										if (!in_array($value,array(".","..")))
										  { 
										   $valuey = str_replace(".png", "", $value);
										   $valuex = str_replace("_", " ", $valuey);
										   if((isset($_POST['flag']) ? $_POST['flag']:"") == $value)
										   {
										     print ' <option value="'.$value.'" selected>'.$valuex.'</option>';
										   }else{										
											 print ' <option value="'.$value.'">'.$valuex.'</option>';
										   }
										  }
									 }								
								print'
								</select>
							</div>
                                <p class="help-block">Country where you host your game.</p>
                            </div>

							
                            <div class="form-group">
                                <label>Site Category *</label>	
							<div class="dropdown">	
								<select class="form-control" name="category">
								<option value="" class="dropdown" '.(isset($_POST['category']) ? "":"selected").'>What Game Are you Running?</option>
								';
									$i=1;
									$handle = fopen("../WEB-INF/categories.data", "r");
									if ($handle) {
										while (($line = fgets($handle)) !== false) {
										   if((isset($_POST['category']) ? $_POST['category']:"") == $i)
										   {
										     print ' <option value="'.$i.'" selected>'.$line.'</option>';
										   }else{										
											 print ' <option value="'.$i.'">'.$line.'</option>';
										   }											
											$i++;
										}
										fclose($handle);
									}								
								print'
								</select>
							</div>
                                <p class="help-block">Category in which your site will be shown.</p>
                            </div>	
						    <hr>
                            <div class="form-group">
                                <label>Site URL *</label>
                                <input class="form-control" name="siteLink" value="'.(isset($_POST['siteLink']) ? $_POST['siteLink']:"").'" placeholder="Enter Site URL">
                                <p class="help-block">e.g. http://www.example.com</p>
                            </div>
							 <hr>
                            <div class="form-group">
                                <label>Site Title *</label>
                                <input class="form-control" name="siteTitle" value="'.(isset($_POST['siteTitle']) ? $_POST['siteTitle']:"").'" placeholder="Enter Site Title">
                                <p class="help-block">e.g. Cataclysm INSTANT 85</p>
                            </div>
							 <hr>
                           <div class="form-group">
                                <label>Site Banner URL</label>
                                <input class="form-control" name="siteBanner" value="'.(isset($_POST['siteBanner']) ? $_POST['siteBanner']:"").'" placeholder="Enter Site Title">
                                <p class="help-block">e.g. http://www.example.com/banner.gif</p>
                            </div>
							 <hr>
							<!--
                            <div class="form-group">
                                <label>File input</label>
                                <input type="file">
                            </div>
							-->
                            <div class="form-group">
                                <label>Site Description *</label>
                                <textarea id="sideText" name="sideText" class="form-control" rows="3">'.(isset($_POST['sideText']) ? $_POST['sideText']:"").'</textarea>
                            </div>
							<p class="help-block"><font color=red>Allowed characters are: A-Z 0-9 [ ] : - + | ! , . % & @ / * _ ? # \'</font></p>
                            <p id="count_message" class="help-block"></p>
							<p class="help-block">				
							<br>Max width 750 Min Width 468
							<br>Max height 284 Min height 60
							<br>We allow only png,jpg,bmp and gif
							</p>
							<hr>
							<input name="add" type="submit" value="Add Site" class="btn btn-primary" />
                        </form>

                      

                    </div>
                </div>
                <!-- /.row -->
';
}

?>
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
<script>
var text_max = 600;
var text_length = $('#sideText').val().length;
var text_remaining = text_max - text_length;
$('#count_message').html(text_remaining + ' characters remaining');

$('#sideText').keyup(function() { 
 text_length = $('#sideText').val().length;
 text_remaining = text_max - text_length;
  $('#count_message').html(text_remaining + ' characters remaining');
});		
</script>	
</body>

</html>
