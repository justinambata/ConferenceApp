<?php
	$User = $this->session->userdata('User');
	
	$ngPosts = "";
	if(isset($posts)){
		foreach($posts AS $post){
			if($post['UserID'] == $user['UserID']){
				$glyphicon = ($post['To'] == -1) ? "globe" : (($post['To'] == 0) ? "lock" : "cog");
				$privacy = ($post['To'] == -1) ? "Public" : (($post['To'] == 0) ? "Private" : "Specific Session");
				
				if(($User['UserID'] == $user['UserID'])||($post['To'] == -1)){
					#get all signed-in user's posts, or get all user's public posts only
					$ngPosts .= "{postid: '".$post['PostID']."', userid: '".$post['UserID']."', eventid: '".$post['EventID']."', to: '".$post['To']."', text: '".str_replace("'","\'",$post['Text'])."', timestamp: '".date_format(date_create($post['Timestamp']), 'F d, Y g:i A')."', displaytospeaker: '".$post['DisplayToSpeaker']."', username: '".$post['UserName']."', userimage: '".$post['UserImage']."', glyphicon: '".$glyphicon."', privacy: '".$privacy."'";
					
					$ngComments = ", comments: [";
					foreach($comments AS $comment){
						if($comment['PostID'] == $post['PostID']){
							$ngComments .= "{commentid: '".$comment['CommentID']."', userid: '".$comment['UserID']."', postid: '".$comment['PostID']."', text: '".$comment['Text']."', timestamp: '".$comment['Timestamp']."', username: '".$comment['UserName']."', userimage: '".$comment['UserImage']."'},";
						}
					}
					$ngComments = rtrim($ngComments, ',');
					$ngComments .= "]";
					
					$ngPosts .= $ngComments."},";
				}
			}
		}
	}
	
	$ngPosts = rtrim($ngPosts, ',');
?>
<!-- CodeIgniter + AngularJS -->
<div class="bs-callout bs-callout-info">
	<h4><?php echo $user['FirstName']." ".$user['LastName']?>'s Profile</h4>
	<p>
		<div class="media">
			<a class="pull-left" href="#">
				<div class="col-xs-4 col-md-4 col-md-3 col-lg-3">
					<a href="<?php echo base_url()."user/view/".$user['UserID']; ?>" class="thumbnail" >
						<img ng-src="<?php echo base_url()."images/users/".$user['Image'];?>" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNDIiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjEyMSIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE1cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MjQyeDIwMDwvdGV4dD48L3N2Zz4=';" />
					</a>
				</div>
			</a>
			<div class="media-body">
				<?php #echo $user['Position']."<br />".$user['DivisionName']."<br />".$user['Company']."<br />".$user['Phone1']; ?>
				<table class="table">
					<tr>
						<td>
							Position:
						</td>
						<td>
							<?php echo $user['Position']; ?>
						</td>
					</tr>
					<tr>
						<td>
							Division:
						</td>
						<td>
							<?php echo $user['DivisionName']; ?>
						</td>
					</tr>
					<tr>
						<td>
							Company:
						</td>
						<td>
							<?php echo $user['Company']; ?>
						</td>
					</tr>
					<tr>
						<td>
							Phone 1:
						</td>
						<td>
							<?php echo $user['Phone1']; ?>
						</td>
					</tr>
					<tr>
						<td>
							Phone 2:
						</td>
						<td>
							<?php echo $user['Phone2']; ?>
						</td>
					</tr>
					<tr>
						<td>
							Bio:
						</td>
						<td>
							<?php echo $user['Bio']; ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</p>
	<?php if($post['UserID'] == $user['UserID']){ ?>
	<p>
		<table width="100%">
			<tr>
				<td align="right">
					<?php echo form_open('user/details'.$user['UserID']);?>
							<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Update my profile</button>
					</form>
				</td>
			</tr>
		</table>
	</p>
	<?php } ?>
</div>

<!-- OTHER USER DETAILS -->

<!-- ALL USER'S PUBLIC POSTS, IF USER==SIGNED IN USER, DISPLAY ALL POSTS -->
<?php if(strlen($ngPosts) > 0){?>
	<div ng-init="posts = [<?php echo $ngPosts; ?>]">
	</div>
	<div class="bs-callout bs-callout-default">
		<h4><?php echo $user['FirstName']." ".$user['LastName']?>'s Posts</h4>
		<p>
			<div class="panel panel-default ng-scope" ng-repeat="post in posts">
				<!-- POST -->
				<!--
				<div class="panel-heading">
				</div>
				-->
				<div class="panel-body ng-binding">
					<div class="media">
						<a class="pull-left" href="#">
							<div class="col-xs-3 col-md-3 col-md-2 col-lg-2">
								<a href="<?php echo base_url()."user/view/"; ?>{{post.userid}}" class="thumbnail" >
									<img ng-src="<?php echo base_url()."images/users/";?>{{post.userimage}}" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNDIiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjEyMSIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE1cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MjQyeDIwMDwvdGV4dD48L3N2Zz4=';" />
								</a>
							</div>
						</a>
						<div class="media-body ng-binding">
							<h4 class="media-heading ng-binding">{{post.username}}</h4>
							<span class="label label-default">{{post.timestamp}}</span> &middot; <span class="label label-default"><span class="glyphicon glyphicon-{{post.glyphicon}}"></span>  {{post.privacy}}</span>
							<div class="bs-callout bs-callout-info">
								<p>{{post.text}}</p>
							</div>
						</div>
					</div>
				</div>
				<!--\ POST -->
				<div class="panel-footer">
					<b>Comments</b>
					<!-- COMMENTS ON POST -->
					<div class="media" ng-repeat="comments in post.comments">
						<a class="pull-left" href="#">
							<div class="col-xs-2 col-md-2 col-md-1 col-lg-1">
								<a href="<?php echo base_url()."user/view/"; ?>{{comments.userid}}" class="thumbnail" >
									<img ng-src="<?php echo base_url()."images/users/";?>{{comments.userimage}}" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNDIiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjEyMSIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE1cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MjQyeDIwMDwvdGV4dD48L3N2Zz4=';" />
								</a>
							</div>
						</a>
						<div class="media-body ng-binding">
							<b>{{comments.username}}</b>
							<br />
							{{comments.text}}
						</div>
					</div>
					<!--\ COMMENTS ON POST -->
					<div class="row">
						<div class="col-lg-12">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Write a comment" maxlength="500">
								<span class="input-group-btn">
									<button class="btn btn-success" type="button"><span class="glyphicon glyphicon-comment"></span></button>
								</span>
							</div><!-- /input-group -->
						</div><!-- /.col-lg-12 -->
					</div><!-- /.row -->
				</div>
			</div>
		</p>
	</div>

	<!--
	<div class="panel panel-default" ng-repeat="post in posts">
		<div class="panel-heading">
			<h4 class="media-heading">{{post.username}}</h4>
			{{post.timestamp}}
		</div>
		<div class="panel-body">
			{{post.text}}
		</div>
	</div>
	-->
<?php } ?>