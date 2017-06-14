<?php
namespace models;

class lesson{

	static function uploadHomework($file, $user, $array){

		$db = \F3::get("DB");

		$time = date("Y-m-d H-i-s", strtotime("+1 hour"));
		if (($file[name]!='') && ($file[name]!=null) && (isset($file[name]))){
			$teacher = $db->exec("SELECT * from user where email = :email", ["email" => $array[email]])[0]['id'];
			if($teacher != null){
				$fn = explode(".", $file[name]);
				$ext = end($fn);
				$name =  helpers::translit( str_replace(" ", "-", $user[fullname]) ).date("_Y-m-d H-i-s", strtotime("+1 hour"));
				$file[name] = $name.'.'.$ext;

				$studentdir = "./files/homeworks/";
				if(!is_dir($studentdir)) mkdir($studentdir, 0777, true);
				$uploaddir = "./files/homeworks/";

				$route= $uploaddir . $name.'.'.$ext;

				$fullname = $uploaddir.$file[name];

				if(!move_uploaded_file($file['tmp_name'], $fullname)){
					return 700;
				} else {
					$db->exec("INSERT INTO homework (id_student, id_teacher, filename, student_comment, type_file, route, subject, uploadtime) VALUES ('$user[id]', '$teacher',
						'$file[name]', '$array[text]', '$ext', '$route', '$array[subject]', '$time')");

					$db->exec("INSERT INTO user_notification (id_user, id_notification, id_student, id_teacher) VALUES ('$teacher', 2, '$user[id]', '$teacher')");

						return 709;
					}
				} return 708;

			} 
		}
	}

	