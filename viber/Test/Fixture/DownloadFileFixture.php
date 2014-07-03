<?php
/**
 * DownloadFileFixture
 *
 */
class DownloadFileFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'DownloadFile';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'DownloadID' => array('type' => 'string', 'null' => false, 'length' => 100, 'key' => 'primary'),
		'EventID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'BucketName' => array('type' => 'string', 'null' => false, 'length' => 200),
		'FileType' => array('type' => 'string', 'null' => false, 'length' => 10),
		'DownloadStatus' => array('type' => 'text', 'null' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => array('DownloadID', 'EventID'), 'unique' => 1)
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
			'DownloadID' => 'Lorem ipsum dolor sit amet',
			'EventID' => 1,
			'BucketName' => 'Lorem ipsum dolor sit amet',
			'FileType' => 'Lorem ip',
			'DownloadStatus' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);

}
