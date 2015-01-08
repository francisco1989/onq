<head>
	
		<div class="loginform">
			<h2>
			<?php 
				echo "Welcome ";
				echo AuthComponent::user('userName');
				echo "!";
				echo $this->Session->flash('auth'); 
				echo $this->Form->create('Logout'); 
			?>
			</h2>
				<div style="width: 100%; display: table;">
					<div style="display: table-row">
						<div style="width: 90px; display: table-cell;">
							<?php 
								echo $this->Html->link("LOGOUT", array('controller' => 'Qprofiles','action'=> 'logout'), array( 'class' => 'signbutton'))
							?>
						</div>
					</div>
				</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</head>
		
<div class="myTable" >
	<table name="viewDeck" style="border-width:0px;">
		<h1>Details</h1>
		<tr>
			<td>ID</td>
			<td>DeckType</td>
			<td>Description</td>
			<td>Rating</td>
			<td>Private/Public</td>
			<td>Created</td>
			<td>Modified</td>
		</tr>
		<tr>
			<td><?php echo $qdeck['Qdeck']['deckID'];?></td>
			<td><?php echo $qdeck['Qdeck']['deckType']; ?></td>
			<td><?php echo h($qdeck['Qdeck']['description']); ?></td>
			<td><?php echo $qdeck['Qdeck']['rating']; ?></td>
			<td><?php echo $qdeck['Qdeck']['privatePublic']; ?></td>
			<td><?php echo $qdeck['Qdeck']['created']; ?></td>
			<td><?php echo $qdeck['Qdeck']['modified']; ?></td>
		</tr>
	</table>
</div>
