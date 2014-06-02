<?php
/**
 * MessageFixture
 *
 */
class MessageFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'Messages';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'EventID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'Type' => array('type' => 'text', 'null' => false),
		'Status' => array('type' => 'integer', 'null' => false),
		'Subject' => array('type' => 'string', 'null' => true, 'length' => 500),
		'Body' => array('type' => 'string', 'null' => true, 'length' => 5000),
		'Flag' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'PayloadPath' => array('type' => 'string', 'null' => true, 'length' => 1000),
		'ThumbnailPath' => array('type' => 'string', 'null' => true, 'length' => 100),
		'StickerID' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'PttID' => array('type' => 'string', 'null' => true, 'length' => 100),
		'PttStatus' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'PttDuration' => array('type' => 'text', 'null' => true, 'default' => '0'),
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
			'EventID' => 1,
			'Type' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'Status' => 1,
			'Subject' => 'Lorem ipsum dolor sit amet',
			'Body' => 'Lorem ipsum dolor sit amet',
			'Flag' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'PayloadPath' => 'Lorem ipsum dolor sit amet',
			'ThumbnailPath' => 'Lorem ipsum dolor sit amet',
			'StickerID' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'PttID' => 'Lorem ipsum dolor sit amet',
			'PttStatus' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'PttDuration' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);

}
