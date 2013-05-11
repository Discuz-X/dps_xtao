<?php
/**
 *    [淘客宝(tkb.{modulename})] (C)2012-2099 Powered by tkb.
 *    Version: 1.0
 *    Date: 2012-12-28 11:15
 *    Author:lvenle@gmail.com
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_tkb {

	function show_items($fid, $items) {

	}

}

class plugin_tkb_portal extends plugin_tkb {

	function view_article_content() {
		global $_G;
		$vars         = $_G['cache']['plugin']['tkb'];
		$portals      = explode(',', $vars['portalcat']);
		$article      = C::t('portal_article_title')->fetch($_GET['aid']);
		$fid          = $article['catid'];
		$displaycount = empty($vars['displaycountportal']) ? 3 : $vars['displaycountportal'];
		if(in_array($fid, $portals)) {
			require_once dirname(__FILE__).'/lib/items_service.php';
			$items_service            = new items_service;
			$items_service->items_dao = C::t('#tkb#tkb_items');
			$items                    = $items_service->get_items_rand($fid, 1, 2);
			include template("tkb:tkb_thread_show");

			return $return;
		}

		return '';
	}
}

class plugin_tkb_forum extends plugin_tkb {

	function viewthread_postsightmlafter_output() {
		global $_G;
		$vars         = $_G['cache']['plugin']['tkb'];
		$groups       = (array)unserialize($vars['forums']);
		$displaycount = empty($vars['displaycount']) ? 4 : $vars['displaycount'];
		$fid          = $_G['fid'];
		if(in_array($fid, $groups)) {
			require_once dirname(__FILE__).'/lib/items_service.php';
			$items_service            = new items_service;
			$items_service->items_dao = C::t('#tkb#tkb_items');
			$items                    = $items_service->get_items_rand($fid, 0, 2);
			include template("tkb:tkb_thread_show");
			$ret [] = $return;

			return $ret;
		} else {
			return array();
		}

	}
}

?>