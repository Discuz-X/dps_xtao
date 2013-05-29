<?php
class LtConfigExpression {

	private $_expression;
	public $autoRetrived;

	public function __construct($string, $autoRetrived = TRUE) {
		$this->_expression  = (string)$string;
		$this->autoRetrived = $autoRetrived;
	}

	public function __toString() {
		return $this->_expression;
	}
}