<?php
!defined('IN_DISCUZ') && exit('Access Denied');
error_reporting(E_ALL ^ E_NOTICE);

global $_G;

define('IDENTIFIER', basename(dirname(__FILE__))); //统一管理插件标识符
$config = $_G['cache']['plugin'][IDENTIFIER]; //读取设置

//未开启淘宝登录
!$config['allow'] && exit('disabled');
/*
$referer = dreferer();
$__path  = str_replace('\\', '/', dirname(__FILE__)).'/';
if($op == '' && $code == '' && $_GET['error'] == '') {
	$op = 'init';
} elseif($_GET['error'] != '') {
	header('Location: '.getcookie('xtao_refer'));
	exit;
}*/

//服務器函數環境檢查，否則拋出異常
!function_exists('curl_init') && showmessage(lang('plugin/'.IDENTIFIER, 'function_curl_not_exist'));
!function_exists('json_decode') && showmessage(lang('plugin/'.IDENTIFIER, 'function_json_decode_not_exist'));

define('HACKTOR_PRE', 'taobao_');

$op = empty($_GET['op']) ? 'redirect' : $_GET['op'];
isset($_GET['code']) && !empty($_GET['code']) && $op = 'login';

$redirect_uri = $_G['siteurl'].'plugin.php?id='.IDENTIFIER.':oath2';

