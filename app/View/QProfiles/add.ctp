<!-- app/View/Qprofiles/add.ctp -->
<!DOCTYPE html>
<html>
	<head>
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
					  <h1><?php echo "Add User";?></h1>
					</td>
				</tr>
				<tr valign="top">
					<div class="users form">
						<td style="background-color:#eeeeee;height:200px; width:300px;text-align:top;">
							<?php echo $this->Form->create('Qprofile', array('type'=>'file')); ?>
								<fieldset>
									<p><?php echo $this->Form->input('userName');?></p>
									<p><?php echo $this->Form->input('password');?></p>
									<p><?php echo $this->Form->input('emailAddress');?></p>
									<p><?php echo $this->Form->input('role', array('options' => array('admin' => 'Admin', 'user' => 'General User')));?></p>
								
								</fieldset>
							<?php echo $this->Form->end(__('ADD')); ?>
						</td>
					</div>
				</tr>
			</table>
		</div>
	</body>
</html>