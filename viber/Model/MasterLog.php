<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('AppModel', 'Model');

class MasterLog extends AppModel
{
    public $primaryKey = 'id';

    public $belongsTo = array(
        'MasterGroup' => array(
            'className' => 'MasterGroup',
            'foreignKey' => 'group_code',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        ),

        'MasterUser' => array(
            'className' => 'MasterUser',
            'foreignKey' => 'number',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );
}
