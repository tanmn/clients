<?php
App::uses('AppModel', 'Model');
/**
 * PhoneNumber Model
 *
 */
class PhoneNumber extends AppModel {

    public $useDbConfig = 'viber';
    public $useTable = 'PhoneNumber';
	public $primaryKey = 'Number';
}
