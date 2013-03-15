<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 13-3-14
 * Time: 下午11:37
 * To change this template use File | Settings | File Templates.
 */
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_dps_taobao_base {

	function init() {
		global $_G;
		//include_once template('qqconnect:module');
		if(!$_G['cache']['plugin']['dps_taobao']['allow'] || $_G['setting']['bbclosed']) {
			return;
		}
		$this->allow = true;
	}
}

class plugin_dps_taobao extends plugin_dps_taobao_base {
	var $allow = false;

	function plugin_dps_taobao() {
		$this->init();
	}
	function global_login_extra() {
		global $_G;
		if(!$this->allow || $_G['inshowmessage']) {
			return;
		}
		include template('dps_taobao:_tpl_'.__FUNCTION__);
		return $return;
	}
}


?>