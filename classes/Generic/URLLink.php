<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 09/07/2019
* Time: 15:49
*/

namespace Generic;

class URLLink{
	private $page;
	private $url;
	private $redirect;
	
	/** This method takes the URL of a web page, along with a link from within that page, and then  returns the link in a
	* form that can be accessed without reference to the calling page—in other words, an absolute URL. It takes these 
	* arguments:
	*
	* • $page  A web page URL, including the http:// preface and domain name
	* • $url  A link extracted from $page
	*/
	public function relToAbsURL($page, $url){
		if(substr($page, 0, 7) != "http://"){
			return $url;
		}

		$parse = parse_url($page);
		$root = $parse['scheme'] . "://" . $parse['host'];
		$p = strrpos(substr($page, 7), '/');

		if($p){
			$base=substr($page,0,$p+8);
		}else{
			$base="$page/";
		}

		if(substr($url, 0, 1) == '/'){
			$url = $root . $url;
		}elseif(substr($url,0,7) != "http://"){
			$url=$base.$url;
		}

		return $url;
	}

	/** This method takes the URL of a web page and parses it looking only for <a href links, and returns all that it finds
	* in an array. It takes a single argument:
	*
	* • $page  A web page URL, including the http:// preface and domain name
	*/
	public function getLinksFromURL($page){
		$contents = @file_get_contents($page);
		if(!$contents){
			return NULL;
		}

		$urls = [];
		$dom = new domdocument();
		@$dom->loadhtml($contents);
		$xpath = new domxpath($dom);
		$hrefs = $xpath->evaluate("/html/body//a");

		for($j = 0; $j < $hrefs->length; $j++)
		$urls[$j] = relToAbsURL($page, $hrefs->item($j)->getAttribute('href'));

		return $urls;
	}

	/** This method takes the URL of a web page (yours or a third party’s) and then tests all the links found within it to 
	* see whether they resolve to valid pages. It takes these three arguments:
	*
	* • $page  A web page URL, including the http:// preface and domain name
	* • $timeout  The number of seconds to wait for a web page before considering it unavailable
	* • $runtime  The maximum number of seconds your script should run before timing out
	*/
	public function checkLinks($page, $timeout, $runtime){
		ini_set('max_execution_time', $runtime);
		$contents = @file_get_contents($page);
		if(!$contents){
			return [1, [$page]];
		}

		$checked = [];
		$failed = [];
		$fail = 0;
		$urls = getLinksFromURL($page);
		$context = stream_context_create(['http'=> ['timeout' => $timeout]]);

		for($j = 0; $j < count($urls); $j++){
			if(!in_array($urls[$j], $checked)){
				$checked[] = $urls[$j];

				//Uncommentthefollowinglinetoviewprogress
				echo"$urls[$j]<br/>\n";
				ob_flush();
				flush();
 
				if(!@file_get_contents($urls[$j], 0, $context, 0, 256))
				$failed[$fail++] = $urls[$j];
			}
		}

		return [$fail, $failed];
	}

	/** This method takes the location of a directory on your server and returns all the files within it in an array. Upon 
	* success, it returns a four-element array, the first of which is the number of directories found. The second is the 
	* number of files found, the third is an array of directory names, and the fourth is an array of file names. On 
	* failure, it returns a single-element array with the value FALSE. It requires this argument:
	* 
	* • $path  The path of a directory on the server
	*/
	public function directoryList($path){
		$files = [];
		$dirs = [];
		$fnum = $dnum = 0;

		if(is_dir($path)){
			$dh = opendir($path);

			do{
				$item = readdir($dh);

				if($item !== FALSE && $item != "." && $item != ".."){
					if(is_dir("$path/$item")){
						$dirs[$dnum++] = $item;
					}else{
						$files[$fnum++] = $item;
					}
				}
			}while($item !== FALSE);

			closedir($dh);
		}

		return [$dnum, $fnum, $dirs, $files];
	}

	/** This method takes the text to display and the type of highlighting required for any search terms encountered. It 
	* requires these arguments:
	*
	* • $text  The text to highlight
	* • $highlight  The type of highlight to use, either b, i, or u for bold, italic, or underline
	*/
	public function queryHighlight($text, $highlight){
		$refer = getenv('HTTP_REFERER');
		$parse = parse_url($refer);

		if($refer == ""){
			return$text;
		}elseif(!isset($parse['query'])){
			return$text;
		}

		$queries = explode('&', $parse['query']);

		foreach($queries as $query){

			list($key, $value) = explode('=', $query);

			if($key=="q" || $key=="p"){
				$matches = explode('', preg_replace('/[^\w]/','', urldecode($value)));
				return $this->wordSelector($text, $matches, $highlight);
			}
		}
	}

