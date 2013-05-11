<?php

interface items_dao {

	function insert($data);

	function delete($id);

	function delete_all();

	function get_items_rand($fid, $type, $limit = 4);

	function get_items_by_type($fid, $type, $offset, $limit = 4);

	function get_items_count_by_type($fid, $type);

	function get_item($id);

}

