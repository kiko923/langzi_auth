<?php
function checkIfActive($string) {
	$array=explode(',',$string);
	$php_self=substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['REQUEST_URI'],'/')+1,strrpos($_SERVER['REQUEST_URI'],'.')-strrpos($_SERVER['REQUEST_URI'],'/')-1);
	if (in_array($php_self,$array)){
		return 'active';
	}else
		return null;
}
function checkmobile(){
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$ualist = array('android', 'midp', 'nokia', 'mobile', 'iphone', 'ipod', 'blackberry', 'windows phone');
	if((dstrpos($useragent, $ualist) || strexists($_SERVER['HTTP_ACCEPT'], "VND.WAP") || strexists($_SERVER['HTTP_VIA'],"wap"))){
		return true;
	}else{
		return false;
	}
}
function dstrpos($string,$arr){
	if(empty($string)) return false;
	foreach((array)$arr as $v){
		if(strpos($string, $v)!==false){
			return true;
		}
	}
	return false;
}
function strexists($string,$find){
	return !(strpos($string,$find)===FALSE);
}
function sysmsg($msg = '未知的异常', $die = true){
	echo "  \r\n    <!DOCTYPE html>\r\n    <html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"zh-CN\">\r\n    <head>\r\n        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n        <title>站点提示信息</title>\r\n        <style type=\"text/css\">\r\nhtml{background:#eee}body{background:#fff;color:#333;font-family:\"微软雅黑\",\"Microsoft YaHei\",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px \"微软雅黑\",\"Microsoft YaHei\",,sans-serif;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:9px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:9px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top}.button.button-large{height:29px;line-height:28px;padding:0 12px}.button:focus,.button:hover{background:#fafafa;border-color:#999;color:#222}.button:focus{-webkit-box-shadow:1px 1px 1px rgba(0,0,0,.2);box-shadow:1px 1px 1px rgba(0,0,0,.2)}.button:active{background:#eee;border-color:#999;color:#333;-webkit-box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5);box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5)}table{table-layout:auto;border:1px solid #333;empty-cells:show;border-collapse:collapse}th{padding:4px;border:1px solid #333;overflow:hidden;color:#333;background:#eee}td{padding:4px;border:1px solid #333;overflow:hidden;color:#333}\r\n        </style>\r\n    </head>\r\n    <body id=\"error-page\">\r\n        ";
	echo "<h3>站点提示信息</h3>";
	echo $msg;
	echo "    </body>\r\n    </html>\r\n    ";
	if ($die == true) {
		exit(0);
	}
}
function getSubstr($str, $leftStr, $rightStr){
	$left = strpos($str, $leftStr);
	//echo '左边:'.$left;
	$right = strpos($str, $rightStr,$left);
	//echo '<br>右边:'.$right;
	if($left < 0 or $right < $left) return '';
	return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
}
function get_curl($url,$post=0,$referer=0,$cookie=0,$header=0,$ua=0,$nobaody=0){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$httpheader[] = "Accept:*/*";
	$httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
	$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
	$httpheader[] = "Connection:close";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	if($post){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	if($header){
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
	}
	if($cookie){
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	if($referer){
		if($referer==1){
			curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
		}else{
			curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
	}
	if($ua){
		curl_setopt($ch, CURLOPT_USERAGENT,$ua);
	}else{
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Linux; Android 4.4.2; NoxW Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36');
	}
	if($nobaody){
		curl_setopt($ch, CURLOPT_NOBODY,1);
	}
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}
function curl_get($url){
    $ch=curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $content=curl_exec($ch);
    curl_close($ch);
    return($content);
}
function saveSetting($k,$v){
	global $DB;
	$v = daddslashes($v);
	return $DB->query("REPLACE INTO auth_config SET k='$k',v='$v' ");
}
function get_km(){
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $strlen = strlen($str);
    $randstr = '';
	$randstr1 = '';
	$randstr2 = '';
	$randstr3 = '';
    for ($i = 0; $i < 5; $i++) {
        $randstr .= $str[mt_rand(0, $strlen - 1)];
    }
	for ($i = 0; $i < 5; $i++) {
        $randstr1 .= $str[mt_rand(0, $strlen - 1)];
    }
	for ($i = 0; $i < 5; $i++) {
        $randstr2 .= $str[mt_rand(0, $strlen - 1)];
    }
	for ($i = 0; $i < 5; $i++) {
        $randstr3 .= $str[mt_rand(0, $strlen - 1)];
    }
    return $randstr."_".$randstr1."_".$randstr2."_".$randstr3;
}
function real_ip()
{
        if (isset($_SERVER['HTTP_CDN_SRC_IP']) && $_SERVER['HTTP_CDN_SRC_IP'] != 'unknown') {
            $realip = $_SERVER["HTTP_CDN_SRC_IP"];
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $realip = getenv('HTTP_CLIENT_IP');
        } else {
            $realip = getenv('REMOTE_ADDR');
        }
     
        $realip = explode(',', $realip);
        if ($realip[0] === '::1') return '127.0.0.1';
        return $realip[0];

    }
function get_ip_city($ip){
    $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
    $ipinfo=json_decode(file_get_contents($url)); 
    if($ipinfo->code=='1'){
        return false;
    }
    $city = $ipinfo->data->region.$ipinfo->data->city;
    return $city; 
}
function daddslashes($string, $force = 0, $strip = FALSE){
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force, $strip);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : ENCRYPT_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}
function random($length, $numeric = 0){
	$seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? str_replace('0', '', $seed) . '012340567890' : $seed . 'zZ' . strtoupper($seed);
	$hash = '';
	$max = strlen($seed) - 1;
	for ($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}
function showmsg($content = '未知的异常',$type = 4,$back = false){
	switch($type){
		case 1:
			$panel="success";
		break;
		case 2:
			$panel="info";
		break;
		case 3:
			$panel="warning";
		break;
		case 4:
			$panel="danger";
		break;
	}

	echo '<div class="panel panel-'.$panel.'"><div class="panel-heading"><h3 class="panel-title">提示信息</h3></div><div class="panel-body">';
	echo $content;
	if($back){
		echo '<hr/><a href="'.$back.'"><< 返回上一页</a>';
	}
	else
   		echo '<hr/><a href="javascript:history.back(-1)"><< 返回上一页</a>';
		echo '</div></div>';
	exit;
}
function getIP()
    {
        if (isset($_SERVER['HTTP_CDN_SRC_IP']) && $_SERVER['HTTP_CDN_SRC_IP'] != 'unknown') {
            $realip = $_SERVER["HTTP_CDN_SRC_IP"];
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $realip = getenv('HTTP_CLIENT_IP');
        } else {
            $realip = getenv('REMOTE_ADDR');
        }
     
        $realip = explode(',', $realip);
        if ($realip[0] === '::1') return '127.0.0.1';
        return $realip[0];

    }
function checkauth($url,$authcode){
	global $DB,$date,$conf;
	$ip = getIP();
	if(!$url && !$authcode)return false;
	if($conf['checkq']==1){
		if($conf['switch']==1){
			$row=$DB->get_row("SELECT * FROM auth_site WHERE url='$url' and authcode='$authcode' limit 1");
			if($row){
				if(empty($row['ip'])){
					$DB->query("update auth_site set ip='{$ip}' where id='{$row['id']}'");
				}elseif($row['ip']!=$ip){
					if($conf['ipauth']==1){
						return false;
					}else{
						$DB->query("update auth_site set ip='{$ip}' where id='{$row['id']}'");
						return true;
					}
				}
				if($row['active']==1){
					return true;
				}else{
					return false;
				}
			}
		}else{
			$row=$DB->get_row("SELECT * FROM auth_site WHERE url='$url' limit 1");
			if($row){
				if(empty($row['ip'])){
					$DB->query("update auth_site set ip='{$ip}' where id='{$row['id']}'");
				}elseif($row['ip']!=$ip){
					if($conf['ipauth']==1){
						return false;
					}else{
						$DB->query("update auth_site set ip='{$ip}' where id='{$row['id']}'");
						return true;
					}
				}
				if($row['active']==1){
					return true;
				}else{
					return false;
				}
			}
		}
	}else{
		return true;
	}
}
function checkauth2($url){
	global $DB;
	$row=$DB->get_row("SELECT * FROM auth_site WHERE url='$url' limit 1");
	if($row['active']==1){
		return true;
	}else{
		return false;
	}
}
?>
