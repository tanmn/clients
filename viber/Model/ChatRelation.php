<?php
App::uses('AppModel', 'Model');
/**
 * ChatRelation Model
 *
 */
class ChatRelation extends AppModel {

    public $useDbConfig = 'viber';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'ChatRelation';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'ChatID';

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
	);
}
