<?php 
	namespace models;
	
	class helpers{
		
		public static function getRusMonth($number){
			$month = ['янв', 'фев', 'мар', 'апр', 'май', 'июнь', 'июль', 'авг', 'сен', 'окт', 'ноя', 'дек'];
			return $month[$number - 1];
		}
		
		public static function formatTime($timestamp){
			$dateint = strtotime($timestamp);
			$datenormal = 
						date("G:i, j ", $dateint). self::getRusMonth((int)date('n', $dateint)). date(", Y ", $dateint);
			return $datenormal;
		}
		
		public static function formatDate($date){
			$dateint = strtotime($date);
			$datenormal = 
						date("d.m.Y ", $dateint);
			
			$datenormal = 
						date("d ", $dateint). self::getRusMonth((int)date('n', $dateint)). date(", Y ", $dateint);
			return $datenormal;
		}
		
		public static function translit($str) {
		    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
		    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
		    return str_replace($rus, $lat, $str);
		  }
		
		public static function getDaysAgo($timestamp){
			$dateint = strtotime($timestamp);
			$from = time() - $dateint;
			$daysago = intval((($from / 24) / 60) / 60);
			return $daysago;
		}
		public static function getTimeAgo($timestamp){
			$dateint = strtotime($timestamp);
			$dif = time() - $dateint;
			if($dif<59){
                    return $dif." сек. назад";
                }elseif($dif/60>1 and $dif/60<59){
                    return round($dif/60)." мин. назад";
                }elseif($dif/3600>1 and $dif/3600<23){
                    return round($dif/3600)." час. назад";
                }else{
                    return self::formatTime($timestamp);
                }
		}
		
		public static function getToken()
		{
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $randstring = '';
		    for ($i = 0; $i < 10; $i++) {
		        $randstring .= $characters[rand(0, strlen($characters))];
		    }
		    return $randstring;
		}
		
		public static function uploadPhoto($file, $sizes, $path){
			$uploaddir = $path;
			$filename = $file[name];
			$filetype = "";
			switch (substr($file['name'], -3)){
				case 'png':
					$filename = time().'.png';
					$filetype = "png";
					break;
				case 'jpg':
					$filename = time().'.jpg';
					$filetype = "jpg";
					break;
				default:
					return 701;	
			}
			$fullname = $uploaddir.$filename;
			
			if(!move_uploaded_file($file['tmp_name'], $fullname)){
				return 700;
			}
			$rez = array();
			foreach($sizes as $key => $value){

				$rezfilename = self::resizePhoto($fullname, $filename, $filetype, $value);
				
				if($value != 0)
					$rezfilename = str_replace(".".$filetype, "_".$value.'.'.$filetype, $rezfilename);
				array_push($rez, array($key => $rezfilename));
			}
			return $rez;
		}
		
		public static function uploadFile($file, $path){
			$uploaddir = $path;
			$filename = $file['name'];
			$fullname = $uploaddir.$filename;
			if(!move_uploaded_file($file['tmp_name'], $fullname)){
				return $file['name'];
			}
			return "success";
		}
		
		public static function resizePhoto($fullname, $filename, $filetype, $size ){
			if($size === 0) return $filename;
			
			$im = $filetype === "png" ? imagecreatefrompng($fullname) : imagecreatefromjpeg($fullname);
			
			$w_src = imagesx($im); 
			$h_src = imagesy($im); 
			$w = $size;
			$dest = imagecreatetruecolor($w,$w); 
			
			if ($w_src>$h_src) 
				imagecopyresampled($dest, $im, 0, 0,round((max($w_src,$h_src)-min($w_src,$h_src))/2),0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 
			
			if ($w_src < $h_src) 
				imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w,min($w_src,$h_src), min($w_src,$h_src)); 
				
			if ($w_src==$h_src) imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src); 
			
			$fullname = str_replace(".".$filetype, "_".$size.'.'.$filetype, $fullname);
			if($filetype === "png") imagepng($dest, $fullname);
			if($filetype === "jpg") imagejpeg($dest, $fullname);
			
			imagedestroy($im);
			return $filename;
			
		}
		
		public static function removeDirectory($dir) {
		    if ($objs = glob($dir."/*")) {
		       foreach($objs as $obj) {
		         is_dir($obj) ? helpers::removeDirectory($obj) : unlink($obj);
		       }
		    }
		    //rmdir($dir);
		    return 1;
		  }
	}

	
	
	
	
	
	
	
	