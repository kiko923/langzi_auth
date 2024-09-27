<?php
include("../includes/common.php");
if(isset($_POST['user']) && isset($_POST['pass'])){
	if(!$_SESSION['pass_error'])$_SESSION['pass_error']=0;
	$user=daddslashes($_POST['user']);
	$pass=daddslashes($_POST['pass']);
  	$pass=md5($pass);
	$row = $DB->get_row("SELECT * FROM auth_user WHERE user='$user' limit 1");
	if($row['user']==$user && $row['pass']==$pass){
		$session=md5($user.$pass.$password_hash);
		$token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
		setcookie("user_token", $token, time() + 604800);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('登录授权平台成功！');window.location.href='./';</script>");
	}else{
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
    }
}elseif(isset($_GET['logout'])){
	setcookie("user_token", "", time() - 604800);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登陆！');window.location.href='./login.php';</script>");
}elseif($islogin2==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $conf['title'] ?> - 用户登录</title>
<!-- Custom Theme files -->
<link href="/assets/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- Custom Theme files -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
<div class="login">
<h2><?php echo $conf['title'] ?> - 用户登录</h2>
<form action="./login.php" method="post" role="form">
<div class="login-top">
<input type="text" name="user" value="<?php echo @$_POST['user'];?>" style="margin-bottom:25px;" placeholder="请输入登录账号">
<input type="password" name="pass" placeholder="请输入登录密码">
</div>
<div class="forgot">
<input type="submit" value="Login" >
</div>
</form>
</div>
</body>
</html>