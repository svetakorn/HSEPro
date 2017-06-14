<?php 

namespace models;

class student{
	

	private $_db;

	static function getInfoById($id){
		if($id != null){
			$db = \F3::get('DB');
			$student = $db->exec("SELECT student.id, student.id_year, student.id_program, student.id_user, year.name as year, program.name as program
				FROM student
				JOIN year ON student.id_year = year.id
				JOIN program ON student.id_program = program.id

				WHERE id_user = $id")[0];	
			if($student != null){

				return array("id"=>$student['id'], 
					"id_year" => $student['id_year'],
					"id_program" => $student['id_program'],
					"id_user" => $student['id_user'],
					"year" => $student['year'],
					"program" => $student['program']

					
					);
				
			}
				return 100; //no such user TODO: show error on client
			}
		}

}

