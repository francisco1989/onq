<?php //This lists profile -> deck -> list of cards?>
<!DOCTYPE html>
<html>
	<head>
	<style>
	#header{
		position:relative;
		top: -20px;
		width: 100%;
		padding: 60px;
		background: url('/./img/logo.png') left top no-repeat, linear-gradient(rgba(4,95,248,1), rgba(3,17,95,1));
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
	<body >
	<div class="container-fluid">
	
	<?php //List of Cards Section, add pre-scrollable and a height to div?>
	<div class="row">
		<div class="col-md-9" >
		<h3>Cards </h3>
		
		<div class="myTable" style="overflow: auto;">

		<table class="table table-hover" style="border-width:0px;">
		<tr >
				<td>Type</td>
				<td>Question</td>
				<td>Answer</td>
				<td>Action</td>
		</tr>
		<?php foreach ($Qcards as $Qcard): ?>
			<tr >
				<td ><?php echo $Qcard['Qc']['cardType']; ?> </td>
				<td ><?php echo $Qcard['Qc']['question']; ?> </td>
				<td ><?php echo $Qcard['Qc']['answer']; ?> </td>
				<td>
				<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<span class="glyphicon glyphicon-cog"></span><span class="caret"></span>
				</button>
				
				<ul class="dropdown-menu" role="menu">
				<li>
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'delete',$Qcard['Qc']['cardID'],$deckID,$userID),array('confirm' => 'Are you sure?')
							
						);
						
						
					?>
				</li>
				<li>
					<?php
						echo $this->Html->link(
							'Edit', array('controller' => 'qdeckcards','action' => 'edit',$Qcard['Qc']['cardID'],$deckID,$userID,$retUrl)
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
			<?php unset($Qcard); ?>
		</div>

	<?php //Add Card Section?>


		<div class="col-md-3">
		<h3>Add Card
		<small>
		</br>
		Deck: <?php echo $deckName ?> 
		</br>
		User:<?php echo $userName ?>
		</small>
		</h3>
		<?php
		$url = '/Qdeckcards/add/'.$deckID;
		echo $this->Form->create('Qcard', 
		array('url' => $url),
		array('inputDefaults' => array(
				'div' => array('class' => 'input-group input-group-sm'),
				'label' => array('class' => 'control-label'),
				'between' => '<div class="controls">',
				'after' => '</div>',
				'class' => '')
		));
		echo $this->Form->input('cardType',array('class' => 'form-control', 'placeholder'=>'Card Type'));
		echo $this->Form->input('question',array('class' => 'form-control', 'placeholder'=>'Question'));
		echo $this->Form->input('answer',array('class' => 'form-control', 'placeholder'=>'Answer'));
		echo $this->Form->input('controllerName', array('type' => 'hidden'));
		echo $this->Form->input('groupID', array('type' => 'hidden'));
		echo $this->Form->end('Submit');
		?>
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
		
			
		</div>
		
		
		
	</div>
	</div>
	
	
	
	
	</body>
</html>

