<?php
App::uses('AppModel', 'Model');
/**
 * ChatInfo Model
 *
 */
class ChatInfo extends AppModel {

    public $useDbConfig = 'viber';
	public $useTable = 'ChatInfo';
	public $primaryKey = 'ChatID';

    public $hasMany = array(
        'ChatRelation' => array(
            'className' => 'ChatRelation',
            'foreignKey' => 'ChatID',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );

    public $virtualFields = array(
        'Name' => "(CASE
            WHEN ChatInfo.Token LIKE '+%' THEN ''
            ELSE ChatInfo.Name
            END)",
        'Private' => "(CASE
            WHEN ChatInfo.Token LIKE '+%' THEN 1
            ELSE 0
            END)"
    );

    public function fetchGroups($group_ids = array()){
        $conditions = array();

        if (!INCLUDE_PRIVATE) {
            $conditions['ChatInfo.Private'] = 0;
        }

        if(!empty($group_ids)){
            $conditions['ChatInfo.ChatID'] = $group_ids;
        }

        return $this->find('all', array(
            'fields' => array(
                'ChatInfo.ChatID',
                'ChatInfo.Name',
                'ChatInfo.Token',
                'ChatInfo.Private',
            ),
            'conditions' => $conditions,
            'order' => 'ChatInfo.Private, ChatInfo.Token ASC',
            'contain' => array('ChatRelation' => array('fields' => 'Number'))
        ));
    }
}
