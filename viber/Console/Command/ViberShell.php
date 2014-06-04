<?php

/*

Copyright (c) 2014 by AppSeeds (http://appseeds.shinsenter.com).  All Rights Reserved.

*/

App::uses('AppShell', 'Console/Command');
App::uses('ConnectionManager', 'Model');

set_time_limit(0);
ini_set('memory_limit', '256M');
Configure::write('debug', 0);


class ViberShell extends AppShell {

    public $uses = array('Message', 'MasterPoint');



    protected $errors = array();



    protected function _welcome() {
        $this->out();
        $this->out('VIBER PROCESS by AppSeeds (http://appseeds.shinsenter.com)');
        $this->hr();
    }



    public function main() {
        if(!$this->testConnections('viber')){
            $this->mailErrors();
            return FALSE;
        }

        $this->out('Processing ' . $this->getCount() . ' messages...');

        $time_start = microtime(true);

        if($this->command == 'today'){
            $output = $this->process(date('Y-m-d'));
        }else{
            $output = $this->process();
            $top_250 = $this->getTop250();
            $this->mailTop250($top_250);
        }


        $time_stop = microtime(true);

        @file_put_contents(DATA, serialize($output));

        $this->out(pr($output));
        $this->hr();

        $this->out((count($output['points']) + count($output['groups'])) . ' entries have been push to microsite!');
        $this->out($this->getOwnerCount() . ' outgoing messages from ' . MY_NUM . ' were excluded!');

        $this->hr();
        $this->out('Total process time: ' . (($time_stop - $time_start) * 1) . 's');
        $this->out();

        $this->mailErrors($output);
    }



    protected function testConnections($name){
        try {
            $connected = ConnectionManager::getDataSource($name);
        } catch (Exception $connectionError) {
            $connected = false;
            $errorMsg = $connectionError->getMessage();

            if (method_exists($connectionError, 'getAttributes')){
                $attributes = $connectionError->getAttributes();

                if (isset($errorMsg['message'])){
                    $errorMsg .= "\n -> " . $attributes['message'];
                }
            }

            $this->errors[] = $errorMsg;
            return false;
        }

        return true;
    }



    protected function getCount() {
        try{
            return $this->Message->find('count');
        }catch(Exception $e){
            $this->errors[] = $e->getMessage();
        }

        return 0;
    }



    protected function getOwnerCount($date = NULL) {
        $context = array(
            'Event.Direction' => 1
        );

        if ($date) {
            $context['date(TimeStamp, \'unixepoch\', \'localtime\')'] = $date;
        }


        try{
            return $this->Message->find('count', array(
                'conditions' => $context,
                'contain' => array(
                    'Event'
                )
            ));
        }catch(Exception $e){
            $this->errors[] = $e->getMessage();
        }

        return array();
    }



