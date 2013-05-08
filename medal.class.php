<?php !defined('IN_DISCUZ') && exit('Access Denied');
class medal {

	private $ver;
	private $uid;
	private $__path;
	private $medalpath;

	function __construct($uid, $ver, $path) {
		$this->ver       = $ver;
		$this->uid       = floatval($uid);
		$this->__path    = $path;
		$this->medalpath = $path.'medals.php';
	}

	function addmedal() {
		$medals = $this->loadmedals();
		if($medals == FALSE) {
			return FALSE;
		}
		foreach($medals as $key => $value) {
			$medalstr .= '('.$this->uid.','.$medals[$key].'),';
			$totalmedal .= "\t".$medals[$key];
		}
		if($this->ver != 'X2') {
			$medalstr = rtrim($medalstr, ',');
			$sql      = 'INSERT IGNORE INTO '.DB::table('common_member_medal').' VALUES'.$medalstr;
			DB::query($sql);
		}
		$existmedal = $this->getexistmedal();
		if(!empty($existmedal)) {
			if($existmedal['medals'] == '') {
				$newmedals = ltrim($totalmedal);
			} else {
				$newmedals = $existmedal['medals'].$totalmedal;
				$medalarr  = explode("\t", $newmedals);
				$medalarr  = array_unique($medalarr);
				$newmedals = implode("\t", $medalarr);
			}
			$this->updateexistmedal($newmedals);
		}
	}

	function recyclemedal() { // delete medal
		$medals = $this->loadmedals();
		if($medals == FALSE) {
			return FALSE;
		}
		$existmedal = $this->getexistmedal();
		$omedal     = explode("\t", $existmedal['medals']);
		$tmp_medal  = array_flip($omedal);
		foreach($medals as $key => $value) {
			unset($tmp_medal[$value]);
			if($this->ver != 'X2') {
				DB::delete('common_member_medal', "uid='".$this->uid."' and medalid='".$medals[$key]."'");
			}
		}
		$omedal = implode("\t", array_flip($tmp_medal));
		$this->updateexistmedal($omedal);
	}

	private function loadmedals() {
		if(is_file($this->medalpath)) {
			include $this->medalpath; //return $medals
			return $medals;
		} else {
			return FALSE;
		}
	}

	private function getexistmedal() {
		$sql = 'SELECT medals FROM '.DB::table('common_member_field_forum').' WHERE uid=\''.$this->uid.'\'';

		return DB::fetch_first($sql);
	}

	private function updateexistmedal($medal) {
		DB::update('common_member_field_forum', array('medals' => $medal), 'uid=\''.$this->uid.'\'');
	}
}