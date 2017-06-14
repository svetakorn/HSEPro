<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HSEPro | <?php echo $page['main_title']; ?></title>
    <link  href="<?php echo $BASE; ?>/ui/images/owl.png" rel="icon">
    
    <link href="<?php echo $BASE; ?>/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Ladda style -->
    <link href="<?php echo $BASE; ?>/ui/css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="<?php echo $BASE; ?>/ui/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/animate.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/style.css" rel="stylesheet">
    <!-- c3 Charts -->
    <link href="<?php echo $BASE; ?>/ui/css/plugins/c3/c3.min.css" rel="stylesheet">
    
    <link href="<?php echo $BASE; ?>/ui/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    

</head>

<body class="fixed-sidebar no-skin-config   pace-done ">
	
	
  <!-- Mainly scripts -->
  <script src="<?php echo $BASE; ?>/ui/js/jquery-2.1.1.js"></script>
  <script src="<?php echo $BASE; ?>/ui/js/jquery-ui-1.10.4.min.js"></script>
  
  <script src="<?php echo $BASE; ?>/ui/js/bootstrap.min.js"></script>
  <script src="<?php echo $BASE; ?>/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
  <script src="<?php echo $BASE; ?>/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

  <!-- Custom and plugin javascript -->
  <script src="<?php echo $BASE; ?>/ui/js/inspinia.js"></script>
  <script src="<?php echo $BASE; ?>/ui/js/plugins/pace/pace.min.js"></script>
  <!-- Toastr script -->
  <script src="<?php echo $BASE; ?>/ui/js/plugins/toastr/toastr.min.js"></script>
  <!-- App settings -->
  <script src="<?php echo $BASE; ?>/ui/js/app.js"></script>

  <script type="text/javascript">
   
   function notification( event ) {
     
     
     $.ajax({
      url: '/deletenotification',
      type: 'POST',
      data: 'delete',
      success: function (json) {
         var data = JSON.parse(json);
         console.log(data); 
         $(".notification-count").css('display', 'none');
     },
     cache: false,
     contentType: false,
 });
 };
</script>

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                        <div class="img-circle menu-avatar" 
                        style="background-image: url(<?php echo $BASE; ?>/ui/images/avatars/<?php echo $user['avatar_small'] != null ? $user['avatar_small'] : 'no-avatar.jpg'; ?>)">
                    </div>
                </span>
                <div data-toggle="dropdown" class="dropdown-toggle" style="margin-top: 15px;">
                    <span class="clear"> 
                       <span class="block m-t-xs"> 
                          <strong class="font-bold" style="color: white;">
                             <?php echo $user['fullname'] != null ? $user['fullname'] : $user['login']; ?>
                         </strong>
                     </span> 
                     <span class="text-muted text-xs block" style="margin-top: 8px;">
                       <?php if ($user['roles'] != null): ?>
                          
                             <?php foreach (($user['roles']?:array()) as $role): ?>
                                <?php echo $role; ?>
                            <?php endforeach; ?>
                        
                        <?php else: ?>
                         Нет роли
                     
                 <?php endif; ?>
             </span> 
         </span> 
     </div>
     
 </div>
 <div class="logo-element">
    HSEPro
</div>
</li>



<?php if (in_array(100, $permissions)): ?>
    <li class="<?php echo $page['code'] == '100'  ? 'active' : ''; ?>">
       <a href="/"><i class="fa fa-home"></i> <span class="nav-label">Загрузка работы</span> </a>
   </li>
<?php endif; ?>

<?php if (in_array(200, $permissions)): ?>
    <li class="<?php echo $page['code'] == '200' ? 'active' : ''; ?>">
        <a href="/"><i class="fa fa-check"></i> <span class="nav-label">Проверка работ</span> </a>
    </li>
<?php endif; ?>


