<?php
	#usort by name
	function cmp($a, $b){
		$x = $a['LastName']." ".$a['FirstName'];
		$y = $b['LastName']." ".$b['FirstName'];
		if ($x == $y) {
			return 0;
		}
		return ($x < $y) ? -1 : 1;
	}
	
	if(isset($speakers)){
		usort($speakers, "cmp");
	}
?>

<!-- Session Details -->
<div class="bs-callout bs-callout-info">
	<h4><?php echo $session['SessionName']; ?></h4>
	<p>
		<?php echo date_format(date_create($session['StartDateTime']), 'F d, Y g:i A')." - ".date_format(date_create($session['EndDateTime']), 'F d, Y g:i A');?>
	</p>
	<p>
		<?php echo $session['Venue'];?>
	</p>
	<p>
		<?php
			if($session['WithConfirmation']==true){
				$bool = false;
				foreach($usersessions AS $usersession){
					if($usersession['SessionID'] == $session['SessionID']){
						$bool = true;
						break;
					}
				}
				
				echo form_open('usersession/update');
				echo '<input name="SessionID" type="hidden" value="'.$session['SessionID'].'" />';
				echo '<input name="RedirectPage" type="hidden" value="/session/view/'.$session['SessionID'].'" />';
				echo ($bool) ? '<button type="submit" name="submitRemove" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span></button> Remove from My Schedule' : '<button type="submit" name="submitInclude" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span></button> Include in My Schedule';
				echo form_close();
			}
		?>
	</p>
</div>

<!-- Speakers List -->
<?php if(isset($speakers)){ ?>
<div class="bs-callout bs-callout-info">
	<h4>Speakers</h4>
	<p>
		<?php foreach($speakers AS $speaker): ?>
		<div class="media">
			<a class="pull-left" href="#">
				<div class="col-sm-3 col-md-3">
					<a href="<?php echo base_url()."speaker/view/".$speaker['SpeakerID']; ?>" class="thumbnail" >
						<img ng-src="<?php echo base_url()."images/speakers/".$speaker['Image']; ?>" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNDIiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjEyMSIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE1cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MjQyeDIwMDwvdGV4dD48L3N2Zz4=';" />
					</a>
				</div>
			</a>
			<div class="media-body">
				<h4 class="media-heading"><?php echo $speaker['FirstName']." ".$speaker['LastName']; ?></h4>
				<?php echo $speaker['Position']; ?>
				<br />
				<?php echo $speaker['Company']; ?>
			</div>
		</div>
		<?php endforeach ?>
	</p>
</div>
<?php }else{ ?>
<?php } ?>

<!-- File Downloads -->
<div class="bs-callout bs-callout-info">
	<h4>Downloads</h4>
	<p>
		
	</p>
</div>

<!-- Evaluation -->
<div class="bs-callout bs-callout-info">
	<h4>Evaluation</h4>
	<p>
		
	</p>
</div>