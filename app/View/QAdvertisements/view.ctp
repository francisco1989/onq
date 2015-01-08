<!--
 *  Project : OnQ
 *  File : view.ctp
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 20, 2014
 *  Description : view.ctp allows the user to view a specific advertisement
 -->
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

<h1><?php echo 'Details of Ad: '.h($Qadvertisement['Qadvertisement']['advertisementID']); ?></h1>

<p>
	<?php 
		$image = file_get_contents($Qadvertisement['Qadvertisement']['advertisement']); //File path from DB
		$pathInPieces = explode('/', $Qadvertisement['Qadvertisement']['advertisement']); //Break path
		$fileName = $pathInPieces[count($pathInPieces)-1]; //Grab file name + extension
		header('Content-Type: image/*');
		echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" alt="'.$fileName.'">';
	?>
</p>

<?php
	echo $this->Form->postLink(
		'Delete',
		array('action' => 'delete', $Qadvertisement['Qadvertisement']['advertisementID']),
		array( 'class' => 'signbutton',
			'confirm' => 'Are you sure?')
	);
?>
<?php
	echo $this->Html->link(
		'Edit',
		array('action' => 'edit', $Qadvertisement['Qadvertisement']['advertisementID']),
		array( 'class' => 'signbutton')
	);
?>