<?php defined('IN_DISCUZ') || die('Access Denied');
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'init.php';
$plugintitle = $navtitle;//导航标题
$goodkeywords = !empty($_C['goodkeywords']) ? $_C['goodkeywords'] : '';
$indexgoods = !empty($_C['indexgoods']) ? $_C['indexgoods'] : '女装';
//$conv = new Convert;
//if(strtolower($_G['config']['output']['charset']) == 'gbk') {
//	$conv->convert   = TRUE;
//	$conv->localcode = 'gbk';
//} else {
//	$conv->convert = FALSE;
//}
//define('DDROOT', DISCUZ_ROOT.'../duoduo');
$keywords = array();
$keywords = explode(',', $goodkeywords);
//for($i = 0; $i < count($arraykey); $i++) {
//	$keywords[] = $arraykey[$i];
//}
////$itl = new ItemcatsGetRequest;
////$itl->setFields('cid,parent_cid,name,is_parent,status,sort_order,last_modified');
////$itl->setParentCid(isset($_GET['cid'])?$_GET['cid']:'0');
////$ritl = $c->execute($itl);
////aiodebug($ritl->item_cats, 'response', $debug);
////aiodebug($ritl, 'response', $debug);
////$itemCats = $ritl->item_cats->item_cat;
//
////aiodebug($ritl, 'response', $debug);
////aiodebug($ritl, 'response', $debug);
////aiodebug($ritl, 'response', $debug);
////aiodebug($ritl, 'response', $debug);
//if($mod == 'view') {
//	$iid = !empty($_GET['iid']) ? addslashes($_GET['iid']) : showmessage(lang('plugin/abis_shops', 'error_noiids'));
//	$req = new TaobaokeItemsDetailGetRequest;
//	$req->setFields('pic_url,num_iid,title,nick,desc,create,num,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,click_url,shop_click_url,seller_credit_score');
//	$req->setNumIids($iid);
//	$req->setNick($conv->req($taokeusername));
//	$resp = $c->execute($req);
//	if(empty($resp->total_results)) {
//		showmessage(lang('plugin/abis_shops', 'error_noproduct'));
//	}
//	$i                           = $resp->taobaoke_item_details->taobaoke_item_detail[0];
//	$item                        = array();
//	$item['click_url']           = base64_encode($i->click_url);
//	$item['seller_credit_score'] = $i->seller_credit_score;
//	$item['shop_click_url']      = base64_encode($i->shop_click_url);
//	$item['item']                = array();
//	foreach($i->item as $key => $val) {
//		$val                = $conv->disp($val);
//		$item['item'][$key] = $val;
//	}
//
//	//加工市场价
//	if($item['item']['price'] <= 100) {
//		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod1));
//	} else if($item['item']['price'] > 100 and $item['item']['price'] <= 500) {
//		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod2));
//	} else if($item['item']['price'] > 500 and $item['item']['price'] <= 1000) {
//		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod3));
//	} else if($item['item']['price'] > 1000 and $item['item']['price'] <= 3000) {
//		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod4));
//	} else if($item['item']['price'] > 3000 and $item['item']['price'] <= 5000) {
//		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod5));
//	} else {
//		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod6));
//	}
//
	//得到标题
	if(!empty($item['item']['title'])) {
		$thisnav  = $item['item']['title'];
		$navtitle = $item['item']['title'].' - '.$plugintitle;
	}
//} else {
//	$page    = intval($_GET['page']) != 0 ? intval($_GET['page']) : 1;
	$keyword = dhtmlspecialchars(rawurldecode($_GET['keyword']));
//	$sort    = dhtmlspecialchars(rawurldecode($_GET['sort']));
//	$cid     = dhtmlspecialchars(rawurldecode($_GET['cid']));
//
	//得到标题
	if(empty($cid) and empty($keyword)) { //关键字和分类都为空
		$navtitle = $plugintitle;
		$thisnav  = '';
	} else if(!empty($cid) and empty($keyword)) {
		$navtitle = $thisnav.' - '.$plugintitle;
		$thisnav  = '';
	} else if(empty($cid) and !empty($keyword)) {
		$navtitle = $keyword.' - '.$plugintitle;
		$thisnav  = $keyword.'';
	} else if(!empty($cid) and !empty($keyword)) {
		$navtitle = $keyword.'-'.$plugintitle;
		$thisnav  = $keyword.'';
	}
//
//
	$thisnav = empty($keyword)?$indexgoods:$keyword;//得到导航
//	if(empty($cid)) {
//		$cid = 0;
//	} else {
//		$thisnav = '';
//	}
//
//
//	//得到排序
//	if(empty($sort)) {
//		$sort = commissionNum_desc;
//	}
//
//	$ppp = !empty($_C['page_size']) ? intval($_C['page_size']) : showmessage(lang('plugin/abis_shops', 'error_nopagesize'));
//	$ppp = $ppp > 40 ? 40 : $ppp;
//
//	$req = new TaobaokeItemsGetRequest;
//	$req->setPageNo($page);
//	$req->setPageSize($ppp);
//	$req->setSort($sort);
//	$req->setFields('num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume');
//
//	if(empty($cid) and empty($keyword)) { //关键字和分类都为空
//		$keyword = $indexgoods;
//		$req->setKeyword($conv->req($keyword));
//		$keyword = NULL;
//	} else if(!empty($cid) and empty($keyword)) {
//		$req->setCid($conv->req($cid));
//	} else if(empty($cid) and !empty($keyword)) {
//		$req->setKeyword($conv->req($keyword));
//	} else if(!empty($cid) and !empty($keyword)) {
//		$req->setKeyword($conv->req($keyword));
//	}
//
//	if(!empty($taokepid)) {
//		//aiodebug($taokepid, 'taoke pid', $debug);
//		$req->setPid($taokepid);
//	} elseif(!empty($taokeusername)) {
//		aiodebug($taokeusername, 'taoke username', $debug);
//		$req->setNick($conv->req($taokeusername));
//	} else {
//		showmessage(lang('plugin/abis_shops', 'error_nouser'));
//	}
//	$resp = $c->execute($req);
//	//aiodebug($resp, 'response', $debug);
//	$total = $resp->total_results;
//	$total = $total > $ppp * 100 ? $ppp * 100 : $total;
//	$items = array();
//	foreach($resp->taobaoke_items->taobaoke_item as $i) {
//		$item                   = get_object_vars($i);
//		$item['title']          = $conv->disp($item['title']);
//		$item['item_location']  = $conv->disp($item['item_location']);
//		$item['nick']           = $conv->disp($item['nick']);
//		$item['click_url']      = base64_encode($item['click_url']);
//		$item['shop_click_url'] = base64_encode($item['shop_click_url']);
//
//		//加工市场价
//		if($item['price'] <= 100) {
//			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod1));
//		} else if($item['price'] > 100 and $item['price'] <= 500) {
//			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod2));
//		} else if($item['price'] > 500 and $item['price'] <= 1000) {
//			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod3));
//		} else if($item['price'] > 1000 and $item['price'] <= 3000) {
//			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod4));
//		} else if($item['price'] > 3000 and $item['price'] <= 5000) {
//			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod5));
//		} else {
//			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod6));
//		}
//
//		$items[] = $item;
//	}
//
//	$pageurl = 'plugin.php?id=abis_shops:tbindex&cid='.rawurlencode($cid).'&keyword='.rawurlencode($keyword).'&sort='.$sort;
//	$multi   = multi($total, $ppp, $page, $pageurl);
//
//	/*
//	if(!empty($keyword)) {
//		$navtitle = $keyword.'-'.$plugintitle;
//		$thisnav = $keyword.'';
//	}
//	*/
//}

