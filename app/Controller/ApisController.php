<?php

App::uses('AppController', 'Controller');

class ApisController extends AppController {
    public $autoRender = true;
    public $autoLayout = false;
    public $output = NULL;
    public $layout = 'ajax';

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
}