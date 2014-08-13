<?php foreach ($events as $event):?>
	<div class="media">
		<a class="pull-left" href="#">
			<div class="col-sm-6 col-md-4">
				<a href="<?php echo base_url()."event/view/".$event['EventID']; ?>" class="thumbnail">
					<?php
						$imgloc = "images/events/".$event['EventID']."/".$event['Image'];
						if(file_exists($imgloc)){
					?>
						<img src="<?php echo base_url().$imgloc;?>" alt="...">
					<?php
						}else{
					?>
						<img data-src="holder.js/100%x200" alt="100%x200" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNDIiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjEyMSIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE1cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MjQyeDIwMDwvdGV4dD48L3N2Zz4=" style="height: 200px; width: 100%; display: block;">
					<?php
						}
					?>
				</a>
			</div>
		</a>
		<div class="media-body">
			<h4 class="media-heading"><?php echo $event['EventName']; ?></h4>
			<?php echo date_format(date_create($event['StartDate']), 'F d, Y')." - ".date_format(date_create($event['EndDate']), 'F d, Y');?>
			<br />
			<?php echo $event['Venue'];?>
		</div>
	</div>
<?php endforeach ?>