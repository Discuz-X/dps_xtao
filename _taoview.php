<?php defined('IN_DISCUZ') || die('Access Denied');


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
function get_tao_id($_url, $tao_id_arr = array()) {
	if(empty($tao_id_arr)) {
		$tao_id_arr = array(
			'id',
			'Id',
			'item_num_id',
			'default_item_id',
			'item_id',
			'itemId',
			'mallstItemId',
			//'tradeID'  http://trade.taobao.com/trade/detail/tradeSnap.htm?tradeID=147485513698005
		);
	}
	//$ids = '/[&|?]('.implode('|', $tao_id_arr).')=(\d+)/i';
	$ids = '/\b(?:'.implode('|', $tao_id_arr).')=(\d+)/i';
	preg_match($ids, $_url, $b);
	if($b[1] != '') return $b[1];
	preg_match('#/i(\d+)\.htm#', $_url, $b);
	return $b[1];
}

$tao_id_arr = array(
	'id',
	'Id',
	'item_num_id',
	'default_item_id',
	'item_id',
	'itemId',
	'mallstItemId',
	//'tradeID'  http://trade.taobao.com/trade/detail/tradeSnap.htm?tradeID=147485513698005
);
//	//$shield_cid  = include(DDROOT.'/data/shield_cid.php');
//	$shield_cid = array(0 => 50012829, 1 => 50003114, 2 => 50012831, 3 => 50012832, 4 => 50012830, 5 => 50006275, 6 => 50019617, 7 => 50019618, 8 => 50019619, 9 => 50019620, 10 => 50019621, 11 => 50019622, 12 => 50019623, 13 => 50019624, 14 => 50019625, 15 => 50019626, 16 => 50019627, 17 => 50019628, 18 => 50019629, 19 => 50019630, 20 => 50019631, 21 => 50019636, 22 => 50019637, 23 => 50019638, 24 => 50019639, 25 => 50019640, 26 => 50019641, 27 => 50019642, 28 => 50019643, 29 => 50019644, 30 => 50019692, 31 => 50019693, 32 => 50019645, 33 => 50019646, 34 => 50019698, 35 => 50019699, 36 => 50019700, 37 => 50019647, 38 => 50019651, 39 => 50019652, 40 => 50019653, 41 => 50019654, 42 => 50019655, 43 => 50019656, 44 => 50019657, 45 => 50019658, 46 => 50019659, 47 => 50019660, 48 => 50019661, 49 => 50019662, 50 => 50019663, 51 => 50019664, 52 => 50019665, 53 => 50020206, 54 => 50020205, 55 => 50050327, 2813);
//	//$virtual_cid = include(DDROOT.'/data/virtual_cid.php');
//	$virtual_cid = array('goods' => array(0 => 150401, 1 => 150402, 2 => 50011814, 3 => 150406), 'shop' => array(1103, 1041, 1102, 35, 36));
//	if(empty($iid)) {
//		$iid = isset($_GET['iid']) ? (float)$_GET['iid'] : '';
//	}
$promotion_name = $_GET['promotion_name'] ? $_GET['promotion_name'] : '促销打折';
$price_name     = '一&nbsp;口&nbsp;价';

$is_url  = 0;
$is_mall = 0;
$is_ju   = 0;
$url     = '';


if(preg_match('/(taobao\.com|tmall\.com)/', $keyword)) {
	$is_url = 1;
	$url    = $keyword;
	$iid    = (float)get_tao_id($keyword, $tao_id_arr);
	if($iid == 0) {
		showmessage('请使用标准淘宝商品网址搜索！');
	}
	$ju_url  = 'http://a.m.taobao.com/i'.$iid.'.htm';
	$ju_html = file_get_contents($ju_url);
	if($ju_html == '') { //个别主机不能采集淘宝手机页面
		$ju_url  = 'http://ju.taobao.com/tg/home.htm?item_id='.$iid;
		$ju_html = dd_get($ju_url);
		if($ju_html != '' && strpos($ju_html, '<input type="hidden" name="item_id" value="'.$iid.'"') !== false) {
			$is_juhuasuan = 2; //一般网页
		}
	} elseif(strpos($ju_html, '<a name="'.$iid.'"></a>') !== false) {
		$is_juhuasuan = 1; //手机网页
	}

	//die((string)__LINE__);
	if($is_juhuasuan > 0) {
		$keyword = $url = 'http://ju.taobao.com/tg/home.htm?item_id='.$iid;
		if($is_juhuasuan == 1) {
			preg_match('/style="color:#ffffff;">￥(.*)<\/span>/', $ju_html, $a);
		} else {
			preg_match('/<strong class="J_juPrices"><b>&yen;<\/b>(.*)<\/strong>/', $ju_html, $a);
		}
		$ju_price                          = (float)$a[1];
		$goods_type                        = 'ju';
		$jssdk_items_convert['goods_type'] = $goods_type; //聚划算
		$jssdk_items_convert['ju_price']   = $ju_price;
		$price_name                        = '<img src="images/ju-icon.png" alt="聚划算" />';
	} elseif(strpos($keyword, 'tmall.com') !== false) {
		$goods_type                        = 'tmall';
		$jssdk_items_convert['goods_type'] = $goods_type; //天猫
		$price_name                        = '<b style="color:#a91029">天猫正品</b>';
	} else {
		$goods_type                        = 'market';
		$jssdk_items_convert['goods_type'] = $goods_type; //集市
	}
} elseif($iid == 0) {
	if($webset['taoapi']['s8'] == 1) {
		$url = $ddTaoapi->taobao_taobaoke_listurl_get($keyword, $dduser['id']);
		$url = $goods['jump'] = "index.php?mod=jump&act=s8&url=".urlencode(base64_encode($url)).'&name='.urlencode($keyword);
		jump($url);
	} else {
		showmessage('直接搜索淘宝商品网址即可查询返利', 5);
	}
}
$data['iid']        = $iid;
$data['outer_code'] = $dduser['id'];
$data['all_get']    = 1; //商品没有返利也获取商品内容
$data['goods_type'] = $goods_type;
$data['ju_price']   = $ju_price;


