<?php
include("../includes/common.php");
$title='搜索授权';
include './head.php';
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

if(isset($_POST['search']) && isset($_POST['type'])){
	exit("<script language='javascript'>window.location.href='./list.php?type=".$_POST['type']."&search=".urlencode(base64_encode($_POST['search']))."&method=".$_POST['method']."';</script>");
}
?>
<div class="container" style="padding-top:70px;">
<div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<div class="panel panel-primary">
<div class="panel-heading text-center"><h3 class="panel-title">搜索授权</h3></div>
<div class="panel-body">
<form action="./search.php" method="post" class="form-inline" role="form">
<div class="form-group">
<label>类别</label>
<select name="type" class="form-control">
<option value="0">全部</option>
<option value="1">ＱＱ</option>
<option value="2">域名</option>
<option value="3">授权码</option>
<option value="4">特征码</option>
</select>
</div>
<div class="form-group">
<label>内容</label>
<input type="text" name="search" value="" class="form-control" autocomplete="off" required/>
</div>
<div class="form-group">
<select name="method" class="form-control">
<option value="0">精确搜索</option>
<option value="1">模糊搜索</option>
</select>
</div>
<input type="submit" value="查询" class="btn btn-primary form-control"/>
</form>
</div>
</div>
</div>
</div>
