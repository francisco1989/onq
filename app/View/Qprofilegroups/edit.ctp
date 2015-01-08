<!-- File: /app/View/QAdvertisments/edit.ctp -->
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
		
<h1>Edit Group</h1>
<?php
echo $this->Form->create('Qgroup');
echo $this->Form->input('groupID', array('type' => 'hidden'));
echo $this->Form->input('groupType',array('class' => 'form-control'));
echo $this->Form->input('groupTitle',array('class' => 'form-control'));
echo $this->Form->input('groupDescription',array('class' => 'form-control'));
echo $this->Form->input('Qgroup.privatePublic', array(
						'options' => array('0' => 'private','1' => 'public')
					));
echo $this->Form->end('Save Group');
?>