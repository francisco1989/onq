<!--
 *  Project : OnQ
 *  File : target.ctp
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 17, 2014
 *  Description : target.ctp allows an administrator to target demographics for an advertisement
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
<h1>Target Demographics</h1>
<div class="container-fluid" style="border-style:solid; border-width:1px">
	<?php
		echo $this->Form->create('Qadvertisement', array('action' => 'target'));
		echo $this->Form->input('advertisementID', array('type' => 'hidden')); 
	?>
	<table class="table-responsive" style="overflow: auto;">
		<tr>
			<td>
				<div style="margin:0px">Location</div>
				<!--<?php echo $this->Form->checkbox('locationCheckBox', array('value'=>1,'checked'=>false,'hiddenField'=>false)); ?>-->
			</td>
			<td>
				<div class="container-fluid" style="border-style:solid; border-width:1px;">
					Before Text
					</br>
					<?php //echo $this->Form->textarea('location'); ?>
					</br>
					After Text
				</div>
			</td>
		</tr>
		<tr>
			<td>
				Age <?php echo $this->Form->checkbox('locationCheckBox', array('value'=>1,'checked'=>false,'hiddenField'=>false)); ?>
			</td>
			<td>
				<div class="container-fluid" style="border-style:solid; border-width:1px">
					Before Text
					</br>
					<?php //echo $this->Form->textarea('location'); ?>
					</br>
					After Text
				</div>
			</td>
		</tr>
		<tr>
			<td>
				Email Domain <?php echo $this->Form->checkbox('locationCheckBox', array('value'=>1,'checked'=>false,'hiddenField'=>false)); ?>
			</td>
			<td>
				<div class="container-fluid" style="border-style:solid; border-width:1px">
					Before Text
					</br>
					<?php //echo $this->Form->textarea('location'); ?>
					</br>
					After Text
				</div>
			</td>
		</tr>
		<tr>
			<td>
				Gender <?php echo $this->Form->checkbox('locationCheckBox', array('value'=>1,'checked'=>false,'hiddenField'=>false)); ?>
			</td>
			<td>
				<div class="container-fluid" style="border-style:solid; border-width:1px">
					Before Text
					</br>
					<?php //echo $this->Form->textarea('location'); ?>
					</br>
					After Text
				</div>
			</td>
		</tr>
		<tr>
			<td>
				Active Users <?php echo $this->Form->checkbox('locationCheckBox', array('value'=>1,'checked'=>false,'hiddenField'=>false)); ?>
			</td>
			<td>
				<div class="container-fluid" style="border-style:solid; border-width:1px">
					Before Text
					</br>
					<?php //echo $this->Form->textarea('location'); ?>
					</br>
					After Text
				</div>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->submit('Save Advertisement Targets'); ?>
	<?php echo $this->Form->end();?>
</div>
<br />
<br />
<?php
	echo $this->Html->link(
		'Back to Advertisements',
		array('action' => 'index'),
		array( 'class' => 'signbutton')
	);
?>