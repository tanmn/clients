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
        'Info' => array(
            'className' => 'OriginNumberInfo',
            'foreignKey' => 'Number',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );

    public function fetchUsers($user_ids = array()){
        $conditions = array();

        if(!empty($user_ids)){
            $conditions['Info.Number'] = $user_ids;
        }

        return $this->find('all', array(
            'fields' => array(
                'ChatRelation.ChatID',
                'ChatRelation.Number',
                'Info.ClientName',
                'Info.AvatarPath'
            ),
            'conditions' => $conditions,
            'contain' => array('Info.PhoneNumber' => array('fields' => array('IsViberNumber')))
        ));
    }
}
