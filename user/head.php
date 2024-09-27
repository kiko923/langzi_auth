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
<?php if($islogin2==1){ ?>
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
<?php if($userrow['type']==1 or $userrow['type']==2){ ?>
<li class="<?php echo checkIfActive('userlist')?>"><a href="./userlist.php"><span class="glyphicon glyphicon-user"></span> 用户管理</a></li>
<?php } ?>
<li class="<?php echo checkIfActive('list,addsite,search')?>">
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cloud"></span> 授权管理<b class="caret"></b></a>
<ul class="dropdown-menu">
<li class="<?php echo checkIfActive('list')?>"><a href="./list.php">授权列表</a></li>
<li class="<?php echo checkIfActive('addsite')?>"><a href="./addsite.php">添加授权</a><li>
<li class="<?php echo checkIfActive('search')?>"><a href="./search.php">搜索授权</a><li>
</ul>
</li>
<li class="<?php echo checkIfActive('downfile')?>"><a href="./downfile.php"><span class="glyphicon glyphicon-thumbs-up"></span> 下载程序</a></li>
<li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
</ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container -->
</nav><!-- /.navbar -->
<?php }?>