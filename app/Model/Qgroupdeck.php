<?php

// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

// app/Model/User.php
class Qgroupdeck extends AppModel {

  public $useTable ='Qgroupdecks';
	  public $belongsTo = array(
        'Qgroup'=> array(
            'className' => 'Qgroup',
            'foreignKey' => 'groupID'

        )
		, 'Qdeck'=> array(
            'className' => 'Qdeck',
            'foreignKey' => 'deckID'

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