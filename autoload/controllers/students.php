<?php
namespace controllers;

	class students extends basecontroller{
		
		
		
		static function addComment($f3){
			$id = $f3->get("PARAMS.id");
			$text = $_POST['text'];
			$result = \models\students::addComment($id, $text);
			var_dump($_POST);
		}
}
		