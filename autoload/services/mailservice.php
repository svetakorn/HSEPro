<?php

namespace services;

class mailservice{
	private $server, $headers;

	function __construct()
	{
		$server =  "http://".$_SERVER['HTTP_HOST']."/";
		$headers =  'От: hsepro.server@yandex.ru' . "\r\n" ;
	}
	
	public static function SendEmail($email, $subject, $message){
		if(!isset($email) || !isset($subject) || !isset($message)) return 1200;
		if(strlen($email) < 4 || strlen($email) > 50) return 1201;
		$mail             = new \PHPMailer();
		$body             = $message;
		$mail->IsSMTP(); 
		$mail->Host       = "smtp.yandex.ru";
		$mail->SMTPDebug  = 2;                     
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPAuth   = true;             		
		$mail->Port       = 465;                  
		$mail->Username   = "hsepro.server@yandex.ru"; 
		$mail->Password   = "password"; //not real 
		$mail->CharSet = 'UTF-8';
		$mail->SetFrom('hsepro.server@yandex.ru', 'Сервис HSEPro+'); 
				
		$mail->Subject    = $subject;
				
		$mail->MsgHTML($body);
		$mail->isHTML(true);                              
		$address = $email;
		$mail->AddAddress($address, "Пользователь");
		
		
		if(!$mail->Send()) {
		  return 1202; 
		} else {
		  return 1209;
		};
		
		
		//return 1209;
	}
}
