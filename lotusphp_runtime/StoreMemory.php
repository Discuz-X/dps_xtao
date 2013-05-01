<?php
class LtStoreMemory implements LtStore {

	protected $stack;

	public function add($key, $value) {
		if(isset($this->stack[$key])) {
			return FALSE;
		} else {
			$this->stack[$key] = $value;

			return TRUE;
		}
	}

	public function del($key) {
		if(isset($this->stack[$key])) {
			unset($this->stack[$key]);

			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get($key) {
		return isset($this->stack[$key]) ? $this->stack[$key] : FALSE;
	}

	/**
	 * key不存在返回false
	 *
	 * @return bool
	 */
	public function update($key, $value) {
		if(!isset($this->stack[$key])) {
			return FALSE;
		} else {
			$this->stack[$key] = $value;

			return TRUE;
		}
	}
}