if($op == 'init') {
	if(!$config['app_key'] || !$config['app_secret']) {
		showmessage(lang('plugin/'.IDENTIFIER, 'not_configed'));
		exit;
	}

	header('Location: https://oauth.taobao.com/authorize?response_type=code&client_id='.$config['app_key'].'&redirect_uri='.$redirect_uri);
	exit;
	$tmp = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
	dsetcookie('xtao_refer', '');
	if(strpos($tmp, 'mod=register') === FALSE && strpos($tmp, 'mod=logging') === FALSE) {
		dsetcookie('xtao_refer', $_SERVER['HTTP_REFERER']);
	}
	header('Location: https://openapi.baidu.com/oauth/2.0/authorize?response_type=code&client_id='.$apikey.'&redirect_uri='.$redirecturi.'&scope=super_msg&display=page');
} elseif($op == 'login') {
	$token               = array();
	$token['url']        = 'https://oauth.taobao.com/token';
	$token['postfields'] = array(
		'response_type' => 'token',
		'grant_type'    => 'authorization_code',
		'client_id'     => $config['app_key'],
		'client_secret' => $config['app_secret'],
		'code'          => $_GET['code'],
		'redirect_uri'  => $redirect_uri
	);

	//POST请求函数
	function curl_http_request($url, $postFields = NULL) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_REFERER, $_G['siteurl']);

		if(is_array($postFields) && 0 < count($postFields)) {
			$postBodyString = "";
			foreach($postFields as $k => $v) {
				$postBodyString .= "$k=".urlencode($v)."&";
			}
			unset($k, $v);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
		}
		$reponse = curl_exec($ch);
		if(curl_errno($ch)) {
			throw new Exception(curl_error($ch), 0);
		} else {
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if(200 !== $httpStatusCode) {
				throw new Exception($reponse, $httpStatusCode);
			}
		}
		curl_close($ch);

		return $reponse;
	}


	try {
		$token['respond_array'] = (array)json_decode(curl_http_request($token['url'], $token['postfields']), TRUE);
		//$_G['hacktor_taobao'] = $token;
		if(!$token['respond_array']['access_token']) {
			define('VERSION', $_G['setting']['plugins']['version'][IDENTIFIER]);
			if($result == '') {
				showmessage(lang('plugin/'.IDENTIFIER, 'function_curl_not_exist'));
			} else {
				switch($token['respond_array']['error']) {
					case 'invalid_grant':
					case 'invalid_request':
					case 'invalid_client':
						$langname = $token['respond_array']['error'];
						break;
					default:
						$langname = 'failed_get_access_token';
				}
				showmessage(
					lang('plugin/'.IDENTIFIER, $langname).
						'<br />error: '.$token['respond_array']['error'].
						'<br />error discription: '.
						$token['respond_array']['error_description'].
						'<br />version: '.VERSION
				);
			}
		}
		dsetcookie('token', serialize($token['respond_array']));
		//header('Location: '.$redirect_uri.'&op=main');
	} catch(Exception $exc) {
		$error = json_decode($exc->getMessage());
		showmessage($error->error_description, $redirect_uri.'&op=redirect');
	}


	/*
		//get baidu user info
		$url = 'https://openapi.baidu.com/rest/2.0/passport/users/getInfo?access_token='.$token.'&format=json';
		if(function_exists('curl_init')) {
			$r = niuc_curl($url);
		} else {
			$r = file_get_contents($url);
		}
		$baiduser = (array)json_decode($r);*/
	//failed get baidu user info
	intval($token['respond_array']['taobao_user_id']) == 0 && showmessage(lang('plugin/'.IDENTIFIER, 'failed_get_taobao_user_id'));
	if(!$token['respond_array']['error_code']) {
		//binded or not?
		$token['respond_array']['taobao_user_nick'] = iconv('utf-8', $_G['charset'], $token['respond_array']['taobao_user_nick']);
		//$baiduser['username']   = iconv('utf-8', $_G['charset'], $baiduser['username']);
		$sql = 'SELECT forum_uid FROM '.DB::table('forum_taobao_user')." WHERE taobao_uid='".$token['respond_array']['taobao_user_id']."'";
		$rs  = DB::fetch_first($sql);
		//exit(var_dump($rs));
		if(!empty($rs)) { // binded baiduuser,now login
			if($_G['uid'] && $_G['uid'] != $rs['forum_uid']) {
				showmessage(lang('plugin/'.IDENTIFIER, 'chnbaiduuserbeforebind'));
			} else {
				$niuc_uinfo = array('uid' => $rs['forum_uid']);
				niuc_login($niuc_uinfo, getcookie('xtao_refer'));
			}
		} else { //not binded baiduuser,now bind
			if($_G['uid']) { //bind loginned forum user?
				$sql     = 'SELECT forum_uid FROM '.DB::table('forum_taobao_user')." WHERE forum_uid='".$_G['uid']."'"; //exam loginned forum user binded or not
				$examuid = DB::fetch_first($sql);
				if(empty($examuid)) { //loginned forum user not binded
					$bind_u_info = array('forum_uid' => $_G['uid'], 'taobao_uid' => $token['respond_array']['taobao_user_id'], 'taobao_name' => $token['respond_array']['taobao_user_nick']);
					$rtn         = addbindinfo($bind_u_info);
					if($rtn) {
						showmessage(
							lang('plugin/'.IDENTIFIER, 'bind_success')
								.lang('plugin/'.IDENTIFIER, 'taobao_user').'： '
								.$token['respond_array']['taobao_user_nick'],
							getcookie('xtao_refer'),
							array(),
							array('timeout' => '1', 'alert' => 'right')
						);
					} else {
						showmessage(lang('plugin/'.IDENTIFIER, 'bindfailure').lang('plugin/'.IDENTIFIER, 'fatalerror'));
					}
				} else {
					//loginned forum user has binned baidu,and loginned baiduuser not binned
					showmessage(lang('plugin/'.IDENTIFIER, 'logoutbeforebaidulogin').'<br />'.lang('plugin/'.IDENTIFIER, 'baiduuser').$token['respond_array']['taobao_user_nick']);
				}
			} else { //show bind template
				$referer = getcookie('xtao_refer');
				include template(IDENTIFIER.':xtao_login');
				exit;
			}
		}
	} else { //get baiduuser failured
		switch($baiduser['error_code']) {
			case '110':
				header('Location: plugin.php?id=niuc_baiduconnect:connect&op=init');
				break;
			case '6':
				header('Location: '.getcookie('xtao_refer'));
				break;
			case '100':
				showmessage(lang('plugin/'.IDENTIFIER, 'Invalid_parameter').'<br>errcode:100<br>errmsg:'.$baiduser['error_msg']);
			default:
				showmessage('errcode:'.$baiduser['error_code'].'<br>errmsg:'.$baiduser['error_msg'].'<br>version:'.VERSION.'<br>please read this: http://code.niuc.org/thread-3638-1-1.html, or contact QQ group:278119776');
		}
	}
} elseif($op == 'bind') {
	//bind

	function is_unsafe() { //safe exam
		foreach($_POST as $key => $value) {
			if(dps_safe($_POST[$key]) == 'dps_Forbidden') {
				return 1; //unsafe
			}
		}

		return 0;
	}

	function dps_safe($string) {
		$pattern = "/select|insert|update|delete|drop|alter|truncate|union|\%|\'|\"|\\\|char\(/i";
		preg_match($pattern, $string, $matches);

		return count($matches) > 0 ? 'dps_Forbidden' : $string;
	}

	include template('common/header_ajax');

	if(is_unsafe()) {
		echo '-1'; //unsafe e.g. ' " \ % union select...
	} else {
		$_POST['taobao_user_id']   = addslashes($_POST['taobao_user_id']);
		$_POST['taobao_user_nick'] = addslashes($_POST['taobao_user_nick']);

		$_POST['dps_username'] = addslashes(trim($_POST['dps_username']));
		$_POST['dps_password'] = addslashes(trim($_POST['dps_password']));

		if($_POST['user_exist'] == '1') {
			if(function_exists('fetch_uid_by_username')) {
				$uidfromun = C::t('common_member')->fetch_uid_by_username($_POST['dps_username']);
			} else {
				$uidfromun = niuc_fetch_uid_by_username($_POST['dps_username']);
			}
			$sql = 'SELECT forum_uid FROM '.DB::table('forum_taobao_user')." WHERE taobao_uid='".$_POST['taobao_user_id']."' or forum_uid='$uidfromun'";
			$rs  = DB::fetch_first($sql);
			if(!empty($rs)) {
				echo '3'; //binded yet
			} else {
				//not binded, bind existing forum user
				//get salt
				$sql  = 'SELECT salt FROM '.DB::table('ucenter_members')." WHERE username='".$_POST['dps_username']."'";
				$rs   = DB::fetch_first($sql);
				$salt = $rs['salt'];
				if(!empty($rs)) { //salt found
					$sql = 'SELECT uid,password FROM '.DB::table('ucenter_members')." WHERE username='".$_POST['dps_username']."'"; //verify password?
					$rs  = DB::fetch_first($sql);
					if(md5(md5($_POST['dps_password']).$salt) == $rs['password']) {
						//true password,begin bind
						$bind_u_info = array('forum_uid' => $rs['uid'], 'taobao_uid' => $_POST['taobao_user_id'], 'taobao_name' => $_POST['taobao_user_nick']);
						$insertid    = addbindinfo($bind_u_info); //bind info insert database
						if($insertid) {
							$niuc_uinfo = array('uid' => $rs['uid']);
							connect_login($niuc_uinfo); //login
							manageaftlogin($niuc_uinfo); //login extra
							echo '0'; // OK
						} else {
							echo '4'; //fatal error
						}
					} else {
						echo '2'; //wrong password
					}
				} else {
					echo '1'; //salt not found
				}
			}
		} elseif($_POST['user_exist'] == '0') {
			//$newrepassword          = trim($_POST['niuc_repassword']);
			$_POST['dps_email'] = strtolower(addslashes(trim($_POST['dps_email'])));
			if($newpassword != $newrepassword || $newpassword == '') {
				echo '17';
			} else {
				if(niuc_fetch_uid_by_username($newusername)) {
					echo '11'; //username_duplicate
				} else {
					loaducenter();
					$uid = uc_user_register($newusername, $newpassword, $newemail);
					if($uid <= 0) {
						if($uid == -1) {
							echo '12';
						} elseif($uid == -2) {
							echo '13';
						} elseif($uid == -3) {
							echo '11';
						} elseif($uid == -4) {
							echo '14';
						} elseif($uid == -5) {
							echo '15';
						} elseif($uid == -6) {
							echo '16';
						}
					} else {
						exit('pause here');
						$sql        = "SELECT * FROM ".DB::table('common_usergroup').' WHERE groupid=\''.$_G['cache']['plugin']['niuc_baiduconnect']['baiduugroup'].'\'';
						$group      = DB::fetch_first($sql);
						$newadminid = in_array($group['radminid'], array(1, 2, 3)) ? $group['radminid'] : ($group['type'] == 'special' ? -1 : 0);
						loadcache('fields_register');
						$init_arr = explode(',', $_G['setting']['initcredits']);
						$password = md5(random(10));
						addmember($uid, $newusername, $password, $newemail, $_SERVER['REMOTE_ADDR'], $_G['cache']['plugin']['niuc_baiduconnect']['baiduugroup'], array('credits' => $init_arr), $newadminid);
						if($_G['cache']['plugin']['niuc_baiduconnect']['baiducredit']) {
							$credit_style = $_G['cache']['plugin']['niuc_baiduconnect']['baiducredit'];
							$sql          = 'SELECT extcredits'.$credit_style.' FROM '.DB::table('common_member_count')." WHERE uid='$uid'";
							$ucredit      = DB::fetch_first($sql);
							$data         = array('extcredits'.$credit_style => $ucredit['extcredits'.$credit_style] + $_G['cache']['plugin']['niuc_baiduconnect']['baiducredit_quan']);
							DB::update("common_member_count", $data, "uid='$uid'");
						}
						$bind_u_info = array('forum_uid' => $uid, 'taobao_uid' => $_POST['taobao_user_id'], 'taobao_name' => $_POST['taobao_user_nick']);
						$insertid    = addbindinfo($bind_u_info); //add to bind table
						if($insertid) {
							$niuc_uinfo = array('uid' => $uid);
							connect_login($niuc_uinfo, getcookie('xtao_refer'));
							manageaftlogin($niuc_uinfo);
							echo '10'; //ok
						} else {
							echo '4'; //fatalerror
						}
					}
				}
			}
		}
	}

	include template('common/footer_ajax');
} elseif($op == 'unbind'){
	if($_G['uid']) {
		$sql    = 'SELECT userid FROM '.DB::table('forum_taobao_user').' WHERE forum_uid=\''.$_G['uid'].'\'';
		$binded = DB::fetch_first($sql);
		if(!$binded) {
			showmessage(lang('plugin/'.IDENTIFIER, 'not_binded'));
		} else {
			DB::delete('forum_taobao_user', "forum_uid='".$_G['uid']."'");
			include $__path.'medal.class.php';
			$medal = new medal($_G['uid'], $_G['setting']['version'], $__path);
			$medal->recyclemedal();
			showmessage(lang('plugin/'.IDENTIFIER, 'unbind_success'), $_SERVER['HTTP_REFERER'], array(), array('timeout' => '1', 'alert' => 'right'));
		}
	} else {
		showmessage(lang('plugin/'.IDENTIFIER, 'need_login'), '', array(), array('login' => TRUE));
	}
}
if($op == 'redirect') {
	$uri = 'https://oauth.taobao.com/authorize?response_type=code&client_id='.$config['app_key'];
	$uri = $uri.'&redirect_uri='.$redirect_uri;
	header('Location: '.$uri);
	exit;
}