<?php if (in_array(250, $permissions)): ?>
    <li class="<?php echo $page['code'] == '250' ? 'active' : ''; ?>">
        <a href="/showresults"><i class="fa fa-check"></i> <span class="nav-label">Мои оценки</span> </a>
    </li>
<?php endif; ?>


<?php if (in_array(150, $permissions)): ?>
    <li class="<?php echo $page['code'] == '150'  ? 'active' : ''; ?>">
        <a href="/edituser?<?php echo $user['id']; ?>"><i class="fa fa-user"></i> <span class="nav-label">Изменить профиль</span> </a>
    </li>
<?php endif; ?>

<?php if (in_array(350, $permissions)): ?>
    <li class="<?php echo $page['code'] == '350'  ? 'active' : ''; ?>">
        <a href="/search"><i class="fa fa-search"></i> <span class="nav-label">Поиск по работам</span> </a>
    </li>
<?php endif; ?>

<hr class="hr">

			<!--	<?php if (in_array(310, $permissions) || in_array(300, $permissions)): ?>
                <li class="<?php echo in_array($page['code'], array(300,310,320,330,340)) ? 'active' : ''; ?>">
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Люди</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if (in_array(310, $permissions)): ?>
                        <li class="<?php echo $page['code'] == 310  ? 'active' : ''; ?>">
                        	<a href="/users?<?php echo $user['id']; ?>">Мой профиль</a>
                        </li>
                        <?php endif; ?>
                        <?php if (in_array(300, $permissions)): ?>
                        <li class="<?php echo $page['code'] == '300' ? 'active' : ''; ?>"><a href="/users">Все люди</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (in_array(210, $permissions)): ?>
                <li class="<?php echo in_array($page['code'], array(210, 220, 230, 240, 250, 260, 270, 280, 290)) ? 'active' : ''; ?>">
                    <a href="#"><i class="fa fa-graduation-cap"></i> <span class="nav-label">Курсы </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                       	<?php foreach (($courses?:array()) as $course): ?>
                    		<li class="<?php echo ($page['subsection'] == $course['course_name'])&&($department_name == $course['department_name']) ? 'active' : ''; ?>">
                    		
                            	<a href="#"><?php echo $course['course_name']; ?> (<?php echo $course['department_name']; ?>) <span class="fa arrow"></span></a>
	                            <ul class="nav nav-third-level">
	                            <?php echo count($course['lessons'])==0 ? '<li><a>Нет занятий</a></li>' : ''; ?>
	                            	<?php foreach (($course['lessons']?:array()) as $i=>$lesson): ?>
	                            	
	                                <li class="<?php echo (substr($page['main_title'],-1) == $lesson['number']) & ($page['subsection'] == $course['course_name'])&&($department_name == $course['department_name'])  ? 'active' : ''; ?>">
	                                    <a href="/lesson?<?php echo $lesson['id']; ?>">Занятие <?php echo $lesson['number']; ?></a>
	                                </li>
	                            	<?php endforeach; ?>
	                            	<?php if ((in_array(240, $permissions) & $course['teacher']==1)): ?>
	                            	
	                            	<li class="<?php echo ($page['code'] == 240) & ($page['subsection'] == $course['course_name']) ? 'active' : ''; ?>">
	                                    <a href="/addlesson?<?php echo $course['id_c_d']; ?>">Добавить занятие</a>
	                                </li>
	                            	
	                            	<?php endif; ?>
	                            </ul>
							</li>
						<?php endforeach; ?>
						<?php if (in_array(250, $permissions)): ?>
						<li class="<?php echo $page['code'] == 250 ? 'active' : ''; ?>">
							<a href="/teachers">Преподаватели</a>
						</li>
						<?php endif; ?>
						<?php if (in_array(280, $permissions)): ?>
	                            	
	                            	<li class="<?php echo $page['code'] == 280 ? 'active' : ''; ?>">
					                    <a href="/checkhomework"> <span class="nav-label">Домашние задания </span></a>
					                </li>
					                
					    <?php endif; ?>
					    <?php if (in_array(270, $permissions)): ?>
					    
					                <li class="<?php echo $page['code'] == 270 ? 'active' : ''; ?>">
					                    <a href="/students"> <span class="nav-label"> Студенты </span></a>
					                </li>
					    
					    <?php endif; ?>
					    
					    <?php if (in_array(290, $permissions)): ?>
					    
					                <li class="<?php echo $page['code'] == 290 ? 'active' : ''; ?>">
					                    <a href="/stat"> <span class="nav-label"> Статистика </span></a>
					                </li>
					    
					    <?php endif; ?>       	
	                    
						
                    </ul>
                </li>
                <?php endif; ?>
                
                <?php if (in_array(800, $permissions)): ?>
                <li class="<?php echo $page['code'] =='800' ? 'active' : ''; ?>">
                    <a href="/wiki"><i class="fa fa-book"></i> <span class="nav-label">База знаний</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php foreach (($destinations?:array()) as $destination): ?>
							<?php if (in_array(800, $permissions)): ?>
								<li class="<?php echo $PARAMS['id'] == $destination['id'] ? 'active' : ''; ?>"><a href="/wiki?<?php echo $destination['id']; ?>"><?php echo $destination['name']; ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (in_array(400, $permissions) || in_array(450, $permissions)): ?>
                <li class="<?php echo in_array($page['code'], array(400, 410, 420, 430, 440, 450)) ? 'active' : ''; ?>">
                    <a href="#"><i class="fa fa-soundcloud"></i> <span class="nav-label">Проекты</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if (in_array(450, $permissions)): ?>
                        <li class="<?php echo $page['code'] == 410 ? 'active' : ''; ?>"><a href="/myprojects">Мои проекты</a></li>
                        <?php endif; ?>
                        <?php if (in_array(400, $permissions)): ?>
                        <li class="<?php echo $page['code'] == 400 ? 'active' : ''; ?>"><a href="/projects">Все проекты</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (in_array(510, $permissions) || in_array(500, $permissions)): ?>
                <li class="<?php echo in_array($page['code'], array(500, 510, 520, 530, 540)) ? 'active' : ''; ?>">
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Отделы</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if (in_array(510, $permissions)): ?>
                        <li class="<?php echo $page['code'] == 510 ? 'active' : ''; ?>"><a href="/mydepartment">Мой отдел</a></li>
                        <?php endif; ?>
                        <?php if (in_array(500, $permissions)): ?>
                        <li class="<?php echo $page['code'] == 500 ? 'active' : ''; ?>"><a href="/departments">Все отделы</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (in_array(650, $permissions) || in_array(600, $permissions)): ?>
                <li class="<?php echo in_array($page['code'], array(600, 610, 620, 630, 640, 650)) ? 'active' : ''; ?>">
                    <a href="#"><i class="fa fa-hospital-o"></i> <span class="nav-label">Направления</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if (in_array(650, $permissions)): ?>
                        <li class="<?php echo $page['code'] == 650 ? 'active' : ''; ?>"><a href="/mydestinations">Мои направления</a></li>
                        <?php endif; ?>
                        <?php if (in_array(600, $permissions)): ?>
                        <li class="<?php echo $page['code'] == 600 ? 'active' : ''; ?>"><a href="/destinations">Все направления</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                
                
                <?php if (in_array(700, $permissions)): ?>
                <li class="<?php echo in_array($page['code'], array(700)) ? 'active' : ''; ?>">
                    <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Настройки</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php if (in_array(720, $permissions)): ?>
                        <li class="<?php echo $page['code'] == 720 ? 'active' : ''; ?>"><a href="/settings">Настройки</a></li>
                        <?php endif; ?>
                        <?php if (in_array(700, $permissions)): ?>
                        <li class="<?php echo $page['code'] == 700 ? 'active' : ''; ?>"><a href="/roles">Роли</a></li>
                        <?php endif; ?>

                        
                    </ul>
                </li>
            <?php endif; ?> -->
            
            <li class="<?php echo $page['code'] == '300'  ? 'active' : ''; ?>">
               <a href="/contacts"><i class="fa fa-phone"></i> <span class="nav-label">Контакты</span> </a>
           </li>
           

       </ul>

   </div>
