<?php
class LtCacheAdapterEAccelerator implements LtCacheAdapter {

	public function connect($hostConf) {
		return TRUE;
	}

	public function add($key, $value, $ttl = 0, $tableName, $connectionResource) {
		$value = serialize($value); //eAccelerator doesn't serialize object
		return eaccelerator_put($this->getRealKey($tableName, $key), $value, $ttl);
	}

	public function del($key, $tableName, $connectionResource) {
		return eaccelerator_rm($this->getRealKey($tableName, $key));
	}

	public function get($key, $tableName, $connectionResource) {
		$value = eaccelerator_get($this->getRealKey($tableName, $key));
		if(!empty($value)) {
			return unserialize($value);
		} else {
			return FALSE;
		}
	}

	public function update($key, $value, $ttl = 0, $tableName, $connectionResource) {
		if($this->del($key, $tableName, $connectionResource)) {
			return $this->add($key, $value, $ttl, $tableName, $connectionResource);
		} else {
			return FALSE;
		}
	}

	protected function getRealKey($tableName, $key) {
		return $tableName."-".$key;
	}
}