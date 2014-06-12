<?php
App::uses('AppModel', 'Model');
/**
 * MasterUser Model
 *
 */
class MasterUser extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'number';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'address' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'device' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'winner_flag' => array(
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


    public $virtualFields = array(
        'raw_avatar' => 'avatar'
    );


    public function afterFind($results, $primary = false) {
        $alias = $this->alias;

        if(is_array($results)){
            foreach ($results as $key => $object) {
                if(is_array($object) && !empty($object[$alias]['number'])){
                    $results[$key][$alias]['number'] = $this->formatPhone($object[$alias]['number']);
                    $results[$key][$alias]['avatar'] = Router::url('/avatar/' . preg_replace('/^\+/', '', $object[$alias]['number']) . '/user.png', true);
                }
            }
        }

        return $results;
    }
}
