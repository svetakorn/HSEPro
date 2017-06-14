<?php
	
	namespace controllers;
	
	class basecontroller{
		
		private $_user;
		private $_id_user;
		private $_permissions;
		function __construct()
		{
			$token = ($_SESSION['auth_tok'] == null ? ($_COOKIE['auth_tok'] == null ? null : $_COOKIE['auth_tok']) : $_SESSION['auth_tok']);
			$this->_user = new \models\user($token);
			$id_user = $this->_user->check();
			if (!$id_user) {
				\F3::reroute("/login");
			}
			else {
				$userinfo = $this->_user->getInfo();
				$permissions = $this->_user->getPermissions();
				$this->_id_user = $id_user;
				$this->_permissions = $permissions;
				\F3::set('permissions', $permissions);
				\F3::set('user', $userinfo);
				\F3::set('id_user', $id_user);
			}
		}
		
		function showPage($f3, 
										$section, 						//first title of header nav
										
										$subsection, 				//second title of header nav ?null
										
										$title, 							//page title & title of header nav
										$main_title, 					//big page title of header nav
										$code, 						//code
										$view_link){
			
			$template = new \Template;
			//check_role
			if(!in_array($code, $this->_permissions)) $f3->reroute("/error?403");
			
			$f3->set('page', array('section' => $section,
									
									'subsection' => $subsection,
									
									'title' => $title,
									'main_title' => $main_title,
									'code' => $code,
									'view_link' => $view_link
									));
			$userinfo = $f3->get('user');
			
			
			$notification = \models\user::getNotificationById($this->_id_user);
			$f3->set('notification_count',$notification['0']);
			array_shift($notification);
			$f3->set('notification', $notification);

			echo $template->render('baseview.html');
		}
	}