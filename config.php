<?php
/*数据库配置*/
$dbconfig=array(
	'host' => 'localhost', //数据库服务器
	'port' => 3306, //数据库端口
	'user' => '', //数据库用户名
	'pwd' => '', //数据库密码
	'dbname' => '', //数据库名
);

/*目录配置*/
define('CACHE_DIR','includes/cache'); //下载缓存目录
define('PACKAGE_DIR','includes/download'); //程序安装包目录
define('PACKAGE_SUFFIX','UuDto'); //下载目录后缀
?>