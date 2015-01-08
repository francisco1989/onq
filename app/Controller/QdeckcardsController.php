<?php 
class QdeckcardsController extends AppController {

	public $uses = array(
        'Qprofile','Qcard','Qdeck','Qdeckcard'
    );
	
	   public function beforeFilter() 
	{
		parent::beforeFilter();
		//debug("in filter");
		$this->loadModel('Qgroup','Qprofile','Qprofilegroup','Qachievement');
		if($this->Auth->user('role')=='user')
		{
			$this->Auth->allow('view','edit','index','add','test','play','delete');//add this line for normal users
		}
		else
		{
			$this->Auth->allow('register','login');
		}
		 // Basic setup
		$this->Auth->authenticate = array('Form');

		// Pass settings in
		$this->Auth->authenticate = array(
									'Basic' => array('userModel' => 'Qgroup'),
									'Form' => array('userModel' => 'Qgroup')
		);
    }
	
	public function index($deckID,$GID=null,$returnUrl=null) {  
		$this->Qprofile->primaryKey = "profileID";
		$this->Qdeck->primaryKey = "deckID";
		$Qcards = $this->Qdeckcard->find('all',array(
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
    
		if($returnUrl != null)
		{
			$myurl = $returnUrl.'/'.$GID;
			$this->set('groupID', $GID);
		}
		else
		{
			$myurl= null;
		}
		
		$profile = $this->Qprofile->find('first', array(
										'conditions' => array('Qprofile.profileID'=> $this->Auth->user('profileID')),
										'fields' => array('Qprofile.userName')));
		
		$deck = $this->Qdeck->find('first', array(
									'conditions' => array('Qdeck.deckID'=> $deckID),
									'fields' => array('Qdeck.title')));
									
		$this->set('retUrl', $myurl);
		$this->set('Qcards', $Qcards);
		$this->set('deckID', $deckID);
		$this->set('deckName', $deck['Qdeck']['title']);
		$this->set('userID', $this->Auth->user('profileID'));
		$this->set('userName', $profile['Qprofile']['userName']);
		//debug($Qcards);
		//debug('in deckcards/index');
		//debug($deckID);
    }

	public function add($deckID) {
			if ($this->request->is('post')) {
			
			$this->Qcard->create();
            $this->Qdeckcard->create();

				if($this->Qcard->save($this->request->data))
				{
					$cardID = $this->Qcard->getLastInsertID();
					$this->request->data['Qdeckcard']['cardID'] = $cardID;
					$this->request->data['Qdeckcard']['deckID'] = $deckID;
						if($this->Qdeckcard->save($this->request->data))
						{
						
						$this->Session->setFlash( 'The card has been added', 'default', array('class' => 'alert alert-success'));
						return $this->redirect(array('action' => 'index', $deckID));
						}
						else
						{
							//debug('in deckcards/add');
							//debug($deckID);
							//debug($userID);
							//debug($this->Qdeckcard->save($this->request->data));
							//$this->Session->setFlash(__('The card has NOT been added'));
							$this->Session->setFlash( 'The card has NOT been added', 'default', array('class' => 'alert alert-danger'));
							return $this->redirect(array('action' => 'index', $deckID));
						}
				}
				else
				{
							//debug('in deckcards/add');
							//debug($deckID);
							//debug($userID);
							//debug($this->Qdeckcard->save($this->request->data));
							//$this->Session->setFlash(__('The card has NOT been added'));
							$this->Session->setFlash( 'The card has NOT been added', 'default', array('class' => 'alert alert-danger'));
							return $this->redirect(array('action' => 'index', $deckID));
				}
			}
	}
	
	
	
	
	public function delete($id,$DID=null,$UID=null){
			if ($this->request->is('get'))
			{
				throw new MethodNotAllowedException();
			}

			
				if($this->Qcard->deleteAll(array('Qcard.cardID' => $id), false))
				{
				$this->Session->setFlash('The Card with id: '.$id. ' has been deleted.','default',array('class' => 'alert alert-warning'));
					if($UID != null)
					{
						return $this->redirect(array('action' => 'index',$DID,$UID));
					}
					else
					{
					
					}
					

				}
			
	}
	
	
	
		public function edit($id = null, $DID = null, $UID = null, $returnUrl=null) 
		{
			$this->Qcard->recursive = -1;
			debug($id);
			if (!$id) 
			{
				throw new NotFoundException(__('Invalid card'));
				
			}
			if($returnUrl != null)
			{
				$myurl = $returnUrl.'/'.$GID;
				$this->set('groupID', $GID);
			}
			else
			{
				$myurl= null;
			}
			$this->set('retUrl', $myurl);
			$this->set('deckID',$DID);
			$this->set('userID',$UID);
			$qcard = $this->Qcard->find('first', array(
			'conditions' => array('Qcard.cardID'=> $id),
			'fields' => array('Qcard.cardID','Qcard.cardType','Qcard.question', 'Qcard.answer','Qcard.modified')));
				
			if (!$qcard) 
			{
				throw new NotFoundException(__('Invalid card'));
			}
			//debug($qdeck);
			if ($this->request->is(array('post', 'put'))) 
			{
			
			unset($this->request->data['Qcard']['modified']);
			$type = $this->request->data['Qcard']['cardType'];
			$question = $this->request->data['Qcard']['question'];
			$answer = $this->request->data['Qcard']['answer'];	
			$Qcard['Qcard']['cardType'] = $type;
			
			if ($this->Qcard->updateAll(array('Qcard.cardType'=>"'$type'",'Qcard.question'=>"'$question'",
			'Qcard.answer'=>"'$answer'"), array('Qcard.cardID' => $this->data['Qcard']['cardID'])))
				{
					//$this->Session->setFlash(__('Your deck has been updated.'));
					$this->Session->setFlash( 'Your Deck has been updated', 'default', array('class' => 'alert alert-success'));
					return $this->redirect(array('action' => 'index',$DID,$UID));
					//return $this->redirect($this->referer());
				}
				else
				{
					//$this->Session->setFlash(__('Unable to update your deck.'));
					$this->Session->setFlash( 'Unable to update your deck', 'default', array('class' => 'alert alert-danger'));
				}
			}

			if (!$this->request->data) 
			{
				$this->request->data = $qcard;
			}
		}
		
		
		public function view($id = null,$GID=null,$returnUrl=null) {
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
		if($returnUrl != null)
		{
			$myurl = $returnUrl.'/'.$GID;
			$this->set('groupID', $GID);
		}
		else
		{
			$myurl= null;
		}
		$this->set('retUrl', $myurl);
		//debug($qdeck);
        $this->set('qdeck', $qdeck);
    }
	
	public function play($deckID,$GID=null,$returnUrl=null) {  
		$Qcards = $this->Qdeckcard->find('all',array(
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
		
		$cardIndex = 0;

		if($returnUrl != null)
		{
			$myurl = $returnUrl.'/'.$GID;
			$this->set('groupID', $GID);
		}
		else
		{
			$myurl= null;
		}
		$this->set('retUrl', $myurl);
		$this->set('Qcards', $Qcards);
		$this->set('deckID', $deckID);
		$this->set('userID', $this->Auth->user('profileID'));
		$cardCount = count($Qcards);
		$this->set('cardCount', $cardCount);
		//debug($Qcards);
    }
	
	public function test($deckID,$GID=null,$returnUrl=null)
		{
			
			//debug($deckID);
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
				throw new NotFoundException(__('Cards do not exist'));
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
			if($returnUrl != null)
			{
				$myurl = $returnUrl.'/'.$GID;
				$this->set('groupID', $GID);
			}
			else
			{
				$myurl= null;
			}
			$this->set('retUrl', $myurl);
		}
		
		function generateTest($qcards,$cardCount)
		{
		
			
			//foreach($qcards as $qcard)
			$max = $cardCount - 1;
			$cardTest[$max] = 0;
			
			for($x = 0; $x < $cardCount; $x++)
			{	
			//debug($qcards);
			//debug($max);
			
				$Mone =-1;
				$Mtwo =-1;
				$Mthree =-1;
				$Mfour =-1;
				$multiChoice[5] = 0;
				$answerindex = mt_rand(1,$max);
				$multiChoice[0] = $qcards[$x]['Qc']['question'];
				$answer = $qcards[$x]['Qc']['answer'];
				for($i = 1; $i<5 ;$i++)
				{
					
					
					
					
					if($i == 1)
					{
						$choice1 = mt_rand(0,$max);
						$Mone = $choice1;
						$multiChoice[$i] = $qcards[$Mone]['Qc']['answer'];
						
						
					}
					else if($i == 2)
					{
						$choice1 = mt_rand(0,$max);
						if($Mone != $choice1)
						{
							
							$Mtwo= $choice1;
							$multiChoice[$i] = $qcards[$Mtwo]['Qc']['answer'];
				
						}
						else
						{
							$i=1;
						}
					}
					else if($i == 3)
					{
						$choice1 = mt_rand(0,$max);
						if($Mone != $choice1 && $Mtwo != $choice1)
						{
							$Mthree= $choice1;
							$multiChoice[$i] = $qcards[$Mthree]['Qc']['answer'];
						
						}
						else
						{
							$i=2;
						}
					}
					else if($i == 4)
					{
						$choice1 = mt_rand(0,$max);
						if($Mone != $choice1 && $Mtwo != $choice1&& $Mthree != $choice1)
						{
							$Mfour= $choice1;
							$multiChoice[$i] = $qcards[$Mfour]['Qc']['answer'];
							
						}
						else
						{
							$i=3;
						}
					}
					
				
					
					
			
					//if($multiChoice[$i] != $qcards[$choice1]['Qc']['answer'])
					//{
					//debug($multiChoice[$i]);
					//}
					
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