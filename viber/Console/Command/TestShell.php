<?php

/*

Copyright (c) 2014 by AppSeeds (http://appseeds.shinsenter.com).  All Rights Reserved.

*/

App::uses('AppShell', 'Console/Command');

set_time_limit(0);
ini_set('memory_limit', '256M');
Configure::write('debug', 2);


class TestShell extends AppShell {

    public $uses = array('ChatInfo', 'MasterPoint', 'MasterGroup');

    public function main(){
        $raw_groups = $this->ChatInfo->find(
            'all',
            array(
                'fields' => array(
                    'ChatInfo.ChatID',
                    'ChatInfo.Name',
                    'ChatInfo.Token'
                )
            )
        );

        $groups = array();
        $group_map = array();

        foreach($raw_groups as $group){
            $group_code = $group['ChatInfo']['ChatID'];
            $group_name = $group['ChatInfo']['Name'];
            $group_token = $group['ChatInfo']['Token'];

            $groups[$group_code] = array(
                'group_code' => $group_token,
                'hotline' => MY_NUM,
                'group_name' => empty($group_name) ? 'Group' : $group_name
            );

            $group_map[$group_code] = $group_token;
        }

        $dbo = $this->MasterPoint->getDatasource();

        $dbo->begin();
        foreach($group_map as $code => $token){
            $code = $this->formatGroupId($code);
            $this->MasterPoint->updateAll(
                array(
                    'MasterPoint.group_code' => "'{$token}'"
                ),
                array(
                    'MasterPoint.group_code' => $code
                )
            );
        }
        $dbo->commit();

        $dbo = $this->MasterGroup->getDatasource();

        $dbo->begin();
        $this->MasterGroup->deleteAll(array(
            'MasterGroup.hotline' => MY_NUM
        ));
        $this->MasterGroup->saveMany($groups);
        $dbo->commit();

        $this->out('Done~');
    }
}