<?php

// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

// app/Model/User.php
class Qprofile extends AppModel {

 /*public $hasOne = array(
        'Qaddress' => array
        (
            'className'  => 'Qaddress',
            'foreignKey' => 'addressID',
            'dependent'  => true
        )

    );*/
	public $useTable = 'Qprofiles';
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
        'userName' => array(
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => 'Alphabets and numbers only'
            ),
            'between' => array(
                'rule'    => array('between', 5, 40),
                'message' => 'Between 5 to 15 characters'
            )
        ),
        'password' => array(
            'rule'    => array('minLength', '8'),
            'message' => 'Minimum 8 characters long'
        ),
		'firstName' => array(
            'between' => array(
                'rule'    => array('between', 0, 20),
                'message' => 'Cannot be more than 20 characters'
            )
        ),
		'lastName' => array(
            'between' => array(
                'rule'    => array('between', 0, 20),
                'message' => 'Cannot be more than 20 characters'
            )
        ),
		'emailAddress' => 'email',
		'dateCreated' => array(
            'required' => array(
                'rule' => array('notEmpty'),
				'message' => 'Must be a valid email'
            )
        ),
		'dateOfBirth' => array(
            'rule'       => 'date',
            'message'    => 'Enter a valid date',
            'allowEmpty' => true
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'user')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        ),
		'maleFemale' => array(
            'valid' => array(
                'rule' => array('inList', array('1', '0')),
                'message' => 'Must be a male or female cant be both or can you....',
                'allowEmpty' => false
            )
        ),
		'phoneNumber' => array(
            'numeric' => array(
                'rule'     => 'numeric',
                'message'  => 'numbers only'
            ),
            'between' => array(
                'rule'    => array('between', 10, 11),
                'message' => 'Between 10 and 11 numbers'
            )
        ),
		'profilePic' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A profile image is required'
            )
        ),
		
    );
}

?>