</nav>

<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <!--form role="search" class="navbar-form-custom" >
                <div class="form-group">
                    <input type="text" placeholder="Поиск по тегу..." class="form-control" name="top-search" id="top-search">
                </div>
            </form-->
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">HSEPro+</span>
            </li>
            
            <!--                 Иконки сообщения и Алерты  -->
            
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" onclick="notification(event);">
                    <i class="fa fa-bell"></i>  <span class="label notification-count label-primary"><?php echo $notification_count != 0 ? $notification_count: ''; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                   <?php if ($notification_count == 0): ?>
                       
                          <p class="text-center"> Нет новых уведомлений </p>
                      
                      <?php else: ?>
                          <?php foreach (($notification?:array()) as $v): ?>
                              <li>


                                <?php if (in_array(100, $permissions)): ?>
                                  <a href="/showresults" class="notification" data-id="<?php echo $v['id']; ?>">
                                      <div class="dropdown-messages-box" >

                                       <div class="media-body" style="line-height:normal">
                                          
                                           <b><?php echo $v['name']; ?></b><br><br>
                                           <b>Преподаватель:</b> <?php echo $v['teacher_name']; ?>
                                           <br><br>
                                           <small class="text-muted"><?php echo $v['days']; ?></small>
                                           
                                       </div>
                                   </div>
                               </a>
                           <?php endif; ?>

                           <?php if (in_array(200, $permissions)): ?>
                            <a href="/checkhomework" class="notification" data-id="<?php echo $v['id']; ?>">
                                <div class="dropdown-messages-box" >

                                    <div class="media-body" style="line-height:normal">
                                        
                                        <b><?php echo $v['name']; ?></b><br><br>
                                        <b>Студент:</b> <?php echo $v['student_name']; ?>
                                        <br><br>
                                        <small class="text-muted"><?php echo $v['days']; ?></small>
                                        
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                        
                        
                    </li>  
                    <li class="divider"></li>
                    
                <?php endforeach; ?>
            
        <?php endif; ?>                    	
        
    </ul>
