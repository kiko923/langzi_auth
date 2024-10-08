<?php
include("./includes/common.php");
session_start();


$qrsig = (isset($_SESSION['qrsig']) && isset($_SESSION['uin']) && isset($_SESSION['skey']) && isset($_SESSION['pskey']) && isset($_SESSION['superkey']) && isset($_SESSION['nick'])) 
    ? $_SESSION['qrsig'] 
    : header('Location: /get');
    
$uin=daddslashes($_GET['qq']);
if(!$uin || !$_GET['my']){
    exit("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><script language='javascript'>alert('未知错误');</script>");
}
// if(!$get_token || !$uin){exit();}

// $tokenid=base64_encode(md5($uin.md5($uin.'*$$*').'23132'.md5(date("Y-m-d-H"))));

// if($tokenid!=$get_token)exit("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
// <script language='javascript'>alert('验证信息已过期，请返回重新扫码验证。');history.go(-1);</script>");

$row=$DB->get_row("SELECT * FROM auth_site WHERE qq='$uin' limit 1");

if(!$row){
    // die('授权平台不存在该QQ！');
    exit("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><script language='javascript'>alert('授权平台不存在该QQ！');</script>");
}
$authcode=$row['authcode'];
$sign=$row['sign'];
// if(!$authcode || !$sign){exit();}

//============生成压缩包开始==================
require_once(SYSTEM_ROOT.'pclzip.php');
$file_real=substr($authcode,0,32).'.zip';
$file=ROOT.CACHE_DIR."/{$file_real}";
//============生成压缩包结束==================

if($_GET['my']=='install'){
    $file_path=ROOT.PACKAGE_DIR.'/install_'.PACKAGE_SUFFIX.'/';
	$file_str=file_get_contents(ROOT.PACKAGE_DIR.'/authcode.php');
	$file_str=str_replace('1000000001',$authcode,$file_str);
	file_put_contents($file_path.'includes/authcode.php',$file_str);
	$file_name='release_'.rand(11111,99999).'.zip';
    $DB->query("insert into `auth_down` (`type`,`authcode`,`sign`,`date`,`ip`) values ('扫码获取|安装包','".$authcode."','".$sign."','".$date."','".$clientip."')");
}elseif($_GET['my']=='update') {
    $file_path=ROOT.PACKAGE_DIR.'/update_'.PACKAGE_SUFFIX.'/';
	$file_str=file_get_contents(ROOT.PACKAGE_DIR.'/authcode.php');
	$file_str=str_replace('1000000001',$authcode,$file_str);
	file_put_contents($file_path.$conf['authfile'],$file_str);
    $file_name='update_'.rand(11111,99999).'.zip';
    $DB->query("insert into `auth_down` (`type`,`authcode`,`sign`,`date`,`ip`) values ('扫码获取|更新包','".$authcode."','".$sign."','".$date."','".$clientip."')");
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
