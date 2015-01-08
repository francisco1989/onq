<!--
 *  Project : OnQ
 *  File : add.ctp
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 17, 2014
 *  Description : add.ctp allows the user to upload a new advertisement
 -->

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
	</h1>
</head>
<h1>Add Advertisement</h1>

<?php
	echo $this->Form->create('Qadvertisement', array('action' => 'add', 'type' => 'file'));
	//Restricts the users input to image file types
	echo $this->Form->input('Advertisement', array('id'=>'advertisement','name'=>'advertisement', 'type'=>'file', 'accept'=>'image/*'));
	echo $this->Form->submit('Save Advertisement');
	echo $this->Form->end();
?>