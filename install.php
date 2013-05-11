<?php
/**
 *	[DPS!淘宝数据接入管理(dps_xtao.install)] (C)2013-2099 Powered by Discuz! Perfect Sense.
 *	Version: 0.01
 *	Date: 2013-4-30 04:20 PM
 */

(!defined('IN_DISCUZ')|| !defined('IN_ADMINCP')) && exit('Access Denied');

$table = DB::table('forum_taobao_user');
$sql = <<<EOF
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `{$table}` (
  `userid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `forum_uid` mediumint(9) NOT NULL,
  `taobao_uid` bigint(20) NOT NULL,
  `taobao_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `pre_forum_taobao_user`
--
DROP TABLE IF EXISTS cdb_tkb_items;
CREATE TABLE cdb_tkb_items (
  `id` int(10) auto_increment NOT NULL,
  `fid` int(10)  NOT NULL,
  `type` int(10)  NOT NULL default 0,
  `num_iid` int(10)  NOT NULL,
  `like_count` int(10)  NOT NULL,
  `commission_num` int(10)  NOT NULL,
  `commission` double  NOT NULL,
  `commission_rate` double  NOT NULL,
  `commission_volume` int(10)  NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` double NOT NULL DEFAULT '0.0',
  `pic_url` varchar(255) NOT NULL,
  `click_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY  fid (`fid`),
  KEY `tname` (`title`)
);

EOF;

runquery($sql);
$finish = true;
?>