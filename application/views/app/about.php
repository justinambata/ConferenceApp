<?php
	$Settings = $this->session->userdata('Settings');
	
	$AppName = "";
	$Version = -1;
	foreach($Settings as $setting){
		if($setting['Property'] == "AppName"){
			$AppName = $setting['Value'];
		}else if($setting['Property'] == "Version"){
			$Version = $setting['Value'];
		}
	}
?>
<div class="bs-callout bs-callout-info">
	<h4>Version <?php echo $Version; ?></h4>
	<p>
		What's new in version <code><?php echo $Version; ?></code>?
	</p>
	<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam venenatis felis nec nisl malesuada, eu posuere nisi imperdiet. Ut feugiat dui neque, et sodales arcu accumsan at. Pellentesque ac cursus sapien. Sed lorem urna, blandit vitae ultrices ac, varius id augue. Proin elementum magna lectus, id luctus arcu bibendum congue. Ut feugiat sed quam eget semper. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec lobortis sollicitudin justo ac luctus. In neque libero, rutrum in sem sit amet, feugiat rhoncus ligula. Sed sit amet neque nec nisi porttitor convallis. Nulla facilisi.
	</p>
</div>
<div class="bs-callout bs-callout-warning">
	<h4>Our Team</h4>
	<p>
		Get to know the team behind the <code><?php echo $AppName; ?></code>!
	</p>
	<div class="row">
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
				<img data-src="holder.js/100%x175" alt="...">
				<div class="caption">
					<h3>Thumbnail label</h3>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
				<img data-src="holder.js/100%x175" alt="...">
				<div class="caption">
					<h3>Thumbnail label</h3>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
				<img data-src="holder.js/100%x175" alt="...">
				<div class="caption">
					<h3>Thumbnail label</h3>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
				<img data-src="holder.js/100%x175" alt="...">
				<div class="caption">
					<h3>Thumbnail label</h3>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
				<img data-src="holder.js/100%x175" alt="...">
				<div class="caption">
					<h3>Thumbnail label</h3>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
				<img data-src="holder.js/100%x175" alt="...">
				<div class="caption">
					<h3>Thumbnail label</h3>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
				<img data-src="holder.js/100%x175" alt="...">
				<div class="caption">
					<h3>Thumbnail label</h3>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
				<img data-src="holder.js/100%x175" alt="...">
				<div class="caption">
					<h3>Thumbnail label</h3>
					<p>...</p>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
				<img data-src="holder.js/100%x175" alt="...">
				<div class="caption">
					<h3>Thumbnail label</h3>
					<p>...</p>
				</div>
			</div>
		</div>
	</div>
</div>