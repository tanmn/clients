<?php
/**
 * UploadFileFixture
 *
 */
class UploadFileFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'UploadFile';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'File' => array('type' => 'string', 'null' => false, 'length' => 3000, 'key' => 'primary'),
		'EventID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'FileType' => array('type' => 'string', 'null' => false, 'length' => 10),
		'FileSize' => array('type' => 'text', 'null' => false),
		'CheckSum' => array('type' => 'string', 'null' => false, 'length' => 100),
		'Offset' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'Seq' => array('type' => 'string', 'null' => false, 'length' => 100),
		'MediaType' => array('type' => 'text', 'null' => false),
		'UploadType' => array('type' => 'text', 'null' => false),
		'UploadStatus' => array('type' => 'text', 'null' => false),
		'UDID' => array('type' => 'string', 'null' => false, 'length' => 100),
		'indexes' => array(
			'PRIMARY' => array('column' => array('File', 'EventID'), 'unique' => 1)
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
			'File' => 'Lorem ipsum dolor sit amet',
			'EventID' => 1,
			'FileType' => 'Lorem ip',
			'FileSize' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'CheckSum' => 'Lorem ipsum dolor sit amet',
			'Offset' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'Seq' => 'Lorem ipsum dolor sit amet',
			'MediaType' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'UploadType' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'UploadStatus' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'UDID' => 'Lorem ipsum dolor sit amet'
		),
	);

}
