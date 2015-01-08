
<head>
			
</head>
<h1>Edit Card</h1>
<?php
echo $this->Form->create('Qcard');
echo $this->Form->input('cardID', array('type' => 'hidden'));
echo $this->Form->input('cardType');
echo $this->Form->input('question');
echo $this->Form->input('answer');
echo $this->Form->end('Save Qcard');
?>
<br />
<br />
<?php
	echo $this->Html->link(
		'Back to Cards', array('action' => 'index')
	);
?>