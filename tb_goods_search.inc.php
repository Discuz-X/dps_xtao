<?php defined('IN_DISCUZ') || die('Access Denied');
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'init.php';


//插件标题
$navtitle = !empty($_C['navtitle']) ? $_C['navtitle'] : $_G['setting']['bbname'];


$appkey    = !empty($_C['app_key']) ? $_C['app_key'] : showmessage(lang('plugin/abis_shops', 'error_noappkey'));
$appsecret = !empty($_C['app_secret']) ? $_C['app_secret'] : showmessage(lang('plugin/abis_shops', 'error_noappsecret'));

//导航标题
$plugintitle = $navtitle;
//搜索关键字列表
$goodkeywords = !empty($_C['goodkeywords']) ? $_C['goodkeywords'] : '';
//首页默认显示的商品关键字
$indexgoods = !empty($_C['indexgoods']) ? $_C['indexgoods'] : lang('plugin/abis_shops', 'indexdefault_goodkeyword');

//初始化设置
$conv = new Convert;
if(strtolower($_G['config']['output']['charset']) == 'gbk') {
	$conv->convert   = TRUE;
	$conv->localcode = 'gbk';
} else {
	$conv->convert = FALSE;
}

//得到搜索关键字列表
$keywords = array();
$arraykey = explode(',', $goodkeywords);
//$arraykey = get_arraybynum($arraykey, 10);
for($i = 0; $i < count($arraykey); $i++) {
	$keywords[$i][0] = $arraykey[$i];
	$keywords[$i][1] = $arraykey[$i];
}

//如果是商品列表
//得到传值
$page = intval($_GET['page']) != 0 ? intval($_GET['page']) : 1;
$sort = dhtmlspecialchars(rawurldecode($_GET['sort']));
//$keyword = dhtmlspecialchars(rawurldecode($_GET['keyword']));

//得到传值 ，如果没有传值就显示默认首页的商品关键字
$keywordencode = $_GET['keyword'];
if(!empty($keywordencode)) {
	$keyword = $keywordencode;
} else {
	$keyword       = $indexgoods;
	$keywordencode = $indexgoods;

}

//得到排序 默认销量从高到低
if(empty($sort)) {
	$sort = commissionNum_desc; //销量
}

//得到首页要展示商品的关键字 得到导航
$thisnav = '';
if(empty($keyword)) {
	$thisnav = $indexgoods;
} else {
	$thisnav = $keyword;
}

//公共模块===========================================
$ppp = !empty($_C['page_size']) ? intval($_C['page_size']) : showmessage(lang('plugin/abis_shops', 'error_nopagesize'));
$ppp = $ppp > 100 ? 100 : $ppp;

include 'sdk/request/TaobaokeItemsGetRequest.php';
$req = new TaobaokeItemsGetRequest;

$req->setPageNo($page);
$req->setPageSize($ppp);
$req->setSort($sort);
$req->setFields('num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume');


//抓取是关键字
$req->setKeyword($conv->req($keyword));
//===================================================
$c            = new TopClient;
$c->format    = 'json'; //返回数据格式
$c->appkey    = $appkey;
$c->secretKey = $appsecret;
$resp         = $c->execute($req);
//将值给字符串留下面解析
$shopslistjson = $resp;

//转化为页面需要的数据
$total = $shopslistjson->total_results;
$total = $total > $ppp * 10 ? $ppp * 10 : $total;
$items = array();
foreach($shopslistjson->taobaoke_items->taobaoke_item as $i) {
	$item                   = get_object_vars($i);
	$item['title']          = $conv->disp($item['title']);
	$item['item_location']  = $conv->disp($item['item_location']);
	$item['nick']           = $conv->disp($item['nick']);
	$item['click_url']      = base64_encode($item['click_url']);
	$item['shop_click_url'] = base64_encode($item['shop_click_url']);
	$item['pic_url']        = $item['pic_url']."_210x1000.jpg";
	//加工市场价
	if($item['price'] <= 100) {
		$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod1));
	} else if($item['price'] > 100 && $item['price'] <= 500) {
		$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod2));
	} else if($item['price'] > 500 && $item['price'] <= 1000) {
		$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod3));
	} else if($item['price'] > 1000 && $item['price'] <= 3000) {
		$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod4));
	} else if($item['price'] > 3000 && $item['price'] <= 5000) {
		$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod5));
	} else {
		$item['fakeprice'] = sprintf('%01.2f', floor($item['price'] * $price_mod6));
	}
	$item['discount'] = sprintf('%01.0f', floor($item['price'] * 10 / $item['fakeprice']));
	//加工销售件数
	$item['commission_num'] = sprintf('%01.0f', floor($item['commission_num'] + $commissionnumadd));
	$items[]                = $item;
}
$pageurl  = 'plugin.php?id=dps_xtao:tb_goods_search&sort='.$sort.'&keyword='.$keywordencode.'';
$multi    = multi($total, $ppp, $page, $pageurl);
$navtitle = $keyword.' - '.$navtitle;

include template('dps_xtao:goods_search_normal');


