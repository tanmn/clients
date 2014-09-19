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

    public function fetchLogs($conditions = array(), $date = NULL)
    {
        $context = array(
            'MasterLog.agent' => MY_NUM
        );

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

        if ($date) {
            $context['MasterLog.report_date'] = $date;
        }

        return $this->find('all', array(
            'contain' => array(
                'MasterGroup.group_name',
                'MasterGroup.is_whitelist',
                'MasterGroup.is_private',
                'MasterUser.viber_name',
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
                'MasterLog.group_code' => 'ASC',
                'MasterUser.is_agent' => 'DESC',
                'MasterLog.number' => 'ASC'
            )
        ));

        return $results;
    }
}
