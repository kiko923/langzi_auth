<?php
include("../includes/common.php");
@header('Content-Type: application/json; charset=UTF-8');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

switch($act){

case 'del_user':
	if(!$islogin2)exit('{"code":-1,"msg":"未登录"}');
	$uid=intval($_POST['uid']);
	$row=$DB->get_row("SELECT * FROM auth_user WHERE uid='{$uid}' limit 1");
	if(!$row)exit('{"code":-1,"msg":"当前ＩＤ不存在"}');
    if($row['daili']!=$userrow['uid'])exit('{"code":-1,"msg":"此用户不属于您管理！"}');
	$sql="ALTER TABLE auth_user AUTO_INCREMENT=1";
	$DB->query("DELETE FROM auth_user WHERE uid='{$uid}'");
    if($DB->query($sql)){
		exit('{"code":0,"msg":"删除成功"}');
    }else{
    	exit('{"code":-1,"msg":"删除失败"}');
    }
break;

case 'del_site':
	if(!$islogin2)exit('{"code":-1,"msg":"未登录"}');
	$id=intval($_POST['id']);
	$row=$DB->get_row("SELECT * FROM auth_site WHERE id='{$id}' limit 1");
	if(!$row)exit('{"code":-1,"msg":"当前ＩＤ不存在"}');
    if($row['daili']!=$userrow['uid'])exit('{"code":-1,"msg":"此域名不属于您授权！"}');
	$sql="ALTER TABLE auth_site AUTO_INCREMENT=1";
	$DB->query("DELETE FROM auth_site WHERE id='{$id}'");
    if($DB->query($sql)){
		exit('{"code":0,"msg":"删除成功"}');
    }else{
    	exit('{"code":-1,"msg":"删除失败"}');
    }
break;
}
?>