function get_tao_id($url, $tao_id_arr = array()) {
//	if(empty($tao_id_arr)) {
//		$tao_id_arr = array(
//			'id',
//			'Id',
//			'item_num_id',
//			'default_item_id',
//			'item_id',
//			'itemId',
//			'mallstItemId',
//			//'tradeID'  http://trade.taobao.com/trade/detail/tradeSnap.htm?tradeID=147485513698005
//		);;
//	}
//	$ids = implode('|', $tao_id_arr);
//	preg_match('/[&|?]('.$ids.')=(\d+)/', $url, $b);
//	if($b[2] == '') {
//		preg_match('#/i(\d+)\.htm#', $url, $b);
//
//		return $b[1];
//	} else {
//		return $b[2];
//	}
}
//
//function in_tao_cat($cid, $tao_cat = array()) {
//	if(empty($tao_cat)) {
//		$tao_cat = array(
//			1 => array(50010537, 50010531, 50003509, 50022728, 50010530, 50010529, 50010527, 50010540, 50010518, 50010539, 50010522, 50012308, 50012334, 50012423, 50013186, 50016012, 50016450, 50017139, 50010528, 50017667, 50012325, 50012945, 50013825, 50013204, 50017598, 50017618, 50017782, 50017864, 50016664, 50016585, 50016587, 50016588, 50016593, 50016595, 50016620, 50016622, 50016643, 50016645, 50016651, 50016655, 50016572, 50016638, 50016634, 50016630, 50016625, 50016618, 50016613, 50016608, 50016603, 50016605, 50016599, 50016600, 50016683, 50017732, 50016660, 50017915, 50017926, 50017940, 50017948, 50017956, 50017965, 50017973, 50018098, 50017270, 50018190, 50018196, 50019505, 50013928, 50015978, 50014677, 50013932, 50019520, 50019526, 50014787, 50015980, 50014800, 50015983, 50014798, 50019543, 50014799, 50019549, 50013933, 50014802, 50015984, 50014089, 50014137, 50019535, 50019202, 50015396, 50019132, 50019124, 50019125, 50019128, 50019126, 50019127, 50019130, 50019131, 50019133, 50019135, 50013228, 50011717, 50011718, 50011720, 50011721, 50011711, 50011713, 50013238, 50013239, 50011704, 50011706, 50011739, 50010850, 50000671, 162104, 162105, 50013196, 162116, 50000697, 50011277, 50008897, 50008898, 162103, 50008901, 50013194, 50008900, 50008899, 50008904, 50008905, 50000852, 1629, 1624, 50011404, 50008906, 50000436, 50010402, 50010159, 50011123, 50011159, 50011165, 50011161, 50011167, 50010160, 50010158, 50011130, 50011153, 50000557, 50001748, 50005867, 50012355, 50012357, 50012358, 50012359, 50012360, 50012361, 50012365, 50012371, 50012372, 50012373, 50012378, 50012379, 50012381, 50010398, 50012377,),
//			array(50007068, 50023107, 50003510, 50013616, 50013686, 50017668, 50016586, 50016594, 50016644, 50016571, 50016604, 50014786, 50014791, 50014788, 50014801, 50019541, 50019547, 50014803, 50019136, 50019137, 50011722, 50011726, 1622, 162205, 1623, 50010167, 3035, 50011129, 50011127, 50012356, 50012362, 50012364, 50012366, 50012367, 50012369, 50012375, 50066647, 50071140, 50066954,),
//			array(50012340, 50012331, 50012064, 50012044, 50012036, 50012946, 50013826, 50013205, 50017599, 50017619, 50017784, 50017865, 50017630, 50017762, 50016584, 50016592, 50016617, 50016642, 50016650, 50016654, 50016637, 50016633, 50016629, 50016616, 50016612, 50016607, 50016602, 50016598, 50016682, 50016659, 50017916, 50017927, 50017941, 50017957, 50018099, 50017271, 50018191, 50018195, 50019504, 50019272, 50019270, 50019274, 50019275, 50019276, 50019278, 50019279, 50019280, 50019118, 50019140, 50019141, 50019143, 50019342, 50010388, 50011740, 50006843, 50011597, 50031712,),
//			array(50012324, 50016666, 50013887, 50016125, 50019122, 50006842, 50014494, 50014495, 50014496, 50014500, 50014502, 50014503),
//			array(50013865, 50013868, 50022428, 50013882, 50013868, 50014239, 50013964, 50009579, 150701, 50013879, 50013869, 50013875, 50013878, 50006583, 50012312, 50016589, 50016596, 50016624, 50016646, 50016647, 50016652, 50016656, 50016574, 50016639, 50016635, 50016631, 50016627, 50016619, 50016614, 50015368, 50019119, 50005700, 50010404, 50011818),
//			array(50010788, 50020280, 50011999, 50020276, 50012006, 50012000, 50024984, 50008548, 50008545, 50010567, 50012083, 1801, 50018397),
//			array(50006584, 50012430, 50016736, 50016737, 50016738, 50016739, 50016740, 50016741, 50016742, 50014796, 50016143, 50019138, 1625, 50019651, 50012363, 50012370, 50014848, 50007124, 50012380, 50016687, 50010399, 50016686, 50016688, 50016884, 50019652, 50019653, 50019656, 50019657, 50019658, 50019654, 50019655, 50008881),
//			array(50013008, 50021800, 50003823, 50011738, 50013334, 210103, 50020103, 50013980, 50020105, 50008626, 50012520, 50012928, 50006990, 50006890, 50023181, 50023169, 50012411, 50002777, 50010825, 50024799, 50001283, 50003450, 50008607, 50013011, 50011676, 50009202, 50001412, 50008779, 50005526, 50020953, 50011975, 50023409, 50006439, 50009221, 50006772, 50010417, 210204, 50011975, 50020104, 50020676, 21, 50016349, 50016348, 50008163, 2128, 50020670, 50020808, 50020857, 50012100, 50012082),
//			array(14, 261704, 20, 50011418, 50008090, 11, 50018222, 50012164, 1201, 1512, 50012081, 1101, 50019780)
//		);;
//	}
//	foreach($tao_cat as $k => $v) {
//		if(in_array($cid, $v)) {
//			return $k;
//		}
//	}
//
//	return 999;
//}
//
function dd_set_cache($name, $arr, $type = 'json') {
	switch($type) {
		case 'json':
			$data = PHP_EXIT.json_encode($arr);
			dd_file_put(DDROOT.'/data/json/'.$name.'.php', $data);
			break;
		case 'array':
			$data = "<?php\n return ".var_export($arr, TRUE).";\n?>";
			dd_file_put(DDROOT.'/data/array/'.$name.'.php', $data);
			break;
	}
}
//function dd_get_cache($name, $type = 'json') {
//	switch($type) {
//		case 'json':
//			$data = array();
//			if(is_file(DDROOT.'/data/json/'.$name.'.php')) {
//				$data = file_get_contents(DDROOT.'/data/json/'.$name.'.php');
//				$data = preg_replace('/^'.PHP_EXIT_PREG.'/', '', $data);
//				$data = json_decode($data, 1);
//				if(empty($data)) {
//					$data = array();
//				}
//			}
//			break;
//		case 'array':
//			$data = array();
//			if(is_file(DDROOT.'/data/array/'.$name.'.php')) {
//				$data = include(DDROOT.'/data/array/'.$name.'.php');
//				if(empty($data)) {
//					$data = array();
//				}
//			}
//			break;
//	}
//	return $data;
//}
//
//function def($tag, $data = array(), $parame = array()) {
//	$default_data = dd_get_cache('tao_goods', 'array');
//	switch($tag) {
//		case 'dingdaning':
//			$default_data = $default_data[$tag];
//			if(!empty($default_data)) {
//				foreach($default_data as $row) {
//					$data[$row['wz']]['num_iid']    = $row['num_iid'];
//					$data[$row['wz']]['item_title'] = $row['title'];
//					$data[$row['wz']]['fxje']       = $row['fxje'] * TBMONEYBL;
//					$data[$row['wz']]['img']        = $row['pic_url'];
//					$data[$row['wz']]['name']       = '******';
//					$data[$row['wz']]['gourl']      = u('tao', 'view', array('iid' => $row['num_iid']));
//				}
//			}
//			break;
//
//		case 'tao_hot_goods':
//			$default_data = $default_data[$tag];
//			if(is_array($default_data) && !empty($default_data)) {
//				foreach($default_data as $row) {
//					$data[$row['wz']]['num_iid'] = $row['num_iid'];
//					$data[$row['wz']]['title']   = $row['title'];
//					$data[$row['wz']]['pic_url'] = $row['pic_url'];
//					$data[$row['wz']]['price']   = $row['price'];
//					$data[$row['wz']]['fxje']    = fenduan($row['commission'], $parame['fxbl'], $parame['user_level'], TBMONEYBL);
//					$data[$row['wz']]['gourl']   = u('tao', 'view', array('iid' => $row['num_iid']));
//				}
//			}
//			break;
//
//		case 'tao_zhe_goods':
//			$default_data = $default_data[$tag];
//			if(is_array($default_data) && !empty($default_data)) {
//				foreach($default_data as $row) {
//					$data[$row['wz']]['num_iid']         = $row['num_iid'];
//					$data[$row['wz']]['title']           = $row['title'];
//					$data[$row['wz']]['pic_url']         = $row['pic_url'];
//					$data[$row['wz']]['price']           = $row['price'];
//					$data[$row['wz']]['coupon_price']    = $row['coupon_price'];
//					$data[$row['wz']]['coupon_end_time'] = $row['coupon_end_time'];
//					$data[$row['wz']]['coupon_fxje']     = fenduan($row['coupon_commission'], $parame['fxbl'], $parame['user_level']);
//					$data[$row['wz']]['gourl']           = u('tao', 'view', array('iid' => $row['num_iid']));
//				}
//			}
//			break;
//	}
//
//	return $data;
//}
//
//function jump($url = '', $word = '') {
//	if(defined('AJAX') && AJAX == 1) {
//		if($word != '') {
//			$arr = array('s' => 0, 'id' => $word);
//		} else {
//			$arr = array('s' => 1);
//		}
//		echo json_encode($arr);
//		dd_exit();
//	} else {
//		if($word != '') {
//			if(is_numeric($word)) {
//				global $errorData;
//				$alert = "alert('".$errorData[$word]."');";
//			} else {
//				$alert = "alert('".$word."');";
//			}
//		} else {
//			$alert = '';
//		}
//		if($url == -1) {
//			$url = $_SERVER["HTTP_REFERER"];
//		}
//		if(is_numeric($url)) {
//			echo script($alert.'history.go('.$url.');');
//		} else {
//			echo script($alert.'window.location.href="'.$url.'";');
//			//echo '< meta http-equiv="Refresh" content="0; url='.$url.'" />';
//		}
//		dd_exit();
//	}
//}
//
//function u($mod, $act = '', $arr = array()) {
//	$wjt = 0;
//	if(isset($arr['rela'])) {
//		$rela = 1;
//		unset($arr['rela']);
//	} else {
//		$rela = 0;
//	}
//
//	if(defined('INDEX') == 1) {
//		if($act == '' && $mod == 'index') {
//			return SITEURL;
//		}
//		global $wjt_mod_act_arr; //伪静态数组
//
//		if(!isset($wjt_mod_act_arr)) {
//			$wjt_mod_act_arr = dd_get_cache('wjt');
//		}
//		if(WJT == 1 && array_key_exists($mod, $wjt_mod_act_arr) && array_key_exists($act, $wjt_mod_act_arr[$mod]) && $wjt_mod_act_arr[$mod][$act] == 1) {
//			$wjt = 1;
//		}
//		unset($wjt_mod_act_arr);
//
//		if($mod == 'tao' && ($act == 'list' || $act == 'view') && URLENCRYPT != '') {
//			if(isset($arr['cid']) && $arr['cid'] > 0) {
//				$arr['cid'] = dd_encrypt($arr['cid'], URLENCRYPT);
//			} elseif(isset($arr['iid']) && $arr['iid'] > 0) {
//				$arr['iid'] = dd_encrypt($arr['iid'], URLENCRYPT);
//			}
//		}
//	}
//
//	if($wjt == 0) {
//		if($act == '') {
//			$mod_act_url = "index.php?mod=".$mod."&act=index";
//		} elseif(empty($arr)) {
//			$mod_act_url = "index.php?mod=".$mod."&act=".$act;
//		} else {
//			$mod_act_url = "index.php?mod=".$mod."&act=".$act.arr2param($arr);
//		}
//	} elseif($wjt == 1) {
//		global $alias_mod_act_arr; //链接别名数组
//		if(!isset($alias_mod_act_arr)) {
//			$alias_mod_act_arr = dd_get_cache('alias');
//		}
//		$dir = $mod.'/'.$act;
//		if(is_array($alias_mod_act_arr[$dir])) {
//			$mod = $alias_mod_act_arr[$dir][0];
//			$act = $alias_mod_act_arr[$dir][1];
//		}
//		unset($alias_mod_act_arr);
//		if($act == '') {
//			$mod_act_url = $mod."/index.html";
//		} elseif(empty($arr)) {
//			$mod_act_url = $mod.'/'.$act.'.html';
//		} else {
//			$mod_act_url = '';
//			$url         = '';
//			foreach($arr as $k => $v) {
//				$url .= rawurlencode($v).'-';
//			}
//			$mod_act_url = $mod.'/'.$act.'-'.$url;
//			$mod_act_url = str_del_last($mod_act_url).'.html';
//		}
//	}
//
//	if(defined('INDEX') && $mod == 'index' && $act == 'index') {
//		$mod_act_url = '';
//	}
//
//	if(defined('INDEX') && $rela == 0) {
//		$mod_act_url = SITEURL.'/'.$mod_act_url;
//	}
//
//	/*if(strpos($mod_act_url,'%23')!==false){
//		$mod_act_url=str_replace('%23','#',$mod_act_url);
//	}*/
//
//	return $mod_act_url;
//}
//
//function dd_session_start() {
//	create_dir(DDROOT.'/data/temp/session/'.date('Ymd'));
//	ini_set('session.save_handler', 'files');
//	session_save_path(DDROOT.'/data/temp/session/'.date('Ymd'));
//	session_set_cookie_params(0, '/', '');
//	session_start();
//}
//
//function sel_date($dir) {
//	$dh = dir($dir);
//	$j  = 0;
//	while(($filename = $dh->read()) !== FALSE) {
//		if($filename != "." && $filename != "..") {
//			$dp = $dir.'/'.$filename;
//			if(judge_empty_dir($dp) != 1) {
//				$arr            = explode('_', $filename);
//				$time           = date('Y-m-d', strtotime($arr[1]));
//				$option_arr[$j] = "<option value='$arr[1]'>$time</option>";
//				$j++;
//			}
//		}
//	}
//	for($i = $j; $i >= 0; $i--) {
//		$option .= $option_arr[$i];
//	}
//	$dh->close();
//
//	return $option;
//}
//
//function mingxi_content($row, $mingxi_content) {
//	$mingxi_content = str_replace('{money}', $row['money'], $mingxi_content);
//	$mingxi_content = str_replace('{jifenbao}', jfb_data_type($row['jifenbao']), $mingxi_content);
//	$mingxi_content = str_replace('{jifen}', $row['jifen'], $mingxi_content);
//	if(strpos($mingxi_content, '{source}') !== FALSE) {
//		$mingxi_content = str_replace('{source}', $row['source'], $mingxi_content);
//	}
//
//	return $mingxi_content;
//}
//
//
//function spider_limit($spider) {
//	foreach($spider as $k => $val) {
//		if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), $k) !== FALSE) {
//			$rand_num = rand(1, 100);
//			if($rand_num <= $val) {
//				dd_file_put(DDROOT.'/data/spider/'.$k.'.txt', date('Y-m-d H:i:s')."\r\n", FILE_APPEND);
//				showmessage('hello spider!');
//			}
//		}
//	}
//}
//
//function mod_name($mod, $act) {
//	if($mod == 'index') {
//		$mod_name = $mod;
//	} elseif($mod == 'ajax' || $mod == 'jump') {
//		$mod_name = $mod;
//	} else {
//		$mod_name = $mod.'/'.$act;
//	}
//
//	return $mod_name;
//}
//
//function AD($id) {
//	$arr = dd_get_cache('ad/'.$id);
//	if(!empty($arr)) {
//		$style = 'style="';
//		if($arr['edate'] > TIME && ($arr['img'] == 1 || $arr['content'] == 1)) {
//			if($arr['width'] > 0) {
//				$style .= 'width:'.$arr['width'].'px;';
//			}
//			if($arr['height'] > 0) {
//				$style .= 'height:'.$arr['height'].'px;';
//			}
//			$style .= '"';
//			if(isset($arr['ad_content'])) {
//				$c = $arr['ad_content'];
//			} else {
//				$c = "<script src='".SITEURL."/data/ad/".$id.".js'></script>";
//			}
//
//			return "<div ".$style." id='ad".$id."'>".$c."</div>";
//		}
//	}
//
//	return;
//}
//
//function yzm($path = '') {
//	return '<img alt="验证码" src="'.$path.'comm/showpic.php" align="absmiddle" onClick="this.src=\''.$path.'comm/showpic.php?a=\'+Math.random()" title="点击更换" style="cursor:pointer;"/>';
//}
//
//function show_shop_cat($text) {
//	switch($text) {
//		case "11":
//			$str = "电脑硬件/台式机/网络设备";
//			break;
//		case "12":
//			$str = "MP3/MP4/iPod/录音笔";
//			break;
//		case "13":
//			$str = "手机";
//			break;
//		case "14":
//			$str = "女装/流行女装";
//			break;
//		case "15":
//			$str = "彩妆/香水/护肤/美体";
//			break;
//		case "16":
//			$str = "电玩/配件/游戏/攻略";
//			break;
//		case "17":
//			$str = "数码相机/摄像机/图形冲印";
//			break;
//		case "18":
//			$str = "运动/瑜伽/健身/球迷用品";
//			break;
//		case "20":
//			$str = "古董/邮币/字画/收藏";
//			break;
//		case "21":
//			$str = "办公设备/文具/耗材";
//			break;
//		case "22":
//			$str = "汽车/配件/改装/摩托/自行车";
//			break;
//		case "23":
//			$str = "珠宝/钻石/翡翠/黄金";
//			break;
//		case "24":
//			$str = "居家日用/厨房餐饮/卫浴洗浴";
//			break;
//		case "26":
//			$str = "装潢/灯具/五金/安防/卫浴";
//			break;
//		case "27":
//			$str = "成人用品/避孕用品/情趣内衣";
//			break;
//		case "29":
//			$str = "食品/茶叶/零食/特产";
//			break;
//		case "30":
//			$str = "玩具/动漫/模型/卡通";
//			break;
//		case "31":
//			$str = "箱包皮具/热销女包/男包";
//			break;
//		case "32":
//			$str = "宠物/宠物食品及用品";
//			break;
//		case "33":
//			$str = "音乐/影视/明星/乐器";
//			break;
//		case "34":
//			$str = "书籍/杂志/报纸";
//			break;
//		case "35":
//			$str = "网络游戏点卡";
//			break;
//		case "36":
//			$str = "网络游戏装备/游戏币/帐号/代练";
//			break;
//		case "37":
//			$str = "男装";
//			break;
//		case "1020":
//			$str = "母婴用品/奶粉/孕妇装";
//			break;
//		case "1040":
//			$str = "ZIPPO/瑞士军刀/饰品/眼镜";
//			break;
//		case "1041":
//			$str = "移动联通充值中心/IP长途";
//			break;
//		case "1042":
//			$str = "网店装修/物流快递/图片存储";
//			break;
//		case "1043":
//			$str = "笔记本电脑";
//			break;
//		case "1044":
//			$str = "品牌手表/流行手表";
//			break;
//		case "1045":
//			$str = "户外/军品/旅游/机票";
//			break;
//		case "1046":
//			$str = "家用电器/hifi音响/耳机";
//			break;
//		case "1047":
//			$str = "鲜花速递/蛋糕配送/园艺花艺";
//			break;
//		case "1048":
//			$str = "3C数码配件市场";
//			break;
//		case "1049":
//			$str = "床上用品/靠垫/窗帘/布艺";
//			break;
//		case "1050":
//			$str = "家具/家具定制/宜家代购";
//			break;
//		case "1051":
//			$str = "保健品/滋补品";
//			break;
//		case "1052":
//			$str = "网络服务/电脑软件";
//			break;
//		case "1053":
//			$str = "演出/旅游/吃喝玩乐折扣券";
//			break;
//		case "1054":
//			$str = "饰品/流行首饰/时尚饰品";
//			break;
//		case "1055":
//			$str = "女士内衣/男士内衣/家居服";
//			break;
//		case "1056":
//			$str = "女鞋";
//			break;
//		case "1062":
//			$str = "童装/婴儿服/鞋帽";
//			break;
//		case "1082":
//			$str = "流行男鞋/皮鞋";
//			break;
//		case "1102":
//			$str = "腾讯QQ专区";
//			break;
//		case "1103":
//			$str = "IP卡/网络电话/在线影音充值";
//			break;
//		case "1104":
//			$str = "个人护理/保健/按摩器材";
//			break;
//		case "1105":
//			$str = "闪存卡/U盘/移动存储";
//			break;
//		case "1106":
//			$str = "运动鞋";
//			break;
//		case "1122":
//			$str = "时尚家饰/工艺品/十字绣";
//			break;
//		case "1153":
//			$str = "运动服";
//			break;
//		case "1154":
//			$str = "服饰配件/皮带/帽子/围巾";
//			break;
//		default:
//			$str = "全部店铺";
//			break;
//	}
//	return $str;
//}
//
//function reg_content($content, $type = 0) { //type为1，替换；type为2，提示错误
//	$pattern = DOMAIN_PREG;
//	if($type == 0) {
//		$type = REPLACE;
//	}
//	$shield_arr = dd_get_cache('no_words'); //屏蔽词语
//	if($type == 1) {
//		$content = strtr($content, $shield_arr);
//		$content = preg_replace($pattern, '', $content);
//	} else {
//		foreach($shield_arr as $v) {
//			if(strpos($content, $v) !== FALSE) {
//				return ''; //包含非法词汇
//			}
//		}
//		if(preg_match($pattern, $content)) {
//			return '';
//		}
//	}
//
//	return htmlspecialchars($content);
//}
//
//function jfb_data_type($jifenbao) {
//	return data_type($jifenbao, TBMONEYTYPE);
//}
//
//function mobile_yzm($mobile, $yzm = '') {
//	$a = dd_crc32(DDKEY.$mobile);
//	$a = substr($a, 0, 4);
//	if($yzm == '') {
//		return $a;
//	} else {
//		if($yzm == $a) {
//			return 1;
//		} else {
//			return 0;
//		}
//	}
//}
//
//function show_mobile($mobile) {
//	return '<b style="font-size:18px; color:#000">'.substr($mobile, 0, 3).'*****'.substr($mobile, -3).'</b>';
//}
//
//function dd_xuliehua($obj) {
//	return base64_encode(gzcompress(json_encode($obj)));
//}
//
////反序列化
//function dd_unxuliehua($txt) {
//	return json_decode(gzuncompress(base64_decode($txt)), 1);
//}
//
//function add_menu($data) { //$data=array('parent_id'=>72,'node'=>'plug','mod'=>'plugin','act'=>'list','listorder'=>'0','sort'=>'0','title'=>'插件列表','hide'=>0,'sys'=>1);
//	global $duoduo;
//
//	if(!isset($data['parent_id'])) { //插件菜单快速添加
//		$data['parent_id'] = 72;
//		$data['node']      = 'plug';
//		$data['listorder'] = 0;
//		$data['sort']      = 0;
//		$data['hide']      = 1;
//		$data['sys']       = 0;
//	}
//
//	if($data['act'] == '' && $data['mod'] == '') {
//		$data['listorder'] = $data['sort'] + 10000;
//		unset($data['sort']);
//		$menuid = $duoduo->select('menu', 'id', '`node`="'.$data['node'].'" and `mod`="" and `act`=""');
//		if($menuid > 0) {
//			return $menuid; //节点已存在;
//		}
//		$menuid = $duoduo->insert('menu', $data);
//		$data   = array('role_id' => 1, 'menu_id' => $menuid);
//		$duoduo->insert('menu_access', $data);
//
//		return $menuid;
//	} else {
//		$menuid = $duoduo->select('menu', 'id', '`mod`="'.$data['mod'].'" and act="'.$data['act'].'"');
//		if($menuid > 0) {
//			return $menuid;
//		}
//		$menuid = $duoduo->insert('menu', $data);
//		$data   = array('role_id' => 1, 'menu_id' => $menuid);
//		$duoduo->insert('menu_access', $data);
//	}
//}
//
//function del_menu($mod, $act) {
//	global $duoduo;
//	$id = $duoduo->select('menu', 'id', '`mod`="'.$mod.'" and `act`="'.$act.'"'); //删除导航
//	$duoduo->delete('menu', 'id="'.$id.'" limit 1');
//	$duoduo->delete('menu_access', 'menu_id="'.$id.'" limit 1');
//}
//
//function url_html_cache($name, $url, $trigger_time_arr = array()) {
//	$trigger_time_arr = array('09:30:00', '14:30:00', '17:30:00');
//	$html_dir         = DDROOT.'/data/html/'.$name.'/'.dd_crc32($url).'.html';
//	$html_url         = SITEURL.'/data/html/'.$name.'/'.dd_crc32($url).'.html';
//
//	if(!file_exists($html_dir)) {
//		$html = dd_get($url);
//		create_file($html_dir, $html);
//	} else {
//		$file_time = filemtime($html_dir);
//		foreach($trigger_time_arr as $v) {
//			$trigger_time = strtotime(date('Ymd'.' '.$v));
//			if(TIME > $trigger_time && $file_time <= $trigger_time) {
//				$html = dd_get($url);
//				create_file($html_dir, $html);
//			}
//		}
//	}
//
//	return $html_url;
//}
//
//function l($mod, $act, $arr = array()) {
//	$url = SITEURL.'/index.php?mod='.$mod.'&act='.$act;
//	if(!empty($arr)) {
//		$url .= '&'.arr2param($arr);
//	}
//
//	return $url;
//}
//
//function p($mod, $act, $arr = array()) {
//	$url = '';
//	if(WJT == 1) {
//		foreach($arr as $k => $v) {
//			$url .= rawurlencode($v).'-';
//		}
//		$url = $mod.'/'.$act.'-'.$url;
//		$url = SITEURL.'/'.str_del_last($url).'.html';
//	} else {
//		$url = SITEURL.'/plugin.php?mod='.$mod.'&act='.$act;
//		if(!empty($arr)) {
//			$url .= arr2param($arr);
//		}
//	}
//
//	return $url;
//}
//
//function include_mod($mod, $duoduo, $new = 1) { //new表示是否实例化
//	include(DDROOT.'/mod/'.$mod.'/fun.class.php');
//	$dd_mod_class_name  = 'dd_'.$mod.'_class';
//	$$dd_mod_class_name = new $dd_mod_class_name($duoduo);
//
//	return $$dd_mod_class_name;
//}
//GLOBAL $webset;
//$webset =
//	array(
//		'fxbl'                =>
//		array(
//			100 => '0.8',
//			50  => '0.7',
//			20  => '0.6',
//			0   => '0.5',
//		),
//		'sign'                =>
//		array(
//			'open'     => '0',
//			'money'    => '0',
//			'jifenbao' => '0',
//			'jifen'    => '0',
//		),
//		'baobei'              =>
//		array(
//			'shai_jifen'       => '2',
//			'share_jifen'      => '1',
//			'hart_jifen'       => '1',
//			'shai_s_time'      => '2011-10-01',
//			'word_num'         => '80',
//			'comment_word_num' => '50',
//			'share_level'      => '0',
//			'comment_level'    => '0',
//			'cat'              =>
//			array(
//				1   => '上装',
//				2   => '下装',
//				3   => '鞋子',
//				4   => '包包',
//				5   => '配饰',
//				6   => '美妆',
//				7   => '内衣',
//				8   => '家居',
//				9   => '数码',
//				999 => '其他',
//			),
//			're_tao_cid'       => '1',
//		),
//		'comment_interval'    => '86400',
//		'chanet'              =>
//		array(
//			'name' => 'a0504030301',
//			'pwd'  => '',
//			'wzid' => '431726',
//			'key'  => '2a784eee44480173',
//		),
//		'static'              =>
//		array(
//			'index' =>
//			array(
//				'random' => '0',
//			),
//		),
//		'tixian_limit'        => '10',
//		'txxz'                => '10',
//		'user'                =>
//		array(
//			'jihuo'          => '0',
//			'autoreg'        => '0',
//			'shoutu'         => '0',
//			'reg_between'    => '0',
//			'reg_money'      => '0',
//			'reg_jifenbao'   => '0',
//			'reg_jifen'      => '0',
//			'reg_level'      => '0',
//			'up_avatar'      => '1',
//			'auto_increment' => '1',
//			'limit_ip'       => '',
//		),
//		'taobao_nick'         => '飞翔的波斯猫',
//		'taobao_session'      =>
//		array(
//			'value'         => '',
//			'refresh_token' => '',
//			'day'           => '20121220',
//			'auto'          => '0',
//			'time'          => 0,
//		),
//		'wujiumiaoapi'        =>
//		array(
//			'open'              => '0',
//			'key'               => '1006060',
//			'secret'            => 'c8e8aa3ebe08032ea930f0fe462f5bff',
//			'pagesize'          => '20',
//			'cache_time'        => '0',
//			'shield_merchantId' => '',
//			'del_cache_time'    => '',
//		),
//		'tao_report_interval' => '1200',
//		'jifenbl'             => '0',
//		'tgbl'                => '0.1',
//		'taoapi'              =>
//		array(
//			'm2j'                   => '0',
//			'pagesize'              => '20',
//			'goods_comment'         => '0',
//			'trade_check'           => '1',
//			's8'                    => '0',
//			'freeze'                => '0',
//			'freeze_sday'           => '2012-12-16 16:15:59',
//			'freeze_limit'          => '0',
//			'ju_commission_rate'    => '0.01',
//			'tmall_commission_rate' => '0.005',
//			'shield'                => '0',
//			'cache_time'            => '10',
//			'cache_monitor'         => '0',
//			'errorlog'              => '0',
//			'taobao_search_pid'     => '25328448_2922415_11006570',
//			'taobao_chongzhi_pid'   => '25328448_2922415_10004886',
//			'fanlitip'              => '0',
//			'goods_show'            => '1',
//			'sort'                  => 'commissionNum_desc',
//			'promotion'             => '0',
//			'jssdk_key'             => '21141544',
//			'jssdk_secret'          => '433bd2b2450a9a67fd7a5b0530b90377',
//		),
//		'hotword'             =>
//		array(
//			0 => '热卖',
//			1 => '新款',
//			2 => '秒杀',
//			3 => '减肥',
//			4 => '内衣',
//			5 => '丰胸',
//			6 => '衬衣',
//			7 => '短袖',
//			8 => '连衣裙',
//			9 => '电风扇',
//		),
//		'webclose'            => '0',
//		'webclosemsg'         => '网站升级中。。。',
//		'email'               => 'email',
//		'qq'                  => 'qq',
//		'liebiao'             => '1',
//		'level'               =>
//		array(
//			0   => '普通会员',
//			20  => '黄金会员',
//			50  => '白金会员',
//			100 => '钻石会员',
//		),
//		'mallfxbl'            =>
//		array(
//			100 => '0.8',
//			50  => '0.7',
//			20  => '0.6',
//			0   => '0.5',
//		),
//		'smtp'                =>
//		array(
//			'type' => '1',
//			'host' => '',
//			'name' => '',
//			'pwd'  => '',
//		),
//		'sql_debug'           => '0',
//		'hytxjl'              => '0',
//		'tgurl'               => 'http://tryanderror.cn/duoduo/index.php?',
//		'searchlimit'         => '0',
//		'linktech'            =>
//		array(
//			'name' => '',
//			'pwd'  => '',
//			'wzbh' => '',
//		),
//		'duomai'              =>
//		array(
//			'uid'  => '10440',
//			'wzid' => '52244',
//			'wzbh' => '001',
//			'key'  => '35ad3d58d228787714d72e1ded84d40a',
//		),
//		'gzip'                => '0',
//		'shop'                =>
//		array(
//			'open'   => '1',
//			'slevel' => '11',
//			'elevel' => '20',
//		),
//		'yiqifa'              =>
//		array(
//			'uid'  => '',
//			'wzid' => '',
//			'name' => '',
//			'key'  => '',
//		),
//		'yiqifaapi'           =>
//		array(
//			'open'              => '0',
//			'key'               => '13399929765611312',
//			'secret'            => '4ff6a7f2d44ef876d15eabffe1c799ee',
//			'pagesize'          => '20',
//			'cache_time'        => '0',
//			'shield_merchantId' => '100016',
//		),
//		'tuan'                =>
//		array(
//			'open'     => '0',
//			'cid'      => '1',
//			'autoget'  => '2',
//			'autogdel' => '1',
//			'shownum'  => '6',
//			'listnum'  => '9',
//			'mall_cid' => '21',
//		),
//		'ucenter'             =>
//		array(
//			'open'          => '0',
//			'UC_APPID'      => '',
//			'UC_KEY'        => '',
//			'UC_API'        => '',
//			'UC_DBCHARSET'  => '',
//			'UC_CHARSET'    => '',
//			'UC_DBHOST'     => '',
//			'UC_DBUSER'     => '',
//			'UC_DBPW'       => '',
//			'UC_DBNAME'     => '',
//			'UC_DBTABLEPRE' => '',
//		),
//		'spider'              =>
//		array(
//			'sosospider'  => '100',
//			'baiduspider' => '20',
//			'yahoo'       => '100',
//			'bingbot'     => '100',
//			'googlebot'   => '100',
//			'ia_archiver' => '100',
//			'youdaobot'   => '100',
//			'sohu'        => '100',
//			'msnbot'      => '100',
//			'slurp'       => '100',
//			'sogou'       => '100',
//			'QihooBot'    => '100',
//		),
//		'seo'                 =>
//		array(
//			'spider_limit' => '0',
//		),
//		'fxb'                 =>
//		array(
//			'open' => '0',
//			'name' => '多多返现宝',
//		),
//		'tao_report_time'     => '1371141560',
//		'tuan_goods_time'     => '1371140944',
//		'tao_cache_time'      => '1374588537',
//		'login_tip'           => '1',
//		'taobao_pid'          => '25328448',
//		'jiesuan_date'        => '201208',
//		'phpwind'             =>
//		array(
//			'open'    => '0',
//			'key'     => '',
//			'url'     => '',
//			'charset' => '',
//		),
//		'yinxiangma'          =>
//		array(
//			'open'        => '0',
//			'private_key' => '',
//			'public_key'  => '',
//		),
//		'bshare_code'         => '<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#uuid=c196de18-8f38-410e-8ae0-834dd0ec2c86&amp;style=3&amp;fs=4&amp;textcolor=#fff&amp;bgcolor=#F60&amp;text=分享到..."></script>',
//		'paipai_report_time'  => '1371140944',
//		'paipaifxbl'          =>
//		array(
//			100 => '0.8',
//			50  => '0.7',
//			20  => '0.6',
//			0   => '0.5',
//		),
//		'bshare'              =>
//		array(
//			'user'      => 'anzhongxiao@126.com',
//			'pwd'       => 'an4659862',
//			'uuid'      => 'c196de18-8f38-410e-8ae0-834dd0ec2c86',
//			'secretKey' => '158d59b4-0e48-4240-8ff9-de000aa0b4e2',
//		),
//		'collect'             =>
//		array(
//			'curl'              => '1',
//			'file_get_contents' => '2',
//			'fsockopen'         => '3',
//		),
//		'tao_zhe'             =>
//		array(
//			'keyword'                 => '热卖',
//			'cid'                     => '16',
//			'coupon_type'             => '1',
//			'shop_type'               => 'all',
//			'sort'                    => 'commissionRate_desc',
//			'start_coupon_rate'       => '1000',
//			'end_coupon_rate'         => '9000',
//			'start_credit'            => '1heart',
//			'end_credit'              => '5goldencrown',
//			'start_commission_rate'   => '1000',
//			'end_commission_rate'     => '9000',
//			'start_commission_volume' => '',
//			'end_commission_volume'   => '',
//			'start_commission_num'    => '',
//			'end_commission_num'      => '',
//			'start_volume'            => '',
//			'end_volume'              => '',
//			'page_size'               => '16',
//			'ajax_load_num'           => '5',
//		),
//		'sql_log'             => '0',
//		'yiqifa_cache_time'   => '1347281665',
//		'corrent_time'        => '0',
//		'authorize'           => '10d1+zxLLkWBb0fYsasPjTHNGAPRcZISwpqdxzNv11BusjjSbhHRK6QnwT/tRB8zZfBlSbBQ/+gj8n0Dx9dkzzxIlZxUfl3Vlcrjuz/3yfXAgBnTLh30aNeCRuByuAJlOAEdXLvgu+hP3KmOs7VKUg7wCfWSOEkFugqQYMatSM/SrrX0OCHry+sRwpx1bGCpgIJ+yO+ZYT5EMTuYYGwZKbRN7HBsoI5MADCXps2I0ArFhO5FjIOX82fanrZwSJUZ9A',
//		'shop_count'          =>
//		array(
//			'c3423b50b6bc6f096c8adb67d138a03f' =>
//			array(
//				'count' => 123,
//				'time'  => 1344958234,
//			),
//			'b3238ee9a748de831d373d2cb67eb896' =>
//			array(
//				'count' => 36,
//				'time'  => 1343919212,
//			),
//			'345860b0cc5bf16991899d57d15e9b05' =>
//			array(
//				'count' => 0,
//				'time'  => 1344959071,
//			),
//			'26463dfff3cfa230ece11a054330fd1d' =>
//			array(
//				'count' => '131',
//				'time'  => 1355972422,
//			),
//			'cba0c3c4eba6ea656323750c80c35510' =>
//			array(
//				'count' => 1,
//				'time'  => 1346215972,
//			),
//			'ddbc652ae832177d9ea36c40b4982040' =>
//			array(
//				'count' => 1,
//				'time'  => 1346216605,
//			),
//			'1081f1dcbe8c6f15da37dc330ff28279' =>
//			array(
//				'count' => 0,
//				'time'  => 1346429307,
//			),
//			'15e58b831c48b54374c20ad80729f2c9' =>
//			array(
//				'count' => 0,
//				'time'  => 1346882387,
//			),
//			'c622a8583962dafc67f0df71a3902ee9' =>
//			array(
//				'count' => 0,
//				'time'  => 1346882390,
//			),
//			'9d9d07719dcf3a029bd9c71ccc233243' =>
//			array(
//				'count' => 0,
//				'time'  => 1346882392,
//			),
//			'6a4389c47e5116359a6cb88d16f9231d' =>
//			array(
//				'count' => 0,
//				'time'  => 1346882392,
//			),
//			'92d072dcd68592a552157a15d9d86069' =>
//			array(
//				'count' => 0,
//				'time'  => 1346882393,
//			),
//			'cd405da34b6a1e01f4cf38dc830ec8f6' =>
//			array(
//				'count' => 2,
//				'time'  => 1346882394,
//			),
//			'20233a79e8a58c9a15ff381fc85b8585' =>
//			array(
//				'count' => 1,
//				'time'  => 1346882395,
//			),
//			'bdbd221a0d0e8e7084bd57ee83d8f362' =>
//			array(
//				'count' => 0,
//				'time'  => 1346882395,
//			),
//			'a8227e987bfbf21877b728b1313b05a5' =>
//			array(
//				'count' => 0,
//				'time'  => 1346882397,
//			),
//			'cafa1e0950af3db7056cf85ddcf7a1fe' =>
//			array(
//				'count' => 16,
//				'time'  => 1347013694,
//			),
//			'3c585a0d110870e379197d5f4acb6102' =>
//			array(
//				'count' => 0,
//				'time'  => 1346882400,
//			),
//			'9bc5a0e8027145ce11161820efb9a9d9' =>
//			array(
//				'count' => 0,
//				'time'  => 1347983694,
//			),
//			'dc0f8f7ea1eef59212b1c93890fbb0b6' =>
//			array(
//				'count' => 1,
//				'time'  => 1348408611,
//			),
//			'd7e4f0a1be5271c549f7280bec16ab3a' =>
//			array(
//				'count' => 0,
//				'time'  => 1348650799,
//			),
//			'5462da8bb8f268bec9c82b7c5339d5af' =>
//			array(
//				'count' => 1,
//				'time'  => 1348675819,
//			),
//			'2864125ec77653f0820745bde18777e2' =>
//			array(
//				'count' => '1',
//				'time'  => 1374588537,
//			),
//		),
//		'banquan'             => 'Copyright ©2008-2012&nbsp;&nbsp; <a href="http://soft.duoduo123.com" target="_blank">多多返利建站系统</a>&nbsp;&nbsp;&nbsp;<a href="index.php?mod=about&amp;act=index" target="_blank">关于我们</a>',
//		'email_notice'        =>
//		array(
//			'dd' => '1',
//		),
//		'paipai'              =>
//		array(
//			'open'           => '0',
//			'userId'         => '12245',
//			'qq'             => '332439180',
//			'appOAuthID'     => '700028903',
//			'secretOAuthKey' => '0cQC1gfECGxeLXvS',
//			'accessToken'    => '164cb25e20b6415e684000650fb62cf1',
//			'keyWord'        => '女装',
//			'pageSize'       => '20',
//			'sort'           => '11',
//			'cache_time'     => '0',
//			'errorlog'       => '0',
//		),
//		'sms'                 =>
//		array(
//			'name'   => 'an4659862',
//			'pwd'    => 'aaaaaa',
//			'newpwd' => 'aaaaaa',
//			'mobile' => '',
//			'check'  => '0',
//		),
//		'qq_meta'             => '',
//		'tgfz'                => '50',
//		'tixian'              =>
//		array(
//			'tblimit'     => '1000',
//			'tbtxxz'      => '1000',
//			'limit'       => '10',
//			'txxz'        => '10',
//			'hytxjl'      => '0',
//			'ddpay'       => '0',
//			'need_alipay' => '1',
//		),
//		'appkey'              =>
//		array(
//			0 =>
//			array(
//				'key'    => '21141544',
//				'secret' => '433bd2b2450a9a67fd7a5b0530b90377',
//				'num'    => '100',
//			),
//		),
//	);
function act_tao_view() {
//	global $duoduo, $ddTaoapi;
	//include DISCUZ_ROOT.'../duoduo/comm/dd.class.php';
	//include DISCUZ_ROOT.'../duoduo/comm/collect.class.php';
	//include DISCUZ_ROOT.'../duoduo/comm/Taoapi.php';
	//include DISCUZ_ROOT.'../duoduo/comm/ddTaoapi.class.php';
	//$ddTaoapi = new ddTaoapi();
//	//$webset      = $duoduo->webset;
//
//	//$dduser      = $duoduo->dduser;
//	$dduser = array(
//		'name'  => '',
//		'id'    => 0,
//		'level' => 0,
//	);
//	//$tao_id_arr  = include(DDROOT.'/data/tao_ids.php');
//	$tao_id_arr = array(
//		'id',
//		'Id',
//		'item_num_id',
//		'default_item_id',
//		'item_id',
//		'itemId',
//		'mallstItemId',
//		//'tradeID'  http://trade.taobao.com/trade/detail/tradeSnap.htm?tradeID=147485513698005
//	);
//	//$shield_cid  = include(DDROOT.'/data/shield_cid.php');
//	$shield_cid = array(0 => 50012829, 1 => 50003114, 2 => 50012831, 3 => 50012832, 4 => 50012830, 5 => 50006275, 6 => 50019617, 7 => 50019618, 8 => 50019619, 9 => 50019620, 10 => 50019621, 11 => 50019622, 12 => 50019623, 13 => 50019624, 14 => 50019625, 15 => 50019626, 16 => 50019627, 17 => 50019628, 18 => 50019629, 19 => 50019630, 20 => 50019631, 21 => 50019636, 22 => 50019637, 23 => 50019638, 24 => 50019639, 25 => 50019640, 26 => 50019641, 27 => 50019642, 28 => 50019643, 29 => 50019644, 30 => 50019692, 31 => 50019693, 32 => 50019645, 33 => 50019646, 34 => 50019698, 35 => 50019699, 36 => 50019700, 37 => 50019647, 38 => 50019651, 39 => 50019652, 40 => 50019653, 41 => 50019654, 42 => 50019655, 43 => 50019656, 44 => 50019657, 45 => 50019658, 46 => 50019659, 47 => 50019660, 48 => 50019661, 49 => 50019662, 50 => 50019663, 51 => 50019664, 52 => 50019665, 53 => 50020206, 54 => 50020205, 55 => 50050327, 2813);
//	//$virtual_cid = include(DDROOT.'/data/virtual_cid.php');
//	$virtual_cid = array('goods' => array(0 => 150401, 1 => 150402, 2 => 50011814, 3 => 150406), 'shop' => array(1103, 1041, 1102, 35, 36));
//	if(empty($iid)) {
//		$iid = isset($_GET['iid']) ? (float)$_GET['iid'] : '';
//	}
	if(empty($keyword)) {
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
	}
//	$promotion_name = $_GET['promotion_name'] ? $_GET['promotion_name'] : '促销打折';
//	$price_name     = '一&nbsp;口&nbsp;价';
//
//	$is_url  = 0;
//	$is_mall = 0;
//	$is_ju   = 0;
//	$url     = '';
//
//
//	if(preg_match('/(taobao\.com|tmall\.com)/', $keyword)) {
//		$is_url = 1;
//		$url    = $keyword;
//		$iid    = (float)get_tao_id($keyword, $tao_id_arr);
//		if($iid == 0) {
//			showmessage('请使用标准淘宝商品网址搜索！');
//		}
//
//		$ju_url  = 'http://a.m.taobao.com/i'.$iid.'.htm';
//		$ju_html = file_get_contents($ju_url);
//		if($ju_html == '') { //个别主机不能采集淘宝手机页面
//			$ju_url  = 'http://ju.taobao.com/tg/home.htm?item_id='.$iid;
//			$ju_html = dd_get($ju_url);
//			if($ju_html != '' && strpos($ju_html, '<input type="hidden" name="item_id" value="'.$iid.'"') !== FALSE) {
//				$is_juhuasuan = 2; //一般网页
//			}
//		} elseif(strpos($ju_html, '<a name="'.$iid.'"></a>') !== FALSE) {
//			$is_juhuasuan = 1; //手机网页
//		}
//
//		if($is_juhuasuan > 0) {
//			$keyword = $url = 'http://ju.taobao.com/tg/home.htm?item_id='.$iid;
//			if($is_juhuasuan == 1) {
//				preg_match('/style="color:#ffffff;">￥(.*)<\/span>/', $ju_html, $a);
//			} else {
//				preg_match('/<strong class="J_juPrices"><b>&yen;<\/b>(.*)<\/strong>/', $ju_html, $a);
//			}
//			$ju_price                          = (float)$a[1];
//			$goods_type                        = 'ju';
//			$jssdk_items_convert['goods_type'] = $goods_type; //聚划算
//			$jssdk_items_convert['ju_price']   = $ju_price;
//			$price_name                        = '<img src="images/ju-icon.png" alt="聚划算" />';
//		} elseif(strpos($keyword, 'tmall.com') !== FALSE) {
//			$goods_type                        = 'tmall';
//			$jssdk_items_convert['goods_type'] = $goods_type; //天猫
//			$price_name                        = '<b style="color:#a91029">天猫正品</b>';
//		} else {
//			$goods_type                        = 'market';
//			$jssdk_items_convert['goods_type'] = $goods_type; //集市
//		}
//	} elseif($iid == 0) {
//		if($webset['taoapi']['s8'] == 1) {
//			$url = $ddTaoapi->taobao_taobaoke_listurl_get($keyword, $dduser['id']);
//			$url = $goods['jump'] = "index.php?mod=jump&act=s8&url=".urlencode(base64_encode($url)).'&name='.urlencode($keyword);
//			jump($url);
//		} else {
//			showmessage('直接搜索淘宝商品网址即可查询返利', 5);
//		}
//	}
	$data['iid']        = $iid;
	$data['outer_code'] = $dduser['id'];
	$data['all_get']    = 1; //商品没有返利也获取商品内容
	$data['goods_type'] = $goods_type;
	$data['ju_price']   = $ju_price;
//
//	if(TAOTYPE == 1) {
//		$data['fields'] = 'iid,detail_url,num_iid,title,nick,type,cid,pic_url,seller_cids,num,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,item_img';
//		if(WEBTYPE == 1) {
//			$data['fields'] .= ',desc';
//		}
//		$goods       = $ddTaoapi->taobao_item_get($data);
//		$allow_fanli = 1;
//	} else {
//		$data['fields'] = 'iid,detail_url,num_iid,title,nick,type,cid,pic_url,num,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,seller_credit_score,shop_click_url,click_url,volume,stuff_status,has_invoice,auction_point';
//		if(WEBTYPE == 1) {
//			$data['fields'] .= ',desc';
//		}
//		$goods       = $ddTaoapi->items_detail_get($data);
//		exit('afjk');
//		$allow_fanli = 1; //$ddTaoapi->taobao_taobaoke_rebate_authorize_get($iid);
//	}
//
//
//	if($goods['title'] == '' || $goods['num'] == 0 || ($webset['taoapi']['shield'] == 1 && in_array($goods['cid'], $shield_cid))) {
//		showmessage('商品不存在或已下架或者是违禁商品。<a target="_blank" href="http://item.taobao.com/item.htm?id='.$iid.'">去淘宝确认</a>', -1, 1);
//	}
//
	$jssdk_items_convert['method']      = 'taobao.taobaoke.widget.items.convert';
	$jssdk_items_convert['outer_code']  = (int)$dduser['id'];
	$jssdk_items_convert['user_level']  = (int)$dduser['level'];
	$jssdk_items_convert['num_iids']    = $iid;
	$jssdk_items_convert['allow_fanli'] = $allow_fanli;
	$jssdk_items_convert['cid']         = $goods['cid'];
	$jssdk_items_convert['tmall_fxje']  = (float)$goods['tmall_fxje'];
	$jssdk_items_convert['ju_fxje']     = (float)$goods['ju_fxje'];
	$jssdk_items_convert['goods_type']  = $goods_type;
//
	//$nick = $goods['nick'];
//
//	//include(DDROOT.'/mod/tao/shopinfo.act.php'); //店铺信息
//
	//$shop = $ddTaoapi->taobao_shop_get($nick);
//
//	if($shop == 104) {
//		showmessage('掌柜不存在！');
//	} else {
//		$jssdk_shops_convert['method']       = 'taobao.taobaoke.widget.shops.convert';
//		$jssdk_shops_convert['outer_code']   = (int)$dduser['id'];
//		$jssdk_shops_convert['user_level']   = (int)$dduser['level'];
//		$jssdk_shops_convert['seller_nicks'] = $nick;
//		$jssdk_shops_convert['list']         = (int)$list;
//		foreach($shop as $k => $v) {
//			$jssdk_shops_convert[$k] = $v;
//		}
//	}
//
//	//////
//	if(WEBTYPE == 1 && TAOTYPE == 2) {
//		$Tapparams['cid']          = $goods['cid']; //当前cid热卖商品
//		$Tapparams['page_size']    = 6;
//		$Tapparams['start_credit'] = '1crown';
//		$Tapparams['end_credit']   = '5goldencrown';
//		$Tapparams['start_price']  = '20';
//		$Tapparams['end_price']    = '5000';
//		$Tapparams['sort']         = 'commissionNum_desc';
//		$Tapparams['outer_code']   = $dduser['id'];
//		$goods2                    = $ddTaoapi->taobao_taobaoke_items_get($Tapparams);
//	}
//
//	$comment_url = "http://rate.taobao.com/detail_rate.htm?&auctionNumId=".$iid."&showContent=2&currentPage=1&ismore=1&siteID=7&userNumId=";
//
//	//include(DDROOT.'/plugin/tao_coupon.php');
//
//
//	function tao_coupon_view($shop_title, $goods_price) {
//		$str         = '';
//		$d           = iconv("UTF-8", "gbk//IGNORE", $shop_title);
//		$e           = urlencode($d);
//		$url         = "http://taoquan.taobao.com/coupon/coupon_list.htm?key_word=".$e;
//		$listcontent = iconv("gbk", "utf-8//IGNORE", dd_get($url));
//		$preg        = "/<p class=\"coupon-num\">&yen;(.*)元<\/p>/";
//		preg_match_all($preg, $listcontent, $num); //获取优惠券面值
//		$preg = "/<p class=\"cond\">使用条件：订单满(.*).00元<\/p>/";
//		preg_match_all($preg, $listcontent, $cond); //获取使用条件
//		$preg = "/a href=\"combo\/between.htm\?(.*)&shopTitle/";
//		preg_match_all($preg, $listcontent, $url); //获取优惠券地址码
//		$a = $cond[1];
//		arsort($a);
//		foreach($a as $k => $v) {
//			$b = $cond[1][$k];
//			$d = $num[1][$k];
//			$u = $url[1][$k];
//		}
//
//		$str = '<div class="shopitem_main_r_5"><span>优&nbsp;惠&nbsp;券：';
//		if($num[1][$k] > 0) {
//			$str .= '【<a style="color:#F60;" href="http://ecrm.taobao.com/shopbonusapply/buyer_apply.htm?'.$url[1][$k].'" target="_blank" title="点击免费领取优惠券后购买更便宜" >满'.$cond[1][$k].'减'.$num[1][$k].'元';
//			if($goods_price < $cond[1][$k]) {
//				$str .= '(需凑单)';
//			}
//			$str .= '</a>】&nbsp;</span><a  href="'.u('tao', 'coupon', array('q' => $shop_title)).'" target="_blank" title="查看该卖家更多优惠券">查看更多优惠券</a>  &nbsp;';
//		} else {
//			$str .= '暂&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;无&nbsp;&nbsp;';
//		}
//		$str .= '</span> </div>';
//
//		return $str;
//	}
//	exit('sdjfhlafjal');
//
//	$plugin_set = array();
//	if($plugin_set['tao_coupon'] == 1) {
//		$tao_coupon_str = tao_coupon_view($shop['title'], $goods['price']);
//	}
//	/////////

	$parameter['tao_id_arr']          = $tao_id_arr;
	$parameter['shield_cid']          = $shield_cid;
	$parameter['virtual_cid']         = $virtual_cid;
	$parameter['iid']                 = $iid;
	$parameter['q']                   = $keyword;
	$parameter['promotion_name']      = $promotion_name;
	$parameter['price_name']          = $price_name;
	$parameter['tao_coupon_str']      = $tao_coupon_str;
	$parameter['url']                 = $url;
	$parameter['data']                = $data;
	$parameter['goods']               = $goods;
	$parameter['goods2']              = $goods2;
	$parameter['comment_url']         = $comment_url;
	$parameter['nick']                = $nick;
	$parameter['jssdk_items_convert'] = $jssdk_items_convert;
	$parameter['shop']                = $shop;
	$parameter['jssdk_shops_convert'] = $jssdk_shops_convert;

	unset($duoduo);

	return $parameter;
}

