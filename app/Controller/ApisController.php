<?php

App::uses('AppController', 'Controller');

class ApisController extends AppController {
    public $autoRender = true;
    public $autoLayout = false;
    public $output = NULL;
    public $layout = 'ajax';

    public function beforeFilter($options = array()){
        if(!(Configure::read('debug') || $this->request->is('post') || $this->request->is('ajax'))) return $this->redirect('/');
    }

    public function beforeRender($options = array()){
        header('Content-type: text/json');
        echo json_encode($this->output);
        exit;
    }

    public function getHotline(){
        $phone = @$this->request->data['phone'];

        $this->loadModel('MasterHotline');

        $this->output = $this->MasterHotline->find(
            'first',
            array(
                'fields' => array(
                    'MasterHotline.id',
                    'MasterHotline.hotline',
                    'MasterHotline.created'
                ),
                'conditions' => array(
                    'MasterHotline.active_flag' => true
                )
            )
        );

        if(!empty($phone) && !empty($this->output)){
            $phone = preg_replace('/[^\d]/', '', $phone);
            $phone = preg_replace('/^(0|84|840)/', '+84', $phone);

            $this->loadModel('HotlineRequest');
            $this->HotlineRequest->save(array(
                'hotline' => $this->output['MasterHotline']['hotline'],
                'number' => $phone
            ));
        }
    }

    public function getStats(){
        $this->loadModel('MasterPoint');

        $top_groups = $this->MasterPoint->getTopGroups(5);
        $top_users = $this->MasterPoint->getTopUsers(5);

        $this->output = array('groups' => $top_groups, 'users' => $top_users);
    }

    public function getUserPoints(){
        $this->loadModel('MasterPoint');

        $phone = preg_replace('/[^\d]/', '', @$this->request->data['phone']);
        $phone = preg_replace('/^(0|84|840)/', '+84', $phone);

        $result = $this->MasterPoint->getTopUsers(5, array(
            'MasterPoint.number' => $phone
        ));

        if(empty($result)) $this->output = 0;
        else $this->output = $result[0]['MasterPoint']['points'];
    }

    public function getTopUsers(){
        $this->loadModel('MasterPoint');

        $type = @$this->request->data['type'];
        $context = $this->getContext($type);

        if($context === NULL){
            $this->output = NULL;
            return;
        }

        $users = $user = $group = $group_members = array();

        if($type == 'daily'){
            $users = $this->MasterPoint->getTopUsers(250, $context);

            if($context['MasterPoint.report_date'] < '2014-06-25'){
                $validGroups = $this->MasterPoint->getValidGroups(array(
                    'MasterPoint.group_code' => Configure::read('GROUP_SECTIONS.2014-06-25')
                ));
            }else if($context['MasterPoint.report_date'] < '2014-07-01'){
                $validGroups = $this->MasterPoint->getValidGroups(array(
                    'MasterPoint.group_code' => Configure::read('GROUP_SECTIONS.2014-07-01')
                ));
            }else{
                $validGroups = $this->MasterPoint->getValidGroups();
            }
        }else{
            if(in_array($type, array('week1', 'week2', 'week3'))){
                $validGroups = $this->MasterPoint->getValidGroups(array(
                    'MasterPoint.group_code' => Configure::read('GROUP_SECTIONS.2014-06-25')
                ));
            }else if($type == 'week4'){
                $validGroups = $this->MasterPoint->getValidGroups(array(
                    'MasterPoint.group_code' => Configure::read('GROUP_SECTIONS.2014-07-01')
                ));
            }else{
                $validGroups = $this->MasterPoint->getValidGroups();
            }
        }

        $user = $this->MasterPoint->getTopUsers(1, $context);

        if(!empty($user)){
            $user = array_pop($user);
        }

        if(!empty($validGroups)){
            $groups = $this->MasterPoint->getTopGroups($type == 'week1' || $type == 'daily' ? 1 : 2, array($context, 'MasterPoint.group_code' => array_keys($validGroups)));

            foreach($groups as $i => $group){
                $groups[$i]['MasterGroup']['players'] = $validGroups[$group['MasterPoint']['group_code']];
                // $group_members = $this->MasterPoint->getTopUsers(1000, array($context, 'MasterPoint.group_code' => $group['MasterGroup']['group_code']));
            }
        }

        $this->output = compact('users', 'user', 'groups', 'group_members', 'validGroups');
    }


    public function getGroupUser($group){
        $this->loadModel('MasterPoint');

        if(isset($this->request->data['group_code'])){
            $group = $this->request->data['group_code'];
        }

        $this->output = $this->MasterPoint->getGroupUsers($group);
    }

