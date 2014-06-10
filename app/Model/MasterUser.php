<?php
App::uses('AppModel', 'Model');
/**
 * MasterUser Model
 *
 */
class MasterUser extends AppModel {

    public $primaryKey = 'number';

/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'number' => array(
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
