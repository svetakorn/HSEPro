<?php
namespace controllers;

	class lesson extends basecontroller{
		
		
		static function uploadHomework($f3){
			$user = \models\user::getInfoById($f3->get('id_user'));
			$response = \models\lesson::uploadHomework($_FILES["fileToUpload"], $user, $_POST);
			echo $response;
		}
		
		static function deleteNotification($f3){
			$id_user = $f3->get('id_user');
			$result = \models\user::deleteNotification($id_user);
			die(json_encode($result));
		}
		static function sendNotification($f3){
			$result = \models\course::sendNotification($_POST);
			die(json_encode($result));
		}

		
		static function forElasticUpload($f3){
		$id = $f3->get('id_user');
		$hw = \models\checkhomework::getLastHomeworkForStudent($id);
		echo json_encode($hw);
		}

		static function forElasticStudentInfo($f3){
		$id = $f3->get('id_user');
		$st = \models\user::getStudentInfoById($id);
		echo json_encode($st);
		}
		
	}