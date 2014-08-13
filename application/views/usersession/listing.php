<!-- CodeIgniter + AngularJS -->
<?php
	$ngSessions = "";
	foreach($sessions AS $session){
		foreach($usersessions AS $usersession){
			if($session['SessionID'] == $usersession['SessionID']){
				$ngSessions .= "{sessionid: '".$session['SessionID']."', sessionname: '".str_replace("'","\'",$session['SessionName'])."', startdatetime: '".date_format(date_create($session['StartDateTime']), 'F d, Y g:i A')."', enddatetime: '".date_format(date_create($session['EndDateTime']), 'F d, Y g:i A')."', venue: '".str_replace("'","\'",$session['Venue'])."', maxcapacity: '".$session['MaxCapacity']."', withconfirmation: '".$session['WithConfirmation']."', sessiontypeid: '".$session['SessionTypeID']."'},";
				break;
			}
		}
	}
	$ngSessions = rtrim($ngSessions, ',');
?>
<div ng-init="sessions = [<?php echo $ngSessions; ?>]">
</div>

<!-- CodeIgniter + AngularJS + Bootstrap -->
<?php if(count($sessions) != 0){ ?>
<div class="row">
	<div class="col-lg-12">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search sessions by title, date, or venue" ng-model="searchSessions">
			<span class="input-group-btn">
				<button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span> Search</button>
			</span>
		</div><!-- /input-group -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->

<!-- Hint -->
<div class="bs-callout bs-callout-info">
	<h4>Hint:</h4>
	<p>
		To view the session details, <code>click</code> on the session name.
	</p>
	<p>
		<button class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span></button>
		Remove from My Schedule
	</p>
</div>
<?php }else{ ?>
<div class="jumbotron">
	<p>
		There are no sessions as of the moment. Please check back again soon.
	</p>
</div>
<?php } ?>

<div class="panel panel-default" ng-repeat="session in sessions | filter:searchSessions">
	<div class="panel-heading">
		<h3 class="panel-title">
			<a href="<?php echo base_url()."session/view/"; ?>{{session.sessionid}}" class="btn-block">{{session.sessionname}}</a>
		</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					{{session.startdatetime}} - {{session.enddatetime}}
					<br />
					{{session.venue}}
				</td>
				<td align="right">
					<?php
						echo form_open('usersession/update');
					?>
						<input name="SessionID" type="hidden" value="{{session.sessionid}}" />
						<input name="RedirectPage" type="hidden" value="/usersession/listing/<?php echo $this->session->userdata('CurrentEventID');?>" />
						<div ng-switch="session.withconfirmation">
							<div ng-switch-when="1">
								<button type="submit" name="submitRemove" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span></button>
							</div>
							<div ng-switch-default="">
							</div>
						</div>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>