<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('AppModel', 'Model');

class ViberModel extends AppModel
{
    public $useDbConfig = 'viber';
    public $cacheQueries = false;

    public function beforeSave($options = array()) {
        return false;
    }

    public function beforeDelete($cascade = true) {
        return false;
    }
}
