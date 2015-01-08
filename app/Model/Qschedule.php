<?php

class Qschedule extends AppModel {
	public $useTable = 'Qschedule';

	  public $validate = array(
        'startDay' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A start day is required'
				
            )
        ),
        'endDay' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A end day is required'
            )
        ),
		
		
    );
 
}
?>