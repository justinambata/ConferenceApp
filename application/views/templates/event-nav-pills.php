<?php
	$Event = $this->session->userdata('Event');
?>
<ul class="nav nav-pills">
	<li <?php echo ($content=='event/view') ? 'class="active"' : ''; ?>>
		<a href="<?php echo base_url()."event/view/".$Event['EventID']; ?>">
			<span class="glyphicon glyphicon-home"></span> Home
		</a>
	</li>
	<li <?php echo ($content=='event/about') ? 'class="active"' : ''; ?>>
		<a href="<?php echo base_url()."event/about/".$Event['EventID']; ?>">
			<span class="glyphicon glyphicon-star"></span> About
		</a>
	</li>
	<li <?php echo ($content=='session') ? 'class="active"' : ''; ?>>
		<a href="<?php echo base_url()."session/".$Event['EventID']; ?>">
			<span class="glyphicon glyphicon-calendar"></span> Schedule
		</a>
	</li>
	<li <?php echo ($content=='speaker') ? 'class="active"' : ''; ?>>
		<a href="<?php echo base_url()."speaker/".$Event['EventID']; ?>">
			<span class="glyphicon glyphicon-bullhorn"></span> Speakers
		</a>
	</li>
	<li <?php echo ($content=='user') ? 'class="active"' : ''; ?>>
		<a href="<?php echo base_url()."user/".$Event['EventID']; ?>">
			<span class="glyphicon glyphicon-user"></span> Attendees
		</a>
	</li>
	<li <?php echo ($content=='file') ? 'class="active"' : ''; ?>>
		<a href="<?php echo base_url()."file/".$Event['EventID']; ?>">
			<span class="glyphicon glyphicon-cloud-download"></span> Download
		</a>
	</li>
	<li <?php echo ($content=='evaluation') ? 'class="active"' : ''; ?>>
		<a href="<?php echo base_url()."evaluation/".$Event['EventID']; ?>">
			<span class="glyphicon glyphicon-pencil"></span> Evaluation
		</a>
	</li>
	<li <?php echo ($content=='alert') ? 'class="active"' : ''; ?>>
		<a href="<?php echo base_url()."alert/".$Event['EventID']; ?>">
			<span class="glyphicon glyphicon-bell"></span> Alerts
		</a>
	</li>
	<li <?php echo ($content=='event/info') ? 'class="active"' : ''; ?>>
		<a href="<?php echo base_url()."event/info/".$Event['EventID']; ?>">
			<span class="glyphicon glyphicon-info-sign"></span> Information
		</a>
	</li>
</ul>
<br />
<!-- CONTENT -->
<?php $this->load->view($content); ?>
<!--/ CONTENT -->