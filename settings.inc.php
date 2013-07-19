<?php (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) && exit('Access Denied');



loadcache('portalcategory');

global $_G;

$vars           = $_G['cache']['plugin']['tkb'];
$portalcategory = $_G['cache']['portalcategory'];
$portals        = explode(',', $vars['portalcat']);

$portalcat = array();

foreach($portals as $cid) {
	foreach($portalcategory as $cat) {
		if($cat['catid'] == $cid) {
			$portalcat[] = $cat;
		}
	}
}

