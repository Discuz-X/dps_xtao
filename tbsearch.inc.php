<?php defined('IN_DISCUZ') || die('Access Denied');
include 'lib/functions.php';
$keyword = $_GET['keyword'];
header('Location: plugin.php?id=dps_xtao:taobaoindex&sort=commissionNum_desc&keyword='.$keyword);