    protected function fetchGroupPoints($conditions = array(), $date = NULL) {
        $context = array(
            'Event.Direction' => 0
        );

        if ($date) {
            $context['date(TimeStamp, \'unixepoch\', \'localtime\')'] = $date;
        }

        try{
            return $this->Message->find('all', array(
                'fields' => array(
                    'Event.Number as PHONE_NUM',
                    'Event.ChatID as GROUP_ID',
                    'COUNT(Message.EventID) as NUM'
                ),
                'group' => array(
                    'Event.ChatID',
                    'Event.Number'
                ),
                'contain' => array(
                    'Event'
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
        }catch(Exception $e){
            $this->errors[] = $e->getMessage();
        }

        return array();
    }



    protected function process($date = NULL) {
        if (empty($date))
            $date = date('Y-m-d', time() - 86400);

        $this->out($date);
        $this->hr();

        if(!$this->testConnections('viber')){
            return FALSE;
        }

        $sticker_data = $this->fetchGroupPoints(array(
            'Message.StickerID <>' => 0
        ), $date);

        $normal_data = $this->fetchGroupPoints(array(
            'Message.StickerID' => 0
        ), $date);

        $summary = array();
        $group_ids = array();

        foreach ($normal_data as $item) {
            $summary[] = array(
                'report_date' => $date,
                'hotline' => MY_NUM,
                'msg_type' => 'normal',
                'group_code' => $this->formatGroupId($item[0]['GROUP_ID']),
                'number' => $this->formatNumber($item[0]['PHONE_NUM']),
                'quantity' => $item[0]['NUM']
            );

            $group_ids[$item[0]['GROUP_ID']] = true;
        }

        foreach ($sticker_data as $item) {
            $summary[] = array(
                'report_date' => $date,
                'hotline' => MY_NUM,
                'msg_type' => 'sticker',
                'group_code' => $this->formatGroupId($item[0]['GROUP_ID']),
                'number' => $this->formatNumber($item[0]['PHONE_NUM']),
                'quantity' => $item[0]['NUM']
            );

            $group_ids[$item[0]['GROUP_ID']] = true;
        }

        $groups = $this->Message->Event->ChatInfo->find(
            'list',
            array(
                'fields' => array(
                    'ChatInfo.ChatID',
                    'ChatInfo.Name'
                ),
                'conditions' => array(
                    'ChatInfo.ChatID' => array_keys($group_ids)
                )
            )
        );

        unset($group_ids);

        foreach($groups as $group_code => $group_name){
            $groups[$group_code] = array(
                'group_code' => $this->formatGroupId($group_code),
                'hotline' => MY_NUM,
                'group_name' => empty($group_name) ? 'NONAME' : $group_name
            );
        }

        if(!$this->testConnections('default')){
            return array('points' => $summary, 'groups' => $groups);
        }

        $dbo = $this->MasterPoint->getDataSource();
        $dbo->begin();

        $this->MasterPoint->deleteAll(array(
            'report_date' => $date
        ));

        if(!empty($groups))
            $this->MasterPoint->MasterGroup->saveAll($groups);

        if (empty($summary) || $this->MasterPoint->saveMany($summary)) {
            $dbo->commit();
        } else {
            $dbo->rollback();
        }

        return array('points' => $summary, 'groups' => $groups);
    }



    protected function formatNumber($number){
        return preg_replace('/^0/', '+84', $number);
    }



    protected function formatGroupId($group_code){
        return preg_replace('/^.*(\d{6,6})$/', '$1', MY_NUM) . '' . $group_code;
    }



    protected function getTop250(){
        $date = date('Y-m-d', time() - 86400);

        $top250 = $this->MasterPoint->getTopUsers(250, array(
            'MasterPoint.report_date' => $date
        ));

        return $top250;
    }



    protected function mailErrors($data = NULL){
        if(empty($this->errors)) return;

        $message = 'Dear administrators,';
        $message .= "\n\n";
        $message .= 'The app meets errors when trying collect data.';
        $message .= "\n\n";
        $message .= "-------ERROR DETAILS-------";
        $message .= "\n\n";
        $message .= implode("\n", $this->errors);
        $message .= "\n\n";
        $message .= "-------ERROR DETAILS--------";
        $message .= "\n\n";

        if(!empty($data)){
            $message .= "Proceeded data:\nPlease view attached file below this email.";
            $message .= "\n";
            $message .= "----------------------------";
            $message .= "\n";

            $attachment = APP . 'webroot' . DS . 'files' . DS . 'proceeded_data_' . date('Ymd.His') . '.log';
            @file_put_contents($attachment, serialize($data));
        }

        $message .= 'This message was sent automatically from client ' . MY_NUM . ' at ' . date('Y-m-d H:i:s') . '.';

        $this->out('Errors:');
        $this->out($message);

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('gmail');
        $Email->to(Configure::read('ADMINISTRATORS'));

        if(isset($attachment)){
            $Email->attachments($attachment);
        }

        $Email->subject('[VIBER APP] Error report from hotline ' . MY_NUM);

        try{
            $Email->send($message);
        }catch(Exception $e){
            $this->out('Mail not sent: ' . $e->getMessage());
        }
    }

    protected function mailTop250($data = NULL){
        if(empty($data)) return;

        $date = date('Y-m-d', time() - 86400);

        $message = 'Dear administrators,';
        $message .= "\n\n";
        $message .= 'I send you the list of top 250 winners on ' . $date . '.';
        $message .= "\n\n";
        $message .= "-------LIST BEGIN-------";
        $message .= "\n\n";
        $message .= "# ; Phone number ; Points\n";

        foreach ($data as $key => $value) {
            $index = $key + 1;
            $message .= "{$index} ; {$value['MasterPoint']['number']} ; {$value['MasterPoint']['points']}\n";
        }

        $message .= "\n";
        $message .= "-------LIST STOP--------";
        $message .= "\n\n";
        $message .= "Total: " . count($data) . " users.";
        $message .= "\n\n";

        $message .= 'This message was sent automatically from client ' . MY_NUM . ' at ' . date('Y-m-d H:i:s') . '.';

        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail('gmail');
        $Email->to(Configure::read('ADMINISTRATORS'));

        if(isset($attachment)){
            $Email->attachments($attachment);
        }

        $Email->subject('[VIBER APP] Winner report from hotline ' . MY_NUM . ' on ' . $date);

        try{
            $Email->send($message);
        }catch(Exception $e){
            $this->out('Mail not sent: ' . $e->getMessage());
        }
    }
}
