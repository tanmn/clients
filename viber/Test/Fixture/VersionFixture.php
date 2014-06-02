<?php
/**
 * VersionFixture
 *
 */
class VersionFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'Versions';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'VersionID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'VersionNumber' => array('type' => 'string', 'null' => true, 'length' => 20),
		'TimeStamp' => array('type' => 'text', 'null' => false),
		'Status' => array('type' => 'text', 'null' => false),
		'Title' => array('type' => 'string', 'null' => true, 'length' => 200),
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
			'VersionID' => 1,
			'VersionNumber' => 'Lorem ipsum dolor ',
			'TimeStamp' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'Status' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'Title' => 'Lorem ipsum dolor sit amet'
		),
	);

}
