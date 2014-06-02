<?php
App::uses('AppModel', 'Model');
/**
 * ContactRelation Model
 *
 */
class ContactRelation extends AppModel {

    public $useDbConfig = 'viber';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'ContactRelation';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'ContactID';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'Number' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'TypeName' => array(
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
