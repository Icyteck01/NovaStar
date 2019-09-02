<?php
include 'WEB-INF/head.php';
?>

<link href="css/manage.css" rel="stylesheet">
<link href="../css/responsive.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
<link href="css/bootstrap-switch.min.css" rel="stylesheet">
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
function addhttp($url) {
	$tmpurl = base64_decode($url);
    if (!preg_match("~^(?:f|ht)tps?://~i", $tmpurl)) {
        $url = base64_encode("http://" . $tmpurl);
    }
    return $url;
}
function addDots($string) {

    if (strstr($string, ':')) {
        
    }else{
	$string = $string.":";
	}
    return $string;
}


function getFill($type, $row, $pos, $catName){
/*
* 0 = normal
* 1 = Payed Normal
* 2 = Payed Top
*/
$link = 'o?a='.addhttp($row['siteLink']).'&o='.$row['uid'];
$title = (base64_decode($row['siteTitle']));
$text = (base64_decode($row['sideText']));
$banner = (base64_decode($row['siteBanner']));
$flag = (base64_decode($row['flag']));
$siteLink = (base64_decode($row['siteLink']));
$uidzxcxz = $row['uid'];
$votes = $row['vote'];
$out = $row['clicks'];


$siteCFtitle = explode(",", (base64_decode($row['siteCFtitle'])));
$siteCFvalues = explode(",", (base64_decode($row['siteCFvalues'])));

$youtubevalues = explode(",", (base64_decode($row['youtube'])));

if(empty($banner)){

$banner = "http://www.games-shark.com/user/defaultbanner.png";

}
$width = 0;
$height = 0;

$data = '
<br><br>
<div class="blog-post shadow" data-wow-offset="100" data-wow-iteration="1" style="margin:-10px;">
<x style="cursor:help" data-toggle="popover" data-placement="left" data-trigger="hover" title="Site Status" data-html="true" data-content="<div style=\'font-size:12px;\'>Publish or unpublish your website add on our ranking site.<br>Once you are finished editing your site info please give us 30 minutes to approve or re-approve your add.</div>">Status</x>: <input id="liveStateSwich-'.$uidzxcxz.'" data-id="'.$uidzxcxz.'" type="checkbox" name="activateSite" '.($row['live'] == 1 ? "checked":"").' class="liveStateSwich" data-size="mini" data-on-text="Published" data-off-text="Unpublished" data-on-color="success" data-off-color="danger">
<x class="tip" style="cursor:help" title="Enable/Disable this add to show social links, such as youtube videos and facebook page.">Social</x>:<input id="social_state-'.$uidzxcxz.'" data-id="'.$uidzxcxz.'" type="checkbox" name="activatesocial_state" '.($row['social'] == 1 ? "checked":"").' class="social_state" data-size="mini" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger">
<x style="cursor:help" data-toggle="popover" data-placement="left" data-trigger="hover" title="Ping Back" data-html="true" data-content="<div style=\'font-size:12px;\'>Ping Back enables you to check whether a user has voted correct or not.<br>Please check the ping back section on the left side menu before you enable this feature.</div>">Ping Back</x>:<input id="pingback_state-'.$uidzxcxz.'" data-id="'.$uidzxcxz.'" type="checkbox" name="pingback_state" '.($row['pingenable'] == 1 ? "checked":"").' class="pingback_state" data-size="mini" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger">
<br><hr>

<button id="edit_site_live-'.$uidzxcxz.'" data-id="'.$uidzxcxz.'" data-google="'.(base64_decode($row['google'])).'" data-twitter="'.(base64_decode($row['twitter'])).'" data-facebook="'.(base64_decode($row['facebook'])).'" data-category="'.($row['category']).'" data-siteCFvalues="'.base64_decode($row['siteCFvalues']).'" data-siteCFtitle="'.base64_decode($row['siteCFtitle']).'" data-titlex="'.$title.'" data-link="'.$siteLink.'" data-banner="'.$banner.'" data-text="'.$text.'" data-flag="'.$flag.'" class="btn btn-default edit_site_live tip" title="Edit this add spot."><i class="fa fa-pencil-square-o"></i></button>
<button id="edi_savebtn-'.$uidzxcxz.'" data-id="'.$row['uid'].'" class="btn btn-success save_site_live tip" title="Save this add spot." disabled><i class="fa fa-floppy-o"></i></button>
<button id="get_site_live-'.$uidzxcxz.'" data-id="'.$row['uid'].'" class="btn btn-warning get_site_live tip" title="Get Vote Link Code For This Add."><i class="fa fa-code"></i></button>

<button data-id="'.$row['uid'].'" class="btn btn-danger del_site_live pull-right tip" title="Delete this add spot."><i class="fa fa-eraser"></i></button>
<hr>
Category: <select id="cat_edi-'.$uidzxcxz.'" name="category" class="category_edi_live" style="display:none">
<option value="0">What Game Are you Running?</option>
';

$i=1;
$handle = fopen("../WEB-INF/categories.data", "r");
if ($handle) {
while (($line = fgets($handle)) !== false) {
if($row['category'] == $i)
{
$data .= ' <option value="'.$i.'" selected>'.$line.'</option>';
}else{										
$data .= ' <option value="'.$i.'">'.$line.'</option>';
}											
$i++;
}

fclose($handle);
}
$data .='</select>
<p>
<div class="pull-left" style="color:#FF7105;">
<span class="badge badge-warning tip" title="UID:'.$row['uid'].' Category:'.$catName[$row['category']-1].'." style="font-size: 15px">#'.$row['uid'].'</span>&nbsp; <span title="Total Votes." class="badge badge-info tip" style="font-size: 15px" >+'.$votes.'</span> <a href="../Details-'.(str_replace(' ', '-', $title)).'-SiteId-'.$uidzxcxz.'" target="_blank">Details</a></div>
<div class="pull-right" style="color:rgb(33, 149, 141);margin-top:-10px;"><img src="../images/views1.png" class="tip" title="Total Views" style="width:30px;height:30px;"></img>&nbsp; <b class="tip" title="Total Views." >'.$out.'</b></div>
</p>
<br>
<br>

<p class="pull-left h4" style="margin-top:-10px;" >
<b id="edi_title-'.$uidzxcxz.'" class="title_live_edi tip" title="Your Title.">'.$title.'</b>
</p>

<br>
<x id="edi_link-'.$uidzxcxz.'" data-id="'.$uidzxcxz.'" class="link_live_edi tip" title="Your website URL." style="display:none;">'.$siteLink.'</x>
	<center>
		<img id="edi_img-'.$uidzxcxz.'"  src="'.$banner.'" style="width:100%!important;important;" class="img" alt=""></img>
	</center>
<x id="edi_banner-'.$uidzxcxz.'" data-id="'.$uidzxcxz.'" class="banner_live_edi tip" title="Your website Banner URL." style="display:none;">'.$banner.'</x><a id="reset_baaner_val1-'.$uidzxcxz.'" data-id="'.$row['uid'].'" href="#" onClick="return false;" class="reset_baaner_val1 tip" style="display:none;" title="Reset this to predefined value!(It wont show on website)"><i class="fa fa-eraser"></i></a>
<p id="edi_text-'.$uidzxcxz.'" class="tip text_live_edi" style="word-break: break-all;" title="Server Description." >'.$text.'</p>
<p style="color:#FF7105;">
<x class="tip" title="Country where the server is hosted.">Country</x>: <img id="flag_img_edi-'.$uidzxcxz.'" src="/images/flags/'.$flag.'" alt="" style="width:20px;height:12px;" class="tip" data-placement="top" data-toggle="tooltip" data-original-title="'.str_replace('_', ' ', str_replace('.png', '', $flag)).'"></img>
<select name="flag" id="edi_flag-'.$uidzxcxz.'" class="dropdown flag_edi" style="display:none;color:#000;">
<option value="0">Where do you host your server?</option>';
$cdir = scandir('../images/flags');
foreach ($cdir as $key => $value)
{
  if (!in_array($value,array(".","..")))
  { 
   $valuey = str_replace(".png", "", $value);
   $valuex = str_replace("_", " ", $valuey);
   if(base64_decode($row['flag']) == $value)
   {
	 $data .= ' <option value="'.$value.'" selected>'.$valuex.'</option>';
   }else{										
	 $data .= ' <option value="'.$value.'">'.$valuex.'</option>';
   }
  }
}
$facebook = (base64_decode($row['facebook']));
$google = (base64_decode($row['google']));
$twitter = (base64_decode($row['twitter']));
$pingBack = (base64_decode($row['pingBack']));
$data .='</select>
<br><x id="edi_Custom1-'.$uidzxcxz.'" class="Custom1_edi tip" title="A Custom Title-value that you can assign to your add.">'.(!empty($siteCFtitle[0]) ? $siteCFtitle[0]:"Custom1").'</x>: <font color="#000"><x id="edi_Val1-'.$uidzxcxz.'" class="Val1_edi tip" title="A Custom value that you can assign to your add.">'.(!empty($siteCFvalues[0]) ? $siteCFvalues[0]:"Val1").'</x></font><a id="reset_live_val1-'.$uidzxcxz.'" data-id="'.$row['uid'].'" href="#" onClick="return false;" class="reset_live_val1 tip" style="display:none;" title="Reset this to predefined value!(It wont show on website)"><i class="fa fa-eraser"></i></a>
<br><x id="edi_Custom2-'.$uidzxcxz.'" class="Custom2_edi tip" title="A Custom Title-value that you can assign to your add.">'.(!empty($siteCFtitle[1]) ? $siteCFtitle[1]:"Custom2").'</x>: <font color="#000"><x id="edi_Val2-'.$uidzxcxz.'" class="Val2_edi tip" title="A Custom value that you can assign to your add.">'.(!empty($siteCFvalues[1]) ? $siteCFvalues[1]:"Val2").'</x></font><a id="reset_live_val2-'.$uidzxcxz.'" data-id="'.$row['uid'].'" href="#" onClick="return false;" class="reset_live_val2 tip" style="display:none;" title="Reset this to predefined value!(It wont show on website)"><i class="fa fa-eraser"></i></a>
<br><x id="edi_Custom3-'.$uidzxcxz.'" class="Custom3_edi tip" title="A Custom Title-value that you can assign to your add.">'.(!empty($siteCFtitle[2]) ? $siteCFtitle[2]:"Custom3").'</x>: <font color="#000"><x id="edi_Val3-'.$uidzxcxz.'" class="Val3_edi tip" title="A Custom value that you can assign to your add.">'.(!empty($siteCFvalues[2]) ? $siteCFvalues[2]:"Val3").'</x></font><a id="reset_live_val3-'.$uidzxcxz.'" data-id="'.$row['uid'].'" href="#"  onClick="return false;" class="reset_live_val3 tip" style="display:none;" title="Reset this to predefined value!(It wont show on website)"><i class="fa fa-eraser"></i></a>
<div id="social-live-edi-'.$uidzxcxz.'" style="display:none;">
<hr>
Facebook:
<x id="social_facebook_edi-'.$uidzxcxz.'" class="social_facebook_edi_live">'.(!empty($facebook) ? $facebook:"Your Facebook Page").'</x><a data-id="'.$row['uid'].'" href="#" class="reset_live_Facebook tip" title="Reset this to predefined value!(It wont show on website)" onClick="return false;"><i class="fa fa-eraser"></i></a><br>
Google+:
<x id="social_google_edi-'.$uidzxcxz.'" class="social_google_edi_live">'.(!empty($google) ? $google:"Your Google Page").'</x><a data-id="'.$row['uid'].'" href="#" class="reset_live_Google tip" title="Reset this to predefined value!(It wont show on website)" onClick="return false;"><i class="fa fa-eraser"></i></a><br>
Twitter:
<x id="social_twitter_edi-'.$uidzxcxz.'" class="social_twitter_edi_live">'.(!empty($twitter) ? $twitter:"Your Twitter Page").'</x><a data-id="'.$row['uid'].'" href="#" class="reset_live_Twitter tip" title="Reset this to predefined value!(It wont show on website)" onClick="return false;"><i class="fa fa-eraser"></i></a><br>

<br><x class="h4">Youtube</x>
<br><x id="youtbe1_edi-'.$uidzxcxz.'" class="youtbe1_edi_live">'.(!empty($youtubevalues[0]) ? $youtubevalues[0]:"https://www.youtube.com/embed/UH-kf0mDTlc").'</x><a data-id="'.$row['uid'].'" href="#" onClick="return false;" class="reset_live_youtube1 tip" title="Reset this to predefined value!(It wont show on website)"><i class="fa fa-eraser"></i></a>
<x id="iframe_youtbe1_edi-'.$uidzxcxz.'"><iframe width="560" height="315" src="'.(!empty($youtubevalues[0]) ? $youtubevalues[0]:"https://www.youtube.com/embed/UH-kf0mDTlc").'" frameborder="0" allowfullscreen></iframe></x>
<br><x id="youtbe2_edi-'.$uidzxcxz.'"  class="youtbe2_edi_live">'.(!empty($youtubevalues[1]) ? $youtubevalues[1]:"https://www.youtube.com/embed/UH-kf0mDTlc").'</x><a data-id="'.$row['uid'].'" href="#" onClick="return false;" class="reset_live_youtube2 tip" title="Reset this to predefined value!(It wont show on website)"><i class="fa fa-eraser"></i></a>
<x id="iframe_youtbe2_edi-'.$uidzxcxz.'"><iframe width="560" height="315" src="'.(!empty($youtubevalues[1]) ? $youtubevalues[1]:"https://www.youtube.com/embed/UH-kf0mDTlc").'" frameborder="0" allowfullscreen></iframe></x>
<br><x id="youtbe3_edi-'.$uidzxcxz.'"  class="youtbe3_edi_live">'.(!empty($youtubevalues[2]) ? $youtubevalues[2]:"https://www.youtube.com/embed/UH-kf0mDTlc").'</x><a data-id="'.$row['uid'].'" href="#" onClick="return false;" class="reset_live_youtube3 tip" title="Reset this to predefined value!(It wont show on website)"><i class="fa fa-eraser"></i></a>
<x id="iframe_youtbe3_edi-'.$uidzxcxz.'"><iframe width="560" height="315" src="'.(!empty($youtubevalues[2]) ? $youtubevalues[2]:"https://www.youtube.com/embed/UH-kf0mDTlc").'" frameborder="0" allowfullscreen></iframe></x>
</div>
<div id="social-pingback-div-edi-'.$uidzxcxz.'" style="display:none;">
<hr>
Ping Back Url:
<x id="social_pingback_edi-'.$uidzxcxz.'" class="social_pingback_edi_live">'.(!empty($pingBack) ? $pingBack:"Your Pingback URL").'</x><button id="save_pingback_btn-'.$uidzxcxz.'" data-id="'.$row['uid'].'" href="#" onClick="return false;" class="save_pingback_btn btn btn-success btn-xs tip" title="Save your pingback url."><i class="fa fa-floppy-o"></i></button><br>
</div>
</span>
</p>

</div>
';



return $data.'<hr style="background-color: #000; height: 1px; border: 0;">';
}

