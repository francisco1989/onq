<?php 
/*
*	FileName: 		QgroupdecksController.php
*	Authour(s):		Fransico Granados
*	Date:			March.27.2014
*	Description:	This file contains the main logic to allow user to create, join, add cards
*					and modify decks.
*/

class QgroupdecksController extends AppController {

	public $uses = array(
        'Qdeck','Qgroup','Qgroupdeck'
    );
	    public function beforeFilter() 
	{
		parent::beforeFilter();
		//debug("in filter");
		$this->loadModel('Qgroup','Qprofile','Qprofilegroup','Qachievement','Qgroupdeck');
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
									'Basic' => array('userModel' => 'Qgroupdeck'),
									'Form' => array('userModel' => 'Qgroupdeck')
		);
    }
	//This lists all the decks that belong to the group the user clicked on
	public function index($groupID) {  
    $this->Qgroup->primaryKey = "groupID";
	$this->Qgroupdeck->recursive = -1;
	 //retrive cards from the database associated with this group
	$Qdecks =	   $this->Qgroupdeck->find('all',array(
	 'joins' => array(
        array(
            'table' => 'Qdecks',
            'type' => 'INNER',
			'alias' => 'Qd',
            'conditions' => array(
                'Qd.deckID = Qgroupdeck.deckID'
            )
        )
    ),
    'conditions' => array(
        'Qgroupdeck.groupID' => $groupID
    ),
    'fields' => array('Qd.*','Qgroupdeck.*')
	));
    
	$group = $this->Qgroup->find('first', array(
									'conditions' => array('Qgroup.groupID'=> $groupID),
									'fields' => array('Qgroup.groupTitle')));

	$this->set('groupName', $group['Qgroup']['groupTitle']);
    $this->set('Qdecks', $Qdecks);
    $this->set('groupID', $groupID);
    $this->set('returnUrl', 'Qgroupdecks');
    //debug($this->params['controller']);
    //debug('in groupdecks/index');
    //debug($Qdecks);
    //debug($groupID);
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
		$tmp1 = mysqli_fetch_array($highscore);
		$tmp1 = $tmp1['MAX(gameTime)'];
		
		$highname = mysqli_query($con,"SELECT userName FROM highscores WHERE deckID = ".$id." AND gameTime = ".$tmp1.";");
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
	public function add($groupID) {
			if ($this->request->is('post')) {
       
            $this->Qgroupdeck->create();
			//debug( 'adding');
			$this->request->data['Qgroupdeck']['groupID'] = $groupID;
			
			//save group to database
            if ($this->Qgroupdeck->saveAll($this->request->data, array('deep' => true))) {
               //$this->Session->setFlash(__('The deck has been created'));
				$this->Session->setFlash( 'The deck has been created', 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index',$groupID));
            }
            //$this->Session->setFlash( __('The deck could not be created. Please, try again.'));
			$this->Session->setFlash( 'The deck could not be created', 'default', array('class' => 'alert alert-danger'));
			} 
			
			$this->set('groupID', $groupID);
	}

	//Delete a deck for this user TO DO: delete cards associated with the deck.
	public function delete($deckID, $groupID){
			if ($this->request->is('get'))
			{
				throw new MethodNotAllowedException();
			}

			if ($this->Qgroupdeck->deleteAll(array('Qgroupdeck.deckID' => $deckID), false)) 
			{
				if($this->Qdeck->deleteAll(array('Qdeck.deckID' => $deckID), false))
				{
					$this->Session->setFlash('The Deck with id: '.$deckID. ' has been deleted.','default',array('class' => 'alert alert-warning'));
					return $this->redirect(array('action' => 'index', $groupID));
				}
			}
	}	
	
	//Edit a users deck.
	public function edit($id = null, $groupID) 
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
				return $this->redirect(array('action' => 'index', $groupID));
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
		
		$this->set('groupID', $groupID);
	}
	
}
?>