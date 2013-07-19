<?php defined('IN_DISCUZ') || die('Access Denied');
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'init.php';
//include dirname(__FILE__).DIRECTORY_SEPARATOR."taobao-sdk".DIRECTORY_SEPARATOR."TopSdk.php";
////实例化TopClient类
$c = new TopClient;
$c->appkey = "test";
$c->secretKey = "test";
include template('dps_xtao:taobaoindex');