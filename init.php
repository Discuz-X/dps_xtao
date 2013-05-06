<?php
!defined('IN_DISCUZ') && exit('Access Denied');
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'Config.php';


//引用文件
require_once 'lib/functions.php';
require_once 'sdk/TopClient.php';
require_once 'sdk/RequestCheckUtil.php';
require_once 'sdk/request/TaobaokeItemsDetailGetRequest.php';

$modarray = array('view');
$mod = !empty($_GET['mod']) ? addslashes($_GET['mod']) : 'index';
$mod = in_array($mod, $modarray) ? $mod : 'index';
$navtitle = !empty($_C['navtitle']) ? $_C['navtitle'] : $_G['setting']['bbname'];
$debug = $_C['is_debug'];
$appkey = !empty($_C['app_key']) ? $_C['app_key'] : showmessage(lang('plugin/abis_shops', 'error_noappkey'));
$appsecret = !empty($_C['app_secret']) ? $_C['app_secret'] : showmessage(lang('plugin/abis_shops', 'error_noappsecret'));
$taokepid = !empty($_C['taoke_pid']) ? $_C['taoke_pid'] : NULL;
$taokeusername = !empty($_C['taoke_username']) ? $_C['taoke_username'] : NULL;

//市场价比率
$price_mod1 = !empty($_C['price_mod1']) ? (float)($_C['price_mod1']) : 1 ;
$price_mod2 = !empty($_C['price_mod2']) ? (float)($_C['price_mod2']) : 1 ;
$price_mod3 = !empty($_C['price_mod3']) ? (float)($_C['price_mod3']) : 1 ;
$price_mod4 = !empty($_C['price_mod4']) ? (float)($_C['price_mod4']) : 1 ;
$price_mod5 = !empty($_C['price_mod5']) ? (float)($_C['price_mod5']) : 1 ;
$price_mod6 = !empty($_C['price_mod6']) ? (float)($_C['price_mod6']) : 1 ;

//广告代码
$headeraddcode = !empty($_C['headeraddcode']) ? $_C['headeraddcode'] : '';
$footeraddcode = !empty($_C['footeraddcode']) ? $_C['footeraddcode'] : '';

?>