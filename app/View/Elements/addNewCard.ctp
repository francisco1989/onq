<h1>Add Card</h1>
<?php
echo $this->Form->create('Qcard', array(
    'inputDefaults' => array(
        'div' => array('class' => 'input-group input-group-sm'),
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after' => '</div>',
        'class' => '')
));
echo $this->Form->input('cardType',array('class' => 'form-control'));
echo $this->Form->input('question',array('class' => 'form-control'));
echo $this->Form->input('answer',array('class' => 'form-control'));
echo $this->Form->end('Save Qcard');
?>