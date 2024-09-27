<?php
include("../includes/common.php");
$title='授权列表';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="container" style="padding-top:70px;">
<div class="col-md-12 center-block" style="float: none;">
<?php
if($_GET['mod']=="edit"){
	$id=intval($_GET['id']);
	$row=$DB->get_row("SELECT * FROM auth_site where id='{$id}' limit 1");
	if(!$row)exit("<script type='text/javascript'>layer.alert('授权管理平台不存在该域名！',{icon:5,closeBtn:0},function(){window.location.href='./list.php'});</script>");
	
	$rs = $DB->query("SELECT * FROM auth_user WHERE 1");
	$select = "";
	while ($res = $DB->fetch($rs)){
		$select.= "<option value=\"".$res["uid"]."\">UID:".$res["uid"]." 用户名:".$res["user"]."</option>";
	}
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">编辑授权</h3></div>
<div class="panel-body">

<form action="./list.php?mod=edit_n&id=<?=$row['id']?>" method="post" class="form-horizontal" role="form">
<input type="hidden" name="do" value="submit"/>

<div class="input-group">
<span class="input-group-addon">ＱＱ</span>
<input type="text" name="qq" value="<?=$row['qq']?>" class="form-control" />
</div><br/>

<div class="input-group">
<span class="input-group-addon">域名</span>
<input type="text" name="url" value="<?=$row['url']?>" class="form-control" />
</div><br/>

<div class="input-group">
<span class="input-group-addon">ＩＰ</span>
<input type="text" name="ip" value="<?=$row['ip']?>" placeholder="绑定服务器IP,空项自动取" class="form-control" />
</div><br/>

<div class="input-group">
<span class="input-group-addon">代理</span>
<select class="form-control" name="daili" default="<?=$row['daili']?>">
<option value="0">平台站长</option>
<?php echo $select ?>
</select>
</div><br/>

<div class="input-group">
<span class="input-group-addon">授权码</span>
<input type="text" name="authcode" value="<?=$row['authcode']?>" class="form-control" readonly/>
</div><br/>

<div class="input-group">
<span class="input-group-addon">添加时间</span>
<input type="text" name="date" value="<?=$row['date']?>" class="form-control" readonly/>
</div><br/>

<div class="input-group">
<span class="input-group-addon">授权状态</span>
<select name="active" class="form-control">
<?php if($row['active']==1){?>
<option value="1">正常</option><option value="0">封禁</option>
<?php }else{ ?>
<option value="0">封禁</option><option value="1">正常</option>
<?php } ?>
</select>
</div><br/>

<div class="form-group">
<div class="col-sm-12"><input type="submit" value="确定添加" class="btn btn-primary form-control"/></div>
</div>

</form>
<a href="./list.php">>>返回授权列表</a>
</div>
</div>
<?php
}elseif($_GET['mod']=="edit_n"&&$_POST["do"]=="submit"){
	$id=intval($_GET['id']);
	$row=$DB->get_row("SELECT * FROM auth_site where id='{$id}' limit 1");

	if($_POST['url']==$row['url'] || $_POST['url']==""){
		$url=$row['url'];
	}else{
		$url=daddslashes($_POST['url']);
		$rurl=$DB->get_row("SELECT * FROM auth_site where url='{$url}' limit 1");
		if($rurl)exit("<script type='text/javascript'>layer.alert('该域名已存在，无法替换！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	}

	if($_POST['qq']==$row['qq'] || $_POST['qq']==""){
		$qq=$row['qq'];
		$sign=$row['sign'];
		$authcode=$row['authcode'];
	}elseif($_POST['qq']!=$row['qq']){
		$qq=daddslashes($_POST['qq']);
		$row1=$DB->get_row("SELECT * FROM auth_site WHERE qq='{$qq}' limit 1");
		$row2=$DB->get_row("SELECT * FROM auth_site WHERE 1 order by sign desc limit 1");
		if($row1){
			$authcode=$row1['authcode'];
			$sign=$row1['sign'];
		}elseif(!$row1){
			$authcode=md5(random(32).$qq);
			$sign=$row2['sign']+1;
		}
	}

	$ip=daddslashes($_POST['ip']);
	$daili=daddslashes($_POST['daili']);
	$active=daddslashes($_POST['active']);
	if(!$row)exit("<script type='text/javascript'>layer.alert('授权管理平台不存在该域名！',{icon:5,closeBtn:0},function(){history.go(-1)});</script>");
	
	if($DB->query("update auth_site set qq='$qq',url='$url',ip='$ip',authcode='$authcode',sign='$sign',daili='$daili',active='$active' where id='{$id}'"))
		exit("<script type='text/javascript'>layer.alert('修改成功！',{icon:6,closeBtn:0},function(){window.location.href='./list.php'});</script>");
	else
		exit("<script type='text/javascript'>layer.alert('修改失败！".$DB->error()."',{icon:5,closeBtn:0},function(){window.location.href='./list.php'});</script>");
}else{
$pagesize=30;
if (!isset($_GET['page'])){
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}

if(isset($_GET['search'])){
	$sql = " qq='{$_GET['search']}' or url='{$_GET['search']}'";
	$numrows=$DB->count("SELECT count(*) from auth_site WHERE{$sql}");
	$con='包含 <b>'.$_GET['search'].'</b> 的共有 <b>'.$numrows.'</b> 个域名';
}else{
	$numrows=$DB->count("SELECT count(*) from auth_site");
	$sql=" 1";
	$con='系统共有 <b>'.$numrows.'</b> 个域名';
}
?>
<div class="alert alert-info text-center">
<?=$con?><br/>
</div>

<div class="modal fade" align="left" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title" id="myModalLabel">搜索授权</h4>
</div>
<div class="modal-body">
<form action="list.php" method="GET">
<input type="text" class="form-control" name="search" placeholder="请输入域名或QQ"><br/>
<input type="submit" class="btn btn-primary btn-block" value="搜索"></form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
</div>
</div>
</div>
</div>

<a href="javascript:void(0)" data-toggle="modal" data-target="#search" id="search" class="btn btn-primary">搜索</a><br/>&nbsp;

<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>UID</th><th>QQ</th><th>域名</th><th>时间</th><th>状态</th><th style="width: 200px;" class="text-center">操作</th></tr></thead>
<tbody>
<?php
$rs=$DB->query("SELECT * FROM auth_site WHERE{$sql} order by id desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs)){
	if($res['active']==0){
		$active="<span style='color:#FF0000;'>封禁</span>";
	}elseif($res['active']==1){
		$active="<span style='color:#008000;'>正常</span>";
	}
	echo '<tr><td><strong>'.$res['id'].'</strong></td><td>'.$res['qq'].'【<a href="tencent://message/?uin='.$res['qq'].'&amp;Site=qq&amp;Menu=yes"><li class="fa fa-qq sidebar-nav-icon"></li></a>】</td><td>'.$res['url'].'【<a href="http://'.$res['url'].'/" target="_blank"><i class="fa fa-internet-explorer"></i></a>】</td><td>'.$res['date'].'</td><td>'.$active.'</td><td class="text-center"><a href="javascript:void(0)" onclick="layer.alert(\'授权码：'.$res["authcode"].'\')" data-toggle="tooltip"  class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-search"></i></a> <a href="./list.php?mod=edit&id='.$res['id'].'"  class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-pencil"></i></a> <a href="javascript:void(0)" onclick="del('.$res['id'].')" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-remove"></i></a></td></tr>';
}
?>
</tbody>
</table>
</div>
<?php
echo'<center><ul class="pagination">';
$s = ceil($numrows / $pagesize);
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$s;
if ($page>1)
{
echo '<li><a href="list.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="list.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="list.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="list.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul></center>';
#分页
}
?>
</div>
</div>
<script>
function del(id){
	layer.confirm('您是否删除此域名？',{btn:['确定','取消'],closeBtn:0,icon:5},function(){
		var load=layer.load(0,{shade:false});
		$.ajax({
			type:"POST",
			url:"ajax.php?act=del_site",
          	data:{id:id},
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