<?php defined('IN_DISCUZ') || die('Access Denied');
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'Config.php';

define("TOP_SDK_DEV_MODE", $_C['is_debug']);
spl_autoload_unregister(array('core','autoload'));
include_once dirname(__FILE__).DS.'taobao-sdk'.DS.'TopSdk.php';//引用文件
spl_autoload_register(array('core', 'autoload'));
require_once 'lib/functions.php';

global $TopClient;
$TopClient = new TopClient;
TOP_SDK_DEV_MODE && $c->gatewayUrl = 'http://gw.api.tbsandbox.com/router/rest';
//aiodebug($c->gatewayUrl, 'App URL', $debug);
$TopClient->appkey = TOP_SDK_DEV_MODE ? 'test' : $_C['app_key'];
$TopClient->secretKey = TOP_SDK_DEV_MODE ? 'test' : $_C['app_secret'];
//aiodebug($_C['app_secret'], 'App secret', $debug);
$TopClient->format = 'json';

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
