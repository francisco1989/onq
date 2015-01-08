<?php 
class QAchievementsController extends AppController {

	public $uses = array(
        'Qprofile','Qachievement'
    );
	
    public function beforeFilter() 
	{
		parent::beforeFilter();
		//debug("in filter");
		
		$this->loadModel('Qprofile','Qachievement');
		/****************************************************************************************************************
		*	No one is allowed to access QAchievementsController while the feature is not included in the application	*
		****************************************************************************************************************/
		/* if($this->Auth->user('role')=='user' || $this->Auth->user('role')=='admin')
		{
			$this->set('role', $this->Auth->user('role')); 
			$this->Auth->allow('index','logout');//add this line for normal users
		}
		else
		{
			$this->Auth->allow('register','login');
		}
		
		 // Basic setup
		$this->Auth->authenticate = array('Form');

		// Pass settings in
		$this->Auth->authenticate = array(
									'Basic' => array('userModel' => 'Qprofile'),
									'Form' => array('userModel' => 'Qprofile')
		); */
		$this->redirect($this->webroot);
    }
	
	

	
	
/*	public function index() 
	{
		//debug($theName);
		$this->set('qprofile', $this->paginate());
		//logout button
		if ($this->request->is('post')) 
		{
			return $this->redirect($this->Auth->logout());
		}
	}*/
	
	public function add() 
	{
        if ($this->request->is('post')) 
		{
            $this->Qprofile->create();
			debug($this->Qprofile->create());
			$timezone = date_default_timezone_get();
			date_default_timezone_set($timezone);
			$date = date('Y-m-d H:i:s');
			$this->request->data['Qprofile']['dateCreated'] = $date;
			
            if ($this->Qprofile->save($this->request->data)) 
			{
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'login'));
            }
			else
			{
				debug($this->Qprofile->save($this->request->data));
				debug($this->Stock->validationErrors);
			}
				
			$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
    }
	
	public function register()
	{
		if ($this->request->is('post')) 
		{
			debug("in register");
            $this->Qprofile->create();
			$this->Qaddress->create();
			
			debug($this->Qprofile->create());
			//set role to user for general user
			$this->request->data['Qprofile']['role'] = 'user';
			//set time created and timezone
			$timezone = date_default_timezone_get();
			date_default_timezone_set($timezone);
			$date = date('Y-m-d H:i:s');
			$this->request->data['Qprofile']['dateCreated'] = $date;
			
			$timestamp = strtotime($_POST['datepicker']);
			debug($timestamp);
			$date = date('Y-m-d', $timestamp);
			debug($date);
			$this->request->data['Qprofile']['dateOfBirth'] = $date;
			
			if($this->Qaddress->save($this->request->data))
			{
			$addressID=$this->Qaddress->getLastInsertId();
			$this->request->data['Qprofile']['addressID'] = $addressID;
            if ($this->Qprofile->save($this->request->data)) 
			{
                $this->Session->setFlash(__('The user has been saved'));
				
				//debug($addressID);
                return $this->redirect(array('action' => 'login'));
            }
			}
			else
			{
				debug($this->Qprofile->save($this->request->data));
				debug($this->Stock->validationErrors);
			}
				
			$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
	}
	
    public function index() {
        $this->Qachievement->recursive = -1;
	
		$qachievement =$this->Qachievement->find('all',array(
		'joins' => array(
        array(
            'table' => 'Qachievement',
            'alias' => 'QachievementJoin',
            'type' => 'INNER',
            'conditions' => array(
                'QachievementJoin.achievementID = Qachievement.achievementID'
            )
        )
    ),
    'conditions' => array(
        'Qachievement.profileID'=>$this->Auth->user('profileID')
    ),
    'fields' => array('QachievementJoin.*')
	));
	
	//	debug($qachievement);
      
        $this->set('qachievements', $qachievement);
    }
	
	
	
}
?>