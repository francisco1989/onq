<!-- File: /app/View/Posts/index.ctp -->
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
		<h1>Groups</h1>
		<p><?php echo $this->Html->link('Add Groups', array('action' => 'add'),array('class'=>'signbutton')); ?></p>
		<p><?php echo $this->Html->link("Join Group", array('controller' => 'Qprofilegroups','action'=> 'join'), array( 'class' => 'signbutton')); ?></p>
	
	<br/>
	<br/>

		
			<div class="container pull-left" style=" width:1100px;">
			<div class="row">
			<div class="col-md-11">			

		<!-- Here's where we loop through our $posts array, printing out post info -->
	<?php $mycounter = 0?>
			<?php foreach ($Qgroups as $Qgroup): ?>
			
			<br/>
			<div >
			<!--  <a href="google.com"><span>-->
			<div class="myTable" >
			<table style="border-width:0px;">
			<tr >
				<td></td>
				<td>Type</td>
				<td>Title</t>
				<td>Description</td>
				<td>Date Created</td>
				<td>Privacy Setting</td>
				<td>Group Code</td>
				<td>Actions</td>
				
			</tr>
			<tr >
				<td ><span class="badge badge-info"><?php echo $count[$mycounter][0][0]['COUNT(*)']; ?></span></td >
					<?php $mycounter = $mycounter  + 1; ?>
				<td ><?php echo $Qgroup['QgroupJoin']['groupType']; ?> </td>
				<td><?php echo $Qgroup['QgroupJoin']['groupTitle']; ?> </td>
				<td><?php echo $Qgroup['QgroupJoin']['groupDescription']; ?> </td>
				<td>
					<?php echo $Qgroup['QgroupJoin']['lastModified']; ?>
					
				</td>
									
					<?php if($Qgroup['QgroupJoin']['privatePublic'] == 0) { ?>
					<td>  Private</td>
					<?php }elseif ($Qgroup['QgroupJoin']['privatePublic'] == 1){  ?>
					<td>  Public</td>
					<?php } ?>
					
								
				<td>
				<?php 
				if($Qgroup['Qprofilegroup']['owner'] == 1)
				{
					
					echo $Qgroup['QgroupJoin']['groupCode']; 
					
				}
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
				if($Qgroup['Qprofilegroup']['owner'] == 1)
				{
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'delete', $Qgroup['Qprofilegroup']['groupID']),
							array('Are you sure?')
							
						);
						}
						
					?>
				</li>
				<li>
					<?php
				if($Qgroup['Qprofilegroup']['owner'] == 1)
				{
						echo $this->Html->link(
							'Edit', array('action' => 'edit', $Qgroup['Qprofilegroup']['groupID'])
						);
						}
					?>
				</li>
				<li>
					<?php
						echo $this->Html->link(
							'Decks', array( 'controller' => 'Qgroupdecks','action' => 'index', $Qgroup['Qprofilegroup']['groupID'])
						);
					?>
				</li>
				<li>
					<?php
						echo $this->Html->link(
							'Members', array( 'controller' => 'Qprofilegroups','action' => 'members', $Qgroup['Qprofilegroup']['groupID'])
						);
					?>
				</li>
				<li>
					<?php
				if($Qgroup['Qprofilegroup']['owner'] == 1)
				{
						echo $this->Html->link(
							'Analytics', array( 'controller' => 'Qanalytics','action' => 'groupdash')
						);
						}
					?>
				</li>	
				</ul>
				</div>
				</td>
			</tr>
			
			</table>
			</div>
		
			<!-- </span></a> -->
			</div>
			
			<?php endforeach; ?>

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

