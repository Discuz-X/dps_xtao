<?php
!defined('IN_DISCUZ') && exit('Access Denied');

global $_G;
$sql = 'SELECT taobao_name FROM '.DB::table('forum_taobao_user')." WHERE forum_uid ='".$_G['uid']."'";
$rs = DB::fetch_first($sql);
$binded = empty($rs) ? 0 : 1;
$bindedtip=lang('plugin/niuc_baiduconnect', 'nowbinded');
define('IDENTIFIER', basename(dirname(__FILE__)));
?>