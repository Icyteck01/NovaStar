     <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> <?php print $CFG['VERSION']; ?>
        </div>
        <strong>Copyright &copy; 2016 <a href="http://www.games-shark.com/">Games Shark</a>.</strong> All rights reserved.
      </footer>
    </div><!-- ./wrapper -->

	
	
	
<div class="box box-info direct-chat direct-chat-warning center-pane">
<div class="box-header with-border">
  <h3 class="box-title"><?php print $CFG["Dashboard_37"];?></h3>
  <div class="box-tools pull-right">
	<button id="showHideDirectChat2" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
  </div>
</div><!-- /.box-header -->
<div class="box-body">
  <!-- Conversations are loaded here -->
  <div id="direct-chat-messages" class="direct-chat-messages">


  </div><!-- /.box-body -->
<div class="box-footer">
  <form action="#" method="post">
	<div class="input-group">
	  <input type="text" id="directChatInputMsg" placeholder="<?php print $CFG["Dashboard_36"];?>" class="form-control">
	  <span class="input-group-btn">
		<button id="directChatSendInputMsg" type="button" class="btn btn-warning btn-flat"><?php print $CFG["SEND"];?></button>
	  </span>
	</div>
  </form>
</div><!-- /.box-footer-->
</div><!--/.direct-chat -->
</div><!--/.direct-chat -->
	
	
	
	
	
	
	
	
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="dist/js/bootbox.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <script src="dist/js/app.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js"></script>
	<!-- rangeSlider 1.0.1 -->
	<script src="plugins/ion.rangeSlider-2.1.2/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
	<script src="dist/js/gauge.js"></script>
    <!-- NovaStar for demo purposes -->
    <script src="dist/js/demo.js"></script>
	<script src="dist/js/fakeLoader.js"></script>
	 <!-- <script src="dist/js/jquery-ui.min.js"></script>-->
    <script src="WEB-INF/java.js"></script>
    
	<?php print $script; ?>
  </body>
</html>