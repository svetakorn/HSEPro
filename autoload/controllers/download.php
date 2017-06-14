<?php
namespace controllers;

class download extends basecontroller{

	function main($f3){
		$id = $f3->get('id_user');

		$role = \models\user::getRoleIdById($id);
		

		if(array_search('1',$role) != null) {	
			
			$st = \models\user::getStudentInfoById($id);
			$f3->set("stInfo", $st);
			$this->showPage($f3, 'Главная', null, "Форма загрузки", "Загрузка студенческой работы", 100, 'lesson/lesson.html');
		}
		else {
			$id = $f3->get('id_user');
			$hw = \models\checkhomework::getHomeworkForTeacher($id);
			$f3->set("homework", $hw);
			$this->showPage($f3, 'Главная', null, "Студенческие работы", "Проверка студенческих работ", 200, 'checkhomework/all.html');
		}
	}
}