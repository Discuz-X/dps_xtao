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
//var_dump($forumscat);


$pageNo = isset($_GET['page']) ? $_GET['page'] : 1;
if(!empty($_GET['keyword'])) {
	include dirname(__FILE__).'/lib/items_service.php';
	$items_service            = new items_service;
	$items_service->appkey    = $vars['appkey'];
	$items_service->secreckey = $vars['appsecret'];

	$pidarray           = explode('_', $vars['pid']);
	$pid                = count($pidarray) > 1 ? $pidarray[1] : $vars['pid'];
	$items_service->pid = $pid;

	$keyword = $_GET['keyword'];

	$_GET['fields'] = 'num_iid,title,pic_url,price,click_url,commission_volume,commission_rate,commission_num,commission';
	//$pageNo = 1;
	$result = $items_service->search($_GET, $pageNo);


	if(!empty($result)) {
		$totalcount = $result['totalcount'];
		$items      = $result['items'];

	} else {
		echo '没有搜索结果';
	}

}


$subPage_link = 'admin.php?a=a';
unset($_GET['fields']);
foreach($_GET as $key => $value) {
	$subPage_link = $subPage_link.'&'.$key.'='.$value;
}
//生成提交后用于返回的链接
$back_url = $subPage_link.'&page='.$pageNo;


include template('tkb:search');


if($totalcount > 20) {

	include_once dirname(__FILE__).'/lib/pages.class.php';

	new SubPages(20, $totalcount, $pageNo, 10, $subPage_link, 2);
}
?>