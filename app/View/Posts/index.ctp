<!-- File: /app/View/Posts/index.ctp -->
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
				echo __('You are logged in!'); 
			?>
		</div>
		</h1>
	</head>
	<boby>
		<h1>Blog posts</h1>
		<p><?php echo $this->Html->link('Add Post', array('action' => 'add')); ?></p>
		<table>
			<tr>
				<th>Id</th>
				<th>Title</th>
				<th>Actions</th>
				<th>Created</th>
			</tr>

		<!-- Here's where we loop through our $posts array, printing out post info -->

			<?php foreach ($posts as $post): ?>
			<tr>
				<td><?php echo $post['Post']['id']; ?></td>
				<td>
					<?php
						echo $this->Html->link(
							$post['Post']['title'],
							array('action' => 'view', $post['Post']['id'])
						);
					?>
				</td>
				<td>
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'delete', $post['Post']['id']),
							array('confirm' => 'Are you sure?')
						);
					?>
					<?php
						echo $this->Html->link(
							'Edit', array('action' => 'edit', $post['Post']['id'])
						);
					?>
				</td>
				<td>
					<?php echo $post['Post']['created']; ?>
				</td>
			</tr>
			<?php endforeach; ?>

		</table>
	</body>
</html>

