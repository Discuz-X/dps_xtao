<?php (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) && exit('Access Denied');

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: @lvenle@gmail.com
 */


$items   = $_POST['item'];
$message = NULL;

if(count($items) > 0) {
	require_once dirname(__FILE__).'/lib/items_service.php';

	$items_service            = new items_service;
	$items_service->items_dao = C::t('#tkb#tkb_items');

	$count = $items_service->insert($items, $_POST['fid'], empty($_POST['type']) ? 0 : $_POST['type']);
	if($count > 0) {
		$message = '保存成功';
	}
}
$items_service->redirect($_POST['back_url'], $message);
?>