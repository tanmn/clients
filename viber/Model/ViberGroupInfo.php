<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('ViberModel', 'Model');

class ViberGroupInfo extends ViberModel
{
    public $useTable = 'ChatRelation';
    public $primaryKey = 'ChatID';

    public $belongsTo = array(
        'ViberGroup' => array(
            'className' => 'ViberGroup',
            'foreignKey' => 'ChatID',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        ),
        'ViberNumber' => array(
            'className' => 'ViberNumber',
            'foreignKey' => 'Number',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );

    public function fetchUsers($user_ids = array())
    {
        $conditions = array();

        if (!empty($user_ids)) {
            $conditions['ViberNumber.Number'] = $user_ids;
        }

        return $this->find('all', array(
            'fields' => array(
                'ViberGroupInfo.ChatID',
                'ViberGroupInfo.Number',
                'ViberNumber.ClientName',
                'ViberNumber.AvatarPath'
            ),
            'conditions' => $conditions,
            'contain' => array(
                'ViberNumber.ViberNumberInfo' => array(
                    'fields' => array(
                        'IsViberNumber'
                    )
                )
            )
        ));
    }
}
