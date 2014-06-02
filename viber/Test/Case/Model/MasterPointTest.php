<?php
App::uses('MasterPoint', 'Model');

/**
 * MasterPoint Test Case
 *
 */
class MasterPointTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.master_point'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MasterPoint = ClassRegistry::init('MasterPoint');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MasterPoint);

		parent::tearDown();
	}

}
