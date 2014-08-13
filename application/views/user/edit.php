<?php
	$Settings = $this->session->userdata('Settings');
	$User = $this->session->userdata('User');
	
	$AuthorCompany = "";
	foreach($Settings as $setting){
		if($setting['Property'] == "AuthorCompany"){
			$AuthorCompany = $setting['Value'];
		}
	}
	
	if($field == "Password"){ #password
		$data = array(
			'type'			=> 'password',
			'name'			=> 'field',
			'class'			=> 'form-control',
			'placeholder'	=> ucfirst(strtolower($field)),
			'value'			=> $User[$field],
			'maxlength'		=> '45'
		);
	}else if(($field == "DivisionID")||($field == "DivisionName")){
		if($User['Company'] == $AuthorCompany){ #dropdown
			/*
			$options = array();
			foreach($divisions as $division){
				$options[$division['DivisionID']] = $division['DivisionName'];
			}
			*/
		}else{ #textbox
			$data = array(
				'type'			=> 'text',
				'name'			=> 'field',
				'class'			=> 'form-control',
				'placeholder'	=> ucfirst(strtolower($field)),
				'value'			=> $User[$field]
			);
		}
	}else{ #textbox
		$maxlength = ($field == "Password") ? '100' : '45';
		$data = array(
			'type'			=> 'text',
			'name'			=> 'field',
			'class'			=> 'form-control',
			'placeholder'	=> ucfirst(strtolower($field)),
			'value'			=> $User[$field],
			'maxlength'		=> $maxlength
		);
	}
?>
<?php
	$attributes = array('role' => 'form');
	echo form_open('user/update/'.$field, $attributes);
?>
	<?php
		if((($field == "DivisionID")||($field == "DivisionName"))&&($User['Company'] == $AuthorCompany)){
			//echo form_dropdown('DivisionID', $options, $User['DivisionID']);
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Division</h3>
		</div>
		<div class="panel-body">
			<?php foreach($divisions as $division): ?>
			<div class="row">
				<div class="col-lg-6">
					<div class="input-group">
						<span class="input-group-addon">
							<input type="radio" name="field" value="<?php echo $division['DivisionID']; ?>" <?php echo ($User['DivisionID'] == $division['DivisionID']) ? 'checked = "true"' : ''; ?>>
						</span>
						<input type="text" class="form-control" value="<?php echo $division['DivisionName']; ?>" readonly style="background-color: #fff;">
					</div><!-- /input-group -->
				</div><!-- /.col-lg-6 -->
			</div><!-- /.row -->
			<?php endforeach ?>
		</div>
	</div>
	<?php
		}else{
	?>
	<div class="input-group">
		<span class="input-group-addon"><?php echo $field; ?></span>
		<?php echo form_input($data); ?>
	</div>
	<br />
	<?php	
		}
	?>
	<div class="btn-group">
		<button type="submit" name="submitOK" class="btn btn-primary">Update</button>
		<button type="submit" name="submitCancel" class="btn btn-warning">Cancel</button>
	</div>
</form>