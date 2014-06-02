<?php
App::uses('ContactRelation', 'Model');

/**
 * ContactRelation Test Case
 *
 */
class ContactRelationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.contact_relation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ContactRelation = ClassRegistry::init('ContactRelation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ContactRelation);

		parent::tearDown();
	}

}
