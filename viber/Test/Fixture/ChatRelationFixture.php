<?php
/**
 * ChatRelationFixture
 *
 */
class ChatRelationFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'ChatRelation';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'ChatID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'Number' => array('type' => 'string', 'null' => false, 'length' => 30, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('ChatID', 'Number'), 'unique' => 1)
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
			'Number' => 'Lorem ipsum dolor sit amet'
		),
	);

}
