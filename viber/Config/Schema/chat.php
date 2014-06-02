<?php 
class ViberSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $Calls = array(
		'EventID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'Type' => array('type' => 'text', 'null' => false),
		'Duration' => array('type' => 'text', 'null' => true),
		'Status' => array('type' => 'text', 'null' => false),
		'IsViberCall' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'IsTransferred' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

	public $ChatInfo = array(
		'ChatID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'Name' => array('type' => 'string', 'null' => false, 'length' => 200),
		'Token' => array('type' => 'string', 'null' => false, 'length' => 50),
		'Flags' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'TimeStamp' => array('type' => 'text', 'null' => false),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

	public $ChatRelation = array(
		'ChatID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'Number' => array('type' => 'string', 'null' => false, 'length' => 30, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('ChatID', 'Number'), 'unique' => 1)
		),
		'tableParameters' => array()
	);

	public $Contact = array(
		'ContactID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'FirstName' => array('type' => 'string', 'null' => false, 'length' => 40),
		'SecondName' => array('type' => 'string', 'null' => false, 'length' => 40),
		'AvatarPath' => array('type' => 'string', 'null' => true, 'length' => 500),
		'RingtonePath' => array('type' => 'string', 'null' => true, 'length' => 500),
		'IsNotAdded' => array('type' => 'text', 'null' => false, 'default' => '0'),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

	public $ContactRelation = array(
		'ContactID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'Number' => array('type' => 'string', 'null' => false, 'length' => 30, 'key' => 'primary'),
		'TypeName' => array('type' => 'string', 'null' => false, 'length' => 80),
		'IsFavoriteNumber' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('ContactID', 'Number'), 'unique' => 1)
		),
		'tableParameters' => array()
	);

	public $DownloadFile = array(
		'DownloadID' => array('type' => 'string', 'null' => false, 'length' => 100, 'key' => 'primary'),
		'EventID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'BucketName' => array('type' => 'string', 'null' => false, 'length' => 200),
		'FileType' => array('type' => 'string', 'null' => false, 'length' => 10),
		'DownloadStatus' => array('type' => 'text', 'null' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => array('DownloadID', 'EventID'), 'unique' => 1)
		),
		'tableParameters' => array()
	);

	public $Events = array(
		'EventID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'TimeStamp' => array('type' => 'text', 'null' => false),
		'Direction' => array('type' => 'text', 'null' => false),
		'Type' => array('type' => 'text', 'null' => false),
		'ContactLongitude' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'ContactLatitude' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'ChatID' => array('type' => 'integer', 'null' => true),
		'Number' => array('type' => 'string', 'null' => true, 'length' => 30),
		'IsSessionLifeTime' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'Flags' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'Token' => array('type' => 'text', 'null' => false),
		'IsRead' => array('type' => 'text', 'null' => false, 'default' => '0'),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

	public $Messages = array(
		'EventID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'Type' => array('type' => 'text', 'null' => false),
		'Status' => array('type' => 'integer', 'null' => false),
		'Subject' => array('type' => 'string', 'null' => true, 'length' => 500),
		'Body' => array('type' => 'string', 'null' => true, 'length' => 5000),
		'Flag' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'PayloadPath' => array('type' => 'string', 'null' => true, 'length' => 1000),
		'ThumbnailPath' => array('type' => 'string', 'null' => true, 'length' => 100),
		'StickerID' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'PttID' => array('type' => 'string', 'null' => true, 'length' => 100),
		'PttStatus' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'PttDuration' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

	public $OriginNumberInfo = array(
		'Number' => array('type' => 'string', 'null' => false, 'length' => 30, 'key' => 'primary'),
		'ClientName' => array('type' => 'string', 'null' => true, 'length' => 1000),
		'AvatarPath' => array('type' => 'string', 'null' => true, 'length' => 2000),
		'DownloadID' => array('type' => 'string', 'null' => true, 'length' => 60),
		'indexes' => array(
			'PRIMARY' => array('column' => 'Number', 'unique' => 1)
		),
		'tableParameters' => array()
	);

	public $PhoneNumber = array(
		'Number' => array('type' => 'string', 'null' => false, 'length' => 30, 'key' => 'primary'),
		'IsViberNumber' => array('type' => 'text', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'Number', 'unique' => 1)
		),
		'tableParameters' => array()
	);

	public $Settings = array(
		'SettingID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'SettingTitle' => array('type' => 'string', 'null' => false, 'length' => 100),
		'SettingType' => array('type' => 'string', 'null' => false, 'length' => 20),
		'SettingValue' => array('type' => 'string', 'null' => true, 'length' => 400),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

	public $UploadFile = array(
		'File' => array('type' => 'string', 'null' => false, 'length' => 3000, 'key' => 'primary'),
		'EventID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'FileType' => array('type' => 'string', 'null' => false, 'length' => 10),
		'FileSize' => array('type' => 'text', 'null' => false),
		'CheckSum' => array('type' => 'string', 'null' => false, 'length' => 100),
		'Offset' => array('type' => 'text', 'null' => true, 'default' => '0'),
		'Seq' => array('type' => 'string', 'null' => false, 'length' => 100),
		'MediaType' => array('type' => 'text', 'null' => false),
		'UploadType' => array('type' => 'text', 'null' => false),
		'UploadStatus' => array('type' => 'text', 'null' => false),
		'UDID' => array('type' => 'string', 'null' => false, 'length' => 100),
		'indexes' => array(
			'PRIMARY' => array('column' => array('File', 'EventID'), 'unique' => 1)
		),
		'tableParameters' => array()
	);

	public $Versions = array(
		'VersionID' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'VersionNumber' => array('type' => 'string', 'null' => true, 'length' => 20),
		'TimeStamp' => array('type' => 'text', 'null' => false),
		'Status' => array('type' => 'text', 'null' => false),
		'Title' => array('type' => 'string', 'null' => true, 'length' => 200),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

	public $sqlite_sequence = array(
		'name' => array('type' => 'text', 'null' => true),
		'seq' => array('type' => 'text', 'null' => true),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

}