if($keyword != '') {
	$parameter = act_tao_view();
	extract($parameter);
	$css[] = TPLURL."/css/view.css";
	$js[]  = "js/md5.js";
	$js[]  = "js/jssdk.js";
	$js[]  = "js/jQuery.autoIMG.js";
	//include(TPLPATH.'/header.tpl.php');
}
include template(IDENTIFIER.':taobaoindex');
/**
 * 淘宝API处理类
 *
 * @category   Taoapi
 * @package    Taoapi
 * @copyright  Copyright (c) 2008-2009 Taoapi (http://www.Taoapi.com)
 * @license    http://www.Taoapi.com
 * @version    Id: Taoapi  2009-12-22  12:30:51  浪子 ；多多淘宝客优化：http://www.duoduo123.com
 */
class Taoapi {

	protected $taobaoData;
	private $_userParam = array();
	public $_errorInfo;
	/**
	 * @var Taoapi_Config
	 */
	public $ApiConfig;
	/**
	 * @var Taoapi_Cache
	 */
	public $Cache;
	public $cache_id;
	private $_ArrayModeData;



	public function __construct() {
		$Config = Taoapi_Config::Init();

		$this->ApiConfig = $Config->getConfig();

		$this->Cache = new Taoapi_Cache();
		$this->Cache->setClearCache($this->ApiConfig->ClearCache);
	}



	public function __set($name, $value) {
		if($this->taobaoData && $this->ApiConfig->AutoRestParam) {

			$this->_userParam = array();
			$this->taobaoData = NULL;
		}
		$this->_userParam[$name] = $value;
	}



	public function setUserParam($userParam) {
		$this->_userParam = $userParam;
	}



	public function __get($name) {
		if(!empty($this->_userParam[$name])) {

			return $this->_userParam[$name];
		}
	}



	public function __unset($name) {
		unset($this->_userParam[$name]);
	}



	public function __isset($name) {
		return isset($this->_userParam[$name]);
	}



	public function __destruct() {
		$this->_userParam = array();
	}



	public function __toString() {
		return $this->createStrParam($this->_userParam);
	}



	/**
	 * @return Taoapi
	 */
	public function setRestNumberic($rest) {
		$this->ApiConfig->RestNumberic = intval($rest);

		return $this;
	}



	/**
	 * @return Taoapi
	 */
	public function setVersion($version, $signmode = 'md5') {
		$this->ApiConfig->Version = intval($version);

		$this->ApiConfig->SignMode = $signmode;

		return $this;
	}



	/**
	 * @return Taoapi
	 */
	public function setCloseError() {
		$this->ApiConfig->CloseError = FALSE;

		return $this;
	}



	private function FormatUserParam($param) {
		if(strtoupper($this->ApiConfig->Charset) != 'UTF-8') {
			if(function_exists('mb_convert_encoding')) {
				if(is_array($param)) {
					foreach($param as $key => $value) {
						$param[$key] = @mb_convert_encoding($value, 'UTF-8', $this->ApiConfig->Charset);
					}
				} else {
					$param = @mb_convert_encoding($param, 'UTF-8', $this->ApiConfig->Charset);
				}
			} elseif(function_exists('iconv')) {
				if(is_array($param)) {
					foreach($param as $key => $value) {
						$param[$key] = @iconv($this->ApiConfig->Charset, 'UTF-8', $value);
					}
				} else {
					$param = @iconv($this->ApiConfig->Charset, 'UTF-8', $param);
				}
			}
		}

		return $param;
	}



	private function FormatTaobaoData($data) {
		if(strtoupper($this->ApiConfig->Charset) != 'UTF-8') {
			if(function_exists('mb_convert_encoding')) {
				$data = str_replace('utf-8', $this->ApiConfig->Charset, $data);
				$data = @mb_convert_encoding($data, $this->ApiConfig->Charset, 'UTF-8');
			} elseif(function_exists('iconv')) {
				$data = str_replace('utf-8', $this->ApiConfig->Charset, $data);
				$data = @iconv('UTF-8', $this->ApiConfig->Charset, $data);
			}
		}

		return $data;
	}



	/**
	 * @return Taoapi
	 */
	public function Send($mode = 'GET', $format = 'xml') {
		$imagesArray = $this->_ArrayModeData = array();
		$tempParam = $this->_userParam;
		foreach($tempParam as $key => $value) {
			if(is_array($value)) {
				if(!empty($value['image'])) {
					$imagesArray = $value;
				}
				unset($tempParam[$key]);
			} elseif(trim($value) == '') {
				unset($tempParam[$key]);
			} else {
				$tempParam[$key] = $this->FormatUserParam($value);
			}
		}

		if(!isset($tempParam['api_key'])) {

			$systemdefault['api_key'] = key($this->ApiConfig->AppKey);
			$systemdefault['format']  = strtolower($format);
			$systemdefault['v']       = strpos($this->ApiConfig->Version, '.') ? $this->ApiConfig->Version : $this->ApiConfig->Version.'.0';
			if($this->ApiConfig->Version == 2) {
				$systemdefault['sign_method'] = strtolower($this->ApiConfig->SignMode);
			}
			$systemdefault['timestamp'] = date('Y-m-d H:i:s');

			$tempParam        = array_merge($tempParam, $systemdefault);
			$this->_userParam = array_merge($this->_userParam, $systemdefault);
		}

		$cacheid = $tempParam;

		unset($cacheid['timestamp']); //去掉随机性数据
		unset($cacheid['api_key']);

		$cacheid = md5($this->createStrParam($cacheid));

		$this->cache_id = $cacheid;

		$method = !empty($tempParam['method']) ? $tempParam['method'] : '';

		$this->Cache->setMethod($method);

		if(!$this->taobaoData = $this->Cache->getCacheData($cacheid)) {

			$mode = strtoupper($mode);

			$ReadMode = array_key_exists($mode, $this->ApiConfig->PostMode) ? $this->ApiConfig->PostMode[$mode] : $ReadMode['GET'];

			if($ReadMode == 'postImageSend') {
				$this->taobaoData = $this->$ReadMode($tempParam, $imagesArray);
			} else {
				$this->taobaoData = $this->$ReadMode($tempParam);
			}

			$error = $this->getArrayData($this->taobaoData);

			global $counttt;
			$counttt++==1 && exit((string) __LINE__);
			$this->ApiCallLog();

			if(isset($error['code'])) {

				/*if(in_array($error['code'],array(4,5,6,7,8,25)))
				{
					$this->_systemParam['apicount'] = empty($this->_systemParam['apicount']) ? 1 : $this->_systemParam['apicount'] + 1;
					if($this->_systemParam['apicount'] < count($this->ApiConfig->AppKey))
					{
						next($this->ApiConfig->AppKey);
						$this->_userParam['api_key'] = key($this->ApiConfig->AppKey);
						return $this->Send($mode, $format);
					}
				}*/

				if($this->ApiConfig->RestNumberic && empty($this->_systemParam['apicount'])) {

					$this->ApiConfig->RestNumberic = $this->ApiConfig->RestNumberic - 1;

					return $this->Send($mode, $format);
				} else {
					$tempParam['sign'] = $this->_systemParam['sign'];

					$this->_errorInfo = new Taoapi_Exception($error, $tempParam, $this->ApiConfig->CloseError, $this->ApiConfig->Errorlog);

					if(!$this->ApiConfig->CloseError) {
						echo $this->FormatTaobaoData($this->_errorInfo->getErrorInfo());
					}
				}
			} else {
				$this->cache_id = $cacheid;
			}
		}

		return $this;
	}


	public function ApiCallLog() {
		if($this->ApiConfig->ApiLog) {
			$apilogpath = DDROOT.'/data/temp/taoapi_call_log';
			$logparam   = $this->_userParam;
			unset($logparam['fields']);
			create_file($apilogpath.'/'.key($this->ApiConfig->AppKey).'_'.date('Y-m-d').'.log', implode("\t", $logparam)."\r\n", 1);
		}
	}



	public function getXmlData() {
		if(empty($this->taobaoData)) {
			return FALSE;
		}

		return $this->FormatTaobaoData($this->taobaoData);
	}



	public function getJsonData() {
		if(empty($this->taobaoData)) {
			return FALSE;
		}
		if(substr($this->taobaoData, 0, 1) != '{') {

			if($this->_userParam['format'] == 'xml') {
				$Charset                  = $this->ApiConfig->Charset;
				$this->ApiConfig->Charset = "UTF-8";
				$Data                     = $this->getArrayData($this->taobaoData);
				$this->ApiConfig->Charset = $Charset;
			}

			$Data = json_encode($Data);
			if(strpos($_SERVER['SERVER_SIGNATURE'], "Win32") > 0) {
				$Data = preg_replace("#\\\u([0-9a-f][0-9a-f])([0-9a-f][0-9a-f])#ie", "iconv('UCS-2','UTF-8',pack('H4', '\\1\\2'))", $Data);
			} else {
				$Data = preg_replace("#\\\u([0-9a-f][0-9a-f])([0-9a-f][0-9a-f])#ie", "iconv('UCS-2','UTF-8',pack('H4', '\\2\\1'))", $Data);
			}
			$Data = $this->FormatTaobaoData($Data);

		} else {
			$Data = $this->taobaoData;
		}

		return $Data;
	}



	public function getArrayData() {
		if(empty($this->taobaoData)) {
			return FALSE;
		}

		if(!empty($this->taobaoData) && is_array($this->taobaoData)) {
			if($this->_userParam['format'] == 'json') {
				foreach($this->taobaoData as $k => $row) {
					return $row;
				}
			}
		}

		if(!empty($this->_ArrayModeData[$this->ApiConfig->Charset])) {
			return $this->_ArrayModeData[$this->ApiConfig->Charset];
		}

		if($this->_userParam['format'] == 'json') {
			$arr = dd_json_decode($this->taobaoData, TRUE);
			if(is_array($arr) && !isset($arr['error_response'])) {
				$this->Cache->saveCacheData($this->cache_id, $this->taobaoData);
			}
			if($this->_userParam['format'] == 'json' && is_array($arr)) {
				foreach($arr as $k => $row) {
					return $row;
				}
			}

			return array();
		} elseif($this->_userParam['format'] == 'xml') {

			$xmlCode = simplexml_load_string($this->taobaoData, 'SimpleXMLElement', LIBXML_NOCDATA);

			if(is_object($xmlCode)) {
				$this->Cache->saveCacheData($this->cache_id, $this->taobaoData);
			}

			$taobaoData = $this->get_object_vars_final($xmlCode);

			if(strtoupper($this->ApiConfig->Charset) != 'UTF-8') {
				$taobaoData = $this->get_object_vars_final_coding($taobaoData);
			}

			$this->_ArrayModeData[$this->ApiConfig->Charset] = $taobaoData;

			return $taobaoData;

		} else {
			return FALSE;
		}
	}



	/**
	 * 返回错误提示信息
	 *
	 * @return array
	 */
	public function getErrorInfo() {
		if($this->_errorInfo) {
			if(is_object($this->_errorInfo)) {

				return $this->FormatTaobaoData($this->_errorInfo->getErrorInfo());
			} else {
				return $this->FormatTaobaoData($this->_errorInfo);
			}
		}
	}



	/**
	 * 返回提交参数
	 *
	 * @return array
	 */
	public function getParam() {
		return $this->_userParam;
	}



	private function JoinSign($paramArr) {
		$sign = '';
		foreach($paramArr as $key => $val) {
			if(is_array($val)) {
				$sign .= $this->JoinSign($val);

			} elseif($key != '' && $val != '') {
				$sign .= $key.$val;
			}
		}

		return $sign;
	}



	public function SignVersion2($paramArr) {
		if(strtolower($this->ApiConfig->SignMode) == 'hmac') {
			ksort($paramArr);
			$sign = $this->JoinSign($paramArr);
			$sign = strtoupper(bin2hex(mhash(MHASH_MD5, $sign, current($this->ApiConfig->AppKey))));
		} else {
			ksort($paramArr);
			$sign = $this->JoinSign($paramArr);
			$sign = strtoupper(md5(current($this->ApiConfig->AppKey).$sign.current($this->ApiConfig->AppKey)));
		}

		return $sign;
	}



	public function SignVersion1($paramArr) {
		$sign = current($this->ApiConfig->AppKey);
		ksort($paramArr);
		$sign .= $this->JoinSign($paramArr);
		$sign = strtoupper(md5($sign));

		return $sign;
	}



	public function createSign($paramArr) {
		$Version = 'SignVersion'.intval($this->ApiConfig->Version);

		if(method_exists($this, $Version)) {
			$sign = $this->{$Version}($paramArr);
		}

		$this->_systemParam['sign'] = $sign;

		return $sign;
	}



	static public function createStrParam($paramArr) {
		$strParam = array();
		foreach($paramArr as $key => $val) {
			if($key != '' && $val != '') {
				$strParam [] = $key.'='.urlencode($val);
			}
		}

		return implode('&', $strParam);
	}



	private $_systemParam;



	public function check_num_iids($num_iids) {
		if($num_iids == '') {
			return $re = 'Missing required arguments:num_iids';
		}
		if(strpos($num_iids, ',') !== FALSE) {
			if(str_replace(',', '', $num_iids) == '') {
				return $re = 'Missing required arguments:num_iids';
			}
			$num_iids_arr = explode(',', $num_iids);
			foreach($num_iids_arr as $num_iid) {
				$num_iid   = (float)$num_iid;
				$num_iid_l = strlen($num_iid);
				if($num_iid <= 0 || ($num_iid_l < 8 || $num_iid_l > 12)) {
					return $re = 'invalid arguments:num_iids';
				}
			}
		} else {
			$num_iid   = (float)$num_iids;
			$num_iid_l = strlen($num_iid);
			if($num_iid <= 0 || ($num_iid_l < 8 || $num_iid_l > 12)) {
				return $re = 'invalid arguments:num_iids';
			}
		}
	}



	public function check_sids($sids) {
		if($sids == '') {
			return $re = 'Missing required arguments:sids';
		}
		if(strpos($sids, ',') !== FALSE) {
			if(str_replace(',', '', $sids) == '') {
				return $re = 'Missing required arguments:sids';
			}
			$sids_arr = explode(',', $sids);
			if(count(sids_arr) > 10) {
				return $re = 'invalid arguments:sids';
			}
			foreach($sids_arr as $sid) {
				$sid   = (float)$sid;
				$sid_l = strlen($sid);
				if(sid_l > 11) {
					return $re = 'invalid arguments:sids';
				}
				if($sid <= 0) {
					return $re = 'invalid arguments:sids';
				}
			}
		} else {
			$sid   = (float)$sids;
			$sid_l = strlen($sid);
			if(sid_l > 11) {
				return $re = 'invalid arguments:sids';
			}
			if($sid <= 0) {
				return $re = 'invalid arguments:sids';
			}
		}
	}



	public function check_users($users) {
		if($users == '') {
			return $re = 'Missing required arguments:users';
		}
		if(strpos($users, ',') !== FALSE) {
			if(str_replace(',', '', $users) == '') {
				return $re = 'Missing required arguments:users';
			}
			$users_arr = explode(',', $users);
			foreach($users_arr as $user) {
				if($user == '') {
					return $re = 'invalid arguments:users';
				}
			}
		} else {
			$user = $users;
			if($user == '') {
				return $re = 'invalid arguments:users';
			}
		}
	}



