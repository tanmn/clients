<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

// Hotline number with country code
define('MY_NUM', '+841689979431');


// Windows ONLY: Path of current user, without trailing splash
define('WINDOWS_USER_PATH', 'C:\Users\Administrator');


// For receiving daily reports
Configure::write('RECEIVERS', array(
    'tanmn@c3tek.biz',
));


// For debug errors
Configure::write('DEVELOPERS', array(
    'tanmn@c3tek.biz',
));