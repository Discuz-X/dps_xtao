<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: @lvenle@gmail.com
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$id = $_GET['tkid'];
include dirname(__FILE__).'/lib/items_service.php';

$items_service            = new items_service;
$items_service->items_dao = C::t('#tkb#tkb_items');
$item                     = $items_service->get_item($id);
if($item != NULL) {
	$click_url = $item['click_url'];
	$items_service->redirect($click_url, NULL);
}
exit();

?>