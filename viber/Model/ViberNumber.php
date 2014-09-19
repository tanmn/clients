<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('ViberModel', 'Model');

class ViberNumber extends ViberModel
{
    public $useTable = 'OriginNumberInfo';
    public $primaryKey = 'Number';

    public $belongsTo = array(
        'ViberNumberInfo' => array(
            'className' => 'ViberNumberInfo',
            'foreignKey' => 'Number',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );

    public function fetchUsers($user_ids = array())
    {
        $conditions = array(
            'ViberNumberInfo.IsViberNumber' => 1
        );

        if (!empty($user_ids)) {
            $conditions['ViberNumber.Number'] = $user_ids;
        }

        return $this->find('all', array(
            'fields' => array(
                'ViberNumber.Number',
                'ViberNumber.ClientName',
                'ViberNumber.AvatarPath'
            ),
            'conditions' => $conditions,
            'contain' => array(
                'ViberNumberInfo'
            )
        ));
    }
}
