<!-- CodeIgniter + AngularJS -->
<?php
	$ngFiles = "";
	if(isset($files)){
		foreach($sessions AS $session){
			foreach($files AS $file){
				# 1:1 session-file ratio
				if($session['SessionID'] == $file['SessionID']){
					if($session['IsFileDownloadable']){
						$ngFiles .= "{sessionid: '".$session['SessionID']."', sessionname: '".str_replace("'","\'",$session['SessionName'])."', fileid: '".$file['FileID']."', filename: '".str_replace("'","\'",$file['Filename'])."'},";
					}
					break;
				}
			}
		}
	}
	$ngFiles = rtrim($ngFiles, ',');
?>
<div ng-init="files = [<?php echo $ngFiles; ?>]">
</div>

<!-- CodeIgniter + AngularJS + Bootstrap -->

<?php if((isset($files))&&(count($files) != 0)){ ?>
<div class="row">
	<div class="col-lg-12">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search files by filename, or by session name" ng-model="searchFiles">
			<span class="input-group-btn">
				<button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span> Search</button>
			</span>
		</div><!-- /input-group -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<br />
<?php }else{ ?>
<div class="jumbotron">
	<p>
		There are no files available for download as of the moment. Please check back again soon.
	</p>
</div>
<?php } ?>

<div class="panel panel-default" ng-repeat="file in files | filter:searchFiles">
	<div class="panel-heading">
		<h3 class="panel-title">
			<a href="<?php echo base_url()."session/view/"; ?>{{file.sessionid}}" class="btn-block">{{file.sessionname}}</a>
		</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td >
					{{file.filename}}
				</td>
				<td align="right">
					<?php
						echo form_open('file/download');
					?>
						<input name="FileID" type="hidden" value="{{file.fileid}}" />
						<input name="RedirectPage" type="hidden" value="<?php echo "/file/listing/".$this->session->userdata('CurrentEventID');?>" />
						<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-download"></span></button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>