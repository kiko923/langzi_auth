<?php
include("../includes/common.php");
$title='管理中心';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$sites=$DB->count("SELECT count(*) from auth_site WHERE 1");
$blocks=$DB->count("SELECT count(*) from auth_block WHERE 1");
?>
<div class="container" style="padding-top:70px;">
<div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<div class="panel panel-primary">
<div class="panel-heading text-center"><h3 class="panel-title">授权平台信息</h3></div>
<ul class="list-group">
<li class="list-group-item"><span class="glyphicon glyphicon-stats"></span> <b>站点统计：</b> 正版:<?=$sites?>，盗版:<?=$blocks?></li>
<li class="list-group-item"><span class="glyphicon glyphicon-time"></span> <b>现在时间：</b> <?=$date?></li>
<li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>用户权限：</b> 平台站长</li>
<li class="list-group-item"><span class="glyphicon glyphicon-list"></span> <b>功能菜单：</b>
<a href="./addsite.php" class="btn btn-xs btn-success">授权</a>
<a href="./userlist.php" class="btn btn-xs btn-warning">用户</a>
<a href="./log.php" class="btn btn-xs btn-info">日志</a>
<a href="./pirate.php" class="btn btn-xs btn-primary">盗版</a>
</li>
</ul>
</div>
</div>
</div>
