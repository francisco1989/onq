<?php

class Qdeck extends AppModel {
	public $useTable = 'Qdecks';

    public $validate = array(
			'deckType' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Only letters and numbers allowed',
				'rule' => array('maxLength',20),
				'message' => 'Maximum length of 20 characters'
						
			),
			
			'title' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Only letters and numbers allowed',
				'rule' => array('maxLength',20),
				'message' => 'Maximum length of 20 characters'
								
			),
		
			'description' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Only letters and numbers allowed',
				'rule' => array('maxLength',20),
				'message' => 'Maximum length of 20 characters'
							
			),
			'rating' => array(
				'ratingRule-1' => array(
				'rule' => array('decimal', 2),
				'message' => 'Please enter a valid rating',
				'allowEmpty' => false
				)				
			),
			
			'privatePublic' => array(
				'privatePublicRule-1' => array(
				'rule' => array('boolean'),
				'message' => 'Incorrect value for privatePublic',
				'allowEmpty' => false
				)				
			)
    );
			/* before changes 
				'description' => array(
				'descriptionRule-1' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Only letters and numbers allowed'
				),
				'descriptionRule-2' => array(
				'rule' => array('maxLength',20),
				'message' => 'Maximum length of 20 characters'
				)				
			),*/
}
?>