<?php
/**
 * SettingFixture
 *
 */
class SettingFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'Settings';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'SettingID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'SettingTitle' => array('type' => 'string', 'null' => false, 'length' => 100),
		'SettingType' => array('type' => 'string', 'null' => false, 'length' => 20),
		'SettingValue' => array('type' => 'string', 'null' => true, 'length' => 400),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'SettingID' => 1,
			'SettingTitle' => 'Lorem ipsum dolor sit amet',
			'SettingType' => 'Lorem ipsum dolor ',
			'SettingValue' => 'Lorem ipsum dolor sit amet'
		),
	);

}
