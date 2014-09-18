<?php
App::uses('AppModel', 'Model');
/**
 * PhoneNumber Model
 *
 */
class PhoneNumber extends AppModel {

    public $useDbConfig = 'viber';
    public $useTable = 'PhoneNumber';
	public $primaryKey = 'Number';

    public $hasOne = array(
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
        $conditions = array('PhoneNumber.IsViberNumber' => 1);

        if(!empty($user_ids)){
            $conditions['Info.Number'] = $user_ids;
        }

        return $this->find('all', array(
            'fields' => array(
                'Info.Number',
                'Info.ClientName',
                'Info.AvatarPath'
            ),
            'conditions' => $conditions,
            'contain' => array('Info')
        ));
    }

}