    public function test(){
        $this->loadModel('MasterPoint');
        $type = 'week4';
        $this->request->data['date'] = '2014/06/23';
        $context = $this->getContext($type);

        if($context === NULL){
            $this->output = NULL;
            return;
        }

        $members = $this->MasterPoint->getTopUsersForReport(250, $context);
        $groups = array();
        $group_members = array();

        if($type == 'daily'){
            if($context['MasterPoint.report_date'] < '2014-06-25'){
                $validGroups = $this->MasterPoint->getValidGroups(array(
                    'MasterPoint.group_code' => Configure::read('GROUP_SECTIONS.2014-06-25')
                ));
            }else if($context['MasterPoint.report_date'] < '2014-07-01'){
                $validGroups = $this->MasterPoint->getValidGroups(array(
                    'MasterPoint.group_code' => Configure::read('GROUP_SECTIONS.2014-07-01')
                ));
            }else{
                $validGroups = $this->MasterPoint->getValidGroups();
            }
        }else{
            if(in_array($type, array('week1', 'week2', 'week3'))){
                $validGroups = $this->MasterPoint->getValidGroups(array(
                    'MasterPoint.group_code' => Configure::read('GROUP_SECTIONS.2014-06-25')
                ));
            }else if($type == 'week4'){
                $validGroups = $this->MasterPoint->getValidGroups(array(
                    'MasterPoint.group_code' => Configure::read('GROUP_SECTIONS.2014-07-01')
                ));
            }else{
                $validGroups = $this->MasterPoint->getValidGroups();
            }
        }

        if(!empty($validGroups)){
            $groups = $this->MasterPoint->getTopGroups(10, $context + array('MasterPoint.group_code' => array_keys($validGroups)));
            $group_ids = array();

            foreach($groups as $i => $group){
                $groups[$i]['MasterGroup']['players'] = $validGroups[$group['MasterGroup']['group_code']];
                $groups[$i]['members'] = $this->MasterPoint->getGroupUsers($group['MasterGroup']['group_code']);
            }

            $group_members[$group['MasterGroup']['group_code']] = $groups[$i]['members'];
        }

        $csv_data = array();
        $csv_member = array();

        // members
        $csv_data[] = array('TOP ' . count($members) . ' MEMBERS');
        $csv_data[] = array('#', 'Phone', 'Is Bot', 'Points', 'Viber Name', 'Read Name', 'Device', 'Address');

        foreach($members as $i => $mem){
            $csv_data[] = array(
                $i + 1,
                "'" . $mem['MasterPoint']['raw_number'],
                $mem['MasterPoint']['virtual_flag'] ? 'YES' : 'NO',
                $mem['MasterPoint']['points'],
                $mem['MasterUser']['name'],
                $mem['MasterUser']['real_name'],
                $mem['MasterUser']['device'],
                $mem['MasterUser']['address']
            );
        }

        $csv_data[] = array();
        $csv_data[] = array();

        // groups
        $csv_data[] = array('TOP ' . count($groups) . ' VALID GROUPS');
        $csv_data[] = array('#', 'Group Name', 'Group ID', 'Points', 'Members');

        foreach($groups as $i => $group){
            $csv_data[] = array(
                $i + 1,
                $group['MasterGroup']['group_name'],
                "'" . $group['MasterGroup']['group_code'],
                $group['MasterPoint']['points'],
                $group['MasterGroup']['players']
            );

            $csv_member[] = array('Member of ' . $group['MasterGroup']['group_name'] . ' [' . $group['MasterGroup']['group_code'] . ']');
            $csv_member[] = array('#', 'Phone', 'Is Bot', 'Viber Name', 'Read Name', 'Device', 'Address');
            foreach($group['members'] as $i => $mem){
                $csv_member[] = array(
                    $i + 1,
                    "'" . $mem['MasterPoint']['raw_number'],
                    $mem['MasterPoint']['virtual_flag'] ? 'YES' : 'NO',
                    $mem['MasterUser']['name'],
                    $mem['MasterUser']['real_name'],
                    $mem['MasterUser']['device'],
                    $mem['MasterUser']['address']
                );
            }
            $csv_member[] = array();
        }

        $csv_data[] = array();
        $csv_data[] = array();

        foreach($csv_member as $line){
            $csv_data[] = $line;
        }

        // $csv_data[] = $group_members;
        $filename = 'test.csv';
        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
        echo $this->array2csv($csv_data); exit;
    }

    public function test2($exclude_bots = FALSE){
        set_time_limit(0);
        ini_set('memory_limit', '256M');

        $this->loadModel('MasterPoint');
        $default_context = array();

        if(empty($exclude_bots)){
            $default_context['MasterPoint.virtual_flag'] = 0;
        }

        $date = strtotime('2014-06-04');
        $end_date = strtotime('2014-07-09');
        $csv_data = array();

        while ($date <= $end_date) {
            $report_date = date('Y-m-d', $date);
            $date = $date + 86400;
            $context = Set::merge($default_context, array('MasterPoint.report_date' => $report_date));
            $members = $this->MasterPoint->getTopUsersForReport(10, $context);

            // members
            $csv_data[] = array('Top ' . count($members) . ' members of ' . $report_date);
            $csv_data[] = array('#', 'Phone', 'Is Bot', 'Points', 'Viber Name', 'Read Name', 'Device', 'Address');

            foreach($members as $i => $mem){
                $csv_data[] = array(
                    $i + 1,
                    "'" . $mem['MasterPoint']['raw_number'],
                    $mem['MasterPoint']['virtual_flag'] ? 'YES' : 'NO',
                    $mem['MasterPoint']['points'],
                    $mem['MasterUser']['name'],
                    $mem['MasterUser']['real_name'],
                    $mem['MasterUser']['device'],
                    $mem['MasterUser']['address']
                );
            }

            unset($context);
            unset($members);

            $csv_data[] = array();
            $csv_data[] = array();
        }

        $filename = 'test.csv';

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
        echo $this->array2csv($csv_data); exit;
    }

