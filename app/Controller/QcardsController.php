<?php

class QcardsController extends AppController {
    public $helpers = array('Html', 'Form');
	public $uses = array('Qcard');
	public $useTable = 'qcards';
	
	public function index() {
	
	$this->set('qcards', $this->Qcard->find('all'));
	}
	
	
	
	public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid card'));
        }

		$this->Qcard->recursive = -1;
        $qcard = $this->Qcard->find('first', array(
		'conditions' => array('Qcard.cardID'=> $id),
		'fields' => array('Qcard.cardID', 'Qcard.cardType', 'Qcard.question', 'Qcard.answer')));
        if (!$qcard) {
            throw new NotFoundException(__('Card does not exist'));
        }
		debug($qcard);
        $this->set('qcard', $qcard);
    }
	
	
	public function add(){
	if($this->request->is('post')){
		$this->Qcard->create();
		if($this->Qcard->save($this->request->data)){
			$this->Session->setFlash(__('Your card has been saved.'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Unable to add your card.'));
		}
	}
	
	
		public function edit($id = null) 
		{
			$this->Qcard->recursive = -1;
			if (!$id) 
			{
				throw new NotFoundException(__('Invalid card'));
			}

			$qcard = $this->Qcard->find('first', array(
			'conditions' => array('Qcard.cardID'=> $id),
			'fields' => array('Qcard.cardID', 'Qcard.cardType', 'Qcard.question', 'Qcard.answer')));
				
			if (!$qcard) 
			{
				throw new NotFoundException(__('Invalid card'));
			}
			debug($qcard);
			if ($this->request->is(array('post', 'put'))) 
			{
			
			$type = $this->request->data['Qcard']['cardType'];
			$question = $this->request->data['Qcard']['question'];
			$answer = $this->request->data['Qcard']['answer'];
			$Qdeck['Qcard']['cardType'] = $type;
			
			if ($this->Qcard->updateAll(array('Qcard.cardType'=>"'$type'",'Qcard.question'=>"'$question'",
			'Qcard.answer'=>"'$answer'"), array('Qcard.cardID' => $this->data['Qcard']['cardID'])))
				{
					$this->Session->setFlash(__('Your card has been updated.'));
					return $this->redirect(array('action' => 'index'));
				}
				else
				{
					$this->Session->setFlash(__('Unable to update your card.'));
				}
			}

			if (!$this->request->data) 
			{
				$this->request->data = $qcard;
			}
		}
		
		public function delete($id) 
		{
			if ($this->request->is('get'))
			{
				throw new MethodNotAllowedException();
			}

			if ($this->Qcard->deleteAll(array('Qcard.cardID' => $id), false)) 
			{
				$this->Session->setFlash(
					__('Card %s deleted.', h($id))
				);
				return $this->redirect(array('action' => 'index'));
			}
		}
		
		public function test($dID)
		{
			
			
			 if (!$id) {
				throw new NotFoundException(__('Invalid card'));
			}

			$this->Qcard->recursive = -1;
			$qcard = $this->Qcard->find('first', array(
			'conditions' => array('Qcard.cardID'=> $id),
			'fields' => array('Qcard.cardID', 'Qcard.cardType', 'Qcard.question', 'Qcard.answer')));
			if (!$qcard) {
				throw new NotFoundException(__('Card does not exist'));
			}
			$cardCount = count($qcard);
			if($cardCount > 4){
			debug($qcard);
			$this->set('qcard', $qcard);
			}
			else
			{
				throw new NotFoundException(__('Not enough cards in the deck'));
			
			}
		}
}

?>