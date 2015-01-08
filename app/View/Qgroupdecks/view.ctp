
<head>
			<style>
		#header{
		position:relative;
		top: -20px;
		width: 100%;
		padding: 60px;
		background: url('../../img/logo.png') left top no-repeat, linear-gradient(rgba(4,95,248,1), rgba(3,17,95,1));
	}
	</style>
</head>

<table name="viewDeck" class="table">
<h1>Details</h1>
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

