<?php
	$CurrentEventID = $this->session->userdata('CurrentEventID');
	$User = $this->session->userdata('User');
	
	$ngPosts = "";
	if(isset($posts)){
		foreach($posts AS $post){
			$glyphicon = ($post['To'] == -1) ? "globe" : (($post['To'] == 0) ? "lock" : "cog");
			$privacy = ($post['To'] == -1) ? "Public" : (($post['To'] == 0) ? "Private" : "Specific Session");
			
			if(($User['UserID'] == $post['UserID'])||($post['To'] == -1)){
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
	
	$ngPosts = rtrim($ngPosts, ',');
	
	
	if($event['SessionID_Active'] == -1){
		#event offline
	}else if($event['SessionID_Active'] == 0){
		#breakout sessions
	}else{
?>
<div class="jumbotron">
	<h1>Session ongoing...</h1>
	<p>
		<code><span class="glyphicon glyphicon-calendar"></span> <?php echo $session['SessionName']?></code>
		at
		<code><span class="glyphicon glyphicon-map-marker"></span> <?php echo $session['Venue']?></code>
	</p>
	<p>
		<a class="btn btn-primary btn-lg" href= "<?php echo base_url()."session/view/".$event['SessionID_Active']; ?>" role="button">Go to current session</a>
	</p>
</div>
<?php
	}
?>

<?php
	$attributes = array('id' => 'writePostForm', 'name'=>'writePostForm');
	echo form_open('post/write', $attributes);
?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Write Post
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<div class="input-group">
						<input type="text" id="Text" name="Text" class="form-control" placeholder="Share what's new" maxlength="500">
						<input type="hidden" id="To" name="To">
						<input type="hidden" id="RedirectPage" name="RedirectPage" value="<?php echo "/event/view/".$CurrentEventID; ?>">
						<div id="write_post_div" class="input-group-btn">
							<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
								Post to <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a onclick="$('#To').val('-1'); $('#writePostForm').submit()"><span class="glyphicon glyphicon-globe"></span> Public</a></li>
								<li><a onclick="$('#To').val('0'); $('#writePostForm').submit()"><span class="glyphicon glyphicon-lock"></span> Private</a></li>
								<li class="divider"></li>
								<li><a href="#"><span class="glyphicon glyphicon-cog"></span> To a specific session</a></li>
							</ul>
						</div><!-- /btn-group -->
					</div><!-- /input-group -->
				</div><!-- /.col-lg-6 -->
			</div><!-- /.row -->
		</div>
	</div>
<?php echo form_close(); ?>

<!-- ALL USER'S PUBLIC POSTS, IF USER==SIGNED IN USER, DISPLAY ALL POSTS -->
<?php if(strlen($ngPosts) > 0){?>
	<div ng-init="posts = [<?php echo $ngPosts; ?>]">
	</div>
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
		<?php
			$attributes = array('id' => 'writeCommentForm', 'name'=>'writeCommentForm');
			echo form_open('comment/write', $attributes);
		?>
		<div class="row">
			<div class="col-lg-12">
				<div class="input-group">
					<input type="text" id="Text" name="Text" class="form-control" placeholder="Write a comment" maxlength="500">
					<input type="hidden" id="PostID" name="PostID" value="{{post.postid}}">
					<input type="hidden" id="RedirectPage" name="RedirectPage" value="<?php echo "/event/view/".$CurrentEventID; ?>">
					<span class="input-group-btn">
						<button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-comment"></span></button>
					</span>
				</div><!-- /input-group -->
			</div><!-- /.col-lg-12 -->
		</div><!-- /.row -->
		<?php echo form_close(); ?>
	</div>
</div>
<?php } ?>