<?php !defined('IN_DISCUZ') && exit('Access Denied');

global $_G;
//$_G['uid'] == 1 && error_reporting(E_ALL | E_STRICT);//error_reporting(E_ALL ^ E_NOTICE);
$olderrlevel = error_reporting(E_ALL | E_STRICT);

define('IDENTIFIER', basename(dirname(__FILE__))); //统一管理插件标识符
(!defined('IN_ADMINCP') || !IN_ADMINCP) && $_C = $_G['cache']['plugin'][IDENTIFIER]; //读取设置

define('PLUGIN_VERSION', $_G['setting']['plugins']['version'][IDENTIFIER]);
define('PLUGIN_ROOT', dirname(__FILE__));
define('PLUGIN_DIR', str_replace(DISCUZ_ROOT, '', PLUGIN_ROOT));