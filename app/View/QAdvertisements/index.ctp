<!--
 *  Project : OnQ
 *  File : index.ctp
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 20, 2014
 *  Description : index.ctp displays all advertisements in the database
 -->
 
<!DOCTYPE html>
<html>
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
	<boby>
		<h1>Advertisements</h1>
		<p><?php echo $this->Html->link('Add Advertisement', array('action' => 'add'), array( 'class' => 'signbutton')); ?></p>
		<br/>
		<br/>
		<br/>
		<div class="myTable" >
			<table style="border-width:0px;">
				<tr>
					<td>Id</td>
					<td>Advertisement</td>
					<td>Actions</td>
				</tr>

			<!-- Here's where we loop through our $qadvertisements array, printing out advertisement info -->

				<?php foreach ($Qadvertisements as $qad): ?>
				<tr>
					<td><?php echo $qad['Qadvertisement']['advertisementID']; ?></td>
					<td>
						<?php
							$image = file_get_contents($qad['Qadvertisement']['advertisement']); //File path from DB
							$pathInPieces = explode('/', $qad['Qadvertisement']['advertisement']); //Break path
							$fileName = $pathInPieces[count($pathInPieces)-1]; //Grab file name + extension
							header('Content-Type: image/*');
							echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" alt="'.$fileName.'" height="100" width="100">';
							//echo '<a href="Qadvertisements/View/'.$qad['Qadvertisement']['advertisementID'].'"><img src="data:image/jpeg;base64,'
							//	. base64_encode($image) . '" alt="'.$fileName.'" height="100" width="100"></a>';
						?>
					</td>
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-cog"></span><span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li>
									<?php
										echo $this->Html->link(
											'View Details', array('action' => 'view', $qad['Qadvertisement']['advertisementID'])
										);
									?>
								</li>
								<li>
									<?php
										echo $this->Form->postLink(
											'Delete',
											array('action' => 'delete', $qad['Qadvertisement']['advertisementID']),
											array('confirm' => 'Are you sure?')
										);
									?>
								</li>
								<li>
									<?php
										echo $this->Html->link(
											'Edit', array('action' => 'edit', $qad['Qadvertisement']['advertisementID'])
										);
									?>
								</li>
								<!--<li>
									<?php
										/*echo $this->Html->link(
											'Target Users', array('action' => 'target', $qad['Qadvertisement']['advertisementID']),
											array( 'class' => 'signbutton')
										);*/
									?>
								</li>-->
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</body>
</html>