$req = new ItemGetRequest;
$req->setFields(
	'iid,detail_url,num_iid,title,nick,type,cid,pic_url,seller_cids,'
	.'num,list_time,delist_time,stuff_status,location,price,post_fee,'
	.'express_fee,ems_fee,has_discount,freight_payer,item_img'.($_C['page_description'] ? ',desc' : '')
);
$req->setNumIid($iid);
//$req->setTrackIid("123_track_456");
$goods = $TopClient->execute($req, $sessionKey)->item;

//var_export($goods->item->price);
//
//
//	if($goods['title'] == '' || $goods['num'] == 0 || ($webset['taoapi']['shield'] == 1 && in_array($goods['cid'], $shield_cid))) {
//		showmessage('商品不存在或已下架或者是违禁商品。<a target="_blank" href="http://item.taobao.com/item.htm?id='.$iid.'">去淘宝确认</a>', -1, 1);
//	}
//
//$jssdk_items_convert['method']      = 'taobao.taobaoke.widget.items.convert';
//$jssdk_items_convert['outer_code']  = (int)$dduser['id'];
//$jssdk_items_convert['user_level']  = (int)$dduser['level'];
//$jssdk_items_convert['num_iids']    = $iid;
//$jssdk_items_convert['allow_fanli'] = $allow_fanli;
//$jssdk_items_convert['cid']         = $goods['cid'];
//$jssdk_items_convert['tmall_fxje']  = (float)$goods['tmall_fxje'];
//$jssdk_items_convert['ju_fxje']     = (float)$goods['ju_fxje'];
//$jssdk_items_convert['goods_type']  = $goods_type;
//
//die((string)__LINE__);
//$nick = $goods['nick'];
//
//	//include(DDROOT.'/mod/tao/shopinfo.act.php'); //店铺信息
//
$req = new ShopGetRequest;
$req->setFields('sid,cid,title,pic_path,created,shop_score,nick');
$req->setNick($goods->nick);
$shop = $TopClient->execute($req, $sessionKey)->shop;

//var_export($goods);
//die((string)__LINE__);

/*
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
 */

if($shop == 104) {
	showmessage('掌柜不存在！');
} else {
	$jssdk_shops_convert['method']       = 'taobao.taobaoke.widget.shops.convert';
	$jssdk_shops_convert['outer_code']   = (int)$dduser['id'];
	$jssdk_shops_convert['user_level']   = (int)$dduser['level'];
	$jssdk_shops_convert['seller_nicks'] = $nick;
	$jssdk_shops_convert['list']         = (int)$list;
	foreach($shop as $k => $v) {
		$jssdk_shops_convert[$k] = $v;
	}
}
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

//$parameter['tao_id_arr']          = $tao_id_arr;
//$parameter['shield_cid']          = $shield_cid;
//$parameter['virtual_cid']         = $virtual_cid;
//$parameter['iid']                 = $iid;
//$parameter['q']                   = $keyword;
//$parameter['promotion_name']      = $promotion_name;
//$parameter['price_name']          = $price_name;
//$parameter['tao_coupon_str']      = $tao_coupon_str;
//$parameter['url']                 = $url;
//$parameter['data']                = $data;
//$parameter['goods']               = $goods;
//$parameter['goods2']              = $goods2;
//$parameter['comment_url']         = $comment_url;
//$parameter['nick']                = $nick;
//$parameter['jssdk_items_convert'] = $jssdk_items_convert;
//$parameter['shop']                = $shop;
//$parameter['jssdk_shops_convert'] = $jssdk_shops_convert;
