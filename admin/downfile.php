<?php
include("../includes/common.php");
$title='获取下载';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="container" style="padding-top:70px;">
<div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
if(isset($_GET['qqurl'])){
	$qqurl=daddslashes($_GET['qqurl']);
	$row=$DB->get_row("SELECT * FROM auth_site WHERE qq='{$qqurl}' or url='{$qqurl}' order by id desc limit 1");
	if(!$row)exit("<script type='text/javascript'>layer.alert('授权平台不存在该QQ！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	if($row['active']==0)exit("<script type='text/javascript'>layer.alert('此QQ的授权已被封禁！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">下载程序</h3></div>
<ul class="list-group">
<li class="list-group-item"><span class="glyphicon glyphicon-stats"></span> <b>授权ＱＱ：</b> <?=$row['qq']?></li>
<li class="list-group-item"><span class="glyphicon glyphicon-time"></span> <b>授权代码：</b> <?=$row['authcode']?></li>
<li class="list-group-item"><span class="glyphicon glyphicon-list"></span> <b>下载类型：</b> 
<a href="./download.php?my=install&authcode=<?=$row['authcode']?>&sign=<?=$row['sign']?>&r=<?=time()?>" class="btn btn-xs btn-success">安装包</a>&nbsp;
<a href="./download.php?my=update&authcode=<?=$row['authcode']?>&sign=<?=$row['sign']?>&r=<?=time()?>" class="btn btn-xs btn-primary">更新包</a>
</li>
</ul>
<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span> 新购用户请下载安装包！
</div>
</div>
<?php }else{ ?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">获取下载</h3></div>
<div class="panel-body">

<form action="./downfile.php" method="GET" class="form-horizontal" role="form">

<div class="input-group">
<span class="input-group-addon">下载信息</span>
<input type="text" name="qqurl" value="<?=@$_GET['qqurl']?>" class="form-control" placeholder="请输入域名或QQ即可下载！"/>
</div><br/>

<div class="form-group">
<div class="col-sm-12"><input type="submit" value="获取下载地址" class="btn btn-primary form-control"/></div>
</div>

</form>

</div>
</div>
<?php } ?>
</div>
</div>