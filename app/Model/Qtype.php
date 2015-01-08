<?php

// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

// app/Model/User.php
class Qtype extends AppModel {

	public $useTable = 'Qtypes';

	public function beforeSave($options = array()) {
	//debug("in beforesave");
		
		return true;
	}
	
	
	
    public $validate = array(
       
		'typeName' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required'
            )
        )
		
    );
}

?>