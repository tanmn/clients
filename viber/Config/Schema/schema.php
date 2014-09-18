<?php
class ViberSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $master_groups = array(
		'group_code' => array('type' => 'text', 'null' => false, 'key' => 'primary'),
        'group_name' => array('type' => 'text', 'null' => true),
		'agent' => array('type' => 'text', 'null' => true),
        'is_whitelist' => array('type' => 'integer', 'null' => true, 'default' => 0),
		'is_private' => array('type' => 'integer', 'null' => true, 'default' => 0),
        'created' => array('type' => 'text', 'null' => true),
		'indexes' => array(

		),
		'tableParameters' => array()
	);

	public $master_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'agent' => array('type' => 'text', 'null' => true),
        'group_code' => array('type' => 'text', 'null' => true),
		'number' => array('type' => 'text', 'null' => true),
		'report_date' => array('type' => 'text', 'null' => true),
		'msg_type' => array('type' => 'text', 'null' => true),
		'quantity' => array('type' => 'integer', 'null' => true, 'default' => 0),
        'is_virtual' => array('type' => 'integer', 'null' => true, 'default' => 0),
		'created' => array('type' => 'text', 'null' => true),
		'indexes' => array(

		),
		'tableParameters' => array()
	);

	public $master_users = array(
		'number' => array('type' => 'text', 'null' => false, 'key' => 'primary'),
		'is_viber' => array('type' => 'integer', 'null' => true, 'default' => 0),
		'viber_name' => array('type' => 'text', 'null' => true),
		'created' => array('type' => 'text', 'null' => true),
		'indexes' => array(

		),
		'tableParameters' => array()
	);

}
