<head>
			
</head>
<table name="viewCard" class="table">
<tr>
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
</tr>
<tr>
	<td>
	<?php echo $qcard['Qcard']['cardID'];?>
	</td>
	
	<td>
	<?php echo $qcard['Qcard']['cardType']; ?>
	</td>
	
	<td>
	<?php echo h($qcard['Qcard']['question']); ?>
	</td>
	
	<td>
	<?php echo $qcard['Qcard']['answer']; ?>
	</td>
</table>