if($op == 'main') {

	$token = getcookie('token');

	if(empty($token)) {
		header('Location: /');
	}

	$token    = unserialize($token);
	$nick     = $token['taobao_user_nick'];
	$username = HACKTOR_PRE.$nick;

	$sql = 'SELECT uid FROM '.DB::table('ucenter_members')." WHERE username='".$username."'";
	$rs  = DB::fetch_first($sql);
	if(!empty($rs)) {
		$connect_member['uid'] = $rs['uid'];
		hacktor_connect_login($connect_member);
		hacktor_manageaftlogin($connect_member);
		showmessage('欢迎您 '.$nick, '/');
	} else {
		if(empty($config['group_id'])) {
			$config['group_id'] = 0;
		}

		$password = md5(md5($username));
		$email    = $username.'@taobao.com';
		$ip       = $_SERVER['REMOTE_ADDR'];
		loaducenter();
		$uid = uc_user_register($username, $password, $email);
		if($uid <= 0) {
			showmessage('注册失败', '/');
		} else {
			hacktor_addmember($uid, $username, $password, $email, $ip, $config['group_id'], NULL);
			$connect_member['uid'] = $uid;
			hacktor_connect_login($connect_member);
			hacktor_manageaftlogin($connect_member);
			showmessage('登录成功', '/');
		}
	}
}





