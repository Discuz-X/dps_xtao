<?php
/**
 * TOP API: tmall.wangwangfenliu.rule.hanoi.delete request
 *
 * @author auto create
 * @since  1.0, 2013-04-29 16:46:23
 */
class TmallWangwangfenliuRuleHanoiDeleteRequest {

	/**
	 * 汉诺塔的分组ID
	 **/
	private $hanoiGroupId;
	/**
	 * 汉诺塔分组的标签ID
	 **/
	private $hanoiLabelId;
	private $apiParas = array();

	public function setHanoiGroupId($hanoiGroupId) {
		$this->hanoiGroupId               = $hanoiGroupId;
		$this->apiParas["hanoi_group_id"] = $hanoiGroupId;
	}

	public function getHanoiGroupId() {
		return $this->hanoiGroupId;
	}

	public function setHanoiLabelId($hanoiLabelId) {
		$this->hanoiLabelId               = $hanoiLabelId;
		$this->apiParas["hanoi_label_id"] = $hanoiLabelId;
	}

	public function getHanoiLabelId() {
		return $this->hanoiLabelId;
	}

	public function getApiMethodName() {
		return "tmall.wangwangfenliu.rule.hanoi.delete";
	}

	public function getApiParas() {
		return $this->apiParas;
	}

	public function check() {

		RequestCheckUtil::checkNotNull($this->hanoiGroupId, "hanoiGroupId");
		RequestCheckUtil::checkNotNull($this->hanoiLabelId, "hanoiLabelId");
	}

	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key           = $value;
	}
}
