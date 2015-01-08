<?php //This lists profile -> deck -> list of cards?>
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
	<script type="text/javascript" src="http://mbostock.github.com/d3/d3.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<style>
 
/* entire container, keeps perspective */
.flip-container {
	perspective: 1000;
}
.flip-container, .front, .back {
	width: 500px;
	height: 300px;
}
/* flip speed goes here */
.flipper {
	position: relative;
}
/* hide back of pane during swap */
.front, .back {
	backface-visibility: hidden;
	position: absolute;
	top: 0;
	left: 0;
	text-align:center;
	vertical-align:middle;
	box-shadow: 5px 5px 5px #888888;
	
	-moz-border-radius: 1em 1em 1em 1em;
	border-radius: 1em 1em 1em 1em;
}
/* front pane, placed above back */
.front {
	z-index: 2;
background-color: white; 
background-image: 
linear-gradient(90deg, transparent 79px, #abced4 79px, #abced4 81px, transparent 81px),
linear-gradient(#eee .1em, transparent .1em);
background-size: 100% 1.2em;
}

.cover {
background-color: red;
}


/* back, initially hidden pane */
.back {	
	background-image: -webkit-gradient(
	linear,
	left top,
	left bottom,
	color-stop(0, #FFFFFF),
	color-stop(1, #B4DFFA)
);
background-image: -o-linear-gradient(bottom, #FFFFFF 0%, #B4DFFA 100%);
background-image: -moz-linear-gradient(bottom, #FFFFFF 0%, #B4DFFA 100%);
background-image: -webkit-linear-gradient(bottom, #FFFFFF 0%, #B4DFFA 100%);
background-image: -ms-linear-gradient(bottom, #FFFFFF 0%, #B4DFFA 100%);
background-image: linear-gradient(to bottom, #FFFFFF 0%, #B4DFFA 100%);
}	
</style>

</head>
	<body>
		<h3>Play</h3>
		Click the card to toggle between question and answer. <br/><br/>
		
		<div class="container-fluid col-md-6">	
			<div class="row">
			<!-- col-md-2 col-md-offset-5-->
					<div class="flip-container col-md-offset-4" style="">
						<div class="flipper">

						
							<div id="front" class="front" onclick="javascript:animate()" style="border: 1px solid green; background-color:#CCFB5D">
							<!-- front content -->
														
							<div id="text">
							<h1 id="question">Front Content</h1>
							</div>
							</div>
							
							
							<div id="back" class="back" style="border: 1px solid blue; background-color:#C2DFFF;">
							<!-- back content -->
							<h1 id="answer">Back Content</h1>
							</div>
						</div>
					</div>
			</div>
			<br/>
			<div class="row">
					<?php
						echo '<div class="pull-left col-md-offset-7">';
						$image = file_get_contents('../webroot/img/leftArrowSM.png');
						header('Content-Type: image/*');
						echo '<img src="data:image/png;base64,' . base64_encode($image) . '" class="img-responsive" style="height: 50px; width: 80px;" onClick="javascript:previous()" alt="Responsive Image" />';
						echo '</div>';
						
						echo '<div class=" col-md-offset-10">';
						$image = file_get_contents('../webroot/img/rightArrowSM.png');
						header('Content-Type: image/*');
						echo '<img src="data:image/png;base64,' . base64_encode($image) . '" class="img-responsive" style="height: 50px; width: 80px;" onClick="javascript:next()" alt="Responsive Image" />';
						echo '</div>';
					?>
			</div>
		</div>
		
</br>
</br>
</br>
</br>
</br>
</br>	
</br>
</br>
</br>
</br>
</br>
</br>
</br>	
</br>
</br>
</br>
</br>
</br>	
</br>
		<?php
	
			if($retUrl != null)
			{
		
				echo $this->Html->link(
				'Back To Group Decks', 
				array('controller' => 'Qgroupdecks' ,'action' => 'index', $groupID),
				array('class' => 'signbutton')
				);			
			}
				
				
		?>
</br>
	</body>
	<script>
	var myCards = <?php echo json_encode($Qcards); ?>;
	var cardCount = myCards.length;
	var myNum = 0;
	var cardVisible = 0;
	
	if(myCards!= null)
	{
		var frontCard = document.getElementById("question");
		frontCard.innerHTML = "<h1>Q: <small>" + myCards[0].Qc['question'] + "</small></h1>";
		var backCard = document.getElementById("back");	
		backCard.innerHTML = "<h1>A: <small>" + myCards[0].Qc['answer'] + "</small></h1>";		
	}
	
function update()
{
	    d3.select("#text").transition()
        .duration(1)
		.style("opacity", 0);
}	
	
function next() {
	if(cardVisible == 0)
	{
		if(myNum == cardCount-1)
		{
			alert("Last Card");
		}
		else
		{				
			//Fade out
			
			$("#front").animate({
			left:'-400px',
			opacity:'0.0'
			});
			$("#back").animate({
			left:'-400px',
			opacity:'0.0'
			});

			//Fade In
			$("#front").animate({
			left:'0px',
			opacity:'0.0'
			});
			$("#back").animate({
			left:'0px',
			opacity:'0.0'
			});	
			
			$("#front").animate({
			opacity:'1.0'
			});
			
			//Change Text
			setTimeout(function(){
			myNum++;
			var frontCard = document.getElementById("front");
			frontCard.innerHTML = "<h1>Q: <small>" + myCards[myNum].Qc['question'] + "</small></h1>";}, 800);
		}
	}
}
	
function previous() {
	if(cardVisible == 0)
	{
		if(myNum == 0)
		{
			alert("First Card");
		}
		else
		{
			//Fade out
			$("#front").animate({
			left:'400px',
			opacity:'0.0'
			});
			$("#back").animate({
			left:'400px',
			opacity:'0.0'
			});
		
			//Fade In
			$("#front").animate({
			left:'0px',
			opacity:'0.0'
			});
			$("#back").animate({
			left:'0px',
			opacity:'0.0'
			});	
			
			$("#front").animate({
			opacity:'1.0'
			});	
			
			//Change Text
			//Change Text
			setTimeout(function(){
			myNum--;
			var frontCard = document.getElementById("front");
			frontCard.innerHTML = "<h1>Q: <small>" + myCards[myNum].Qc['question'] + "</small></h1>";}, 800);
		}
	}
}

function animate() {
	//Show Answer
	if(cardVisible == 0)
	{
	toggleVisibility();
    d3.select("#front").transition()
        .duration(500)
		.style("opacity", 0);
	//Get Text
	var backCard = document.getElementById("back");	
	backCard.innerHTML = "<h1>A: <small>" + myCards[myNum].Qc['answer'] + "</small></h1>";		
		
	 d3.select("#back").transition()
        .duration(500)
		.style("opacity", 1);
		
	}//Show Question
	else if(cardVisible == 1)
	{
		toggleVisibility();
	    d3.select("#front").transition()
        .duration(500)
		.style("opacity", 1);
		
		d3.select("#back").transition()
        .duration(500)
		.style("opacity", 0);
	}
};

function toggleVisibility()
{
	if(cardVisible == 0)
	{
		cardVisible = 1;
	}
	else if(cardVisible == 1)
	{
		cardVisible = 0;
	}
}
</script>
	
	
</html>

