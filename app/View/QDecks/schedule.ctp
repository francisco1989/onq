<!-- app/View/Qprofiles/add.ctp -->
<div class="Qgroup form">
<?php echo $this->Form->create('schedule'); ?>
    <fieldset>
        <legend><?php echo __('Set up study schedule for this deck'); ?></legend>
        <?php 
		
		echo $this->Form->input('startDay', array(
						'label'=>'Start Day','options' => array('monday' =>'Monday','tuesday' =>'Tuesday','wendnesday' =>'Wednesday','thursday' =>'Thursday','friday' => 'Friday','satruday' =>'Saturday', 'sunday' =>'Sunday')
					));
					
		echo $this->Form->input('endDay', array(
						'label'=>'End Day','options' => array('monday' =>'Monday','tuesday' =>'Tuesday','wendnesday' =>'Wednesday','thursday' =>'Thursday','friday' => 'Friday','satruday' =>'Saturday', 'sunday' =>'Sunday')
					));
					
		
		echo $this->Form->input('startTime', array(
						'label'=>'Start Time','type'=>'select','options' => $time)
					);
					
			echo $this->Form->input('endTime', array(
						'label'=>'End Time','type'=>'select','options' => $time)
					);
	
		?>
    </fieldset>
<?php echo $this->Form->end(__('Schedule study time')); ?>
</div>