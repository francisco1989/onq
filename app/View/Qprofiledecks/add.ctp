
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
		
<h1>Add Deck</h1>
<?php echo $this->Form->create('Qprofiledeck'); ?>
    <fieldset>
        <legend><?php echo __('Create a Deck'); ?></legend>
		<?php 
		echo $this->Form->input('Qdeck.deckType',array('class' => 'form-control'));
		echo $this->Form->input('Qdeck.title',array('class' => 'form-control'));
		echo $this->Form->input('Qdeck.description',array('class' => 'form-control'));
		echo $this->Form->input('Qdeck.privatePublic', array('class'=>'form-control','options' => array('0' => 'Private', '1' => 'Public')));	?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>