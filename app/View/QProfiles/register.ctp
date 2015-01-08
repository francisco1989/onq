<!-- app/View/Users/add.ctp -->
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
		<h1>
			<div class="loginform">
			<h2>
				<?php 
					if($role == "admin" || $role == "user")
					{
						echo "Welcome ";
						echo AuthComponent::user('userName');
						echo "!";
						echo $this->Session->flash('auth'); 
						echo $this->Form->create('Logout'); 
					}
				?>
				</h2>
					<div style="width: 100%; display: table;">
						<div style="display: table-row">
							<div style="width: 90px; display: table-cell;">
								<?php 
									if($role == "admin" || $role == "user")
									{
										echo $this->Html->link("LOGOUT", array('controller' => 'Qprofiles','action'=> 'logout'), array( 'class' => 'signbutton'));
									}
								?>
							</div>
						</div>
					</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</h1>
		<?php
			echo $this->Html->script(array('jquery','jquery-ui'));
			echo $this->Html->css('jquery-ui.css');
		?>
		<script>
			$(function() {
				   $("#datepicker").datepicker();
			});
		</script>
	</head>
	<body>
		<div class="myTable" >
			<table>
			  <tr>
				<td colspan="2" >
				  <h1><?php echo "Sign Up";?></h1>
				</td>
			  </tr>
			    <tr valign="top">
					<div class="users form" >
						<td style="background-color:#eeeeee;height:200px; width:300px;text-align:top;">
							<?php echo $this->Form->create('Qprofile', array('type'=>'file')); ?>
							<fieldset>
								<p><?php echo $this->Form->input('userName');?></p>
								<p><?php echo $this->Form->input('password');?></p>
								<p><?php echo $this->Form->input('firstName');?></p>
								<p><?php echo $this->Form->input('lastName');?></p>
								<p><?php echo $this->Form->input('emailAddress');?></p>
								<p><?php echo $this->Form->input('phoneNumber');?></p>
								
								<p><?php echo $this->Form->input('Qaddress.unit');?></p>
								<p><?php echo $this->Form->input('Qaddress.streetNumber');?></p>
								<p><?php echo $this->Form->input('Qaddress.streetName');?></p>
								<p><?php echo $this->Form->input('Qaddress.city');?></p>
								<p><?php echo $this->Form->input('Qaddress.stateProvince');?></p>
								<p><?php echo $this->Form->input('Qaddress.postalCode');?></p>
								<p><?php echo $this->Form->input('Qaddress.country');?></p>
								<p><?php echo $this->Form->input('maleFemale', array('label'=>'Gender','options' => array('0' => 'male','1' => 'female')));?></p>
						
								<p><?php echo $this->Form->input('dateOfBirth', array('id'=>'datepicker','type'=>'text','name'=>'datepicker'));?></p>
						
								<p><?php echo $this->Form->input('profilePic', array('required'=>false,'id'=>'profilePic','name'=>'profilePic', 'type'=>'file', 'accept'=>'image/*'));?></p>
								<?php 
								if($role == "admin")
								{
									echo $this->Form->input('role', array('options' => array('admin' => 'Admin', 'user' => 'General User')));
								}
								else
								{
									echo $this->Form->input('role', array('options' => array('user' => 'General User')));
								}
								?>
							</fieldset>
							
							<?php echo $this->Form->end(__('REGISTER')); ?>
						</td>
						
					</div>
				</tr>
			</table>
		</div>
		
	</body>
</html>