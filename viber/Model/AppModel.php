<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('Model', 'Model');

class AppModel extends Model
{
    public $cacheQueries = TRUE;
    public $recursive = -1;
    public $actsAs = array('Containable');
}
