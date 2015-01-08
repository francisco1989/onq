<?php
	require "./PHPMailer/PHPMailerAutoload.php";
	//require 'C:/php/PHPmailer/PHPMailerAutoload.php';
	//while(1)
	//{

		class information
		{
			// Create connection
			
			function information()
			{
			//hello mothefuckers
			}
			function getInformation()
			{
			echo "Hello World";
			//	while(1)
				//{
					date_default_timezone_set('Canada/Eastern');
					$con=mysqli_connect("localhost","onqadmin","5evetarem","studywithonq_db");

					// Check connection
					if (mysqli_connect_errno())
					{
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}else
					{
						echo "connect to database";
					}
					
					
					$result = mysqli_query($con,"SELECT * FROM emailInfo WHERE sent is NULL OR sent = 0");
					
					$prevDeckId = 0;
					echo mysqli_fetch_array($result);
					while($row = mysqli_fetch_array($result))
					{
					$counter = 0;
					echo "in while loop";
						if($prevDeckId == $row['deckID'] ||$prevDeckId == 0 )
						{
						echo "add to current array";
						echo $row['startTime'] . " " . $row['deckID']. " " . $row['cardID']. " " . $row['question'];
						echo "<br>";
						$userInfo[$counter][] = $row;
						}
						else
						{
						$counter = $counter + 1;
						$userInfo[$counter][] = $row;
							echo "start new array";
							echo $row['startTime'] . " " . $row['deckID']. " " . $row['cardID']. " " . $row['question'];
							echo "<br>";
						}
						$prevDeckId = $row['deckID'];
						
					}
						mysqli_close($con);
					$emailListCount = count($userInfo);
					echo "list count $emailListCount";
					$day = date('m/d/Y');
					
					echo "todays date is $day";
					
					echo "<br/>";
					for($x=0;$x < $emailListCount;$x++)
					{
						$notEmptyList = count($userInfo[$x][0][0]);
						if( $notEmptyList > 0)
						{
							$start = setDay($userInfo[$x][0]['startDay']);
							$end = setDay($userInfo[$x][0]['endDay']);
							$startTime = $userInfo[$x][0]['startTime'];
							$endTime = $userInfo[$x][0]['endTime'];
							$currentTime = date('H');
							echo "todays time is $currentTime";
							echo $startTime;
							echo $endTime;
							echo "<br/>";
							if($day >= $start && $day <=$end)
							{
							
								if($currentTime >= $startTime && $currentTime <=$endTime)
								{
									//spawn thread cant send mail
									echo "found a matchn<br/>";
									sendMail($userInfo[$x][0]['cardID'], $userInfo[$x][0]['question'],$userInfo[$x][0]['answer'],$userInfo[$x][0]['phoneNumber'],$userInfo[$x][0]['provider']);
									echo count($userInfo[$x][0][0]);
									echo"<br/>";
									restCards($userInfo[$x][0]['deckID']);
								}
							}
						}
					}


				//sleep(800);
				//}
			}
		}
	//}
	function setDay($day)
	{
		switch($day)
		{
			case 'monday':
			$day = 0;
			break;
			case 'tuesday':
			$day = 1;
			break;
			case 'wednesday':
			$day = 2;
			break;
			case 'thursday':
			$day = 3;
			break;
			case 'friday':
			$day = 4;
			break;
			case 'saturday':
			$day = 5;
			break;
			case 'sunday':
			$day = 6;
			break;
		
		
		}
		return $day;
	}
	//change status in db to sent
	
	
		 function sendMail($cardID, $question, $answer, $number,$provider) 
		{
			
			echo "In sendMail";
			$mail = new PHPMailer();
			$mail->IsSMTP();  // telling the class to use SMTP
			$mail->Host = 'smtp.gmail.com'; // SMTP server
			$mail->SMTPAuth = true;     // turn on SMTP authentication

			//$mail->SMTPDebug  = 2; 
			$mail->SMTPSecure = "ssl";
			$mail->Port       = 465;
			
			$mail->Username = "onqmail@gmail.com";  // SMTP username
			$mail->Password = "Capstone"; // SMTP password
			
			$mail->From = "onqmail@gmail.com";
			$concact = checkProvider($provider);
			$mail->AddAddress("$number$concact");
			echo "$number$concact";
			//echo "$number@msg.koodomobile.com";
			//$mail->AddAddress("francisco.j.granados@hotmail.com");
		//	$mail->AddAddress("5195054014@txt.bell.ca");
			$mail->Subject  = "OnQ Scheduled Study Text";
			$mail->Body     = "\n$question\n\n$answer";
			$mail->WordWrap = 50;
			$mail->SMTPDebug = 1;
			
			if(!$mail->Send()) {
				echo 'Message was not sent.';
				echo 'Mailer error: ' . $mail->ErrorInfo;
			} else {
				echo 'Message has been sent.';
				setToRead($cardID);
			}	
		}

			
		function setToRead($cardID)
		{
			$con=mysqli_connect("localhost","onqadmin","5evetarem","studywithonq_db");
			if (mysqli_connect_errno())
			  {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  }

			mysqli_query($con,"UPDATE Qcards SET sent=1
			WHERE cardID= $cardID");

			mysqli_close($con);
		
		}
		
		function restCards($dID)
		{
			
			$rID[] = 0;
			$counter = 0;
			$count = 0;
			$con=mysqli_connect("localhost","onqadmin","5evetarem","studywithonq_db");
			if (mysqli_connect_errno())
			  {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  }
			
			$result = mysqli_query($con,"SELECT c.cardID cardID, c.sent sent FROM qdeckcards s JOIN Qcards c ON c.cardID = s.cardID WHERE s.deckID = $dID;");
			mysqli_close($con);
				
					while($row = mysqli_fetch_array($result))
					{
						
						if($row['sent'] == 1)
						{
							$rID[$counter]=$row['cardID'];
						}
						$counter = $counter + 1;
					}
					$count = count($rID);
					echo "deck ids $count";
					$con=mysqli_connect("localhost","onqadmin","5evetarem","studywithonq_db");
					if($counter == $count)
					{
						for($i = 0; $i < $count; $i++)
						{
								
							 mysqli_query($con,"UPDATE Qcards SET sent=0 WHERE cardID= $rID[$i];");
						}
					
					}
					mysqli_close($con);
		
		}
		function checkProvider($provider)
		{	
			$providerDomain;
			
			switch($provider)
			{
				case rogers:
				$providerDomain = '@pcs.rogers.com';
				break;
				case fido:
				$providerDomain = '@fido.ca';
				break;
				case telus:
				$providerDomain = '@msg.telus.com';
				break;
				case bell:
				$providerDomain = '@txt.bell.ca';
				break;
				case koodo:
				$providerDomain = '@msg.koodomobile.com';
				break;
				case mts:
				$providerDomain = '@text.mtsmobility.com';
				break;
				case solo:
				$providerDomain ='@txt.bell.ca';
				break;
				case virgin:
				$providerDomain ='@vmobile.ca';
				break;
			
			
			
			}
		return $providerDomain;
		
		}
	$information = new information;
	$information->getInformation();

?>