?>
<?php


if($op == 'disconnect') {

} elseif($op == 'init' || $op == 'bindaccount') { //start
	if(!$apikey || !$redirecturi || !$secretkey) {
		showmessage(lang('plugin/'.IDENTIFIER, 'notconfiged'));
		exit;
	}
	$tmp = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
	dsetcookie('xtao_refer', '');
	if(strpos($tmp, 'mod=register') === FALSE && strpos($tmp, 'mod=logging') === FALSE) {
		dsetcookie('xtao_refer', $_SERVER['HTTP_REFERER']);
	}
	header('Location: https://openapi.baidu.com/oauth/2.0/authorize?response_type=code&client_id='.$apikey.'&redirect_uri='.$redirecturi.'&scope=super_msg&display=page');
} elseif($op == 'bind') { //bind
	include template('common/header_ajax');
	$style = isset($_GET['style']) ? $_GET['style'] : '';

	if($style == '0') { //binded or not??
		if(safecheck()) {
			echo '-1'; //unsafe e.g. ' " \ % union select...
		} else {
			$_POST['taobao_user_id']   = addslashes($_POST['taobao_user_id']);
			$_POST['taobao_user_nick'] = addslashes($_POST['taobao_user_nick']);
			$_POST['dps_username']     = addslashes($_POST['dps_username']);
			if(function_exists('fetch_uid_by_username')) {
				$uidfromun = C::t('common_member')->fetch_uid_by_username($_POST['niuc_username']);
			} else {
				$uidfromun = niuc_fetch_uid_by_username($_POST['niuc_username']);
			}
			$sql = 'SELECT forum_uid FROM '.DB::table('forum_baidu_user')." WHERE baiduuid='".$_POST['taobao_user_id']."' or forum_uid='$uidfromun'";
			$rs  = DB::fetch_first($sql);
			if(!empty($rs)) {
				echo '3'; //binded yet
			} else {
				//not binded, bind existing forum user
				//get salt
				$sql  = 'SELECT salt FROM '.DB::table('ucenter_members')." WHERE username='".$_POST['niuc_username']."'";
				$rs   = DB::fetch_first($sql);
				$salt = $rs['salt'];
				if(!empty($rs)) { //salt found
					$sql = 'SELECT uid,password FROM '.DB::table('ucenter_members')." WHERE username='".$_POST['niuc_username']."'"; //verify password?
					$rs  = DB::fetch_first($sql);
					if(md5(md5($_POST['niuc_password']).$salt) == $rs['password']) {
						//true password,begin bind
						$bind_u_info = array('forum_uid' => $rs['uid'], 'baiduuid' => $_POST['taobao_user_id'], 'taobao_name' => $_POST['taobao_user_nick']);
						$insertid    = addbindinfo($bind_u_info); //bind info insert database
						if($insertid) {
							$niuc_uinfo = array('uid' => $rs['uid']);
							connect_login($niuc_uinfo); //login
							manageaftlogin($niuc_uinfo); //login extra
							echo '0'; // OK
						} else {
							echo '4'; //fatal error
						}
					} else {
						echo '2'; //wrong password
					}
				} else {
					echo '1'; //salt not found
				}
			}
		}
	} elseif($style == '1') {
		//bind new user
		if(safecheck()) {
			echo '-1'; //unsafe e.g. ' " \ % union select...
		} else {
			$newusername               = addslashes(trim($_POST['niuc_username']));
			$newpassword               = addslashes(trim($_POST['niuc_password']));
			$newrepassword             = trim($_POST['niuc_repassword']);
			$newemail                  = strtolower(addslashes(trim($_POST['niuc_email'])));
			$_POST['taobao_user_nick'] = addslashes($_POST['taobao_user_nick']);
			$_POST['taobao_user_id']   = addslashes($_POST['taobao_user_id']);
			if($newpassword != $newrepassword || $newpassword == '') {
				echo '17';
			} else {
				if(niuc_fetch_uid_by_username($newusername)) {
					echo '11'; //username_duplicate
				} else {
					loaducenter();
					$uid = uc_user_register($newusername, $newpassword, $newemail);
					if($uid <= 0) {
						if($uid == -1) {
							echo '12';
						} elseif($uid == -2) {
							echo '13';
						} elseif($uid == -3) {
							echo '11';
						} elseif($uid == -4) {
							echo '14';
						} elseif($uid == -5) {
							echo '15';
						} elseif($uid == -6) {
							echo '16';
						}
					} else {
						$sql        = "SELECT * FROM ".DB::table('common_usergroup').' WHERE groupid=\''.$_G['cache']['plugin']['niuc_baiduconnect']['baiduugroup'].'\'';
						$group      = DB::fetch_first($sql);
						$newadminid = in_array($group['radminid'], array(1, 2, 3)) ? $group['radminid'] : ($group['type'] == 'special' ? -1 : 0);
						loadcache('fields_register');
						$init_arr = explode(',', $_G['setting']['initcredits']);
						$password = md5(random(10));
						addmember($uid, $newusername, $password, $newemail, $_SERVER['REMOTE_ADDR'], $_G['cache']['plugin']['niuc_baiduconnect']['baiduugroup'], array('credits' => $init_arr), $newadminid);
						if($_G['cache']['plugin']['niuc_baiduconnect']['baiducredit']) {
							$credit_style = $_G['cache']['plugin']['niuc_baiduconnect']['baiducredit'];
							$sql          = 'SELECT extcredits'.$credit_style.' FROM '.DB::table('common_member_count')." WHERE uid='$uid'";
							$ucredit      = DB::fetch_first($sql);
							$data         = array('extcredits'.$credit_style => $ucredit['extcredits'.$credit_style] + $_G['cache']['plugin']['niuc_baiduconnect']['baiducredit_quan']);
							DB::update("common_member_count", $data, "uid='$uid'");
						}
						$bind_u_info = array('forum_uid' => $uid, 'taobao_uid' => $_POST['taobao_user_id'], 'taobao_name' => $_POST['taobao_user_nick']);
						$insertid    = addbindinfo($bind_u_info); //add to bind table
						if($insertid) {
							$niuc_uinfo = array('uid' => $uid);
							connect_login($niuc_uinfo, getcookie('xtao_refer'));
							manageaftlogin($niuc_uinfo);
							echo '10'; //ok
						} else {
							echo '4'; //fatalerror
						}
					}
				}
			}
		}
	}
	include template('common/footer_ajax');
}
function niuc_login($uarray, $referer) {
	global $_G;
	connect_login($uarray);
	manageaftlogin($uarray);
	loadcache('usergroups');
	$usergroups = $_G['cache']['usergroups'][$_G['groupid']]['grouptitle'];
	$param      = array('username' => $_G['member']['username'], 'usergroup' => $_G['group']['grouptitle']);
	showmessage('login_succeed', $referer ? $referer : './', $param, array('extrajs' => $ucsynlogin, 'showdialog' => 1, 'locationtime' => TRUE));
}

