<?php
$title='用户登录';
include("../includes/common.php");
if($islogin!=1){}else exit("<script language='javascript'>window.location.href='./';</script>");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $title ?></title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet"/>
<link href="/assets/css/nifty.min.css" rel="stylesheet"/>
<link href="/assets/css/magic-check.min.css" rel="stylesheet"/>
<script type="text/javascript" src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/pace.min.js"></script>
<script type="text/javascript" src="/assets/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/mulin.js"></script>
<script type="text/javascript" src="/assets/js/load.min.js"></script>
<style type="text/css">
/*滑块字体验证大小*/
.yidun_tips__text
{
    font-size:12px;    
}
</style>
</head>
<div id="container" class="cls-container">
<br/><br/><br/><br/>
<div id="bg-overlay" class="bg-img"></div>
<div class="cls-content">
<div class="cls-content-sm panel">
<div class="panel-body">
<!--头像结束-->
<div class="mar-ver pad-btm">
<img class="img-circle m-b-xs" style="border: 2px solid yellow; margin-left:3px; margin-right:3px;" src="http://q1.qlogo.cn/g?b=qq&nk=<?php echo $conf['kfqq'] ?>&s=100" draggable="false" width="84px" height="84px" alt="<?php echo $conf['title'] ?>">
<h3 class="h3 mar-no"><?php echo $conf['title'] ?></h3>
</div>
<!--头像结束-->

<div class="form-group">
<input type="text" id="user" value="<?php echo @$_POST['user'] ?>" class="form-control" placeholder="输入管理员账号" autofocus>
</div>

<div class="form-group">
<input type="password" id="pass" class="form-control" placeholder="输入管理员密码" autofocus>
</div>

<div class="form-group" id="captcha"></div>

<div class="form-group">
<input type="submit" onclick="login()" value="立即登陆" class="btn btn-primary btn-block" />
</div>

<div class="media pad-top bord-top">
<div class="pull-right">
<a href="./connect.php"><img src="../assets/icon/qqpay.ico"/></a>
</div>
<div class="media-body text-left">第三方快捷登录</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).keypress(function(e){
    if(e.which == 13){
        login();
    }
});
</script>
<script type="text/javascript">
initCaptcha();
hui.formInit();
function initCaptcha(){
	initNECaptcha({
		captchaId: "1f5120aead0443528966556bdfc31080",
		element: "#captcha",
		mode: "popup",
		width: "100px",
		onVerify: function(err, ret) {
			if (!err) {
				if(ret['validate']){
					window.captchaObj = true;
		        }else{
		        	window.captchaObj = false;
		        }
			}
		}
	}, function(instance) {
		// 初始化成功后得到验证实例instance，可以调用实例的方法
	}, function(err) {
		// 初始化失败后触发该函数，err对象描述当前错误信息
	});
};
</script>
</body>
</html>