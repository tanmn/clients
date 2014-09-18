<?php
App::uses('AppModel', 'Model');
/**
 * ChatRelation Model
 *
 */
class ChatRelation extends AppModel {

    public $useDbConfig = 'viber';
	public $useTable = 'ChatRelation';
	public $primaryKey = 'ChatID';

	public $belongsTo = array(
        'ChatInfo' => array(
            'className' => 'ChatInfo',
            'foreignKey' => 'ChatID',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        ),
        'User' => array(
            'className' => 'OriginNumberInfo',
            'foreignKey' => 'Number',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        ),
        'Info' => array(
            'className' => 'OriginNumberInfo',
            'foreignKey' => 'Number',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );
}
