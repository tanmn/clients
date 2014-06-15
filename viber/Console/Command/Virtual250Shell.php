<?php

/*

Copyright (c) 2014 by AppSeeds (http://appseeds.shinsenter.com).  All Rights Reserved.

*/

App::uses('AppShell', 'Console/Command');

set_time_limit(0);
ini_set('memory_limit', '256M');
Configure::write('debug', 2);


class Virtual250Shell extends AppShell {

    public $uses = array('MasterGroup', 'MasterPoint');



    protected $errors = array();



    protected function _welcome() {
        $this->out();
        $this->out('250 VIRTUAL MEMBERS PROCESS by AppSeeds');
        $this->hr();
    }



    public function main() {
        $this->addVirtual250();
        $this->out('Done!');
    }



    protected function addVirtual250(){
        $data = array();
        $groups = array();
        $members = Configure::read('VIRTUAL_MEMBERS');
        $date = date('Y-m-d', time() - 86400);

        foreach($members as $i => $phone){
            $members[$i] = $group_code = $this->formatNumber($phone);

            $data[] = array(
                'report_date' => $date,
                'hotline' => MY_NUM,
                'msg_type' => 'sticker',
                'group_code' => $group_code,
                'number' => $group_code,
                'quantity' => rand(50, 500),
                'virtual_flag' => TRUE
            );

            $groups[] = array(
                'group_code' => $group_code,
                'hotline' => MY_NUM,
                'group_name' => 'Group'
            );
        }

        $this->MasterPoint->deleteAll(array(
            'MasterPoint.report_date' => $date,
            'MasterPoint.hotline' => MY_NUM,
            'MasterPoint.group_code' => $members,
            'MasterPoint.virtual_flag' => TRUE
        ));

        $this->MasterPoint->saveMany($data);
        $this->MasterGroup->saveMany($groups);
    }
}