<?php
include("./includes/common.php");

$url=daddslashes($_GET['url']);
$authcode=daddslashes($_GET['authcode']);


if(!$_GET['ver'] && ($url=='localhost' || $url=='127.0.0.1'))exit();

if($_GET['ver']){

	$param=base64_encode(authcode($_GET['ver']."\t".$url."\t".$authcode."\t".(time()+600),'ENCODE','mulin_key'));
	$download=$siteurl.'download.php?update=true&param='.$param.'&rand='.rand(100000,999999);

	if($conf['update']==1) {
		if($_GET['ver']>=$conf['version']){
			$code=0;
			$msg='<font color="green">您使用的已是最新版本！</font><br/>当前版本：'.$conf['ver'].' (Build '.$conf['version'].')';
		} else {
			$code=1;
			$msg='<font color="red">发现新版本！</font> 最新版本：'.$conf['ver'].' (Build '.$conf['version'].')';
		}
	} else {
		$code=0;
		$msg='<font color="blue">更新服务器正在维护，请稍后访问！</font>';
	}
}

if($authcode && checkauth($url,$authcode) || $url=='localhost' || $url=='127.0.0.1'){
	if($_GET['ver'])
		$result=array('code'=>$code,'msg'=>$msg,'uplog'=>$conf['uplog'],'file'=>$download);
	else
		$result=array('code'=>'1','authcode'=>$authcode);
}else{
	$result=array('code'=>'-1','msg'=>$conf['content']);
}

echo json_encode($result);
$DB->close();
?>