	public function check_error($paramArr) {
		$method        = $paramArr['method'];
		$re            = '';
		$sort_list_arr = array(
			'volume:desc'      => '销量从高→低',
			'volume:asc'       => '销量从低→高',
			'price:desc'       => '价格从高→低',
			'price:asc'        => '价格从低→高',
			'delist_time:desc' => '下架时间从高→低',
			'delist_time:asc'  => '下架时间从低→高',
		);

		switch($method) {
			case 'taobao.taobaoke.items.get':
				if($paramArr['keyword'] == '' && $paramArr['cid'] == '') {
					$re = 'Missing required arguments:cid or keyword';
				}
				if($paramArr['sort'] != '' && !array_key_exists($paramArr['sort'], $sort_list_arr)) {
					$re = $paramArr['sort'];
				}
				if(isset($paramArr['page_no']) && $paramArr['page_no'] > 10) {
					$re = 'max 10';
				}
				break;

			case 'taobao.items.get':
				if($paramArr['q'] == '' && $paramArr['cid'] == '') {
					$re = 'Missing required arguments:cid or q';
				}
				if($paramArr['sort'] != '' && !in_array($paramArr['sort'], $sort_list_arr)) {
					$paramArr['sort'] = $sort_list_arr[0];
				}
				if($paramArr['page_no'] > 10) {
					$re = 'max 10';
				}
				break;

			case 'taobao_items_search':
				if($paramArr['page_no'] > 99) {
					$re = 'max 99';
				}
				break;

			case 'taobao.users.get':
				$re = $this->check_users($paramArr['nicks']);
				break;

			case 'taobao.item.get':
				$re = $this->check_num_iids($paramArr['num_iid']);
				break;

			case 'taobao.taobaoke.items.convert':
				$re = $this->check_num_iids($paramArr['num_iids']);
				break;

			case 'taobao.taobaoke.items.detail.get':
				$re = $this->check_num_iids($paramArr['num_iids']);
				break;

			case 'taobao.taobaoke.shops.convert':
				if($paramArr['sids'] != '') {
					$re = $this->check_sids($paramArr['sids']);
				}
				if($paramArr['seller_nicks'] != '') {
					$re = $this->check_users($paramArr['seller_nicks']);
				}
				break;

			case 'taobao.shop.get':
				if($paramArr['nick'] == '') {
					$re = 'Missing required arguments:nick';
				}
				break;

			case 'taobao.user.get':
				if($paramArr['nick'] == '') {
					$re = 'Missing required arguments:nick';
				}
				break;

			case 'taobao.itemcats.get':
				if($paramArr['parent_cid'] == '' && $paramArr['cids'] == '') {
					$re = 'Missing required arguments:parent_cid or cids';
				}
				break;

			case 'taobao.taobaoke.listurl.get':
				if($paramArr['q'] == '') {
					$re = 'Missing required arguments:q';
				}
				break;

			case 'taobao.taobaoke.items.relate.get':
				if($paramArr['relate_type'] == 4 && is_numeric($paramArr['seller_id']) == '') {
					$re = 'miss seller_id';
				}
				break;

		}

		return $re;
	}



	public function getSend($paramArr) {
		$error = $this->check_error($paramArr);
		if($error == '') {
			//组织参数
			$this->_systemParam['sign'] = $this->createSign($paramArr);
			$paramArr['sign']           = $this->_systemParam['sign'];
			$strParam                   = $this->createStrParam($paramArr);
			$this->_systemParam['url']  = $this->ApiConfig->Url.'?'.$strParam;
			//访问服务
			$result = dd_get($this->_systemParam['url']);

			//if($paramArr['method']=='taobao.ump.promotion.get'){
			//				echo 1;
			//			}
			//			echo $this->_systemParam['url']."<br/><hr/>";
			//返回结果
			return $result;
		} else {
			//exit($error);
		}
	}



	/**
	 * 以POST方式访问api服务
	 *
	 * @param $paramArr：api参数数组
	 *
	 * @return $result
	 */
	public function postSend($paramArr) {
		//组织参数，Taoapi_Util类在执行submit函数时，它自动会将参数做urlencode编码，所以这里没有像以get方式访问服务那样对参数数组做urlencode编码
		$this->_systemParam['sign'] = $this->createSign($paramArr);
		$paramArr['sign']           = $this->_systemParam['sign'];
		$this->_systemParam['url']  = array($this->ApiConfig->Url, $paramArr);
		//访问服务
		self::$Taoapi_Util->submit($this->ApiConfig->Url, $paramArr);
		$result = self::$Taoapi_Util->results;

		//返回结果
		return $result;
	}



	/**
	 * 以POST方式访问api服务，带图片
	 *
	 * @param $paramArr：api参数数组
	 * @param $imageArr：图片的服务器端地址，如array('image' => '/tmp/cs.jpg')形式
	 *
	 * @return $result
	 */
	public function postImageSend($paramArr, $imageArr) {
		//组织参数
		$this->_systemParam['sign'] = $this->createSign($paramArr);
		$paramArr['sign']           = $this->_systemParam['sign'];
		//访问服务
		self::$Taoapi_Util->_submit_type = "multipart/form-data";
		$this->_systemParam['url']       = array($this->ApiConfig->Url, $paramArr, $imageArr);
		self::$Taoapi_Util->submit($this->ApiConfig->Url, $paramArr, $imageArr);
		$result = self::$Taoapi_Util->results;

		//返回结果
		return $result;
	}



	private function get_object_vars_final($obj) {
		if(is_object($obj)) {
			$obj = get_object_vars($obj);
		}

		if(is_array($obj)) {
			foreach($obj as $key => $value) {
				$obj[$key] = $this->get_object_vars_final($value);
			}
		}

		return $obj;
	}



	private function get_object_vars_final_coding($obj) {
		foreach($obj as $key => $value) {
			if(is_array($value)) {
				$obj[$key] = $this->get_object_vars_final_coding($value);
			} else {
				$obj[$key] = $this->FormatTaobaoData($value);
			}
		}

		return $obj;
	}



	public function getUrl() {
		return !empty($this->_systemParam['url']) ? $this->_systemParam['url'] : '';
	}



	public function getSign() {
		return !empty($this->_systemParam['sign']) ? $this->_systemParam['sign'] : '';
	}


}
define('REPLACE',0);
global $counttt;
$counttt = 0;
class ddTaoapi extends Taoapi {

	public $dduser;
	public $nowords;
	public $virtual_cid;
	public $format = 'json';
	public $jssdk_time = '';
	public $jssdk_sign = '';
	public $renminbi = 0; //是否显示原始返利

	function __construct() {
		parent::__construct();
		if(empty($this->nowords)) {
			if(REPLACE < 3) {
				$noword_tag = '';
			} else {
				$noword_tag = '3';
			}
			$this->nowords =json_decode('{"\u5356\u6deb":"****","\u529e\u5047\u8bc1":"****","\u529e\u7406\u672c\u79d1":"****","\u529e\u7406\u6c11\u529e\u5b66\u6821\u6587\u51ed":"****","\u529e\u7406\u6587\u51ed":"****","\u529e\u7406\u6587\u6191":"****","\u529e\u7406\u771f\u5b9e\u6587\u51ed":"****","\u529e\u7406\u8bc1\u4ef6":"****","\u529e\u7406\u4e13\u79d1":"****","\u529e\u8bc1\u670d\u52a1":"****","\u63d2\u5165\u723d\u7f51":"****","\u8d85\u723d\u89c6\u9891":"****","\u6210\u4eba\u7535\u5f71":"****","\u4ee3\u529e\u5047\u8bc1":"****","\u4ee3\u529e\u4fe1\u7528\u5361":"****","\u4ee3\u529e\u94f6\u884c\u5361":"****","\u4ee3\u5f00\u53d1\u7968":"****","\u4ee3\u8003\u7f51":"****","\u4ee3\u8003\u7f51\u7ad9":"****","\u5bf9\u5916\u529e\u7406\u53d1\u7968":"****","\u9ec4\u8272\u7535\u5f71":"****","\u9ec4\u8272\u6f2b\u753b":"****","\u9ec4\u8272\u56fe\u7247":"****","\u9ec4\u8272\u7f51\u7ad9":"****","\u6fc0\u60c5\u7535\u5f71":"****","\u6fc0\u60c5\u4f26\u7406\u7535\u5f71":"****","\u6fc0\u60c5\u89c6\u9891":"****","\u6fc0\u60c5\u89c6\u9891\u804a\u5929":"****","\u6fc0\u60c5\u56fe":"****","\u6fc0\u60c5\u56fe\u7247":"****","\u6fc0\u60c5\u5c0f\u7535\u5f71":"****","\u5bc2\u5bde\u5c11\u5987":"****","\u8003\u751f\u7b54\u7591":"****","\u8003\u8bd5\u7b54\u6848":"****","\u4f26\u7406\u7535\u5f71":"****","\u4f26\u7406\u7535\u5f71\u5728\u7ebf":"****","\u7a83\u542c\u5668\u6750":"****","\u60c5\u8272":"****","\u60c5\u8272\u516d\u6708\u5929":"****","\u60c5\u8272\u56fe\u7247":"****","\u60c5\u8272\u4e94\u6708\u5929":"****","\u53d6\u5f97\u672c\u79d1":"****","\u53d6\u5f97\u4e13\u79d1":"****","\u5168\u56fd\u529e\u8bc1":"****","\u70ed\u8fa3\u7f8e\u56fe":"****","\u4eba\u4f53\u5199\u771f":"****","\u4eba\u4f53\u827a\u672f":"****","\u4e09\u5511\u4ed1":"****","\u6851\u62ff\u4e00\u6761\u9f99":"****","\u8272\u7535\u5f71":"****","\u8272\u754c":"****","\u8272\u60c5\u7f51\u7ad9":"****","\u8272\u5c0f\u8bf4":"****","\u8272\u8bf1":"****","\u4e0a\u6d77\u4e1d\u8db3\u6309\u6469":"****","\u5c11\u513f\u52ff\u5165":"****","\u5c11\u5973\u521d\u591c\u723d\u7247":"****","\u5c11\u5973\u9ad8\u6f6e":"****","\u5c11\u5973\u56fe\u7247":"****","\u58f0\u8272\u573a\u6240":"****","\u89c6\u9891\u6fc0\u60c5":"****","\u624b\u673a\u5b9a\u4f4d\u5668":"****","\u624b\u673a\u590d\u5236":"****","\u624b\u673a\u76d1\u542c":"****","\u624b\u673a\u76d1\u542c\u5668":"****","\u7f51\u4e0a\u529e\u8bc1":"****","\u6211\u8981\u8272\u56fe":"****","\u897f\u73ed\u7259\u82cd\u8747\u6c34":"****","\u6210\u4eba\u7528\u54c1":"****","\u786c\u5e01":"****","\u767e\u5bb6\u4e50":"****","\u7535\u5b50\u72d7":"****","\u7f51\u8d5a":"****"}', 1);;
		}
		if(empty($this->virtual_cid)) {
			$this->virtual_cid = array('goods' => array(0 => 150401, 1 => 150402, 2 => 50011814, 3 => 150406), 'shop' => array(1103, 1041, 1102, 35, 36));
		}
	}



	function tbfenduan($val, $arr = array(), $level = 0) {
		if($this->renminbi == 0) {
			$a = fenduan($val, $arr, $level, TBMONEYBL);

			return data_type($a, TBMONEYTYPE);
		} else {
			return $a = fenduan($val, $arr, $level, 1);
		}
	}



	function taobao_taobaoke_items_get($Tapparams) {

		/*if(isset($Tapparams['tag'])){
			$a=def($Tapparams['tag'],array(),array('page_size'=>$Tapparams['page_size']));
			if($a['page_size']>0){
				$Tapparams['page_size']=$a['page_size'];
				$tag_goods=$a['goods'];
			}
		}*/

		if($Tapparams['keyword'] == '' && $Tapparams['cid'] == '') {
			return 'miss keyword or cid';
		}
		$this->method = 'taobao.taobaoke.items.get';
		if(!isset($Tapparams['fields']) || $Tapparams['fields'] == '') {
			$Tapparams['fields'] = 'num_iid,title,cid,nick,seller_credit_score,pic_url,price,click_url,shop_click_url,volume,commission,commission_rate,commission_num,commission_volume,item_location';
		}
		$this->fields = $Tapparams['fields'];
		if(isset($Tapparams['keyword'])) {
			$this->keyword = $Tapparams['keyword'];
		}
		if(isset($Tapparams['cid'])) {
			$this->cid = $Tapparams['cid'];
		}
		$this->page_size = $Tapparams['page_size'];
		if(isset($Tapparams['page_no'])) {
			$this->page_no = $Tapparams['page_no'];
		}
		if(isset($Tapparams['sort'])) {
			$this->sort = $Tapparams['sort'];
		} else {
			$this->sort = 'commissionNum_desc';
		}
		if(isset($Tapparams['start_credit'])) {
			$this->start_credit = $Tapparams['start_credit'];
		}
		if(isset($Tapparams['end_credit'])) {
			$this->end_credit = $Tapparams['end_credit'];
		}
		if(isset($Tapparams['start_price'])) {
			$this->start_price = $Tapparams['start_price'];
		}
		if(isset($Tapparams['end_price'])) {
			$this->end_price = $Tapparams['end_price'];
		}
		if(isset($Tapparams['area'])) {
			$this->area = $Tapparams['area'];
		}
		if(isset($Tapparams['mall_item'])) {
			$this->mall_item = $Tapparams['mall_item'];
		}
		if(isset($Tapparams['outer_code'])) {
			$this->outer_code = $Tapparams['outer_code'];
		}
		if(isset($Tapparams['is_mobile'])) {
			$this->is_mobile = $Tapparams['is_mobile'];
		}

		$TaobaokeData  = $this->Send('get', $this->format)->getArrayData();
		$TaobaokeItem1 = $TaobaokeData["taobaoke_items"]["taobaoke_item"];
		if(isset($tag_goods) && is_array($tag_goods) && !empty($tag_goods)) {
			$TaobaokeItem1 = array_merge($tag_goods, $TaobaokeItem1);
		}

		$TotalResults = $TaobaokeData["total_results"];
		if(!is_array($TaobaokeItem1[0])) {
			$TaobaokeItem[0] = $TaobaokeItem1;
		} else {
			$TaobaokeItem = $TaobaokeItem1;
		}

		if($TotalResults > 0) {
			$TaobaokeItem = $this->do_TaobaokeItem($TaobaokeItem);
			if(isset($Tapparams['total'])) {
				$TaobaokeItem['total'] = $TotalResults ? $TotalResults : 0;
			}

			return $TaobaokeItem;
		} else {
			return 102;
		}
	}



	function do_TaobaokeItem($TaobaokeItem, $type = 0) { //type特别类型，打折页面是否强制缓存
		foreach($TaobaokeItem as $k => $row) {
			if(array_key_exists('coupon_rate', $row)) {
				if($row['coupon_end_time'] > '2038-01-01 00:00:00') {
					$TaobaokeItem[$k]['coupon_end_time'] = '2038-01-01 00:00:00';
				}
				$end_time                              = strtotime($TaobaokeItem[$k]['coupon_end_time']);
				$TaobaokeItem[$k]["coupon_commission"] = round($TaobaokeItem[$k]["commission"] * ($row['coupon_price'] / $row['price']), 2);
				$TaobaokeItem[$k]['coupon_fxje']       = $this->tbfenduan($TaobaokeItem[$k]["coupon_commission"], $this->ApiConfig->fxbl, $this->dduser['level']);
				if($type == 1) {
					$data     = array('name' => '打折促销', 'end_time' => $end_time, 'price' => $row['coupon_price']);
					$dir      = $this->ApiConfig->CachePath.'/cuxiao/'.substr($row['num_iid'], 0, 3).'/'.substr($row['num_iid'], 3, 3).'/'.substr($row['num_iid'], -5);
					$filename = $dir.'_'.$data['end_time'].'.php';
					$content  = json_encode($data);
					$c        = "<?php\r\nreturn '".$content."';";
					create_file($filename, $c, 0, 1);
				}
			}
			$TaobaokeItem[$k]['fxje']    = $this->tbfenduan($TaobaokeItem[$k]["commission"], $this->ApiConfig->fxbl, $this->dduser['level']);
			$TaobaokeItem[$k]['fx_rate'] = fenduan($TaobaokeItem[$k]["commission_rate"], $this->ApiConfig->fxbl, $this->dduser['level']) / 100;
			$TaobaokeItem[$k]["title"]   = dd_replace($TaobaokeItem[$k]["title"], $this->nowords);
			if(array_key_exists('shop_type', $row)) {
				if($row['shop_type'] == 'C') {
					$TaobaokeItem[$k]['level'] = $row['seller_credit_score'];
				} elseif($row['shop_type'] == 'B') {
					$TaobaokeItem[$k]['level'] = 21;
				}
			}
			if(isset($row['seller_credit_score'])) {
				$TaobaokeItem[$k]['level'] = $row['seller_credit_score'];
			}

			$TaobaokeItem[$k]['name']     = strip_tags($TaobaokeItem[$k]['title']);
			$TaobaokeItem[$k]['name_url'] = urlencode($TaobaokeItem[$k]['name']);

			if(isset($TaobaokeItem[$k]['coupon_price']) && $TaobaokeItem[$k]['coupon_price'] > 0) {
				$TaobaokeItem[$k]['jump']    = "index.php?mod=jump&act=goods&url=".urlencode(base64_encode($TaobaokeItem[$k]["click_url"])).'&pic='.urlencode(base64_encode($TaobaokeItem[$k]["pic_url"].'_100x100.jpg')).'&iid='.$TaobaokeItem[$k]['num_iid'].'&fan='.$TaobaokeItem[$k]["fxje"].'&price='.$TaobaokeItem[$k]["price"].'&name='.$TaobaokeItem[$k]["name_url"].'&coupon_price='.$TaobaokeItem[$k]['coupon_price'].'&coupon_end_time='.$TaobaokeItem[$k]['coupon_end_time'];
				$TaobaokeItem[$k]['go_view'] = u('tao', 'view', array('iid' => $TaobaokeItem[$k]["num_iid"], 'promotion_price' => $TaobaokeItem[$k]['coupon_price'], 'promotion_endtime' => $end_time));
			} else {
				$TaobaokeItem[$k]['jump']    = "index.php?mod=jump&act=goods&url=".urlencode(base64_encode($TaobaokeItem[$k]["click_url"])).'&pic='.urlencode(base64_encode($TaobaokeItem[$k]["pic_url"].'_100x100.jpg')).'&iid='.$TaobaokeItem[$k]['num_iid'].'&fan='.$TaobaokeItem[$k]["fxje"].'&price='.$TaobaokeItem[$k]["price"].'&name='.$TaobaokeItem[$k]["name_url"];
				$TaobaokeItem[$k]['go_view'] = u('tao', 'view', array('iid' => $TaobaokeItem[$k]["num_iid"]));
			}

			if(WEBTYPE == '0') {
				$TaobaokeItem[$k]['gourl']   = $TaobaokeItem[$k]['jump'];
				$TaobaokeItem[$k]['go_shop'] = u('tao', 'shop', array('nick' => $TaobaokeItem[$k]["nick"]));
			} else {
				$TaobaokeItem[$k]['gourl']   = $TaobaokeItem[$k]['go_view'];
				$TaobaokeItem[$k]['go_shop'] = u('tao', 'shop', array('nick' => $TaobaokeItem[$k]["nick"]));
			}
		}

		/*if($type==1 && !empty(coupon_cahche_arr)){
		    make_cache_arr(DDROOT.'/data/Apicache/cuxiao','');
		}*/

		return $TaobaokeItem;
	}



	function taobao_items_get($Tapparams) {
		if($Tapparams['keyword'] == '' && $Tapparams['cid'] == '') {
			return 101;
		}
		$this->method = 'taobao.items.get';
		if(!isset($Tapparams['fields']) || $Tapparams['fields'] == '') {
			$this->fields = 'iid,detail_url,num_iid,title,nick,type,cid,seller_cids,props,input_pids,input_str,desc,pic_path,num,valid_thru,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,has_showcase,modified,increment,auto_repost,approve_status,postage_id,product_id,auction_point,property_alias,itemimg,propimg,sku,outer_id,is_virtural,is_taobao,is_ex,video';
		}
		$this->fields = $Tapparams['fields'];
		if(isset($Tapparams['keyword'])) {
			$this->q = $Tapparams['keyword'];
		}
		if(isset($Tapparams['cid'])) {
			$this->cid = $Tapparams['cid'];
		}
		$this->page_size = $Tapparams['page_size'];
		if(isset($Tapparams['page_no'])) {
			$this->page_no = $Tapparams['page_no'];
		}
		if(isset($Tapparams['sort'])) {
			$this->sort = $Tapparams['sort'];
		} else {
			$this->sort = 'commissionNum_desc';
		}
		if(isset($Tapparams['start_credit'])) {
			$this->start_credit = $Tapparams['start_credit'];
		}
		if(isset($Tapparams['end_credit'])) {
			$this->end_credit = $Tapparams['end_credit'];
		}
		if(isset($Tapparams['start_price'])) {
			$this->start_price = $Tapparams['start_price'];
		}
		if(isset($Tapparams['end_price'])) {
			$this->end_price = $Tapparams['end_price'];
		}
		if(isset($Tapparams['area'])) {
			$this->area = $Tapparams['area'];
		}
		if(isset($Tapparams['mall_item'])) {
			$this->mall_item = $Tapparams['mall_item'];
		}
		$TaobaokeData  = $this->Send('get', $this->format)->getArrayData();
		$TaobaokeItem1 = $TaobaokeData["items"]["item"];
		$TotalResults  = $TaobaokeData["total_results"];
		if(!is_array($TaobaokeItem1[0])) {
			$TaobaokeItem[0] = $TaobaokeItem1;
		} else {
			$TaobaokeItem = $TaobaokeItem1;
		}
		foreach($TaobaokeItem as $k => $row) {
			$TaobaokeItem[$k]['fxje']      = 0;
			$TaobaokeItem[$k]["title"]     = dd_replace($TaobaokeItem[$k]["title"], $this->nowords);
			$TaobaokeItem[$k]['name']      = strip_tags($TaobaokeItem[$k]['title']);
			$TaobaokeItem[$k]['name_url']  = urlencode($TaobaokeItem[$k]['name']);
			$TaobaokeItem[$k]['click_url'] = $TaobaokeItem[$k]['detail_url'];
			$TaobaokeItem[$k]['jump']      = "index.php?mod=jump&act=goods&url=".urlencode(base64_encode($TaobaokeItem[$k]["click_url"])).'&pic='.urlencode(base64_encode($TaobaokeItem[$k]["pic_url"].'_100x100.jpg')).'&iid='.$TaobaokeItem[$k]['num_iid'].'&fan=0&price='.$TaobaokeItem[$k]["price"].'&name='.$TaobaokeItem[$k]["name_url"];
			$TaobaokeItem[$k]['go_view']   = u('tao', 'view', array('iid' => $TaobaokeItem[$k]["num_iid"]));

			if(WEBTYPE == '0') {
				$TaobaokeItem[$k]['gourl']   = $TaobaokeItem[$k]['jump'];
				$TaobaokeItem[$k]['go_shop'] = u('shop', 'list', array('nick' => $TaobaokeItem[$k]["nick"]));
			} else {
				$TaobaokeItem[$k]['gourl']   = $TaobaokeItem[$k]['go_view'];
				$TaobaokeItem[$k]['go_shop'] = u('tao', 'shop', array('nick' => $TaobaokeItem[$k]["nick"]));
			}
		}
		if(isset($Tapparams['total'])) {
			$TaobaokeItem['total'] = $TotalResults ? $TotalResults : 0;
		}
		if($TotalResults > 0) {
			return $TaobaokeItem;
		} else {
			return 102;
		}
	}



	function taobao_itemcat_msg($cid, $fields = 'cid,parent_cid,name,is_parent') {
		$this->method = 'taobao.itemcats.get';
		$this->fields = $fields;
		$this->cids   = $cid;
		$TaobaokeData = $this->Send('get', $this->format)->getArrayData();
		$TaobaokeItem = $TaobaokeData["item_cats"]["item_cat"];

		return $TaobaokeItem[0];
	}



	function taobao_itemcats_get($cid) {
		$TaobaokeItem = $this->taobao_itemcat_msg($cid);

		if($TaobaokeItem['is_parent'] == 'true') $cid = $cid;
		elseif($TaobaokeItem['parent_cid'] > 0) $cid = $TaobaokeItem['parent_cid'];

		if($cid) {
			$this->method     = 'taobao.itemcats.get';
			$this->cids       = '';
			$this->parent_cid = $cid;
			$this->fields     = 'cid,parent_cid,name,is_parent';
			$TaobaokeData     = $this->Send('get', $this->format)->getArrayData();
			$TaobaokeItem     = $TaobaokeData["item_cats"]["item_cat"];

			return $TaobaokeItem;
		}
	}



	function taobao_itemcats($cid) {
		$this->method     = 'taobao.itemcats.get';
		$this->cids       = '';
		$this->parent_cid = $cid;
		$this->fields     = 'cid,parent_cid,name,is_parent';
		$TaobaokeData     = $this->Send('get', $this->format)->getArrayData();
		$TaobaokeItem     = $TaobaokeData["item_cats"]["item_cat"];

		return $TaobaokeItem;
	}



	function taobao_users_get($nicks) {
		$this->method  = 'taobao.users.get';
		$this->fields  = 'user_id,nick,seller_credit,location,type';
		$this->nicks   = $nicks;
		$TaoapiUsers   = $this->Send('get', $this->format)->getArrayData();
		$Result_users1 = $TaoapiUsers["users"]["user"];
		if(!is_array($Result_users1[0])) {
			$Result_users[0] = $Result_users1;
		} else {
			$Result_users = $Result_users1;
		}

		return $Result_users;
	}



