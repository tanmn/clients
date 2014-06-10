<?php
App::uses('AppModel', 'Model');
/**
 * OriginNumberInfo Model
 *
 */
class OriginNumberInfo extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
    public $useDbConfig = 'viber';

/**
 * Use table
 *
 * @var mixed False or table name
 */
    public $useTable = 'OriginNumberInfo';

/**
 * Primary key field
 *
 * @var string
 */
    public $primaryKey = 'Number';

}
