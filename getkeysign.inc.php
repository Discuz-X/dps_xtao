<?php defined('IN_DISCUZ') || die('Access Denied');
//echo $js;
/*
if(IE == 1) {
	$("#jssdk").attr('src', 'http://l.tbcdn.cn/apps/top/x/sdk.js?appkey=21165987');
} else {
	var script = document.createElement("script");
	script.src = 'http://l.tbcdn.cn/apps/top/x/sdk.js?appkey=21165987';
	var tag = $("head").append(script);
}
var hostName = window.location.host;
function no_pay() {
	//alert('您的网站没有授权'+hostName);
	//window.location='http://auth.duoduo123.com';
}
$.ajax({
	url: 'http://auth.duoduo123.com/check.php',
	dataType: 'jsonp',
	jsonp: "callback",
	data: {domain: hostName},
	success: function(data) {
		if(data.s == 0) {
			no_pay();
			JSSDK_TIME = '1375178467000';
			JSSDK_SIGN = '8D63E67441FD63DBD38B32F43CA0F161';
			if(typeof(ddJssdkCallBack) == "function") {
				ddJssdkCallBack();
			}
		} else {
			JSSDK_TIME = '1375178467000';
			JSSDK_SIGN = '8D63E67441FD63DBD38B32F43CA0F161';
			if(typeof(ddJssdkCallBack) == "function") {
				ddJssdkCallBack();
			}
		}
	}
});*/
header('Content-type: text/javascript');

if($_C['api_taobaoke_base']) {
	function dd_hash_hmac($algo, $data, $key, $raw_output = false) {
		if(function_exists('hash_hmac')) {
			return hash_hmac($algo, $data, $key, $raw_output);
		}
		$algo = strtolower($algo);
		if($algo == 'sha1') {
			$pack = 'H40';
		} elseif($algo == 'md5') {
			$pack = 'H32';
		} else {
			return '';
		}
		$size = 64;
		$opad = str_repeat(chr(0x5C), $size);
		$ipad = str_repeat(chr(0x36), $size);
		if(strlen($key) > $size) {
			$key = str_pad(pack($pack, $algo($key)), $size, chr(0x00));
		} else {
			$key = str_pad($key, $size, chr(0x00));
		}
		for($i = 0; $i < strlen($key) - 1; $i++) {
			$opad[$i] = $opad[$i] ^ $key[$i];
			$ipad[$i] = $ipad[$i] ^ $key[$i];
		}
		$output = $algo($opad.pack($pack, $algo($ipad.$data)));
		return ($raw_output) ? pack($pack, $output) : $output;
	}

	$url = 'http://l.tbcdn.cn/apps/top/x/sdk.js?appkey='.$appkey;
	$JSSDK_TIME = $_SERVER['REQUEST_TIME']."000";
	$message    = $appsecret.'app_key'.$appkey.'timestamp'.$JSSDK_TIME.$appsecret;
	$JSSDK_SIGN = strtoupper(dd_hash_hmac("md5", $message, $appsecret));
} else {
	$js = file_get_contents("http://yun.duoduo123.com/view.php?time={$_SERVER['REQUEST_TIME']}");
	preg_match("/script\.src ?= ?(?:\'|\")(.+)(?:\'|\")/", $js, $match);
	//echo 'match:'.$match[0].'<br />'."\n";
	$url = $match[1];
	preg_match('/appkey=(\d+)/i', $match[1], $match);
	$appkey = $match[1];
	preg_match("/JSSDK_TIME ?= ?(?:\'|\")(.+)(?:\'|\")/", $js, $match);
	$JSSDK_TIME = $match[1];
	preg_match("/JSSDK_SIGN ?= ?(?:\'|\")(.+)(?:\'|\")/", $js, $match);
	$JSSDK_SIGN = $match[1];
}


echo <<<SIGN
var url='$url'
, appkey=$appkey
, JSSDK_TIME=$JSSDK_TIME
, JSSDK_SIGN='$JSSDK_SIGN';
ddJssdkCallBack();
SIGN;

/*

*/