</li>


<li>
    <a href="/login">
        <i class="fa fa-sign-out"></i> Выйти
    </a>
</li>
</ul>

</nav>
</div>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2><?php echo $page['main_title']; ?></h2>
        <ol class="breadcrumb">
            <?php if ($page['section'] != null): ?>
               <li>
                   <a><?php echo $page['section']; ?></a>
               </li>
           <?php endif; ?>
           <?php if ($page['subsection'] != null): ?>
               <li>
                   <a><?php echo $page['subsection']; ?></a>
               </li>
           <?php endif; ?>
           <li class="active">
            <strong><?php echo $page['title']; ?></strong>
        </li>
    </ol>
</div>
               <!-- <?php if (in_array($page['button_permission'], $permissions)): ?>
                <?php if ($page['button_name'] != null && $page['button_link'] != null): ?>
	                <div class="col-sm-6">
	                    <div class="title-action">
	                        <a href="/<?php echo $page['button_link']; ?>" id="action_button" class="btn btn-primary"><?php echo $page['button_name']; ?></a>
	                    </div>
	                </div>
                <?php endif; ?>
            <?php endif; ?>-->
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
          
            <?php echo $this->render($page['view_link'],$this->mime,get_defined_vars(),0); ?>
            
        </div>
        <div class="footer"">
            <div>
                Разработано в <strong>НИУ ВШЭ</strong> &copy; 2017
            </div>
        </div>
    </div>
</div>


</body>

</html>
