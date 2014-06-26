<?php
App::uses('AppModel', 'Model');
/**
 * MasterHotline Model
 *
 */
class MasterHotline extends AppModel {

    public $displayField = 'hotline';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'hotline' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'active_flag' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

    public function beforeSave($options = array()) {
        return false;
    }

    public function beforeDelete($cascade = true) {
        return false;
    }
}
