<?php

// app/Model/Qadvertisment.php
class Qprofileadvertisment extends AppModel {

	public $useTable = 'Qprofileadvertisements';

    public $validate = array(
        'profileID' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A profile ID is required'
            )
        ),
		
		'advertismentID' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'An advertisment ID is required'
            )
        )
    );
}

?>