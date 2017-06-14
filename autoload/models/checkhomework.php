<?php
namespace models;

class checkhomework{

	private $_id;
	private $_lesson;
	private $_db;

	function __construct($id){
		$this->_id = $id;
		$this->_db = \F3::get('DB');
		$this->_lesson = $this->_db->exec("SELECT * FROM lesson WHERE id = $this->_id");
		if($this->_lesson[0] == null) return 300;
	}

	static function getInfoById($id){
		if($id!=null){
			$db = \F3::get("DB");
			$lesson = $db->exec("SELECT * FROM lesson 
				JOIN course ON course.id = lesson.id_course
				WHERE lesson.id = $id");
			if ($lesson!=null)
				return $lesson[0];
			else \F3::error(400);
		}

	}

	static function getHomeworkForTeacher($id){
		$db = \F3::get("DB");
		$hw = $db->exec("SELECT user.fullname, homework.id, homework.mark, homework.checked, homework.subject, homework.student_comment, homework.teacher_comment, homework.filename, homework.route, user.id as id_user, homework.uploadtime, homework.checktime, program.name as program, year.name as year FROM homework

			LEFT JOIN user ON user.id = homework.id_student
			JOIN student ON student.id_user = user.id
			JOIN year ON year.id = student.id_year
			JOIN program ON program.id = student.id_program
			WHERE homework.id_teacher = $id 

			ORDER BY checked ASC, uploadtime DESC");

		return $hw;
	}


	static function getHomeworkForStudent($id){
		$db = \F3::get("DB");
		$hw = $db->exec("SELECT user.fullname, homework.id, homework.mark, homework.checked, homework.subject, homework.student_comment, homework.teacher_comment, homework.filename, homework.route, user.id as id_user, homework.uploadtime, homework.checktime FROM homework

			LEFT JOIN user ON user.id = homework.id_teacher
			WHERE homework.id_student = $id 

			ORDER BY checked ASC, checktime DESC, uploadtime DESC");

		return $hw;
	}

	static function getLastHomeworkForStudent($id){
		$db = \F3::get("DB");
		$hw = $db->exec("SELECT user.fullname, homework.id, homework.mark, homework.checked, homework.subject, homework.student_comment, homework.teacher_comment, homework.filename, homework.route, user.id as id_user, homework.uploadtime, homework.checktime FROM homework

			LEFT JOIN user ON user.id = homework.id_teacher
			WHERE homework.id = (SELECT MAX(id) FROM homework WHERE homework.id_student = $id)")[0];

		return $hw;
	}


	static function CheckById($id, $array){
		$db = \F3::get("DB");
		$time = date("Y-m-d H-i-s", strtotime("+1 hour"));

		$db->exec("UPDATE homework SET mark = '$array[mark]', checked=1, teacher_comment = '$array[text]', checktime = '$time' WHERE (id = $id)");

		$id_student = $db->exec("SELECT homework.id_student FROM homework WHERE homework.id = $id")[0]['id_student'];
		$id_teacher = $db->exec("SELECT homework.id_teacher FROM homework WHERE homework.id = $id")[0]['id_teacher'];


		$db->exec("INSERT INTO user_notification (id_user, id_notification, id_student, id_teacher) VALUES ('$id_student', 1, '$id_student', '$id_teacher')");

		$email = $db->exec("SELECT user.email FROM user WHERE id=$id_student")[0]['email'];
		$teacher = $db->exec("SELECT user.fullname FROM user WHERE id=$id_teacher")[0]['fullname'];
		$discipline = $db->exec("SELECT subject FROM homework WHERE id=$id")[0]['subject'];

		$timetosend = date("Y-m-d H:i:s", strtotime("+1 hour"));

		$subject = "Ваша студенческая работа проверена";
		$message = "Ваша студенческая работа по дисциплине ".$discipline." была проверена преподавателем ".$teacher."<br><br><b>Оценка за работу:</b> ".$array[mark]."<br><b>Комментарий к работе:</b> ".$array[text]."<br><br><b>Время проверки:</b> ".$timetosend;

		if(\services\mailservice::SendEmail($email, $subject, $message)){
							return 129; //all right
						}
						
						else return  121; //error sending email



					}
				}