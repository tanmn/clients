<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('ViberModel', 'Model');

class ViberEvent extends ViberModel
{
    public $useTable = 'Events';
    public $primaryKey = 'EventID';

    public $belongsTo = array(
        'ViberGroup' => array(
            'className' => 'ViberGroup',
            'foreignKey' => 'ChatID',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        ),
        'ViberMessage' => array(
            'className' => 'ViberMessage',
            'foreignKey' => 'EventID',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        ),
        'ViberNumber' => array(
            'className' => 'ViberNumber',
            'foreignKey' => 'Number',
            'conditions' => array(),
            'order' => '',
            'limit' => '',
            'dependent' => false
        )
    );

    public function fetchGroupData($conditions = array(), $date = NULL)
    {
        $date_field = 'date(ViberEvent.TimeStamp, \'unixepoch\', \'localtime\')';
        $context    = array();

        if (!INCLUDE_MY_NUM) {
            $context[] = 'ViberEvent.Direction = 0';
        }

        if (!INCLUDE_PRIVATE) {
            $context[] = "ViberGroup.Token NOT LIKE '+%'";
        }

        if ($date) {
            $context[] = array(
                $date_field => $date
            );
        }

        $mes_type = "(CASE
            WHEN ViberMessage.StickerID <> 0 THEN 'sticker'
            WHEN ViberMessage.PttID <> '' THEN 'voice'
            WHEN ViberMessage.ThumbnailPath <> '' THEN 'media'
            ELSE 'message'
        END)";

        $mes_number = "(CASE
            WHEN ViberEvent.Direction = 0
            THEN ViberEvent.Number ELSE '" . MY_NUM . "'
        END)";

        $mes_date = 'date(ViberEvent.TimeStamp, \'unixepoch\', \'localtime\')';

        // $mes_direction = "(CASE
        //     WHEN ViberEvent.Direction = 0 THEN 'received'
        //     ELSE 'sent'
        //     END)";

        return $this->find('all', array(
            'fields' => array(
                'ViberGroup.Token as group_code',
                $mes_number . ' as number',
                $mes_date . ' as report_date',
                // $mes_direction . ' as direction',
                $mes_type . ' as msg_type',
                'COUNT(ViberMessage.EventID) as quantity'
            ),
            'group' => array(
                'ViberGroup.Token',
                $mes_number,
                $mes_date,
                // $mes_direction,
                $mes_type
            ),
            'contain' => array(
                'ViberMessage',
                'ViberGroup'
            ),
            'conditions' => array(
                $context,
                $conditions
            ),
            'order' => array(
                'ViberEvent.ChatID' => 'ASC',
                'ViberEvent.Number' => 'ASC'
            )
        ));
    }
}
