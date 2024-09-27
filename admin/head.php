<?php
@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo $title ?></title>
  <link href="//lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
  <link href="//lib.baomitu.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!--[if lt IE 9]>
    <script src="//lib.baomitu.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//lib.baomitu.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<script>
function logout(){
	layer.confirm('您是否退出本次登录？',{btn:['确定','取消'],closeBtn:0,icon:5},function(){
		var ii = layer.msg('正在退出', {icon: 16,time: 0});
		$.ajax({
			type : "get",
			url : "ajax.php?act=login&logout",
			dataType : 'json',
			success : function(data){
				layer.close(ii);
				if(data.code == 0){
                    layer.msg(data.msg,{icon:1,time:2000,end:function(){window.location.href="./login.php"}});
				}
			}
		});
	},function(){});
};
</script>
<?php if($islogin==1){ ?>
  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">导航按钮</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./"><?php echo $conf['title'] ?></a>
      </div><!-- /.navbar-header -->
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">

          <li class="<?php echo checkIfActive('index,')?>">
            <a href="./"><span class="glyphicon glyphicon-home"></span> 平台首页</a>
          </li>

		  <li class="<?php echo checkIfActive('userlist,log,userinfo')?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon glyphicon-user"></span> 用户管理<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./userlist.php">用户列表</a></li>
			  <li><a href="./log.php">系统日志</a></li>
            </ul>
          </li>

		  <li class="<?php echo checkIfActive('list,addsite')?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-align-justify"></span> 授权管理<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./list.php">授权列表</a></li>
			  <li><a href="./addsite.php">添加授权</a></li>
            </ul>
          </li>
		  
		   <li class="<?php echo checkIfActive('downfile')?>"><a href="./downfile.php"><span class="glyphicon glyphicon-save"></span> 获取下载</a></li>
          	<li class="<?php echo checkIfActive('pirate')?>"><a href="./pirate.php"><span class="glyphicon glyphicon-remove"></span> 盗版站点</a></li>

		  <li class="<?php echo checkIfActive('set')?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> 系统设置<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./set.php?mod=site">网站配置</a></li>
			  <li><a href="./set.php?mod=check">授权配置</a></li>
            </ul>
          </li>
          <li><a href="javascript:logout();"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
<?php }?>