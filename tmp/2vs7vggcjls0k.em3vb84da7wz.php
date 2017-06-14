<script src="<?php echo $BASE; ?>/ui/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Chosen -->
<script src="<?php echo $BASE; ?>/ui/js/plugins/chosen/chosen.jquery.js"></script>
<!-- Jquery Validate -->
<script src="<?php echo $BASE; ?>/ui/js/plugins/validate/jquery.validate.min.js"></script>
<!-- Toastr script -->
<script src="<?php echo $BASE; ?>/ui/js/plugins/toastr/toastr.min.js"></script>
<!-- Input Mask-->
<script src="<?php echo $BASE; ?>/ui/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<!-- Ladda -->
<script src="<?php echo $BASE; ?>/ui/js/plugins/ladda/spin.min.js"></script>
<script src="<?php echo $BASE; ?>/ui/js/plugins/ladda/ladda.min.js"></script>
<script src="<?php echo $BASE; ?>/ui/js/plugins/ladda/ladda.jquery.min.js"></script>

<div class="row animated fadeInRight">
	
	
	<div class="col-md-8">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Данные пользователя</h5>
			</div>
			<div class="ibox-content">
				<form role="form" id="formauth">

					<h3 style="margin-bottom: 25px;">Информация о пользователе</h3>

                    <?php if (in_array(100, $permissions)): ?>
                    
                    <div class="form-group"><label>Этап обучения</label> 
                            <select id="year" name="year" data-placeholder="Этап обучения" required class="chosen-select form-control" tabindex="4">
                                <option value="<?php echo $single_student['id_year']; ?>" disabled selected hidden><?php echo $single_student['year']; ?></option>
                                <?php foreach (($year?:array()) as $y): ?>
                                    <option value="<?php echo $y['id']; ?>"><?php echo $y['name']; ?></option>
                                <?php endforeach; ?> 

                            </select>
                        </div>

                        <div class="form-group"><label>Образовательная программа</label> 
                            <select id="program" name="program" data-placeholder="Образовательная программа" required class="chosen-select form-control" tabindex="4">
                                <option value="<?php echo $single_student['id_program']; ?>" disabled selected hidden><?php echo $single_student['program']; ?></option>
                                <?php foreach (($program?:array()) as $p): ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?> 

                            </select>
                        </div>
                        
                    <?php endif; ?>

					<div class="form-group"><label>Логин</label> 
						<input name="login" type="text" placeholder="Логин" class="form-control" required value="<?php echo $single_user['login']; ?>">
					</div>
					<div class="form-group"><label>Email</label> 
						<input name="email" type="email" placeholder="Корпоративная почта" class="form-control" required value="<?php echo $single_user['email']; ?>">
					</div>
					<div class="form-group"><label>Пароль</label> 
						<input name="password" type="password" placeholder="Пароль" class="form-control" required>
					</div>
					<div class="form-group"><label>ФИО</label> 
						<input name="fullname" type="text" placeholder="Полное Имя" class="form-control" required value="<?php echo $single_user['fullname']; ?>">
					</div>




                    <button class="btn btn-sm btn-success m-t-n-xs" type="submit"><strong>Изменить</strong></button>
                </form>

            </div>
        </div>

    </div>


    <!--<div class="col-md-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Аватар</h5>
            </div>
            <div>
                <div class="ibox-content no-padding border-left-right">
                    <img alt="image" class="img-responsive avatar" id="previewImage" style="margin-top:20px;"   
                    src="<?php echo $BASE; ?>/ui/images/avatars/<?php echo $single_user['avatar'] != null ? $single_user['avatar'] : 'no-avatar.jpg'; ?>">
                </div>
                <div class="ibox-content profile-content">
                    <div class="user-button">
                        <div class="row">
                            <form id="formavatar" enctype="multipart/form-data" role="form">
                                <div class="col-md-12">
                                    <div class="form-group"><label>Изменить аватар</label> 
                                        <input type="hidden" name="MAX_FILE_SIZE" value="4194304" /> 
                                        <input name="avatar" type="file"  class="form-control" accept="image/*" required>
                                        <input type="hidden" name="filename" id="filename">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit"  class="ladda-button avatarButton btn btn-primary btn-sm btn-block" data-style="zoom-in"><i class="fa "></i> Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>           
                </div>
            </div>
        </div>
    </div>-->
</div>


<script>
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#previewImage').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}



	$(document).ready(function(){
		var config = {
			'.chosen-select'           : {},
			'.chosen-select-deselect'  : {allow_single_deselect:true},
			'.chosen-select-no-single' : {disable_search_threshold:10},
			'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
			'.chosen-select-width'     : {width:"95%"}
		}
		for (var selector in config) {
			$(selector).chosen(config[selector]);
		}
         //$( '.ladda-button' ).ladda( 'bind', { timeout: 2000 } );
         var formavatar = $("#formavatar");
         var formauth = $("#formauth");
         
         
         var files;
         $('input[type=file]').change(function(){
         	files = this.files; 
         	readURL(this);
         });
         formauth.validate({
         	rules: {
         		password: {
         			required: true,
         			minlength: 4,
         			maxlength: 45,
         		},
         		login: {
         			required: true,
         			minlength: 4,
         			maxlength: 45,
         		},
         		email: {
         			required: true,
         			minlength: 4,
         			maxlength: 45,
         		},
         		fullname: {
         			required: true,
         			minlength: 4,
         			maxlength: 100,
         		}
         	}
         });
         
         
         $( '.ladda-button' ).on("click", function(){
            var l = $(this).ladda();

                  // Start loading
                  l.ladda( 'start' );
                  var data = new FormData($("#formavatar").get(0));
                  data.append("id", <?php echo $single_user['id']; ?>);




                  $.ajax({
                        url:'/uploadavatar',
                        type: 'POST',
                        data: data,
                        cache: false,
                        dataType: 'json',
                        processData: false,
                        contentType: false
                    }).always(
                        function (response){
                            if(response.responseText != 700 && response.responseText != 701){
                                var el = $("#filename");
                                el[0].value = JSON.stringify(response);
                                $.post("/edituseravatar?<?php echo $single_user['id']; ?>", formavatar.serialize(),
                                    function (response){
                                        alert(response);
                                        App.showError(response);
                                        button.ladda("stop");
                                        
                                    });
                            }
                            else{
                                toastr.warning('Не удалось загрузить фото на сервер','Попробуйте другое фото');
                                return;
                                button.ladda("stop");
                            }
                        }
                    );
                });
                
            
               




         
         formauth.submit( function(e){
         	if(formauth.valid()){
         		e.preventDefault();
         		var data = formauth.serialize();
         		var post = $.post("/edituserauth?<?php echo $single_user['id']; ?>", data, 
         			function (response){
                        
         				App.showError(response);
         			}
         			);
         		post.fail(function (response){
                   
         			toastr.error('Ошибка при отправке запроса','Обратитесь к администратору');    
         			return false;
         		});
         	}
         });
         
         
         
     })

 </script>






