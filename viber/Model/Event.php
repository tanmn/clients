<?php
App::uses('AppModel', 'Model');
/**
 * Event Model
 *
 */
class Event extends AppModel {
    public $useDbConfig = 'viber';
	public $useTable = 'Events';
	public $primaryKey = 'EventID';


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


    public function fetchGroupData($conditions = array(), $date = NULL)
    {
        $date_field = 'date(Event.TimeStamp, \'unixepoch\', \'localtime\')';
        $context = array();

        if (!INCLUDE_MY_NUM) {
            $context[] = 'Event.Direction = 0';
        }

        if (!INCLUDE_PRIVATE) {
            $context[] = "ChatInfo.Token NOT LIKE '+%'";
        }

        if ($date) {
            $context[] = array(
                $date_field => $date
            );
        }

        $mes_type = "(CASE
            WHEN Message.StickerID <> 0 THEN 'sticker'
            WHEN Message.PttID <> '' THEN 'voice'
            WHEN Message.ThumbnailPath <> '' THEN 'media'
            ELSE 'message'
            END)";

        $mes_number = "(CASE
            WHEN Event.Direction = 0
            THEN Event.Number ELSE '" . MY_NUM . "'
            END)";

        $mes_date = 'date(Event.TimeStamp, \'unixepoch\', \'localtime\')';

        // $mes_direction = "(CASE
        //     WHEN Event.Direction = 0 THEN 'received'
        //     ELSE 'sent'
        //     END)";

        return $this->find('all', array(
            'fields' => array(
                'ChatInfo.Token as group_code',
                $mes_number . ' as number',
                $mes_date . ' as report_date',
                // $mes_direction . ' as direction',
                $mes_type . ' as msg_type',
                'COUNT(Message.EventID) as quantity'
            ),
            'group' => array(
                'ChatInfo.Token',
                $mes_number,
                $mes_date,
                // $mes_direction,
                $mes_type
            ),
            'contain' => array(
                'Message',
                'ChatInfo'
            ),
            'conditions' => array(
                $context,
                $conditions
            ),
            'order' => array(
                'Event.ChatID' => 'ASC',
                'Event.Number' => 'ASC'
            )
        ));
    }
}
