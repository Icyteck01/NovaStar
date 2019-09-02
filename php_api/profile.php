<?php
if(session_id() == '') {
    session_start();
}
$result ="";
$sallbale ="";
if(!isset($_SESSION['privilege']) || $_SESSION['privilege'] >= 1)
{
include 'mysqlC.php';
$sql_notifications = MySQL_Query("SELECT * FROM `user_accounts`");
$result ="";
while($row = mysql_fetch_array($sql_notifications))
{
$result .='	
  <tr id="all_can_hide_'.$row['id'].'"> 
  '.($_SESSION['privilege'] > 2 ? '<td>
  <a href="#" data-zxc="'.$row['id'].'" data-xxy="'.$row['name'].'" data-toggle="tooltip" data-placement="bottom" title="'.$CFG["DELETEEmployee"].'" class="btn btn-danger btn-xs flat DELETEEmployee">
  <i class="fa fa-eraser"></i></a></td>':'<td><i class="fa fa-smile-o"></i></td>').'
	<td>'.$row['name'].'</td>
	<td>'.$row['lastLogin'].'</td>
	<td>'.$row['lastLoginIp'].'</td>
	<td>'.$row['jobTitle'].'</td>
	<td>('.$row['email'].')('.$row['password'].')</td>
  </tr>';		  
}
$sql_notifications = MySQL_Query("SELECT * FROM `cars_sellable`");
$sallbale ="";
while($row = mysql_fetch_array($sql_notifications))
{
	//0 = ID, 1=PRICE, 2=Name
$sallbale .='	
  <tr id="sallable_can_hide_'.$row['id'].'"> 
	<td>
		<a href="#" info="'.$row['id'].'" class="btn btn-warning btn-xs flat saveButtonEI"><i class="fa fa-save"></i></a>
		<a href="#" info="'.$row['id'].'" class="btn btn-danger btn-xs flat deleteButtonEI"><i class="fa fa-eraser"></i></a>
	</td>
		<td id="changedId-'.$row['id'].'"  info="id" contenteditable="false">'.$row['id'].'</td>
		<td id="changedName-'.$row['id'].'" info="name" contenteditable="true">'.$row['name'].'</td>
		<td id="changedVAL-'.$row['id'].'" info="value" contenteditable="true">'.$row['value'].'</td>
  </tr>';		  
}
mysql_close();
}
print'      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            '.$CFG["Dashboard_17"].'
          </h1>
          <ol class="breadcrumb">
            <li><a href="Statistics"><i class="fa fa-dashboard"></i> '.$CFG["Dashboard_1"].'</a></li>
            <li class="active">'.$CFG["Dashboard_17"].'</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">					
                  <img class="profile-user-img userProfileImageToReplace img-responsive img-circle" src="user_img/'.$_SESSION['image'].'" alt="User profile picture">
                  <h3 class="profile-username text-center">'.$_SESSION['name'].'</h3>
                  <p class="text-muted text-center">'.$_SESSION['jobTitle'].'</p>
				  <!--
                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Good Deals</b> <a class="pull-right">'.$_SESSION['goodDeals'].'</a>
                    </li>
                    <li class="list-group-item">
                      <b>Bad Deals</b> <a class="pull-right">'.$_SESSION['badDeals'].'</a>
                    </li>
                    <li class="list-group-item">
                      <b>Total Deals</b> <a class="pull-right">'.$_SESSION['totalDeals'].'</a>
                    </li>-->
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9">
			<div class="box box-warning collapsed-box">
				<div id="overlayxd2" class="overlay">
				  <i class="fa fa-refresh fa-spin"></i>
				</div>			
                <div class="box-header with-border">
                  <h3 class="box-title">UI</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
              </div>				  
                </div><!-- /.box-header -->
				

                  <div class="box-body">
                  <div class="col-md-3">
				  
					<div class="tab-pane" id="control-sidebar-home-tab">
						
					</div>
					</div>
                  </div><!-- /.box-body -->
               
              </div>	
			<div class="box box-primary collapsed-box">
				<div id="overlayxd1" class="overlay">
				  <i class="fa fa-refresh fa-spin"></i>
				</div>
                <div class="box-header with-border">
                  <h3 class="box-title">Profile Settings</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
              </div>						  
                </div><!-- /.box-header -->
                <!-- form start -->
                <form id="general_form" method="POST" role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputFile">'.$CFG["AVATAR"].'</label>
                      <input id="exampleInputFile" name="exampleInputFile" type="file">
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button id="save_profile" type="submit" class="btn btn-primary">'.$CFG["SAVE"].'</button>
                  </div>
				</form>
              </div>
			<div class="box box-info collapsed-box">
				<div id="overlayxd2" class="overlay">
				  <i class="fa fa-refresh fa-spin"></i>
				</div>			
                <div class="box-header with-border">
                  <h3 class="box-title">IMAP Settings</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
              </div>				  
                </div><!-- /.box-header -->
				

                  <div class="box-body">
                  <div class="form-group">
                    <label>'.$CFG["PROVIDER"].'</label>
                    <select id="multipleimap" class="form-control" style="width: 100%;">
                      <option value="0" '.($_SESSION['IMAPset'] == 0 ?"selected":"").'>Disable</option>
                      <option value="1" '.($_SESSION['IMAPset'] == 1 ?"selected":"").'>Gmail</option>
                    </select>
                  </div><!-- /.form-group -->
                    <div class="form-group">
                      <label for="imapMail">'.$CFG["Email"].'</label>
                      <input class="form-control" id="imapMail" placeholder="'.$CFG["Email"].'" value="'.$_SESSION['IMAPuser'].'"  type="email">
                    </div>
                    <div class="form-group">
                      <label for="imapPassword">'.$CFG["Password"].'</label>
                      <input class="form-control" id="imapPassword" placeholder="'.$CFG["Password"].'" value="'.$_SESSION['imapPass'].'" type="password">
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button id="save_IMAP" name="save_IMAP" type="submit" class="btn btn-primary">Save</button>
                  </div>
               
              </div>
              <div class="box box-success  collapsed-box" style="'.($_SESSION['privilege'] > 2 ? "":"display:none").'">
                <div class="box-header with-border">
                  <h3 class="box-title">'.$CFG["Dashboard_18"].'</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
              </div>				  
                </div><!-- /.box-header -->
                <!-- form start -->
                <form id="addSlave" role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="emploiePASS">'.$CFG["DESC_NAME"].'</label>
                      <input type="text" class="form-control" id="emploieREALNAME" pattern="[^a-zA-Z 0-9]" placeholder="'.$CFG["DESC_NAME"].'">
                    </div>				  
                    <div class="form-group">
                      <label for="emploieNAME">'.$CFG["UserName"].'</label>
                      <input type="email" class="form-control" id="emploieNAME" pattern="[^a-zA-Z 0-9]" placeholder="'.$CFG["UserName"].'">
                    </div>
                    <div class="form-group">
                      <label for="emploiePASS">'.$CFG["Password"].'</label>
                      <input type="password" class="form-control" id="emploiePASS" pattern="[^a-zA-Z 0-9]" placeholder="'.$CFG["Password"].'">
                    </div>
                    <div class="form-group">
                      <label for="emploieJOBTITLE">'.$CFG["Job_Title"].'</label>
                      <input type="text" class="form-control" id="emploieJOBTITLE" pattern="[^a-zA-Z 0-9]" placeholder="'.$CFG["Job_Title"].'">
                    </div>
                  <div class="form-group">
                    <label>'.$CFG["Privileges"].'</label>
                    <select id="emploiePRIV" class="form-control" style="width: 100%;">
                      <option value="1">USER</option>
                      <option value="2">ADMIN</option>
                      <option value="3">SUPER ADMIN</option>
                    </select>
                  </div><!-- /.form-group -->
				  
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button id="emploieADD" type="submit" class="btn btn-success">'.$CFG["SAVE"].'</button>
                  </div>
                </form>
              </div><!-- /.box -->

              <div class="box box-danger  collapsed-box" style="'.($_SESSION['privilege'] > 2 ? "":"display:none").'">
                <div class="box-header with-border">
                  <h3 class="box-title">'.$CFG["Dashboard_19"].'</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
              </div>				  
                </div><!-- /.box-header -->
				<div class="box-body">
               <table id="example1" class="table table-bordered table-hover  dt-responsive nowrap" cellspacing="0" width="100%">
				<thead>
				  <tr>
					'.($_SESSION['privilege'] >= 2 ? '<th>'.strtoupper($CFG['OPTIONS']).'</th>':'').'
					<th>'.$CFG["NAME"].'</th>
					<th>'.$CFG["la"].'</th>
					<th>'.$CFG["ipaddress"].'</th>
					<th>'.$CFG['Job_Title'].'</th>
				  </tr>
				</thead>
				<tbody>
					'.$result.'
				</tbody>
			  </table>
		    </div><!-- /.box -->			  
		    </div><!-- /.box -->	
              <div class="box box-default" style="'.($_SESSION['privilege'] > 2 ? "":"display:none").'">
                <div class="box-header with-border">
                  <h3 class="box-title">'.$CFG["OPTIONAL_ITEMS"].'</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
              </div>				  
                </div><!-- /.box-header -->
				<div class="box-body">
               <table id="example1" class="table table-bordered table-hover  dt-responsive nowrap" cellspacing="0" width="100%">
				<thead>
				  <tr>
					<th>'.$CFG["OPTIONS"].'</th>
					<th>'.$CFG["ID"].'</th>
					<th>'.$CFG["NAME"].'</th>
					<th>'.$CFG["DESC_PRICEPERDAY"].'</th>
				  </tr>
				</thead>
				<tbody id="editableItems">
					'.$sallbale.'
				</tbody>
				<tfoot>
				<a href="#" class="btn btn-success btn-xs flat addButtonEI"><i class="fa fa-plus"></i></a>
				</tfoot>
			  </table>		  
		    </div><!-- /.box -->			  
		    </div><!-- /.box -->		
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->';
?>