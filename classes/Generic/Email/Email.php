<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 10/07/2019
* Time: 07:28
*/

namespace Generic\Email;

class Email{
	
	public function sendEmail($message, $subject, $priority, $from, $replyto, $to, $cc, $bcc, $type) {
		$headers="From:$from\r\n";

		if(strtolower($type) == "html"){
			$headers .= "MIME-Version:1.0\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1\r\n";
		}

		if($priority > 0){
			$headers .= "X-Priority:$priority\r\n";
		}
		
		if($replyto != ""){
			$headers .= "Reply-To:$replyto\r\n";
		}

		if(count($cc)){
			$headers .= "Cc:";
			
			for($j = 0; $j < count($cc) ;++$j){
				$headers .= $cc[$j] . ",";
			}
			$headers = substr($headers, 0, -1) . "\r\n";
		}

		if(count($bcc)){
			$headers .= "Bcc:";
			
			for($j = 0; $j < count($bcc); ++$j){
				$headers .= $bcc[$j] . ",";
			}
			$headers = substr($headers,  0, -1) . "\r\n";
		}

		return mail($to, $subject, $message, $headers);
	}

	public function bBCode($string){
		$from = ['[b]','[/b]','[i]','[/i]',
			'[u]','[/u]','[s]','[/s]',
			'[quote]','[/quote]',
			'[code]','[/code]',
			'[img]','[/img]',
			'[/size]','[/color]',
			'[/url]'];
		$to = ['<b>','</b>','<i>','</i>',
			'<u>','</u>','<s>','</s>',
			'<blockquote>','</blockquote>',
			'<pre>','</pre>',
			'<imgsrc="','"/>',
			'</span>','</font>',
			'</a>'];
		$string = str_replace($from,$to,$string);
		$string = preg_replace("/\[size=([\d]+)\]/",
			"<spanstyle=\"font-size:$1px\">",$string);
		$string=preg_replace("/\[color=([^\]]+)\]/",
			"<fontcolor='$1'>",$string);
		$string = preg_replace("/\[url\]([^\[]*)<\/a>/",
			"<ahref='$1'>$1</a>",$string);
		$string=preg_replace("/\[url=([^\]]*)]/",
			"<ahref='$1'>",$string);
		return $string;
	}

	public function poundCode($text){
		$names = ['#georgia','#arial','#courier',
			'#script','#impact','#comic',
			'#chicago','#verdana','#times'];
			$fonts = ['Georgia','Arial','CourierNew',
			'Script','Impact','ComicSansMS',
			'Chicago','Verdana','TimesNewRoman'];
		$to = [];
		for($j =  0; $j < count($names); ++$j) {
			$to[] = "<fontface='$fonts[$j]'>";
		}
		$text = str_ireplace($names, $to, $text);

		$text = preg_replace('/#([bius])-/i',"</$1>", $text);
		$text = preg_replace('/#([bius])/i',"<$1>", $text);
		$text = preg_replace('/#([1-7])/',"<fontsize='$1'>", $text);
		$text = preg_replace('/#([a-z]+)/i',"<fontcolor='$1'>", $text);
		$text = str_replace('#-',"</font>",$text);

		return $text;
	}
}