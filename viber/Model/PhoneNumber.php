<?php
App::uses('AppModel', 'Model');
/**
 * PhoneNumber Model
 *
 */
class PhoneNumber extends AppModel {

    public $useDbConfig = 'viber';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'PhoneNumber';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'Number';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'IsViberNumber' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
