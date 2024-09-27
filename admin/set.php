<?php
include("../includes/common.php");
$title='系统管理';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

echo'<div class="container" style="padding-top:70px;">
<div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">';

$mod=isset($_GET['mod'])?$_GET["mod"]:NULL;
if($mod=="site_n" && $_POST["do"] == "submit"){
	if($_POST['sitename'] == NULL && $_POST['kfqq'] == NULL){
		exit("<script type='text/javascript'>layer.alert('必填项不能为空！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
    }
	saveSetting('title',$_POST['title']);
	saveSetting('kfqq',$_POST['kfqq']);
	saveSetting('qqjump',$_POST['qqjump']);
	saveSetting('admin_user',$_POST['admin_user']);
	if(!empty($_POST['admin_pass'])){
		saveSetting('admin_pass',md5($_POST['admin_pass']));
	}
	$ad=$CACHE->clear();
	if($ad)
		exit("<script type='text/javascript'>layer.alert('修改成功【网站设置】',{icon:6,closeBtn:0},function(){window.location.href='./set.php?mod=site'});</script>");
	else
		exit("<script type='text/javascript'>layer.alert('修改失败【网站设置】".$DB->error()."',{icon:5,closeBtn:0},function(){window.location.href='./set.php?mod=site'});</script>");
}elseif($mod=="site"){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">网站设置</h3></div>
<div class="panel-body">
<form action="./set.php?mod=site_n" method="post" class="form-horizontal" role="form">
<input type="hidden" name="do" value="submit">

<div class="input-group">
<span class="input-group-addon">网站标题</span>
<input type="text" name="title" class="form-control" value="<?=$conf['title']?>">
</div><br/>

<div class="input-group">
<span class="input-group-addon">站长ＱＱ</span>
<input type="text" name="kfqq" class="form-control" value="<?=$conf['kfqq']?>">
</div><br/>

<div class="input-group">
<span class="input-group-addon">手机QQ打开网站跳转浏览器</span>
<select name="qqjump" class="form-control" default="<?=$conf['qqjump']?>">
<option value="1">开启</option><option value="0">关闭</option>
</select>
</div><hr/>

<div class="input-group">
<span class="input-group-addon">登录账号</span>
<input type="text" name="admin_user" class="form-control" value="<?=$conf['admin_user']?>">
</div><br/>

<div class="input-group">
<span class="input-group-addon">登录密码</span>
<input type="text" name="admin_pass" class="form-control" placeholder="不修改请留空">
</div><br/>

<div class="input-group">
<span class="input-group-addon">快捷登录</span>
<input type="text" name="access_token" class="form-control" value="<?php if(!$conf['access_token']){echo '您未绑定QQ快捷登录！';}else{echo $conf['access_token'];} ?>" disabled>
<?php
if(!$conf['access_token']){
	echo '<a href="./connect.php?binding=true" class="input-group-addon">绑定</a>';
}else{
	echo '<a href="javascript:void(0)" class="input-group-addon" id="jiebang">解绑</a>';
}
?>
</div><br/>

<div class="form-group">
<div class="col-sm-12"><button class="btn btn-primary form-control" type="submit">确认保存</button></div>
</div>

</form>
</div>
</div>
<?php
}elseif($mod=="check_n" && $_POST["do"] == "submit"){
	saveSetting('content',$_POST['content']);
	saveSetting('checkq',$_POST['checkq']);
	saveSetting('switch',$_POST['switch']);
	saveSetting('ipauth',$_POST['ipauth']);
	saveSetting('uplog',$_POST['uplog']);
	saveSetting('update',$_POST['update']);
	saveSetting('ver',$_POST['ver']);
	saveSetting('version',$_POST['version']);
	$ad=$CACHE->clear();
	if($ad)
		exit("<script type='text/javascript'>layer.alert('修改成功【授权设置】',{icon:6,closeBtn:0},function(){window.location.href='./set.php?mod=check'});</script>");
	else
		exit("<script type='text/javascript'>layer.alert('修改失败【授权设置】".$DB->error()."',{icon:5,closeBtn:0},function(){window.location.href='./set.php?mod=check'});</script>");
}elseif($mod=="check"){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">授权设置</h3></div>
<div class="panel-body">
<form action="./set.php?mod=check_n" method="post" class="form-horizontal" role="form">
<input type="hidden" name="do" value="submit">

<div class="input-group">
<span class="input-group-addon">盗版站点信息</span>
<input type="text" name="content" class="form-control" value="<?=$conf['content']?>">
</div><br/>

<div class="input-group">
<span class="input-group-addon">验证域名授权</span>
<select name="checkq" class="form-control" default="<?=$conf['checkq']?>">
<option value="1">开启</option><option value="0">关闭</option>
</select>
</div><br/>

<div class="input-group">
<span class="input-group-addon">验证授权密钥</span>
<select name="switch" class="form-control" default="<?=$conf['switch']?>">
<option value="1">开启</option><option value="0">关闭</option>
</select>
</div><br/>

<div class="input-group">
<span class="input-group-addon">验证网站ＩＰ</span>
<select name="ipauth" class="form-control" default="<?=$conf['ipauth']?>">
<option value="1">开启</option><option value="0">关闭</option>
</select>
</div><br/>

<div class="input-group">
<span class="input-group-addon">更新提示信息</span>
<textarea class="form-control" name="uplog" rows="4"><?php echo htmlspecialchars($conf['uplog']); ?></textarea>
</div><br/>

<div class="input-group">
<span class="input-group-addon">是否开启更新</span>
<select name="update" class="form-control" default="<?=$conf['update']?>">
<option value="1">开启</option><option value="0">关闭</option>
</select>
</div><br/>

<div class="input-group">
<span class="input-group-addon">最新版本序号(显示用)</span>
<input type="text" name="ver" class="form-control" placeholder="比如：V1.01等于1001版本" value="<?=$conf['ver']?>">
</div><br/>

<div class="input-group">
<span class="input-group-addon">最新版本序号(判断用)</span>
<input type="text" name="version" class="form-control" placeholder="比如：1001等于1.0.1版本" value="<?=$conf['version']?>">
</div><br/>

<div class="form-group">
<div class="col-sm-12"><button class="btn btn-primary form-control" type="submit">确认保存</button></div>
</div>

</form>
</div>
</div>
<?php	
}
?>

<script>
$("#jiebang").click(function(){
	layer.confirm('您确定解绑快捷QQ登录！',{btn:['确定','取消'],closeBtn:0,icon:5},function(){
		var load = layer.msg("正在解绑", {icon: 16,time: 0});	
		$.ajax({
			type : "POST",
			url : "ajax.php?act=jiebang",
			dataType : "json",
			success : function(data){
			layer.close(load);
				if(data.code==0){
					layer.msg(data.msg,{icon:1,time:1000,end:function(){window.location.reload()}});
				}else{
					layer.msg(data.msg,{icon:2,time:1000});
				}
			}
		});
	}, function(){});
});
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
$(items[i]).val($(items[i]).attr("default")||0);
}
</script>
</div>
</div>