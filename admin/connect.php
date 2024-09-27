<?php 
include("../includes/common.php");
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']. '/';//获取本地域名
$allapi	 ='http://api.cccyun.cc/';//QQ快捷登录API地址

class Oauth{

function __construct(){
	global $siteurl;
	$this->callback = $siteurl.'admin/connect.php';//登录回调地址
}

public function login(){
	global $allapi;
	
	//-------生成唯一随机串防CSRF攻击
	$state = md5(uniqid(rand(), TRUE));
	$_SESSION['Oauth_state'] = $state;

	//-------构造请求参数列表
	$keysArr = array("act" => "login","media_type" => $_GET['type'],"redirect_uri" => $this->callback,"state" => $state);
	$login_url = $allapi.'social/connect.php?'.http_build_query($keysArr);
	header("Location:$login_url");
}

public function callback(){
	global $allapi;
	//--------验证state防止CSRF攻击
	if($_GET['state'] != $_SESSION['Oauth_state']){
		sysmsg("<h2>The state does not match. You may be a victim of CSRF.</h2>");
	}

	//-------请求参数列表
	$keysArr = array("act" => "callback","code" => $_GET['code'],"redirect_uri" => $this->callback);

	//------构造请求access_token的url
	$token_url = $allapi.'/social/connect.php?'.http_build_query($keysArr);
	$response = get_curl($token_url);

	$arr = json_decode($response,true);

	if(isset($arr['error_code'])){
		sysmsg('<h3>error:</h3>'.$arr['error_code'].'<h3>msg  :</h3>'.$arr['error_msg']);
	}

	$_SESSION['Oauth_access_token']=$arr["access_token"];
	$_SESSION['Oauth_social_uid']=$arr["social_uid"];
	return $arr;
    }
}
$Oauth = new Oauth();
header("Content-Type: text/html; charset=UTF-8");
if($_GET['code']){
    $array = $Oauth->callback();
    $media_type = $array['media_type'];
    $access_token = $array['access_token'];
    $social_uid = $array['social_uid'];
    //以下是授权系统写法
	if(!$islogin){
		if(!$conf['access_token']){
			@header('Content-Type: text/html; charset=UTF-8');
			exit("<script language='javascript'>alert('该QQ未绑定用户！');history.go(-1);</script>");
		}elseif($conf['access_token']==$social_uid){
			$user=$conf['admin_user'];
			$pass=$conf['admin_pass'];
			$session=md5($user.$pass.$password_hash);
			$token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
			setcookie("admin_token", $token, time() + 604800);
			@header('Content-Type: text/html; charset=UTF-8');
			exit("<script language='javascript'>alert('登录成功,欢迎回来!');window.location.href='./';</script>");
		}
	}else{
		if($conf['access_token']==$social_uid){
			@header('Content-Type: text/html; charset=UTF-8');
			exit("<script language='javascript'>alert('该QQ已绑定其他用户！');history.go(-1);</script>");
		}else{
			saveSetting('access_token',$social_uid);
			@header('Content-Type: text/html; charset=UTF-8');
			exit("<script language='javascript'>alert('恭喜你，绑定成功');window.location.href='./';</script>");
		}
	}
	unset($array);
}else{
    $Oauth->login();
}