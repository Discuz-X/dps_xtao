<?php !defined('IN_DISCUZ') && exit('Access Denied');

global $_G;

//$_G['uid'] == 1 && error_reporting(E_ALL ^ E_NOTICE);

define('IDENTIFIER', 'dps_xtao'); //统一管理插件标识符
$_C = $_G['cache']['plugin'][IDENTIFIER]; //读取设置

define('PLUGIN_VERSION', $_G['setting']['plugins']['version'][IDENTIFIER]);
?>