<?php
	$User = $this->session->userdata('User');
	$Settings = $this->session->userdata('Settings');
	$CurrentEventID = $this->session->userdata('CurrentEventID');
	
	$AlertStatus = $this->session->flashdata('AlertStatus');
	
	$AppName = "";
	foreach($Settings as $setting){
		if($setting['Property'] == "AppName"){
			$AppName = $setting['Value'];
		}
	}
?>
<!DOCTYPE html>
<html lang="en" ng-app><!-- ng-app: AngularJS -->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Justin V. Ambata">
		<link rel="icon" href="<?php echo base_url()."images/favicon.ico";?>">
		
		<title><?php echo $title." | ".$AppName ?></title>
		
		<!-- Bootstrap core CSS -->
		<link href="<?php echo base_url()."bootstrap/css/bootstrap.min.css";?>" rel="stylesheet">
		<link href="<?php echo base_url()."css/main.css";?>" rel="stylesheet">
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo base_url()."event/listing";?>"><span class="glyphicon glyphicon-home"></span> <?php echo $AppName; ?></a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<?php if($CurrentEventID){ ?>
						<li class="active"><a href="<?php echo base_url()."event/view/".$CurrentEventID;?>"><?php echo $title ?></a></li>
						<?php }else{ ?>
						<li class="active"><a href=""><?php echo $title ?></a></li>
						<?php } ?>
					</ul>
					
					<?php
						if(!($User['UserID'])){
							$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
							//echo validation_errors();
							echo form_open('user/signin', $attributes);
					?>
					<!--<form class="navbar-form navbar-right" role="form">-->
						<div class="form-group">
							<input type="text" name="Email" placeholder="Email" class="form-control">
							<?php //echo form_input(array("type"=>"text","placeholder"=>"Email","class"=>"form-control")); ?>
						</div>
						<div class="form-group">
							<input type="password" name="Password" placeholder="Password" class="form-control">
						</div>
						<button type="submit" class="btn btn-success">Sign in</button>
					</form>
					<?php
						}else{
							$attributes = array('class' => 'navbar-form', 'role'=>'form');
					?>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<?php echo form_open('user/view/'.$User['UserID'], $attributes); ?>
								<button type="submit" class="btn btn-info">
									<span class="glyphicon glyphicon-user"></span> <?php echo $User['FirstName']." ".$User['LastName'];?>
								</button>
							</form>
						</li>
						<li>
							<?php echo form_open('user/signout', $attributes); ?>
								<button type="submit" class="btn btn-danger">Sign out</button>
							</form>
						</li>
					</ul>
					<?php
						}
					?>
				</div><!--/.navbar-collapse -->
			</div>
		</div>
		<!-- Alert Message -->
		<div>
		<?php
			if($AlertStatus){
				if($AlertStatus == "Sign in unsuccessful"){
		?>
		<div class="alert alert-danger" role="alert">
			<strong><?php echo $AlertStatus;?>.</strong> <?php echo $this->session->flashdata('AlertMessage');?>
		</div>
		<?php
				}else if($AlertStatus == "Sign out successful"){
		?>
		<div class="alert alert-success" role="alert">
			<strong><?php echo $this->session->flashdata('AlertMessage');?></strong>
		</div>
		<?php
				}else{
		?>
			<div class="alert alert-<?php echo $AlertStatus; ?> alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<strong><?php echo $this->session->flashdata('AlertMessage');?></strong>
			</div>
		<?php
				}
			}
		?>
		</div>
		<!--/ Alert Message -->
		<div class="container">
			<div class="page-header">
				<h1><?php echo $title ?></h1>
			</div>