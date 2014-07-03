<?php
/**
 * PhoneNumberFixture
 *
 */
class PhoneNumberFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'PhoneNumber';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'Number' => array('type' => 'string', 'null' => false, 'length' => 30, 'key' => 'primary'),
		'IsViberNumber' => array('type' => 'text', 'null' => false, 'default' => '0'),
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
			'IsViberNumber' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);

}
