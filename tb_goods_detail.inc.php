<?php defined('IN_DISCUZ') || die('Access Denied');
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'init.php';


$appkey = !empty($_C['app_key']) ? $_C['app_key'] : showmessage(lang('plugin/abis_shops', 'error_noappkey'));
$appsecret = !empty($_C['app_secret']) ? $_C['app_secret'] : showmessage(lang('plugin/abis_shops', 'error_noappsecret'));

$modarray = array('view');
$mod = !empty($_GET['mod']) ? addslashes($_GET['mod']) : 'index';
$mod = in_array($mod, $modarray) ? $mod : 'index';

//插件标题
$navtitle = !empty($_C['navtitle']) ? $_C['navtitle'] : $_G['setting']['bbname'];


//插件关键字
$commissionnumadd = !empty($_C['commissionnumadd']) ? $_C['commissionnumadd'] : 11;


//搜索关键字列表
$goodkeywords = !empty($_C['goodkeywords']) ? $_C['goodkeywords'] : '';


//初始化设置
$conv = new Convert;
if(strtolower($_G['config']['output']['charset']) == 'gbk') {
	$conv->convert   = TRUE;
	$conv->localcode = 'gbk';
} else {
	$conv->convert = FALSE;
}

//导航标题
$plugintitle = $navtitle;

$iid = !empty($_GET['iid']) ? addslashes($_GET['iid']) : showmessage(lang('plugin/abis_shops', 'error_noiids'));
$req = new TaobaokeItemsDetailGetRequest;
$req->setFields('pic_url,num_iid,title,nick,desc,create,num,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,click_url,shop_click_url,seller_credit_score');
$req->setNumIids($iid);

//定义调用
$c = new TopClient;
$c->format = 'json'; //返回数据格式
//得到全部的appkey
$c->appkey = $appkey;
$c->secretKey = $appsecret;
$resp = $c->execute($req);

if(empty($resp->total_results)) {
	showmessage(lang('plugin/abis_shops', 'error_noproduct'));

	return;
}

//得到商品明细
$i = $resp->taobaoke_item_details->taobaoke_item_detail[0];

$item = array();
$item['click_url'] = base64_encode($i->click_url);
$item['seller_credit_score'] = $i->seller_credit_score;
$item['shop_click_url'] = base64_encode($i->shop_click_url);
$item['item'] = array();
foreach($i->item as $key => $val) {
	$val                = $conv->disp($val);
	$item['item'][$key] = $val;
}


$item['item']['pic_url'] = $item['item']['pic_url']."_570x10000.jpg";


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
	$navtitle = $item['item']['title'].' - '.$item['item']['location']['state'].''.$item['item']['location']['city'].' - '.$item['item']['nick'].' - '.$item['item']['price'];
	//.' - '.$plugintitle.$item['item']['desc'];

}


include template('abis_shops:goods_detail');