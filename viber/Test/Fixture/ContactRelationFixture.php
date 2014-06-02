<?php
/**
 * ContactRelationFixture
 *
 */
class ContactRelationFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'ContactRelation';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'ContactID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'Number' => array('type' => 'string', 'null' => false, 'length' => 30, 'key' => 'primary'),
		'TypeName' => array('type' => 'string', 'null' => false, 'length' => 80),
		'IsFavoriteNumber' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('ContactID', 'Number'), 'unique' => 1)
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
			'Number' => 'Lorem ipsum dolor sit amet',
			'TypeName' => 'Lorem ipsum dolor sit amet',
			'IsFavoriteNumber' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);

}
