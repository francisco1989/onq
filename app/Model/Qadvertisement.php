<?php
/*
 *  Project : OnQ
 *  File : QAdvertisement.php
 *  Author : Francis Kurevija	 
 *  Created : February 16, 2014
 *  Last Modiied : February 17, 2014
 *  Description : QAdvertisement is the model definition for the QAdvertisements table of the OnQ database
 */
 
// app/Model/Qadvertisement.php
class Qadvertisement extends AppModel {

	public $useTable = 'Qadvertisements';
	
    public $validate = array(
		'advertisementID' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'An advertisement image is required'
            )
        ),
        'advertisement' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'An advertisement image is required'
            )
        )
    );
}

?>