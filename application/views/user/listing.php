<!-- CodeIgniter + AngularJS -->
<?php
	$ngAttendees = "";
	foreach($attendees AS $attendee){
		$ngAttendees .= "{userid: '".$attendee['UserID']."', name:'".$attendee['FirstName']." ".$attendee['LastName']."', divisionname:'".$attendee['DivisionName']."', image:'".$attendee['Image']."'},"; 
	}
	$ngAttendees = rtrim($ngAttendees, ',');
?>
<div ng-init="attendees = [<?php echo $ngAttendees; ?>]">
</div>

<!-- CodeIgniter + AngularJS + Bootstrap -->
<div class="row">
	<div class="col-lg-12">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search attendees by name, or by division" ng-model="searchAttendees">
			<span class="input-group-btn">
				<button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span> Search</button>
			</span>
		</div><!-- /input-group -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="media" ng-repeat="attendee in attendees | filter:searchAttendees">
	<a class="pull-left" href="#">
		<div class="col-xs-4 col-md-4 col-md-3 col-lg-3">
			<a href="<?php echo base_url()."user/view/"; ?>{{attendee.userid}}" class="thumbnail" >
				<img ng-src="<?php echo base_url()."images/users/";?>{{attendee.image}}" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNDIiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjEyMSIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE1cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MjQyeDIwMDwvdGV4dD48L3N2Zz4=';" />
			</a>
		</div>
	</a>
	<div class="media-body">
		<h4 class="media-heading">{{attendee.name}}</h4>
		{{attendee.divisionname}}
	</div>
</div>