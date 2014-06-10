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


    public $virtualFields = array(
        'raw_avatar' => 'avatar'
    );


    public function afterFind($results, $primary = false) {
        $alias = $this->alias;

        if(is_array($results)){
            foreach ($results as $key => $object) {
                if(is_array($object) && !empty($object[$alias]['number'])){
                    $results[$key][$alias]['number'] = $this->formatPhone($object[$alias]['number']);
                }

                if(is_array($object) && !empty($object[$alias]['avatar'])){
                    $results[$key][$alias]['avatar'] = Router::url('/avatar/' . preg_replace('/^\+/', '', $object[$alias]['number']) . '/user.png', true);
                }
            }
        }

        return $results;
    }
}
