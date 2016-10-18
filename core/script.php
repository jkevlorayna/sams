    <script src="<?php echo $path; ?>js/theme/jquery.min.js"></script>
	<script src="<?php echo $path; ?>js/moment.js"></script> 
	<script src="<?php echo $path; ?>js/angular.min.js"></script> 
	<script src="<?php echo $path; ?>js/angular-ui-router.js"></script> 

	<script src="<?php echo $path; ?>js/angular-cookies.js"></script> 
	<script src="<?php echo $path; ?>js/ui-bootstrap-tpls-1.3.2.js"></script> 
	<script src="<?php echo $path; ?>js/angular-animate.js"></script> 
	<script src="<?php echo $path; ?>js/checklist-model.js"></script> 
	<script src="<?php echo $path; ?>js/angular-app.js"></script>  
	<script src="<?php echo $path; ?>js/select.js"></script>  
	<script src="<?php echo $path; ?>js/angular-growl.js"></script> 
	<script src="<?php echo $path; ?>js/angular-sanitize.min.js"></script>  
	<script src="<?php echo $path; ?>js/angular-io-barcode.js"></script>  
	
	<!-- controller -->
		<?php foreach (glob($path."js/controller/angular-controller*.js") as $filename) { ?>
				<script src="<?php echo $filename; ?>"></script>
		<?php } ?>
	<!-- controller -->
	<!-- service -->
		<?php foreach (glob($path."js/service/angular-service*.js") as $filename) { ?>
			<script src="<?php echo $filename; ?>"></script>
		<?php } ?>
	<!-- end service -->	
	
	<script src="<?php echo $path; ?>js/angular-directive.js"></script> 	
		
		
  <script src="<?php echo $path; ?>js/theme/jquery.cookie/jquery.cookie.js"></script>
  <script src="<?php echo $path; ?>js/theme/jquery.pushmenu/js/jPushMenu.js"></script>
  <script src="<?php echo $path; ?>js/theme/jquery.nanoscroller/jquery.nanoscroller.js"></script>
  <script src="<?php echo $path; ?>js/theme/jquery.sparkline/jquery.sparkline.min.js"></script>
  <script src="<?php echo $path; ?>js/theme/jquery.ui/jquery-ui.js" ></script>
  <script src="<?php echo $path; ?>js/theme/jquery.gritter/js/jquery.gritter.js"></script>
  <script src="<?php echo $path; ?>js/theme/behaviour/core.js"></script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

  <script src="<?php echo $path; ?>js/theme/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?php echo $path; ?>js/theme/jasny.bootstrap/extend/js/jasny-bootstrap.min.js"></script>
  <script src="<?php echo $path; ?>js/theme/behaviour/dashboard.js"></script>
  <script src="<?php echo $path; ?>js/theme/jquery.datatables/jquery.datatables.min.js"></script>
  <script src="<?php echo $path; ?>js/theme/jquery.datatables/js/datatables.js"></script>
  <script src="<?php echo $path; ?>js/theme/jquery.gritter/js/jquery.gritter.js"></script>
  <script src="<?php echo $path; ?>js/theme/bootstrap.multiselect/js/bootstrap-multiselect.js"></script>
  <script src="<?php echo $path; ?>js/theme/jquery.multiselect/js/jquery.multi-select.js"></script>
  <script src="<?php echo $path; ?>js/theme/datepicker/js/bootstrap-datepicker.js"></script>

