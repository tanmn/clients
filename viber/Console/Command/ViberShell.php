<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('AppShell', 'Console/Command');
App::uses('ConnectionManager', 'Model');

set_time_limit(0);
ini_set('memory_limit', '256M');
Configure::write('debug', 2);

class ViberShell extends AppShell
{
    public $uses = array('Event', 'ChatInfo', 'PhoneNumber', 'MasterLog');

    protected function _welcome()
    {
        $this->out();
        $this->out('VIBER PROCESS by C3TEK (c3tek.biz)');
        $this->hr();
    }

    public function main()
    {
        if(!empty($this->args[0]) && strtotime($this->args[0]) !== FALSE){
            $this->date($this->args[0]);
        }else{
            $this->today();
        }
    }

    public function today(){
        $target_date = date('Y-m-d', strtotime('today'));
        $this->out('Today ' . $target_date);
        $this->hr();

        $this->process($target_date);
    }

    public function yesterday(){
        $target_date = date('Y-m-d', strtotime('yesterday'));
        $this->out('Yesterday ' . $target_date);
        $this->hr();

        $this->process($target_date);
    }

    protected function date($target_date = NULL){
        $target_date = date('Y-m-d', strtotime($target_date));
        $this->out('Date ' . $target_date);
        $this->hr();

        $this->process($target_date);
    }

    protected function process($target_date){
        $data = $this->Event->fetchGroupData(array(), $target_date);
        $this->out(pr($data));


        // $data = $this->ChatInfo->fetchGroups();
        // $this->out(pr($data));


        // $data = $this->PhoneNumber->fetchUsers();
        // $this->out(pr($data));
    }
}