	function taobao_item_get($Tapparams) {
		$iid        = $Tapparams['iid'];
		$goods_type = $Tapparams['goods_type'];
		$ju_price   = $Tapparams['ju_price'];
		$fields     = $Tapparams['fields'] ? $Tapparams['fields'] : 'iid,detail_url,num_iid,pic_url,title,nick,type,cid,seller_cids,num,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,item_img';

		$this->method  = 'taobao.item.get';
		$this->fields  = $fields;
		$this->num_iid = $iid;
		$TaobaoData    = $this->Send('get', $this->format)->getArrayData();
		exit((string)__LINE__);
		$a             = $TaobaoData['item'];
		if($a['title'] == '') {
			return 102;
		}
		/*else{
			if(isset($a['item_imgs']['item_img'][0])){
			    $a['pic_url']=$a['item_imgs']['item_img'][0]['url'];
			}
			elseif(isset($a['item_imgs']['item_img']['url'])){
			    $a['pic_url']=$a['item_imgs']['item_img']['url'];
			}
		}*/
		$a['freight_payer'] = $a['freight_payer'] == 'seller' ? '卖家承担' : '买家承担';
		$a['notaoke']       = 1;
		if($goods_type == 'ju') {
			$a['price']         = $ju_price;
			$a['ju_commission'] = $a['price'] * $this->ApiConfig->ju_commission_rate; //聚划算全站佣金
			$a['ju_fxje']       = $this->tbfenduan($a['ju_commission'], $this->ApiConfig->fxbl, $this->dduser['level']);
		} elseif($goods_type == 'tmall') {
			$a['tmall_commission'] = $a['price'] * $this->ApiConfig->tmall_commission_rate; //天猫全站佣金
			$a['tmall_fxje']       = $this->tbfenduan($a['tmall_commission'], $this->ApiConfig->fxbl, $this->dduser['level']);
		}
		$a['title'] = dd_replace($a['title'], $this->nowords);
		$a['desc']  = dd_replace($a['desc'], $this->nowords);
		$a['jump']  = 'http://item.taobao.com/item.htm?id='.$iid;

		return $a;

		/*//查询是否有缓存数据
		$cacheid=array ( 'method' => 'taobao.item.get', 'fields' => $fields, 'num_iid' => $iid, 'format' => $this->format, 'v' => '2.0', 'sign_method' => 'md5') ;
		$cacheid = md5($this->createStrParam($cacheid));
		$taobaoData=$this->Cache->getCacheData($cacheid,'taobao.item.get');
		if($taobaoData!=''){
		    $xmlCode = simplexml_load_string($taobaoData, 'SimpleXMLElement', LIBXML_NOCDATA);
		    $taobaoData = self::$collect->get_object_vars_final($xmlCode);
		    return $taobaoData['item'];
		}

		$url='http://item.taobao.com/item.htm?id='.$iid; //检测商品是否存在，避免api错误
		self::$collect->get($url);
		$html=self::$collect->val;
		if(strpos($html,'http://img01.taobaocdn.com/tps/i1/T1CXucXf4vXXXXXXXX-51-63.png')!==false){
		    return 102; //商品不存在
		}
		else{
		    $this->method = 'taobao.item.get';
            $this->fields = $fields;
            $this->num_iid = $iid;
		    $TaobaoData = $this->Send('get',$this->format)->getArrayData();
		    return $TaobaoData['item'];
		}*/
	}



	function taobao_taobaoke_items_detail_get($Tapparams) {
		$this->method     = 'taobao.taobaoke.items.detail.get';
		$this->num_iids   = $Tapparams['iid'];
		$this->outer_code = $Tapparams['outer_code'];
		if(isset($Tapparams['is_mobile']) && $Tapparams['is_mobile'] == 1) {
			$this->is_mobile = 'true';
		}
		if($Tapparams['fields'] != '') {
			$this->fields = $Tapparams['fields'];
		} else {
			$this->fields = 'iid,detail_url,num_iid,title,nick,type,cid,desc,pic_url,num,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,seller_credit_score,shop_click_url,click_url,volume,stuff_status,has_invoice,cid,auction_point';
		}
		$TaobaokeData = $this->Send('get', $this->format)->getArrayData();
		$goods        = $TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"][0]['item'];

		if(strpos($goods['title'], "'") !== FALSE) {
			$goods['title'] = str_replace("'", '', $goods['title']);
		}

		if($goods['title'] != '') {
			if(strpos($goods['title'], '&amp;')) {
				$goods['title'] = str_replace('&amp;', '&', $goods['title']);
			}
			$goods['click_url']           = $TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"][0]['click_url'];
			$goods['seller_credit_score'] = $TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"][0]['seller_credit_score'];
			$goods['shop_click_url']      = $TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"][0]['shop_click_url'];
		}

		if($goods['title'] == '') { //商品没有返利也获取商品信 推广链接跟商品链接相同
			$TaobaoData = $this->taobao_item_get($Tapparams);
			if($TaobaoData == 102) {
				return 102;
			}
			$TaobaoData['click_url'] = $TaobaoData['detail_url'];
			$goods                   = $TaobaoData;
		}

		exit((string)__LINE__);
		if($goods['title'] != '') {
			if($goods['freight_payer'] == "seller") {
				$goods['freight_payer'] = "卖家承担";
			} else {
				$goods['freight_payer'] = "买家承担";
			}
			$goods['desc']  = preg_replace("/<a [^>]*>|<\/a>/", "", $goods['desc']);
			$goods['desc']  = preg_replace("/<map(.*)<\/map>/", "", $goods['desc']);
			$goods['title'] = dd_replace($goods['title'], $this->nowords);
			$goods['desc']  = dd_replace($goods['desc'], $this->nowords);
		} else {
			$goods = 102;
		}

		return $goods;
	}



