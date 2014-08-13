<?php
	$Settings = $this->session->userdata('Settings');
	$User = $this->session->userdata('User');
	
	$AuthorCompany = "";
	foreach($Settings as $setting){
		if($setting['Property'] == "AuthorCompany"){
			$AuthorCompany = $setting['Value'];
		}
	}
?>
<div class="media">
	<a class="pull-left" href="#">
		<div class="col-xs-4 col-md-4 col-md-3 col-lg-3">
			<a href="#" class="thumbnail">
			<?php
				$imgloc = "images/users/".$User['Image'];
				if(file_exists($imgloc)){
			?>
				<img src="<?php echo base_url().$imgloc;?>" alt="...">
			<?php
				}else{
			?>
				<img data-src="holder.js/100%x175" alt="100%x175" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNDIiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjEyMSIgeT0iMTAwIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjE1cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MjQyeDIwMDwvdGV4dD48L3N2Zz4=" style="height: 175px; width: 100%; display: block;">
			<?php
				}
			?>
			</a>
		</div>
	</a>
	<div class="media-body">
		<button type="submit" class="btn btn-primary">Change Profile Picture</button>
	</div>
</div>
<br />
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Email</h3>
	</div>
	<div class="panel-body">
		<?php echo $User['Email']; ?>
		<!--<table width="100%">
			<tr>
				<td>
					<?php //echo $User['Email']; ?>
				</td>
				<td align="right">
					<button type="submit" class="btn btn-primary">Update</button>
				</td>
			</tr>
		</table>-->
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Password</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php
						//echo $User['Password'];
						for($i=0; $i<8; $i++){
							echo "&#9679;";
						}
					?>
				</td>
				<td align="right">
					<?php
						$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
						echo form_open('user/edit/Password', $attributes);
					?>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Firstname</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php echo $User['FirstName']; ?>
				</td>
				<td align="right">
					<?php
						$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
						echo form_open('user/edit/FirstName', $attributes);
					?>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Lastname</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php echo $User['LastName']; ?>
				</td>
				<td align="right">
					<?php
						$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
						echo form_open('user/edit/LastName', $attributes);
					?>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Position</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php echo $User['Position']; ?>
				</td>
				<td align="right">
					<?php
						$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
						echo form_open('user/edit/Position', $attributes);
					?>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="panel panel-default" hidden>
	<div class="panel-heading">
		<h3 class="panel-title">DivisionID</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php echo $User['DivisionID']; ?>
				</td>
				<td align="right">
					<?php
						$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
						echo form_open('user/edit/DivisionID', $attributes);
					?>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Division</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php echo $User['DivisionName']; ?>
				</td>
				<td align="right">
					<?php
						$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
						echo form_open('user/edit/DivisionName', $attributes);
					?>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Company</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php echo $User['Company']; ?>
				</td>
				<td align="right">
					<?php
						if($User['Company'] != $AuthorCompany){
							$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
							echo form_open('user/edit/Company', $attributes);
							echo '<button type="submit" class="btn btn-primary">Update</button>';
							echo form_close();
						}
					?>
						<!--<button type="submit" class="btn btn-primary">Update</button>-->
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Phone 1</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php echo $User['Phone1']; ?>
				</td>
				<td align="right">
					<?php
						$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
						echo form_open('user/edit/Phone1', $attributes);
					?>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Phone 2</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php echo $User['Phone2']; ?>
				</td>
				<td align="right">
					<?php
						$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
						echo form_open('user/edit/Phone2', $attributes);
					?>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Bio</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php echo $User['Bio']; ?>
				</td>
				<td align="right">
					<?php
						$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
						echo form_open('user/edit/Bio', $attributes);
					?>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Employee ID</h3>
	</div>
	<div class="panel-body">
		<table width="100%">
			<tr>
				<td>
					<?php echo $User['EmployeeID']; ?>
				</td>
				<td align="right">
					<?php
						$attributes = array('class' => 'navbar-form navbar-right', 'role'=>'form');
						echo form_open('user/edit/EmployeeID', $attributes);
					?>
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>