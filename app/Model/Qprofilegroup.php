<?php

// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

// app/Model/User.php
class Qprofilegroup extends AppModel {

  public $useTable ='Qprofilegroups';
	  public $belongsTo = array(
        'Qprofile'=> array(
            'className' => 'Qprofile',
            'foreignKey' => 'profileID'

        )
		, 'Qgroup'=> array(
            'className' => 'Qgroup',
            'foreignKey' => 'groupID'

        )
    );

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

    );
}

?>