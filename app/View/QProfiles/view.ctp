<!DOCTYPE html>
<html>
	<head>
	<style>
		
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
			  <h1><?php echo $qprofile['QprofileJoin']['userName'];?></h1>
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
				?>
				<a>
			</td>
			<td style="background-color:#eeeeee;height:200px; width:300px;text-align:top;">
				<p><?php echo $qprofile['QprofileJoin']['firstName'];?></p>
				<p><?php echo $qprofile['QprofileJoin']['lastName'];?></p>
				<p><?php echo $qprofile['QprofileJoin']['emailAddress'];?></p>
				<p><?php echo $qprofile['QprofileJoin']['dateOfBirth'];?></p>
				<p><?php echo $qprofile['QprofileJoin']['phoneNumber'];?></p
				
					
					
								
				<p>
					<?php if($qprofile['QprofileJoin']['maleFemale'] == 0) { ?>
					male
					<?php }elseif ($Qgroup['QgroupJoin']['privatePublic'] == 1){  ?>
					female
					<?php } ?>
				</p>
				
				<p><?php echo $qprofile['QaddressJoin']['unit'];?></p>
				<p><?php echo $qprofile['QaddressJoin']['streetNumber'];?></p>
				<p><?php echo $qprofile['QaddressJoin']['streetName'];?></p>
				<p><?php echo $qprofile['QaddressJoin']['city'];?></p>
				<p><?php echo $qprofile['QaddressJoin']['stateProvince'];?></p>
				<p><?php echo $qprofile['QaddressJoin']['postalCode'];?></p>
				<p><?php echo $qprofile['QaddressJoin']['country'];?></p>
				</br>
				</br>
				<?php 
					echo $this->Html->link("EDIT", array('controller' => 'Qprofiles','action'=> 'edit', $qprofile['QprofileJoin']['profileID']), array( 'class' => 'signbutton'))
					/*echo $this->Html->link('Edit', array('action' => 'edit', $qprofile['QprofileJoin']['profileID']));*/
				?>
			</td>
		  </tr>
		</table>
	</div>
	</body>
</html>



