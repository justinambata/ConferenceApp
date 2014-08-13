<?php
	$CurrentEventID = $this->session->userdata('CurrentEventID');
	
	#BAD PRACTICE! Accessing the model through the view.
	$condition = array(
		'EventID'	=> $CurrentEventID
	);
	$tempAlerts = $this->ConferenceApp_model->getAlerts($condition);
?>
<div class="row row-offcanvas row-offcanvas-left">
	<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
		<div class="list-group">
			<a href="<?php echo base_url()."event/view/".$CurrentEventID; ?>" class="list-group-item <?php echo ($content=="event/view") ? "active" : ""; ?>"><span class="glyphicon glyphicon-home"></span> Home</a>
			<a href="<?php echo base_url()."event/about/".$CurrentEventID; ?>" class="list-group-item <?php echo ($content=="event/about") ? "active" : ""; ?>"><span class="glyphicon glyphicon-star"></span> About</a>
			<a href="<?php echo base_url()."session/listing/".$CurrentEventID; ?>" class="list-group-item <?php echo (($content=="session/listing")||($content=="session/view")) ? "active" : ""; ?>"><span class="glyphicon glyphicon-calendar"></span> Full Schedule</a>
			<a href="<?php echo base_url()."usersession/listing/".$CurrentEventID; ?>" class="list-group-item <?php echo ($content=="usersession/listing") ? "active" : ""; ?>"><span class="glyphicon glyphicon-pushpin"></span> My Schedule</a>
			<a href="<?php echo base_url()."speaker/listing/".$CurrentEventID; ?>" class="list-group-item <?php echo ($content=="speaker/listing") ? "active" : ""; ?>"><span class="glyphicon glyphicon-bullhorn"></span> Speakers</a>
			<a href="<?php echo base_url()."user/listing/".$CurrentEventID; ?>" class="list-group-item <?php echo (($content=="user/listing")||($content=="user/view")) ? "active" : ""; ?>"><span class="glyphicon glyphicon-user"></span> Attendees</a>
			<a href="#" class="list-group-item"><span class="glyphicon glyphicon-stats"></span> Statistics</a>
			<a href="<?php echo base_url()."file/listing/".$CurrentEventID; ?>" class="list-group-item <?php echo ($content=="file/listing") ? "active" : ""; ?>"><span class="glyphicon glyphicon-cloud-download"></span> Download</a>
			<a href="<?php echo base_url()."evaluation/listing/".$CurrentEventID; ?>" class="list-group-item <?php echo ($content=="evaluation/listing") ? "active" : ""; ?>"><span class="glyphicon glyphicon-pencil"></span> Evaluation</a>
			<a href="<?php echo base_url()."alert/listing/".$CurrentEventID; ?>" class="list-group-item <?php echo ($content=="alert/listing") ? "active" : ""; ?>"><span class="glyphicon glyphicon-bell"></span> Alerts <span class="badge"><?php echo count($tempAlerts); ?></span></a>
			<a href="<?php echo base_url()."event/info/".$CurrentEventID; ?>" class="list-group-item <?php echo ($content=="event/info") ? "active" : ""; ?>"><span class="glyphicon glyphicon-info-sign"></span> Helpful Information</a>
		</div>
	</div><!--/span-->
	<div class="col-xs-12 col-sm-9">
		<p class="pull-left visible-xs">
			<button type="button" class="btn btn-lg btn-primary" data-toggle="offcanvas">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</button>
		</p>
		<div class="offcanvas-offset">
			<br />
			<br />
			<br />
		</div>
		<!-- CONTENT -->
		<?php $this->load->view($content); ?>
		<!--/ CONTENT -->
	</div><!--/span-->
</div>