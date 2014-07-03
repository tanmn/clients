<?php
App::uses('OriginNumberInfo', 'Model');

/**
 * OriginNumberInfo Test Case
 *
 */
class OriginNumberInfoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.origin_number_info'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OriginNumberInfo = ClassRegistry::init('OriginNumberInfo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OriginNumberInfo);

		parent::tearDown();
	}

}
