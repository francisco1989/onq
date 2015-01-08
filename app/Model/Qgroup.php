<?php

// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

// app/Model/User.php
class Qgroup extends AppModel {

	public $hasMany = array(
        'Qprofilegroup' => array
        (
            'className'  => 'Qprofilegroup',
            'foreignKey' => 'groupID',
            'dependent'  => true
        )

    );
	
	public $useTable = 'Qgroups';
	
	 public function procedureDecks($id) {
           $data= $this->query( "call decksingroup($id);" );
		   return $data;
		   }
	
	public function beforeSave($options = array()) {
	//debug("in beforesave");
		/*if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
				
			);
		}*/
		return true;
	}
	
	
	
    public $validate = array(
        'groupType' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
				
            )
        ),
        'groupTitle' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
		'groupDescription' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A descriptionis required'
            )
        ),
		'lastModified' => array(
            'required' => array(
                'rule' => array('notEmpty')
            )
        ),
		'groupCode' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A code is required'
            )
        ),
        'privatePublic' => array(
            'valid' => array(
                'rule' => array('inList', array('1', '0')),
                'message' => 'Deck must be private or public',
                'allowEmpty' => false
            )
            )
        
    );
}

?>