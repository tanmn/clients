<?php
App::uses('AppModel', 'Model');
/**
 * Event Model
 *
 */
class Event extends AppModel {

    public $useDbConfig = 'viber';

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'Events';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'EventID';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'TimeStamp' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'Direction' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'Type' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'Token' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'IsRead' => array(
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

    public $belongsTo = array(
        'ChatInfo' => array(
            'className' => 'ChatInfo',
            'foreignKey' => 'ChatID',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        ),
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'EventID',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        ),
        'User' => array(
            'className' => 'OriginNumberInfo',
            'foreignKey' => 'Number',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );

    // public function afterFind($results, $primary = false) {
    //     foreach($results as $index => $data){
    //         if(isset($data['Event']['TimeStamp'])){
    //             $results[$index]['Event']['TimeStamp'] = date('Y-m-d H:i:s', $data['Event']['TimeStamp']);
    //         }
    //     }
    //
    //     return $results;
    // }

    public function fetchGroupData($conditions = array(), $date = NULL, $group_only = TRUE)
    {
        $context = array(
            'Event.Direction' => 0
        );

        $mes_type = "(CASE
            WHEN Message.StickerID <> 0 THEN 'sticker'
            WHEN Message.PttID <> '' THEN 'voice'
            WHEN Message.ThumbnailPath <> '' THEN 'photo'
            ELSE 'message' END)";

        if ($date)
        {
            $context['date(Event.TimeStamp, \'unixepoch\', \'localtime\')'] = $date;
        }

        if($group_only)
        {
            $context[] = 'ChatInfo.Token <> Event.Number';
        }

        return $this->find('all', array(
            'fields' => array(
                $mes_type . ' as msg_type',
                'Event.Number as number',
                'ChatInfo.Token as group_code',
                'COUNT(Message.EventID) as quantity'
            ),
            'group' => array(
                'ChatInfo.Token',
                'Event.Number',
                $mes_type
            ),
            'contain' => array(
                'Message',
                'ChatInfo'
            ),
            'conditions' => array(
                // "Message.PttID <> ''",
                $context,
                $conditions
            ),
            'order' => array(
                'Event.ChatID' => 'ASC',
                'Event.Number' => 'ASC'
            ),
            // 'limit' => 10
        ));
    }
}
