<?php
// app/Controller/AppController.php
class AppController extends Controller 
{
    //...
	public $theme = "Cakestrap";
    public $components = array
	(
	'DebugKit.Toolbar',
		'Session',
		'Auth' => array(
			'loginRedirect' => array('controller' => 'qprofiles/index', 'action' => ''),
			'logoutRedirect' => array('controller' => 'qprofiles/login','action' => ''),
			'authorize' => array('Controller'),
			'userModel' => 'Qprofile'			// Added this line
		)
	);

	public function isAuthorized($Qprofile) 
	{
		// Admin can access every action
		
		if (isset($Qprofile['role']) && $Qprofile['role'] === 'admin') {
		
			return true;
		}

		// Default deny
		return false;
	}

	public function beforeFilter() 
	{
		$this->set('authUser', $this->Auth->user());
		$this->set('role', $this->Auth->user('role')); 
		$this->Auth->userModel = 'qprofiles';
		$this->Auth->allow('login');
		$this->Auth->loginAction = '/qprofiles/login';
	}
	//...
}
?>