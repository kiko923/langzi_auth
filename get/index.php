
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>扫码自助下载最新源码</title>
  <!--<link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">-->
  <link href="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/twitter-bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
  <!--<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
  <script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/jquery/3.6.0/jquery.min.js" type="application/javascript"></script>
  <!--<script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>-->
  <script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/bootstrap/5.1.3/js/bootstrap.min.js" type="application/javascript"></script>
  <!--<script src="//cdn.bootcdn.net/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>-->
  <script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/lrsjng.jquery-qrcode/0.18.0/jquery-qrcode.min.js" type="application/javascript"></script>
  
  
  
  <script src="//static.wicdn.com/layui/layui.js" type="application/javascript"></script>
  <link href="//static.wicdn.com/layui/css/layui.css" type="text/css" rel="stylesheet" />
  <!--[if lt IE 9]>
    <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
    <script src="http://libs.useso.com/js/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
<script src="qrlogin.js?ver=1003"></script>
</head>
<body>
<div class="container">
<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
<div class="panel panel-primary">
	<div class="panel-heading" style="text-align: center;"><h3 class="panel-title">
		扫码自助下载最新源码
	</div>
	<div class="panel-body" style="text-align: center;">
		<div class="list-group">
			<div class="list-group-item">请使用你购买授权时的QQ扫描以下二维码，通过验证后即可下载更新包&安装包，扫码前需要关闭QQ网页保护。或者你也可以联系客服获取源码。</div>
			<div class="list-group-item list-group-item-info" style="font-weight: bold;" id="login">
				<span id="loginmsg">使用QQ手机版扫描二维码</span><span id="loginload" style="padding-left: 10px;color: #790909;">.</span>
			</div>
			<div class="list-group-item" id="qrimg">
			</div>
<div class="list-group-item" id="mobile" style="display:none;"><button type="button" id="mlogin" onclick="mloginurl()" class="btn btn-warning btn-block">跳转QQ快捷登录</button></div>
<div class="list-group-item" id="submit"><a href="#" onclick="loadScript()" class="btn btn-block btn-primary">点此验证</a></div>
		</div>
		  <a href="/" class="btn btn-default btn-sm">返回首页</a> 
	</div>
</div>

<!--<div class="panel panel-primary">-->
<!--	<div class="panel-body" style="text-align: center;">-->
<!--		<div class="list-group"><br>-->
<!--            售后群号123456-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
</div>
</div>
</body>
</html>
