<?php
App::uses('UploadFile', 'Model');

/**
 * UploadFile Test Case
 *
 */
class UploadFileTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.upload_file'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UploadFile = ClassRegistry::init('UploadFile');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UploadFile);

		parent::tearDown();
	}

}
