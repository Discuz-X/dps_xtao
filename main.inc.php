<?php

define('HACKTOR_PRE', 'taobao_');

$config = $_G['cache']['plugin']['dps_taobao'];
//未开启淘宝登录
if(!$config['allow']){
    exit('disable');
}
if(@!$config['app_key'] || $config == ''){
	showmessage('APP KEY设置为空');
}

$op = empty($_GET['op'])?'redirect':$_GET['op'];

if(isset($_GET['code']) && !empty($_GET['code'])){
    $op = 'login';
}

$redirect_uri = $_G['siteurl'].'plugin.php?id=dps_taobao:main';

if ($op == 'redirect') {
    $uri = 'https://oauth.taobao.com/authorize?response_type=code&client_id='.$config['app_key'];
    $uri = $uri . '&redirect_uri=' . $redirect_uri;
    header('Location: '.$uri);
    exit;
}

if($op == 'main'){

    $token  = getcookie('token');

    if(empty($token)){
        header('Location: /');
    }

    $token  = unserialize($token);
    $nick   = $token['taobao_user_nick'];
    $username   = HACKTOR_PRE.$nick;

    $sql = 'SELECT uid FROM '.DB::table('ucenter_members')." WHERE username='".$username."'";
    $rs = DB::fetch_first($sql);
    if(!empty($rs)){
        $connect_member['uid']  = $rs['uid'];
        hacktor_connect_login($connect_member);
        hacktor_manageaftlogin($connect_member);
        showmessage('欢迎您 '.$nick, '/');
    }else{
        if(empty($config['group_id'])){
            $config['group_id']   = 0;
        }

        $password   = md5(md5($username));
        $email      = $username . '@taobao.com';
        $ip         = $_SERVER['REMOTE_ADDR'];
        loaducenter();
        $uid = uc_user_register($username, $password, $email);
        if($uid <= 0){
            showmessage('注册失败', '/');
        }else{
            hacktor_addmember($uid, $username, $password, $email, $ip, $config['group_id'], null);
            $connect_member['uid']  = $uid;
            hacktor_connect_login($connect_member);
            hacktor_manageaftlogin($connect_member);
            showmessage('登录成功', '/');
        }
    }
}

if ($op == 'login') {
    $code           = $_GET['code'];
    $client_id      = $config['app_key'];
    $grant_type     = 'authorization_code';
    $client_secret  = $config['app_secret'];
    //请求参数
    $postfields = array('grant_type' => $grant_type,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code,
        'redirect_uri' => $redirect_uri
    );

    $url = 'https://oauth.taobao.com/token';
    try {
        $token = json_decode(hacktor_http_request($url, $postfields), true);
        $_G['hacktor_taobao']   = $token;
        dsetcookie('token', serialize($token));
        header('Location: '.$redirect_uri.'&op=main');
    } catch (Exception $exc) {
        $error  = json_decode($exc->getMessage());
        showmessage($error->error_description, $redirect_uri.'&op=redirect');
    }
}


function hacktor_http_request($url, $postFields = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if (is_array($postFields) && 0 < count($postFields)) {
        $postBodyString = "";
        foreach ($postFields as $k => $v) {
            $postBodyString .= "$k=" . urlencode($v) . "&";
        }
        unset($k, $v);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
    }
    $reponse = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch), 0);
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 !== $httpStatusCode) {
            throw new Exception($reponse, $httpStatusCode);
        }
    }
    curl_close($ch);
    return $reponse;
}

function hacktor_addmember($uid, $username, $password, $email, $ip, $groupid, $extdata, $adminid = 0) {
	$credits = isset($extdata['credits']) ? $extdata['credits'] : array();
	$profile = isset($extdata['profile']) ? $extdata['profile'] : array();
	$base = array(
		'uid' => $uid,
		'username' => (string)$username,
		'password' => (string)$password,
		'email' => (string)$email,
		'adminid' => intval($adminid),
		'groupid' => intval($groupid),
		'regdate' => TIMESTAMP,
		'emailstatus' => intval($extdata['emailstatus']),
		'credits' => intval($credits[0]),
		'timeoffset' => 9999
	);
	$status = array(
		'uid' => $uid,
		'regip' => (string)$ip,
		'lastip' => (string)$ip,
		'lastvisit' => TIMESTAMP,
		'lastactivity' => TIMESTAMP,
		'lastpost' => 0,
		'lastsendmail' => 0
	);
	$count = array(
		'uid' => $uid,
		'extcredits1' => intval($credits[1]),
		'extcredits2' => intval($credits[2]),
		'extcredits3' => intval($credits[3]),
		'extcredits4' => intval($credits[4]),
		'extcredits5' => intval($credits[5]),
		'extcredits6' => intval($credits[6]),
		'extcredits7' => intval($credits[7]),
		'extcredits8' => intval($credits[8])
	);
	$profile['uid'] = $uid;
	$field_forum['uid'] = $uid;
	$field_home['uid'] = $uid;
	DB::insert('common_member', $base, true);
	DB::insert('common_member_status', $status, true);
	DB::insert('common_member_count', $count, true);
	DB::insert('common_member_profile', $profile, true);
	DB::insert('common_member_field_forum', $field_forum, true);
	DB::insert('common_member_field_home', $field_home, true);
	DB::insert('common_setting', array('skey' => 'lastmember', 'svalue' => $username), false, true);
	manyoulog('user', $uid, 'add');
	$totalmembers = DB::result_first("SELECT COUNT(*) FROM ".DB::table('common_member'));
	$userstats = array('totalmembers' => $totalmembers, 'newsetuser' => stripslashes($username));
	save_syscache('userstats', $userstats);
}

function hacktor_connect_login($connect_member) {
	global $_G;
	$member = DB::fetch_first('SELECT * FROM '.DB::table('common_member')." WHERE uid='$connect_member[uid]'");
	if(!($member = getuserbyuid($connect_member['uid'], 1))) {
		return false;
	} else {
		if(isset($member['_inarchive'])) {
			C::t('common_member_archive')->move_to_master($member['uid']);
		}
	}
	require_once libfile('function/member');
	$cookietime = 2592000;
	setloginstatus($member, $cookietime);
	return true;
}

function hacktor_manageaftlogin($niuc_uinfo) {
	global $_G;
	DB::update(('common_member_status'), array('lastip'=>$_G['clientip'], 'lastvisit'=>TIMESTAMP, 'lastactivity' => TIMESTAMP), 'uid=\''.$niuc_uinfo['uid'].'\'');
	$ucsynlogin = '';
	if($_G['setting']['allowsynlogin']) {
		loaducenter();
		$ucsynlogin = uc_user_synlogin($_G['uid']);
	}
}
?>
