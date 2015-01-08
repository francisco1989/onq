<?php
//This lists profile -> list of decks
?>

<!DOCTYPE html>
<html>
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
		
	<body>


		<h1> <?php echo AuthComponent::user('userName'); ?> Decks</h1>
		<p><?php echo $this->Html->link('Add Deck', array('action' => 'add'),array('class'=>'signbutton')); ?></p>
		
		<br/>
		<br/>
		<br/>
		<div class="container pull-left" style=" width:1100px;">
		<div class="row">
		<div class="col-md-11">
		<div class="myTable" >
		<table style="border-width:0px;">
		<tr >
				<td>Type</td>
				<td>Title</td>
				<td>Description</td>
				<td>Rating</td>
				<td>Date Created</td>			
				<td>Privacy Setting</td>
				<td>Actions</td>
				
		</tr>
		<?php foreach ($Qdecks as $Qdeck): ?>
			<tr >
				<td><?php echo $Qdeck['Qd']['deckType']; ?> </td>
				<td><?php echo $Qdeck['Qd']['title']; ?> </td>
				<td><?php echo $Qdeck['Qd']['description']; ?> </td>
				<td><?php echo $Qdeck['Qd']['rating']; ?> </td>
				<td><?php echo $Qdeck['Qd']['created']; ?></td>		
				<?php if($Qdeck['Qd']['privatePublic'] == 0) { ?>
				<td>  Private</td>
				<?php }elseif ($Qdeck['Qd']['privatePublic'] == 1){  ?>
				<td>  Public</td>
				<?php } ?>
				<td>
				<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<span class="glyphicon glyphicon-cog"></span><span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
				<li>
					<?php
						echo $this->Html->link(
							'View Details', 
							array('controller' => 'qdeckcards' ,'action' => 'view', $Qdeck['Qd']['deckID'], $userID)
							);
					?>	
				</li>
				<li>
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'delete', $Qdeck['Qd']['deckID']),
							array('confirm' => 'Are you sure?')
						);
					?>
				</li>
				<li>
					<?php
						echo $this->Html->link(
							'Edit', 
							array('controller' => 'qprofiledecks' ,'action' => 'edit', $Qdeck['Qd']['deckID'])

						);
					?>
				</li>
				</ul>
				</div>
				<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<span class="glyphicon glyphicon-th-list"></span><span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
				
				<li>
				<?php
					echo $this->Html->link(
						'Cards', 
						array('controller' => 'qdeckcards' ,'action' => 'index', $Qdeck['Qd']['deckID'], $userID)
						);
				?>	
				</li>
				<li>
				<?php
					echo $this->Html->link(
						'Schedule', 
						array('controller' => 'qprofiledecks' ,'action' => 'schedule', $Qdeck['Qd']['deckID'], $userID)
						);
				?>	
				</li>
				<li>
				<?php
					echo $this->Html->link(
						'Play', 
						array('controller' => 'qdeckcards' ,'action' => 'play', $Qdeck['Qd']['deckID'])
						);
				?>
				</li>
				<li>
				<?php
					echo $this->Html->link(
						'Test', 
						array('controller' => 'qdeckcards' ,'action' => 'test', $Qdeck['Qd']['deckID'])
						);
				?>
				</li>
				<li>
				<?php
					echo $this->Html->link(
						'Game', 
						array('controller' => 'qprofiledecks' ,'action' => 'startGame', $Qdeck['Qd']['deckID'])
					);
				?>	
				</li>
				</ul>
				</div>
				</td>
			</tr>
			
			<?php endforeach; ?>
			</table>
			</div>
			<?php unset($Qdeck); ?>
			
			</div>
			</div>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			</div>	

	</body>
</html>

