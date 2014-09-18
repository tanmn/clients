<?php
App::uses('AppModel', 'Model');
/**
 * OriginNumberInfo Model
 *
 */
class OriginNumberInfo extends AppModel {

    public $useDbConfig = 'viber';
    public $useTable = 'OriginNumberInfo';
    public $primaryKey = 'Number';

    public $belongsTo = array(
        'PhoneNumber' => array(
            'className' => 'PhoneNumber',
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
            $conditions['OriginNumberInfo.Number'] = $user_ids;
        }

        return $this->find('all', array(
            'fields' => array(
                'OriginNumberInfo.Number',
                'OriginNumberInfo.ClientName',
                'OriginNumberInfo.AvatarPath'
            ),
            'conditions' => $conditions,
            'contain' => array('PhoneNumber')
        ));
    }
}