function addbindinfo($fields) {
	global $_G, $__path;
	$insertid = DB::insert('forum_taobao_user', $fields, TRUE);
	if($insertid) { //medal
		include $__path.'medal.class.php';
		$medal = new medal($fields['forum_uid'], $_G['setting']['version'], $__path);
		$medal->addmedal();
	}

	return $insertid;
}

function manageaftlogin($niuc_uinfo) {
	global $_G;
	DB::update(('common_member_status'), array('lastip' => $_G['clientip'], 'lastvisit' => TIMESTAMP, 'lastactivity' => TIMESTAMP), 'uid=\''.$niuc_uinfo['uid'].'\'');
	$ucsynlogin = '';
	if($_G['setting']['allowsynlogin']) {
		loaducenter();
		$ucsynlogin = uc_user_synlogin($_G['uid']);
	}
}

function connect_login($connect_member) {
	global $_G;
	$member = DB::fetch_first('SELECT * FROM '.DB::table('common_member')." WHERE uid='$connect_member[uid]'");
	if(!($member = getuserbyuid($connect_member['uid'], 1))) {
		return FALSE;
	} else {
		if(isset($member['_inarchive'])) {
			C::t('common_member_archive')->move_to_master($member['uid']);
		}
	}
	require_once libfile('function/member');
	$cookietime = 2592000;
	setloginstatus($member, $cookietime);

	return TRUE;
}


