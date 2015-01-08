<h1>Edit Deck</h1>
<?php
echo $this->Form->create('Qdeck');
echo $this->Form->input('deckID', array('type' => 'hidden'));
echo $this->Form->input('modified', array('type' => 'hidden'));
echo $this->Form->input('deckType');
echo $this->Form->input('title');
echo $this->Form->input('description');
echo $this->Form->input('privatePublic', array('options' => array('0' => 'Private', '1' => 'Public')));
echo $this->Form->end('Save Qdeck');
?>
<br />
<br />
<?php
	echo $this->Html->link(
		'Back to Decks', array('action' => 'index')
	);
?>