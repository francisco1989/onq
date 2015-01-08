<!DOCTYPE html>
<html>
	<head>
	<h1>
		<div class="loginform">
			<?php 
				echo $this->Session->flash('auth'); 
				echo $this->Form->create('User'); 
				//echo __('Please Login'); 
				echo $this->Form->input('username');
				echo $this->Form->input('password');
				echo $this->Form->end(__('LOGIN')); 
			?>
		</div>
		</h1>
	</head>
	<boby>
	
	</body>
</html>
