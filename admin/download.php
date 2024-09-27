<?php
include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$authcode=$_GET['authcode'];
$sign=$_GET['sign'];
if(!$authcode){exit();}

//============生成压缩包开始==================
require_once(SYSTEM_ROOT.'pclzip.php');
$file_real=substr($authcode,0,32).'.zip';
$file=ROOT.CACHE_DIR."/{$file_real}";
//============生成压缩包结束==================

$clientip=real_ip();

if($_GET['my']=='install'){
    $file_path=ROOT.PACKAGE_DIR.'/install_'.PACKAGE_SUFFIX.'/';
    $file_str=file_get_contents(ROOT.PACKAGE_DIR.'/authcode.php');
    $file_str=str_replace('1000000001',$authcode,$file_str);
    file_put_contents($file_path.'includes/authcode.php',$file_str);
    $file_name='release_'.rand(11111,99999).'.zip';
    $DB->query("insert into `auth_down` (`type`,`authcode`,`sign`,`date`,`ip`) values ('后台获取|安装包','".$authcode."','".$sign."','".$date."','".$clientip."')");
}elseif($_GET['my']=='update'){
    $file_path=ROOT.PACKAGE_DIR.'/update_'.PACKAGE_SUFFIX.'/';
    $file_str=file_get_contents(ROOT.PACKAGE_DIR.'/authcode.php');
    $file_str=str_replace('1000000001',$authcode,$file_str);
    file_put_contents($file_path.'includes/authcode.php',$file_str);
    $file_name='update_'.rand(111111,999999).'.zip';
    $DB->query("insert into `auth_down` (`type`,`authcode`,`sign`,`date`,`ip`) values ('后台获取|更新包','".$authcode."','".$sign."','".$date."','".$clientip."')");
}

if(file_exists($file))unlink($file);
$zip = new PclZip($file);
$v_list = $zip->create($file_path ,PCLZIP_OPT_REMOVE_PATH,$file_path);

$file_size=filesize("$file");
header("Content-Description: File Transfer");
header("Content-Type:application/force-download");
header("Content-Length: {$file_size}");
header("Content-Disposition:attachment; filename={$file_name}");
readfile("$file");
?>