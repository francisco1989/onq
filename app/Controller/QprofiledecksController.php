<?php 
class QprofiledecksController extends AppController {

	public $uses = array(
        'Qdeck','Qprofile','Qprofiledeck','Qschedule'
    );
	 public function beforeFilter() 
	{
		parent::beforeFilter();
		//debug("in filter");
		$this->loadModel('Qgroup','Qprofile','Qprofilegroup','Qachievement','Qschedule');
		if($this->Auth->user('role')=='user')
		{
			$this->Auth->allow('view','edit','index','add','schedule','test','startGame','delete');//add this line for normal users
		}
		else
		{
			$this->Auth->allow('register','login');
		}
		 // Basic setup
		$this->Auth->authenticate = array('Form');

		// Pass settings in
		$this->Auth->authenticate = array(
									'Basic' => array('userModel' => 'Qdeck'),
									'Form' => array('userModel' => 'Qdeck')
		);
    }
	//This lists all the decks that belong to the user that is logged in
	public function index() {  
       
		$this->Qprofiledeck->recursive = -1;
		  
		$Qdecks = $this->Qprofiledeck->find('all',array(
		 'joins' => array(
			array(
				'table' => 'Qdecks',
				'type' => 'INNER',
				'alias' => 'Qd',
				'conditions' => array(
					'Qd.deckID = Qprofiledeck.deckID'
				)
			)
		),
		'conditions' => array(
			'Qprofiledeck.profileID' => $this->Auth->user('profileID')
		),
		'fields' => array('Qd.*','Qprofiledeck.*')
		));
    

	   $this->set('Qdecks', $Qdecks);
	   $this->set('userID', $this->Auth->user('profileID'));
	  
		
    }

	public function startGame($id = null)
	{
		$this->autoRender = false;
		
		if (!$id) 
		{
			throw new NotFoundException(__('Invalid deck'));
		}
		
		// Create connection
		$con=mysqli_connect("localhost","onqadmin","5evetarem","studywithonq_db");

		// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$stringResult = "|" . $id;
		
		$highscore = mysqli_query($con,"SELECT MAX(gameTime) FROM highscores WHERE deckID = ".$id.";");
		debug($highscore);
		$tmp1 = mysqli_fetch_array($highscore);
		$tmp1 = $tmp1['MAX(gameTime)'];
		
		$highname = mysqli_query($con,"SELECT userName FROM highscores WHERE deckID = ".$id." AND gameTime = ".$tmp1.";");
		debug($highname);
		$tmp2 = mysqli_fetch_array($highname);
		$tmp2 = $tmp2['userName'];
		
		$stringResult = $stringResult . "|" . $tmp2 . "|" . $tmp1;
		
		$result = mysqli_query($con,"SELECT * FROM deckInfo WHERE deckID = ".$id.";");
		while($row = mysqli_fetch_array($result))
		{
			//echo $row['question'];
			$a = $row['question'];
			$b = $row['answer'];
			$stringResult = $stringResult . "|" . $a . "|" . $b;
		}
		
		//close connection
		mysqli_close($con);
		
		$this->redirect($this->webroot.'../Games/Builds.php?test='.$stringResult);
	}
	
