<!DOCTYPE html>
<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')</script>	
		<script src="js/bootstrap.min.js"></script>
		<script>
		  $(document).ready(function(){
			$('.carousel').carousel({
			
			interval: 4000
			});
		  });
		</script>	
	<h1>
		<div class="loginform">
		<?php if (!$authUser) { 
			echo $this->Session->flash('auth'); 
			echo $this->Form->create('Qprofile'); 
			echo $this->Form->input('username');
			echo $this->Form->input('password');
			?>
			<div style="width: 100%; display: table;">
				<div style="display: table-row">
					<div style="width: 90px; display: table-cell;">
						<?php 
							echo $this->Form->submit('LOGIN', array('name'=>'submit1'));
						?>
					</div>
					<div style="display: table-cell;">
						<?php 
							echo $this->Html->link("SIGN UP", array('controller' => 'Qprofiles','action'=> 'register'), array( 'class' => 'signbutton'))
							//echo $this->Form->submit('SIGN UP', array('name'=>'submit2'));
						?>
					</div>
				</div>
			</div>
		</div>				
	</h1>
	</head>
	<body>
		<div class="container" >
			<div id="this-carousel-id" class="carousel slide">
				<div class="carousel-inner">
					<div class="item active">
					  <img src="../img/headerCopy.jpg" alt="" />
					  <div class="carousel-caption">
						<p><h2></h2></p>
					  </div>
					</div>
					<div class="item">
					  <img src="../img/unity_Banner.png" alt="" />
					  <div class="carousel-caption">
						<p><h2>Unity3D FPS</h2></p>
					  </div>
					</div>
					<div class="item">
					  <img src="../img/kids_Banner.png" alt="" />
					  <div class="carousel-caption">
						<p><h2>Games for everyone!</h2></p>
					  </div>
					</div>
					<div class="item">
					  <img src="../img/analytics_Banner.png" alt="" />
					  <div class="carousel-caption">
						<p><h2>Analytics</h2></p>
					  </div>
					</div>
					
					<div class="item">
					  <img src="../img/study_Banner.png" alt="" />
					  <div class="carousel-caption">
						<p><h2>Study on the go!</h2></p>
					  </div>
					</div>		
					
			  </div>
				<a class="carousel-control left" href="#this-carousel-id" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#this-carousel-id" data-slide="next">&rsaquo;</a>
			</div>
				<div class="row">
				<div class="col-md-12">
						<?php
							//echo $this->Html->image('../img/head.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
						</div>
				</div>
				<br/>
				<div class="row" >
					<div class="col-md-4">
					<?php
						echo $this->Html->image('../img/studentTablet.jpg', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
					</div>
					
					<div class="col-md-8 well">
					<h3>About ONQ</h3>
						ONQ started out as a simple idea for an educational tool that through repetition would improve a student’s performance. 
					Our main goal was to create a web application that would allow our users to create cue cards, create groups and share group cards with other users.
					 ONQs main features include a game which will allow users to shoot cue cards, a play button which will allow users to study their cards, 
					 a test button that will test users on the cards selected and the ability to set up a schedule which will send cue cards question and answers 
					 sets to your phone via SMS/MMS every 10 minutes. 
					In addition to the web application we have an android mobile companion which will allow you to view your cards, 
					pull decks and share decks with other users by bumping phones.
					</div>
				</div>
					<br/>
				<div class="row" >
					<div class="col-md-4 pull-left">
					<?php
						echo $this->Html->image('../img/onqdroid.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
					</div>
					<div class="col-md-8 well pull-right">
					<h3>Mobile</h3>
						Developing native mobile applications for specific platforms gives ONQ full control of the provided API’s allowing us to utilize mobile features such as NFC, the accelerometer and the gyroscope. 
					Currently the android version of ONQ offers the ability to connect to your account to retrieve your current decks of study cards and share your decks with your peers using NFC and bump technology. 
					Shared decks may also be pushed back to your account and saved for later use. 
					The android version also provides the user an interactive way of studying by allowing them to use swipe technology to view their cards.
						 <br/>
					</div>
				</div>
					<br/>
					<br/>
				<div class="row">
						<div class="col-md-2 col-md-offset-5">
						<h2 class="center">The Team</h2>
						<br/>
					</div>
				</div>
				<div class="row " >
					<div class="col-md-3">  
					<?php
						echo $this->Html->image('../img/userimg.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
					
					</div>
					
					<div class="col-md-3 ">
					<?php
						echo $this->Html->image('../img/userimg.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
					</div>	
					
					<div class="col-md-3 ">
					<?php
						echo $this->Html->image('../img/userimg.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
					</div>
					
					<div class="col-md-3">
					<?php
						echo $this->Html->image('../img/userimg.png', array('class' => 'img-responsive', 'alt' => 'Responsive Image')) ?>
					</div>
				</div>
				<div class="row " >
					<div class="col-md-3 well"style="text-align:center">  
					<h4>Darryl</h4>
					Graphic Designer, <br/> Software Engineering Technologist
					darrylpoworoznyk@live.com
					</div>
					<div class="col-md-3 well"style="text-align:center"> 
					<h4>Francisco</h4>
					Software Engineering Technologist
					francisco.j.granados@hotmail.com
					
					
					<br/>
					<br/>
				
					</div>
					<div class="col-md-3 well"style="text-align:center">  
					<h4>Francis</h4>
					Software Engineering Technologist
					fkurevija@gmail.com
					<br/>
					<br/>
					</div>
					<div class="col-md-3 well"style="text-align:center">  
					<h4 >Jose</h4>
					Graphic Designer, <br/> Software Engineering Technologist
					jcifuentes-cc@conestogac.on.ca
					</div>
				</div>
		</div>
	<?php } ?>
	</div>
		
	</body>
</html>
