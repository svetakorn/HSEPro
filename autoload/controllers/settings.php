<?php
	
	namespace controllers;
	
	class settings extends basecontroller{
		
		
		function contacts($f3){
			
			$this->showPage($f3, 'Главная', null, "Контакты","Контакты", 300, 'contacts/contacts.html');
			
		}
	}

