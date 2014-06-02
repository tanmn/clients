<?php
/**
 * ContactFixture
 *
 */
class ContactFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'Contact';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'ContactID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'FirstName' => array('type' => 'string', 'null' => false, 'length' => 40),
		'SecondName' => array('type' => 'string', 'null' => false, 'length' => 40),
		'AvatarPath' => array('type' => 'string', 'null' => true, 'length' => 500),
		'RingtonePath' => array('type' => 'string', 'null' => true, 'length' => 500),
		'IsNotAdded' => array('type' => 'text', 'null' => false, 'default' => '0'),
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
			'ContactID' => 1,
			'FirstName' => 'Lorem ipsum dolor sit amet',
			'SecondName' => 'Lorem ipsum dolor sit amet',
			'AvatarPath' => 'Lorem ipsum dolor sit amet',
			'RingtonePath' => 'Lorem ipsum dolor sit amet',
			'IsNotAdded' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);

}
