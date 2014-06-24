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
        'points' => 'SUM(IF(msg_type = "sticker", quantity * 3, quantity * 1))',
        'players' => 'COUNT(DISTINCT MasterPoint.number)',
        'raw_number' => 'MasterPoint.number'
    );

    public $belongsTo = array(
        'MasterGroup' => array(
            'className' => 'MasterGroup',
            'foreignKey' => 'group_code',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        ),
        'MasterUser' => array(
            'className' => 'MasterUser',
            'foreignKey' => 'number',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );

    public function beforeSave($options = array()) {
        return false;
    }

    public function beforeDelete($cascade = true) {
        return false;
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


    public function getValidGroups($conditions = array()){
        $alias = $this->alias;

        $results = $this->find(
            'list',
            array(
                'fields' => array(
                    $alias . '.group_code',
                    $alias . '.players'
                ),
                'conditions' => $conditions,
                'group' => $alias . '.group_code HAVING ' . $this->virtualFields['players'] . ' > 4',
                'recursive' => -1
            )
        );

        return $results;
    }


    public function getTopGroups($limit = 10, $conditions = array()){
        $alias = $this->alias;

        $cache_name = 'Groups_' . md5($limit . json_encode($conditions));

        $conditions[] = array(
            'OR' => array(
                array(
                    $alias . '.number <> ' . $alias . '.group_code',
                    $alias . '.report_date >=' => '2014-06-24'
                ),
                $alias . '.report_date <' => '2014-06-24',
                $alias . '.virtual_flag' => TRUE
            )
        );

        $results = $this->find(
            'all',
            array(
                'fields' => array(
                    $alias . '.group_code',
                    'MasterGroup.group_name',
                    $alias . '.points'
                ),
                'conditions' => $conditions,
                'contain' => array('MasterGroup'),
                'group' => array($alias . '.group_code'),
                'order' => array($alias . '.points' => 'DESC'),
                'limit' => $limit,
                'cacheConfig' => 'apis',
                'cache' => '_' . $cache_name
            )
        );

        return $results;
    }

    public function getTopUsers($limit = 10, $conditions = array()){
        $alias = $this->alias;

        $cache_name = 'Users_' . md5($limit . json_encode($conditions));

        $conditions[] = array(
            'OR' => array(
                array(
                    $alias . '.number <> ' . $alias . '.group_code',
                    $alias . '.report_date >=' => '2014-06-24'
                ),
                $alias . '.report_date <' => '2014-06-24',
                $alias . '.virtual_flag' => TRUE
            )
        );

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
                'limit' => $limit,
                'contain' => array('MasterUser.name', 'MasterUser.real_name', 'MasterUser.address', 'MasterUser.device', 'MasterUser.avatar'),
                'cacheConfig' => 'apis',
                'cache' => '_' . $cache_name
            )
        );

        return $results;
    }

    public function getTopUsersForReport($limit = 10, $conditions = array()){
        $alias = $this->alias;

        $conditions[] = array(
            'OR' => array(
                array(
                    $alias . '.number <> ' . $alias . '.group_code',
                    $alias . '.report_date >=' => '2014-06-24'
                ),
                $alias . '.report_date <' => '2014-06-24',
                $alias . '.virtual_flag' => TRUE
            )
        );

        $results = $this->find(
            'all',
            array(
                'fields' => array(
                    $alias . '.number',
                    $alias . '.virtual_flag',
                    $alias . '.raw_number',
                    $alias . '.points'
                ),
                'conditions' => $conditions,
                'group' => array($alias . '.number'),
                'order' => array($alias . '.points' => 'DESC'),
                'limit' => $limit,
                'contain' => array('MasterUser.name', 'MasterUser.real_name', 'MasterUser.address', 'MasterUser.device', 'MasterUser.avatar'),
            )
        );

        return $results;
    }

    public function getAvailableDate(){
        $todate = date('Y-m-d');
        $alias = $this->alias;

        $dates = Set::flatten((array) $this->find(
            'all',
            array(
                'fields' => array(
                    'DISTINCT ' . $alias . '.report_date'
                ),
                'conditions' => array(
                    $alias . '.report_date <>' => $todate
                ),
                'order' => array($alias . '.report_date' => 'DESC'),
                'cacheConfig' => 'apis',
                'cache' => 'AvailableDates'
            )
        ));

        foreach($dates as $k => $v){
            $v = explode('-', $v);
            $dates[$k] = "{$v[2]}-{$v[1]}-{$v[0]}";
        }

        return array_values($dates);
    }

    public function getGroupUsers($group_id = FALSE, $context = array()){
        $alias = $this->alias;
        $conditions = array();

        if(!empty($group_id)){
            $conditions[$alias . '.group_code'] = $group_id;
        }

        if(!empty($context)){
            $conditions[] = $context;
        }

        $cache_name = md5(json_encode($conditions));

        $users = $this->find(
            'all',
            array(
                'fields' => array(
                    'DISTINCT ' . $alias . '.number',
                    $alias . '.group_code',
                    $alias . '.virtual_flag',
                    $alias . '.raw_number',
                ),
                'conditions' => $conditions,
                'contain' => array('MasterUser.name', 'MasterUser.real_name', 'MasterUser.address', 'MasterUser.device', 'MasterUser.avatar'),
            )
        );

        $groups = array();

        foreach($users as $user){
            $gr_code = $user[$alias]['group_code'];

            if(!isset($groups[$gr_code])) $groups[$gr_code] = array();

            $groups[$gr_code][] = $user;
        }

        unset($users);

        if(count($groups) == 1){
            $groups = array_pop($groups);
        }

        return $groups;
    }
}
