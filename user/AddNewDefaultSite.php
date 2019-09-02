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
function isValid($str) {
  $allowed = array("=", ".", "-", "_", ",", " ", "[", "]", ":", "+", "|", "!", "%", "&", "@", "/", "*", "?", "#", "'");
  if(empty($str))
  {
  return true;
  
  }
  if (ctype_alnum(str_replace($allowed, '', $str ) ) ) {
    return true;
  } else {
    return false;
  }
}
if(isset($_SESSION['uid']))
{
$userID = $_SESSION['uid'];
$toRedirect = 0;
include '../mysql_connect.php';
$stmtz = sprintf('SELECT * FROM _accounts WHERE uid = "%s"', $userID);
$stmtz = mysql_query($stmtz);
if (mysql_num_rows($stmtz) > 0){
$siteLink = base64_encode("http://www.games-shark.com/");
$siteBanner = base64_encode("http://www.games-shark.com/user/defaultbanner.png");
$siteTitle = base64_encode("Best Ranking Site Ever");
$sideText = base64_encode("Games-shark.com is one of the fastest growing online gaming portal and communities in the world. We list the best sites, Blade and Soul, Runescape, CoD, WoW and many more on the internet. Games Shark helps gamers get the best experience every time they play by providing optimal news.");
$category = 0;
$flag = base64_encode("/images/flags/Germany.png");
	 $query2 = sprintf("INSERT INTO `_sites` (`userId`, `siteLink`, `siteBanner`, `siteTitle`, `sideText`, `category`, `flag`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",	
	 mysql_real_escape_string($userID),
	 mysql_real_escape_string($siteLink),
	 mysql_real_escape_string($siteBanner),
	 mysql_real_escape_string($siteTitle),
	 mysql_real_escape_string($sideText),
	 mysql_real_escape_string($category),
	 mysql_real_escape_string($flag)
	 );
	 if(mysql_query($query2))
	 {		
		$toRedirect = mysql_insert_id();
			$query = "SELECT * FROM _sites WHERE userId=$userID ORDER BY `_sites`.`createTime` ASC" ;
			$sites = array();
			$query = mysql_query($query);
			if (mysql_num_rows($query) > 0) {
				while ($row = mysql_fetch_array($query)) {
					 $sites[$row['uid']] = $row;
					}
			}		
			$_SESSION['sites'] = $sites;	
				print
				'
				<div class="alert alert-success" role="alert">
				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				  <span class="sr-only">Done:</span>
				  <br> Please wait...
				</div>';
				print'<meta http-equiv="refresh" content="2;url=Manage-Site?uid='.$toRedirect.'">';	
	 }else{
		print "Something went wrong please try again later!";
	 }
}
mysql_close();
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
</body>
</html>