<!-- File: /app/View/Posts/index.ctp -->
<!DOCTYPE html>
<html>
	<head>
	<h1>
		
		</h1>
	</head>
	<boby>
		<h1>Achievements</h1>
	
	<br/>
	<br/>

		
			

		<!-- Here's where we loop through our $posts array, printing out post info -->
	
			<?php foreach ($qachievements as $qachievement): ?>
			<div style="background-color:lightgrey;border:5px solid black; margin: 10px">
			 <a href="google.com"><span>
			<table class="table">
			<tr >
				<th>Achievement Name</th>
				<th>Details</th>
				
			</tr>
			<tr >
				<td ><?php echo $qachievement['QachievementJoin']['achievementName']; ?> </td>
				<td><?php echo $qachievement['QachievementJoin']['details']; ?> </td>
			
				
				
			</tr>
			</table>
			</span></a>
			</div>
			
			<?php endforeach; ?>

		
		
	</body>
</html>

