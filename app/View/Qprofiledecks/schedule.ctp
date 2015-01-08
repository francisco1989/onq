<!-- app/View/Qprofiles/add.ctp -->
	<head>
				<style>
		#header{
		position:relative;
		top: -20px;
		width: 100%;
		padding: 60px;
		background: url('../../../img/logo.png') left top no-repeat, linear-gradient(rgba(4,95,248,1), rgba(3,17,95,1));
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
<?php
			echo $this->Html->script(array('jquery','jquery-ui'));
			echo $this->Html->css('jquery-ui.css');
		?>
		<script>
			$(function() {
				   $("#datepicker").datepicker();
			});
			$(function() {
				   $("#datepick").datepicker();
			});
		</script>

<div class="Qgroup form">

<div class="alert alert-warning"> <strong>Warning!</strong> This feature is not fully developed it is intended to be a proof of concept  </div>

<?php echo $this->Form->create('Qschedule'); ?>
    <fieldset>
        <legend><?php echo __('Set up study schedule for this deck'); ?></legend>
		 <div class="row">
		<div class="col-md-4">
        <?php 
		
		
					echo $this->Form->input('startDay', array(
						'id'=>'datepicker','type'=>'text','name'=>'datepicker'
					));
		
					
					echo $this->Form->input('endDay', array(
						'id'=>'datepick','type'=>'text','name'=>'datepick'
					));
		
		echo $this->Form->input('startTime', array(
						'label'=>'Start Time','type'=>'select','options' => $time)
					);
					
		echo $this->Form->input('endTime', array(
						'label'=>'End Time','type'=>'select','options' => $time)
					);
					
		echo $this->Form->input('intervals', array(
						'label'=>'Set Interval','options' => array(15 =>15,30 =>30,45 =>45,60 =>60)
					));	
					
		echo $this->Form->input('provider', array(
			'label'=>'Provider','options' => array('rogers' =>'rogers','fido' =>'fido','telus' =>'telus','bell' =>'bell','koodo' =>'koodo','virgin' =>'virgin','bell' =>'bell','solo' =>'solo','mts' =>'mts')
			));	
	
		?>
    </fieldset>
<?php echo $this->Form->end(__('Schedule study time')); ?>
</div>
</div>
</div>