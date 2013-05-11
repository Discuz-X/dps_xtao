<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_myrepeats.php 31511 2012-09-04 07:10:47Z monkey $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/../lib/items_dao.php';

class table_tkb_items extends discuz_table implements items_dao {

	public function __construct() {

		$this->_table = 'tkb_items';
		$this->_pk    = 'id';

		parent::__construct();
	}

	/* function insert($data){
		return $this->insert($data);
	}
	
	function delete($id){
		return $this->delete($id);
	} */

	function get_item($id) {
		return $this->fetch($id);
	}

	function get_items_rand($fid, $type, $limit = 4) {
		return DB::fetch_all("SELECT * FROM %t WHERE fid=%d and type=%d order by  rand() limit %d ", array($this->_table, $fid, $type, $limit));
	}

	function get_items_by_type($fid, $type = 0, $offset, $limit = 4) {
		return DB::fetch_all("SELECT * FROM %t WHERE fid=%d and type=%d order by id desc limit %d,%d ", array($this->_table, $fid, $type, $offset, $limit));
	}

	function get_items_count_by_type($fid, $type) {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE fid=%d and type=%d ", array($this->_table, $fid, $type));
	}

	function delete_all() {
		return DB::result_first("delete  from %t ", array($this->_table));
	}


}

?>