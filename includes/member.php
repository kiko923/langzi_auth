<?php
if(!defined('IN_CRONLITE'))exit();

$clientip=real_ip();

if(isset($_COOKIE["admin_token"])){
    $token=authcode(daddslashes($_COOKIE['admin_token']), 'DECODE', SYS_KEY);
    list($user, $sid) = explode("\t", $token);
    $session=md5($conf['admin_user'].$conf['admin_pass'].$password_hash);
	if($session==$sid){
		$islogin=1;
	}
}

if(isset($_COOKIE["user_token"])){
    $token=authcode(daddslashes($_COOKIE['user_token']), 'DECODE', SYS_KEY);
    list($user, $sid) = explode("\t", $token);
    $userrow = $DB->get_row("SELECT * FROM auth_user WHERE user='$user' limit 1");
    $session=md5($userrow['user'].$userrow['pass'].$password_hash);
	if($session==$sid){
      	$DB->query("UPDATE auth_user SET logintime='$date' WHERE user='$user'");
		$islogin2=1;
	}
}
?>