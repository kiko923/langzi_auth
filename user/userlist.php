<?php
include("../includes/common.php");
$title='用户列表';
include './head.php';
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

if($userrow['type']!=1 && $userrow['type']!=2)exit("<script type='text/javascript'>layer.alert('您的账号没有权限使用此功能！',{icon:5,closeBtn:0},function(){window.location.href='./index.php'});</script>");

echo'<div class="container" style="padding-top:70px;">
<div class="col-md-12 center-block" style="float: none;">';

$mod = isset($_GET['mod']) ? $_GET["mod"]:NULL;
if($mod=="add"){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">添加用户</h3></div>
<div class="panel-body">
<form action="./userlist.php?mod=add_n" method="post" class="form-horizontal" role="form">
<input type="hidden" name="do" value="submit"/>

<div class="input-group">
<span class="input-group-addon">用户账号</span>
<input type="text" name="user" placeholder="username" maxlength="11" class="form-control">
</div><br/>

<div class="input-group">
<span class="input-group-addon">用户密码</span>
<input type="text" name="pass" placeholder="password" maxlength="16" class="form-control">
</div><br/>

<div class="input-group">
<span class="input-group-addon">用户ＱＱ</span>
<input type="text" name="qq" placeholder="联系ＱＱ" maxlength="10" class="form-control">
</div><br/>

<div class="input-group">
<span class="input-group-addon">用户权限</span>
<select name="type" class="form-control">
<?php if($userrow['type']==1){ ?>
<option value="2">合作商权限</option><option value="3">授权商权限</option><option value="0">封禁该用户</option>
<?php }elseif($userrow['type']==2){ ?>
<option value="3">授权商权限</option><option value="0">封禁该用户</option>
<?php } ?>
</select>
</div><br/>

<input type="submit" class="btn btn-primary btn-block" value="确定添加">

</form>

<br/><a href="./userlist.php">>>返回用户列表</a>

</div>
</div>
<?php
}elseif($mod=="edit"){
	$id=intval($_GET['id']);
	$row=$DB->get_row("SELECT * FROM auth_user WHERE uid='{$id}' limit 1");
	if(!$row)exit("<script type='text/javascript'>layer.alert('授权管理平台不存在该用户！',{icon:5,closeBtn:0},function(){window.location.href='./userlist.php'});</script>");
	if($row['daili']!=$userrow['uid'])exit("<script type='text/javascript'>layer.alert('此用户不属于您管理！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">编辑用户</h3></div>
<div class="panel-body">
<form action="./userlist.php?mod=edit_n&id=<?php echo $id; ?>" method="post" class="form-horizontal" role="form">
<input type="hidden" name="do" value="submit"/>

<div class="input-group">
<span class="input-group-addon">用户账号</span>
<input type="text" name="user" value="<?php echo $row['user']; ?>" class="form-control">
</div><br/>

<div class="input-group">
<span class="input-group-addon">用户密码</span>
<input type="password" name="pass" placeholder="不修改请留空" class="form-control">
</div><br/>

<div class="input-group">
<span class="input-group-addon">用户ＱＱ</span>
<input type="text" name="qq" value="<?php echo $row['qq']; ?>" class="form-control">
</div><br/>

<div class="input-group">
<span class="input-group-addon">用户权限</span>
<select name="type" class="form-control" default="<?php echo $row['type'] ?>">
<?php if($userrow['type']==1)echo '<option value="2">合作商权限</option>'; ?><option value="3">授权商权限</option><option value="0">封禁该用户</option>
</select>
</div><br/>

<div class="input-group">
<span class="input-group-addon">添加时间</span>
<input type="text" name="addtime" value="<?php echo $row['addtime']; ?>" class="form-control" readonly>
</div><br/>

<input type="submit" class="btn btn-primary btn-block" value="确定修改">

</form>
<br/><a href="./userlist.php">>>返回用户列表</a>
</div>
</div>
<?php
}elseif($mod=="add_n"&&$_POST["do"]=="submit"){
	$user=daddslashes($_POST['user']);
	$pass=daddslashes($_POST['pass']);
	$type=daddslashes($_POST['type']);
	$qq=daddslashes($_POST['qq']);
	$rqq=$DB->get_row("SELECT * FROM auth_user WHERE qq='{$qq}' limit 1");
	$row=$DB->get_row("SELECT * FROM auth_user WHERE user='{$user}' limit 1");
	if($row)exit("<script type='text/javascript'>layer.alert('用户名已存在！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	if($rqq)exit("<script type='text/javascript'>layer.alert('联系QQ已存在！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	if($pass==$user)exit("<script type='text/javascript'>layer.alert('密码不能跟账号一致！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	if(mb_strlen($user) < 6 || mb_strlen($pass) < 6)exit("<script type='text/javascript'>layer.alert('账号密码必须大过6位！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	if(!preg_match('/^[A-Za-z0-9]+$/',$user))exit("<script type='text/javascript'>layer.alert('用户名只能英文数字组合！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	if(!$user || !$pass || !$qq || !$type)exit("<script type='text/javascript'>layer.alert('账号密码重要不能为空！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	
	if($type=="1" && $type!="2" && $type!="3" && $type!="0"){
		exit("<script type='text/javascript'>layer.alert('非法操作，IP已经记录！',{icon:5,closeBtn:0},function(){window.location.href='./index.php'});</script>");
	}elseif($userrow['type']==2 && $type==2){
		exit("<script type='text/javascript'>layer.alert('非法操作，IP已经记录！',{icon:5,closeBtn:0},function(){window.location.href='./index.php'});</script>");
	}
	
	if($type=="0"){
		$type=0;
		$status=0;
	}elseif($type=="2"){
		$type=2;
		$status=1;
	}elseif($type=="3"){
		$type=3;
		$status=1;
	}

	if($DB->query("INSERT INTO `auth_user`(`user`, `pass`, `qq`, `type`, `addtime`, `daili`, `status`) VALUES ('".$user."','".md5($pass)."','".$qq."','".$type."','".$date."','".$userrow['uid']."','".$status."')")){
		exit("<script type='text/javascript'>layer.alert('添加成功！',{icon:6,closeBtn:0},function(){window.location.href='./userlist.php'});</script>");
	}else{
		exit("<script type='text/javascript'>layer.alert('添加失败！".$DB->error()."',{icon:5,closeBtn:0},function(){window.location.href='./userlist.php'});</script>");
	}
}elseif($mod=="edit_n"&&$_POST["do"]=="submit"){
	$id=intval($_GET['id']);
	$row=$DB->get_row("SELECT * FROM auth_user WHERE uid='{$id}' limit 1");
	if(!$row)exit("<script type='text/javascript'>layer.alert('授权管理平台不存在该用户！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	if($row['daili']!=$userrow['uid'])exit("<script type='text/javascript'>layer.alert('此用户不属于您管理！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['qq']) && isset($_POST['type'])){
		$qq=daddslashes($_POST['qq']);
		$user=daddslashes($_POST['user']);
		$type=daddslashes($_POST['type']);
		if($type=="1" && $type!="2" && $type!="3" && $type!="0"){
			exit("<script type='text/javascript'>layer.alert('非法操作，IP已经记录！',{icon:5,closeBtn:0},function(){window.location.href='./index.php'});</script>");
		}elseif($userrow['type']==2 && $type==2){
			exit("<script type='text/javascript'>layer.alert('非法操作，IP已经记录！',{icon:5,closeBtn:0},function(){window.location.href='./index.php'});</script>");
		}
		if($user==$row['user'] || $_POST['user']==""){
			$user=$row['user'];
		}else{
			$user=daddslashes($_POST['user']);
			$rus=$DB->get_row("SELECT * FROM auth_user where user='{$user}' limit 1");
			if($rus)exit("<script type='text/javascript'>layer.alert('用户名已存在，无法修改！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
			if(mb_strlen($user) < 6)exit("<script type='text/javascript'>layer.alert('用户名必须大过6位！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
			if(!preg_match('/^[A-Za-z0-9]+$/',$user))exit("<script type='text/javascript'>layer.alert('用户名只能英文数字组合！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
		}
		if($qq==$row['qq'] || $_POST['qq']==""){
			$qq=$row['qq'];
		}else{
			$qq=daddslashes($_POST['qq']);
			$rqq=$DB->get_row("SELECT * FROM auth_user where qq='{$qq}' limit 1");
			if($rqq)exit("<script type='text/javascript'>layer.alert('此ＱＱ已存在，无法修改！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
		}
		
		if($type=="0"){
			$type=0;
			$status=0;
		}elseif($type=="2"){
			$type=2;
			$status=1;
		}elseif($type=="3"){
			$type=3;
			$status=1;
		}
		if(empty($_POST['pass'])){
			$pass=$row["pass"];
		}else{
			$pass=daddslashes($_POST["pass"]);
			if(mb_strlen($pass) < 6)exit("<script type='text/javascript'>layer.alert('密码必须大过6位！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
			if($pass==$user)exit("<script type='text/javascript'>layer.alert('密码不能跟账号一致！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
			$pass=md5($pass);
		}
		if($DB->query("update auth_user set user='{$user}',pass='{$pass}',qq='{$qq}',type='{$type}',status='{$status}' where uid='{$id}'")){
			exit("<script type='text/javascript'>layer.alert('修改成功',{icon:6,closeBtn:0},function(){window.location.href='./userlist.php'});</script>");
		}else{
			exit("<script type='text/javascript'>layer.alert('修改失败".$DB->error()."',{icon:5,closeBtn:0},function(){window.location.href='./userlist.php'});</script>");
		}
	}
}else{
	if($mod=='search'){
		if($_GET['type']=='user'){
			$sql=" `user`='{$_GET['value']}'";
		}elseif($_GET['type']=='word'){
			$sql=" `user` LIKE '%{$_GET['value']}%'";
		}else{
			$sql=" `{$_GET['type']}`='{$_GET['value']}'";
		}
		$numrows=$DB->count("SELECT count(*) from auth_user WHERE{$sql} and daili='{$userrow['uid']}'");
		$con='包含 <b>'.$_GET['value'].'</b> 的共有 <b>'.$numrows.'</b> 个用户';
		$link='&mod=search&type='.$_GET['type'].'&value='.$_GET['value'];
	}elseif($_GET['type']){
		if($_GET['type']==2){
			$mulin_type="合作商权限";
		}elseif($_GET['type']==3){
			$mulin_type="授权商权限";
		}
		$sql=" `type`='".$_GET['type']."'";
		$numrows=$DB->count("SELECT count(*) from auth_user WHERE{$sql} and daili='{$userrow['uid']}'");
		$con='包含 <b>'.$mulin_type.'</b> 的共有 <b>'.$numrows.'</b> 个用户';
		$link='&type='.$_GET['type'];
	}else{
		$numrows=$DB->count("SELECT count(*) from auth_user WHERE daili='{$userrow['uid']}'");
		$sql=" 1";
		$con='系统共有 <b>'.$numrows.'</b> 个用户';
	}
?>
<div class="alert alert-info text-center">
<?=$con?>
</div>

<div class="modal fade" align="left" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title" id="myModalLabel">搜索用户</h4>
</div>
<div class="modal-body">
<form action="./userlist.php" method="GET">
<input type="hidden" class="form-control" name="mod" value="search">
<select name="type" class="form-control"><option value="user">用户账号</option><option value="qq">用户ＱＱ</option><option value="word">账号字词</option></select><br />

<div class="form-group">
<input type="text" class="form-control" name="value" placeholder="搜索内容">
</div>
<input type="submit" class="btn btn-primary btn-block" value="搜索"></form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
</div>
</div>
</div>
</div>

<div class="modal fade" align="left" id="typesearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title" id="myModalLabel">类型搜索</h4>
</div>
<div class="modal-body">
<form action="./userlist.php" method="GET">
<select name="type" class="form-control"><option value="2">合作商权限</option><option value="3">授权商权限</option></select><br />
<input type="submit" class="btn btn-primary btn-block" value="搜索"></form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
</div>
</div>
</div>
</div>

<a href="./userlist.php?mod=add" class="btn btn-primary">添加用户</a>&nbsp;
<a href="javascript:void(0)" data-toggle="modal" data-target="#search" id="search" class="btn btn-success">搜索用户</a>&nbsp;
<a href="javascript:void(0)" data-toggle="modal" data-target="#typesearch" id="typesearch" class="btn btn-warning">类型搜索</a><br/>&nbsp;

<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>UID</th><th>用户名</th><th>用户QQ</th><th>上次登录</th><th>用户权限</th><th>状态</th><th style="width: 200px;" class="text-center">操作</th></tr></thead>
<tbody>
<?php
$pagesize=30;
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}

$rs=$DB->query("SELECT * FROM auth_user WHERE{$sql} and daili='{$userrow['uid']}' order by uid desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs)){
	if($res['status']==0){
		$status="<span style='color:#FF0000;'>封禁</span>";
	}elseif($res['status']==1){
		$status="<span style='color:#008000;'>正常</span>";
	}
	if($res['logintime']==NULL){
		$logintime="从未登录过";
	}else{
		$logintime=$res['logintime'];
	}
	if($res['type']==1){
		$type="<span style='color:#FF8C00;'>超级管理员</span>";
	}elseif($res['type']==2){
		$type="<span style='color:#DC143C;'>合作商权限</span>";
	}elseif($res['type']==3){
		$type="<span style='color:#008000;'>授权商权限</span>";
	}
	echo '<tr><td><b>'.$res['uid'].'</b></td><td>'.$res['user'].'</td><td>'.$res['qq'].'【<a href="tencent://message/?uin='.$res['qq'].'&amp;Site=qq&amp;Menu=yes"><li class="fa fa-qq sidebar-nav-icon"></li></a>】</td><td>'.$logintime.'</td><td>'.$type.'</td><td>'.$status.'</td><td class="text-center"><a href="./userlist.php?mod=edit&id='.$res['uid'].'" data-toggle="tooltip" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-pencil"></i></a> <a href="javascript:void(0)" onclick="del('.$res['uid'].')" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-remove"></i></a></td></tr>
';
}
?>
</tbody>
</table>
</div>
<center>
<?php
echo'<ul class="pagination">';
$s = ceil($numrows / $pagesize);
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$s;
if($page>1){
echo '<li><a href="userlist.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="userlist.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="userlist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="userlist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="userlist.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="userlist.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
</center>
<?php } ?>
</div>
</div>
<script>
function del(uid){
	layer.confirm('您是否删除此用户？',{btn:['确定','取消'],closeBtn:0,icon:5},function(){
		var load=layer.load(0,{shade:false});
		$.ajax({
			type:"POST",
			url:"ajax.php?act=del_user",
          	data:{uid:uid},
			dataType:'json',
			success:function(data){
				layer.close(load);
				if(data.code==0){
                    layer.msg(data.msg,{icon:1,time:1000,end:function(){window.location.reload()}});
				}else{
					layer.msg(data.msg,{icon:2,time:1000});
				}
			}
		});
	},function(){});
};

var items = $("select[default]");
for(i = 0; i < items.length; i++){
	$(items[i]).val($(items[i]).attr("default")||0);
}
</script>