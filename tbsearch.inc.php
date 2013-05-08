<?php !defined('IN_DISCUZ') && exit('Access Denied');


include 'lib/functions.php';

$keyword = $_GET['keyword'];
header('Location: plugin.php?id=abis_shops:tb_goods_search&sort=commissionNum_desc&keyword='.$keyword);
?>
