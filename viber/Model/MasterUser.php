<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('AppModel', 'Model');

class MasterUser extends AppModel
{
    public $primaryKey = 'number';
    public $displayField = 'viber_name';

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);

        $this->virtualFields = array(
            'is_agent' => "(CASE WHEN MasterUser.number = '" . MY_NUM . "' THEN 1 ELSE 0 END)",
            'viber_name' => "(CASE WHEN MasterUser.number = '" . MY_NUM . "' THEN 'VIBER AGENT' ELSE MasterUser.viber_name END)"
        );
    }
}
