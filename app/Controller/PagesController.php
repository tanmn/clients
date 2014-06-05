<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {
	public $helpers = array('QrCode');

    public function beforeFilter() {
    	$this->set('active', '');
	}


    public function home(){

        $this->set('title_for_layout', 'Trang chủ');
        $this->set('active', 'home');
    }


    public function results(){
        $this->loadModel('MasterPoint');

        $todate = date('Y-m-d');
        $available_date = $this->MasterPoint->getAvailableDate();

        $this->set('title_for_layout', 'Kết quả');
        $this->set('active', 'results');
        $this->set('available_date', array_combine($available_date, $available_date));
    }


    public function sticker(){

        $this->set('title_for_layout', 'Nhãn Dán');
        $this->set('active', 'stickers');
    }


    public function events(){

        $this->set('title_for_layout', 'Sự Kiện');
        $this->set('active', 'events');
    }


    public function condition(){

        $this->set('title_for_layout', 'Thể Lệ Tham Dự');
        $this->set('active', 'conditions');
    }


    public function sticker1(){

        $phone = $_POST["phone"];
        $phone = preg_replace('/[^\d]/', '',$phone);
        $phone = preg_replace('/^(0|84)/', '+84', $phone);
        $this->loadModel('UserQrcode');

        $data = $this->UserQrcode->getQrcode($phone);
        if(count($data) == 0){
            $result = array();
            $result["error"] = "Số điện thoại của bạn không trúng thưởng hoặc chưa tham gia chương trình.";
            $result["status"] = false;
            die(json_encode($result));
        }

    }


	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
}
