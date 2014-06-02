<?php
App::uses('MasterGroup', 'Model');

/**
 * MasterGroup Test Case
 *
 */
class MasterGroupTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.master_group'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MasterGroup = ClassRegistry::init('MasterGroup');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MasterGroup);

		parent::tearDown();
	}

}
