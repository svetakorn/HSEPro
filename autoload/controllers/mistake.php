<?php
namespace controllers;

	class mistake extends basecontroller{
		
		function main($f3){
			$code = $f3->get("PARAMS.code");
			$more = "";
			switch ($code) {
				case 404:
				$descriprion = "Страница не найдена";
				$more = "Но вы можете перейти на <a href = './'> главную </a>";
				break;
				case 403:
				$descriprion = "Нет прав на просмотр страницы";
				$more = "Если вы уверены, что они должны быть, напишите <a href='/contacts'>администраторам</a>";
				break;
				case 500:
				$descriprion = "Ошибка на сервере";
				$more = "Попробуйте перезагрузить страницу или написать <a href='/contacts'>администраторам</a>";
				break;
			}
			$f3->set("error", array("code"=>$code, "text"=> $descriprion, "more" => $more));
			$this->showPage($f3, 
							null, 
							 
							null, 
							
							null, 
							'Ошибка!', 
							 
							100, 
							"error/error.html");
			
		}
}
		