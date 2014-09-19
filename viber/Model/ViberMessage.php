<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('ViberModel', 'Model');

class ViberMessage extends ViberModel
{
	public $useTable = 'Messages';
	public $primaryKey = 'EventID';

	public $hasOne = array(
        'ViberEvent' => array(
            'className' => 'ViberEvent',
            'foreignKey' => 'EventID',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );
}
