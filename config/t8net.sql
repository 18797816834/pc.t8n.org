# Host: 127.0.0.1  (Version 5.5.53)
# Date: 2017-10-25 21:28:48
# Generator: MySQL-Front 5.4  (Build 4.153) - http://www.mysqlfront.de/

/*!40101 SET NAMES utf8 */;

#
# Structure for table "t_admin"
#

DROP TABLE IF EXISTS `t_admin`;
CREATE TABLE `t_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `mobile` varchar(11) NOT NULL DEFAULT '0' COMMENT '手机号码',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(10) NOT NULL DEFAULT '' COMMENT '密码加盐值',
  `update_id` int(11) NOT NULL COMMENT '更新人id',
  `last_update_time` int(10) NOT NULL DEFAULT '0' COMMENT '上次更新时间',
  `active` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否启用=1为启用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "t_admin"
#

INSERT INTO `t_admin` VALUES (1,'云开','18170783931','a60fb8f95f6985bb5d86dd67afde922f','987g',0,0,1,0);

#
# Structure for table "t_res"
#

DROP TABLE IF EXISTS `t_res`;
CREATE TABLE `t_res` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `type` enum('view','add','edit','del','unknow') NOT NULL DEFAULT 'view' COMMENT '类型，用于查看方便',
  `urlcode` varchar(64) NOT NULL DEFAULT '' COMMENT '关联的菜单url，暂时不拆分出去',
  `display_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序值',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `css` varchar(32) NOT NULL DEFAULT '' COMMENT 'css样式',
  `is_menu` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '是否是菜单',
  `domain` enum('t8n') NOT NULL DEFAULT 't8n' COMMENT '所属域',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='授权资源表';

#
# Data for table "t_res"
#

INSERT INTO `t_res` VALUES (1,'信息管理','view','',0,0,'','Y','t8n'),(2,'内容类型','view','info/lst',0,1,'','Y','t8n'),(3,'banner管理','view','banner/lst',0,1,'','Y','t8n'),(4,'留言管理','view','',0,0,'','Y','t8n'),(5,'留言列表','view','comments/lst',0,4,'','Y','t8n');
