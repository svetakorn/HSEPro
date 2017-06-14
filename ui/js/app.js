var App = (function($){
	
	var that = this;	
	
	this.initToastr = function () {
		toastr.options = {
			"closeButton": true,
			"progressBar": true,
		}
	}
	
	this.showError = function (code){
		switch (code){
			case "230": 
			ui.item.fadeOut(600, function(){
				ui.item.addClass("hidden");
			});
			toastr.info('Вы успешно удалили задачу','Вы можете продолжить работу с другими блоками');
			break;            
			
			case "101": 
			toastr.warning('Такой пары не существует','Попробуйте ввести другие данные или воспользуйтесь услугой восстановления паролей');    
			break;
			case "109":
			toastr.info('Вы успешно авторизовались','Сейчас вы перейдете на главную страницу');   
			$(location).attr('href','/'); 
			break; 	
			case "110": 
			toastr.warning('Email уже существует или не является корпоративным адресом НИУ ВШЭ','Попробуйте ввести другой e-mail');    
			break;
			case "111": 
			toastr.warning('Login уже существует','Попробуйте выбрать другой логин');    
			break;
			case "116":
			toastr.warning('Направления не изменились','Попробуйте изменить направления');   
			break;
			case "117":
			toastr.warning('Отдел не изменился','Попробуйте выбрать другой отдел');   
			break;
			case "118":
			toastr.info('Не все данные сохранены','Измените данные на странице пользователя');   
			break;
			case "119":
			toastr.info('Вы успешно изменили данные пользователя','данные сохранены');   
			break;
			case "120": 
			toastr.warning('Такого email не существует','Попробуйте ввести другой email, или зарегистрируйте новый');    
			break;
			case "121": 
			toastr.warning('Ошибка при отправке email','Попробуйте позже');    
			break;
			case "122": 
			toastr.warning('Ваша ссылка уже не активна','Попробуйте сгенерировать другую ссылку');    
			break;
			case "129":
			toastr.info('Вы успешно изменили пароль','Сейчас вы перейдете на страницу авторизации');   
			$(location).attr('href','/'); 
			break;
			case "200":
			toastr.info('Вы успешно изменили данные','данные сохранены');   
			break;
			case "209":
			toastr.info('Вы успешно создали новую задачу','Вы можете создать больше)');   
			$(location).reload(); 
			break;
			case "210":
			toastr.warning('Проект с таким именем уже существует','Выберите другое имя проекта');    
			break;
			case "218":
			toastr.info('Не все данные сохранены','Измените данные на странице проекта');   
			break;
			case "219":
			toastr.info('Вы успешно создали новый проект','Вы можете создать больше)');   
			break;
			case "220":
			toastr.warning('У проекта обязательно должен быть мастер','Выберите мастера');    
			break;
			case "500": 
			toastr.warning('Такого отдела не существует','Попробуйте выбрать другой отдел');    
			break;
			case "501": 
			toastr.warning('Такое имя уже существует','Попробуйте ввести другое имя');    
			break;
			case "518":
			toastr.info('Не все данные сохранены','Измените данные на странице департамента');   
			break;
			case "519":
			toastr.info('Вы успешно создали новый департамент','Вы можете создать больше)');   
			break;
			case "800":
			toastr.warning('ERROR 800','BAD REQUEST'); 
			case "700":
			toastr.warning('Домашнее задание не загружено', 'Обратитесь к администратору'); 
			break;
			case "701":
			toastr.warning('Фото не загружено', 'Обратитесь к администратору'); 
			break;
			case "708":
			toastr.warning('Преподаватель с таким email в базе не найден', 'Проверьте корректность email'); 
			break;
			case "710":
			toastr.warning('Слишком большой файл'); 
			break;
			case "709":
			toastr.info('Домашнее задание загружено!');
			break; 
			/*case "712":
			toastr.info('Фото для аватара загружено!'); 
			break;*/
			case "711":
			toastr.info('Домашнее задание загружено!'); 
			location.reload();
			break;
			case "1200":
			toastr.warning('Что-то не так');
			break;
			case "1201":
			toastr.info('Сохранено!');
			break;
			case "800":
			toastr.info('Произошла ошибка! Попробуйте еще раз');
			$('#close_modal2').click();
			break;
			case "900": 
			toastr.warning('Неверные данные','Проверьте свои данные еще раз');    
			break;
			case "901": 
			toastr.warning('1) Оценка дожна быть целым числом от 0 до 10<br/>2) Комментарий не обязательно должен присутствовать','Неверные данные');    
			break;
			case "902": 
			toastr.info('Работа успешно проверена');    
			break;     
			case "910":
			toastr.info('У Вас недостаточно прав','Попробуйте передвинуть другие блоки');   
			break;
			case '1009':
			toastr.info("ALL GOOD", "Все ок");
			break;
			case '1010':
			toastr.warning("EROOR DATA", "Попробуйте ввести данные, чтоб они норм такие ");
			break;
			case '1011':
			toastr.warning("Не существует", "Такой Роли не существует");
			break;
			case '1012':
			toastr.warning("Имя уже занято", "Создайте роль с другим именем");
			break;
			

		}
		


		
	}
	
	this.initialize = function(){
		this.initToastr();
	}();
	
	return {
		showError: function(code){
			that.showError(code);
		}
	};
	
})(jQuery);