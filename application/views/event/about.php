<div class="row">
	<div class="col-sm-6 col-md-6">
		<div class="thumbnail">
			<?php
				$imgloc = "images/events/".$event['EventID']."/".$event['Image'];
				if(file_exists($imgloc)){
			?>
				<img src="<?php echo base_url().$imgloc;?>" alt="...">
			<?php
				}else{
			?>
				<img data-src="holder.js/100%x200" alt="...">
			<?php
				}
			?>
		</div>
	</div>
</div>
<div class="panel panel-info">
	<div class="panel-heading">When</div>
	<div class="panel-body">
		<?php echo date_format(date_create($event['StartDate']), 'F d, Y')." - ".date_format(date_create($event['EndDate']), 'F d, Y');?>
	</div>
</div>
<p align="justify">
	<?php echo nl2br($event['Summary']); ?>
</p>