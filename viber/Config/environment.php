<?php

/*

Copyright (c) 2014 by AppSeeds (http://appseeds.shinsenter.com).  All Rights Reserved.

*/

$MY_NUM = str_replace('+', '', MY_NUM);
$VIBER_PATH = 'ViberPC' . DS . $MY_NUM . DS . 'viber.db';
$SYSTEM_PATH = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? getenv('HOMEDRIVE') . getenv('HOMEPATH') . DS . 'AppData' . DS . 'Roaming' : getenv('HOME') . DS . 'Library' . DS . 'Application Support';

//define('ENV_HOME', $SYSTEM_PATH . DS . $VIBER_PATH);
define('ENV_HOME', 'C:\Users\Administrator\AppData\Roaming\ViberPC\84916065017\viber.db');
define('DATA', TMP . 'DATA');

unset($MY_NUM, $VIBER_PATH, $SYSTEM_PATH);

Configure::write('ADMINISTRATORS', array(
    'tuannh@c3tek.biz',
    'giangnam.nguyen@teetalk.vn',
    'bichphuong.nguyen@faceinteraction.vn',
    'tanmn@c3tek.biz'
));

Configure::write('DEVELOPERS', array(
    'tuannh@c3tek.biz',
    'tanmn@c3tek.biz'
));