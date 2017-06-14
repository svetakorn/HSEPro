<?php
namespace controllers;

class search extends basecontroller{
	

	function main($f3){
		$id = $f3->get('id_user');
		$hw = \models\checkhomework::getHomeworkForTeacher($id);
		
		$f3->set("id_user", $id);
		$f3->set("homework", $hw);
		$role = \models\user::getRoleIdById($id);
		$f3->set("id_role", $role);
		$this->showPage($f3, 'Главная', null, "Студенческие работы", "Поиск по студенческим работам", 350, 'search/search.html');
		
	}
}