	/** This method takes a copyright message and the first year the copyright began. It requires these arguments:
	*
	* • $message  The copyright message
	* • $year  The year the copyright began
	 */
	public function rollingCopyright($message, $year){
		return "$message&copy;$year - ". date("Y");
	}

	/** This method takes the YouTube ID of a video and the parameters required to display it to your requirements. It 
	* accepts these arguments:
	*
	* • $id  A YouTube video ID such as “VjnygQ02aW4”
	* • $width  The display width
	* • $height  The display height
	* • $hq  If set to 1, enable high-quality display, if available
	* • $full  If set to 1, enable the video to play in full-screen mode
	* • $auto  If set to 1, start the video playing automatically on page load
	*/
	public function embedYouTubeVideo($id, $width, $height, $hq, $full, $auto){
		if($hq==1){
			$q = "&ap=%2526fmt%3D18";
		}
		else{
			$q="";
		}

		return <<< END
		<objectwidth="$width"height="$height">
		<param name="movie" value="http://www.youtube.com/v/$id&fs=1&autoplay=$auto$q">
		</param>
		<param name="allowFullScreen"value="true"></param>
		<param name="allowscriptaccess"value="always"></param>
		<embed src="http://www.youtube.com/v/$id&fs=1&autoplay=$auto$q"
		type="application/x-shockwave-flash" allowscriptaccess="always"allowfullscreen="true" width="$width"height="$height"></embed></object>
END;
	}

	# This method takes an array containing all the items in a list, along with parameters to control the display formatting. It accepts these arguments:
	/**
	*
	* • $items  An array containing all the items in the list
	* • $start  The start number for ordered lists
	* • $type  The type of list: ul for unordered and ol for ordered
	* • $bullet  The type of bullet. For unordered lists: square, circle, or disc. For ordered lists: 1, A, a, I, or i
	*/
	public function createList($items, $start, $type, $bullet){
		$list="<$type start='$start'type='$bullet'>";
		foreach($items as $item){
			$list .= "<li>$item</li>\n";
		}
		return $list . "</$type>";
	}

	/** This method takes the name of a file to hold the counts for the current page, as well as details on what to do with 
	* it. It accepts these arguments:
	*
	* • $filename  A path/filename to use for storing hit count data
	* • $action  What to do with the data: reset = reset all counts, add = add the current visit to the data, get = 
	* retrieve hit stats, delete = delete the counter file
	*/
	public function hitCounter($filename, $action){
		$data = getenv("REMOTE_ADDR") . getenv("HTTP_USER_AGENT") . "\n";

		switch($action){
			case"reset":
			
			$fp = fopen($filename, "w");
			if(flock($fp,LOCK_EX)){
				flock($fp,LOCK_UN);
				fclose($fp);
				return;
			}

			case"add":
			$fp=fopen($filename,"a+");
			if(flock($fp,LOCK_EX)){
				fwrite($fp,$data);
				flock($fp,LOCK_UN);
				fclose($fp);
				return;
			}

			case"get":
			$fp=fopen($filename,"r");
			if(flock($fp,LOCK_EX)){
				$file = fread($fp, filesize($filename) -1);
				flock($fp, LOCK_UN);
				fclose($fp);
				$lines=explode("\n",$file);
				$raw=count($lines);
				$unique=count(array_unique($lines));
				return array($raw, $unique);
			}

			case"delete":
			unlink($filename);
			return;
		}
	}

	/** This method takes the name of a file to hold the referring data for the current page, as well as details on what to * do with it. Upon success, it either updates or returns details from the data file. It accepts these arguments:
	
	* • $filename  A path/file name to use for storing referring page data
	* • $action  What to do with the data: reset = reset all data; add = add the current visit to the data; get = retrieve 
	* referrer stats; delete = delete the file
	*/
	public function refererLog($filename, $action){
		$data = getenv("HTTP_REFERER") . "\n";
		if($data == "\n"){
			$data = "No Referrer\n";
		}

		switch($action){
			case "reset":
			$fp=fopen($filename,"w");
			if(flock($fp,LOCK_EX))
			;
			flock($fp,LOCK_UN);
			fclose($fp);
			return;

			case "add":
			$fp = fopen($filename,"a+");
			if(flock($fp,LOCK_EX))
			fwrite($fp,$data);
			flock($fp,LOCK_UN);
			fclose($fp);
			return;

			case"get":
			$fp = fopen($filename,"r");
			if(flock($fp,LOCK_EX)){
				$file = fread($fp,filesize($filename)-1);
				flock($fp,LOCK_UN);
				fclose($fp);
				$temp = array_unique(explode("\n",$file));
				sort($temp);
				return$temp;
			}

			case"delete":
			unlink($filename);
			return;
		}
	}

