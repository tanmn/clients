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

    public function fetchUsers($user_ids = array()){
        $conditions = array();

        if(!empty($user_ids)){
            $conditions['OriginNumberInfo.Number'] = $user_ids;
        }

        return $this->find('all', array(
            'fields' => array(
                'OriginNumberInfo.Number',
                'OriginNumberInfo.ClientName',
                'OriginNumberInfo.AvatarPath'
            ),
            'conditions' => $conditions
        ));
    }

}