    public function test3($exclude_bots = FALSE){
        set_time_limit(0);
        ini_set('memory_limit', '256M');

        $this->loadModel('MasterPoint');
        $context = array('MasterPoint.report_date <' => '2014-07-10');

        if(empty($exclude_bots)){
            $context['MasterPoint.virtual_flag'] = 0;
        }

        $csv_data = array();
        $members = $this->MasterPoint->getTopUsersForReport(30, $context);

        // members
        $csv_data[] = array('Top ' . count($members) . ' members');
        $csv_data[] = array('#', 'Phone', 'Is Bot', 'Points', 'Viber Name', 'Read Name', 'Device', 'Address');

        foreach($members as $i => $mem){
            $csv_data[] = array(
                $i + 1,
                "'" . $mem['MasterPoint']['raw_number'],
                $mem['MasterPoint']['virtual_flag'] ? 'YES' : 'NO',
                $mem['MasterPoint']['points'],
                $mem['MasterUser']['name'],
                $mem['MasterUser']['real_name'],
                $mem['MasterUser']['device'],
                $mem['MasterUser']['address']
            );
        }

        $filename = 'topall.csv';

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
        echo $this->array2csv($csv_data); exit;
    }

    protected function getContext($type = ''){
        $context = array();

        switch($type){
            case 'daily':
                $date = date('Y-m-d', time() - 86400);

                if(isset($this->request->data['date'])){
                    $input_date = explode('-', $this->request->data['date']);

                    if(count($input_date) == 3){
                        $input_date = "{$input_date[2]}-{$input_date[1]}-{$input_date[0]}";
                        $user_date = strtotime($input_date);

                        if($user_date) $date = date('Y-m-d', $user_date);
                    }
                }

                $context = array(
                    'MasterPoint.report_date' => $date,
                    'MasterPoint.report_date <' => date('Y-m-d 00:00:00')
                );

                break;

            case 'week1':
                if(time() < strtotime('2014-06-11 06:00:00')){
                    $context = NULL;
                    return;
                }
                $context = array(
                    'MasterPoint.report_date BETWEEN ? AND ?' => array('2014-06-04', '2014-06-10')
                );
                break;

            case 'week2':
                if(time() < strtotime('2014-06-18 06:00:00')){
                    $context = NULL;
                    return;
                }
                $context = array(
                    'MasterPoint.report_date BETWEEN ? AND ?' => array('2014-06-11', '2014-06-17'),
                    // 'MasterPoint.number <>' => array('+841682448494')
                );
                break;

            case 'week3':
                if(time() < strtotime('2014-06-25 06:00:00')){
                    $context = NULL;
                    return;
                }
                $context = array(
                    'MasterPoint.report_date BETWEEN ? AND ?' => array('2014-06-18', '2014-06-24'),
                    'MasterPoint.number <>' => array('+841682448494', '+84918112919')
                );
                break;

            case 'week4':
                if(time() < strtotime('2014-07-02 23:00:00')){
                    $context = NULL;
                    return;
                }
                $context = array(
                    'MasterPoint.report_date BETWEEN ? AND ?' => array('2014-06-25', '2014-07-01'),
                    'MasterPoint.number <>' => array('+841682448494', '+84918112919', '+84988777822')
                );
                break;

            case 'week5':
                if(time() < strtotime('2014-07-09 06:00:00')){
                    $context = NULL;
                    return;
                }
                $context = array(
                    'MasterPoint.report_date BETWEEN ? AND ?' => array('2014-07-02', '2014-07-08')
                );
                break;

            case 'all':
                if(time() < strtotime('2014-07-14 04:00:00')){
                    $context = NULL;
                    return;
                }
                $context = array(
                    'MasterPoint.report_date BETWEEN ? AND ?' => array('2014-06-04', '2014-07-08')
                );
                break;

            default:
                $context = NULL;
                return;
        }

        return $context;
    }

    protected function array2csv(array &$array)
    {
       if (count($array) == 0) {
         return null;
       }
       ob_start();
       $df = fopen("php://output", 'w');
       fputcsv($df, array_keys(reset($array)));
       foreach ($array as $row) {
          fputcsv($df, $row);
       }
       fclose($df);
       return ob_get_clean();
    }
}