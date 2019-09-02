<?php
print '
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
	  <!-- Sidebar user panel -->
	  <div class="user-panel">
		<div class="pull-left image">
		  <img src="user_img/'.$_SESSION["image"].'" class="img-circle userProfileImageToReplace" alt="">
		</div>
		<div class="pull-left info">
		  <p>'.$_SESSION["name"].'</p>
		  <a ><i class="fa fa-circle text-success"></i> Online</a>
		</div>
	  </div>
	  <!-- search form 
	  <form action="#" method="get" class="sidebar-form">
		<div class="input-group">
		  <input type="text" name="q" class="form-control" placeholder="'.$CFG["Search"].'">
		  <span class="input-group-btn">
			<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
		  </span>
		</div>
	  </form>-->
	  <!-- /.search form -->
	  <!-- sidebar menu: : style can be found in sidebar.less -->
	  <ul class="sidebar-menu">
		<li class="header">'.$CFG["MAIN_NAVIGATION"].'</li>
		<li class="'.$active20.'"><a href="New-Agrement"><i class="fa fa-cc-amex"></i> <span>'.$CFG["NEWAGREEMENT"].'</span></a></li>	
		<li class="'.$active1.' treeview">
		  <a style="cursor:pointer;"><i class="fa fa-dashboard"></i> <span>'.$CFG["Dashboard"].'</span> <i class="fa fa-angle-left pull-right"></i></a>
		  <ul class="treeview-menu">';
			if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] >= 2)
			{	
				print'<li><a href="Statistics"><i class="fa '.$page1.'"></i> '.$CFG["STATISTICS"].'</a></li>';
				print'<li><a href="View-Users"><i class="fa '.$page9.'"></i> '.$CFG["VIEWUSERS"].'</a></li>';
				print'<li><a href="View-Contracts"><i class="fa '.$page8.'"></i> '.$CFG["VIEWAGREEMENTS"].'</a></li>';
			}
			print'
		  </ul>
		</li>
		<li class="'.$active2.' treeview">
		  <a style="cursor:pointer;">
			<i class="ion ion-model-s"></i>
			<span>'.$CFG["Car_Manager"].'</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="Rented"><i class="fa '.$page3.'"></i> '.$CFG["CarManager_2"].'</a></li>
			<li><a href="In-Transit"><i class="fa '.$page4.'"></i> '.$CFG["CarManager_8"].'</a></li>
			';
			if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] >= 2)
			{			
				print'<li><a href="In-Service"><i class="fa '.$page5.'"></i> '.$CFG["CarManager_10"].'</a></li>';
				if($_SESSION['privilege'] > 2)
				{
					print'<li><a href="Add-Car"><i class="fa '.$page6.'"></i> '.$CFG["Add_Car"].'</a></li>';
				}	
			}
			print'<li><a href="View-All"><i class="fa '.$page7.'"></i> '.$CFG["View_All_Cars"].'</a></li>';
			print'
		  </ul>
		</li>		
		<li class="'.$active3.'">
		  <a href="Calendar">
			<i class="fa fa-calendar"></i> <span>'.$CFG["Calendar"].'</span>
			<small class="label pull-right bg-red calendarUpdate">'.($_SESSION['calendarANDtaskCount'] == 0 ? "":$_SESSION['calendarANDtaskCount']).'</small>
		  </a>
		</li>
		<li class="'.$active4.'" style="'.($_SESSION['IMAPset'] == 0 ? 'display:none':'').'">
		  <a href="Mailbox">
			<i class="fa fa-envelope"></i> <span>'.$CFG["Mailbox"].'</span>
			'.($_SESSION['unreadMessages'] > 0 ? ' <small class="label pull-right label-success unreadMessagesClassUpdate">'.($_SESSION['unreadMessages'] ? $_SESSION['unreadMessages']:0).'</small>':' <small class="label pull-right label-success unreadMessagesClassUpdate" style="display:none">'.($_SESSION['unreadMessages'] ? $_SESSION['unreadMessages']:0).'</small>').'
		  </a>
		</li>
	  </ul>
	</section>
	<!-- /.sidebar -->
  </aside>';