if(isset($_SESSION['uid']) && isset($_GET['uid']) && is_numeric($_GET['uid']))
{
$handle = fopen("../WEB-INF/categories.data", "r");
$i=0;
if ($handle) {
	while (($line = fgets($handle)) !== false) {
		$cats_arrayx[$i] = trim($line);
		$i++;
	}

	fclose($handle);
}

$uid = $_SESSION['uid'];
$premium ="";
$html ="";
$has_gold = true;
$pos = 0;

$html .= getFill(1, $_SESSION['sites'][$_GET['uid']], $pos, $cats_arrayx);

echo '
<div class="container" style="max-width:600px!important;">';
	print $html;
echo '</div>';
}
?>					
					
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
	 <script src="js/bootstrap-switch.min.js"></script>
	

	<script type="text/javascript" src="../WEB-INF/bootstrap-dialog/js/bootstrap-dialog.js"></script>	
	
<script>
$( document ).ready(function() {

function addHttp(url) {
	if (!/^(f|ht)tps?:\/\//i.test(url)) {
		url = 'http://' + url;
	}
	return url;
}

var id;
var titlex;
var link;
var banner;
var text;
var flag;
var siteCFtitle;
var siteCFvalues;
var category;
var custom1;
var custom2;
var custom3;
var val1;
var val2;
var val3;
var youtbe1;
var youtbe2;
var youtbe3;
var facebook;
var twitter;
var google;

var pingback;

var regex = /[\.,+-|\/#!%?&\*:\-_'()\@\[\] ]/g;
var regex2 = /[^A-Za-z0-9 \.,+-|\/#!%?&\*:\-_'()\@\[\]]/g;
var regex3 = /[^A-Za-z0-9\.-]/g;
function isValid($str) {
  var str = $str.replace(regex,"");
  var regx = /^[A-Za-z0-9 ]+$/;
  if (regx.test(str)) {
    return true;
  } else {
    return false;
  }
}


$('.edit_site_live').click(function(){
//contenteditable
id = $(this).data("id");
titlex = $(this).data("titlex");
link = $(this).data("link");
banner = $(this).data("banner");
text = $(this).data("text");
flag = $(this).data("flag");
siteCFtitle = $(this).data("siteCFtitle");
siteCFvalues = $(this).data("siteCFvalues");
custom1 = $("#edi_Custom1-"+id).text();
custom2 = $("#edi_Custom2-"+id).text();
custom3 = $("#edi_Custom3-"+id).text();
val1 = $("#edi_Val1-"+id).text();
val2 = $("#edi_Val2-"+id).text();
val3 = $("#edi_Val3-"+id).text();
category = $(this).data("category");
pingback = $("#social_pingback_edi-"+id).text();
youtbe1 = $("#youtbe1_edi-"+id).text();
youtbe2 = $("#youtbe2_edi-"+id).text();
youtbe3 = $("#youtbe3_edi-"+id).text();

facebook = $(this).data("facebook");
twitter = $(this).data("twitter");
google = $(this).data("google");


if($("#social_state-"+id)[0].checked)
{
	$("#social-live-edi-"+id).show();
}
if($("#pingback_state-"+id)[0].checked)
{
	$("#social-pingback-div-edi-"+id).show();

}
$("#edi_banner-"+id).show();
$("#edi_flag-"+id).show();
$("#edi_link-"+id).show();
$("#cat_edi-"+id).show();
$("#reset_live_val1-"+id).show();
$("#reset_live_val2-"+id).show();
$("#reset_live_val3-"+id).show();
$("#reset_baaner_val1-"+id).show();
$("#social_pingback_edi-"+id).attr('class', '').addClass('edit');
$("#social_pingback_edi-"+id).prop("contentEditable", "true");	
$("#edit_site_live-"+id).attr('disabled','disabled');
$("#edi_savebtn-"+id).removeAttr('disabled');
$("#edi_title-"+id).attr('class', '').addClass('edit');
$("#edi_banner-"+id).attr('class', '').addClass('edit');
$("#edi_text-"+id).attr('class', '').addClass('edit');
$("#edi_Custom1-"+id).attr('class', '').addClass('edit');
$("#edi_Custom2-"+id).attr('class', '').addClass('edit');
$("#edi_Custom3-"+id).attr('class', '').addClass('edit');
$("#edi_Val1-"+id).attr('class', '').addClass('edit');
$("#edi_Val2-"+id).attr('class', '').addClass('edit');
$("#edi_Val3-"+id).attr('class', '').addClass('edit');
$("#edi_title-"+id).prop("contentEditable", "true");
$("#edi_banner-"+id).prop("contentEditable", "true");
$("#edi_text-"+id).prop("contentEditable", "true");
$("#edi_Custom1-"+id).prop("contentEditable", "true");
$("#edi_Custom2-"+id).prop("contentEditable", "true");
$("#edi_Custom3-"+id).prop("contentEditable", "true");
$("#edi_Val1-"+id).prop("contentEditable", "true");
$("#edi_Val2-"+id).prop("contentEditable", "true");
$("#edi_Val3-"+id).prop("contentEditable", "true");
$("#edi_link-"+id).attr('class', '').addClass('edit');
$("#edi_link-"+id).prop("contentEditable", "true");
$("#youtbe1_edi-"+id).attr('class', '').addClass('edit');
$("#youtbe1_edi-"+id).prop("contentEditable", "true");
$("#youtbe2_edi-"+id).attr('class', '').addClass('edit');
$("#youtbe2_edi-"+id).prop("contentEditable", "true");
$("#youtbe3_edi-"+id).attr('class', '').addClass('edit');
$("#youtbe3_edi-"+id).prop("contentEditable", "true");
$("#social_facebook_edi-"+id).attr('class', '').addClass('edit');
$("#social_facebook_edi-"+id).prop("contentEditable", "true");
$("#social_google_edi-"+id).attr('class', '').addClass('edit');
$("#social_google_edi-"+id).prop("contentEditable", "true");
$("#social_twitter_edi-"+id).attr('class', '').addClass('edit');
$("#social_twitter_edi-"+id).prop("contentEditable", "true");
});


$('.reset_live_Facebook').click(function(e){
var id = $(this).data("id");
$("#social_facebook_edi-"+id).text('Your Facebook Page');
facebook = $("#social_facebook_edi-"+id).text();
});
$('.reset_live_Google').click(function(e){
var id = $(this).data("id");
$("#social_google_edi-"+id).text('Your Google Page');
google = $("#social_google_edi-"+id).text();
});
$('.reset_live_Twitter').click(function(e){
var id = $(this).data("id");
$("#social_twitter_edi-"+id).text('Your Twitter Page');
twitter = $("#social_twitter_edi-"+id).text();
});

$('.reset_live_youtube1').click(function(e){
var id = $(this).data("id");
$("#youtbe1_edi-"+id).text('https://www.youtube.com/embed/UH-kf0mDTlc');
youtbe1 = $("#youtbe1_edi-"+id).text();
var iframe = '<iframe src="'+youtbe1+'" width="560" height="315" frameborder="0" allowfullscreen></iframe>';
$("#iframe_youtbe1_edi-"+id).html(iframe);
});
$('.reset_live_youtube2').click(function(e){
var id = $(this).data("id");
$("#youtbe2_edi-"+id).text('https://www.youtube.com/embed/UH-kf0mDTlc');
youtbe2 = $("#youtbe2_edi-"+id).text();
var iframe = '<iframe src="'+youtbe2+'" width="560" height="315" frameborder="0" allowfullscreen></iframe>';
$("#iframe_youtbe2_edi-"+id).html(iframe);
});
$('.reset_live_youtube3').click(function(e){
var id = $(this).data("id");
$("#youtbe3_edi-"+id).text('https://www.youtube.com/embed/UH-kf0mDTlc');
youtbe3 = $("#youtbe3_edi-"+id).text();
var iframe = '<iframe src="'+youtbe3+'" width="560" height="315" frameborder="0" allowfullscreen></iframe>';
$("#iframe_youtbe3_edi-"+id).html(iframe);
});


$('.reset_baaner_val1').click(function(e){
var id = $(this).data("id");
$("#edi_banner-"+id).text('http://www.games-shark.com/user/defaultbanner.png');
banner = 'http://www.games-shark.com/user/defaultbanner.png';
$("#edi_img-"+id).attr('src', banner).load(function() { });
e.stopPropagation();
});



$('.reset_live_val1').click(function(e){
var id = $(this).data("id");
$("#edi_Custom1-"+id).text('Custom1');
$("#edi_Val1-"+id).text('Val1');
custom1 = $("#edi_Custom1-"+id).text();
val1 = $("#edi_Val1-"+id).text();
e.stopPropagation();
});
$('.reset_live_val2').click(function(e){
var id = $(this).data("id");
$("#edi_Custom2-"+id).text('Custom2');
$("#edi_Val2-"+id).text('Val2');
custom2 = $("#edi_Custom2-"+id).text();
val2 = $("#edi_Val2-"+id).text();
e.stopPropagation();
});
$('.reset_live_val3').click(function(e){
var id = $(this).data("id");
$("#edi_Custom3-"+id).text('Custom3');
$("#edi_Val3-"+id).text('Val3');
custom3 = $("#edi_Custom3-"+id).text();
val3 = $("#edi_Val3-"+id).text();
e.stopPropagation();
});
$('.social_facebook_edi_live').focusout(function(e){
facebook = $(this).text().replace(regex2,"");
$(this).text(facebook);
e.stopPropagation();
});

$('.social_google_edi_live').focusout(function(e){
google = $(this).text().replace(regex2,"");
$(this).text(google);
e.stopPropagation();
});

$('.social_twitter_edi_live').focusout(function(e){
twitter = $(this).text().replace(regex2,"");
$(this).text(twitter);
e.stopPropagation();
});

$('.social_pingback_edi_live').focusout(function(e){
pingback = $(this).text().replace(regex2,"");
$(this).text(pingback);
e.stopPropagation();
});


$('.youtbe1_edi_live').focusout(function(e){
youtbe1 = addHttp($(this).text().replace(regex2,""));
$(this).text(youtbe1);
var iframe = '<iframe src="'+$(this).text()+'" width="560" height="315" frameborder="0" allowfullscreen></iframe>';
$("#iframe_youtbe1_edi-"+id).html(iframe);
e.stopPropagation();
});

$('.youtbe2_edi_live').focusout(function(e){
youtbe2 = addHttp($(this).text().replace(regex2,""));
$(this).text(youtbe2);
var iframe = '<iframe src="'+$(this).text()+'" width="560" height="315" frameborder="0" allowfullscreen></iframe>';
$("#iframe_youtbe2_edi-"+id).html(iframe);
e.stopPropagation();
});

$('.youtbe3_edi_live').focusout(function(e){
youtbe3 = addHttp($(this).text().replace(regex2,""));
$(this).text(youtbe2);
var iframe = '<iframe src="'+$(this).text()+'" width="560" height="315" frameborder="0" allowfullscreen></iframe>';
$("#iframe_youtbe3_edi-"+id).html(iframe);
e.stopPropagation();
});


$('.category_edi_live').change(function(e){
if($(this).val() != 0)
{
	category = $(this).val();
}
e.stopPropagation();
});

$('.flag_edi').change(function(e){
if($(this).val() != 0)
{
	flag = $(this).val();
}
$("#flag_img_edi-"+id).attr('src', '/images/flags/'+flag).load(function() { });
e.stopPropagation();
});

$('.flag_edi').change(function(e){
	flag = $(this).val();
$("#flag_img_edi-"+id).attr('src', '/images/flags/'+flag).load(function() { });
e.stopPropagation();
});

$('.banner_live_edi').focusout(function(e){
banner = addHttp($(this).text().replace(regex2,""));
$(this).text(banner);
$("#edi_img-"+id).attr('src', banner).load(function() { });
e.stopPropagation();
});

$('.link_live_edi').focusout(function(e){
link = addHttp($(this).text().replace(regex2,""));
$(this).text(link);
e.stopPropagation();
});


$('.title_live_edi').focusout(function(e){
var text_max = 60;
var text_length = $(this).text().length;
if(text_max <= text_length)
{
BootstrapDialog.alert("Your "+text_max+" characters for the title are exhausted!");
titlex = $(this).text().substring(0, text_max-1);
$(this).text(titlex);
}else{ 
titlex = $(this).text().replace(regex2,"");
$(this).text(titlex);
}
e.stopPropagation();
});

$('.text_live_edi').focusout(function(e){
var text_max = 600;
var text_length = $(this).text().length;
	if(text_max <= text_length)
	{
		BootstrapDialog.alert("Your "+text_max+" characters for the description are exhausted!");
		text = $(this).text().substring(0, text_max-1);
		$(this).text(text);
	}else{ 
		text = $(this).text().replace(regex2,"");
		$(this).text(text);
	}
e.stopPropagation();
});

$('.Custom1_edi').focusout(function(e){
var text_max = 30;
var text_length = $(this).text().length;
	if(text_max <= text_length)
	{
		BootstrapDialog.alert("Your "+text_max+" characters for the Custom-title 1 are exhausted!");
		custom1 = $(this).text().substring(0, text_max-1);
		$(this).text(custom1);
	}else{ 
		custom1 = $(this).text().replace(regex3,"");
		$(this).text(custom1);
	}
e.stopPropagation();
});

$('.Custom2_edi').focusout(function(e){
var text_max = 30;
var text_length = $(this).text().length;
	if(text_max <= text_length)
	{
		BootstrapDialog.alert("Your "+text_max+" characters for the Custom-title 2 are exhausted!");
		custom2 = $(this).text().substring(0, text_max-1);
		$(this).text(custom2);
	}else{ 
		custom2 = $(this).text().replace(regex3,"");
		$(this).text(custom2);
	}
e.stopPropagation();
});
$('.Custom3_edi').focusout(function(e){
var text_max = 30;
var text_length = $(this).text().length;
	if(text_max <= text_length)
	{
		BootstrapDialog.alert("Your "+text_max+" characters for the Custom-title 3 are exhausted!");
		custom3 = $(this).text().substring(0, text_max-1);
		$(this).text(custom3);
	}else{ 
		custom3 = $(this).text().replace(regex3,"");
		$(this).text(custom3);
	}
e.stopPropagation();
});

$('.Val1_edi').focusout(function(e){
var text_max = 30;
var text_length = $(this).text().length;
	if(text_max <= text_length)
	{
		BootstrapDialog.alert("Your "+text_max+" characters for the Custom-value 1 are exhausted!");
		val1 = $(this).text().substring(0, text_max-1);
		$(this).text(val1);
	}else{ 
		val1 = $(this).text().replace(regex3,"");
		$(this).text(val1);
	}
e.stopPropagation();
});

$('.Val2_edi').focusout(function(e){
var text_max = 30;
var text_length = $(this).text().length;
	if(text_max <= text_length)
	{
		BootstrapDialog.alert("Your "+text_max+" characters for the Custom-value 2 are exhausted!");
		val2 = $(this).text().substring(0, text_max-1);
		$(this).text(val2);
	}else{ 
		val2 = $(this).text().replace(regex3,"");
		$(this).text(val2);
	}
e.stopPropagation();
});

$('.Val3_edi').focusout(function(e){
var text_max = 30;
var text_length = $(this).text().length;
	if(text_max <= text_length)
	{
		BootstrapDialog.alert("Your "+text_max+" characters for the Custom-value 3 are exhausted!");
		val3 = $(this).text().substring(0, text_max-1);
		$(this).text(val3);
	}else{ 
		val3 = $(this).text().replace(regex3,"");
		$(this).text(val3);
	}
e.stopPropagation();
});
$('.save_site_live').click(function(e){
var youtbe = youtbe1+","+youtbe2+","+youtbe3;
siteCFtitle = custom1+","+custom2+","+custom3;
siteCFvalues = val1+","+val2+","+val3; 
$.ajax({
	type: "POST",
	url: "save.php",
	data: {
	id:id,
	title:titlex,
	link:link,
	text:text,
	banner:banner,
	flag:flag,
	siteCFtitle:siteCFtitle,
	siteCFvalues:siteCFvalues,
	category:category,
	facebook:facebook,
	twitter:twitter,
	google:google,
	youtbe:youtbe
	},
	success: function(html){
		if(html.search("has been saved"))
		{
			
			$("#edi_banner-"+id).hide();
			$("#edi_flag-"+id).hide();
			$("#edi_link-"+id).hide();
			$("#cat_edi-"+id).hide();
			$("#reset_baaner_val1-"+id).hide();
			$("#reset_live_val1-"+id).hide();
			$("#reset_live_val2-"+id).hide();
			$("#reset_live_val3-"+id).hide();
			if($("#social_state-"+id)[0].checked)
			{
				$("#social-live-edi-"+id).hide();
			}
			if($("#pingback_state-"+id)[0].checked)
			{
				$("#social-pingback-div-edi-"+id).hide();
				$("#social_pingback_edi-"+id).attr('class', '');
				$("#social_pingback_edi-"+id).prop("contentEditable", "false");	
			}			
			$("#edit_site_live-"+id).removeAttr('disabled');	
			$("#edi_savebtn-"+id).attr('disabled','disabled');
			$("#edi_title-"+id).attr('class', '');
			$("#edi_banner-"+id).attr('class', '');
			$("#edi_text-"+id).attr('class', '');
			$("#edi_Custom1-"+id).attr('class', '');
			$("#edi_Custom2-"+id).attr('class', '');
			$("#edi_Custom3-"+id).attr('class', '');
			$("#edi_Val1-"+id).attr('class', '');
			$("#edi_Val2-"+id).attr('class', '');
			$("#edi_Val3-"+id).attr('class', '');
			$("#edi_title-"+id).prop("contentEditable", "false");
			$("#edi_banner-"+id).prop("contentEditable", "false");
			$("#edi_text-"+id).prop("contentEditable", "false");
			$("#edi_Custom1-"+id).prop("contentEditable", "false");
			$("#edi_Custom2-"+id).prop("contentEditable", "false");
			$("#edi_Custom3-"+id).prop("contentEditable", "false");
			$("#edi_Val1-"+id).prop("contentEditable", "false");
			$("#edi_Val2-"+id).prop("contentEditable", "false");
			$("#edi_Val3-"+id).prop("contentEditable", "false");
			$("#edi_link-"+id).attr('class', '');
			$("#edi_link-"+id).prop("contentEditable", "false");
			$("#youtbe1_edi-"+id).attr('class', '');
			$("#youtbe1_edi-"+id).prop("contentEditable", "false");
			$("#youtbe2_edi-"+id).attr('class', '');
			$("#youtbe2_edi-"+id).prop("contentEditable", "false");
			$("#youtbe3_edi-"+id).attr('class', '');
			$("#youtbe3_edi-"+id).prop("contentEditable", "false");
			$("#social_facebook_edi-"+id).attr('class', '');
			$("#social_facebook_edi-"+id).prop("contentEditable", "false");
			$("#social_google_edi-"+id).attr('class', '');
			$("#social_google_edi-"+id).prop("contentEditable", "false");
			$("#social_twitter_edi-"+id).attr('class', '');
			$("#social_twitter_edi-"+id).prop("contentEditable", "false");			
		}
		BootstrapDialog.alert(html);
	}  
});
e.stopPropagation();
});



$('input[name="activateSite"]').on('switchChange.bootstrapSwitch', function(e, state) {
var id = $(this).data("id");
$.ajax({
	type: "POST",
	url: "UpdateSiteStatus.php",
	data: {
	idui:id
	},
	success: function(html){
		if(!html.search("has been saved"))
		{
			$("[name='activateSite']").toggle(this.checked);
		}
		BootstrapDialog.alert(html);
	}  
});
e.stopPropagation();

});



$('input[name="activatesocial_state"]').on('switchChange.bootstrapSwitch', function(e, state) {
var id = $(this).data("id");
$.ajax({
	type: "POST",
	url: "UpdateSiteSocial.php",
	data: {
	idui:id
	},
	success: function(html){
		if(!html.search("Your social status is"))
		{
			$("[name='activatesocial_state']").toggle(this.checked);
		}	
		var enabled = $("#edit_site_live-"+id).is(':disabled');
		if(enabled)
		{
			$("#social-live-edi-"+id).toggle();
		}		
		BootstrapDialog.alert(html);
	}  
});
e.stopPropagation();
});
$('input[name="pingback_state"]').on('switchChange.bootstrapSwitch', function(e, state) {
var id = $(this).data("id");
$.ajax({
	type: "POST",
	url: "UpdateSitepingback.php",
	data: {
	idui:id
	},
	success: function(html){
		if(!html.search("Your pingback status is"))
		{
			$("[name='pingback_state']").toggle(this.checked);
		}
		var enabled = $("#edit_site_live-"+id).is(':disabled');
		if(enabled)
		{
			$("#social-pingback-div-edi-"+id).toggle();
		}		
		BootstrapDialog.alert(html);
	}  
});
e.stopPropagation();
});

$('.save_pingback_btn').click(function(e){
var id = $(this).data("id");
var urlpingback = pingback;
$.ajax({
	type: "POST",
	url: "validate_pingback.php",
	data: {
	idui:id,
	url:urlpingback
	},
	success: function(html){
		BootstrapDialog.alert(html);
	}  
});
e.stopPropagation();
});

$('.get_site_live').click(function(e){
var id = $(this).data("id");
var code1 = '/* start games-shark.com */\n'+
'<a href="http://www.games-shark.com/v?i='+id+'" target="_BLANK" >\n'+
'<img src="http://www.games-shark.com/images/votebanner88x51.png" border="0" alt="Vote on Game-Shark.com"/>\n'+
'</a>\n'+
'/* end games-shark.com */';
var code2 = '/* start games-shark.com */\n'+
'<a href="http://www.games-shark.com/v?i='+id+'&c=$custom" target="_BLANK" >\n'+
'<img src="http://www.games-shark.com/images/votebanner88x51.png" border="0" alt="Vote on Game-Shark.com"/>\n'+
'</a>\n'+
'/* end games-shark.com */';
var code3 = '\n'+
'<a href="http://www.games-shark.com/v?i='+id+'" target="_BLANK" >\n'+
'<img src="http://www.games-shark.com/images/votebanner88x51.png" border="0" alt="Vote on Game-Shark.com"/>\n'+
'</a>\n'+
'';
var code4 = '\n'+
'<a href="http://www.games-shark.com/v?i='+id+'&c=$custom" target="_BLANK" >\n'+
'<img src="http://www.games-shark.com/images/votebanner88x51.png" border="0" alt="Vote on Game-Shark.com"/>\n'+
'</a>\n'+
'';
var code = $("[name='pingback_state']")[0].checked ?  code2:code1;
var codes = $("[name='pingback_state']")[0].checked ?  code4:code3;
var msig = $("[name='pingback_state']")[0].checked ?  "Don't Foreget ot change the <font color='red'>$custom</font> value to your user id.<br>Please view a php ping back example <a href='Ping-Back-Example'>HERE</a>":"";
BootstrapDialog.show({
	title: 'Your vote code for this site is:',
	message: $('<textarea style="font-size: 11px;" class="form-control" rows="7">'+code+'</textarea>'+msig+'<br>'+codes+''),
	buttons: [{
		label: 'Close',
		cssClass: 'btn-primary',
		hotkey: 13, // Enter.
		action: function(dialogRef) {
			 dialogRef.close();
		}
	}]
});


e.stopPropagation();
});




$(".del_site_live").click(function(){
var data = $(this).data("id");
BootstrapDialog.show({
	title: 'Question',
	message: 'Are you sure you want to delete this website?',
	buttons: [{
		label: 'Yes',
		hotkey: 13,
		action: function(dialog) {
		dialog.close();
		$.ajax({
			type: "POST",
			url: "DelSite.php",
			data: { idui:data},
			success: function(html){						
				BootstrapDialog.alert({
					title: 'Info',
					message: html,
					closable: true, 
					draggable: true, 
					buttonLabel: 'okay', 
					callback: function(result) {
						if (html.indexOf("website") >= 0)
						{			
							location.href = "index";
						}																			
					}
				});
			}  
		});	
		}
	}, {
		label: 'No',
		action: function(dialog) {
			dialog.close();
		}
	}]
});
});



});
$(document).on('focus', ':not(.tip)', function(){
    $('.tip').tooltip('hide');
});
$("[name='pingback_state']").bootstrapSwitch();
$("[name='activatesocial_state']").bootstrapSwitch();
$("[name='activateSite']").bootstrapSwitch();
$('.tip').tooltip();
$('[data-toggle="popover"]').popover(); 
</script>	
</body>

</html>