	//Create new deck for the user that is logged in
	public function add() {
			if ($this->request->is('post')) {
       
            $this->Qprofiledeck->create();
			//$this->Qschedule->create();
			//debug( 'adding');
			$this->request->data['Qprofiledeck']['profileID'] = $this->Auth->user('profileID');
			//$this->request->data['Qschedule']['intervals'] = 15;
		
			//if($this->Qschedule->save($this->request->data['Qschedule']))
			
            if ($this->Qprofiledeck->saveAll($this->request->data, array('deep' => true))) {
				
                //$this->Session->setFlash(__('The deck has been created'));
				$this->Session->setFlash( 'The deck has been created', 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
				
            
			}
            //$this->Session->setFlash(__('The deck could not be created. Please, try again.');
			$this->Session->setFlash( 'The deck could not be created', 'default', array('class' => 'alert alert-danger'));
			} 
	}
	
	
	//Delete a deck for this user TO DO: delete cards associated with the deck.
	public function delete($id){
			if ($this->request->is('get'))
			{
				throw new MethodNotAllowedException();
			}

			if ($this->Qprofiledeck->deleteAll(array('Qprofiledeck.deckID' => $id), false)) 
			{
				if($this->Qdeck->deleteAll(array('Qdeck.deckID' => $id), false))
				{
			
				$this->Session->setFlash('The Deck with id: '.$id. ' has been deleted.','default',array('class' => 'alert alert-warning'));
				return $this->redirect(array('action' => 'index'));
				}
			}
	}
	
	
	
		//Edit a users deck.
		public function edit($id = null) 
		{
			$this->Qdeck->recursive = -1;
			if (!$id) 
			{
				throw new NotFoundException(__('Invalid deck'));
			}

			$qdeck = $this->Qdeck->find('first', array(
			'conditions' => array('Qdeck.deckID'=> $id),
			'fields' => array('Qdeck.deckID', 'Qdeck.deckType', 'Qdeck.title', 'Qdeck.description','Qdeck.rating','Qdeck.privatePublic', 'Qdeck.modified')));
				
			if (!$qdeck) 
			{
				throw new NotFoundException(__('Invalid deck'));
			}
			//debug($qdeck);
			if ($this->request->is(array('post', 'put'))) 
			{
			
			unset($this->request->data['Qdeck']['modified']);
			$type = $this->request->data['Qdeck']['deckType'];
			$title = $this->request->data['Qdeck']['title'];
			$description = $this->request->data['Qdeck']['description'];
			$private = $this->request->data['Qdeck']['privatePublic'];	
			$Qdeck['Qdeck']['deckType'] = $type;
			
			if ($this->Qdeck->updateAll(array('Qdeck.deckType'=>"'$type'",'Qdeck.title'=>"'$title'",
			'Qdeck.description'=>"'$description'",'Qdeck.privatePublic'=>"'$private'"), array('Qdeck.deckID' => $this->data['Qdeck']['deckID'])))
				{
					//$this->Session->setFlash(__('Your deck has been updated.'));
					$this->Session->setFlash( 'Your deck has been updated', 'default', array('class' => 'alert alert-success'));
					return $this->redirect(array('action' => 'index'));
				}
				else
				{
					//$this->Session->setFlash(__('Unable to update your deck.'));
					$this->Session->setFlash( 'Unable to update your deck', 'default', array('class' => 'alert alert-danger'));
				}
			}

			if (!$this->request->data) 
			{
				$this->request->data = $qdeck;
			}
		}
		
		
		//View the details about the deck selected
		public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid deck'));
        }

		$this->Qdeck->recursive = -1;
        $qdeck = $this->Qdeck->find('first', array(
		'conditions' => array('Qdeck.deckID'=> $id),
		'fields' => array('Qdeck.deckID', 'Qdeck.deckType', 'Qdeck.title', 'Qdeck.description','Qdeck.rating','Qdeck.privatePublic','Qdeck.created','Qdeck.modified')));
        if (!$qdeck) {
            throw new NotFoundException(__('Deck does not exist'));
        }
		
