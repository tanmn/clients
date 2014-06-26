<?php

/*

Copyright (c) 2014 by AppSeeds (http://appseeds.shinsenter.com).  All Rights Reserved.

*/

App::uses('AppShell', 'Console/Command');

set_time_limit(0);
ini_set('memory_limit', '256M');
Configure::write('debug', 2);
require_once APP . 'Config' . DS . '250knumbers.php';

class GetCodeShell extends AppShell {

    public $uses = array('HotlineRequest');

    public function main(){
        $NUMBERS = Configure::read('NUMBERS');

        $hotlines = array(
            '+84916065017' => array(strtotime('2014-06-10 00:00:00'), strtotime('2014-06-22 00:00:00')),
            '+84902913785' => array(strtotime('2014-06-22 00:00:00'), strtotime('2014-07-09 00:00:00'))
        );

        $this->out(pr($hotlines));

        foreach($NUMBERS as $chunk){
            $data = array();

            foreach($chunk as $number){
                $hotline = array_rand($hotlines);
                $date_range = $hotlines[$hotline];
                $time = date('Y-m-d H:i:s', mt_rand($date_range[0], $date_range[1]));

                $data[] = array(
                    'number' => $number,
                    'hotline' => $hotline,
                    'created' => $time,
                    'modified' => $time
                );
            }

            $this->HotlineRequest->saveMany($data);

            $this->out(count($data) . ' rows saved.');

            unset($data);
        }
    }
}