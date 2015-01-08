<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class Qprofiledeck extends AppModel {

  public $useTable ='Qprofiledecks';
	  public $belongsTo = array(
        'Qprofile'=> array(
            'className' => 'Qprofile',
            'foreignKey' => 'profileID'
        ), 
		'Qdeck'=> array(
            'className' => 'Qdeck',
            'foreignKey' => 'deckID'
        )
    );

	public function beforeSave($options = array()) {
		return true;
	}
	
	
	
    public $validate = array(
    );
}
?>