<?php 

namespace models;

class user{
	
	private $_token, $_id;
	private $_db;


	function __construct($token)
	{
		$this->_token = $token;
		$this->_db = \F3::get('DB');
		if($this->_token != null) {
			$this->_id = $this->_db->exec("SELECT id_user from authorization where token = '$this->_token'")[0]['id_user'];
		}
	}

	function check(){
		if(isset($this->_token)){
			$id_user = $this->_db->exec("SELECT id_user from authorization where token = '$this->_token'")[0]['id_user'];
			return $id_user;
		}
		return false;
	}

	function getPermissions(){
		$db = $this->_db;
		$roles = $db->exec("SELECT id_role FROM user WHERE id=$this->_id");


		$rez = array();
		foreach($roles as $role){
			$id_role = $role['id_role'];
			$permissions = $db->exec("SELECT module.code as code FROM role_module
				JOIN module on module.id = role_module.id_module
				WHERE role_module.id_role = $id_role");
			foreach($permissions as $permission){
				if(!in_array($permission['code'], $rez)){
					array_push($rez, $permission['code']);
				}
			}
		} 
		return $rez;
	}
	

	function getInfo(){
		if($this->_id != null){

			$user =  $this->_db->exec("SELECT user.id, user.login, user.fullname, user.email
				FROM user
				WHERE user.id = $this->_id")[0];	
			$roles = $this->_db->exec("SELECT role.name, role.id
				FROM role
				JOIN user on user.id_role = role.id
				WHERE user.id = $this->_id");
			$rezult = array();
			$rezultid = array();
			if($roles != null){
				foreach($roles as $role){
					array_push($rezult, $role['name']);
					array_push($rezultid, $role['id']);
				}
			}
			return array("id" => $user['id'],
				"login" => $user['login'],
				"fullname" => $user['fullname'],
				"email" => $user['email'],
				"roles" => $rezult,
				"rolesid" => $rezultid);
		}
	}

	static function getInfoById($id){
		if($id != null){
			$db = \F3::get('DB');
			$user = $db->exec("SELECT user.id, user.login, user.fullname, user.email
				FROM user

				WHERE user.id = $id")[0];	
			if($user!= null){

				return array("id"=>$user['id'], 
					"fullname" => $user['fullname'],
					"login" => $user['login'],
					"email" => $user['email']
					);
			}
		}		
	}

	static function getStudentInfoById($id){
		if($id != null){
			$db = \F3::get('DB');
			$student = $db->exec("SELECT user.fullname, year.name as year, program.name as program FROM user JOIN student ON user.id = student.id_user JOIN year ON year.id = student.id_year JOIN program ON program.id = student.id_program

				WHERE user.id = $id")[0];	
			if($student!= null){

				return array(
					"id" => $id,
					"fullname" => $student['fullname'],
					"year" => $student['year'],
					"program" => $student['program']
					);
				
			}
				return 100; //no such user TODO: show error on client
			}
		}
		
		static function getRoleIdById($id){
			if($id != null){
				$db = \F3::get('DB');
				$role = $db->exec("SELECT user.id_role FROM user WHERE user.id = $id")[0];	
				if($role!= null){
					
					return $role;

				}
				return 100; //no such user TODO: show error on client
			}
		}
		
		
		
		static function getNotificationById($id){
			if($id != null){
				$db = \F3::get('DB');
				$activityes = $db->exec("SELECT user_notification.date, notification.name, user_notification.status, user_notification.id
					FROM user_notification
					JOIN notification on (notification.id = user_notification.id_notification) 
					WHERE id_user = $id AND (user_notification.status = 0)
					GROUP BY user_notification.date DESC"); 
				$teacher_name = $db->exec("SELECT user.fullname FROM user JOIN user_notification on (user.id = user_notification.id_teacher) WHERE id_user = $id")[0]['fullname']; 
				$student_name = $db->exec("SELECT user.fullname FROM user JOIN user_notification on (user.id = user_notification.id_student) WHERE id_user = $id")[0]['fullname']; 
				

				$rez = array("0"=>'');				
				foreach($activityes as $activity){
					$date = $activity['date'];

					if ($activity['status']==0) $count++;
					$datenormal = helpers::formatTime($date);
					$daysago = helpers::getTimeAgo($date);
					$description = "Нет описания";
					
					array_push($rez, array(
						"id" => $activity['id'],
						"time" => $datenormal,
						"student_name" => $student_name,
						"name" => $activity['name'],
						"description" => $description,
						"teacher_name" => $teacher_name,
						"days" => $datenormal));
				}	
				$rez[0] = $count;
				return $rez;
			}
		}
		
		
		static function getAll(){
			$db = \F3::get('DB');
			$users = $db->exec('SELECT login, user.id, fullname, user.email 

				FROM user');
			$rez = array();
			foreach($users as $user){
				$id = $user['id'];
				
				$roles = $db->exec("SELECT id_role FROM user_role WHERE id_user = $id");
				$rolesArr = array();
				foreach($roles as $role){
					array_push($rolesArr, $role['id_role']);
				}
				array_push($rez, array(	"login" => $user['login'],
					"id" => $user['id'],
					"fullname" => $user['fullname'],
					"email" => $user["email"],
					"roles" => $rolesArr));
			}
			return $rez;

		}
		
		static function authorization($login, $password){
			if(isset($login) && isset($password)){
				if(!(strlen($login) < 4  || strlen($password) < 4 || strlen($login) > 50 || strlen($password) > 50)  ){
					$db = \F3::get('DB');
					$id_user = $db->exec("SELECT id FROM user 
						WHERE (login = '$login' or email = '$login') AND password = MD5(MD5('$password'))")[0]['id'];

					if($id_user!=null){
						$token = helpers::getToken();
						$db->exec("INSERT INTO authorization (id_user, token) values ($id_user, '$token')");
						
						return $token;
					}
					return 101;
				}
				return 900;
			}
			
			return 900;
		}
		
		static function forgotSendEmail($email){


			
			if(isset($email)){
				if(!(strlen($email) < 4 || strlen($email) > 50)){
					$db = \F3::get('DB');
					$user = $db->exec("SELECT id, login FROM user
						WHERE email = '$email'")[0];
					$user_id = $user['id'];
					$user_login = $user['login'];
					if($user['id']!= null){


						
						$subject = "Восстановление пароля HSEPro";

						$token = helpers::getToken();
						$url = "http://".$_SERVER['HTTP_HOST']."/reset?".$token;

						$message = "Ссылка для восстановления пароля: $url";
						
						$db->exec("DELETE FROM restore_password where id_user = $user_id");
						$db->exec("INSERT INTO restore_password (id_user, token) values ($user_id, '$token')");


						if(\services\mailservice::SendEmail($email, $subject, $message)){
							return 129; //all right
						}
						
						else return  121; //error sending email
						
					}
					else return 120;
				}
			}
			else return 900;
		}
		
		static function checkResetToken($token){

			if(isset($token)){
				if(!(strlen($token) < 4 || strlen($token) > 20)){
					$db = \F3::get('DB');
					$id_user = $db->exec("SELECT id_user FROM restore_password
						WHERE token = '$token'")[0]['id_user'];

					return $id_user;
				}
			} return false;
		}
		
		static function setNewPassword($token, $password){
			if(isset($token) && isset($password)){
				if(!(strlen($token) < 4 || strlen($token) > 20 || strlen($password) < 4 || strlen($password) > 30)){
					if($id_user = self::checkResetToken($token)){
						$db = \F3::get('DB');
						$db->exec("DELETE FROM restore_password 
							WHERE id_user = $id_user");
						$db->exec("UPDATE user 
							SET password = MD5(MD5('$password'))
							WHERE id = $id_user");
						return 129;	
					}
					return 122;
				}
			}
			return 900;
		}
		
		static function editauth($id, $login, $email, $password, $fullname, $year, $program){
			if(isset($login) && isset($email) && isset($password) && isset($fullname)){
				if(!(strlen($login) < 4 || strlen($email) < 4 || strlen($password) < 4 || strlen($fullname) < 4 ||
					strlen($login) > 50 || strlen($email) > 50 || strlen($password) > 50 || strlen($fullname) > 100)  ){
					$db = \F3::get('DB');
				$check_email = $db->exec("SELECT email FROM user where email = '$email' and id <> $id")[0]['email'];
				if( ($check_email == null) && ( (substr($email,-11)=="@edu.hse.ru") || (substr($email,-7)=="@hse.ru") ) ){
					$check_login = $db->exec("SELECT login FROM user where login = '$login' and id <> $id")[0]['login'];
					if($check_login == null){
						$check_fullname = $db->exec("SELECT fullname FROM user where fullname = '$fullname' and id <> $id")[0]['fullname'];
						if($check_fullname == null){
							$db->exec("UPDATE user SET email = '$email', login = '$login', fullname = '$fullname', password = MD5(MD5('$password')) 
								WHERE id = $id");
							if($year != null) {
								$db->exec("UPDATE student SET id_year = '$year' WHERE id_user = $id");
							}
							if($program != null) {
								$db->exec("UPDATE student SET id_program = '$program' WHERE id_user = $id");
							}
							return 119;
						}
					}
					return 111;
				}
				return 110;
			}
		}
		return 900;
	}



	static function registration($login, $email, $password, $fullname, $year, $program){
		if(isset($login) && isset($email) && isset($password)){
			if(!(strlen($login) < 4 || strlen($email) < 4 || strlen($password) < 4 || 
				strlen($login) > 50 || strlen($email) > 50 || strlen($password) > 50)  ){
				$db = \F3::get('DB');
			$check_email = $db->exec("SELECT email FROM user where email = '$email'")[0]['email'];

			if($check_email == null){
				$check_login = $db->exec("SELECT login FROM user where login = '$login'")[0]['login'];

				if($check_login == null){
					if((substr($email,-11)=="@edu.hse.ru") || (substr($email,-7)=="@hse.ru")) {
						if(substr($email,-11)=="@edu.hse.ru" && isset($year) && isset($program)){
							$db->exec("INSERT INTO user (login, password, email, fullname, id_role) VALUES ('$login', MD5(MD5('$password')), '$email', '$fullname', 1)");
							$id_student = $db->exec("SELECT id from user WHERE email = '$email' ")[0]['id'];
							$db->exec("INSERT INTO student (id_user, id_year, id_program) VALUES ('$id_student', '$year', '$program')");


						}
						else if(substr($email,-7)=="@hse.ru"){
							$db->exec("INSERT INTO user (login, password, email, fullname, id_role) VALUES ('$login', MD5(MD5('$password')), '$email', '$fullname', 2)");


						}
						$id_user = $db->exec("SELECT id from user 
							WHERE login = '$login' AND password = MD5(MD5('$password')) AND email = '$email' ")[0]['id'];
						
						return 119;
						
					}
					else return 118;


				}
						else return 111; //Login exists
					}
					else return 110; //Email exists
				}
			}
			else return 900; //Bad Data
		}
		

		static function deleteNotification($id_user){
			$db = \F3::get('DB');
			$db->exec("UPDATE user_notification SET status=1 WHERE id_user = $id_user");
			return 1;
		}

	}
