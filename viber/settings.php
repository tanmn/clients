<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

/*
|--------------------------------------------------------------------------
| SETTINGS
|--------------------------------------------------------------------------
*/

// Hotline number with country code
define('MY_NUM', '+841689979431');

// Windows ONLY: Path of current user, without trailing splash
define('WINDOWS_USER_PATH', 'C:\Users\Administrator');

// Includes my number when collect Viber PC data
define('INCLUDE_MY_NUM', TRUE);


// Includes private messages when collect Viber PC data
define('INCLUDE_PRIVATE', TRUE);

/*
|--------------------------------------------------------------------------
| REPORTS
|--------------------------------------------------------------------------
*/

// Includes my number in reports
define('REPORT_INCLUDE_MY_NUM', TRUE);

// Includes private messages in reports
define('REPORT_INCLUDE_PRIVATE', TRUE);

// Prefers exporting reports of groups in whitelist
define('REPORT_WHITELIST_ONLY', TRUE);

/*
|--------------------------------------------------------------------------
| MAILING
|--------------------------------------------------------------------------
*/

// For receiving daily reports
Configure::write('RECEIVERS', array(
    'tanmn@c3tek.biz',
));


// For debug errors
Configure::write('DEVELOPERS', array(
    'tanmn@c3tek.biz',
));