		//debug($qdeck);
        $this->set('qdeck', $qdeck);
    }
	
		public function schedule($id = null,$pid = null) {
        
		$time;
		$interval;
		$val = 15;
		
		$qschedule = $this->Qschedule->find('first', array(
			'conditions' => array('Qschedule.deckID'=> $id),
			'fields' => array('Qschedule.deckID', 'Qschedule.startDay', 'Qschedule.endDay', 'Qschedule.startTime','Qschedule.endTime','Qschedule.intervals')));
				
		$c = 1;
		for($i = 1; $i <= 24; $i++)
		{
		
			if($i <= 12)
			{
			$time[$i] = "$i:00 AM";	
			}
			else
			{
			$time[$i] = "$c:00 PM";	
			$c=$c+1;
			}
		}
		
		for($i = 0; $i <= 2; $i++)
		{
			$interval[$i] = $val;
			$val += 15;
		}
		//debug($qschedule);
		$this->set('time', $time);
		$this->set('interval', $interval);
		//debug($id);
		if($qschedule == null)
		{
			$this->Qschedule->create();
			if ($this->request->is('post')) {
       
				$this->Qschedule->create();
				//$this->Qschedule->create();
		
				$this->request->data['Qschedule']['deckID'] = $id;
				$this->request->data['Qschedule']['profileID'] = $pid;
				//$this->request->data['Qschedule']['intervals'] = 15;
		
				//if($this->Qschedule->save($this->request->data['Qschedule']))
			
				if ($this->Qschedule->saveAll($this->request->data, array('deep' => true))) {
				
					//$this->Session->setFlash(__('The schedule has been created'));
					$this->Session->setFlash( 'The schedule has been created', 'default', array('class' => 'alert alert-success'));
					return $this->redirect(array('action' => 'index'));
				
            
				}
				//$this->Session->setFlash( __('The schedule could not be created. Please, try again.'));
				$this->Session->setFlash( 'The schedule could not be created. Please, try again', 'default', array('class' => 'alert alert-danger'));
			} 
			//debug("new schedule");
		}
		else
		{
			//debug("update schedule");
			if ($this->request->is(array('post', 'put'))) 
			{
			
			
			$startd = $this->request->data['datepicker'];
			$endd = $this->request->data['datepick'];
			$startt = $this->request->data['Qschedule']['startTime'];
			$endt = $this->request->data['Qschedule']['endTime'];	
			$interval = $this->request->data['Qschedule']['intervals'];
			$provider = $this->request->data['Qschedule']['provider'];			
			
			if ($this->Qschedule->updateAll(array('Qschedule.startDay'=>"'$startd'",'Qschedule.endDay'=>"'$endd'",
			'Qschedule.startTime'=>"'$startt'",'Qschedule.endTime'=>"'$endt'",'Qschedule.intervals'=>"'$interval'",'Qschedule.provider'=>"'$provider'"), array('Qschedule.deckID' => $id)))
				{
				//	$this->Session->setFlash(__('Your deck has been updated.'));
					$this->Session->setFlash( 'Your schedule has been created', 'default', array('class' => 'alert alert-success'));
					//return $this->redirect(array('action' => 'index'));
				}
				else
				{
					//$this->Session->setFlash(__('Unable to update your deck.'));
					$this->Session->setFlash( 'Cannot Set up your schedule', 'default', array('class' => 'alert alert-danger'));
				}
			}
		
		}
		
    }
	
	public function test($deckID)
		{
			
			debug($deckID);
			 if (!$deckID) {
				throw new NotFoundException(__('Invalid card'));
			}
			
			
			$qcards = $this->Qdeckcard->find('all',array(
			 'joins' => array(
				array(
					'table' => 'Qcards',
					'type' => 'INNER',
					'alias' => 'Qc',
					'conditions' => array(
						'Qc.cardID = Qdeckcard.cardID'
					)
				)
			),
			'conditions' => array(
				'Qdeckcard.deckID' => $deckID
			),
			'fields' => array('Qc.*','Qdeckcard.*')
			));
	
			
			
			if (!$qcards) {
				throw new NotFoundException(__('Card does not exist'));
			}
			$cardCount = count($qcards);
			if($cardCount >= 4){
			
			$multiChoice = $this->generateTest($qcards,$cardCount);
			//debug($qcards);
			//debug($multiChoice);
			$this->set('Qcards', $multiChoice);
			}
			else
			{
				throw new NotFoundException(__('Not enough cards in the deck'));
			
			}
		}
		
		function generateTest($qcards,$cardCount)
		{
		
			
			//foreach($qcards as $qcard)
			$max = $cardCount - 1;
			$cardTest[$max] = 0;
			
			for($x = 0; $x < $cardCount; $x++)
			{	
		//	debug($x);
			//debug($max);
				$multiChoice[5] = 0;
				$answerindex = mt_rand(1,$max);
				$multiChoice[0] = $qcards[$x]['Qc']['question'];
				$answer = $qcards[$x]['Qc']['answer'];
				for($i = 1; $i<5 ;$i++)
				{
					
					$choice1 = mt_rand(0,$max);
					
					$multiChoice[$i] = $qcards[$choice1]['Qc']['answer'];
					
					
				}
				$multiChoice[$answerindex]= $answer;
				$multiChoice[5] = $answer;
			/*	$multiChoice[0] = $qcards[0]['Qc']['question'];
				$multiChoice[1] = $qcards[0]['Qc']['answer'];
				$multiChoice[2] = $qcards[$choice1]['Qc']['answer'];
				$multiChoice[3] = $qcards[$choice2]['Qc']['answer'];
				$multiChoice[4] = $qcards[$choice3]['Qc']['answer'];*/
				//debug($multiChoice);
				$cardTest[$x] = $multiChoice;
				
			
			}
			
			

		
			return $cardTest;
		}
	
	
	
}
?>