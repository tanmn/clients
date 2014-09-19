<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('ViberModel', 'Model');

class ViberNumberInfo extends ViberModel
{
    public $useTable = 'PhoneNumber';
    public $primaryKey = 'Number';
}
