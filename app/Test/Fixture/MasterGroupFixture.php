<?php
/**
 * MasterGroupFixture
 *
 */
class MasterGroupFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'group_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hotline' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'group_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'group_code', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'group_code' => 'Lorem ipsum dolor sit amet',
			'hotline' => 'Lorem ipsum d',
			'group_name' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-06-02 09:21:01',
			'modified' => '2014-06-02 09:21:01'
		),
	);

}
