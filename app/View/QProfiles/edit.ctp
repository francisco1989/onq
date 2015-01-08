<!DOCTYPE html>
<html>
	<head>
	<style>
		
		#header{
		position:relative;
		top: -20px;
		width: 100%;
		padding: 60px;
		background: url('../../img/logo.png') left top no-repeat, linear-gradient(rgba(4,95,248,1), rgba(3,17,95,1));
	}
	
	</style>
		<div class="loginform">
			<h2>
			<?php 
				echo "Welcome ";
				echo AuthComponent::user('userName');
				echo "!";
				echo $this->Session->flash('auth'); 
				echo $this->Form->create('Logout'); 
			?>
			</h2>
				<div style="width: 100%; display: table;">
					<div style="display: table-row">
						<div style="width: 90px; display: table-cell;">
							<?php 
								echo $this->Html->link("LOGOUT", array('controller' => 'Qprofiles','action'=> 'logout'), array( 'class' => 'signbutton'))
							?>
						</div>
					</div>
				</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</head>
	<body>
	<div class="myTable" >
		<table>
		  <tr>
			<td colspan="2" >
				<h1><?php echo $this->Form->create('Qprofile',
								array('type' => 'file',
									array('action' => 'edit', 'id' => $this->request->data['QprofileJoin']['profileID'])
								));
						echo $qprofile['QprofileJoin']['userName'];
					?>
				</h1>
			</td>
		  </tr>
		  <tr valign="top">
			<td style="background-color:#8daff6; height: 100px; width: 10px;position: relative;text-align:left;">
			  <b><font color="blue">Profile Picture</font></b><br />
			  <a class="img">
			  <?php
					$image = file_get_contents($qprofile['QprofileJoin']['profilePic']); //File path from DB
					$pathInPieces = explode('/', $qprofile['QprofileJoin']['profilePic']); //Break path
					$fileName = $pathInPieces[count($pathInPieces)-1]; //Grab file name + extension
					header('Content-Type: image/*');
					echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" alt="'.$fileName.'"eight="200px", width="200px", h>';
					
					echo $this->Form->input('QprofileJoin.profilePic', array('id'=>'picture','type'=>'file','name'=>'picture','accept'=>'image/*'));
				?>
				<a>
			</td>
			<td style="background-color:#eeeeee;height:200px; width:300px;text-align:top;">
				<p><?php echo $this->Form->input('QprofileJoin.profileID', array('type' => 'hidden'));?></p>
				<p><?php echo $this->Form->input('QprofileJoin.addressID', array('type' => 'hidden'));?></p>
				<p><?php echo $this->Form->input('QprofileJoin.firstName');?></p>
				<p><?php echo $this->Form->input('QprofileJoin.lastName');?></p>
				<p><?php echo $this->Form->input('QprofileJoin.emailAddress');?></p>
				<p><?php echo $this->Form->input('QprofileJoin.phoneNumber');?></p>
				
				<p><?php echo $this->Form->input('QaddressJoin.unit');?></p>
				<p><?php echo $this->Form->input('QaddressJoin.streetNumber');?></p>
				<p><?php echo $this->Form->input('QaddressJoin.streetName');?></p>
				<p><?php echo $this->Form->input('QaddressJoin.city');?></p>
				<p><?php echo $this->Form->input('QaddressJoin.stateProvince');?></p>
				<p><?php echo $this->Form->input('QaddressJoin.postalCode');?></p>
				<p><?php echo $this->Form->input('QaddressJoin.country');?></p>
				
				<p><?php echo $this->Form->submit('SAVE', array( 'name' => 'submit1'),array( 'class' => 'signbutton'));?></p>
				<?php echo $this->Form->end(); ?>
				<br />
				<br />
					<?php
						echo $this->Html->link(
							'Back to Profile Page', array('action' => 'view'),array( 'class' => 'signbutton')
						);
					?>
			</td>
		  </tr>
		</table>
	</div>
		
	</body>
</html>


