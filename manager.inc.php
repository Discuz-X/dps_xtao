<?php (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) && exit('Access Denied');
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: @lvenle@gmail.com
 */
loadcache('plugin');
loadcache('forums');
$type = 0;
global $_G;
$vars   = $_G['cache']['plugin']['tkb'];
$forums = $_G['cache']['forums'];
$groups = (array)unserialize($vars['forums']);
//var_dump($forums);// $groups
$forumscat = array();
foreach($groups as $fid) {
	foreach($forums as $forum) {
		if($forum['fid'] == $fid) {
			$forumscat[] = $forum;
		}
	}
}
$pageNo = isset($_GET['page']) ? $_GET['page'] : 1;
$type   = 0;
if(!empty($_GET['fid'])) {
	$fid = $_GET['fid'];
} else if(count($groups) > 0) {
	$fid = $groups[0];
} else {
	$fid = 0;
}
if($fid > 0) {
	include dirname(__FILE__).'/lib/items_service.php';
	$items_service            = new items_service;
	$items_service->items_dao = C::t('#tkb#tkb_items');
	$offset                   = ($pageNo - 1) * 20;
	$items                    = $items_service->get_items_by_type($fid, 0, $offset, 20);
	$totalcount               = count($items);
}
//echo $return;
$subPage_link = 'admin.php?a=a';
unset($_GET['fields']);
foreach($_GET as $key => $value) {
	$subPage_link = $subPage_link.'&'.$key.'='.$value;
}
//生成提交后用于返回的链接
$back_url = $subPage_link.'&page='.$pageNo;
include template('tkb:manager');
if($totalcount == 0) {
	echo '没有搜索结果';
} else if($totalcount == 20) {
	$totalcount = $items_service->get_items_count_by_type($fid, $type);
	include dirname(__FILE__).'/lib/pages.class.php';
	new SubPages(20, $totalcount, $pageNo, 10, $subPage_link, 2);
}
?>