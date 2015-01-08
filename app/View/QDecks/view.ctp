<table name="viewDeck" class="table">
<tr>
<th>
ID
</th>
<th>
DeckType
</th>
<th>
Description
</th>

<th>
Rating
</th>
<th>
Private/Public
</th>
<th>
Created
</th>
<th>
Modified
</th>


</tr>

<tr>
	<td>
	<?php echo $qdeck['Qdeck']['deckID'];?>
	</td>
	
	<td>
	<?php echo $qdeck['Qdeck']['deckType']; ?>
	</td>
	
	<td>
	<?php echo h($qdeck['Qdeck']['description']); ?>
	</td>
	
	<td>
	<?php echo $qdeck['Qdeck']['rating']; ?>
	</td>
	
	<td>
	<?php echo $qdeck['Qdeck']['privatePublic']; ?>
	</td>	
	
	<td>
	<?php echo $qdeck['Qdeck']['created']; ?>
	</td>
	
	<td>
	<?php echo $qdeck['Qdeck']['modified']; ?>
	</td>
</table>

<?php echo $this->element('addNewCard');?>
