<?php
//显示内容,作调试用的
function show($string) {
	echo $comment." : <br/>";
	var_dump($string);
	echo "<br/><hr/><br/>";

}


function aiodebug($string, $comment, $debug) {
	if($debug) {
		echo $comment." : <br/>";
		var_dump($string);
		echo "<br/><hr/><br/>";
	}
}
class Convert {

	public $convert;
	public $localcode;

	public function disp($object) {
		if(is_array($object) || is_object($object)) {
			foreach($object as $key => $item) {
				$result[$key] = $this->conv($item, 'UTF-8', $this->localcode);
			}
		} else {
			$result = $this->conv($object, 'UTF-8', $this->localcode);
		}

		return $result;
	}

	public function req($object) {
		if(is_array($object) || is_object($object)) {
			foreach($object as $key => $item) {
				$result[$key] = $this->conv($item, $this->localcode, 'UTF-8');
			}
		} else {
			$result = $this->conv($object, $this->localcode, 'UTF-8');
		}

		return $result;
	}

	private function conv($string, $from, $to) {
		if($this->convert) {
			if(function_exists('mb_convert_encoding')) {
				$string = mb_convert_encoding($string, $to, $from);
			} else {
				$string = iconv($from, $to, $string);
			}
		}

		return $string;
	}

}

?>
