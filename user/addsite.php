<?php
include("../includes/common.php");
$title='添加授权';
include './head.php';
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

if(isset($_POST['qq']) && isset($_POST['url'])){
	$qq=daddslashes($_POST['qq']);
	$url=daddslashes($_POST['url']);
	
	if($qq==NULL or $url==NULL){
		exit("<script type='text/javascript'>layer.alert('所有项都不能为空！',{icon:5},function(){window.location.href='./addsite.php'});</script>");
	}

	$row1=$DB->get_row("SELECT * FROM auth_site WHERE qq='{$qq}' limit 1");
	$row2=$DB->get_row("SELECT * FROM auth_site WHERE 1 order by sign desc limit 1");

	if($row1){
		$authcode=$row1['authcode'];
		$sign=$row1['sign'];
	}elseif(!$row1){
		$authcode=md5(random(32).$qq);
		$sign=$row2['sign']+1;
	}

	$url=str_replace('，',',',$url);
	$url_arr=explode(',',$url);

	foreach($url_arr as $val){
		$row=$DB->get_row("SELECT * FROM auth_site WHERE url='{$val}' limit 1");
		if($row){
			exit("<script type='text/javascript'>layer.alert('该域名已存在！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
		}else{
			$DB->query("INSERT INTO `auth_site` (`qq`,`url`,`date`,`authcode`,`sign`,`daili`) values ('".$qq."','".trim($val)."','".$date."','".$authcode."','".$sign."','".$userrow['uid']."')");
		}
	}
	exit("<script type='text/javascript'>layer.alert('添加成功！',{icon:6,closeBtn:0},function(){window.location.href='./list.php'});</script>");
}
?>
<div class="container" style="padding-top:70px;">
<div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">

<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">添加授权</h3></div>
<div class="panel-body">

<form action="./addsite.php" method="post" class="form-horizontal" role="form">

<div class="input-group">
<span class="input-group-addon">ＱＱ</span>
<input type="text" name="qq" class="form-control" placeholder="购买授权的QQ"/>
</div><br/>

<div class="input-group">
<span class="input-group-addon">域名</span>
<input type="text" name="url" class="form-control" placeholder="购买授权的域名"/>
</div><br/>

<div class="form-group">
<div class="col-sm-12"><input type="submit" value="确定添加" class="btn btn-primary form-control"/></div>
</div>

</form>
</div>

<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span> 添多个域名请用英文逗号 , 隔开！
</div>
</div>

</div>
</div>