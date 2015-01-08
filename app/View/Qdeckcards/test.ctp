<head>
	<style>
	#header{
		position:relative;
		top: -20px;
		width: 100%;
		padding: 60px;
		background: url('/./img/logo.png') left top no-repeat, linear-gradient(rgba(4,95,248,1), rgba(3,17,95,1));
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
	
		<?php $counter = 1 ;?>	
		<?php foreach ($Qcards as $Qcard): ?>
		
		
		<div class="questions">
		 <div class="form-group">
		
		<h2> <span class="label label-default">Question <?php echo $counter;?>.</span> <br><br></h2>
		<form class="options">
			<div class="myTable">
				<table style="border-width:0px;">
					<tr>
						<td width="10%">
						</td>
						<td>
						<?php echo $Qcard[0]; ?>
						</td>
					</tr>
					<tr>
						<td width="10%">
						<input class="option" type="radio"  id="question<?php echo $counter;?>" name="question<?php echo $counter;?>" value=<?php echo $Qcard[1]; ?>>
						</td>
						<td width="90%">
						<?php echo $Qcard[1]; ?>
						</td>
					</tr>
					<tr>
						<td width="10%">
						<input class="option" type="radio" id="question<?php echo $counter;?>" name="question<?php echo $counter;?>" value=<?php echo $Qcard[2]; ?>>
						</td>
						<td width="90%">
						<?php echo $Qcard[2]; ?> 
						</td>
					</tr>
					<tr>
						<td width="10%">
						<input class="option" type="radio" id="question<?php echo $counter;?>" name="question<?php echo $counter;?>" value=<?php echo $Qcard[3]; ?>>
						</td>
						<td width="90%">
						<?php echo $Qcard[3]; ?>
						</td>
					</tr>
					<tr>
						<td width="10%">
						<input class="option" type="radio" id="question<?php echo $counter;?>" name="question<?php echo $counter;?>" value=<?php echo $Qcard[4]; ?>>
						</td>
						<td width="90%">
						<?php echo $Qcard[4]; ?>
						</td>
					</tr>
				</table>
			</div>
			<input type="hidden" id="answerquestion<?php echo $counter;?>" value="<?php echo $Qcard[5]; ?>"<?php echo $Qcard[5]; ?> >
		</form>
		
		
			</div>
			</div>
		<?php $counter = $counter+1 ;?>	
			<?php endforeach; ?>
		<br>
		
		<?php
			$styles = "position: relative;bottom: -10px;float: left;display: inline;font-size: 110%;height: 50px;width: 1135px;font-weight:normal;font-size: 110%;
			padding: 4px 18px;background:linear-gradient(rgba(4,95,248,1), rgba(4,27,159,1));border-color: #2d6324;color: #fff;
			text-shadow: rgba(0, 0, 0, 0.5) 0px -1px 0px;border:1px solid #bbb;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;
			text-decoration: none;user-select: none;";
			
			echo $this->Form->button('Next', array('id' => 'next', 'class' => 'signbutton', 'style' => $styles));
		?>
		<!--<input type="button" id='next' value="Next">-->
			
	
	
			
			<!-- <h2>Question</h2>
			<h3> <?php echo $Qcards[0][0];	?></h3>
			<?php
		
				$options = array('A1' => $Qcards[0][1], 'A2' => $Qcards[0][2], 'A3' => $Qcards[0][3], 'A4' => $Qcards[0][4]);
				$attributes = array('legend' => false);
				echo $this->Form->radio('card', $options, $attributes);
				?> -->
		
			
			
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
answers = new Object();
$('.option').change(function(){
    var answer = ($(this).attr('value'));
    var question = ($(this).attr('name'));
	var Qanswer = document.getElementById('answer'+question).value;
    answers[question] = answer;
	answers[question+'Answer'] = Qanswer;
})

var item1 = document.getElementById('questions');

var totalQuestions = $('.questions').size();
var currentQuestion = 0;

var the_sum = 0;
var count = Object.keys(answers).length/2;
var weight = 0;

$questions = $('.questions');
$questions.hide();
$($questions.get(currentQuestion)).fadeIn();
$('#next').click(function(){
    $($questions.get(currentQuestion)).fadeOut(function(){
        currentQuestion = currentQuestion + 1;
        if(currentQuestion == totalQuestions){
               //var result = sum_values()
				//do stuff with the result
				
				weight = 100/totalQuestions;
				
				for(var x = 1; x <= totalQuestions;x++)
				{
					if(answers['question'+x]==answers['question'+x+'Answer'] && answers['question'+x] != null)
					{
					the_sum += weight;
					}
							
				}
				
				the_sum = Math.round( the_sum * 10 ) / 10;
				
				if(the_sum>50)
				{
						var smallmsg = "Great Job keep it up your grade is: ";
					var mymsg = '<div class="alert alert-success">'+smallmsg+the_sum+'%'+'</div>';
				}
				else
				{
					var smallmsg = "You need to study some more your grade is: ";
			
					var mymsg = '<div class="alert alert-danger">'+smallmsg+the_sum+'%'+'</div>';
				}
				 document.getElementById('next').style.visibility = "hidden";
				 document.getElementById('content').innerHTML=mymsg;
               //alert(the_sum);
        }else{
        $($questions.get(currentQuestion)).fadeIn();
        }
    });

});
});



</script>

<br/>
		
		
<br>
		<?php
	
			if($retUrl != null)
			{
		
				echo $this->Html->link(
				'Back To Group Decks', 
				array('controller' => 'Qgroupdecks' ,'action' => 'index', $groupID),
				array( 'class' => 'signbutton', 'confirm' => 'Are you sure? Your score will not be recorded if you leave without finishing')
				);			
			}
				
				
		?>
</br>