	function items_detail_get_iids($Tapparams) {
		$goods            = array();
		$this->method     = 'taobao.taobaoke.items.detail.get';
		$this->num_iids   = $Tapparams['iids'];
		$this->outer_code = $Tapparams['outer_code'];
		if(isset($Tapparams['fields']) && $Tapparams['fields'] != '') {
			$this->fields = $Tapparams['fields'];
		} else {
			$this->fields = 'num_iid,title,nick,cid,pic_url,num,location,price,seller_credit_score,shop_click_url,click_url,volume';
		}

		$TaobaokeData = $this->Send('get', $this->format)->getArrayData();
		if(isset($TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"])) {
			$goods = $TaobaokeData["taobaoke_item_details"]["taobaoke_item_detail"];

			foreach($goods as $k => $row) {
				$goods[$k] = $row['item'];
				unset($goods[$k]['item']);
			}
		}

		return $goods;
	}



	function taobao_items_list_get($Tapparams) {
		$goods          = array();
		$this->method   = 'taobao.items.list.get';
		$this->num_iids = $Tapparams['iids'];
		if(isset($Tapparams['fields']) && $Tapparams['fields'] != '') {
			$this->fields = $Tapparams['fields'];
		} else {
			$this->fields = 'num_iid,title,nick,cid,pic_url,num,location,price,seller_credit_score,shop_click_url,click_url,volume';
		}

		$TaobaokeData = $this->Send('get', $this->format)->getArrayData();

		if(isset($TaobaokeData["items"]["item"])) {
			$goods = $TaobaokeData["items"]["item"];
		}

		return $goods;
	}



	function taobao_taobaoke_items_convert($iid, $outer_code = '') {
		$iid_arr = str2arr($iid, 20);
		$a       = array();
		foreach($iid_arr as $v) {
			$this->method = 'taobao.taobaoke.items.convert';
			$this->fields = 'commission,commission_num,commission_rate,commission_volume,num_iid,click_url';
			if($outer_code != '') {
				$this->outer_code = $outer_code;
			}
			$this->num_iids = $v;
			$CommData       = $this->Send('get', $this->format)->getArrayData();
			$a1             = $CommData['taobaoke_items']['taobaoke_item'];
			$a              = array_merge($a, $a1);
		}

		return $a;
	}



	function taobao_user_get($nick) {
		$this->method         = 'taobao.user.get';
		$this->fields         = 'user_id,nick,good_num,total_num,seller_credit,location,type';
		$this->nick           = $nick;
		$TaoapiUsers          = $this->Send('get', $this->format)->getArrayData();
		$Result_users         = $TaoapiUsers["user"];
		$sellers['uid']       = $Result_users["user_id"];
		$sellers['type']      = $Result_users["type"];
		$sellers['level']     = $Result_users["seller_credit"]["level"];
		$sellers['good_num']  = $Result_users["seller_credit"]["good_num"];
		$sellers['total_num'] = $Result_users["seller_credit"]["total_num"];
		$sellers['score']     = $Result_users["seller_credit"]["score"];
		$sellers['state']     = $Result_users["location"]['state'];
		$sellers['city']      = $Result_users["location"]['city'];
		$sellers['type']      = $Result_users["type"]; //B(商城用户),C(普通卖家)
		$sellers['nick']      = $nick;

		return $sellers;
	}



	function taobao_shop_get($nick) {
		$this->method           = 'taobao.shop.get';
		$this->fields           = 'sid,cid,title,pic_path,created,shop_score,nick'; //没有获取desc字段，如果这个字段带有回车符（测试掌柜：李海燕008），会造成json无法解析
		$this->nick             = $nick;
		$ShopData               = $this->Send('get', $this->format)->getArrayData();
		$Result_shop            = $ShopData['shop'];
		$info['logo']           = TAOLOGO.$Result_shop['pic_path'];
		$info['pic_path']       = $Result_shop['pic_path'];
		$info['onerror']        = 'images/tbdp.gif';
		$info['cid']            = $Result_shop['cid'];
		$info['sid']            = $Result_shop['sid'];
		$info['item_score']     = $Result_shop["shop_score"]["item_score"];
		$info['service_score']  = $Result_shop["shop_score"]["service_score"];
		$info['delivery_score'] = $Result_shop["shop_score"]["delivery_score"];
		$info['created']        = $Result_shop['created'];
		$info['title']          = $Result_shop['title'];
		$info['nick']           = $Result_shop['nick'];
		if($info['nick'] == '') {
			return 104;
		} else {
			return $info;
		}
	}



	function taobao_taobaoke_shops_convert($Tapparams) {
		$this->method     = 'taobao.taobaoke.shops.convert';
		$this->fields     = 'commission_rate,click_url,user_id,shop_title,seller_credit,seller_nick,shop_type,auction_count,shop_id,total_auction';
		$this->outer_code = $Tapparams['outer_code'];
		$shopinfo         = array();
		if($Tapparams['nick'] != '') {
			$nick_arr = explode(',', $Tapparams['nick']);
			$strnicks = '';
			$i        = 0;
			if(count($nick_arr) > 10) {
				foreach($nick_arr as $v) {
					$strnicks .= $v.',';
					if($i == 9) {
						$strnicks      = preg_replace('/,$/', '', $strnicks);
						$nicks_array[] = $strnicks;
						$i             = -1;
						$strnicks      = '';
					}
					$i++;
				}
				$strnicks = preg_replace('/,$/', '', $strnicks);
				if($strnicks != '') {
					$nicks_array[] = $strnicks;
				}
			} else {
				$nicks_array[] = $Tapparams['nick'];
			}
			foreach($nicks_array as $strnicks) {
				$this->method       = 'taobao.taobaoke.shops.convert';
				$this->fields       = 'commission_rate,click_url,user_id,shop_title,seller_credit,seller_nick,shop_type,auction_count,shop_id,total_auction';
				$this->outer_code   = $Tapparams['outer_code'];
				$this->seller_nicks = $strnicks;
				$data               = $this->Send('get', $this->format)->getArrayData();
				$shopinfo1          = $data['taobaoke_shops']['taobaoke_shop'];
				$shopinfo           = array_merge($shopinfo, $shopinfo1);
			}
		} else {
			$this->sids = $Tapparams['sid'];
			$data       = $this->Send('get', $this->format)->getArrayData();
			$shopinfo   = $data['taobaoke_shops']['taobaoke_shop'];
		}

		return $shopinfo;
	}



	function taobao_taobaoke_shop($nick) {
		$shop = $this->taobao_shop_get($nick);
		if($shop['nick'] == '') { //昵称不存在
			return 104;
		}
		if($shop['type'] == 'B') {
			$shop['level'] = 21;
		}
		$a        = $this->taobao_taobaoke_shops_convert(array('sid' => $shop['sid'], 'outer_code' => $this->dduser['id']));
		$ShopComm = $a[0]; //echo $ShopComm['commission_rate'];
		if($ShopComm['user_id'] > 0) {
			$shop['uid'] = $ShopComm['user_id'];
		}
		$shop['type'] = $ShopComm['shop_type'];
		if($shop['type'] == 'B') {
			$shop['level'] = 21;
		} else {
			$shop['level'] = $ShopComm['seller_credit'];
		}
		$shop['auction_count'] = $ShopComm['auction_count'];
		$shop['total_auction'] = $ShopComm['total_auction'];
		$shop['fanxianlv']     = (float)$ShopComm['commission_rate'];
		if(in_array($shop['cid'], $this->virtual_cid['shop'])) { //虚拟商品返利强制为0
			$shop['shop_click_url'] = 'http://shop'.$shop['sid'].'.taobao.com/';
			$shop['fanxianlv']      = 0;
			$shop['taoke']          = 0;
		} elseif($shop['fanxianlv'] > 0) {
			$shop['shop_click_url'] = $ShopComm['click_url'];
			$shop['taoke']          = 1;
		} elseif($shop['level'] == 21) {
			$shop['shop_click_url'] = $this->taobao_taobaoke_t9('http://shop'.$shop['sid'].'.taobao.com/', $this->dduser['id']);
			$shop['fanxianlv']      = $this->ApiConfig->tmall_commission_rate * 100;
			$shop['taoke']          = 0;
		} else {
			$shop['shop_click_url'] = 'http://shop'.$shop['sid'].'.taobao.com/';
			$shop['fanxianlv']      = 0;
			$shop['taoke']          = 0;
		}
		if(defined('INDEX')) {
			$shop['fxbl'] = $this->tbfenduan($shop['fanxianlv'], $this->ApiConfig->fxbl, $this->dduser['level']);
		}
		if(is_array($shop['pic_path'])) {
			if($shop['level'] == 21) {
				$shop['pic_path'] = 'images/tbsc.gif';
			} else {
				$shop['pic_path'] = 'images/tbdp.gif';
			}
		}

		return $shop;
	}



	function taobao_items_search($Tapparams) {
		$this->method      = 'taobao.items.search';
		$this->fields      = 'iid,num_iid,title,pic_url,price,volume';
		$this->q           = $Tapparams['q'];
		$this->nicks       = $Tapparams['nick'];
		$this->start_score = $Tapparams['start_credit'];
		$this->end_score   = $Tapparams['end_credit'];
		$this->start_price = $Tapparams['start_price'];
		$this->end_price   = $Tapparams['end_price'];
		$this->order_by    = $Tapparams['sort'];
		$this->post_free   = $Tapparams['post_free'];
		$this->page_no     = $Tapparams['page_no'];
		$this->page_size   = $Tapparams['page_size'];
		$TaobaokeData_shop = $this->Send('get', $this->format)->getArrayData();
		$TaobaokeItem1     = $TaobaokeData_shop['item_search']['items']['item'];
		$TotalResults      = $TaobaokeData_shop['total_results'];
		if(!is_array($TaobaokeItem1[0])) {
			$TaobaokeItem[0] = $TaobaokeItem1;
		} else {
			$TaobaokeItem = $TaobaokeItem1;
		}
		if($Tapparams['total']) {
			$TaobaokeItem['total'] = $TotalResults;
		}

		return $TaobaokeItem;
	}



	function taobao_taobaoke_report_get($sj = '', $page_no = 1) {
		if($sj == '') $sj = date("Ymd");
		$this->method    = 'taobao.taobaoke.report.get';
		$this->fields    = 'app_key,outer_code,trade_id,pay_time,create_time,pay_price,num_iid,item_title,item_num,category_id,category_name,shop_title,commission_rate,commission,iid,seller_nick,real_pay_fee';
		$this->date      = $sj;
		$this->page_no   = $page_no;
		$this->page_size = TAO_REPORT_GET_NUM;
		$TaobaokeData    = $this->Send('get', $this->format)->getArrayData();
		if(isset($TaobaokeData['code'])) {
			print_r($this->_errorInfo->getErrorInfo());
			print_r($TaobaokeData);
			exit;
		}
		$TaobaokeItem1 = $TaobaokeData['taobaoke_report']['taobaoke_report_members']['taobaoke_report_member'];
		//$total_results=$TaobaokeData['taobaoke_report']['total_results'];
		if(!is_array($TaobaokeItem1[0])) {
			if(empty($TaobaokeItem1)) {
				$TaobaokeItem = array();
			} else {
				$TaobaokeItem[0] = $TaobaokeItem1;
			}

		} else {
			$TaobaokeItem = $TaobaokeItem1;
		}

		//$TaobaokeItem['total']=$total_results;
		return $TaobaokeItem;
	}



	function shop_items_get($Tapparams) {
		$Tapparams['relate_type'] = 4;
		$Tapparams['seller_id']   = $Tapparams['uid'];
		$Tapparams['max_count']   = $Tapparams['count'] ? $Tapparams['count'] : 40;
		$TaobaokeItem             = $this->taobao_taobaoke_items_relate_get($Tapparams);

		if(isset($Tapparams['taoke']) && $Tapparams['taoke'] == 1 && !empty($TaobaokeItem)) {
			foreach($TaobaokeItem as $k => $row) {
				$TaobaokeItem[$k]['fxje']     = $this->tbfenduan($TaobaokeItem[$k]["commission"], $this->ApiConfig->fxbl, $this->dduser['level']);
				$TaobaokeItem[$k]["title"]    = dd_replace($TaobaokeItem[$k]["title"], $this->nowords);
				$TaobaokeItem[$k]['name']     = strip_tags($TaobaokeItem[$k]['title']);
				$TaobaokeItem[$k]['name_url'] = urlencode($TaobaokeItem[$k]['name']);
				$TaobaokeItem[$k]['jump']     = "index.php?mod=jump&act=goods&url=".urlencode(base64_encode($TaobaokeItem[$k]["click_url"])).'&pic='.urlencode(base64_encode($TaobaokeItem[$k]["pic_url"].'_100x100.jpg')).'&iid='.$TaobaokeItem[$k]['num_iid'].'&fan='.$TaobaokeItem[$k]["fxje"].'&price='.$TaobaokeItem[$k]["price"].'&name='.$TaobaokeItem[$k]["name_url"];
				$TaobaokeItem[$k]['go_view']  = u(
					'tao', 'view', array(
						'iid' => $TaobaokeItem[$k]["num_iid"]
					)
				);
				$TaobaokeItem[$k]['go_shop']  = u(
					'tao', 'shop', array(
						'nick' => $Tapparams["nick"]
					)
				);
				$TaobaokeItem[$k]['nick']     = $Tapparams['nick'];
				if(WEBTYPE == '0') {
					$TaobaokeItem[$k]['gourl'] = $TaobaokeItem[$k]['jump'];
				} else {
					$TaobaokeItem[$k]['gourl'] = $TaobaokeItem[$k]['go_view'];
				}
				$TaobaokeItem[$k]['nick'] = $Tapparams['nick'];
			}
		} elseif($Tapparams['shoplevel'] == 21 && !empty($TaobaokeItem)) { //商城商品，有补贴
			foreach($TaobaokeItem as $k => $row) {
				$TaobaokeItem[$k]["commission"] = $TaobaokeItem[$k]["price"] * $this->ApiConfig->tmall_commission_rate;
				$TaobaokeItem[$k]['fxje']       = $this->tbfenduan($TaobaokeItem[$k]["commission"], $this->ApiConfig->fxbl, $this->dduser['level']);
				$TaobaokeItem[$k]["click_url"]  = $this->taobao_taobaoke_t9('http://detail.tmall.com/item.htm?id='.$TaobaokeItem[$k]['num_iid'], $Tapparams['outer_code']);
				$TaobaokeItem[$k]["title"]      = dd_replace($TaobaokeItem[$k]["title"], $this->nowords);
				$TaobaokeItem[$k]['name']       = strip_tags($TaobaokeItem[$k]['title']);
				$TaobaokeItem[$k]['name_url']   = urlencode($TaobaokeItem[$k]['name']);
				$TaobaokeItem[$k]['jump']       = "index.php?mod=jump&act=goods&url=".urlencode(base64_encode($TaobaokeItem[$k]["click_url"])).'&pic='.urlencode(base64_encode($TaobaokeItem[$k]["pic_url"].'_100x100.jpg')).'&iid='.$TaobaokeItem[$k]['num_iid'].'&fan='.$TaobaokeItem[$k]["fxje"].'&price='.$TaobaokeItem[$k]["price"].'&name='.$TaobaokeItem[$k]["name_url"];
				$TaobaokeItem[$k]['go_view']    = u(
					'tao', 'view', array(
						'iid' => $TaobaokeItem[$k]["num_iid"]
					)
				);
				$TaobaokeItem[$k]['go_shop']    = u(
					'tao', 'shop', array(
						'nick' => $Tapparams["nick"]
					)
				);
				if(WEBTYPE == '0') {
					$TaobaokeItem[$k]['gourl'] = $TaobaokeItem[$k]['jump'];
				} else {
					$TaobaokeItem[$k]['gourl'] = $TaobaokeItem[$k]['go_view'];
				}
				$TaobaokeItem[$k]['nick'] = $Tapparams['nick'];
			}
		}

		return $TaobaokeItem;
	}



	function items_get($Tapparams) {
		//获取商品信息
		$TaobaokeItem = $this->taobao_taobaoke_items_get($Tapparams);
		if($Tapparams['total'] == 1) {
			$total = $TaobaokeItem['total'];
			unset($TaobaokeItem['total']);
		}
		if($Tapparams['seller'] == 1) {
			$nicks = "";
			$c     = count($TaobaokeItem);
			for($i = 0; $i < $c; $i++) {
				if($i == 0) {
					$nicks = $TaobaokeItem[$i]["nick"];
				} else {
					$nicks = $nicks.",".$TaobaokeItem[$i]["nick"];
				}
			}
			if(str_replace(',', '', $nicks) == '') {
				return 103;
			} else {
				//获取卖家信息
				$c         = count($TaobaokeItem);
				$shopinfos = $this->taobao_taobaoke_shops_convert(array('nick' => $nicks));

				foreach($shopinfos as $k => $row) {
					$nick            = $row['seller_nick'];
					$shopinfo[$nick] = $row;
				}
				unset($shopinfos);

				foreach($TaobaokeItem as $k => $row) {
					$nick = $row["nick"];
					if($shopinfo[$nick]['shop_type'] == 'B') {
						$TaobaokeItem[$k]['level'] = 21;
					} else {
						$TaobaokeItem[$k]['level'] = $shopinfo[$nick]['seller_credit'];
					}
					$TaobaokeItem[$k]["type"]    = $shopinfo[$nick]["shop_type"];
					$TaobaokeItem[$k]["user_id"] = $shopinfo[$nick]["user_id"];
				}
			}
		}
		if($Tapparams['total'] == 1) {
			$TaobaokeItem['total'] = $total;
		}

		return $TaobaokeItem;
	}



	function items_detail_get($Tapparams) {
		$goods = $this->taobao_taobaoke_items_detail_get($Tapparams);
		if($goods == 102) return 102;

		exit($ReadMode.(string)__LINE__);
		if($Tapparams['goods_type'] == 'tmall') { //返现为0但是为天猫商品
			exit('3202');
			$url = 'http://detail.tmall.com/item.htm?id='.$goods['num_iid'];
			if($goods['notaoke'] == 1) {
				$goods['click_url'] = $this->taobao_taobaoke_t9($url, $Tapparams['outer_code']);
			}
			$goods['tmall_commission'] = $goods['price'] * $this->ApiConfig->tmall_commission_rate; //天猫全站佣金
			$goods['tmall_fxje']       = $this->tbfenduan($goods['tmall_commission'], $this->ApiConfig->fxbl, $this->dduser['level']);
		} elseif($Tapparams['goods_type'] == 'ju') { //聚划算商品
			exit('3210');
			$url = 'http://ju.taobao.com/tg/home.htm?item_id='.$goods['num_iid'];
			if($goods['notaoke'] == 1) {
				$goods['click_url'] = $this->taobao_taobaoke_t9('http://detail.tmall.com/item.htm?id='.$goods['num_iid'], $Tapparams['outer_code']); //t9要采用天猫连接
			}

			$goods['price']         = $Tapparams['ju_price'];
			$goods['ju_commission'] = $goods['price'] * $this->ApiConfig->ju_commission_rate; //聚划算全站佣金
			$goods['ju_fxje']       = $this->tbfenduan($goods['ju_commission'], $this->ApiConfig->fxbl, $this->dduser['level']);
		}

		$goods['jump'] = "index.php?mod=jump&act=goods&url=".urlencode(base64_encode($goods['click_url'])).'&pic='.urlencode(base64_encode($goods["pic_url"].'_100x100.jpg')).'&price='.$goods["price"].'&name='.urlencode($goods["title"]).'&iid='.$goods['num_iid'];

		if($promotion['price'] > 0) {
			$goods['promotion_price']   = $promotion['price'];
			$goods['promotion_name']    = $promotion['name'];
			$goods['promotion_endtime'] = $promotion['endtime'];
			if($goods['commission'] > 0) {
				$goods['promotion_commission'] = round($goods['commission'] * ($goods['promotion_price'] / $goods['price']), 2);
			}
			$goods['jump'] .= '&promotion_price='.$goods['promotion_price'].'&promotion_endtime='.$goods['promotion_endtime'];
		}

		return $goods;
	}



	function get_commission($title, $nick, $p = 'commission') {
		$Tapparams['keyword']   = $title;
		$Tapparams['page_no']   = 1;
		$Tapparams['page_size'] = 40;
		$Tapparams['sort']      = 'commissionNum_desc';
		$Tapparams['fields']    = 'title,click_url,commission,nick';
		$arr                    = $this->taobao_taobaoke_items_get($Tapparams);
		if($arr[0] == '') $row[0] = $arr;
		else $row = $arr;
		if(!is_array($row)) {
			return;
		}
		$c = count($row);
		for($i = 0; $i < $c; $i++) {
			if($row[$i]['nick'] == $nick && strip_tags($row[$i]['title']) == strip_tags($title)) {
				$re = $row[$i];
				$i  = 9999999;
			}
		}
		if($p == 'commission') return $re['commission'];
		if($p == 'click_url') return $re['click_url'];
	}



	function taobao_time_get() {
		$this->method = 'taobao.time.get';
		$TaobaokeData = $this->Send('get', $this->format)->getArrayData();

		return $TaobaokeData['time'];
	}



	function taobao_ump_promotion_get($iid, $type = 'array') {
		$api      = 0;
		$dir      = $this->ApiConfig->CachePath.'/cuxiao/'.substr($iid, 0, 3).'/'.substr($iid, 3, 3).'/'.substr($iid, -5);
		$file_arr = glob($dir.'_*.json');
		if(!empty($file_arr)) {
			foreach($file_arr as $v) {
				$a        = explode('_', $v);
				$end_time = $a[count($a) - 1];
				$end_time = str_replace('.json', '', $end_time);
				if($end_time > TIME) {
					if($type == 'json') {
						return file_get_contents($v);
					} elseif($type == 'array') {
						return json_decode(file_get_contents($v), 1);
					}
				} else {
					$api = 1;
				}
			}
		} else {
			$api = 1;
		}

		if($api == 0) return;

		$this->method     = 'taobao.ump.promotion.get';
		$this->item_id    = $iid;
		$TaobaokeData     = $this->Send('get', $this->format)->getArrayData();
		$info             = $TaobaokeData['promotions']['promotion_in_item']['promotion_in_item'];
		$data['name']     = '';
		$data['end_time'] = '';
		$data['price']    = '';
		if($info[0]['name'] != '') {
			foreach($info as $k => $row) {
				if($row['end_time'] > date('Y-m-d H:i:s')) {
					$data['name']  = $row['name'];
					$data['price'] = $row['item_promo_price'];
					if($row['end_time'] > '2038-01-01 00:00:00') { //时间戳的最大值
						$row['end_time'] = '2038-01-01 00:00:00';
					}
					$data['end_time'] = strtotime($row['end_time']);
					break;
				}
			}
		} elseif($info['name'] != '') {
			$data['name'] = $info['name'];
			if($info['end_time'] > '2038-01-01 00:00:00') { //时间戳的最大值
				$info['end_time'] = '2038-01-01 00:00:00';
			}
			$data['end_time'] = strtotime($info['end_time']);
			$data['price']    = $info['item_promo_price'];
		} else {
			$url1 = 'http://marketing.taobao.com/home/promotion/item_promotion_list.do?itemId='.$iid;
			$url2 = 'http://tbskip.taobao.com/limit_promotion_item.htm?auctionId='.$iid;
			$a    = dd_get($url1);
			if(preg_match('/^var yx_promList(.*)/', $a) == 1) {
				$a                = iconv('gbk', 'utf-8', $a);
				$a                = str_replace('var yx_promList=', '', $a);
				$a                = json_decode($a, 1);
				$data['name']     = $a['promList'][0]['iconTitle'];
				$data['price']    = (float)$a['promList']['policyList'][0]['promPrice'];
				$data['end_time'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')." +5 hour")); //默认5小时过期
			}
		}
		if($data['name'] != '' && $data['price'] > 0) {
			$data['iid'] = $iid;
			$filename    = $dir.'_'.$data['end_time'].'.json';
			$content     = json_encode($data);
			create_file($filename, $content);
		}

		if($type == 'json') {
			return $content;
		} else {
			return $data;
		}
	}



	function taobao_taobaoke_listurl_get($q, $outer_code) { //S8接口，可以自己拼装url
		$url = 'http://s8.taobao.com/search?q='.rawurlencode(iconv('utf-8', 'gbk//IGNORE', $q)).'&pid=mm_'.$this->ApiConfig->taobao_search_pid.'&commend=all&unid='.$outer_code.'&taoke_type=1';

		return spm($url);
		$this->method     = 'taobao.taobaoke.listurl.get';
		$this->q          = $q;
		$this->outer_code = $outer_code;
		$TaobaokeData     = $this->Send('get', $this->format)->getArrayData();

		return $TaobaokeData['taobaoke_item']['keyword_click_url'].'&taoke_type=1';
	}



	function taobao_taobaoke_t9($url, $u) {
		$url = spm($url);

		return 'http://s.click.taobao.com/t_9?p=mm_'.$this->ApiConfig->taobao_pid.'_0_0&l='.urlencode($url).'&unid='.$u;
	}



	function taobao_taobaoke_s8($type, $val = '') {
		switch($type) {
			case 'cid':
				$url = 'http://s8.taobao.com/search?pid=mm_'.$this->ApiConfig->taobao_search_pid.'&unid='.$this->dduser['id'].'&mode=63&refpos=&cat='.$val.'&commend=all&taoke_type=1';
				break;
			case 'index':
				$url = 'http://s8.taobao.com/list.html?&pid=mm_'.$this->ApiConfig->taobao_search_pid.'&commend=all&unid='.$this->dduser['id'].'&taoke_type=1';
				break;
			case 'q':
				$url = 'http://s8.taobao.com/search?q='.rawurlencode(iconv('utf-8', 'gbk//IGNORE', $val)).'&pid=mm_'.$this->ApiConfig->taobao_search_pid.'&commend=all&unid='.$this->dduser['id'].'&taoke_type=1';
				break;
		}
		return spm($url);
	}



	function taobao_taobaoke_items_coupon_get($Tapparams) {
		$this->method = 'taobao.taobaoke.items.coupon.get';
		if($Tapparams['keyword'] == '' && $Tapparams['cid'] == '') {
			return 'miss keyword or cid';
		}
		if(!isset($Tapparams['fields'])) {
			$Tapparams['fields'] = 'num_iid,title,nick,cid,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume,coupon_price,coupon_rate,coupon_start_time,coupon_end_time,shop_type';
		}
		$this->fields = $Tapparams['fields'];
		if(isset($Tapparams['keyword'])) {
			$this->keyword = $Tapparams['keyword'];
		}
		if(isset($Tapparams['cid'])) {
			$this->cid = $Tapparams['cid'];
		}
		if(isset($Tapparams['outer_code'])) {
			$this->outer_code = $Tapparams['outer_code'];
		}
		if(isset($Tapparams['coupon_type'])) { //默认为1，暂时只有1分类
			$this->coupon_type = $Tapparams['coupon_type'];
		}
		if(isset($Tapparams['shop_type'])) { //可选值 b（商城） c（集市） 默认all
			$this->shop_type = 'all'; //$Tapparams['shop_type'];
		}
		if(isset($Tapparams['sort'])) { //可选值 default(默认排序), price_desc(折扣价格从高到低), price_asc(折扣价格从低到高), credit_desc(信用等级从高到低), credit_asc(信用等级从低到高), commissionRate_desc(佣金比率从高到低), commissionRate_asc(佣金比率从低到高), commissionVome_desc(成交量成高到低), commissionVome_asc(成交量从低到高)
			$this->sort = $Tapparams['sort'];
		}
		if(isset($Tapparams['start_coupon_rate'])) { //折扣比例范围,如：7000表示70.00%
			$this->start_coupon_rate = $Tapparams['start_coupon_rate'];
		}
		if(isset($Tapparams['end_coupon_rate'])) { //折扣比例范围,如：8000表示80.00%.注：要起始折扣比率和最高折扣比率一起设置才有效
			$this->end_coupon_rate = $Tapparams['end_coupon_rate'];
		}
		if(isset($Tapparams['start_credit'])) { //卖家信用: 1heart(一心) 2heart (两心) 3heart(三心) 4heart(四心) 5heart(五心) 1diamond(一钻) 2diamond(两钻) 3diamond(三钻) 4diamond(四钻) 5diamond(五钻) 1crown(一冠) 2crown(两冠) 3crown(三冠) 4crown(四冠) 5crown(五冠) 1goldencrown(一黄冠) 2goldencrown(二黄冠) 3goldencrown(三黄冠) 4goldencrown(四黄冠) 5goldencrown(五黄冠)
			$this->start_credit = $Tapparams['start_credit'];
		}
		if(isset($Tapparams['end_credit'])) { //可选值和start_credit一样.start_credit的值一定要小于或等于end_credit的值。注：end_credit与start_credit一起使用才生效
			$this->end_credit = $Tapparams['end_credit'];
		}
		if(isset($Tapparams['start_commission_rate'])) { //起始佣金比率选项，如：1234表示12.34%
			$this->start_commission_rate = $Tapparams['start_commission_rate'];
		}
		if(isset($Tapparams['end_commission_rate'])) { //最高佣金比率选项，如：2345表示23.45%。注：要起始佣金比率和最高佣金比率一起设置才有效。
			$this->end_commission_rate = $Tapparams['end_commission_rate'];
		}
		if(isset($Tapparams['start_commission_volume'])) { //起始累计推广量佣金.注：返回的数据是30天内累计推广佣金，该字段要与最高累计推广佣金一起使用才生效
			$this->start_commission_volume = $Tapparams['start_commission_volume'];
		}
		if(isset($Tapparams['end_commission_volume'])) { //最高累计推广佣金选项
			$this->end_commission_volume = $Tapparams['end_commission_volume'];
		}
		if(isset($Tapparams['start_commission_num'])) { //累计推广量范围开始
			$this->start_commission_num = $Tapparams['start_commission_num'];
		}
		if(isset($Tapparams['end_commission_num'])) { //累计推广量范围结束
			$this->end_commission_num = $Tapparams['end_commission_num'];
		}
		if(isset($Tapparams['start_volume'])) { //交易量范围开始
			$this->start_volume = $Tapparams['start_volume'];
		}
		if(isset($Tapparams['end_volume'])) { //交易量范围结束
			$this->end_volume = $Tapparams['end_volume'];
		}
		if(isset($Tapparams['area'])) {
			$this->area = $Tapparams['area'];
		}
		if(isset($Tapparams['is_mobile'])) {
			$this->is_mobile = $Tapparams['is_mobile'];
		}
		if(isset($Tapparams['page_no'])) {
			$this->page_no = $Tapparams['page_no'];
		}
		if(isset($Tapparams['page_size'])) { //最大100
			$this->page_size = $Tapparams['page_size'];
		}
		$TaobaokeData  = $this->Send('get', $this->format)->getArrayData();
		$TaobaokeItem1 = $TaobaokeData["taobaoke_items"]["taobaoke_item"];
		$TotalResults  = $TaobaokeData["total_results"];
		if(!is_array($TaobaokeItem1[0])) {
			$TaobaokeItem[0] = $TaobaokeItem1;
		} else {
			$TaobaokeItem = $TaobaokeItem1;
		}
		if($TotalResults > 0) {
			$TaobaokeItem = $this->do_TaobaokeItem($TaobaokeItem); //促销价格缓存

			if(isset($Tapparams['total'])) {
				$TaobaokeItem['total'] = $TotalResults ? $TotalResults : 0;
			}

			return $TaobaokeItem;
		} else {
			return 102;
		}
	}



	function taobao_shopcats_list_get() {
		$this->method = 'taobao.shopcats.list.get';
		$TaobaokeData = $this->Send('get', $this->format)->getArrayData();

		return $TaobaokeData['shop_cats']['shop_cat'];
	}



	function taobao_taobaoke_shops_get($Tapparams) {
		$this->method = 'taobao.taobaoke.shops.get';
		if($Tapparams['keyword'] == '' && $Tapparams['cid'] == '') {
			return 'miss keyword or cid';
		}
		if(!isset($Tapparams['fields'])) {
			$Tapparams['fields'] = 'user_id,click_url,shop_title,commission_rate,seller_credit,shop_type,auction_count,total_auction';
		}
		$this->fields = $Tapparams['fields'];
		if(isset($Tapparams['cid'])) {
			$this->cid = $Tapparams['cid'];
		}
		if(isset($Tapparams['keyword'])) {
			$this->keyword = $Tapparams['keyword'];
		}
		if(isset($Tapparams['start_credit'])) { //店铺掌柜信用等级起始店铺的信用等级总共为20级 1-5:1heart-5heart;6-10:1diamond-5diamond;11-15:1crown-5crown;16-20:1goldencrown-5goldencrown
			$this->start_credit = $Tapparams['start_credit'];
		}
		if(isset($Tapparams['end_credit'])) {
			$this->end_credit = $Tapparams['end_credit'];
		}
		if(isset($Tapparams['start_commissionrate'])) { //店铺佣金比例查询开始值，注意佣金比例是x10000的整数.50表示0.5%
			$this->start_commissionrate = $Tapparams['start_commissionrate'];
		}
		if(isset($Tapparams['end_commissionrate'])) {
			$this->end_commissionrate = $Tapparams['end_commissionrate'];
		}
		if(isset($Tapparams['start_auctioncount'])) { //店铺宝贝数查询开始值
			$this->start_auctioncount = $Tapparams['start_auctioncount'];
		}
		if(isset($Tapparams['end_auctioncount'])) {
			$this->end_auctioncount = $Tapparams['end_auctioncount'];
		}
		if(isset($Tapparams['start_totalaction'])) { //店铺累计推广量开始值
			$this->start_totalaction = $Tapparams['start_totalaction'];
		}
		if(isset($Tapparams['end_totalaction'])) {
			$this->end_totalaction = $Tapparams['end_totalaction'];
		}
		if(isset($Tapparams['only_mall'])) { //是否只显示商城店铺 默认false
			$this->only_mall = $Tapparams['only_mall'];
		}
		if(isset($Tapparams['page_no'])) {
			$this->page_no = $Tapparams['page_no'];
		}
		if(isset($Tapparams['page_size'])) {
			$this->page_size = $Tapparams['page_size'];
		}
		$TaobaokeData  = $this->Send('get', $this->format)->getArrayData();
		$TaobaokeItem1 = $TaobaokeData["taobaoke_shops"]["taobaoke_shop"];
		$TotalResults  = $TaobaokeData["total_results"];
		if(!is_array($TaobaokeItem1[0])) {
			$TaobaokeItem[0] = $TaobaokeItem1;
		} else {
			$TaobaokeItem = $TaobaokeItem1;
		}
		if(isset($Tapparams['total'])) {
			$TaobaokeItem['total'] = $TotalResults ? $TotalResults : 0;
		}
		if($TotalResults > 0) {
			return $TaobaokeItem;
		}
	}



	function taobao_taobaoke_items_relate_get($Tapparams) { //推荐接口
		$this->method      = 'taobao.taobaoke.items.relate.get';
		$this->fields      = 'num_iid,title,nick,pic_url,price,click_url,commission,ommission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume';
		$this->relate_type = $Tapparams['relate_type']; //推荐类型.1:同类商品推荐;2:异类商品推荐;3:同店商品推荐;4:店铺热门推荐;5:类目热门推荐
		$this->num_iid     = $Tapparams['num_iid']; //淘宝客商品数字id.推荐类型为1,2,3时num_iid不能为空
		$this->seller_id   = $Tapparams['seller_id']; //卖家id.推荐类型为4时seller_id不能为空
		$this->cid         = $Tapparams['cid']; //分类id.推荐类型为5时cid不能为空。仅支持叶子类目ID，即通过taobao.itemcats.get获取到is_parent=false的cid
		$this->shop_type   = $Tapparams['shop_type'] ? $Tapparams['shop_type'] : 'all'; //店铺类型.默认all,商城:b,集市:c
		$this->sort        = $Tapparams['sort'] ? $Tapparams['sort'] : 'default'; //default(默认排序,关联推荐相关度),price_desc(价格从高到低), price_asc(价格从低到高),commissionRate_desc(佣金比率从高到低), commissionRate_asc(佣金比率从低到高), commissionNum_desc(成交量成高到低), commissionNum_asc(成交量从低到高)
		$this->max_count   = $Tapparams['max_count'] ? $Tapparams['max_count'] : 40;
		$TaobaokeData      = $this->Send('get', $this->format)->getArrayData();

		return $TaobaokeData['taobaoke_items']['taobaoke_item'];
	}



	function taobao_shoprecommend_items_get($Tapparams) {
		$this->method         = 'taobao.shoprecommend.items.get';
		$this->seller_id      = $Tapparams['seller_id'];
		$this->recommend_type = 1;
		$this->count          = $Tapparams['count'] ? $Tapparams['count'] : 10;
		$this->ext            = $Tapparams['ext'];
		$TaobaokeData         = $this->Send('get', $this->format)->getArrayData();

		return $TaobaokeData['favorite_items']['favorite_item'];
	}



	function tmall_temai_items_search($Tapparams = array()) {
		$start        = (int)$Tapparams['page'] * 48;
		$this->method = 'tmall.temai.items.search';
		$this->cat    = $Tapparams['cid'] ? $Tapparams['cid'] : 50100982;
		$this->start  = $start;
		$this->sort   = $Tapparams['sort'] ? $Tapparams['sort'] : 's'; //s: 人气排序 p: 价格从低到高; pd: 价格从高到低; d: 月销量从高到低; pt: 按发布时间排序.
		$TaobaokeData = $this->Send('get', $this->format)->getArrayData();
		$total        = $TaobaokeData['total_results'];
		$TaobaokeItem = $TaobaokeData['item_list']['tmall_search_tm_item'];

		$num_iids = '';
		foreach($TaobaokeItem as $k => $row) {
			preg_match('/(\d+)_track_\d+/', $row['track_iid'], $a);
			$num_iid = $a[1];
			$num_iids .= $num_iid.',';
			$num_iid_arr[$num_iid] = $k;
		}
		$num_iids = preg_replace('/,$/', '', $num_iids);

		$a = $this->taobao_taobaoke_items_convert($num_iids, $Tapparams['outer_code']);
		unset($a['total']);

		foreach($a as $i => $v) {
			$k                                  = $num_iid_arr[(string)$v['num_iid']];
			$TaobaokeItem[$k]['num_iid']        = $v['num_iid'];
			$TaobaokeItem[$k]['pic_url']        = str_replace('_b.jpg', '', $TaobaokeItem[$k]['pic_url']);
			$TaobaokeItem[$k]['click_url']      = $v['click_url'];
			$TaobaokeItem[$k]['commission']     = $v['commission'];
			$TaobaokeItem[$k]['commission_num'] = $v['commission_num'];
			//$TaobaokeItem[$k]['fxje']=round($TaobaokeItem[$k]['promotion_price']*$TaobaokeItem[$k]['commission']/$TaobaokeItem[$k]['price'],2);
		}

		foreach($TaobaokeItem as $k => $row) {
			if(isset($row['num_iid'])) {
				$goods[] = $row;
			}
		}
		unset($TaobaokeItem);
		if(isset($Tapparams['total']) && $Tapparams['total'] > 0) {
			$goods['total'] = $total;
		}

		return $goods;
	}



	function tmall_temai_subcats_search($cid = '') {
		$this->method = 'tmall.temai.subcats.search';
		$this->cat    = $cid ? $cid : 50100982;
		$TaobaokeData = $this->Send('get', $this->format)->getArrayData();

		return $TaobaokeData['cat_list']['tmall_tm_cat'];
	}



	function taobao_spmeffect_get($sdate = '', $edate = '') {
		if($sdate == '') {
			$sdate = date("Y-m-d", strtotime("-1 day"));
		}
		if($edate == '') {
			$edate = date("Y-m-d", strtotime("-1 day"));
		}

		$chaday = date('Ymd', strtotime($edate)) - date('Ymd', strtotime($sdate));

		for($i = 0; $i <= $chaday; $i++) {
			$this->method = 'taobao.spmeffect.get';
			$day          = date("Y-m-d", strtotime($sdate." +".$i." day"));
			$this->date   = $day;
			$TaobaokeData = $this->Send('get', $this->format)->getArrayData();
			$a[$day]      = $TaobaokeData['spm_result']['spm_site'];
		}

		return $a;
	}



	function tmall_items_discount_search($Tapparams) {
		$page              = (int)$Tapparams['page'] * 10;
		$this->method      = 'tmall.items.discount.search';
		$this->q           = $Tapparams['q'];
		$this->cat         = $Tapparams['cid'];
		$this->start       = $page; //start最大是110
		$this->sort        = $Tapparams['sort'] ? $Tapparams['sort'] : 's'; // s: 人气排序 p: 价格从低到高; pd: 价格从高到低; d: 月销量从高到低; td: 总销量从高到低; pt: 按发布时间排序
		$this->post_fee    = $Tapparams['post_fee']; //-1为包邮
		$this->post_fee    = $Tapparams['post_fee'];
		$this->start_price = $Tapparams['start_price'];
		$this->auction_tag = $Tapparams['auction_tag']; //天猫精品库：8578；品牌特卖商品库：3458；天猫原创商品库：4801
		$TaobaokeData      = $this->Send('get', $this->format)->getArrayData();
		$total             = $TaobaokeData['total_results'];
		$TaobaokeItem      = $TaobaokeData['item_list']['tmall_search_item'];

		$num_iids = '';
		foreach($TaobaokeItem as $k => $row) {
			$num_iid = $row['item_id'];
			$num_iids .= $num_iid.',';
			$num_iid_arr[(string)$num_iid] = $k;
		}
		$num_iids = preg_replace('/,$/', '', $num_iids);

		$a = $this->taobao_taobaoke_items_convert($num_iids, $Tapparams['outer_code']);

		foreach($a as $i => $v) {
			$k                                   = $num_iid_arr[(string)$v['num_iid']];
			$TaobaokeItem[$k]['num_iid']         = $v['num_iid'];
			$TaobaokeItem[$k]['pic_path']        = str_replace('_160x160.jpg', '', $TaobaokeItem[$k]['pic_path']);
			$TaobaokeItem[$k]['url']             = str_replace('&amp;', '&', $TaobaokeItem[$k]['url']);
			$TaobaokeItem[$k]['click_url']       = $v['click_url'];
			$TaobaokeItem[$k]['commission']      = $v['commission'];
			$TaobaokeItem[$k]['commission_num']  = $v['commission_num'];
			$TaobaokeItem[$k]['commission_rate'] = $v['commission_rate'];
			//$TaobaokeItem[$k]['fxje']=round($TaobaokeItem[$k]['promotion_price']*$TaobaokeItem[$k]['commission']/$TaobaokeItem[$k]['price'],2);
		}

		foreach($TaobaokeItem as $k => $row) {
			if(isset($row['num_iid'])) {
				$goods[] = $row;
			}
		}
		unset($TaobaokeItem);
		if(isset($Tapparams['total']) && $Tapparams['total'] > 0) {
			$goods['total'] = $total;
		}

		return $goods;
	}



	function taobao_topats_itemcats_get() {
		$this->method        = 'taobao.topats.itemcats.get';
		$this->cids          = 0;
		$this->output_format = 'json';
		$this->type          = 1;
		$TaobaokeData        = $this->Send('get', $this->format)->getArrayData();
		print_r($TaobaokeData);
		exit;
	}



	function taobao_topats_result_get($task_id) {
		$this->method  = 'taobao.topats.result.get';
		$this->task_id = $task_id;
		$TaobaokeData  = $this->Send('get', $this->format)->getArrayData();
		print_r($TaobaokeData);
		exit;
	}



	function taobao_ju_cities_get() {
		$this->method = 'taobao.ju.cities.get';
		$TaobaokeData = $this->Send('get', $this->format)->getArrayData();
		print_r($TaobaokeData);
		exit;
	}



	function taobao_ju_cityitems_get($Tapparams) {
		$this->method    = 'taobao.ju.cityitems.get';
		$this->city      = $Tapparams['city'];
		$this->page_no   = $Tapparams['page_no'] ? $Tapparams['page_no'] : 1;
		$this->page_size = $Tapparams['page_size'] ? $Tapparams['page_size'] : 20;
		$TaobaokeData    = $this->Send('get', $this->format)->getArrayData();
		print_r($TaobaokeData);
		exit;
	}



	function taobao_ju_catitemids_get($Tapparams) {
		$this->method            = 'taobao.ju.catitemids.get';
		$this->terminal_type     = $Tapparams['terminal_type'];
		$this->platform_id       = $Tapparams['platform_id'];
		$this->parent_categoryid = $Tapparams['parent_categoryid'] ? $Tapparams['parent_categoryid'] : 100000;
		$this->child_categoryid  = $Tapparams['child_categoryid'];
		$this->page_no           = $Tapparams['page_no'] ? $Tapparams['page_no'] : 1;
		$this->page_size         = $Tapparams['page_size'] ? $Tapparams['page_size'] : 20;
		$this->city              = $Tapparams['city'];
		$TaobaokeData            = $this->Send('get', $this->format)->getArrayData();
		print_r($TaobaokeData);
		exit;
	}



	function taobao_taobaoke_rebate_report_get($start_time) {
		$goods   = array();
		$page_no = 1;

		for($i = 1; $i <= 6; $i++) {
			$_start_time      = date('Y-m-d H:i:s', strtotime($start_time) + ($i - 1) * 600);
			$this->start_time = $_start_time;
			$this->page_no    = $page_no;

			$this->method    = 'taobao.taobaoke.rebate.report.get';
			$this->fields    = 'app_key,outer_code,trade_id,pay_time,pay_price,num_iid,item_title,item_num,category_id,category_name,shop_title,commission_rate,commission,iid,seller_nick,real_pay_fee';
			$this->span      = 600;
			$this->page_size = TAO_REPORT_GET_NUM;

			$TaobaokeData = $this->Send('get', $this->format)->getArrayData();

			if(isset($TaobaokeData['code'])) {
				echo $_start_time;
				print_r($TaobaokeData);
				exit;
			} else {
				$_goods = $TaobaokeData['taobaoke_payments']['taobaoke_payment'];
				if(!empty($_goods)) {
					$goods = array_merge($goods, $_goods);
					if(count($_goods) == TAO_REPORT_GET_NUM) {
						$page_no++;
						$this->page_no   = $page_no;
						$this->method    = 'taobao.taobaoke.rebate.report.get';
						$this->fields    = 'app_key,outer_code,trade_id,pay_time,pay_price,num_iid,item_title,item_num,category_id,category_name,shop_title,commission_rate,commission,iid,seller_nick,real_pay_fee';
						$this->span      = 600;
						$this->page_size = TAO_REPORT_GET_NUM;

						$TaobaokeData = $this->Send('get', $this->format)->getArrayData();
						$_goods       = $TaobaokeData['taobaoke_payments']['taobaoke_payment'];
						$goods        = array_merge($goods, $_goods);
					}
				}

			}
		}

		return $goods;
	}



	function taobao_taobaoke_rebate_authorize_get($str, $type = 'num_iid') {
		$this->method = 'taobao.taobaoke.rebate.authorize.get';
		if($type == 'num_iid') {
			$this->num_iid = $str;
		} elseif($type == 'seller_id') {
			$this->seller_id = $str;
		} elseif($type == 'nick') {
			$this->nick = $str;
		}
		$TaobaokeData = $this->Send('get', $this->format)->getArrayData();
		if($TaobaokeData['rebate'] == 1) {
			return 1;
		} else {
			return 0;
		}
	}
}

/**
 * 全局设置参数设置
 *
 * @category   Taoapi
 * @package    Taoapi_Config
 * @copyright  Copyright (c) 2008-2010 Taoapi (http://www.Taoapi.com)
 * @license    http://www.Taoapi.com
 * @version    Id: Taoapi_Config  2010-02-22 15:36:47 Arvin  多多淘宝客优化：http://www.duoduo123.com
 */
class Taoapi_Config {

	//存放全局参数
	private $_Config;
	/**
	 * @var  Taoapi_Config
	 */
	private static $_init;



	private function __Config() {
		//多多淘宝客 www.duoduo123.com 优化 12年03月20日
		/*
		警告: 修改该文件必须保存为无ROM头的文件,也就是去掉文件头签名
		如果使用记事本改的话可能会出现获取数据乱码的问题
		*/

		//设置获取数据的编码. 支持UTF-8 GBK GB2312
		//需要 iconv或mb_convert_encoding 函数支持
		//UTF-8 不可写成UTF8
		$apiConfig['Charset'] = 'UTF-8';

		//设置数据环境
		//true 测试环境 false 正式环境
		$apiConfig['TestMode'] = FALSE;

		//您的appKey和appSecret 支持多个appKey

		global $webset;
		$key_arr = $webset['appkey'];
		$k_nums  = 0;
		foreach($key_arr as $key => $row) {
			if($row['num'] > 0) {
				$proArr[] = $row['num'];
				$k_nums++;
			}
		}
		function pro_rand($proArr) {
			$result = '';
			//概率数组的总概率精度
			$proSum = array_sum($proArr);

			foreach($proArr as $key => $proCur) {
				$randNum = mt_rand(1, $proSum);
				if($randNum <= $proCur) {
					$result = $key;
					break;
				} else {
					$proSum -= $proCur;
				}
			}

			return $result;
		}

		for($k = 0; $k < $k_nums; $k++) {
			$result                                        = pro_rand($proArr);
			$apiConfig['AppKey'][$key_arr[$result]['key']] = $key_arr[$result]['secret'];
			unset($proArr[$result]);
		}

		if(MOD == 'tao' && ACT == 'report') { //获取订单，只是用一个key，并赋值session
			$apiConfig['AppKey'][$webset['taoapi']['jssdk_key']] = $webset['taoapi']['jssdk_secret'];
			$error_word                                          = 'appkey列表不能为空！';
		}

		if(empty($apiConfig['AppKey'])) {
			PutInfo($error_word);
		}

		//当appKey不只一个时,API次数超限后自动启用下一个APPKEY
		//false:关闭 true:开启
		$apiConfig['AppKeyAuto'] = TRUE;

		//设置API版本,1 表示1.0 2表示2.0
		$apiConfig['Version'] = 2;

		//设置sign加密方式,支持 md5 和 hmac
		//版本2.0时才可以使用 hmac
		$apiConfig['SignMode'] = 'md5';

		//显示或关闭错语提示,
		//true:关闭 false:开启
		$apiConfig['CloseError'] = TRUE;

		//开启或关闭API调用日志功能,开启后可以查看到每天APPKEY调用的次数以及调用的API
		//false:关闭 true:开启
		$apiConfig['ApiLog'] = FALSE;

		//开启或关闭错误日志功能
		//false:关闭 true:开启

		$apiConfig['Errorlog'] = (int)$webset['taoapi']['errorlog'];

		//设置API读取失败时重试的次数,可以提高API的稳定性,默认为3次
		$apiConfig['RestNumberic'] = 0;

		//设置数据缓存的时间,单位:小时;0表示不缓存

		$apiConfig['Cache'] = $webset['taoapi']['cache_time'];

		//设置缓存保存的目录
		$apiConfig['CachePath'] = DDROOT.'/data/temp/taoapi';

		//积分比例
		$apiConfig['fxbl'] = $webset['fxbl'];

		//淘宝账号
		$apiConfig['taobao_nick'] = $webset['taobao_nick'];

		//淘宝pid
		$apiConfig['taobao_pid'] = $webset['taobao_pid'];

		//搜索框完整pid
		$apiConfig['taobao_search_pid'] = $webset['taoapi']['taobao_search_pid'];

		//天猫全站返利1.5%  个别类别（黄金，家电等0.5%）
		$apiConfig['tmall_commission_rate'] = $webset['taoapi']['tmall_commission_rate'] >= 0 ? $webset['taoapi']['tmall_commission_rate'] : 0.005;

		//聚划算全站返利2% 平均值
		$apiConfig['ju_commission_rate'] = $webset['taoapi']['ju_commission_rate'] >= 0 ? $webset['taoapi']['ju_commission_rate'] : 0.01;

		//是否获取商品实时价格
		$apiConfig['promotion'] = $webset['taoapi']['promotion'];

		//jssdk_key
		$apiConfig['jssdk_key'] = $webset['taoapi']['jssdk_key'];

		//是否获取商品实时价格
		$apiConfig['jssdk_secret'] = $webset['taoapi']['jssdk_secret'];

		//自动清除过期缓存的时间间隔，
		//格式是：* * * *
		//其中第一个数表示分钟，第二个数表示小时，第三个数表示日期，第四个数表示月份
		//多个之间可以用半角分号隔开
		//示例：
		//要求每天早上的8点1分清除缓存，格式是：1 8 * *
		//要求每个月的1号晚上12点5分清除缓存，格式是：5 12 1 *
		//要求每隔5天就在上午10点3分清除缓存，格式是：3 10 1,5,10,15,20,25 *
		//如果设为0或格式不对将不开启此功能
		//缓存清除操作每天只会执行一次
		$apiConfig['ClearCache'] = "1,4,7,10,14 * * *"; //默认为每小时的 1 3 7 10 14 进行自动缓存清除

		//每次调用API后自动清除原有传入参数
		//false:关闭 true:开启
		$apiConfig['AutoRestParam'] = TRUE;
		unset($webset);

		return $apiConfig;
	}



	private function __construct() {
		$this->_Config = self::__Config();
		$this->setTestMode($this->_Config['TestMode']);
		$this->_Config['PostMode'] = array('GET' => 'getSend', 'POST' => 'postSend', 'POSTIMG' => 'postImageSend');
	}



	/**
	 * @return Taoapi_Config
	 */
	public static function Init() {
		if(!self::$_init) {
			self::$_init = new Taoapi_Config();
		}

		return self::$_init;
	}



	/**
	 * 设置数据环境: true 测试环境 false 正式环境
	 *
	 * @param bool $test
	 *
	 * @return Taoapi_Config
	 */
	public function setTestMode($test = TRUE) {
		if($test) {
			$this->_Config['Container'] = 'http://container.api.tbsandbox.com/container';
			$this->_Config['Url']       = 'http://gw.api.tbsandbox.com/router/rest';
		} else {
			$this->_Config['Container'] = 'http://container.api.taobao.com/container';
			$this->_Config['Url']       = 'http://gw.api.taobao.com/router/rest';
		}

		return $this;
	}



	/**
	 * 设置获取数据的编码. 支持UTF-8 GBK GB2312
	 * 需要 iconv或mb_convert_encoding 函数支持
	 * UTF-8 不可写成UTF8
	 *
	 * @param string $Charset
	 *
	 * @return Taoapi_Config
	 */
	public function setCharset($Charset) {
		$this->_Config['Charset'] = $Charset;

		return $this;
	}



	/**
	 * 设置appKey
	 *
	 * @param int $key
	 *
	 * @return Taoapi_Config
	 */
	public function setAppKey($key) {
		if(is_array($key)) {
			$this->_Config['AppKey'] = $key;
		} else {
			$this->_Config['AppKey'][$key] = 0;
		}

		return $this;
	}



	/**
	 * 设置appSecret
	 *
	 * @param string $Secret
	 *
	 * @return Taoapi_Config
	 */
	public function setAppSecret($Secret) {
		$key = array_search('0', $this->_Config['AppKey']);

		if($key) {
			$this->_Config['AppKey'][$key] = $Secret;
		}

		return $this;
	}



	/**
	 * 当appKey不只一个时,API次数超限后自动启用下一个APPKEY
	 *
	 * @param bool $Secret
	 *
	 * @return Taoapi_Config
	 */
	public function setAppKeyAuto($AppKeyAuto) {
		$this->_Config['AppKeyAuto'] = (bool)$AppKeyAuto;

		return $this;
	}



	/**
	 * 设置API版本,1 表示1.0 2表示2.0
	 * 设置sign加密方式,支持 md5 和 hmac
	 *
	 * @param int    $version
	 * @param string $signmode
	 *
	 * @return Taoapi_Config
	 */
	public function setVersion($version, $signmode = 'md5') {
		$this->_Config['Version']  = intval($version);
		$this->_Config['SignMode'] = $signmode;

		return $this;
	}



	/**
	 * 设置sign加密方式,支持 md5 和 hmac
	 *
	 * @param string $signmode
	 *
	 * @return Taoapi_Config
	 */
	public function setSignMode($signmode = 'md5') {
		$this->_Config['SignMode'] = $signmode;

		return $this;
	}



	/**
	 * 显示或关闭错语提示
	 *
	 * @param bool $CloseError
	 *
	 * @return Taoapi_Config
	 */
	public function setCloseError($CloseError = TRUE) {
		$this->_Config['CloseError'] = (bool)$CloseError;

		return $this;
	}



	/**
	 * 开启或关闭API调用日志功能,
	 * 开启后可以查看到每天APPKEY调用的次数以及调用的API
	 *
	 * @param bool $Log
	 *
	 * @return Taoapi_Config
	 */
	public function setApiLog($Log) {
		$this->_Config['ApiLog'] = (bool)$Log;

		return $this;
	}



	/**
	 * 开启或关闭错误日志功能
	 *
	 * @param bool $Errorlog
	 *
	 * @return Taoapi_Config
	 */
	public function setErrorlog($Errorlog) {
		$this->_Config['Errorlog'] = $Errorlog;

		return $this;
	}



	/**
	 * 设置API读取失败时重试的次数,
	 * 可以提高API的稳定性,推荐为3次
	 *
	 * @param int $RestNumberic
	 *
	 * @return Taoapi_Config
	 */
	public function setRestNumberic($RestNumberic) {
		$this->_Config['RestNumberic'] = intval($RestNumberic);;

		return $this;
	}



	/**
	 * 设置数据缓存的时间,
	 * 单位:小时;0表示不缓存
	 *
	 * @param int $cache
	 *
	 * @return Taoapi_Config
	 */
	public function setCache($cache = 0) {
		$this->_Config['Cache'] = intval($cache);

		return $this;
	}



	/**
	 * 设置缓存保存的目录
	 *
	 * @param string $CachePath
	 *
	 * @return Taoapi_Config
	 */
	public function setCachePath($CachePath) {
		$this->_Config['CachePath'] = $CachePath;

		return $this;
	}



	/**
	 * 返回全局配置参数
	 *
	 * @return object
	 */
	public function getConfig() {
		return (object)$this->_Config;
	}
}

/**
 * Api Cache System
 *
 * @author Taoapi.com
 *
 * 多多淘宝客优化：http://www.duoduo123.com
 */
class Taoapi_Cache {

	//缓存路径
	private $_CachePath;
	//缓存时间
	private $_cachetime = 0;
	//API名称
	private $_method = "";
	//是否自动清除缓存
	private $_ClearCache = 0;



	public function __construct() {
		$Taoapi_Config = Taoapi_Config::Init();
		$this->setCacheTime($Taoapi_Config->getConfig()->Cache);
		$this->setCachePath($Taoapi_Config->getConfig()->CachePath);
	}



	public function setMethod($method) {
		$this->_method = $method;
	}



	/**
	 * @return Taoapi_Cache
	 */
	public function setCacheTime($time) {
		$this->_cachetime = intval($time);

		return $this;
	}



	/**
	 * @return Taoapi_Cache
	 */
	public function setClearCache($param) {
		$this->_ClearCache = $param;

		return $this;
	}



	/**
	 * @return Taoapi_Cache
	 */
	public function setCachePath($CachePath) {
		$this->_CachePath = substr($CachePath, -1, 1) == '/' ? $CachePath : $CachePath.'/';

		return $this;
	}



	public function saveCacheData($id, $result) {
		if($result == '') return FALSE;

		$idkey = substr($id, 0, 2);

		if($this->_cachetime) {
			$filepath = $this->_CachePath.$this->_method.'/'.$idkey;
			$filename = $filepath.'/'.$id.'.json';
			create_file($filename, $result, 0, 1, 1);
		}
	}



	private function checkClearTime() {
		$CacheParam = explode(" ", $this->_ClearCache);

		if(!$this->_ClearCache || count($CacheParam) !== 4) {
			return FALSE;
		}

		if($CacheParam[3] != "*") {
			$CacheParam[3] = explode(",", $CacheParam[3]);

			if(!in_array(date('m'), $CacheParam[3])) {
				return FALSE;
			}
		}

		if($CacheParam[2] != "*") {
			$CacheParam[2] = explode(",", $CacheParam[2]);

			if(!in_array(date('d'), $CacheParam[2])) {
				return FALSE;
			}
		}
		if($CacheParam[1] != "*") {
			$CacheParam[1] = explode(",", $CacheParam[1]);

			if(!in_array(date('H'), $CacheParam[1])) {
				return FALSE;
			}
		}

		if($CacheParam[0] != "*") {
			$CacheParam[0] = explode(",", $CacheParam[0]);

			if(!in_array(date('i'), $CacheParam[0])) {
				return FALSE;
			}
		}

		$cachetag = $this->_CachePath."autoclear.tag";

		if(file_exists($cachetag)) {
			$filetime = date('U', filemtime($cachetag));

			if(date("d") == date("d", $filetime)) {
				return FALSE;
			}
		}
		file_put_contents($cachetag, date("Y-m-d H:i:s"));

		return TRUE;
	}



	public function autoClearCache($path = '') {
		$path = $path ? $path : $this->_CachePath;

		if(empty($path)) {
			return FALSE;
		}

		if($this->_cachetime) {
			if(!is_dir($path)) {
				return FALSE;
			}

			if($fdir = opendir($path)) {
				$old_cwd = getcwd();
				chdir($path);
				$path = getcwd().'/';
				while(($file = readdir($fdir)) !== FALSE) {
					if(in_array($file, array('.', '..'))) {
						continue;
					}

					if(is_dir($path.$file)) {
						$this->autoClearCache($path.'/'.$file.'/');
					} else {
						if(strpos($file, ".cache") !== FALSE) {
							$filetime  = date('U', filemtime($path.$file));
							$cachetime = $this->_cachetime * 60 * 60;
							if($this->_cachetime != 0 && (TIME - $filetime) > $cachetime) {
								@unlink($path.$file);
							}
						}
					}
				}
				closedir($fdir);
				chdir($old_cwd);
			}
		}

	}



	public function clearCache($id = NULL) {
		if($id) {
			$filename = $this->_CachePath.$this->_method.'/'.$id.'.cache';
			unlink($filename);
		} else {
			$dir = $this->_CachePath.$this->_method.'/';
			if(is_dir($dir)) {
				if($dh = opendir($dir)) {
					while(($file = readdir($dh)) !== FALSE) {
						if(is_dir($dir.$file)) {
							continue;
						}
						if(strpos($file, ".cache") !== FALSE) {
							unlink($dir.$file);
						}
					}
					closedir($dh);
				}
			}
		}
	}



	public function getCacheData($id, $method = '') {
		/*if($this->checkClearTime())  注释掉原来的删除缓存
		{
			$this->autoClearCache();
		}*/
		if($method == '') {
			$method = $this->_method;
		}

		$idkey    = substr($id, 0, 2);
		$filename = $this->_CachePath.$method.'/'.$idkey.'/'.$id.'.json';
		//       if ($this->_cachetime) {
		if(file_exists($filename)) {
			$filetime  = date('U', filemtime($filename));
			$cachetime = $this->_cachetime * 60 * 60;
			if($this->_cachetime != 0 && (TIME - $filetime) > $cachetime) {
				return FALSE;
			}
			$data = dd_json_decode(file_get_contents($filename), TRUE);

			return $data;
		}

		//        }
		return FALSE;
	}
}

/**
 * 淘宝错误处理类
 *
 * @category   Taoapi
 * @package    Taoapi_Exception
 * @copyright  Copyright (c) 2008-2009 PHPDIY (http://www.taoapi.com)
 * @license    http://www.taoapi.com
 * @version    Id: Taoapi  2009-12-22  12:30:51 浪子Arvin  * 多多淘宝客优化：http://www.duoduo123.com
 */
class Taoapi_Exception {

	private $_ErrorInfo;



	public function __construct($error, $paramArr = NULL, $closeerror = FALSE, $Errorlog = 0) {
		return $this->ViewError($error, $paramArr, $closeerror, $Errorlog);
	}



	public function getErrorInfo() {
		return $this->_ErrorInfo;
	}



	private function ErrorInfo($errorcode) {
		$errorinfo[3]  = array('en' => 'Upload Fail', 'cn' => '图片上传失败');
		$errorinfo[4]  = array('en' => 'User Call Limited', 'cn' => '用户调用次数超限');
		$errorinfo[5]  = array('en' => 'Session Call Limited', 'cn' => '会话调用次数超限');
		$errorinfo[6]  = array('en' => 'Partner Call Limited', 'cn' => '合作伙伴调用次数超限');
		$errorinfo[7]  = array('en' => 'App Call Limited', 'cn' => '应用调用次数超限');
		$errorinfo[8]  = array('en' => 'App Call Exceeds Limited Frequency', 'cn' => '应用调用频率超限');
		$errorinfo[9]  = array('en' => 'Http Action Not Allowed', 'cn' => 'HTTP方法被禁止（请用大写的POST或GET）');
		$errorinfo[10] = array('en' => 'Service Currently Unavailable', 'cn' => '服务不可用');
		$errorinfo[11] = array('en' => 'Insufficient ISV Permissions', 'cn' => '开发者权限不足');
		$errorinfo[12] = array('en' => 'Insufficient User Permissions', 'cn' => '用户权限不足');
		$errorinfo[13] = array('en' => 'Insufficient Partner Permissions', 'cn' => '合作伙伴权限不足');
		$errorinfo[15] = array('en' => 'Remote Service Error', 'cn' => '远程服务出错');
		$errorinfo[21] = array('en' => 'Missing Method', 'cn' => '缺少方法名参数');
		$errorinfo[22] = array('en' => 'Invalid Method', 'cn' => '不存在的方法名');
		$errorinfo[23] = array('en' => 'Invalid Format', 'cn' => '非法数据格式');
		$errorinfo[24] = array('en' => 'Missing Signature', 'cn' => '缺少签名参数');
		$errorinfo[25] = array('en' => 'Invalid Signature', 'cn' => '非法签名');
		$errorinfo[26] = array('en' => 'Missing Session', 'cn' => '缺少SessionKey参数');
		$errorinfo[27] = array('en' => 'Invalid Session', 'cn' => '无效的SessionKey参数');
		$errorinfo[28] = array('en' => 'Missing App Key', 'cn' => '缺少AppKey参数');
		$errorinfo[29] = array('en' => 'Invalid App Key', 'cn' => '非法的AppKe参数');
		$errorinfo[30] = array('en' => 'Missing Timestamp', 'cn' => '缺少时间戳参数');
		$errorinfo[31] = array('en' => 'Invalid Timestamp', 'cn' => '非法的时间戳参数');
		$errorinfo[32] = array('en' => 'Missing Version', 'cn' => '缺少版本参数');
		$errorinfo[33] = array('en' => 'Invalid Version', 'cn' => '非法的版本参数');
		$errorinfo[34] = array('en' => 'Unsupported Version', 'cn' => '不支持的版本号');
		$errorinfo[40] = array('en' => 'Missing Required Arguments', 'cn' => '缺少必选参数');
		$errorinfo[41] = array('en' => 'Invalid Arguments', 'cn' => '非法的参数');
		$errorinfo[42] = array('en' => 'Forbidden Request', 'cn' => '请求被禁止');
		$errorinfo[43] = array('en' => 'Parameter Error', 'cn' => '参数错误');

		$errorinfo[501] = array('en' => 'Your Statement is Not Indexable', 'cn' => '语句不可索引');
		$errorinfo[502] = array('en' => 'Data Service Unavailable', 'cn' => '数据服务不可用');
		$errorinfo[503] = array('en' => 'Error While Parsing TBQL Statement', 'cn' => '无法解释TBQL语句');
		$errorinfo[504] = array('en' => 'Need Binding User', 'cn' => '需要绑定用户昵称');
		$errorinfo[505] = array('en' => 'Missing Parameters', 'cn' => '缺少参数');
		$errorinfo[506] = array('en' => 'Parameters Error', 'cn' => '参数错误');
		$errorinfo[507] = array('en' => 'Parameters Format Error', 'cn' => '参数格式错误');
		$errorinfo[508] = array('en' => 'No Permission Get Information', 'cn' => '获取信息权限不足');
		$errorinfo[550] = array('en' => 'User Service Unavailable', 'cn' => '用户服务不可用');
		$errorinfo[551] = array('en' => 'Item Service Unavailable', 'cn' => '商品服务不可用');
		$errorinfo[552] = array('en' => 'Item Image Service Unavailable', 'cn' => '商品图片服务不可用');
		$errorinfo[553] = array('en' => 'Item Simple Update Service Unavailable', 'cn' => '商品更新服务不可用');
		$errorinfo[554] = array('en' => 'Item Delete Failure', 'cn' => '商品删除失败');
		$errorinfo[555] = array('en' => 'No Picture Service for User', 'cn' => '用户没有订购图片服务');
		$errorinfo[556] = array('en' => 'Picture URL is Error', 'cn' => '图片URL错误');
		$errorinfo[557] = array('en' => 'Item Media Service Unavailable', 'cn' => '商品视频服务不可用');
		$errorinfo[560] = array('en' => 'Trade Service Unavailable', 'cn' => '交易服务不可用');
		$errorinfo[561] = array('en' => 'Trade TC Service Unavailable', 'cn' => '交易服务不可用');
		$errorinfo[562] = array('en' => 'Trade not Exists', 'cn' => '交易不存在');
		$errorinfo[563] = array('en' => 'Trade is Invalid', 'cn' => '非法交易');
		$errorinfo[564] = array('en' => 'No Permission Add or Update Trade Memo', 'cn' => '没有权限添加或更新交易备注');
		$errorinfo[565] = array('en' => 'Trade Memo Too Long', 'cn' => '交易备注超出长度限制');
		$errorinfo[566] = array('en' => 'Trade Memo Already Exists', 'cn' => '交易备注已经存在');
		$errorinfo[567] = array('en' => 'No Permission Add or Update Trade', 'cn' => '没有权限添加或更新交易信息');
		$errorinfo[568] = array('en' => 'No Detail Order', 'cn' => '交易没有子订单');
		$errorinfo[569] = array('en' => 'Close Trade Error', 'cn' => '交易关闭错误');
		$errorinfo[570] = array('en' => 'Shipping Service Unavailable', 'cn' => '物流服务不可用');
		$errorinfo[571] = array('en' => 'Invalid Post Fee', 'cn' => '非法的邮费');
		$errorinfo[572] = array('en' => 'Invalid Division Code', 'cn' => '非法的物流公司编号');
		$errorinfo[580] = array('en' => 'Rate Service Unavailable', 'cn' => '评价服务不可用');
		$errorinfo[581] = array('en' => 'Rate Service Add Error', 'cn' => '添加评价服务错误');
		$errorinfo[582] = array('en' => 'Rate Service List Error', 'cn' => '获取评价服务错误');
		$errorinfo[590] = array('en' => 'Shop Service Unavailable', 'cn' => '店铺服务不可用');
		$errorinfo[591] = array('en' => 'Shop Showcase Remain Count Unavailable', 'cn' => '店铺剩余橱窗推荐服务不可用');
		$errorinfo[592] = array('en' => 'Shop Seller Category Service Unavailable', 'cn' => '卖家自定义类目服务不可用');
		$errorinfo[594] = array('en' => 'Shop Seller Category Insert Error', 'cn' => '卖家自定义类目添加错误');
		$errorinfo[595] = array('en' => 'Shop Seller Category Update Error', 'cn' => '卖家自定义类目更新错误');
		$errorinfo[596] = array('en' => 'No Shop for This User', 'cn' => '用户没有店铺');
		$errorinfo[597] = array('en' => 'Shop Seller Parent Category Error', 'cn' => '卖家自定义父类目错误');
		$errorinfo[540] = array('en' => 'Trade Stat Service Unavailable', 'cn' => '交易统计服务不可用');
		$errorinfo[541] = array('en' => 'Category Stat Service Unavailable', 'cn' => '类目统计服务不可用');
		$errorinfo[542] = array('en' => 'Item Stat Service Unavailable', 'cn' => '商品统计服务不可用');
		$errorinfo[601] = array('en' => 'User not Exists', 'cn' => '用户不存在');
		$errorinfo[610] = array('en' => 'Product Service Unavailable', 'cn' => '产品服务不可用');
		$errorinfo[710] = array('en' => 'Taobaoke Service Unavailable', 'cn' => '淘宝客服务不可用');
		$errorinfo[611] = array('en' => 'Product Number Format Exception', 'cn' => '产品数据格式错误');
		$errorinfo[612] = array('en' => 'Product ID Incorrect', 'cn' => '产品ID错误');
		$errorinfo[613] = array('en' => 'Product Image Delete Error', 'cn' => '删除产品图片错误');
		$errorinfo[614] = array('en' => 'No Permission to Add Product', 'cn' => '没有权限添加产品');
		$errorinfo[615] = array('en' => 'Delivery Address Service Unavailable', 'cn' => '收货地址服务不可用');
		$errorinfo[620] = array('en' => 'Postage Service Unavailable', 'cn' => '邮费服务不可用');
		$errorinfo[621] = array('en' => 'Postage Mode Type Error', 'cn' => '邮费模板类型错误');
		$errorinfo[622] = array('en' => 'Missing Parameter: post, express or ems', 'cn' => '缺少参数：post, express或ems');
		$errorinfo[623] = array('en' => 'Postage Mode Parameter Error', 'cn' => '邮费模板参数错误');
		$errorinfo[630] = array('en' => 'Combo Service Unavailable', 'cn' => '收费服务不可用');
		$errorinfo[650] = array('en' => 'Refund Service Unavailable', 'cn' => '退款服务不可用');
		$errorinfo[651] = array('en' => 'Refund ID Invalid', 'cn' => '非法的退款编号');
		$errorinfo[652] = array('en' => 'Refund Service Unavailable', 'cn' => '退款服务不可用');
		$errorinfo[653] = array('en' => 'Refund not Exists', 'cn' => '退款不存在');
		$errorinfo[654] = array('en' => 'No Permission to Get Refund', 'cn' => '没有权限获取退款信息');
		$errorinfo[655] = array('en' => 'No Permission to Add Refund Message', 'cn' => '没有权限添加退款留言');
		$errorinfo[656] = array('en' => 'Cannot add Refund Message for STATUS_CLOSED(4) or STATUS_SUCCESS(5)', 'cn' => '无法添加退款留言');
		$errorinfo[657] = array('en' => 'Refund Message Content Too Long', 'cn' => '退款留言内容太长');
		$errorinfo[658] = array('en' => 'Refund Message Content Cannot be NULL', 'cn' => '退款留言内容不能为空');
		$errorinfo[659] = array('en' => 'Biz Order ID is Invalid', 'cn' => '非法的交易订单（或子订单）ID');
		$errorinfo[660] = array('en' => 'Item Extra Service Unavailable', 'cn' => '商品扩展服务不可用');
		$errorinfo[661] = array('en' => 'Item Extra not Exists', 'cn' => '商品扩展信息不存在');
		$errorinfo[662] = array('en' => 'No Permission Update Item Extra', 'cn' => '没有权限更新商品扩展信息');
		$errorinfo[663] = array('en' => 'Shipping Parameter Missing', 'cn' => '缺少物流参数');
		$errorinfo[664] = array('en' => 'Shipping Parameter Error', 'cn' => '物流参数错误');
		$errorinfo[670] = array('en' => 'Commission Service Unavailable', 'cn' => '佣金服务不可用');
		$errorinfo[671] = array('en' => 'Commission Trade not Exists', 'cn' => '佣金交易不存在');
		$errorinfo[672] = array('en' => 'Payment Service Unavailable', 'cn' => '淘宝客报表服务不可用');
		$errorinfo[673] = array('en' => 'ICP Service Unavailable', 'cn' => '备案服务不可用');
		$errorinfo[674] = array('en' => 'App Service Unavailable', 'cn' => '应用服务不可用');
		$errorinfo[900] = array('en' => 'Remote Connection Error', 'cn' => '远程连接错误');
		$errorinfo[901] = array('en' => 'Remote Service Timeout', 'cn' => '远程服务超时');
		$errorinfo[902] = array('en' => 'Remote Service Error', 'cn' => '远程服务错误');
		$errorinfo[100] = array('en' => '授权码已经过期', 'cn' => '授权码已经过期');
		$errorinfo[101] = array('en' => '授权码在缓存里不存在，一般是用同样的authcode两次获取sessionkey', 'cn' => '授权码在缓存里不存在，一般是用同样的authcode两次获取sessionkey');
		$errorinfo[103] = array('en' => 'appkey或者tid（插件ID）参数必须至少传入一个', 'cn' => 'appkey或者tid（插件ID）参数必须至少传入一个');
		$errorinfo[104] = array('en' => 'appkey或者tid对应的插件不存在', 'cn' => 'appkey或者tid对应的插件不存在');
		$errorinfo[105] = array('en' => '插件的状态不对，不是上线状态或者正式环境下测试状态', 'cn' => '插件的状态不对，不是上线状态或者正式环境下测试状态');
		$errorinfo[106] = array('en' => '没权限调用此app，由于插件不是所有用户都默认安装，所以需要用户和插件进行一个订购关系。', 'cn' => '没权限调用此app，由于插件不是所有用户都默认安装，所以需要用户和插件进行一个订购关系。');
		$errorinfo[108] = array('en' => '由于app有绑定昵称，而登陆的昵称不是绑定昵称，所以没权限访问。', 'cn' => '由于app有绑定昵称，而登陆的昵称不是绑定昵称，所以没权限访问。');
		$errorinfo[109] = array('en' => '服务端在生成参数的时候出了问题（一般是tair有问题）', 'cn' => '服务端在生成参数的时候出了问题（一般是tair有问题）');
		$errorinfo[110] = array('en' => '服务端在写出参数的时候出了问题', 'cn' => '服务端在写出参数的时候出了问题');
		$errorinfo[111] = array('en' => '服务端在生成参数的时候出了问题（一般是tair有问题）', 'cn' => '服务端在生成参数的时候出了问题（一般是tair有问题）');

		if(!array_key_exists($errorcode, $errorinfo)) {
			$errorcode = 0;
		}

		return $errorinfo[$errorcode];
	}



	public function WriteError($error, $paramArr) {
		$errorpath       = DDROOT.'/data/temp/taoapi_error_log';
		$errorinfotext[] = date('Y-m-d H:i:s');
		$errorinfotext[] = "Error:".$error['msg'];
		foreach($paramArr as $key => $value) {
			$errorinfotext[] = $key." : ".$value;
		}
		$errorinfotext = implode("\t", $errorinfotext)."\r\n".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\r\n";
		create_file($errorpath.'/'.date('Y-m-d').'.log', $errorinfotext, 1);
	}



	public function ViewError($error, $paramArr = NULL, $closeerror = FALSE, $Errorlog = 0) {
		$debug = debug_backtrace(FALSE);
		rsort($debug);
		if(is_array($error)) {
			if($error['code'] < 100) {
				$errorlevel = '系统级错误 ';
			} else {
				$errorlevel = '业务级错误';
			}
			$errortitle = $this->ErrorInfo($error['code']);

			$errortitle       = $errortitle ? $errortitle : array('en' => $error['sub_code'], 'cn' => $error['sub_msg']);
			$this->_ErrorInfo = @implode("\n", $errortitle);
			$errortitle       = (object)$errortitle;
			if($Errorlog == 1) {
				$this->WriteError($error, $paramArr);
			}
			if($closeerror) {
				return FALSE;
			}
			$errortitlediy = $errorlevel.": ".$errortitle->en." (".$errortitle->cn.")";
		} else {
			$errortitlediy = $error;
		}

		$view[] = "<br /><font size='1'><table dir='ltr' border='1' cellspacing='0' cellpadding='1' width=\"100%\">";

		$view[] = "<tr><th align='left' bgcolor='#f57900' colspan=\"3\"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> ".$errortitlediy." in ".$debug[count($debug) - 2]['file']." on line <i>".$debug[count($debug) - 2]['line']."</i></th></tr>";

		$view[]   = "<tr><th align='left' bgcolor='#e9b96e' colspan='3'>调用函数</th></tr>";
		$view[]   = "<tr><th align='center' bgcolor='#eeeeec' width='30'>#</th><th align='left' bgcolor='#eeeeec'>函数名</th><th align='left' bgcolor='#eeeeec'>所在文件</th></tr>";
		$mainfile = basename($debug[0]['file']);

		$view[] = "<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec'>{main}(  )</td><td bgcolor='#eeeeec'>../{$mainfile}<b>:</b>0</td></tr>";

		foreach($debug as $key => $value) {
			$value['file'] = basename($value['file']);
			$key           = $key + 2;
			$view[]        = "<tr><td bgcolor='#eeeeec' align='center'>$key</td><td bgcolor='#eeeeec'>{$value['class']}{$value['type']}{$value['function']}(  )</td><td title='{$value['file']}' bgcolor='#eeeeec'>../{$value['file']}<b>:</b>{$value['line']}</td></tr>";
		}

		$view[] = '</table></font>';
		if($paramArr) {
			$view[] = "<br /><font size='1'><table dir='ltr' border='1' cellspacing='0' cellpadding='1' width=\"100%\">";
			$view[] = "<tr><th align='left' bgcolor='#e9b96e' colspan='4' height='25px'>淘宝API 调用参数列表</th></tr>";
			$view[] = "<tr><th align='center' bgcolor='#eeeeec' width='30px'>#</th><th width='120' align='left' bgcolor='#eeeeec'>参数名称</th><th align='left' bgcolor='#eeeeec'>参数</th><th align='left' bgcolor='#eeeeec' width='50px'>长度</th></tr>";
			$i      = 1;
			foreach($paramArr as $key => $value) {
				$view[] = "<tr><td bgcolor='#eeeeec' align='center'>$i</td><td bgcolor='#eeeeec'>{$key}</td><td bgcolor='#eeeeec'>".implode(', ', explode(',', $value))."</td><td bgcolor='#eeeeec'><b>".strlen($value)."</b></td></tr>";
				$i++;
			}
			$view[] = "<tr><th align='left' bgcolor='#eeeeec' colspan='4' height='25px'>有任何问题请登录：<a href='http://www.taoapi.com' target='_blank'>淘宝TOP外部测试平台(Taoapi.com)</a> 进行咨询! 当前SDK版本：V2.3</th></tr>";
			$view[] = '</table></font>';
		}

		$this->_ErrorInfo = implode("\n", $view);
	}
}


function html_img($pic_url, $type = '', $alt = '', $class = '', $width = '', $height = '', $onerror_pic = '') { //type大于10为不给图片进行js加密，类型再去个位数
	if($onerror_pic == '') {
		$onerror_pic = SITEURL.'/images/dian.png';
	}
	if($type >= 10) {
		$img_type = $type % 10;
	} else {
		$img_type = $type;
	}
	switch($img_type) {
		case 1:
			$pic_url = $pic_url."_100x100.jpg";
			break;
		case 2:
			$pic_url = $pic_url."_b.jpg";
			break;
		case 3:
			$pic_url = $pic_url."_310x310.jpg";
			break;
	}
	$pic_url = base64_encode($pic_url);
	if($type >= 10) {
		if($alt != '') {
			$alt = 'alt="'.$alt.'"';
		}
		if($class != '') {
			$class = 'class="'.$class.'"';
		}
		if($width > 0) {
			$width = 'width:'.$width.'px';
		} else {
			$width = '';
		}
		if($height > 0) {
			$height = ';height:'.$height.'px';
		} else {
			$height = '';
		}
		$onerror = 'onerror="this.src=\''.$onerror_pic.'\'"';
		$re      = "<img src='".base64_decode($pic_url)."' ".$alt." ".$class." style='".$width." ".$height."' ".$onerror."/>";
	} elseif(PICJM == 0) {
		if(strpos($alt, "'") !== FALSE) {
			$alt = str_replace("'", '', $alt);
		}

		$re = "<SCRIPT language=javascript>setPic('".$pic_url."','".$width."','".$height."','".$alt."','".$class."','".$onerror_pic."');</SCRIPT>";
	} elseif(PICJM == 1) {
		$pic_url = urlencode($pic_url);
		if($alt != '') {
			$alt = 'alt="'.$alt.'"';
		}
		if($class != '') {
			$class = 'class="'.$class.'"';
		}
		if($width > 0) {
			$width = 'width:'.$width.'px';
		} else {
			$width = '';
		}
		if($height > 0) {
			$height = ';height:'.$height.'px';
		} else {
			$height = '';
		}
		$onerror = 'onerror="this.src=\''.$onerror_pic.'\'"';
		if(PICWJT == 0) {
			$re = "<img src='".SITEURL."/comm/showpic.php?pic=".$pic_url."' ".$alt." ".$class." style='".$width." ".$height."' ".$onerror."/>";
		} else {
			$re = "<img src='".SITEURL."/tbimg/".$pic_url.".jpg' ".$alt." ".$class." style='".$width." ".$height."' ".$onerror."/>";
		}
	}

	return $re;
}
class collect {
	public $num = 3;
	public $val = '';
	public $connect_timeout = 20; //超时时间
	public $head='';
	public $charset='utf-8';
	public $target_charset='utf-8';
	public $sock_name='';
	public $set_func='';

	function fun($url, $method) {
		if($this->set_func!=''){
			$set_func=$this->set_func;
			return $this->$set_func($url,$method);
		}
		$collect=dd_get_cache('collect');
		foreach($collect as $k=>$v){
			if($k=='fsockopen'){
				if(function_exists('fsockopen')){
					$this->sock_name='fsockopen';
				}
				elseif(function_exists('pfsockopen')){
					$this->sock_name='pfsockopen';
				}
				if($this->sock_name!=''){
					return $this->fsockopen($url,$method);
				}
			}
			elseif($k=='curl' && function_exists('curl_exec')){
				return $this->curl($url,$method);
			}
			elseif($k=='file_get_contents' && function_exists('file_get_contents')){
				return $this->file_get_contents($url,$method);
			}
		}
	}

	function file_get_contents($url, $method = 'get') {
		$context['http'] = array (
			'timeout' => $this->connect_timeout,
		);
		if(!empty($this->head)){
			$context['http']['header']=$this->head;
		}
		if ($method == 'get') {
			$output = file_get_contents($url,0,stream_context_create($context));
			return $output;
		} else {
			$a = explode('?', $url);
			$context['http']['method']='POST';
			$context['http']['content']=$a[1];
			$output = file_get_contents($a[0], false, stream_context_create($context));
			return $output;
		}
	}

	function curl($url, $method = 'get') {
		$urlinfo = parse_url($url);
		if (empty ($urlinfo['path'])) {
			$urlinfo['path'] = '/';
		}
		$host = $urlinfo['host'];
		if(!array_key_exists('query',$urlinfo)){
			$urlinfo['query']='';
		}
		$uri = $urlinfo['path'] . $urlinfo['query'];

		//$header[]= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; zh-CN; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1\r\n";
		//$header[]= "Referer: http://" . $urlinfo['host'] . "\r\n";
		//$header[]= "Connection: Close\r\n\r\n";

		/* 开始一个新会话 */
		$curl_session = curl_init();

		/* 基本设置 */
		curl_setopt($curl_session, CURLOPT_FORBID_REUSE, true); // 处理完后，关闭连接，释放资源
		curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true); //把结果返回，而非直接输出
		curl_setopt($curl_session, CURLOPT_FOLLOWLOCATION,1);  //是否抓取跳转后的页面
		curl_setopt($curl_session, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout); //超时时间

		if(preg_match('|^https://|',$url)==1){
			curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl_session, CURLOPT_SSL_VERIFYHOST,  false);
		}

		$url_parts = $this->parse_raw_url($url);

		if ($method == 'get') {
			$header[]= "GET " . $urlinfo['path'] . "?" . $urlinfo['query'] . " HTTP/1.1\r\n";
			$header[]= "Host: " . $urlinfo['host'] . "\r\n";
			curl_setopt($curl_session, CURLOPT_HTTPGET, true);
		} else {
			$a = explode('?', $url);
			$url = $a[0];
			$params = $a[1];
			curl_setopt($curl_session, CURLOPT_POST, true);
			curl_setopt($curl_session, CURLOPT_POSTFIELDS, $params);
			//$header[]= "POST " . $urlinfo['path'] . " HTTP/1.1\r\n";
			//$header[]= "Host: " . $urlinfo['host'] . "\r\n";
			//$header[] = 'Content-Type: application/x-www-form-urlencoded';
			//$header[] = 'Content-Length: ' . strlen($params);
		}

		/* 设置请求地址 */
		curl_setopt($curl_session, CURLOPT_URL, $url);

		/* 设置头部信息 */
		if(!empty($this->head)){
			unset($header);
			$header=array($this->head);
		}
		curl_setopt($curl_session, CURLOPT_HTTPHEADER, $header);

		$http_response = curl_exec($curl_session);
		curl_close($curl_session);
		return $http_response;
	}

