<?php
App::uses('MasterHotline', 'Model');

/**
 * MasterHotline Test Case
 *
 */
class MasterHotlineTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.master_hotline'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MasterHotline = ClassRegistry::init('MasterHotline');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MasterHotline);

		parent::tearDown();
	}

}
