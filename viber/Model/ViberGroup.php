<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('ViberModel', 'Model');

class ViberGroup extends ViberModel
{
    public $useTable = 'ChatInfo';
    public $primaryKey = 'ChatID';

    public $hasMany = array(
        'ViberGroupInfo' => array(
            'className' => 'ViberGroupInfo',
            'foreignKey' => 'ChatID',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );

    public $virtualFields = array(
        'Name' => "(CASE
            WHEN ViberGroup.Token LIKE '+%' THEN ''
            ELSE ViberGroup.Name
            END)", 'Private' => "(CASE
            WHEN ViberGroup.Token LIKE '+%' THEN 1
            ELSE 0
        END)"
    );

    public function fetchGroups($group_ids = array())
    {
        $conditions = array();

        if (!INCLUDE_PRIVATE) {
            $conditions['ViberGroup.Private'] = 0;
        }

        if (!empty($group_ids)) {
            $conditions['ViberGroup.ChatID'] = $group_ids;
        }

        return $this->find('all', array(
            'fields' => array(
                'ViberGroup.ChatID',
                'ViberGroup.Name',
                'ViberGroup.Token',
                'ViberGroup.Private'
            ),
            'conditions' => $conditions,
            'group' => array('ViberGroup.Token'),
            'order' => 'ViberGroup.Private, ViberGroup.Token ASC',
            'contain' => array(
                'ViberGroupInfo' => array(
                    'fields' => 'Number'
                )
            )
        ));
    }
}
