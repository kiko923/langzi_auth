<?php
include("./includes/common.php");
$param=base64_decode($_GET['param']);
$arr=explode("\t",authcode($param,'DECODE','mulin_key'));
$version=$arr[0];
$url=$arr[1];
$authcode=$arr[2];

if(!$url || !$authcode){exit();}

if($arr[3]<time())exit("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><script language='javascript'>alert('链接已过期，请返回重新下载');history.go(-1);</script>");

if(checkauth2($url,$authcode)){
}else{
	exit("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<script language='javascript'>alert('暂时不能获取更新！');history.go(-1);</script>");
}

$row=$DB->get_row("SELECT * FROM auth_site WHERE url='$url' and authcode='$authcode' limit 1");
$sign=$row['sign'];

//============生成压缩包开始==================
require_once(SYSTEM_ROOT.'pclzip.php');
$file_real=substr($authcode,0,32).'.zip';
$file=ROOT.CACHE_DIR."/{$file_real}";
//============生成压缩包结束==================

$file_path=ROOT.PACKAGE_DIR.'/update_'.PACKAGE_SUFFIX.'/';
$file_str=file_get_contents(ROOT.PACKAGE_DIR.'/authcode.php');
$file_str=str_replace('1000000001',$authcode,$file_str);
file_put_contents($file_path.'includes/authcode.php',$file_str);

if(file_exists($file))unlink($file);
$zip = new PclZip($file);
$v_list = $zip->create($file_path ,PCLZIP_OPT_REMOVE_PATH,$file_path);

$DB->query("insert into `auth_down` (`type`,`authcode`,`sign`,`date`,`ip`) values ('检查更新|更新包','".$authcode."','".$sign."','".$date."','".$clientip."')");

$file_name='update.zip';
$file_size=filesize("$file");
header("Content-Description: File Transfer");
header("Content-Type:application/force-download");
header("Content-Length: {$file_size}");
header("Content-Disposition:attachment; filename={$file_name}");
readfile("$file");
?>