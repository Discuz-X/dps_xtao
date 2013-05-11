<?php (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) && exit('Access Denied');

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: @lvenle@gmail.com
 */



$ids = $_GET['id'];
include dirname(__FILE__).'/lib/items_service.php';

$items_service            = new items_service;
$items_service->items_dao = C::t('#tkb#tkb_items');
$count                    = $items_service->delete($ids);

$items_service->redirect($_POST['back_url'], $count > 0 ? '删除成功' : NULL);

?>