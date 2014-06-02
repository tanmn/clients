<?php
/**
 * ChatInfoFixture
 *
 */
class ChatInfoFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'ChatInfo';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'ChatID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'Name' => array('type' => 'string', 'null' => false, 'length' => 200),
		'Token' => array('type' => 'string', 'null' => false, 'length' => 50),
		'Flags' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'TimeStamp' => array('type' => 'text', 'null' => false),
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
			'ChatID' => 1,
			'Name' => 'Lorem ipsum dolor sit amet',
			'Token' => 'Lorem ipsum dolor sit amet',
			'Flags' => 1,
			'TimeStamp' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);

}
