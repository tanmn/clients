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

    public function fetchGroups($group_ids = array()){
        $conditions = array();

        if(!empty($group_ids)){
            $conditions['ChatInfo.ChatID'] = $group_ids;
        }

        return $this->find('all', array(
            'fields' => array(
                'ChatInfo.ChatID',
                'ChatInfo.Name',
                'ChatInfo.Token'
            ),
            'conditions' => $conditions,
            'contain' => array(
                'ChatRelation' => array(
                    'fields' => array('Number'),
                    'Info' => array('fields' => 'ClientName')
                )
            )
        ));
    }
}
