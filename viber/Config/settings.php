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

// Includes my number when collect Viber PC data
if(!defined('INCLUDE_MY_NUM')) define('INCLUDE_MY_NUM', TRUE);

// Includes private messages when collect Viber PC data
if(!defined('INCLUDE_PRIVATE')) define('INCLUDE_PRIVATE', TRUE);

/*
|--------------------------------------------------------------------------
| REPORTS
|--------------------------------------------------------------------------
*/

// Includes my number in reports
if(!defined('REPORT_INCLUDE_MY_NUM')) define('REPORT_INCLUDE_MY_NUM', INCLUDE_MY_NUM && TRUE);

// Includes private messages in reports
if(!defined('REPORT_INCLUDE_PRIVATE')) define('REPORT_INCLUDE_PRIVATE', INCLUDE_PRIVATE && TRUE);

// Prefers exporting reports of groups in whitelist
if(!defined('REPORT_WHITELIST_ONLY')) define('REPORT_WHITELIST_ONLY', TRUE);

// Excludes groups that have no activity
if(!defined('REPORT_EXCLUDE_INACTIVE_GROUPS')) define('REPORT_EXCLUDE_INACTIVE_GROUPS', FALSE);

