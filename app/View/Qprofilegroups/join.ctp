<!-- app/View/Qprofiles/add.ctp -->
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
		
<div class="Qgroup form">
<?php echo $this->Form->create('Qprofilegroup'); ?>
    <fieldset>
        <legend><?php echo __('Join a Group'); ?></legend>
        <?php 
		echo $this->Form->input('code',array('class' => 'form-control'));
		?>
    </fieldset>
<?php echo $this->Form->end(__('join')); ?>
</div>