function js_AjaxRequest() {
	try {
		var request = new XMLHttpRequest()
	}
	catch(e1) {
		try {
			request = new ActiveXObject("Msxml2.XMLHTTP")
		}
		catch(e2) {
			try {
				request = new ActiveXObject("Microsoft.XMLHTTP")
			}
			catch(e3) {
				request = false
			}
		}
	}
	return  request
}

function postAjaxRequest(url, params, target) {
	request = new js_AjaxRequest()

	request.onreadystatechange = function() {
		if(this.readyState==4) {
			if(this.status==200) {
				if(this.responseText!=null) {
					target.innerHTML=this.responseText
				}
				//Youcanremovethesetwoalertsafterdebugging
			}else {
				alert("Ajax error: No data received")
			}
		}else {
			alert("Ajaxerror: "+ this.statusText)
		}
	}

	request.open("POST", url, true)
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	request.setRequestHeader("Content-length", params.length)
	request.setRequestHeader("Connection", "close")
	request.send(params)
}

function js_GetAjaxRequest(url,params,target)
{
	nocache = "&nocache=" +Math.random() * 1000000
	request = new js_AjaxRequest()

	request.onreadystatechange=function()
	{
		if(this.readyState == 4)
		if(this.status == 200)
		if(this.responseText != null)
		target.innerHTML = this.responseText
		//Youcanremovethesetwoalertsafterdebugging
		else alert("Ajax error: No data received")
		else alert("Ajaxerror: " + this.statusText)
	}

	request.open("GET", url + "?" + params + nocache, true)
	request.send(null)
}

function protectEmail($email) {
	$t1 = strpos($email, '@');
	$t2 = strpos($email, '.', $t1);
	if(!$t1 || !$t2) {
		return FALSE;
	}

	$e1 = substr($email, 0, $t1);
	$e2 = substr($email, $t1, $t2-$t1);
	$e3 = substr($email, $t2);

	return "<script>e1='$e1';e2='$e2';e3='$e3';document.write".
	"('<ahref=\'mailto:'+e1+e2+e3+'\'>'+e1".
	"+e2+e3+'</a>');</script>";
}

function toggleText($text1, $link1, $text2, $link2) {
	$tok = rand(0, 1000000);
	$out = "<divid='PIPHP_TT1_$tok'style='display:block;'>".
	"<ahref=\"javascript://\"onClick=\"document.".
	"getElementById('tT1_$tok').style.display=".
	"'none';document.getElementById('tT2_$tok')".
	".style.display='block';\">$link1</a>$text1</div>\n";

	$out .= "<divid='tT2_$tok'style='display:none;'>".
	"<ahref=\"javascript://\"onClick=\"document.".
	"getElementById('tT1_$tok').style.display=".
	"'block';document.getElementById('tT2_$tok')".
	".style.display='none';\">$link2</a>$text2</div>\n";
	return $out;
}

function slideShow($images) {
	$count = count($images);
	echo "<script>images=newArray($count);\n";

	for($j = 0; $j < $count; ++$j) {
		echo "images[$j]=newImage();";
		echo "images[$j].src='$images[$j]'\n";
	}

	return <<<_END
	counter = 0
	step = 4
	fade = 100
	delay = 0
	pause = 250
	startup = pause
	load('PIPHP_SS1', images[0]);
	load('PIPHP_SS2', images[0]);
	setInterval('process()', 20);

	functionprocess() {
		if(startup-- >  0)return;

		if(fade == 100)
		{
			if(delay < pause)
			{
				if(delay == 0)
				{
					fade = 0;
					load('PIPHP_SS1', images[counter]);
					opacity('PIPHP_SS1', 100);
					++counter;

					if(counter == $count)counter = 0;

					load('PIPHP_SS2', images[counter]);
					opacity('PIPHP_SS2', 0);
				}
				++delay;
			}
			else delay = 0;
		}
		else
		{
			fade += step;
			opacity('PIPHP_SS1', 100 - fade);
			opacity('PIPHP_SS2', fade);
		}
	}


	function opacity(id, deg)
	{
		var object = $(id).style;
		object.opacity = (deg/100);
		object.MozOpacity = (deg/100);
		object.KhtmlOpacity = (deg/100);
		object.filter = "alpha(opacity = " + deg + ")";
	}


	functionload(id, img) {
		$(id).src = img.src;
	}


	function $(id){
		return document.getElementById(id)
	}

	</script>
	_END;
}

function wordsFromRoot($word, $filename, $max) {
	$dict = file_get_contents($filename);
	preg_match_all('/\b' . $word . '[\w]+/', $dict, $matches);
	$c =min(count($matches[0]), $max);
	$out = [];
	for($j = 0; $j < $ c; ++$j) $out[$j] = $matches[0][$j];
	return $out;
}

function predictWord($params, $view, $max){
$id = rand(0,1000000);
$out = "<inputid='PIPHP_PWI_$id' $params".
"onKeyUp='js_PredictWord($view, $max, $id)'><br/>" . "<selectid='PIPHP_PWS_$id'style='display:none'/>\n";

for($j = 0; $j < $max; ++$j)
$out .= "<option id='PIPHP_PWO_$j" . "_$id'"  .
"onClick='js_CopyWord(this.id, $id)'>";

$out.='</select>';
static $PIPHP_PW_NUM;
if($PIPHP_PW_NUM++ == 0)$out .= <<<_END
<script>

function js_CopyWord(id1, id2) {
	$('PIPHP_PWI_'+id2).value=$(id1).innerHTML
	$('PIPHP_PWS_'+id2).style.display = 'none';
}

function js_PredictWord(view, max, id)
{
	if($('PIPHP_PWI_' + id).value.length > 0)
	{
		getAjaxRequest2('wordsfromroot.php', 'word=' + $('PIPHP_PWI_' + id).value + '&max=' + max, view, max, id)
		$('PIPHP_PWS_' + id).scrollTop = 0  $('PIPHP_PWO_0_' + id).selected = true
	}
	else$('PIPHP_PWS_' + id).style.display = 'none'
}

function lgetAjaxRequest(url, params, view, max, id) {
	nocache = "&nocache=" +Math.random() * 1000000
	request = new jS_AjaxRequest()

	request.onreadystatechange = function() {
		if(this.readyState == 4)
		if(this.status == 200)
		if(this.responseText != null)
		{
			a=this.responseText.split('|')
			c = 0

			for(j in a)
			{
				$('PIPHP_PWO_' + c + '_' + id).
				innerHTML = a[j]
				$('PIPHP_PWO_' + c++ + '_' + id).
				style.display = 'block'
			}

			n = c > view ? view : c
			while(c < max)
			{
				$('PIPHP_PWO_' +  c++ +'_'+ id).
				style.display='none'
			}
			$('PIPHP_PWS_' + id).size = n;
			$('PIPHP_PWS_' + id).style.display = 'block'

			//Youcanremovethesetwoalertsafterdebugging
			else alert("Ajaxerror:No data received")
			else alert("Ajax error: " + this.statusText)
		}

		request.open("GET", url + "?" + params + nocache, true)
		request.send(null)
	}

	function$(id)
	{
		return document.getElementById(id)
	}
	</script>
	_END;
	return $out;
}