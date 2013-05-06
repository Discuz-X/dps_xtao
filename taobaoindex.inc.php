<?php !defined('IN_DISCUZ') && exit('Access Denied');
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'init.php';



//导航标题
$plugintitle = $navtitle;

$goodkeywords = !empty($_C['goodkeywords']) ? $_C['goodkeywords'] : '';

$indexgoods = !empty($_C['indexgoods']) ? $_C['indexgoods'] : '女装';

$conv = new Convert;
if(strtolower($_G['config']['output']['charset']) == 'gbk') {
	$conv->convert   = TRUE;
	$conv->localcode = 'gbk';
} else {
	$conv->convert = FALSE;
}
$c = new TopClient;
$c->appkey = $appkey;
aiodebug($appkey, 'App key', $debug);
$c->secretKey = $appsecret;
aiodebug($appsecret, 'App secret', $debug);
$c->format = 'json';

$keywords = array();
$keywords = explode(',', $goodkeywords);
for($i = 0; $i < count($arraykey); $i++) {
	$keywords[] = $arraykey[$i];
}

if($mod == 'view') {
	$iid = !empty($_GET['iid']) ? addslashes($_GET['iid']) : showmessage(lang('plugin/abis_shops', 'error_noiids'));
	$req = new TaobaokeItemsDetailGetRequest;
	$req->setFields('pic_url,num_iid,title,nick,desc,create,num,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,click_url,shop_click_url,seller_credit_score');
	$req->setNumIids($iid);
	$req->setNick($conv->req($taokeusername));
	$resp = $c->execute($req);
	if(empty($resp->total_results)) {
		showmessage(lang('plugin/abis_shops', 'error_noproduct'));
	}
	$i                           = $resp->taobaoke_item_details->taobaoke_item_detail[0];
	$item                        = array();
	$item['click_url']           = base64_encode($i->click_url);
	$item['seller_credit_score'] = $i->seller_credit_score;
	$item['shop_click_url']      = base64_encode($i->shop_click_url);
	$item['item']                = array();
	foreach($i->item as $key => $val) {
		$val                = $conv->disp($val);
		$item['item'][$key] = $val;
	}

	//加工市场价
	if($item['item']['price'] <= 100) {
		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod1));

	} else if($item['item']['price'] > 100 and $item['item']['price'] <= 500) {
		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod2));
	} else if($item['item']['price'] > 500 and $item['item']['price'] <= 1000) {
		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod3));
	} else if($item['item']['price'] > 1000 and $item['item']['price'] <= 3000) {
		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod4));
	} else if($item['item']['price'] > 3000 and $item['item']['price'] <= 5000) {
		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod5));
	} else {
		$item['item']['fakeprice'] = sprintf('%01.2f', floor($item['item']['price'] * $price_mod6));

	}

	//得到标题
	if(!empty($item['item']['title'])) {
		$thisnav  = $item['item']['title'];
		$navtitle = $item['item']['title'].' - '.$plugintitle;

	}
} else {
	$page    = intval($_GET['page']) != 0 ? intval($_GET['page']) : 1;
	$keyword = dhtmlspecialchars(rawurldecode($_GET['keyword']));
	$sort    = dhtmlspecialchars(rawurldecode($_GET['sort']));
	$cid     = dhtmlspecialchars(rawurldecode($_GET['cid']));

	//得到标题
	if(empty($cid) and empty($keyword)) { //关键字和分类都为空
		$navtitle = $plugintitle;
		$thisnav  = '';
	} else if(!empty($cid) and empty($keyword)) {
		$thisnav  = '';
		$navtitle = $thisnav.' - '.$plugintitle;

	} else if(empty($cid) and !empty($keyword)) {
		$navtitle = $keyword.' - '.$plugintitle;
		$thisnav  = $keyword.'';
	} else if(!empty($cid) and !empty($keyword)) {
		$navtitle = $keyword.'-'.$plugintitle;
		$thisnav  = $keyword.'';
	}

	//得到导航
	$thisnav = '';
	if(empty($keyword)) { //关键字和分类都为空
		$thisnav = $indexgoods;
	} else {
		$thisnav = $keyword;
	}
	if(empty($cid)) {
		$cid = 0;
	} else {
		$thisnav = '';
	}


	//得到排序
	if(empty($sort)) {
		$sort = commissionNum_desc;
	}

	$ppp = !empty($_C['page_size']) ? intval($_C['page_size']) : showmessage(lang('plugin/abis_shops', 'error_nopagesize'));
	$ppp = $ppp > 40 ? 40 : $ppp;

	include 'sdk/request/TaobaokeItemsGetRequest.php';
	$req = new TaobaokeItemsGetRequest;
	$req->setPageNo($page);
	$req->setPageSize($ppp);
	$req->setSort($sort);
	$req->setFields('num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume');

	if(empty($cid) and empty($keyword)) { //关键字和分类都为空
		$keyword = $indexgoods;
		$req->setKeyword($conv->req($keyword));
		$keyword = NULL;
	} else if(!empty($cid) and empty($keyword)) {
		$req->setCid($conv->req($cid));
	} else if(empty($cid) and !empty($keyword)) {
		$req->setKeyword($conv->req($keyword));
	} else if(!empty($cid) and !empty($keyword)) {
		$req->setKeyword($conv->req($keyword));
	}

	if(!empty($taokepid)) {
		aiodebug($taokepid, 'taoke pid', $debug);
		$req->setPid($taokepid);
	} elseif(!empty($taokeusername)) {
		aiodebug($taokeusername, 'taoke username', $debug);
		$req->setNick($conv->req($taokeusername));
	} else {
		showmessage(lang('plugin/abis_shops', 'error_nouser'));
	}
	$resp = $c->execute($req);
	aiodebug($resp, 'response', $debug);
	$total = $resp->total_results;
	$total = $total > $ppp * 100 ? $ppp * 100 : $total;
	$items = array();
	foreach($resp->taobaoke_items->taobaoke_item as $i) {
		$item                   = get_object_vars($i);
		$item['title']          = $conv->disp($item['title']);
		$item['item_location']  = $conv->disp($item['item_location']);
		$item['nick']           = $conv->disp($item['nick']);
		$item['click_url']      = base64_encode($item['click_url']);
		$item['shop_click_url'] = base64_encode($item['shop_click_url']);

		//加工市场价
		if($item['price'] <= 100) {
			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod1));

		} else if($item['price'] > 100 and $item['price'] <= 500) {
			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod2));
		} else if($item['price'] > 500 and $item['price'] <= 1000) {
			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod3));
		} else if($item['price'] > 1000 and $item['price'] <= 3000) {
			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod4));
		} else if($item['price'] > 3000 and $item['price'] <= 5000) {
			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod5));
		} else {
			$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod6));
		}

		$items[] = $item;
	}

	$pageurl = 'plugin.php?id=abis_shops:tbindex&cid='.rawurlencode($cid).'&keyword='.rawurlencode($keyword).'&sort='.$sort;
	$multi   = multi($total, $ppp, $page, $pageurl);

	/*
	if(!empty($keyword)) {
		$navtitle = $keyword.'-'.$plugintitle;
		$thisnav = $keyword.'';
	}
	*/
}
include template(IDENTIFIER.':taobaoindex');


?>
