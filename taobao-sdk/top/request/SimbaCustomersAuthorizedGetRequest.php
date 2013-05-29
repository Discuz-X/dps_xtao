<?php
/**
 * TOP API: taobao.simba.customers.authorized.get request
 *
 * @author auto create
 * @since  1.0, 2013-05-29 16:35:09
 */
class SimbaCustomersAuthorizedGetRequest {

	private $apiParas = array();

	public function getApiMethodName() {
		return "taobao.simba.customers.authorized.get";
	}

	public function getApiParas() {
		return $this->apiParas;
	}

	public function check() {

	}

	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key           = $value;
	}
}