	function fsockopen($url,$method='get', $time_out = "15"){
		$urlarr = parse_url($url);
		$errno = "";
		$errstr = "";
		$transports = "";
		if ($urlarr["scheme"] == "https") {
			$transports = "ssl://";
			$urlarr["port"] = "443";
		} else {
			$transports = "";  //加tcp://有些主机就出错
			$urlarr["port"] = "80";
		}
		$sock=$this->sock_name;
		$fp =  $sock($transports . $urlarr['host'], $urlarr['port'], $errno, $errstr, $this->connect_timeout);
		if (!$fp) {
			//die("ERROR: $errno - $errstr<br />\n");
		} else {
			if(!isset($urlarr["query"])){
				$urlarr["query"]='';
				$url_query='';
			}
			else{
				$url_query=$urlarr["query"];
				$urlarr["query"]='?'.$urlarr["query"];
			}
			if(!isset($urlarr["path"])){
				$urlarr["path"]='/';
			}
			if($method=='get'){
				$headers="GET " . $urlarr["path"].$urlarr["query"] . " HTTP/1.0\r\n";
				$headers.="Host: " . $urlarr["host"] . "\r\n";
				//$headers.="Host: " . $urlarr["host"] . "\r\n";
				//$headers.="Host: " . $urlarr["host"] . "\r\n";
			}
			elseif($method=='post'){
				$headers="POST " . $urlarr["path"].$urlarr["query"] . " HTTP/1.0\r\n";
				$headers.="Host: " . $urlarr["host"] . "\r\n";
				$headers.="Content-type: application/x-www-form-urlencoded\r\n";
				$headers.="Content-length: " . strlen($url_query) . "\r\n";
				$headers.="Accept: */*\r\n";
				$headers.="\r\n".$url_query."\r\n";
			}

			//$headers .='User-Agent: Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)\r\n';
			if(!empty($this->head)){
				//unset($headers);
				$headers.=$this->head."\r\n";
			}
			$headers .= "\r\n";

			fputs($fp, $headers, strlen($headers));
			$info='';
			$temp_info='';
			$body=0;
			while (!feof($fp)) {
				$temp_info=fgets($fp,500000);
				if($temp_info == "\r\n" || $body==1){
					$info.=$temp_info;
					$body=1;
				}
			}
		}
		fclose($fp);
		return trim($info);
	}

