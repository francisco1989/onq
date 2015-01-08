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
	<body>
		<div class="myTable" >
                <table >
                    <tr>
						<td>
                            Profile Picture
                        </td>
                        <td>
                            User Name
                        </td>
                        <td >
                            First Name
                        </td>
						<td >
                            Last Name
                        </td>
						<td >
                            Member Status
                        </td>
                    </tr>
					<?php foreach ($Qusers as $user): ?>
                    <tr>
						<td >
							<?php
								$image = file_get_contents($user['Qp']['profilePic']);
								//header('Content-Type: image/*');
								echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" height="100" width="100">';
                            ?>
                        </td>
                        <td >
                            <?php echo $user['Qp']['userName']; ?>
                        </td>
                        <td>
                            <?php echo $user['Qp']['firstName']; ?>
                        </td>
						<td>
                            <?php echo $user['Qp']['lastName']; ?>
                        </td>
						<td>
						
											
					<?php if($user['Qprofilegroup']['owner'] == 1) { ?>
					  Owner
					<?php }elseif ($user['Qprofilegroup']['owner'] == 0){  ?>
					Member
					<?php } ?>
					
                        </td>
                      
                    </tr>
                  <?php endforeach; ?>
                </table>
            </div>
		
	</body>
</html>



