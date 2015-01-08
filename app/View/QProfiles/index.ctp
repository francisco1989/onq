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
		<?php if ($authUser) { ?>
			<div class="container" style="width: 1100px">
				<div class="row" >
					<div class="col-md-12">
					<?php echo $this->Html->image('../img/home_1.jpg', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>

					</div>
				</div>
			</div>
		<?php } ?>
	</body>
</html>
