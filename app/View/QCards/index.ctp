<!DOCTYPE html>
<html>
<head>
		
</head>
	<body>
	<h1>Cards</h1>
	<p><?php echo $this->Html->link('Add Card', array('action' => 'add')); ?></p>
	<table class="table">
	<th>
	ID
	</th>
	<th>
	cardType
	</th>
	<th>
	Question
	</th>
	<th>
	Answer
	</th>
	<th>
	Actions
	</th>
    <?php foreach ($qcards as $qcard): ?>
    <tr>
        <td><?php echo $qcard['Qcard']['cardID']; ?></td>
		<td><?php echo $qcard['Qcard']['cardType']; ?></td>
		<td><?php echo $qcard['Qcard']['question']; ?></td>
		<td><?php echo $qcard['Qcard']['answer']; ?></td>
		<td>
					<?php
						echo $this->Html->link(
							$qcard['Qcard']['cardID'],
							array('action' => 'view', $qcard['Qcard']['cardID'])
						);
					?>
		</td>
		<td>
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'delete', $qcard['Qcard']['cardID']),
							array('confirm' => 'Are you sure?')
						);
					?>
					<?php
						echo $this->Html->link(
							'Edit', array('action' => 'edit', $qcard['Qcard']['cardID'])
						);
					?>
				</td>
		
    </tr>
    <?php endforeach; ?>
    <?php unset($qcard); ?>
	</table>
	</body>
	
</html>