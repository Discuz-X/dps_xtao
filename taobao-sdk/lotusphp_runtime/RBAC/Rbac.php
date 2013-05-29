<?php
class LtRbac {

	public $configHandle;
	protected $acl;

	public function __construct() {
		if(!$this->configHandle instanceof LtConfig) {
			if(class_exists("LtObjectUtil", FALSE)) {
				$this->configHandle = LtObjectUtil::singleton("LtConfig");
			} else {
				$this->configHandle = new LtConfig;
			}
		}
	}

	public function init() {
		$this->acl = $this->configHandle->get('rbac.acl');
	}

	public function checkAcl($roles, $resource) {
		$allow = FALSE;
		// deny priority
		foreach(array("allow", "deny") as $operation) {
			foreach($roles as $role) {
				if(isset($this->acl[$operation][$role])) {
					// everyone *
					if(in_array($resource, $this->acl[$operation]['*'])) {
						$allow = "allow" == $operation ? TRUE : FALSE;
						break;
					}
					if(in_array($resource, $this->acl[$operation][$role])) {
						$allow = "allow" == $operation ? TRUE : FALSE;
						break;
					} else {
						$res = explode('/', trim($resource, '/'));
						for($i = count($res) - 1; $i >= 0; $i--) {
							$res[$i] = '*';
							$tmp     = implode('/', $res);
							if(in_array($tmp, $this->acl[$operation][$role])) {
								$allow = "allow" == $operation ? TRUE : FALSE;
								break;
							}
							unset($res[$i]);
						}
					}
				}
			}
		}

		return $allow;
	}
	/*
		private function __set($p,$v)
		{
			$this->$p = $v;
		}

		private function __get($p)
		{
			if(isset($this->$p))
			{
				return($this->$p);
			}
			else
			{
				return(NULL);
			}
		}
	*/
}
