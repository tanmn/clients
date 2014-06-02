<?php

/*

Copyright (c) 2014 by AppSeeds (http://appseeds.shinsenter.com).  All Rights Reserved.

*/

$MY_NUM = str_replace('+', '', MY_NUM);
$VIBER_PATH = 'ViberPC' . DS . $MY_NUM . DS . 'viber.db';
$SYSTEM_PATH = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'Local Settings' . DS . 'Application Data' : 'Library' . DS . 'Application Support';

define('ENV_HOME', getenv('HOME') . DS . $SYSTEM_PATH . DS . $VIBER_PATH);
define('DATA', TMP . 'DATA');

unset($MY_NUM, $VIBER_PATH, $SYSTEM_PATH);

Configure::write('ADMINISTRATORS', array(
    // 'tuannh@c3tek.biz',
    // 'giangnam.nguyen@teetalk.vn',
    'tanmn@c3tek.biz',
));