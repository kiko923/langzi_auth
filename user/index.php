<?php
include("../includes/common.php");
$title='平台中心';
include './head.php';
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$sites=$DB->count("SELECT count(*) from auth_site WHERE daili='{$userrow['uid']}'");
$blocks=$DB->count("SELECT count(*) from auth_block WHERE 1");

if($userrow['type']==1){
	$type="超级管理员";
}elseif($userrow['type']==2){
	$type="合作商权限";
}elseif($userrow['type']==3){
	$type="授权商权限";
}
?>
<div class="container" style="padding-top:70px;">
<div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<div class="panel panel-primary">
<div class="panel-heading text-center"><h3 class="panel-title">平台信息</h3></div>
<ul class="list-group">
<li class="list-group-item"><span class="glyphicon glyphicon-stats"></span> <b>站点统计：</b> 正版:<?=$sites?>，盗版:<?=$blocks?></li>
<li class="list-group-item"><span class="glyphicon glyphicon-time"></span> <b>现在时间：</b> <?=$date?></li>
<li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>用户权限：</b> <?=$type?></li>
<li class="list-group-item"><span class="glyphicon glyphicon-list"></span> <b>功能菜单：</b>
<a href="./addsite.php" class="btn btn-xs btn-success">添加授权</a>
</li>
</ul>
</div>
</div>
</div>
