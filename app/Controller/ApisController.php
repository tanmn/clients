<?php

App::uses('AppController', 'Controller');

class ApisController extends AppController {
    public $autoRender = true;
    public $autoLayout = false;
    public $output = NULL;
    public $layout = 'ajax';

    public function beforeFilter($options = array()){
        if(!($this->request->is('post') || $this->request->is('ajax'))) return $this->redirect('/');
    }

    public function beforeRender($options = array()){
        header('Content-type: text/json');
        echo json_encode($this->output);
        exit;
    }

    public function getHotline(){
        $this->loadModel('MasterHotline');

        $this->output = $this->MasterHotline->find(
            'first',
            array(
                'conditions' => array(
                    'MasterHotline.active_flag' => true
                )
            )
        );
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
        $phone = preg_replace('/^(0|84)/', '+84', $phone);

        $result = $this->MasterPoint->getTopUsers(5, array('number' => $phone));

        if(empty($result)) $this->output = 0;
        else $this->output = $result[0]['MasterPoint']['points'];
    }

    public function getTopUsers(){
        $this->loadModel('MasterPoint');

        $type = $this->request->data['type'];
        $context = array();

        switch($type){
            case 'all': break;

            case 'daily':
                $date = date('Y-m-d');

                if(isset($this->request->data['date'])){
                    $user_date = strtotime($this->request->data['date']);
                    if($user_date) $date = date('Y-m-d', $user_date);
                }

                $context = array(
                    'MasterPoint.report_date' => $date
                );
                break;

            case 'week1':
                $context = array(
                    'MasterPoint.report_date BETWEEN ? AND ?' => array('2014-06-04', '2014-06-10')
                );
                break;

            case 'week2':
                $context = array(
                    'MasterPoint.report_date BETWEEN ? AND ?' => array('2014-06-11', '2014-06-17')
                );
                break;

            case 'week3':
                $context = array(
                    'MasterPoint.report_date BETWEEN ? AND ?' => array('2014-06-18', '2014-06-24')
                );
                break;

            case 'week4':
                $context = array(
                    'MasterPoint.report_date BETWEEN ? AND ?' => array('2014-06-25', '2014-07-01')
                );
                break;

            default:
                $this->output = NULL;
                return;
        }

        $result = $this->MasterPoint->getTopUsers(250, $context);

        $this->output = $result;
    }
}