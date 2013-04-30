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
  `forumuid` mediumint(9) NOT NULL,
  `taobaouid` bigint(20) NOT NULL,
  `taobaoname` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `pre_forum_taobao_user`
--
EOF;

runquery($sql);
$finish = true;
?>