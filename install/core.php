<?php
error_reporting(0);
define("CACHE_FILE",0);
define("IN_CRONLITE",true);
date_default_timezone_set('PRC');
define("SYSTEM_ROOT",dirname(__FILE__)."/");
define("ROOT",dirname(SYSTEM_ROOT)."/");
$date = date('Y-m-d H:i:s');
session_start();
if(defined('SAE_ACCESSKEY')){
	include_once ROOT.'includes/sae.php';
}else{
	include_once ROOT.'config.php';
}
if (!defined('SQLITE') && (!$dbconfig['user'] || !$dbconfig['pwd'] || !$dbconfig['dbname'])) {
	header('Content-type:text/html;charset=utf-8');
	echo '你还没安装！<a href="install/">点此安装</a>';
	exit;
}
$scriptpath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT']==443?'https://':'http://') . $_SERVER['HTTP_HOST'].$sitepath.'/';

include_once ROOT.'includes/db.class.php';
$DB = new DB($dbconfig['host'], $dbconfig['user'], $dbconfig['pwd'], $dbconfig['dbname'], $dbconfig['port']);

include_once ROOT."includes/cache.class.php";
$CACHE = new CACHE();
$conf = $CACHE->pre_fetch();

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
	$ckey_length = 4;
	$key = md5($key ? $key : ENCRYPT_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? $operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length) : '';
	$cryptkey = $keya . md5($keya . $keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? '' : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for ($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for ($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for ($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ $box[($box[$a] + $box[$j]) % 256]);
	}
	if ($operation == 'DECODE') {
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc . str_replace('=', '', base64_encode($result));
	}
}
function saveSetting($k,$v){
	global $DB;
	$v = addslashes($v);
	return $DB->query("REPLACE INTO auth_config SET k='$k',v='$v' ");
}