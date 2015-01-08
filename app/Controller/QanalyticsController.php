<?php

class QanalyticsController extends AppController {
    public $helpers = array('Html', 'Form');
	
    public function beforeFilter() 
	{
		parent::beforeFilter();
		//debug("in filter");
		if($this->Auth->user('role')=='user')
		{
			$this->Auth->allow('Groupdash','Admindash');//add this line for normal users
		}
		else
		{
			$this->Auth->allow('register','login');
		}
		 // Basic setup
		$this->Auth->authenticate = array('Form');
    }
	
	public function Admindash() {
	}
	
	public function Groupdash() {
	}
}

?>