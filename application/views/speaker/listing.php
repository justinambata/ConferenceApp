<!-- CodeIgniter + AngularJS -->
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
<?php	
	$ngSpeakers = "";
	if(isset($speakers)){
		foreach($speakers AS $speaker){
			$ngSpeakers .= "{speakerid: '".$speaker['SpeakerID']."', name:'".$speaker['FirstName']." ".$speaker['LastName']."', position:'".str_replace("'","\'",$speaker['Position'])."', company:'".str_replace("'","\'",$speaker['Company'])."', image:'".$speaker['Image']."'},"; 
		}
	}
	$ngSpeakers = rtrim($ngSpeakers, ',');
?>
<div ng-init="speakers = [<?php echo $ngSpeakers; ?>]">
</div>

<!-- CodeIgniter + AngularJS + Bootstrap -->
<?php if(isset($speakers)){ ?>
<div class="row">
	<div class="col-lg-12">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search speakers by name, position, or company" ng-model="searchSpeakers">
			<span class="input-group-btn">
				<button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span> Search</button>
			</span>
		</div><!-- /input-group -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php }else{ ?>
<div class="jumbotron">
	<p>
		There are no speakers as of the moment. Please check back again soon.
	</p>
</div>
<?php } ?>
<div class="media" ng-repeat="speaker in speakers | filter:searchSpeakers">
	<a class="pull-left" href="#">
		<div class="col-xs-4 col-md-4 col-md-3 col-lg-3">
			<a href="<?php echo base_url()."speaker/view/"; ?>{{speaker.speakerid}}" class="thumbnail" >
				<img ng-src="<?php echo base_url()."images/speakers/";?>{{speaker.image}}" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNDIiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjEyMSIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE1cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MjQyeDIwMDwvdGV4dD48L3N2Zz4=';" />
			</a>
		</div>
	</a>
	<div class="media-body">
		<h4 class="media-heading">{{speaker.name}}</h4>
		{{speaker.position}}
		<br />
		{{speaker.company}}
		<!--
		<ul class="list-group">
			<li class="list-group-item list-group-item-info">{{speaker.position}}</li>
			<li class="list-group-item list-group-item-info">{{speaker.company}}</li>
		</ul>
		<div class="bs-callout bs-callout-info">
			<p>
				{{speaker.position}}
			</p>
		</div>
		<div class="bs-callout bs-callout-info">
			<p>
				{{speaker.company}}
			</p>
		</div>
		<div class="well well-sm">{{speaker.position}}</div>
		<div class="well well-sm">{{speaker.company}}</div>
		-->
	</div>
</div>