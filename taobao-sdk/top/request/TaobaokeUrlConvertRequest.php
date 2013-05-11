<?php
/**
 * TOP API: taobao.taobaoke.url.convert request
 *
 * @author auto create
 * @since  1.0, 2012-09-11 16:34:52
 */
class TaobaokeUrlConvertRequest {

	/**
	 * 需要转化为淘客链接的url
	 **/
	private $url;
	private $apiParas = array();

	public function setUrl($url) {
		$this->url             = $url;
		$this->apiParas["url"] = $url;
	}

	public function getUrl() {
		return $this->url;
	}

	public function getApiMethodName() {
		return "taobao.taobaoke.url.convert";
	}

	public function getApiParas() {
		return $this->apiParas;
	}

	public function check() {

		RequestCheckUtil::checkNotNull($this->url, "url");
	}

	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key           = $value;
	}
}