	/** This method accepts the URL of a web page to check, along with a set of links that ought to be present on it. If 
	* all the links are present, it returns an array with the single value TRUE, otherwise it returns a two-element array,
	* of which the first element is FALSE. The second is an array containing all the links that were not present. It takes 
	* these arguments:
	* •  $url  A string containing the URL of a page to check
	* •  $links  An array of links to look for on the page at $url
	*/
	function checkExternalLinks($url, $links){
		$results = $this->getLinksFromURL($url);
		$missing = [];
		$failed = 0;

		foreach($links as $link){
			if(!in_array($link, $results)){
				$missing[$failed++] = $link;
			}
		}

		if($failed == 0){
			return [TRUE];
		}else{
			return [FALSE, $missing];
		}
	}

	/**
	* This method accepts the URL of a web page whose title is to be extracted and returns the title. It takes this 
	* argument:
	* 
	* •  $page  A string containing the URL of a page to check
	*/
	public function getTitleFromURL($page){
		$contents = @file_get_contents($page);
		if(!$contents){
			return FALSE;
		}

		preg_match("/<title>(.*)<\/title>/i", $contents, $matches);

		if(count($matches)){
			return $matches[1];
		}
		else{
			return FALSE;
		}
	}

	/**
	* This method accepts the name of a file used as a datafile for storing details about sites linking to the current web 
	* page. It takes this argument:
	* 
	* •  $filename  The file and/or path name to read
	*/
	function autoBackLinks($filename){
		if(!file_exists($filename)){
			return [FALSE];
		}

		$inbound = [];
		$logfile = file_get_contents($filename);
		$links = explode("\n", rtrim($logfile));
		$links = array_count_values($links);
		arsort($links, SORT_NUMERIC);

		foreach($links as $key => $val)
		if($key != "No Referer"){
			$inbound[] = $key;
		}

		return [TRUE, $inbound];
	}

	/**
	* This method accepts a URL to be shortened, along with some other data, and returns a short URL. It takes these 
	* arguments:
	* 
	* •  $url  The URL to be shortened
	* •  $redirect  The name of a php file on your server that will make the redirects from short URLs to their original 
	* destinations
	* •  $len  The number of characters to use in the token part of a short URL. The more  you use, the more URLs are 
	* supported. For example, three characters will support 4,096 URLs since this method uses the hexadecimal digits 0–9 
	* and a–f.
	* •  $file  The name of a file in which to store the short URL data
	*/
	public function createShortURL($url, $redirect, $len, $file){
		$contents = @file_get_contents($file);
		$lines = explode("\n",$contents);
		$shorts = [];
		$longs = [];

		if(strlen($contents)){
			foreach($linesas$line){
				if(strlen($line)){
					list($shorts[], $longs[]) = explode('|', $line);
				}
			}
		}

		if(in_array($url, $longs)){
			for($j = 0; $j < count($longs); ++$j){
				if($longs[$j]==$url){
					return $redirect .  "?u=" . $shorts[$j];
				}
			}
		}

		do $str = substr(md5(rand(0,1000000)), 0, $len);
		while(in_array($str,$shorts));

		file_put_contents($file, $contents . $str . '|' . $url . "\n");
		return $redirect. "?u=$str";
	}

	/**
	* This method accepts a short token and returns its longer URL equivalent. It takes these arguments:
	* 
	* •  $token  A short token with which to look up the equivalent URL
	* •  $file  The datafile for this method
	*/
	function useShortURL($token, $file){
		$contents = @file_get_contents($file);
		$lines = explode("\n", $contents);
		$shorts = [];
		$longs = [];
		if(strlen($contents)){
			foreach($linesas$line){
				if(strlen($line)){
					list($shorts[],$longs[])=explode('|',$line);
				}
			}
		}

		if(in_array($token,$shorts)){
			for($j = 0; $j < count($longs); ++$j){
				if($shorts[$j] == $token){
					return $longs[$j];
				}
			}
		}

		return FALSE;
	}

