<?php
App::uses('ChatInfo', 'Model');

/**
 * ChatInfo Test Case
 *
 */
class ChatInfoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chat_info'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ChatInfo = ClassRegistry::init('ChatInfo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ChatInfo);

		parent::tearDown();
	}

}
