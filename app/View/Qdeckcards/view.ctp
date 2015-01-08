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
	<h1>
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
	</h1>
</head>
<h1>Details</h1>
<div class="myTable" >
	<table name="viewDeck" style="border-width:0px;">
		<tr>
			<td>ID</td>
			<td>DeckType</td>
			<td>Description</td>
			<td>Rating</td>
			<td>Created</td>
			<td>Modified</td>
			<td>Privacy Setting</td>
		</tr>
		<tr>
			<td><?php echo $qdeck['Qdeck']['deckID'];?></td>
			<td><?php echo $qdeck['Qdeck']['deckType']; ?></td>
			<td><?php echo h($qdeck['Qdeck']['description']); ?></td>
			<td><?php echo $qdeck['Qdeck']['rating']; ?></td>
			<td><?php echo $qdeck['Qdeck']['created']; ?></td>
			<td><?php echo $qdeck['Qdeck']['modified']; ?></td>
			<?php if($qdeck['Qdeck']['privatePublic'] == 0) { ?>
			<td>  Private</td>
			<?php }elseif ($qdeck['Qdeck']['privatePublic'] == 1){  ?>
			<td>  Public</td>
			<?php }?>
		</tr>
	</table>
</div>
<br/>
		
		
<br>
		<?php
	
			if($retUrl != null)
			{
		
				echo $this->Html->link(
				'Back To Group Decks', 
				array('controller' => 'Qgroupdecks' ,'action' => 'index', $groupID),
				array('class' => 'signbutton')
				);			
				}
				
				
		?>
</br>