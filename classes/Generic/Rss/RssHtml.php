<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 10/07/2019
* Time: 08:33
*/

namespace Generic\Rss;

class RssHtml{

/** This plug-in accepts a string containing the HTML to be converted, along with other required arguments, and returns a properly formatted RSS document. It takes these arguments:
* •  $html  The HTML to convert
* •  $title  The RSS feed title to use
* •  $description  The RSS description to use
* •  $url  The URL to which the feed should link
* •  $webmaster  The e-mail address of the responsible webmaster
* •  $copyright  The copyright details
*/
	public function  hTMLToRSS($html, $title, $description, $url, $webmaster, $copyright){
		$date = date("D,dMYH:i:se");
		$html = str_replace('&amp;','&',$html);
		$html = str_replace('&','!!**1**!!',$html);
		$dom = new domdocument();
		@$dom->loadhtml($html);
		$xpath = new domxpath($dom);
		$hrefs = $xpath->evaluate("/html/body//a");
		$links = [];
		$to = [];
		$count = 0;

		for($j = 0; $j < $hrefs->length; ++$j){
			$links[] = $hrefs->item($j)->getAttribute('href');
		}
		$links = array_unique($links);
		sort($links);

		foreach($links as $link){
			if($link != ""){
				$temp = str_replace('!!**1**!!','&',$link);
				$to[$count] = urlencode(relToAbsURL($url, $temp));
				$html = str_replace("href=\"$link\"", "href=\"!!$count!!\"", $html);
				$html = str_replace("href='$link'", "href='!!$count!!'", $html);
				$html=str_replace("href=$link", "href=!!$count!!", $html);
				++$count;
			}
		}

		for($j = 0; $j < $count; ++$j)
		$html = str_replace("!!$j!!", $to[$j], $html);

		$html = str_replace('http%3A%2F%2F', 'http://', $html);
		$html = str_replace('!!**1**!!', '&', $html);


		$html = preg_replace('/[\s]+/', '', $html);
		$html = preg_replace('/<script[^>]*>.*?<\/script>/i','', $html);
		$html = preg_replace('/<style[^>]*>.*?<\/style>/i','', $html);
		$ok = '<a><i><b><u><s><h><img><div><span><table><tr>';
		$ok .= '<th><tr><td><br><p><ul><ol><li>';
		$html = strip_tags($html, $ok);
		$html = preg_replace('/<h[1-7][^>]*?>/i', '<h>', $html);
		$html = htmlentities($html);
		$html = preg_replace("/&lt;h&gt;/si", "</description></item>\n<item><title>", $html);
		$html = preg_replace("/&lt;\/h[1-7]&gt;/si", "</title><guid>$url</guid><description>", $html);
 
		return<<<_END
		<?xmlversion="1.0"encoding="UTF-8"?>
		<rssversion="2.0"><channel>
		<generator>Pluginphp.com:plug-in48</generator>
		<title>$title</title><link>$url</link>
		<description>$description</description>
		<language>en</language>
		<webMaster>$webmaster</webMaster>
		<copyright>$copyright</copyright>
		<pubDate>$date</pubDate>
		<lastBuildDate>$date</lastBuildDate>
		<item><title>$title</title>
		<guid>$url</guid>
		<description>$html</description></item></channel></rss>
_END;
	}

	/**
	* This plug-in accepts a string containing the contents of an RSS feed to be converted and returns that string transform
	*ed into HTML. It takes this argument:
	* •  $rss  The contents of an RSS feed to convert
	*/
	public function rSSToHTML($rss){
		$xml = simplexml_load_string($rss);
		$title = @$xml->channel->title;
		$link = @$xml->channel->link;
		$desc = @$xml->channel->description;
		$copyr = @$xml->channel->copyright;
		$ilink = @$xml->channel->image->link;
		$ititle = @$xml->channel->image->title;
		$iurl = @$xml->channel->image->url;

		$out = "<html><head><style>img{border:1pxsolid" . "#444444}</style>\n<body>";

		if($ilink!=""){
			$out.="<ahref='$ilink'><imgsrc='$iurl'title=". "'$ititle'alt='$ititle'border='0'style=". "'border:0px'align='left'/></a>\n";

			$out.="<h1>$title</h1>\n<h2>$desc</h2>\n";
		}

		foreach($xml->channel->item as $item){
			$tlink = @$item->link;
			$tdate = @$item->pubDate;
			$ttitle = @$item->title;
			$tdesc = @$item->description;

			$out.="<h3><ahref='$tlink'title='$tdate'>". "$ttitle</a></h3>\n<p>$tdesc</p>\n";
		}

		return "$out<ahref='$link'>$copyr</a></body></html>";
	}
}