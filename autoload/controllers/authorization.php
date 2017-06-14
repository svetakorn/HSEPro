<?php
namespace controllers;

class authorization{




	static function login($f3){
		$template = new \Template();
		echo $template->render('authorization/login.html');
	}

	

	static function authUser($f3){
		$check = \models\user::authorization($_POST['login'],  $_POST['password']);

		if($check != 101 && $check != 900){
			setcookie("auth_tok", $check, time()+60*60);
			$_SESSION['auth_tok'] = $check;
			echo(109);
			die();
		}
		echo($check);
	}

	static function forgot($f3){
		$template = new \Template();
		echo $template->render('authorization/forgot.html');
	}


	static function forgotSendEmail($f3){
		echo \models\user::forgotSendEmail($_POST['email']);
	}

	static function resetPassword($f3){
		$template = new \Template();
		$token = $f3->get("PARAMS.token");

		$f3->set('token', $token);
		$page = 'authorization/'; 
		$page .= \models\user::checkResetToken($token) ? 'reset.html' : 'badtoken.html';
		echo $template->render($page);

	}

	static function submitNewPassword($f3){

		echo \models\user::setNewPassword($f3->get("PARAMS.token"), $_POST['password']);
	}
	static function register($f3){

		$years= \models\year::getYears();
		$f3->set('year', $years);
		$programs= \models\program::getPrograms();
		$f3->set('program', $programs);
		echo \Template::instance()->render('authorization/register.html');
	}


	static function uploadavatar($f3){
		
		$response = \models\user::uploadAvatar($_FILES['avatar'], $_POST['id']);
		echo $response;
	}

	static function createNewUser($f3){
		echo \models\user::registration($_POST['login'], 
			$_POST['email'], 
			$_POST['password'], 
			$_POST['fullname'],
			$_POST['year'],
			$_POST['program']);
	}



}