<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('AppModel', 'Model');

class MasterLog extends AppModel
{
    public $primaryKey = 'id';

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

    public function fetchLogs($conditions = array(), $date)
    {
        if(!$date) $date = 'today';
        $target_date = date('Y-m-d', strtotime($date));

        $context = array(
            'MasterLog.agent' => MY_NUM,
            'MasterLog.report_date' => $target_date,
        );

        if(REPORT_EXCLUDE_INACTIVE_GROUPS){
            $context[] = array('EXISTS (
                SELECT a.number
                FROM ? as a
                WHERE a.report_date = ?
                AND a.agent = MasterLog.agent
                AND a.group_code = MasterLog.group_code
                AND a.quantity > 0
                LIMIT 1
            )' => array($this->useTable, $target_date));
        }

        if (!REPORT_INCLUDE_MY_NUM) {
            $context[] = 'MasterLog.number <> \'' . MY_NUM . '\'';
        }

        if (!REPORT_INCLUDE_PRIVATE) {
            $context[] = 'MasterGroup.is_private = 0';
        }

        if (REPORT_WHITELIST_ONLY) {
            $white_list = $this->MasterGroup->getWhitelist();

            if (!empty($white_list)) {
                $context['MasterLog.group_code'] = $white_list;
            }
        }

        $results = $this->find('all', array(
            'contain' => array(
                'MasterGroup.group_name',
                'MasterGroup.is_whitelist',
                'MasterGroup.is_private',
                'MasterUser.viber_name',
                'MasterUser.number',
                'MasterUser.is_viber',
                'MasterUser.is_agent',
            ),
            'conditions' => array(
                $context,
                $conditions
            ),
            'group' => array(
                'MasterLog.id'
            ),
            'order' => array(
                'MasterGroup.is_private' => 'ASC',
                'MasterGroup.group_name' => 'ASC',
                'MasterLog.group_code' => 'ASC',
                'MasterUser.is_agent' => 'DESC',
                'MasterLog.number' => 'ASC'
            )
        ));

        unset($context, $white_list);

        $output = array();

        if(!empty($results)){
            foreach($results as $item){
                $group_code = $item['MasterLog']['group_code'];
                $number = $item['MasterLog']['number'];
                $msg_type = $item['MasterLog']['msg_type'];
                $quantity = $item['MasterLog']['quantity'];

                if(!isset($output[$group_code]))
                    $output[$group_code] = $item['MasterGroup'] + array('Logs' => array());

                if(!isset($output[$group_code]['Logs'][$number]))
                    $output[$group_code]['Logs'][$number] = $item['MasterUser'] + array(
                        'message' => 0,
                        'sticker' => 0,
                        'media' => 0,
                        'voice' => 0
                    );

                $output[$group_code]['Logs'][$number][$msg_type] = $quantity;

                unset($item, $group_code, $number, $msg_type, $quantity);
            }
        }

        return array('report_date' => $target_date, 'data' => $output);
    }

    public function fetchNewUser($date = FALSE){
        if(!$date) $date = 'today';

        $target_date = date('Y-m-d', strtotime($date));
        $previous_date = date('Y-m-d', strtotime($date . ' -1 day'));

        $results = $this->find(
            'all',
            array(
                'fields' => array(
                    'MasterLog.number',
                    'MasterLog.group_code',
                ),
                'conditions' => array(
                    'NOT EXISTS (
                        SELECT a.number
                        FROM ? as a
                        WHERE a.report_date = ?
                        AND a.agent = MasterLog.agent
                        AND a.group_code = MasterLog.group_code
                        AND a.number = MasterLog.number
                    )' => array($this->useTable, $previous_date),
                    'MasterLog.report_date' => $target_date
                ),
                'group' => array(
                    'MasterLog.number',
                    'MasterLog.group_code',
                ),
            )
        );

        $output = array();

        if(!empty($results)){
            $user_numbers = Hash::combine($results, '{n}.MasterLog.number', NULL);

            $conditions = array('MasterUser.number' => array_keys($user_numbers));

            if (!REPORT_INCLUDE_MY_NUM) {
                $conditions[] = 'MasterUser.is_agent = 0';
            }

            $new_users = Hash::combine($this->MasterUser->find(
                'all',
                array(
                    'fields' => array(
                        'MasterUser.number',
                        'MasterUser.viber_name',
                        'MasterUser.is_viber',
                        'MasterUser.is_agent',
                    ),
                    'conditions' => $conditions,
                    'group' => array(
                        'MasterUser.number',
                    )
                )
            ), '{n}.MasterUser.number', '{n}.MasterUser');

            unset($user_numbers, $conditions);

            foreach($results as $item){
                $group_code = array_pop($item[0]);
                $number = $item['MasterLog']['number'];

                if(!isset($output[$group_code]))
                    $output[$group_code] = array();

                if(isset($new_users[$number])){
                    if($number == MY_NUM){
                        $output[$group_code] = array($number => $new_users[$number]) + $output[$group_code];
                    }else{
                        $output[$group_code][$number] = $new_users[$number];
                    }
                }

                unset($item, $group_code, $number);
            }

            unset($new_users);
        }

        unset($results);

        return array('report_date' => $target_date, 'data' => $output);
    }
}
