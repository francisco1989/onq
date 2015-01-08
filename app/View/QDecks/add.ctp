<h1>Add Deck</h1>
<?php
echo $this->Form->create('Qdeck', array(
    'inputDefaults' => array(
        'div' => array('class' => 'input-group input-group-sm'),
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after' => '</div>',
        'class' => '')
));
echo $this->Form->input('deckType',array('class' => 'form-control'));
echo $this->Form->input('title',array('class' => 'form-control'));
echo $this->Form->input('description',array('class' => 'form-control'));
echo $this->Form->input('privatePublic', array('class'=>'form-control','options' => array('0' => 'Private', '1' => 'Public')));
echo $this->Form->end('Save Qdeck');
?>
<br />
<br />
<?php
	echo $this->Html->link(
		'Back to Decks', array('action' => 'index')
	);
?>