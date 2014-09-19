<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('CakeNumber', 'Utility');
App::uses('AppShell', 'Console/Command');

set_time_limit(0);
ini_set('memory_limit', -1);

class ReportShell extends AppShell
{
    public $uses = array('MasterLog');

    protected function _welcome()
    {
        $this->out();
        $this->out('VIBER REPORT by C3TEK (c3tek.biz)');
        $this->hr();
        $this->out('Now is ' . date('Y-m-d H:i:s') . ' - Agent number is ' . MY_NUM);

        if (!$this->testConnections('default')) {
            $this->mailErrors();
            $this->error('Cannot connect to application database.');
        }
    }

    public function main()
    {
        if (!empty($this->args[0]) && strtotime($this->args[0]) !== FALSE) {
            $this->process($this->args[0]);
        } else {
            $this->today();
        }
    }

    public function today()
    {
        $this->process('today');
    }

    protected function process($target_date)
    {
        $this->out();
        $target_date = date('Y-m-d', strtotime($target_date));
        $this->out('The target day is ' . $target_date);
        $this->hr();

        $logs = $this->MasterLog->fetchLogs(array(), $target_date);
        $this->out(pr($logs));

        $this->sql();
    }
}