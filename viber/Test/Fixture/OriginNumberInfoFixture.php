<?php
/**
 * OriginNumberInfoFixture
 *
 */
class OriginNumberInfoFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'OriginNumberInfo';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'Number' => array('type' => 'string', 'null' => false, 'length' => 30, 'key' => 'primary'),
		'ClientName' => array('type' => 'string', 'null' => true, 'length' => 1000),
		'AvatarPath' => array('type' => 'string', 'null' => true, 'length' => 2000),
		'DownloadID' => array('type' => 'string', 'null' => true, 'length' => 60),
		'indexes' => array(
			'PRIMARY' => array('column' => 'Number', 'unique' => 1)
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
			'Number' => 'Lorem ipsum dolor sit amet',
			'ClientName' => 'Lorem ipsum dolor sit amet',
			'AvatarPath' => 'Lorem ipsum dolor sit amet',
			'DownloadID' => 'Lorem ipsum dolor sit amet'
		),
	);

}
