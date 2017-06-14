<?php
namespace controllers;

class user extends basecontroller{


	function edit($f3){
		$id = $f3->get('PARAMS.id');
		$user = \models\user::getInfoById($id);
		$f3->set('single_user', $user);

		$student = \models\student::getInfoById($id);
		$f3->set('single_student', $student);

		$years= \models\year::getYears();
		$f3->set('year', $years);
		$programs= \models\program::getPrograms();
		$f3->set('program', $programs);
		$name = $user['fullname'] != null ? $user['fullname'] : $user['login']; 


		$this->showPage($f3, 'Пользователи', $name, 'Изменить', $name, 150, 'user/edit.html');
	}

	function editauth($f3){
		$id = $f3->get('PARAMS.id');
		echo \models\user::editauth($id, $_POST['login'], $_POST['email'], $_POST['password'], $_POST['fullname'], $_POST['year'], $_POST['program']);
	}


	
}

