<?php
/**
 * TOP API: tmall.wangwangfenliu.rule.hanoi.create request
 *
 * @author auto create
 * @since  1.0, 2013-04-29 16:46:23
 */
class TmallWangwangfenliuRuleHanoiCreateRequest {

	/**
	 * 汉诺塔的分组ID
	 **/
	private $hanoiGroupId;
	/**
	 * 汉诺塔分组的标签ID
	 **/
	private $hanoiLabelId;
	/**
	 * 优先级为小数格式的字符串
	 **/
	private $priority;
	/**
	 * 服务分组名称
	 **/
	private $serviceGroupName;
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

	public function setPriority($priority) {
		$this->priority             = $priority;
		$this->apiParas["priority"] = $priority;
	}

	public function getPriority() {
		return $this->priority;
	}

	public function setServiceGroupName($serviceGroupName) {
		$this->serviceGroupName               = $serviceGroupName;
		$this->apiParas["service_group_name"] = $serviceGroupName;
	}

	public function getServiceGroupName() {
		return $this->serviceGroupName;
	}

	public function getApiMethodName() {
		return "tmall.wangwangfenliu.rule.hanoi.create";
	}

	public function getApiParas() {
		return $this->apiParas;
	}

	public function check() {

		RequestCheckUtil::checkNotNull($this->hanoiGroupId, "hanoiGroupId");
		RequestCheckUtil::checkNotNull($this->hanoiLabelId, "hanoiLabelId");
		RequestCheckUtil::checkNotNull($this->priority, "priority");
		RequestCheckUtil::checkMaxLength($this->priority, 6, "priority");
		RequestCheckUtil::checkNotNull($this->serviceGroupName, "serviceGroupName");
		RequestCheckUtil::checkMaxLength($this->serviceGroupName, 64, "serviceGroupName");
	}

	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key           = $value;
	}
}
