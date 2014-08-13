<?php foreach($alerts AS $alert): ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo date_format(date_create($alert['Timestamp']), 'F d, Y g:i:s A');?></h3>
		</div>
		<div class="panel-body">
			<?php echo $alert['Message']; ?>
		</div>
	</div>
<?php endforeach ?>