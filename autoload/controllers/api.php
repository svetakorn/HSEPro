<?php

namespace controllers;

class api{
	
	static function auth($f3){
		$response = \models\api::getUserId($_POST['login'], $_POST['password']);
		echo json_encode($response);
	}
	
	
	static function getNotifications($f3){
		$response = \models\api::getNotifications($_POST['id_user']);
		echo json_encode($response);
	}

	static function setNotificationInfo($f3){
		$response = \models\api::setNotificationInfo($_POST['id_user'], $_POST['guid']);
		echo json_encode($response);
	}
	

}