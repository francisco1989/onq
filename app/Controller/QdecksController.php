<?php

class QdecksController extends AppController {
    public $helpers = array('Html', 'Form');
	public $uses = array('Qdeck');
	public $useTable = 'qdecks';
	
	public function index() {
	
	$this->set('qdecks', $this->Qdeck->find('all'));
	}
	
	
	
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
        $this->set('qdeck', $qdeck);
    }
	
	
	public function add(){
	if($this->request->is('post')){
		$this->Qdeck->create();
		if($this->Qdeck->save($this->request->data)){
			$this->Session->setFlash(__('Your deck has been saved.'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Unable to add your deck.'));
		}
	}
	
	
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
			debug($qdeck);
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
					$this->Session->setFlash(__('Your deck has been updated.'));
					return $this->redirect(array('action' => 'index'));
				}
				else
				{
					$this->Session->setFlash(__('Unable to update your deck.'));
				}
			}

			if (!$this->request->data) 
			{
				$this->request->data = $qdeck;
			}
		}
		
		public function delete($id) 
		{
			if ($this->request->is('get'))
			{
				throw new MethodNotAllowedException();
			}

			if ($this->Qdeck->deleteAll(array('Qdeck.deckID' => $id), false)) 
			{
				$this->Session->setFlash(
					__('Deck %s deleted.', h($id))
				);
				return $this->redirect(array('action' => 'index'));
			}
		}
	
	
		//Following actions need views
		//Each view is built up from seperate elements.
		public function addGroupDeck()
		{
			//Accept form input, add relationship from deck to group in linking table
		
		}
		
		public function addProfileDeck()
		{
			//Accept form input, add relationship from profile to deck in linking table
		
		}
		public function upvoteDeck($deckID)
		{
			//Inccrement deck rating by 1
		}
		
		public function addCardToDeck()
		{
			//Save card, add relationship from card to deck in linking table
		
		}

}

?>