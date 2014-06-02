<?php
App::uses('DownloadFile', 'Model');

/**
 * DownloadFile Test Case
 *
 */
class DownloadFileTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.download_file'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DownloadFile = ClassRegistry::init('DownloadFile');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DownloadFile);

		parent::tearDown();
	}

}
