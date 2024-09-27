<?php
include("../includes/common.php");
$title='系统日志';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$mod = isset($_GET['mod']) ? $_GET["mod"]:NULL;

if($mod=='search'){
	$sql=" `{$_GET['type']}`='{$_GET['value']}'";
	$numrows=$DB->count("SELECT count(*) from auth_log WHERE{$sql}");
	$con='包含 <b>'.$_GET['value'].'</b> 的共有 <b>'.$numrows.'</b> 个用户';
	$link='&mod=search&type='.$_GET['type'].'&value='.$_GET['value'];
}else{
	$numrows=$DB->count("SELECT count(*) from auth_log");
	$sql=" 1";
	$con='系统共有 <b>'.$numrows.'</b> 条日志';
}

$pagesize=10;
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}
?>
<div class="container" style="padding-top:70px;">
<div class="col-md-10 center-block" style="float: none;">

<div class="modal fade" align="left" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title" id="myModalLabel">搜索日志</h4>
</div>
<div class="modal-body">
<form action="./log.php" method="GET">
<input type="hidden" class="form-control" name="mod" value="search">

<select name="type" class="form-control"><option value="user">操作用户</option><option value="type">操作类型</option><option value="data">操作数据</option></select><br />
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

<div class="alert alert-info text-center">
<?=$con?><br/>
</div>

<a href="javascript:void(0)" data-toggle="modal" data-target="#search" id="search" class="btn btn-primary">搜索日志</a><br/>&nbsp;

<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>账号</th><th>类型</th><th>时间</th><th>城市</th><th>详细</th></tr></thead>
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

$rs=$DB->query("SELECT * FROM auth_log WHERE{$sql} order by date desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
echo '<tr><td><b>'.$res['user'].'</b></td><td>'.$res['type'].'</td><td>'.$res['date'].'</td><td>'.$res['city'].'</td><td>'.substr($res['data'],0,20).'</td></tr>';
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
if ($page>1)
{
echo '<li><a href="log.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="log.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="log.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="log.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="log.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="log.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
</center>

</div>
</div>