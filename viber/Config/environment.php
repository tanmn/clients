<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz).  All Rights Reserved.

*/

// Hotline number with country code
define('MY_NUM', '+84916065017');

// Windows ONLY: Path of current user, without trailing splash
define('WINDOWS_USER_PATH', 'C:\Users\Administrator');


// Admin Emails
// For receiving daily reports
Configure::write('ADMINISTRATORS', array(
    'giangnam.nguyen@teetalk.vn',
    'bichphuong.nguyen@faceinteraction.vn',
));


// Developer Emails
// For debug errors
Configure::write('DEVELOPERS', array(
    'giangnam.nguyen@teetalk.vn',
));