<?php
/**
 * TOP API: tmall.wangwangfenliu.hanoigroup.update request
 *
 * @author auto create
 * @since  1.0, 2013-04-29 16:46:23
 */
class TmallWangwangfenliuHanoigroupUpdateRequest {

	/**
	 * 汉诺塔的分组ID
	 **/
	private $hanoiGroupId;
	/**
	 * 汉诺塔分组名称
	 **/
	private $hanoiGroupName;
	/**
	 * 汉诺塔分组的标签ID
	 **/
	private $hanoiLabelId;
	/**
	 * 汉诺塔属性标签
	 **/
	private $hanoiLabelName;
	private $apiParas = array();

	public function setHanoiGroupId($hanoiGroupId) {
		$this->hanoiGroupId               = $hanoiGroupId;
		$this->apiParas["hanoi_group_id"] = $hanoiGroupId;
	}

	public function getHanoiGroupId() {
		return $this->hanoiGroupId;
	}

	public function setHanoiGroupName($hanoiGroupName) {
		$this->hanoiGroupName               = $hanoiGroupName;
		$this->apiParas["hanoi_group_name"] = $hanoiGroupName;
	}

	public function getHanoiGroupName() {
		return $this->hanoiGroupName;
	}

	public function setHanoiLabelId($hanoiLabelId) {
		$this->hanoiLabelId               = $hanoiLabelId;
		$this->apiParas["hanoi_label_id"] = $hanoiLabelId;
	}

	public function getHanoiLabelId() {
		return $this->hanoiLabelId;
	}

	public function setHanoiLabelName($hanoiLabelName) {
		$this->hanoiLabelName               = $hanoiLabelName;
		$this->apiParas["hanoi_label_name"] = $hanoiLabelName;
	}

	public function getHanoiLabelName() {
		return $this->hanoiLabelName;
	}

	public function getApiMethodName() {
		return "tmall.wangwangfenliu.hanoigroup.update";
	}

	public function getApiParas() {
		return $this->apiParas;
	}

	public function check() {

		RequestCheckUtil::checkNotNull($this->hanoiGroupId, "hanoiGroupId");
		RequestCheckUtil::checkNotNull($this->hanoiGroupName, "hanoiGroupName");
		RequestCheckUtil::checkNotNull($this->hanoiLabelId, "hanoiLabelId");
		RequestCheckUtil::checkNotNull($this->hanoiLabelName, "hanoiLabelName");
	}

	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key           = $value;
	}
}
