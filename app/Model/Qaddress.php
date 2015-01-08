<?php

// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

// app/Model/User.php
class QAddress extends AppModel {

	public $belongsTo = 'Qprofile';
 	public $useTable = 'Qaddresses';

	public function beforeSave($options = array()) {
	//debug("in beforesave");
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
				
			);
		}
		return true;
	}
	
	
	
    public $validate = array(
        'unit' => array(
            'between' => array(
                'rule'    => array('between', 1, 3),
                'message' => 'Between 1 to 3 characters'
            )
        ),
        'streetNumber' => array(
            'numeric' => array(
                'rule'     => 'numeric',
                'message'  => 'numbers only'
            ),
            'between' => array(
                'rule'    => array('between', 0, 6),
                'message' => 'Between 0 and 6 numbers'
            )
        ),
		'streetName' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A street name is required'
            )
        ),
		'city' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A city is required'
            )
        ),
		'stateProvince' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A province is required'
            )
        ),
		'country' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A country is required'
            )
        ),
		'postalCode' => array(
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => 'Alphabets and numbers only'
            ),
            'between' => array(
                'rule'    => array('between', 1, 6),
                'message' => 'Between 1 to 6 characters'
            )
        )
		
    );
}

?>