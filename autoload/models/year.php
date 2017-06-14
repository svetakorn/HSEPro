<?php
namespace models;

class year{

	static function getYears(){
		$db = \F3::get('DB');
		$years=$db->exec('SELECT * FROM year');
		return $years;
	}
}