function niuc_fetch_uid_by_username($username) {
	$sql = 'SELECT uid FROM '.DB::table('common_member').' WHERE username=\''.$username.'\'';
	$tmp = DB::fetch_first($sql);

	return empty($tmp) ? 0 : $tmp['uid'];
}

function addmember($uid, $username, $password, $email, $ip, $groupid, $extdata, $adminid = 0) {
	$credits            = isset($extdata['credits']) ? $extdata['credits'] : array();
	$profile            = isset($extdata['profile']) ? $extdata['profile'] : array();
	$base               = array(
		'uid'         => $uid,
		'username'    => (string)$username,
		'password'    => (string)$password,
		'email'       => (string)$email,
		'adminid'     => intval($adminid),
		'groupid'     => intval($groupid),
		'regdate'     => TIMESTAMP,
		'emailstatus' => intval($extdata['emailstatus']),
		'credits'     => intval($credits[0]),
		'timeoffset'  => 9999
	);
	$status             = array(
		'uid'          => $uid,
		'regip'        => (string)$ip,
		'lastip'       => (string)$ip,
		'lastvisit'    => TIMESTAMP,
		'lastactivity' => TIMESTAMP,
		'lastpost'     => 0,
		'lastsendmail' => 0
	);
	$count              = array(
		'uid'         => $uid,
		'extcredits1' => intval($credits[1]),
		'extcredits2' => intval($credits[2]),
		'extcredits3' => intval($credits[3]),
		'extcredits4' => intval($credits[4]),
		'extcredits5' => intval($credits[5]),
		'extcredits6' => intval($credits[6]),
		'extcredits7' => intval($credits[7]),
		'extcredits8' => intval($credits[8])
	);
	$profile['uid']     = $uid;
	$field_forum['uid'] = $uid;
	$field_home['uid']  = $uid;
	DB::insert('common_member', $base, TRUE);
	DB::insert('common_member_status', $status, TRUE);
	DB::insert('common_member_count', $count, TRUE);
	DB::insert('common_member_profile', $profile, TRUE);
	DB::insert('common_member_field_forum', $field_forum, TRUE);
	DB::insert('common_member_field_home', $field_home, TRUE);
	DB::insert('common_setting', array('skey' => 'lastmember', 'svalue' => $username), FALSE, TRUE);
	manyoulog('user', $uid, 'add');
	$totalmembers = DB::result_first("SELECT COUNT(*) FROM ".DB::table('common_member'));
	$userstats    = array('totalmembers' => $totalmembers, 'newsetuser' => stripslashes($username));
	save_syscache('userstats', $userstats);
}


?>