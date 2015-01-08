<!DOCTYPE html>
<html>
<head>
</head>
	<body>
	<h1>Decks</h1>
	<p><?php echo $this->Html->link('Add Deck', array('action' => 'add')); ?></p>
	<table class="table">
	<th>
	ID
	</th>
	<th>
	DeckType
	</th>
	<th>
	Title
	</th>
	<th>
	Actions
	</th>
    <?php foreach ($qdecks as $qdeck): ?>
    <tr>
        <td><?php echo $qdeck['Qdeck']['deckID']; ?></td>
		<td><?php echo $qdeck['Qdeck']['deckType']; ?></td>	
		<td>
					<?php
						echo $this->Html->link(
							$qdeck['Qdeck']['title'],
							array('action' => 'view', $qdeck['Qdeck']['deckID'])
						);
					?>
		</td>
		<td>
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'delete', $qdeck['Qdeck']['deckID']),
							array('confirm' => 'Are you sure?')
						);
					?>
					<?php
						echo $this->Html->link(
							'Edit', array('action' => 'edit', $qdeck['Qdeck']['deckID'])
						);
					?>
				</td>
		
    </tr>
    <?php endforeach; ?>
    <?php unset($qdeck); ?>
	</table>
	</body>
	
</html>