<?php

// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

// app/Model/User.php
class Qachievement extends AppModel {

	public function beforeSave($options = array()) {
	//debug("in beforesave");
	
		return true;
	}
	
	public $useTable = 'Qachievements';
	
  
}

?>