	function parse_raw_url($raw_url) {
		$retval = array ();
		$raw_url = (string) $raw_url;

		// make sure parse_url() recognizes the URL correctly.
		if (strpos($raw_url, '://') === false) {
			$raw_url = 'http://' . $raw_url;
		}

		// split request into array
		$retval = parse_url($raw_url);

		// make sure a path key exists
		if (!isset ($retval['path'])) {
			$retval['path'] = '/';
		}

		// set port to 80 if none exists
		if (!isset ($retval['port'])) {
			$retval['port'] = '80';
		}

		return $retval;
	}

	function generate_crlf()
	{
		$crlf = '';

		if (strtoupper(substr(PHP_OS, 0, 3) === 'WIN'))
		{
			$crlf = "\r\n";
		}
		elseif (strtoupper(substr(PHP_OS, 0, 3) === 'MAC'))
		{
			$crlf = "\r";
		}
		else
		{
			$crlf = "\n";
		}

		return $crlf;
	}

	function get($url,$method='get') {
		/*if(!preg_match('/^http/',$url)){
		    return file_get_contents($url);
		}*/

		if(preg_match('#^http://\w+\.duoduo123\.com#',$url)==1){
			$this->set_func='file_get_contents';
		}
		$a = $this->fun($url,$method);
		$this->num--;
		if ($this->num > 0 && ($a=='' || $a=='null')) {
			$a = $this->get($url);
		}
		else {
			if($this->charset!=$this->target_charset){
				$a=iconv($this->target_charset,$this->charset.'//IGNORE',$a);
			}
			$this->val = $a;
		}
	}

	function get_xml($url){
		$this->get($url);
		$xml=$this->val;
		if($this->charset!=$this->target_charset){
			$xml=str_replace($this->target_charset,$this->charset,$xml);
		}

		$xmlCode = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		$arrdata = $this->get_object_vars_final($xmlCode);
		return $arrdata;
	}

	function get_json($url){
		$this->get($url);
		$json=$this->val;
		$arrdata = dd_json_decode($json,1);
		return $arrdata;
	}

	function get_object_vars_final($obj) {
		if (is_object($obj)) {
			$obj = get_object_vars($obj);
		}

		if (is_array($obj)) {
			foreach ($obj as $key => $value) {
				$obj[$key] = $this->get_object_vars_final($value);
			}
		}
		return $obj;
	}

	function curl_get_http_status($url){
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_HEADER,1);
		curl_setopt($curl,CURLOPT_NOBODY,1);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION,0);
		curl_exec($curl);
		$rtn= curl_getinfo($curl,CURLINFO_HTTP_CODE);
		curl_close($curl);
		return  $rtn;
	}

	function fsockopen_get_http_status($url = "localhost", $port = 80, $fsock_timeout = 10) {
		ignore_user_abort(true); // 记录开始时间
		list ($usec, $sec) = explode(" ", microtime());
		$timer['start'] = (float) $usec + (float) $sec; // 校验URL
		if (!preg_match("/^https?:\/\//i", $url)) {
			$url = "http://" . $url;
		} // 支持HTTPS
		if (preg_match("/^https:\/\//i", $url)) {
			$port = 443;
		} // 解析URL
		$urlinfo = parse_url($url);
		if (empty ($urlinfo['path'])) {
			$urlinfo['path'] = '/';
		}
		$host = $urlinfo['host'];
		$uri = $urlinfo['path'] . (empty ($urlinfo['query']) ? '' : $urlinfo['query']); // 通过fsock打开连接
		if (!$fp = fsockopen($host, $port, $errno, $error, $fsock_timeout)) {
			list ($usec, $sec) = explode(" ", microtime(true));
			$timer['end'] = (float) $usec + (float) $sec;
			$usetime = (float) $timer['end'] - (float) $timer['start'];
			return array (
				'code' => -1,
				'usetime' => $usetime
			);
		} // 提交请求
		$status = socket_get_status($fp);
		$out = "GET {$uri} HTTP/1.1\r\n";
		$out .= "Host: {$host}\r\n";
		$out .= "Connection: Close\r\n\r\n";
		$write = fwrite($fp, $out);
		if (!$write) {
			list ($usec, $sec) = explode(" ", microtime(true));
			$timer['end'] = (float) $usec + (float) $sec;
			$usetime = (float) $timer['end'] - (float) $timer['start'];
			return array (
				'code' => -2,
				'usetime' => $usetime
			);
		}
		$ret = fgets($fp, 1024);
		preg_match("/http\/\d\.\d\s(\d+)/i", $ret, $m);
		$code = $m[1];
		fclose($fp);
		list ($usec, $sec) = explode(" ", microtime());
		$timer['end'] = (float) $usec + (float) $sec;
		$usetime = (float) $timer['end'] - (float) $timer['start'];
		return $code;
		//	return array (
		//		'code' => $code,
		//		'usetime' => $usetime
		//	);
	}

	function get_http_status($url){
		if (function_exists('curl_exec')) {
			return $this->curl_get_http_status($url);
		}
		elseif(function_exists('fsockopen')){
			return $this->fsockopen_get_http_status($url);
		}
	}
}
function dd_get($url,$method='get'){
	$c=fs('collect');
	$c->get($url,$method);
	return $c->val;
}

function fs($class) {
	if(!class_exists($class)) {
		include(DDROOT.'/comm/'.$class.'.class.php');
	}
	static $classes = array();
	if(!isset($classes[$class]) || $classes[$class] === NULL) {
		$classes[$class] = new $class();
		//unset($class);
	}

	return $classes[$class];
}

function dd_replace($str, $arr = array()) {
	if(REPLACE == 0) {
		return $str;
	}

	if(REPLACE < 3) {
		$noword_tag = '';
	} else {
		$noword_tag = '3';
	}

	if(empty($arr)) {
		$arr = dd_get_cache('no_words'.$noword_tag);
	}

	if(REPLACE == 1 && !empty($arr)) {
		$str = strtr($str, $arr);
		//print_r($str);exit;
	} elseif(REPLACE == 2) {
		foreach($arr as $a => $b) {
			if(strpos($str, (string)$a) !== FALSE) {
				if(MOD == 'ajax') {
					$re = array('s' => 0, 'id' => 55);
					dd_exit(json_encode($re));
				} else {
					error_html('商品不存在！', -1);
				}
			}
		}
	} elseif(REPLACE == 3) {
		foreach($arr as $k => $row) {
			$title_split = implode('(.*)', $row['title_arr']);
			$replace     = $row['replace'];
			if(preg_match('/'.$title_split.'/', $str) == 1) {
				if(MOD == 'ajax') {
					$re = array('s' => 0, 'id' => 55);
					dd_exit(json_encode($re));
				} else {
					error_html('商品不存在！', -1);
				}
			}
		}
	}

	return $str;
}
function dd_json_decode($value, $type = 1) {
	if(DDJSON == 1 || !function_exists('json_decode')) {
		$json = fs('DD_Services_JSON');
		$arr  = $json->decode($value, TRUE);
		if(empty($arr) && function_exists('json_decode')) {
			$arr = json_decode($value, 1);
		}

		return $arr;
	} else {
		return json_decode($value, 1);
	}
}

?>