<?php
include("../includes/common.php");
@header('Content-Type: application/json; charset=UTF-8');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

switch($act){

case 'login':
	if(isset($_POST['user']) && isset($_POST['pass'])){
		$user=daddslashes($_POST['user']);
		$pass=daddslashes($_POST['pass']);
		$pass=md5($pass);
		if($user==$conf['admin_user'] && $pass==$conf['admin_pass']){
			$session=md5($user.$pass.$password_hash);
			$token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
			setcookie("admin_token", $token, time() + 604800);
			exit('{"code":0,"msg":"尊敬的管理员,欢迎回来"}');
		}else{
			exit('{"code":-1,"msg":"用户名或密码不正确"}');
		}
	}elseif(isset($_GET['logout'])){
		setcookie("admin_token", $token, time() - 604800);
		exit('{"code":0,"msg":"退出成功"}');
	}elseif($islogin==1){
		exit('{"code":0,"msg":"您已经登录","url":"./"}');
	}
break;

case 'jiebang':
	if(!$islogin)exit('{"code":-1,"msg":"未登录"}');
	if(!$conf['access_token']){
		exit('{"code":-1,"msg":"你还没绑定快捷QQ登录，无法解绑！"}');
	}elseif(saveSetting("access_token",NULL)){
		exit('{"code":0,"msg":"解绑快捷登录成功！"}');
	}
break;

case 'del_user':
	if(!$islogin)exit('{"code":-1,"msg":"未登录"}');
	$uid=intval($_POST['uid']);
	$row=$DB->get_row("SELECT * FROM auth_user WHERE uid='{$uid}' limit 1");
	if(!$row)exit('{"code":-1,"msg":"当前ＩＤ不存在"}');
	$DB->query("ALTER TABLE auth_user AUTO_INCREMENT=1");
	$DB->query("DELETE FROM auth_user WHERE uid='{$uid}'");
	exit('{"code":0,"msg":"删除成功"}');
break;

case 'del_site':
	if(!$islogin)exit('{"code":-1,"msg":"未登录"}');
	$id=intval($_POST['id']);
	$row=$DB->get_row("SELECT * FROM auth_site WHERE id='{$id}' limit 1");
	if(!$row)exit('{"code":-1,"msg":"当前ＩＤ不存在"}');
	$DB->query("ALTER TABLE auth_site AUTO_INCREMENT=1");
	$DB->query("DELETE FROM auth_site WHERE id='{$id}'");
	exit('{"code":0,"msg":"删除成功"}');
break;
}
?>