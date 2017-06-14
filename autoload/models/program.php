<?php
namespace models;

	class program{

	
	static function getPrograms(){
		$db = \F3::get('DB');
		$programs=$db->exec('SELECT * FROM program');
		return $programs;

	}
}

