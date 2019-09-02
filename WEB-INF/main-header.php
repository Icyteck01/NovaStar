<?php

error_reporting(E_ALL & ~E_NOTICE);

if(session_id() == '') {
    session_start();
}

print '
<header class="main-header">
<!-- Logo -->
<a href="/" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"><i class="fa fa-star"></i></span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg">'.strip_tags($CFG['softName']).'</span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	<span class="sr-only">Toggle navigation</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
	<ul class="nav navbar-nav">
	  <li>
		<a id="showHideDirectChat" href="#" ><i class="fa fa-comments"></i></a>
	  </li>	
	
	  <!-- Messages: style can be found in dropdown.less-->
	  <li class="dropdown messages-menu">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		  <i class="fa fa-envelope-o"></i>
		  '.($_SESSION['unreadMessages'] > 0 ? '<span class="label label-success unreadMessagesClassUpdate">'.($_SESSION['unreadMessages'] ? $_SESSION['unreadMessages']:0).'</span>':'<span class="label label-success unreadMessagesClassUpdate" style="display:none">'.($_SESSION['unreadMessages'] ? $_SESSION['unreadMessages']:0).'</span>').'
		</a>
		<ul class="dropdown-menu">
		  <li class="header">'.(str_replace('@',($_SESSION['unreadMessages'] ? $_SESSION['unreadMessages']:0),$CFG["Dashboard_21"])).'</li>
		  <li>
			<!-- inner menu: contains the actual data -->
			<ul class="menu">
			  ';
			  
			  if(isset($_SESSION['emails']))
				{
					$input = array("info", "warning", "success", "danger");
									
					$folders = $_SESSION['emails'];
					foreach($folders as $folder){
						$rand_keys = array_rand($input, 1);	
						if($folder['unread'])
						{
						print '
						  <li>
							<a href="Mailbox-Read-'.$folder["xuid"].'">
							  <div class="pull-left">
								<div style="font-size: 20px"><!-- pretend an enclosing class has big font size -->
									<span class="label label-'.$input[$rand_keys].' label-as-badge round">'.strtoupper($folder["from"][0]).'</span>
								</div>
							  </div>
							  <h4>
								'.$folder["from"].'
							  </h4>
							  <p>'.(strlen($folder["subject"]) >= 35 ? substr($folder["subject"],0,35).'...':$folder["subject"]).'</p>
							</a>
						  </li>
						';
						}
					}
					
				}	  
			  print'
			</ul>
		  </li>
		  <li class="footer"><a href="Mailbox">'.$CFG["Dashboard_20"].'</a></li>
		</ul>
	  </li>
	  <!-- Notifications: style can be found in dropdown.less -->
	  <li class="dropdown notifications-menu">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		  <i class="fa fa-bell-o"></i>
		  <span class="label label-warning">'.$_SESSION['allNotificationsCount'].'</span>
		</a>
		<ul class="dropdown-menu">
		  <li class="header">'.(str_replace('@',($_SESSION['allNotificationsCount'] ? $_SESSION['allNotificationsCount']:0),$CFG["Dashboard_22"])).'</li>
		  <li>
			<!-- inner menu: contains the actual data -->
			<ul class="menu">
				'.$_SESSION['allNotifications'].'
			</ul>
		  </li>
		</ul>
	  </li>
	  <!-- Tasks: style can be found in dropdown.less -->
	  <li class="dropdown tasks-menu">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		  <i class="fa fa-flag-o"></i>
		  <span class="label calendarUpdate label-danger">'.$_SESSION['allTasksCount'].'</span>
		</a>
		<ul class="dropdown-menu">
		  <li class="header">'.(str_replace('@',($_SESSION['allTasksCount'] ? $_SESSION['allTasksCount']:0),$CFG["Dashboard_23"])).'</li>
		  <li>
			<!-- inner menu: contains the actual data -->
			<ul class="menu">
				'.$_SESSION['allTasks'].'
			</ul>
		  </li>
		</ul>
	  </li>
	  <!-- User Account: style can be found in dropdown.less -->
	  <li class="dropdown user user-menu">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		  <img src="user_img/'.$_SESSION["image"].'" class="user-image userProfileImageToReplace" alt="">
		  <span class="hidden-xs">'.$_SESSION["name"].'</span>
		</a>
		<ul class="dropdown-menu">
		  <!-- User image -->
		  <li class="user-header">
			<img src="user_img/'.$_SESSION["image"].'" class="img-circle userProfileImageToReplace" alt="">
			<p>
			  '.$_SESSION["name"].'
			   <small>'.$_SESSION['jobTitle'].'</small>
			</p>
		  </li>
		  <!-- Menu Footer-->
		  <li class="user-footer">
			<div class="pull-left">
			  <a href="Profile" class="btn btn-default btn-flat">'.$CFG["Dashboard_25"].'</a>
			</div>
			<div class="pull-right">
			  <a href="logout" class="btn btn-default btn-flat">'.$CFG["Dashboard_24"].'</a>
			</div>
		  </li>
		</ul>
	  </li>
	  <!-- Control Sidebar Toggle Button -->
	  <li>
		<a href="Profile" ><i class="fa fa-gears"></i></a>
	  </li>
	</ul>
  </div>

</nav>
</header>';