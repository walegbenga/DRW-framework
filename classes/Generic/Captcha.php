<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 09/07/2019
* Time: 17:38
*/

namespace Generic;

class Captcha{
	function createCaptcha($size, $length, $font, $folder, $salt1, $salt2){
		$file = file_get_contents('dictionary.txt');
		$temps = explode("\r\n",$file);
		$dict = [];

		foreach($tempsas$temp){
			if(strlen($temp) == $length){
				$dict[] = $temp;
			}
		}

		$captcha = $dict[rand(0, count($dict) - 1)];
		$token = md5("$salt1$captcha$salt2");
		$fname = $folder . $token . ".gif";
		gifText($fname, $captcha, $font, $size, "444444", "ffffff", $size/10, "666666");
		$image = imagecreatefromgif($fname);
		$image = imageAlter($image, 2);
		$image = imageAlter($image, 13);

		for($j=0; $j<3; ++$j){
			$image = imageAlter($image,3);
		}

		for($j=0; $j<2; ++$j){
			$image = imageAlter($image,5);
		}

		imagegif($image, $fname);
		return [$captcha,$token,$fname];
	}

	function checkCaptcha($captcha,$token, $salt1,$salt2) {
		$token == md5("$salt1$captcha$salt2");

		foreach(glob($folder."*.gif") as $file){
			if(time()-filectime($file)>300){
				unlink($file);
			}
		}
		return $token;
	}

	function spamCatch($text, $words) {
		return strlen($text) - strlen(wordSelector($text, $words, ''));
	}

}