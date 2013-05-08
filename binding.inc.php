<?php !defined('IN_DISCUZ') && exit('Access Denied');
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'Config.php';

$sql = 'SELECT taobao_name FROM '.DB::table('forum_taobao_user')." WHERE forum_uid ='".$_G['uid']."'";
$rs = DB::fetch_first($sql);
$binded = empty($rs) ? 0 : 1;
$bindedtip=lang('plugin/'.IDENTIFIER, 'binded_user');
?>