<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('AppModel', 'Model');

class MasterGroup extends AppModel
{
    public $primaryKey = 'group_code';
    public $displayField = 'group_name';

    public function getWhitelist()
    {
        return $this->find(
            'list',
            array(
                'fields' => array('MasterGroup.group_code', 'MasterGroup.group_code'),
                'conditions' => array(
                    'MasterGroup.is_whitelist' => 1
                )
            )
        );
    }
}
