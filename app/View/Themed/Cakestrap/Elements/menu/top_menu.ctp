
<nav class="navbar navbar-inverse" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button><!-- /.navbar-toggle -->
		<?php 
			echo $this->Html->Link('ONQ', '/qprofiles/index', array('class' => 'navbar-brand')); 
		?>
	</div><!-- /.navbar-header -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<!-- <li class="active"><a href="#">Link</a></li> -->
			<li>
				<?php
					if($role == "admin" || $role == "user")
					{
						echo $this->Html->link($this->Html->image('../img/profilepic.png') . ' ' . __('Profile'),array('controller' => 'Qprofiles/view', 'action' => ''), array('escape' => false));
					}
				?>
			</li>
			<li>
			
				<?php
					if($role == "admin" || $role == "user")
					{
						echo $this->Html->link($this->Html->image('../img/grouppic.png') . ' ' . __('Groups'),array('controller' => 'Qprofilegroups/index', 'action' => ''), array('escape' => false));
					}
				?>
				
				<!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="../img/grouppic.png">Groups <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#"><?php echo $this->Html->Link('Your Groups', '/qprofiles/login'); ?></a></li>
					<li><a href="#"><?php echo $this->Html->Link('Community Groups', '/qprofiles/login'); ?></a></li>
				</ul> -->
			</li>
			<li>
			
				<?php
					if($role == "admin" || $role == "user")
					{
						echo $this->Html->link($this->Html->image('../img/deckspic.png') . ' ' . __('Decks'),array('controller' => 'Qprofiledecks/index', 'action' => ''), array('escape' => false));
					}
				?>
				
			<!--	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="../img/deckspic.png">Decks <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#"><?php echo $this->Html->Link('Your Decks', '/qprofiles/login'); ?></a></li>
					<li><a href="#"><?php echo $this->Html->Link('Community Decks', '/qprofiles/login'); ?></a></li>
				</ul> -->
			</li>
			
			<li>
				<?php 
					if($role == "admin")
					{
						echo $this->Html->Link('Advertisements', '/qadvertisements/index');
					}
				 ?>
			 </li>
			 <li>
				<?php 
					if($role == "admin")
					{
						echo $this->Html->Link('Users', '/qprofiles/viewall');
					}
				 ?>
				 
			 </li>
			 <li>
				<?php
					if($role == "admin")
					{
						echo $this->Html->Link('Analytics', '/qanalytics/admindash');
					}
				?>
			 
			 </li>			 
			 <li>
				<?php 
					if($role == "admin" || $role == "user")
					{
						echo $this->Html->Link('Download', '/qmobile/download');
					}
				 ?>
			 </li>
		 
			 
			 
			 
		</ul><!-- /.nav navbar-nav -->
	</div><!-- /.navbar-collapse -->
</nav><!-- /.navbar navbar-default -->