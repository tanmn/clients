<?php
App::uses('AppModel', 'Model');
/**
 * Created by JetBrains PhpStorm.
 * User: namnguyen
 * Date: 6/5/14
 * Time: 11:11 AM
 * To change this template use File | Settings | File Templates.
 */
Class UserQrcode extends AppModel {
    
    public function getQrcode($abc){

        $sql = array(
            "conditions"=> array(
                "telephone"=> $abc,
            )
        );
        $data = $this->find("all",$sql);

        $this->set("data",$data);
        return $data;
    }

}?>