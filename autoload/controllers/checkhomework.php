<?php
namespace controllers;

	class checkhomework extends basecontroller{
	
		
		function main($f3){
		$id = $f3->get('id_user');
		$hw = \models\checkhomework::getHomeworkForTeacher($id);
		$f3->set("homework", $hw);
			$this->showPage($f3, 'Главная', null, "Студенческие работы", "Проверка студенческих работ", 200, 'checkhomework/all.html');
		
		}
		function check($f3){
		$id = $_POST['id'];
		$response = \models\checkhomework::CheckById($id, $_POST);
		die(json_encode($response));
		}


		function forStudent($f3){
		$id = $f3->get('id_user');
		$hw = \models\checkhomework::getHomeworkForStudent($id);
		$f3->set("homework", $hw);
			$this->showPage($f3, 'Главная', null, "Студенческие работы", "Результаты проверки", 250, 'checkhomework/allforstudent.html');
		
		}

		
}
		