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
	
<h1>Edit Deck</h1>
<?php
echo $this->Form->create('Qcard');
echo $this->Form->input('cardID', array('type' => 'hidden'));
echo $this->Form->input('modified', array('type' => 'hidden'));
echo $this->Form->input('cardType');
echo $this->Form->input('question');
echo $this->Form->input('answer');
echo $this->Form->end('Save Card');
?>
<br />
<br />
<?php
	if($retUrl != null)
	{
		echo $this->Html->link(
			'Back To Cards', array('action' => 'index',$deckID,$userID,$retUrl),
			array('class' => 'signbutton')
		);	
	}
	else
	{
		echo $this->Html->link(
			'Back To Cards', array('action' => 'index',$deckID,$userID),
			array('class' => 'signbutton')
		);
	}
?>

</html>