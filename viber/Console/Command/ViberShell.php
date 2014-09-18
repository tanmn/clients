<?php

/*

Copyright (c) 2014 by C3TEK (c3tek.biz). All Rights Reserved.
Distributed 2014 by AppSeeds (http://appseeds.net/)

*/

App::uses('CakeNumber', 'Utility');
App::uses('AppShell', 'Console/Command');

set_time_limit(0);
ini_set('memory_limit', '256M');
Configure::write('debug', 2);

class ViberShell extends AppShell
{
    public $uses = array('Event', 'ChatInfo', 'ChatRelation', 'MasterLog');

    protected function _welcome()
    {
        $this->out();
        $this->out('VIBER PROCESS by C3TEK (c3tek.biz)');
        $this->hr();
        $this->out(date('Y-m-d H:i:s'));
    }

    public function main()
    {
        if (!empty($this->args[0]) && strtotime($this->args[0]) !== FALSE) {
            $this->process($this->args[0]);
        } else {
            $this->today();
        }
    }

    public function all()
    {
        $this->process();
    }

    public function today()
    {
        $this->process('today');
    }

    public function yesterday()
    {
        $this->process('yesterday');
    }

    public function groups()
    {
        $this->out();
        $this->out('Update groups');
        $this->hr();

        $groups = $this->ChatInfo->fetchGroups();

        $master_groups = array();

        foreach ($groups as $group) {
            $master_groups[] = array(
                'group_code' => $group['ChatInfo']['Token'],
                'group_name' => $group['ChatInfo']['Name'],
                'is_private' => $group['ChatInfo']['Private'],
                'agent' => MY_NUM
            );
        }

        if ($this->MasterLog->MasterGroup->saveMany($master_groups)) {
            $this->out(CakeNumber::format(count($master_groups)) . ' group(s) updated.');
        } else {
            $this->err('Could not update groups.');
        }

        return $groups;
    }

    public function users()
    {
        $this->out();
        $this->out('Update users');
        $this->hr();

        $users = $this->ChatRelation->fetchUsers();

        $master_users = array();

        foreach ($users as $user) {
            $master_users[] = array(
                'number' => $user['ChatRelation']['Number'],
                'is_viber' => empty($user['Info']['PhoneNumber']['IsViberNumber']) ? 0 : 1,
                'viber_name' => $user['Info']['ClientName']
            );
        }

        if ($this->MasterLog->MasterUser->saveMany($master_users)) {
            $this->out(CakeNumber::format(count($master_users)) . ' user(s) updated.');
        } else {
            $this->err('Could not update users.');
        }

        return $users;
    }

    protected function process($target_date = FALSE)
    {
        $time_start = microtime(TRUE);

        $groups = $this->groups();
        $users = $this->users();

        unset($users);

        $this->out();

        if ($target_date) {
            $target_date = date('Y-m-d', strtotime($target_date));
            $this->out('The target day is ' . $target_date);
        } else {
            $this->out('Proceeding data of all time');
        }

        $this->hr();

        $master_logs = array();

        if ($target_date) {
            foreach ($groups as $group) {
                if ($group['ChatInfo']['Private'])
                    continue;

                $group_id = $group['ChatInfo']['Token'];

                foreach ($group['ChatRelation'] as $phone) {
                    $key = "{$target_date}-{$group_id}-{$phone['Number']}-message";

                    $master_logs[$key] = array(
                        'agent' => MY_NUM,
                        'group_code' => $group_id,
                        'number' => $phone['Number'],
                        'report_date' => $target_date,
                        'msg_type' => 'message',
                        'quantity' => 0,
                        'is_virtual' => 0
                    );
                }
            }
        }

        unset($groups, $group, $group_id, $phone, $key);

        $data = $this->Event->fetchGroupData(array(), $target_date);
        $total_messages = 0;

        foreach ($data as $item) {
            $total_messages += $item[0]['quantity'];
            $key = "{$item[0]['report_date']}-{$item[0]['group_code']}-{$item[0]['number']}-{$item[0]['msg_type']}";
            $log = array(
                'agent' => MY_NUM,
                'group_code' => $item[0]['group_code'],
                'number' => $item[0]['number'],
                'report_date' => $item[0]['report_date'],
                'msg_type' => $item[0]['msg_type'],
                'quantity' => $item[0]['quantity'],
                'is_virtual' => 0
            );

            if (isset($master_logs[$key])) {
                $master_logs[$key] = array_merge($master_logs[$key], $log);
            } else {
                $master_logs[$key] = $log;
            }
        }

        unset($data, $item, $key, $log);

        ksort($master_logs);
        $master_logs = array_values($master_logs);

        $db = $this->MasterLog->getDatasource();
        $db->begin();

        $this->cleanupMasterLogs($target_date);

        if ($this->MasterLog->saveMany($master_logs)) {
            $db->commit();
            $this->out(CakeNumber::format($total_messages) . ' message(s) has been proceeded successfully.');
            $this->out(CakeNumber::format(count($master_logs)) . ' row(s) has been added to application database.');
        } else {
            $db->rollback();
            $this->err('Could not update users.');
        }

        $time_stop = microtime(TRUE);
        $time = (($time_stop - $time_start) * 1);

        $this->out();
        $this->out('Total process time: ' . $time . 's');
        if (function_exists('memory_get_usage'))
            $this->out('Total memory used: ' . CakeNumber::toReadableSize(memory_get_usage()));
        $this->out();
    }

    protected function cleanupMasterLogs($target_date = FALSE)
    {
        $delete_conditions = array(
            'OR' => array(
                array(
                    'MasterLog.agent' => MY_NUM,
                    'MasterLog.is_virtual' => 0
                ),
                'MasterLog.agent' => NULL
            )
        );

        if ($target_date) {
            $delete_conditions['OR'][0]['MasterLog.report_date'] = $target_date;
        }

        $this->MasterLog->deleteAll($delete_conditions, FALSE);

        $this->MasterLog->clear();
    }
}