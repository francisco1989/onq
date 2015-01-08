<?php

class Qcard extends AppModel {
	public $useTable = 'Qcards';

    public $validate = array(
			'cardType' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Only letters and numbers allowed',
				'allowEmpty' => false,	
				'rule' => array('maxLength',20),
				'message' => 'Maximum length of 20 characters'
						
			),
			
			'question' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Only letters and numbers allowed',
				'allowEmpty' => false,
				'rule' => array('maxLength',100),
				'message' => 'Maximum length of 100 characters'
								
			),
		
			'answer' => array(
				
				'rule' => 'alphaNumeric',
				'message' => 'Only letters and numbers allowed',
				'allowEmpty' => false,
				'rule' => array('maxLength',100),
				'message' => 'Maximum length of 100 characters'
								
			)
    );
}
?>