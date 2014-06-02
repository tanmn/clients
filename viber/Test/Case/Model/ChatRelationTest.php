<?php
App::uses('ChatRelation', 'Model');

/**
 * ChatRelation Test Case
 *
 */
class ChatRelationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chat_relation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ChatRelation = ClassRegistry::init('ChatRelation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ChatRelation);

		parent::tearDown();
	}

}
