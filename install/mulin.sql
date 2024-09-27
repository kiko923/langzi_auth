DROP TABLE IF EXISTS `auth_block`;
CREATE TABLE `auth_block` (
  `url` varchar(150) NOT NULL COMMENT '盗版站点地址',
  `user` varchar(255) NOT NULL COMMENT '数据库用户名',
  `pwd` varchar(255) NOT NULL COMMENT '数据库密码',
  `db` varchar(255) NOT NULL COMMENT '数据库库名',
  `date` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_config`;
create table `auth_config` (
`k` varchar(32) NOT NULL,
`v` text NULL,
PRIMARY KEY  (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_down`;
CREATE TABLE `auth_down` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL,
  `authcode` varchar(100) DEFAULT NULL,
  `sign` varchar(100) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_log`;
CREATE TABLE `auth_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(11) DEFAULT NULL,
  `type` varchar(4) DEFAULT NULL,
  `date` datetime NOT NULL,
  `city` varchar(20) DEFAULT NULL,
  `data` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_site`;
CREATE TABLE `auth_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qq` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `authcode` varchar(100) DEFAULT NULL,
  `sign` varchar(20) DEFAULT NULL,
  `daili` int(11) NOT NULL DEFAULT '1',
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE `auth_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(11) NOT NULL COMMENT '用户账号',
  `pass` varchar(32) NOT NULL COMMENT '用户密码',
  `qq` varchar(20) DEFAULT NULL COMMENT '联系QQ',
  `type` int(1) DEFAULT NULL COMMENT '用户权限',
  `logintime` datetime DEFAULT NULL COMMENT '登录时间',
  `addtime` datetime DEFAULT NULL COMMENT '注册时间',
  `daili` int(11) NOT NULL DEFAULT '1' COMMENT '代理UID',
  `clientip` varchar(255) DEFAULT NULL COMMENT '绑定登录IP',
  `token` text NOT NULL COMMENT 'QQ快捷登录绑定',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY  (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;