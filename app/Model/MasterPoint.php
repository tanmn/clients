<?php
App::uses('AppModel', 'Model');
/**
 * MasterPoint Model
 *
 */
class MasterPoint extends AppModel {

    public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'report_date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'msg_type' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'group_code' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'quantity' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

    public $virtualFields = array(
        'points' => 'SUM(IF(msg_type = "sticker", quantity * 3, quantity * 1))'
    );

    public $belongsTo = array(
        'MasterGroup' => array(
            'className' => 'MasterGroup',
            'foreignKey' => 'group_code',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );

    public function getTopGroups($limit = 10, $conditions = array()){
        $alias = $this->alias;

        $results = $this->find(
            'all',
            array(
                'fields' => array(
                    // $alias . '.group_code',
                    'MasterGroup.group_name',
                    $alias . '.number',
                    $alias . '.points'
                ),
                'conditions' => $conditions,
                'contain' => array('MasterGroup'),
                'group' => array($alias . '.group_code', 'MasterGroup.group_name', $alias . '.number'),
                'order' => array($alias . '.points' => 'DESC'),
                'limit' => $limit
            )
        );

        return $results;
    }

    public function getTopUsers($limit = 10, $conditions = array()){
        $alias = $this->alias;

        $results = $this->find(
            'all',
            array(
                'fields' => array(
                    $alias . '.number',
                    $alias . '.points'
                ),
                'conditions' => $conditions,
                'group' => array($alias . '.number'),
                'order' => array($alias . '.points' => 'DESC'),
                'limit' => $limit
            )
        );

        return $results;
    }



    public function afterFind($results, $primary = false) {
        $alias = $this->alias;

        if(is_array($results)){
            foreach ($results as $key => $object) {
                if(is_array($object) && !empty($object[$alias]['number'])){
                    $results[$key][$alias]['number'] = $this->formatPhone($object[$alias]['number']);
                }
            }
        }

        return $results;
    }
}
