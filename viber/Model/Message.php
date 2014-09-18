<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 */
class Message extends AppModel {

    public $useDbConfig = 'viber';
	public $useTable = 'Messages';
	public $primaryKey = 'EventID';

	public $hasOne = array(
        'Event' => array(
            'className' => 'Event',
            'foreignKey' => 'EventID',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );
}
