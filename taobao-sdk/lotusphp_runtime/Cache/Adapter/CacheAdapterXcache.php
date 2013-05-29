<?php
class LtCacheAdapterXcache implements LtCacheAdapter {

	public function connect($hostConf) {
		return TRUE;
	}

	public function add($key, $value, $ttl = 0, $tableName, $connectionResource) {
		return xcache_set($this->getRealKey($tableName, $key), $value, $ttl);
	}

	public function del($key, $tableName, $connectionResource) {
		return xcache_unset($this->getRealKey($tableName, $key));
	}

	public function get($key, $tableName, $connectionResource) {
		$key = $this->getRealKey($tableName, $key);
		if(xcache_isset($key)) {
			return xcache_get($key);
		}

		return FALSE;
	}

	public function update($key, $value, $ttl = 0, $tableName, $connectionResource) {
		$key = $this->getRealKey($tableName, $key);
		if(xcache_isset($key)) {
			return xcache_set($key, $value, $ttl);
		}

		return FALSE;
	}

	protected function getRealKey($tableName, $key) {
		return $tableName."-".$key;
	}
}
