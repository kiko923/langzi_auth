<?php
error_reporting(0);
define("CACHE_FILE",0);
define("IN_CRONLITE",true);
date_default_timezone_set('PRC');
define("SYSTEM_ROOT",dirname(__FILE__)."/");
define("ROOT",dirname(SYSTEM_ROOT)."/");
$date = date('Y-m-d H:i:s');
if(is_file(SYSTEM_ROOT."360safe/360webscan.php")){
    require_once(SYSTEM_ROOT."360safe/360webscan.php");
}
session_start();
$scriptpath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT']==443?'https://':'http://') . $_SERVER['HTTP_HOST'].$sitepath.'/';
require(ROOT."config.php");
if(!defined("SQLITE") && (!$dbconfig["user"] || !$dbconfig["pwd"] || !$dbconfig["dbname"])){
	header("Content-type:text/html;charset=utf-8");
	echo "你还没安装！<a href=\"/install/\">点此安装</a>";
	exit(0);
}
include_once(SYSTEM_ROOT."db.class.php");
$DB = new DB($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname'],$dbconfig['port']);
if($DB->query('select * from auth_config where 1')==false){
    header('Content-type:text/html;charset=utf-8');
    echo '你还没安装！<a href="/install/">点此安装</a>';
    exit(0);
}

include(SYSTEM_ROOT."cache.class.php");
$CACHE = new CACHE();
$conf = $CACHE->pre_fetch();

if($conf['qqjump'] == 1 && (!strpos($_SERVER['HTTP_USER_AGENT'],'QQ/') === false || !strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')===false)){
    if($_GET['open'] == 1 && !strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')===false){
        header('Content-Disposition: attachment; filename="load.doc"');
        header('Content-Type: application/vnd.ms-word;charset=utf-8');
    }else{
        header('Content-type:text/html;charset=utf-8');
    }
    include SYSTEM_ROOT."jump.php";
    exit(0);
}

$password_hash = '!@#%!s!0';
include_once SYSTEM_ROOT."function.php";
include_once SYSTEM_ROOT."member.php";

if(!file_exists(ROOT."install/install.lock") && file_exists(ROOT."install/index.php")){
	sysmsg("<h2>检测到无 install.lock 文件</h2><ul><li><font size=\"4\">如果您尚未安装本程序，请<a href=\"./install/\">前往安装</a></font></li><li><font size=\"4\">如果您已经安装本程序，请手动放置一个空的 install.lock 文件到 /install 文件夹下，<b>为了您站点安全，在您完成它之前我们不会工作。</b></font></li></ul><br/><h4>为什么必须建立 install.lock 文件？</h4>它是浪子授权网的保护文件，如果检测不到它，就会认为站点还没安装，此时任何人都可以安装/重装浪子授权系统。<br/><br/>", true);
}
?>