	/**
	* This method accepts a URL to fetch, and returns it with all URLs and links to images altered to run through the 
	* proxy. It takes these arguments:
	* 
	* •  $url  The URL to fetch
	* •  $redirect  The filename of a PHP program to act as the web proxy
	*/
	public function simpleWebProxy($url, $redirect){
		$contents = @file_get_contents($url);
		if(!$contents){
			return NULL;
		}

		switch(strtolower(substr($url, -4))){
			case".jpg": case".gif": case".png": case".ico":
			case".css": case".js": case".xml":
			return $contents;
		}

		$contents = str_replace('&amp;', '&', $contents);
		$contents = str_replace('&', '!!**1**!!', $contents);

		$dom = new domdocument();
		@$dom->loadhtml($contents);
		$xpath = new domxpath($dom);
		$hrefs = $xpath->evaluate("/html/body//a");
		$sources = $xpath->evaluate("/html/body//img");
		$iframes = $xpath->evaluate("/html/body//iframe");
		$scripts = $xpath->evaluate("/html//script");
		$css = $xpath->evaluate("/html/head/link");
		$links = [];

		for($j = 0; $j < $hrefs->length; ++$j){
			$links[]=$hrefs->item($j)->getAttribute('href');
		}

		for($j = 0; $j < $sources->length; ++$j){
			$links[] = $sources->item($j)->getAttribute('src');
		}

		for($j = 0;$j < $iframes->length; ++$j){
			$links[] = $iframes->item($j)->getAttribute('src');
		}
		for($j = 0;$j < $scripts->length; ++$j){
			$links[] = $scripts->item($j)->getAttribute('src');
		}
		for($j = 0; $j < $css->length; ++$j){
			$links[]=$css->item($j)->getAttribute('href');
		}

		$links = array_unique($links);
		$to = [];
		$count = 0;
		sort($links);

		foreach($links as $link){
			if($link != ""){
				$temp = str_replace('!!**1**!!', '&', $link);

				$to[$count] = "/$redirect?u=" . urlencode(relToAbsURL($url, $temp));
				$contents = str_replace("href=\"$link\"", "href=\"!!$count!!\"", $contents);
				$contents = str_replace("href='$link'", "href='!!$count!!'", $contents);
				$contents = str_replace("href=$link", "href=!!$count!!", $contents);
				$contents = str_replace("src=\"$link\"", "src=\"!!$count!!\"", $contents);
				$contents = str_replace("src='$link'", "src='!!$count!!'", $contents);
				$contents = str_replace("src=$link", "src=!!$count!!", $contents);
				++$count;
			}

		}

		for($j= 0; $j < $count; ++$j){
			$contents = str_replace("!!$j!!",$to[$j], $contents);
		}
		return str_replace('!!**1**!!', '&', $contents);
	}

	/**
	* This method accepts the URL of a web page to monitor and lets you know whether it has been changed. It returns 1 if 
	* the page has changed, 0 if it is unchanged, -1 if the page is a new one not yet in the datafile, or -2 if the page 
	* was inaccessible. It takes these arguments:
	* 
	* •  $url  The URL to check
	* •  $datafile  The filename of a file containing the datafile
	*/
	public function pageUpdated($ datafile){
		$contents = @file_get_contents($page);
		if(!$contents){
			returnFALSE;
		}
		$checksum = md5($contents);

		if(file_exists($datafile)){
			$rawfile = file_get_contents($datafile);
			$data = explode("\n", rtrim($rawfile));
			$left = array_map("PU_F1", $data);
			$right = array_map("PU_F2", $data);
			$exists = -1;

			for($j = 0;$j < count($left); ++$j){
				if($left[$j] == $page){
					$exists = $j;
					if($right[$j] == $checksum){
						return0;
					}
				}
			}

			if($exists > -1){
				$rawfile = str_replace($right[$exists], $checksum, $rawfile);
				file_put_contents($datafile, $rawfile);
				return 1;
			}
		} else{
			$rawfile = "";
		}

		file_put_contents($datafile, $rawfile . "$page!1!$checksum\n");
		return -1;
	}

	private function  PU_F1($s){
		list($a, $b) = explode("!1!", $s);
		return $a;
	}

	private function PU_F2($s){
		list($a, $b) = explode("!1!", $s);
		return $b;
	}

}