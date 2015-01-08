<?php 
/*
 *  Project : OnQ
 *  File : QMobileController.php
 *  Author : Francis Kurevija
 *  Created : February 16, 2014
 *  Last Modiied : February 18, 2014
 *  Description : QMobileController is the controller class that handles the OnQ mobile app RESTful APIs for pulling
 *					a users decks from the database and adding decks that users receive through bumping decks
 */

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class QmobileController extends AppController
{	
	public function beforeFilter()
	{
		$this->Auth->allow('login','pullDecks', 'uploadDecks');
		parent::beforeFilter();
	}
	
	//Models being used by the controller
	public $uses = array(
        'Qprofile','Qprofiledecks','Qdecks','Qdeckcards','Qcards'
    );
	
	/* ---------------------------------------------------------------------------------------
		*	Name	:   QMobileController -- download
		*
		*	Purpose :   This function allows a user to download the OnQ.apk (Android app) from
		*				the OnQ server (app is not currently in the Google Play store)
		*	Inputs	:	None
		*	Outputs	:	None
		*	Returns	:	OnQ.apk (Android app)
	----------------------------------------------------------------------------------------*/
	public function download()
	{
		$this->autoRender = false; //Tells the controller not to user a view (no view, as this is just a service API)
		
		$path = "../Downloadable/";
		$file = "OnQ.apk";
		if (file_exists($path.$file)) //If we have made the APK file available for download
		{
			header("Content-type: ".filetype($file));
			header('Content-disposition: attachment; filename="'.$file.'"');
			return file_get_contents($path.$file);
		}
		else
		{
			return "These are not the files you're looking for...";
		}
	}
	
	/* ---------------------------------------------------------------------------------------
		*	Name	:   QMobileController -- login
		*
		*	Purpose :   This function connects a users mobile app to OnQ, it then assigns their
		*				app a unique security token to be passed as an argument to uploadDecks
		*	Inputs	:	$userName - username that decks and cards are being requested for
		*				$password - used to authenticate the user when they try to pull decks/cards
		*	Outputs	:	None
		*	Returns	:	JSON string with users decks or an error message if an error occurred
	----------------------------------------------------------------------------------------*/
	public function login($userName, $password)
	{
		$this->autoRender = false; //Tells the controller not to user a view (no view, as this is just a service API)
	
		//If a user name and password have been passed with the request
		if ($userName != null && $password != null)
		{
			$passwordHasher = new SimplePasswordHasher();
			$password = $passwordHasher->hash($password); //Hashes the password for comparison with the users password in the database
			
			//Find the profile that matches the passed in username
			$profile = $this->Qprofile->find('first', array(
											'conditions' => array('Qprofile.userName'=> $userName),
											'fields' => array('Qprofile.profileID', 'Qprofile.userName', 'Qprofile.password',
															'Qprofile.emailAddress', 'Qprofile.dateOfBirth', 'Qprofile.dateCreated')));
			
			//If a profile was not found
			if (!$profile)
			{
				$error[0] = 'Error';
				$error[1] = 'You are not a registered user of OnQ';
				return json_encode((object)$error); //Return a JSON string notifying the user of the error
			}
			
			//If the password passed in does not match the password of the profile in the database
			if ($password != $profile['Qprofile']['password'])
			{
				$error[0] = 'Error';
				$error[1] = 'Invalid password';
				return json_encode((object)$error); //Return a JSON string notifying the user of the error
			}
			
			/*
			*	User exists and has provided the correct password, generate their unique security token
			*/
			
			//Return profileID | userName | password | emailAddress | password | dob | dateCreated
			$token[0] = 'SecurityToken';
			$token[1] = $profile['Qprofile']['profileID'] | $profile['Qprofile']['userName'] | $profile['Qprofile']['password'] |
						$profile['Qprofile']['emailAddress'] | $profile['Qprofile']['dateOfBirth'] | $profile['Qprofile']['dateCreated'];
			
			//Returns auth token to be held in app stored preferences
			return json_encode((object)$token); //Return the JSON string that represents security token for the users app
		}
		else
		{
			$error[0] = 'Error';
			$error[1] = 'Missing username or password';
			return json_encode((object)$error); //Return a JSON string notifying the user of the error
		}
	}
	
	/* ---------------------------------------------------------------------------------------
		*	Name	:   QMobileController -- pullDecks
		*
		*	Purpose :   This function returns a users decks/cards to their mobile app after
		*				they are authenticated
		*	Inputs	:	$userName - username that decks and cards are being requested for
		*				$password - used to authenticate the user when they try to pull decks/cards
		*	Outputs	:	None
		*	Returns	:	JSON string with users decks or an error message if an error occurred
	----------------------------------------------------------------------------------------*/
    public function pullDecks($userName, $password)
	{
		$this->autoRender = false; //Tells the controller not to user a view (no view, as this is just a service API)
		
		//If a user name and password have been passed with the request
		if ($userName != null && $password != null)
		{
			$passwordHasher = new SimplePasswordHasher();
			$password = $passwordHasher->hash($password); //Hashes the password for comparison with the users password in the database
			
			//Find the profile that matches the passed in username
			$profile = $this->Qprofile->find('first', array(
											'conditions' => array('Qprofile.userName'=> $userName),
											'fields' => array('Qprofile.profileID', 'Qprofile.userName', 'Qprofile.password')));
			
			//If a profile was not found
			if (!$profile)
			{
				$error[0] = 'Error';
				$error[1] = 'You are not a registered user of OnQ';
				return json_encode((object)$error); //Return a JSON string notifying the user of the error
			}
			
			//If the password passed in does not match the password of the profile in the database
			if ($password != $profile['Qprofile']['password'])
			{
				$error[0] = 'Error';
				$error[1] = 'Invalid password';
				return json_encode((object)$error); //Return a JSON string notifying the user of the error
			}
			
			/*
			*	Start fishing out users decks/cards from the database
			*/
			
			//Get the IDs of all the decks that are associated with the users profile
			$deckIDs = $this->Qprofiledecks->query("SELECT deckID FROM Qprofiledecks WHERE profileID=".$profile['Qprofile']['profileID'].";");
			
			$decks = array(); //Array of decks
			
			//For each deck by ID
			for ($x = 0; $x < count($deckIDs); ++$x)
			{
				//Grab the deck from the database that matches the current deckID
				$tmp = $this->Qdecks->query("SELECT * FROM Qdecks WHERE deckID=".$deckIDs[$x]['Qprofiledecks']['deckID'].";");
				$decks[$x] = (object) $tmp[0]['Qdecks'];
				
				//Get IDs of all the cards associated with the current deck
				$cardIDs = $this->Qdeckcards->query("SELECT cardID FROM qdeckcards WHERE deckID=".$decks[$x]->deckID.";");
				
				$decks[$x]->Qdeckcards = array(); //New array to hold cards found for the current deck
				
				//For each card by ID in the current deck
				for ($y = 0; $y < count($cardIDs); ++$y)
				{
					//Grab the card from the database that matches the current cardID
					$tmp = $this->Qcards->query("SELECT * FROM Qcards WHERE cardID=".$cardIDs[$y]['qdeckcards']['cardID'].";");
					
					$decks[$x]->Qdeckcards[$y] = (object) $tmp[0]['Qcards'];
				}
			}
			return json_encode($decks);; //Return the JSON string that represents the decks and cards found for the user
		}
		else
		{
			$error[0] = 'Error';
			$error[1] = 'Missing username or password';
			return json_encode((object)$error); //Return a JSON string notifying the user of the error
		}
    }

	/* ---------------------------------------------------------------------------------------
		*	Name	:   QMobileController -- uploadDecks
		*
		*	Purpose :   This function returns allows a user to push new decks obtained through
						Bump in the mobile app to their collection in the database
		*	Inputs	:	$userName - username that decks and cards are being requested for
		*				$password - used to authenticate the user when they try to pull decks/cards
		*				$authToken - unique security token from users app
		*				$jsonDecks (passed in the URL) - decks to be added to the database (as JSON string)
		*	Outputs	:	None
		*	Returns	:	JSON string containing success or error message
	----------------------------------------------------------------------------------------*/
    public function uploadDecks($userName, $password, $authToken)
	{
		$this->autoRender = false; //Tells the controller not to user a view (no view, as this is just a service API)
		$this->Qprofile->primaryKey = "profileID";
		$this->Qdecks->primaryKey = "deckID";
		$this->Qcards->primaryKey = "cardID";
		
		//If a user name and password have been passed with the request
		if ($userName != null && $password != null)
		{
			$passwordHasher = new SimplePasswordHasher();
			$password = $passwordHasher->hash($password); //Hashes the password for comparison with the users password in the database
			
			//Find the profile that matches the passed in username
			$profile = $this->Qprofile->find('first', array(
											'conditions' => array('Qprofile.userName'=> $userName),
											'fields' => array('Qprofile.profileID', 'Qprofile.userName', 'Qprofile.password',
															'Qprofile.emailAddress', 'Qprofile.dateOfBirth', 'Qprofile.dateCreated')));
			
			//If a profile was not found
			if (!$profile)
			{
				$error[0] = 'Error';
				$error[1] = 'You are not a registered user of OnQ';
				return json_encode((object)$error); //Return a JSON string notifying the user of the error
			}
			
			//If the password passed in does not match the password of the profile in the database
			if ($password != $profile['Qprofile']['password'])
			{
				$error[0] = 'Error';
				$error[1] = 'Invalid password';
				return json_encode((object)$error); //Return a JSON string notifying the user of the error
			}
			
			/*
			*	User exists and has provided the correct password, authenticate their unique security token
			*/
			
			if (!$authToken)
			{
				$error[0] = 'Error';
				$error[1] = 'User not previously signed into the OnQ mobile app';
				return json_encode((object)$error); //Return a JSON string notifying the user of the error
			}
			
			$tmp = explode('+', urlencode($authToken));
			$authToken = '';
			
			foreach ($tmp as $ascii)
			{
				$authToken .= chr($ascii);
			}
			
			$generatedToken = $profile['Qprofile']['profileID'] | $profile['Qprofile']['userName'] | $profile['Qprofile']['password'] |
							$profile['Qprofile']['emailAddress'] | $profile['Qprofile']['dateOfBirth'] | $profile['Qprofile']['dateCreated'];

			if ($authToken !== $generatedToken)
			{
				$error[0] = 'Error';
				$error[1] = 'Invalid security token';
				return json_encode((object)$error); //Return a JSON string notifying the user of the error
			}
			
			//Only way to parse out JSON string containing decks, all other methods corrupt string
			$urlPieces = explode('/', $this->request->url);
			$decksPos = 5;
			
			//If there are decks to be processed
			if (!$urlPieces[$decksPos])
			{
				$error[0] = 'Error';
				$error[1] = 'There are no decks to add';
				return json_encode((object)$error); //Return a JSON string notifying the user of the error
			}
			$decks = json_decode(urldecode($urlPieces[$decksPos]));
			
			/*
			*	Start parsing JSON object of decks, check if they exist
			*	in the database and insert the ones that don't
			*/
			$result[0] = 'Success';
			$result[1] = '';
			
			//debug($this->Qprofiledecks);
			
			//while(false)
			for ($x = 0; $x < count($decks); ++$x)
			{
				//Check if the deck exists in the database
				$deck = $this->Qdecks->query("SELECT * FROM Qdecks WHERE deckID=".$decks[$x]->deckID.";");
				
				//If the deck is not in the database
				if (!$deck)
				{
					//Manually create a query to insert the deck (because CakePHP's conventions are poorly designed... *sadface*)
					$this->Qdecks->query("INSERT INTO Qdecks (deckID, deckType, title, description, privatePublic)
										VALUES ('".$decks[$x]->deckID."', '".$decks[$x]->deckType."', '".$decks[$x]->title."', '".$decks[$x]->description."', '".$decks[$x]->privatePublic."');");
										
					//Manually create a query to check if the deck was inserted (because CakePHP's conventions are poorly designed... *sadface*)
					if(!$this->Qdecks->query("SELECT * FROM Qdecks WHERE deckID=".$decks[$x]->deckID.";"))
					{
						$result[0] = 'Failure';
						$result[1] .= 'Failure to add '.$decks[$x]->title.' to the database. ';
					}
				}
				
				//Check if the deck is in the user's decks in the database
				$pDeck = $this->Qprofiledecks->query("SELECT * FROM Qprofiledecks WHERE deckID=".$decks[$x]->deckID.
																				" AND profileID=".$profile['Qprofile']['profileID'].";");
				
				//If the deck is not in the database
				if (!$pDeck)
				{
					//Manually create a query to link the deck to the profile (because CakePHP's conventions are poorly designed... *sadface*)
					$this->Qprofiledecks->query("INSERT INTO Qprofiledecks (profileID, deckID)
												VALUES ('".$profile['Qprofile']['profileID']."', '".$decks[$x]->deckID."');");
										
					//Manually create a query to check if the deck linked to the profile (because CakePHP's conventions are poorly designed... *sadface*)
					if(!$this->Qprofiledecks->query("SELECT * FROM Qprofiledecks WHERE deckID=".$decks[$x]->deckID." AND profileID=".$profile['Qprofile']['profileID'].";"))
					{
						$result[0] = 'Failure';
						$result[1] .= 'Failure to add '.$decks[$x]->title.' to '.$profile['Qprofile']['userName']."'s decks. ";
					}
				}
				
				for ($y = 0; $y < count($decks[$x]->Qdeckcards); ++$y)
				{
					//Check if the card exists in the database
					$card = $this->Qcards->query("SELECT * FROM Qcards WHERE cardID=".$decks[$x]->Qdeckcards[$y]->cardID.";");
					
					//If the deck is not in the database
					if (!$card)
					{
						//Manually create a query to insert the card (because CakePHP's conventions are poorly designed... *sadface*)
						$this->Qcards->query("INSERT INTO Qcards (cardID, cardType, question, answer)
										VALUES ('".$decks[$x]->Qdeckcards[$y]->cardID."', '".$decks[$x]->Qdeckcards[$y]->cardType."', '".
										$decks[$x]->Qdeckcards[$y]->question."', '".$decks[$x]->Qdeckcards[$y]->answer."');");
										
						//Manually create a query to check if the card was inserted (because CakePHP's conventions are poorly designed... *sadface*)
						if(!$this->Qcards->query("SELECT * FROM Qcards WHERE cardID=".$decks[$x]->Qdeckcards[$y]->cardID.";"))
						{
							$result[0] = 'Failure';
							$result[1] .= 'Failure to add '.$decks[$x]->Qdeckcards[$y]->question.' to the database. ';
						}
					}
					
					//Check if the card exists in the current deck
					$deckcard = $this->Qdeckcards->query("SELECT * FROM qdeckcards WHERE deckID=".$decks[$x]->deckID.
																					" AND cardID=".$decks[$x]->Qdeckcards[$y]->cardID.";");
					
					//If the card is not in the current deck
					if (!$deckcard)
					{
						//Manually create a query to link the card to the deck (because CakePHP's conventions are poorly designed... *sadface*)
						$this->Qdeckcards->query("INSERT INTO qdeckcards (deckID, cardID)
													VALUES ('".$decks[$x]->deckID."', '".$decks[$x]->Qdeckcards[$y]->cardID."');");
										
						//Manually create a query to check if the card linked to the deck (because CakePHP's conventions are poorly designed... *sadface*)
						if(!$this->Qdeckcards->query("SELECT * FROM qdeckcards WHERE deckID=".$decks[$x]->deckID." AND cardID=".$decks[$x]->Qdeckcards[$y]->cardID.";"))
						{
							$result[0] = 'Failure';
							$result[1] .= 'Failure to add '.$decks[$x]->Qdeckcards[$y]->question.' to '.$decks[$x]->title.' deck. ';
						}
					}
				}
			}
			if ($result[0] == 'Success')
			{
				$result[1] = 'All decks successfully added';
			}
			return json_encode((object)$result); //Return a JSON string notifying the user of the result of the upload
		}
		else
		{
			$error[0] = 'Error';
			$error[1] = 'Missing username, password, or security token';
			return json_encode((object)$error); //Return a JSON string notifying the user of the error
		}
    }
}
?>