<?php

// DB connection
define("DB_HOST", "localhost");
define("DB_USER", "login"); //not real
define("DB_PWD", "password"); //not real
define("DB_NAME", "dbname"); //not real


require_once('class.phpmailer.php');
include("class.smtp.php");
define("_EXECUTED",1);
session_start();
$f3 = require('lib/base.php');

$db = new DB\SQL(
	'mysql:host='.DB_HOST.';port=3306;dbname='.DB_NAME, DB_USER, DB_PWD
	);

$f3->set("DB",$db);
$f3->set('DEBUG', 3);
//$f3->set('CACHE',FALSE);
$f3->set('UI','ui/views/');
$f3->set('AUTOLOAD','autoload/');


if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

// Load configuration
$f3->config('config.ini');

//main_page
$f3->route('GET /',"controllers\download->main");

//search
$f3->route('GET /search', "controllers\search->main");
$f3->route('GET /getforelastic',"controllers\lesson->forElasticUpload");

//user
$f3->route('GET /users', "controllers\user->main");
$f3->route('GET /users?{@id}', "controllers\user->profile");
$f3->route('GET /adduser', "controllers\user->add");
$f3->route('GET /edituser?{@id}', "controllers\user->edit");
$f3->route('POST /edituserauth?{@id}', "controllers\user->editauth");
$f3->route('POST /edituserinfo?{@id}', "controllers\user->editinfo");

//authorization
$f3->route('GET /studregister',"controllers\authorization->studRegister");
$f3->route('GET /login',"controllers\authorization->login");
$f3->route('POST /auth',"controllers\authorization->authUser");
$f3->route('GET /forgot',"controllers\authorization->forgot");
$f3->route('POST /forgot',"controllers\authorization->forgotSendEmail");
$f3->route('GET /reset?{@token}',"controllers\authorization->resetPassword");
$f3->route('POST /reset?{@token}',"controllers\authorization->submitNewPassword");
$f3->route('GET /register',"controllers\authorization->register");
$f3->route('POST /createuser',"controllers\authorization->createNewUser");


//homework
$f3->route('POST /uploadhomework', "controllers\lesson->uploadHomework");
$f3->route('GET /checkhomework', "controllers\checkhomework->main");
$f3->route('GET /showresults', "controllers\checkhomework->forStudent");
$f3->route('POST /checkedhomework?{@id}', "controllers\checkhomework->check");

//contacts
$f3->route('GET /contacts', "controllers\settings->contacts");

//notifications
$f3->route('POST /deletenotification', "controllers\lesson->deleteNotification");

//errors
$f3->route('GET /error?{@code}', "controllers\mistake->main");
$f3->route('POST /error?{@code}', "controllers\mistake->main");


$f3->run();

