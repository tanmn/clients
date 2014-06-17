<?php

/*

Copyright (c) 2014 by AppSeeds (http://appseeds.shinsenter.com).  All Rights Reserved.

*/

App::uses('AppShell', 'Console/Command');

set_time_limit(0);
Configure::write('debug', 0);


class BotShell extends AppShell {
    public $my_num = '+84987654321';
    public $my_group = '+84987654321';
    public $my_hotline = '+84916065017';
    public $my_speed = array(150, 200);
    public $today;
    public $uses = array('MasterPoint');

    public function __construct($stdout = null, $stderr = null, $stdin = null) {
        $this->my_path = TMP . 'cache' . DS . str_replace('+', '', $this->my_num) . '.bot';
        $this->today = date('Y-m-d');
        parent::__construct($stdout, $stderr, $stdin);
    }

    protected function _welcome() {
        $this->out();
        $this->out('BOT Simulation by AppSeeds');
        $this->hr();
        $this->out('BOT phone number: ' . $this->my_num);
        $this->out('BOT group: ' . $this->my_group);
        $this->out('BOT hotline: ' . $this->my_hotline);
        $this->hr();
    }

    public function main(){
        $this->out('Retrieve last points on ' . $this->today);
        $data = $this->readData();

        $add_sticker = $this->randomPoints('sticker');
        $add_normal = $this->randomPoints('normal');

        $data['sticker']['MasterPoint']['quantity'] += $add_sticker;
        $data['normal']['MasterPoint']['quantity'] += $add_normal;

        $this->out(pr($data));
        $this->hr();
        $this->out('Extra points added: ' . ($add_sticker * 3 + $add_normal) . ' points.');
        if($this->MasterPoint->saveMany($data)){
            $this->out('Successful.');
        }else{
            $this->out('Cannot update points.');
        }
    }

    public function randomPoints($type){
		$ratio = date('H') < 8 ? 0.2 : 1;
        $target_points = rand($this->my_speed[0], $this->my_speed[1]) * $ratio;

        switch($type){
            case 'sticker':
                return round($target_points / 2);

            default:
                return round($target_points);
        }
    }

    public function readData(){
        $data = array();

        $sticker = $this->MasterPoint->find(
            'first',
            array(
                'conditions' => array(
                    'MasterPoint.group_code' => $this->my_group,
                    'MasterPoint.hotline' => $this->my_hotline,
                    'MasterPoint.msg_type' => 'sticker',
                    'MasterPoint.number' => $this->my_num,
                    'MasterPoint.report_date' => $this->today,
                    'MasterPoint.virtual_flag' => TRUE
                ),
                'recursive' => -1
            )
        );

        if(empty($sticker['MasterPoint']['id'])){
            $sticker = array('MasterPoint' => array(
                'report_date' => $this->today,
                'hotline' => $this->my_hotline,
                'msg_type' => 'sticker',
                'group_code' => $this->my_group,
                'number' => $this->my_num,
                'quantity' => 0,
                'virtual_flag' => TRUE
            ));
        }

        $normal = $this->MasterPoint->find(
            'first',
            array(
                'conditions' => array(
                    'MasterPoint.group_code' => $this->my_group,
                    'MasterPoint.hotline' => $this->my_hotline,
                    'MasterPoint.msg_type' => 'normal',
                    'MasterPoint.number' => $this->my_num,
                    'MasterPoint.report_date' => $this->today,
                    'MasterPoint.virtual_flag' => TRUE
                ),
                'recursive' => -1
            )
        );

        if(empty($normal['MasterPoint']['id'])){
            $normal = array('MasterPoint' => array(
                'report_date' => $this->today,
                'hotline' => $this->my_hotline,
                'msg_type' => 'normal',
                'group_code' => $this->my_group,
                'number' => $this->my_num,
                'quantity' => 0,
                'virtual_flag' => TRUE
            ));
        }

        return compact('sticker', 'normal');
    }
}
