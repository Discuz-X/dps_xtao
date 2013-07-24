<?php defined('IN_DISCUZ') || die('Access Denied');
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

$keywords = array();
$keywords = explode(',', $goodkeywords);
for($i = 0; $i < count($arraykey); $i++) {
	$keywords[] = $arraykey[$i];
}
//$itl = new ItemcatsGetRequest;
//$itl->setFields('cid,parent_cid,name,is_parent,status,sort_order,last_modified');
//$itl->setParentCid(isset($_GET['cid'])?$_GET['cid']:'0');
//$ritl = $c->execute($itl);
//aiodebug($ritl->item_cats, 'response', $debug);
//aiodebug($ritl, 'response', $debug);
//$itemCats = $ritl->item_cats->item_cat;

//aiodebug($ritl, 'response', $debug);
//aiodebug($ritl, 'response', $debug);
//aiodebug($ritl, 'response', $debug);
//aiodebug($ritl, 'response', $debug);
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
		//aiodebug($taokepid, 'taoke pid', $debug);
		$req->setPid($taokepid);
	} elseif(!empty($taokeusername)) {
		aiodebug($taokeusername, 'taoke username', $debug);
		$req->setNick($conv->req($taokeusername));
	} else {
		showmessage(lang('plugin/abis_shops', 'error_nouser'));
	}
	$resp = $c->execute($req);
	//aiodebug($resp, 'response', $debug);
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

function get_tao_id($url, $tao_id_arr=array()) {
	if(empty($tao_id_arr)){
		$tao_id_arr=include (DDROOT.'/data/tao_ids.php');
	}
	$ids=implode('|',$tao_id_arr);
	preg_match('/[&|?]('.$ids.')=(\d+)/',$url,$b);
	if($b[2]==''){
		preg_match('#/i(\d+)\.htm#',$url,$b);
		return $b[1];
	}
	else{
		return $b[2];
	}
}

function in_tao_cat($cid,$tao_cat=array()){
	if(empty($tao_cat)){
		$tao_cat=include(DDROOT.'/data/tao_cat.php');
	}
	foreach($tao_cat as $k=>$v){
		if(in_array($cid,$v)){
			return $k;
		}
	}
	return 999;
}

function dd_set_cache($name,$arr,$type='json'){
	switch($type){
		case 'json':
			$data=PHP_EXIT.json_encode($arr);
			dd_file_put(DDROOT .'/data/json/' . $name . '.php', $data);
			break;
		case 'array':
			$data = "<?php\n return " . var_export($arr, true) . ";\n?>";
			dd_file_put(DDROOT .'/data/array/' . $name . '.php', $data);
			break;
	}
}

function dd_get_cache($name,$type='json'){
	switch($type){
		case 'json':
			$data=array();
			if(is_file(DDROOT .'/data/json/' . $name . '.php')){
				$data=file_get_contents(DDROOT .'/data/json/' . $name . '.php');
				$data=preg_replace('/^'.PHP_EXIT_PREG.'/','',$data);
				$data=json_decode($data,1);
				if(empty($data)){$data=array();}
			}
			break;
		case 'array':
			$data=array();
			if(is_file(DDROOT .'/data/array/' . $name . '.php')){
				$data = include(DDROOT .'/data/array/' . $name . '.php');
				if(empty($data)){$data=array();}
			}
			break;
	}
	return $data;
}

function def($tag,$data=array(),$parame=array()){
	$default_data=dd_get_cache('tao_goods','array');
	switch($tag){
		case 'dingdaning':
			$default_data=$default_data[$tag];
			if(!empty($default_data)){
				foreach($default_data as $row){
					$data[$row['wz']]['num_iid']=$row['num_iid'];
					$data[$row['wz']]['item_title']=$row['title'];
					$data[$row['wz']]['fxje']=$row['fxje']*TBMONEYBL;
					$data[$row['wz']]['img']=$row['pic_url'];
					$data[$row['wz']]['name']='******';
					$data[$row['wz']]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
				}
			}
			break;

		case 'tao_hot_goods':
			$default_data=$default_data[$tag];
			if(is_array($default_data) && !empty($default_data)){
				foreach($default_data as $row){
					$data[$row['wz']]['num_iid']=$row['num_iid'];
					$data[$row['wz']]['title']=$row['title'];
					$data[$row['wz']]['pic_url']=$row['pic_url'];
					$data[$row['wz']]['price']=$row['price'];
					$data[$row['wz']]['fxje']=fenduan($row['commission'],$parame['fxbl'],$parame['user_level'],TBMONEYBL);
					$data[$row['wz']]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
				}
			}
			break;

		case 'tao_zhe_goods':
			$default_data=$default_data[$tag];
			if(is_array($default_data) && !empty($default_data)){
				foreach($default_data as $row){
					$data[$row['wz']]['num_iid']=$row['num_iid'];
					$data[$row['wz']]['title']=$row['title'];
					$data[$row['wz']]['pic_url']=$row['pic_url'];
					$data[$row['wz']]['price']=$row['price'];
					$data[$row['wz']]['coupon_price']=$row['coupon_price'];
					$data[$row['wz']]['coupon_end_time']=$row['coupon_end_time'];
					$data[$row['wz']]['coupon_fxje']=fenduan($row['coupon_commission'],$parame['fxbl'],$parame['user_level']);
					$data[$row['wz']]['gourl']=u('tao','view',array('iid'=>$row['num_iid']));
				}
			}
			break;
	}
	return $data;
}

function jump($url = '',$word='') {
	if(defined('AJAX') && AJAX==1) {
		if($word!=''){
			$arr=array('s'=>0,'id'=>$word);
		}
		else{
			$arr=array('s'=>1);
		}
		echo json_encode($arr);
		dd_exit();
	}
	else{
		if($word!=''){
			if(is_numeric($word)){
				global $errorData;
				$alert="alert('" . $errorData[$word] . "');";
			}
			else{
				$alert="alert('" . $word . "');";
			}
		}
		else {
			$alert='';
		}
		if($url==-1){
			$url=$_SERVER["HTTP_REFERER"];
		}
		if (is_numeric($url)) {
			echo script($alert.'history.go('.$url.');');
		} else {
			echo script($alert.'window.location.href="' . $url . '";');
			//echo '<meta http-equiv="Refresh" content="0; url='.$url.'" />';
		}
		dd_exit();
	}
}

function u($mod,$act='',$arr=array()){
	$wjt=0;
	if(isset($arr['rela'])){
		$rela=1;
		unset($arr['rela']);
	}
	else{
		$rela=0;
	}

	if(defined('INDEX')==1){
		if($act=='' && $mod=='index'){
			return SITEURL;
		}
		global $wjt_mod_act_arr;  //伪静态数组

		if(!isset($wjt_mod_act_arr)){
			$wjt_mod_act_arr=dd_get_cache('wjt');
		}
		if(WJT==1 && array_key_exists($mod,$wjt_mod_act_arr) && array_key_exists($act,$wjt_mod_act_arr[$mod]) && $wjt_mod_act_arr[$mod][$act]==1){
			$wjt=1;
		}
		unset($wjt_mod_act_arr);

		if($mod=='tao' && ($act=='list' || $act=='view') && URLENCRYPT!=''){
			if(isset($arr['cid']) && $arr['cid']>0){
				$arr['cid']=dd_encrypt($arr['cid'],URLENCRYPT);
			}
			elseif(isset($arr['iid']) && $arr['iid']>0){
				$arr['iid']=dd_encrypt($arr['iid'],URLENCRYPT);
			}
		}
	}

	if($wjt==0){
		if($act==''){
			$mod_act_url="index.php?mod=".$mod."&act=index";
		}
		elseif(empty($arr)){
			$mod_act_url="index.php?mod=".$mod."&act=".$act;
		}
		else{
			$mod_act_url="index.php?mod=".$mod."&act=".$act.arr2param($arr);
		}
	}
	elseif($wjt==1){
		global $alias_mod_act_arr;  //链接别名数组
		if(!isset($alias_mod_act_arr)){
			$alias_mod_act_arr=dd_get_cache('alias');
		}
		$dir=$mod.'/'.$act;
		if(is_array($alias_mod_act_arr[$dir])){
			$mod=$alias_mod_act_arr[$dir][0];
			$act=$alias_mod_act_arr[$dir][1];
		}
		unset($alias_mod_act_arr);
		if($act==''){
			$mod_act_url=$mod."/index.html";
		}
		elseif(empty($arr)){
			$mod_act_url=$mod.'/'.$act.'.html';
		}
		else{
			$mod_act_url='';
			$url='';
			foreach($arr as $k=>$v){
				$url.=rawurlencode($v).'-';
			}
			$mod_act_url=$mod.'/'.$act.'-'.$url;
			$mod_act_url=str_del_last($mod_act_url).'.html';
		}
	}

	if(defined('INDEX') && $mod=='index' && $act=='index'){
		$mod_act_url='';
	}

	if(defined('INDEX') && $rela==0){
		$mod_act_url=SITEURL.'/'.$mod_act_url;
	}

	/*if(strpos($mod_act_url,'%23')!==false){
		$mod_act_url=str_replace('%23','#',$mod_act_url);
	}*/
	return $mod_act_url;
}

function dd_session_start(){
	create_dir(DDROOT.'/data/temp/session/'.date('Ymd'));
	ini_set('session.save_handler', 'files');
	session_save_path(DDROOT.'/data/temp/session/'.date('Ymd'));
	session_set_cookie_params(0, '/', '');
	session_start();
}

function sel_date($dir){
	$dh = dir($dir);
	$j=0;
	while(($filename=$dh->read()) !== false){
		if ($filename != "." && $filename != ".."){
			$dp=$dir.'/'.$filename;
			if(judge_empty_dir($dp)!=1){
				$arr=explode('_',$filename);
				$time=date('Y-m-d',strtotime($arr[1]));
				$option_arr[$j]="<option value='$arr[1]'>$time</option>";
				$j++;
			}
		}
	}
	for($i=$j;$i>=0;$i--){
		$option.=$option_arr[$i];
	}
	$dh->close();
	return $option;
}

function mingxi_content($row,$mingxi_content){
	$mingxi_content=str_replace('{money}',$row['money'],$mingxi_content);
	$mingxi_content=str_replace('{jifenbao}',jfb_data_type($row['jifenbao']),$mingxi_content);
	$mingxi_content=str_replace('{jifen}',$row['jifen'],$mingxi_content);
	if(strpos($mingxi_content,'{source}')!==false){
		$mingxi_content=str_replace('{source}',$row['source'],$mingxi_content);
	}
	return $mingxi_content;
}

function error_html($error_msg='缺少必要参数',$goto=0,$type=0){
	global $nav;
	global $duoduo;
	global $webset;
	global $dduser;
	global $no_words;
	global $mallapiopen;
	include(TPLPATH.'/error.tpl.php');
	dd_exit();
}

function spider_limit($spider) {
	foreach ($spider as $k=>$val) {
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), $k) !== false) {
			$rand_num = rand(1, 100);
			if ($rand_num <= $val) {
				dd_file_put(DDROOT . '/data/spider/' . $k . '.txt', date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
				error_html('hello spider!');
			}
		}
	}
}

function mod_name($mod,$act){
	if($mod=='index'){
		$mod_name=$mod;
	}
	elseif($mod=='ajax' || $mod=='jump'){
		$mod_name=$mod;
	}
	else{
		$mod_name=$mod.'/'.$act;
	}
	return $mod_name;
}

function AD($id){
	$arr=dd_get_cache('ad/'.$id);
	if(!empty($arr)){
		$style='style="';
		if($arr['edate']>TIME && ($arr['img']==1 || $arr['content']==1)){
			if($arr['width']>0){
				$style.='width:'.$arr['width'].'px;';
			}
			if($arr['height']>0){
				$style.='height:'.$arr['height'].'px;';
			}
			$style.='"';
			if(isset($arr['ad_content'])){
				$c=$arr['ad_content'];
			}
			else{
				$c="<script src='".SITEURL."/data/ad/".$id.".js'></script>";
			}
			return "<div ".$style." id='ad".$id."'>".$c."</div>";
		}
	}
	return;
}

function yzm($path=''){
	return '<img alt="验证码" src="'.$path.'comm/showpic.php" align="absmiddle" onClick="this.src=\''.$path.'comm/showpic.php?a=\'+Math.random()" title="点击更换" style="cursor:pointer;"/>';
}

function show_shop_cat($text){
	switch ($text){
		case "11": $str="电脑硬件/台式机/网络设备"; break;
		case "12": $str="MP3/MP4/iPod/录音笔"; break;
		case "13": $str="手机"; break;
		case "14": $str="女装/流行女装"; break;
		case "15": $str="彩妆/香水/护肤/美体"; break;
		case "16": $str="电玩/配件/游戏/攻略"; break;
		case "17": $str="数码相机/摄像机/图形冲印"; break;
		case "18": $str="运动/瑜伽/健身/球迷用品"; break;
		case "20": $str="古董/邮币/字画/收藏"; break;
		case "21": $str="办公设备/文具/耗材"; break;
		case "22": $str="汽车/配件/改装/摩托/自行车"; break;
		case "23": $str="珠宝/钻石/翡翠/黄金"; break;
		case "24": $str="居家日用/厨房餐饮/卫浴洗浴"; break;
		case "26": $str="装潢/灯具/五金/安防/卫浴"; break;
		case "27": $str="成人用品/避孕用品/情趣内衣"; break;
		case "29": $str="食品/茶叶/零食/特产"; break;
		case "30": $str="玩具/动漫/模型/卡通"; break;
		case "31": $str="箱包皮具/热销女包/男包"; break;
		case "32": $str="宠物/宠物食品及用品"; break;
		case "33": $str="音乐/影视/明星/乐器"; break;
		case "34": $str="书籍/杂志/报纸"; break;
		case "35": $str="网络游戏点卡"; break;
		case "36": $str="网络游戏装备/游戏币/帐号/代练"; break;
		case "37": $str="男装"; break;
		case "1020": $str="母婴用品/奶粉/孕妇装"; break;
		case "1040": $str="ZIPPO/瑞士军刀/饰品/眼镜"; break;
		case "1041": $str="移动联通充值中心/IP长途"; break;
		case "1042": $str="网店装修/物流快递/图片存储"; break;
		case "1043": $str="笔记本电脑"; break;
		case "1044": $str="品牌手表/流行手表"; break;
		case "1045": $str="户外/军品/旅游/机票"; break;
		case "1046": $str="家用电器/hifi音响/耳机"; break;
		case "1047": $str="鲜花速递/蛋糕配送/园艺花艺"; break;
		case "1048": $str="3C数码配件市场"; break;
		case "1049": $str="床上用品/靠垫/窗帘/布艺"; break;
		case "1050": $str="家具/家具定制/宜家代购"; break;
		case "1051": $str="保健品/滋补品"; break;
		case "1052": $str="网络服务/电脑软件"; break;
		case "1053": $str="演出/旅游/吃喝玩乐折扣券"; break;
		case "1054": $str="饰品/流行首饰/时尚饰品"; break;
		case "1055": $str="女士内衣/男士内衣/家居服"; break;
		case "1056": $str="女鞋"; break;
		case "1062": $str="童装/婴儿服/鞋帽"; break;
		case "1082": $str="流行男鞋/皮鞋"; break;
		case "1102": $str="腾讯QQ专区"; break;
		case "1103": $str="IP卡/网络电话/在线影音充值"; break;
		case "1104": $str="个人护理/保健/按摩器材"; break;
		case "1105": $str="闪存卡/U盘/移动存储"; break;
		case "1106": $str="运动鞋"; break;
		case "1122": $str="时尚家饰/工艺品/十字绣"; break;
		case "1153": $str="运动服"; break;
		case "1154": $str="服饰配件/皮带/帽子/围巾"; break;
		default: $str="全部店铺"; break;
	}
	return $str;
}

function reg_content($content,$type=0){ //type为1，替换；type为2，提示错误
	$pattern=DOMAIN_PREG;
	if($type==0){
		$type=REPLACE;
	}
	$shield_arr = dd_get_cache('no_words'); //屏蔽词语
	if($type==1){
		$content=strtr($content,$shield_arr);
		$content=preg_replace($pattern,'',$content);
	}
	else{
		foreach($shield_arr as $v){
			if(strpos($content,$v)!==false){
				return ''; //包含非法词汇
			}
		}
		if(preg_match($pattern,$content)){
			return '';
		}
	}
	return htmlspecialchars($content);
}

function jfb_data_type($jifenbao){
	return data_type($jifenbao,TBMONEYTYPE);
}

function mobile_yzm($mobile,$yzm=''){
	$a=dd_crc32(DDKEY.$mobile);
	$a=substr($a,0,4);
	if($yzm==''){
		return $a;
	}
	else{
		if($yzm==$a){
			return 1;
		}
		else{
			return 0;
		}
	}
}

function show_mobile($mobile){
	return '<b style="font-size:18px; color:#000">'.substr($mobile,0,3).'*****'.substr($mobile,-3).'</b>';
}

function dd_xuliehua($obj) {
	return base64_encode(gzcompress(json_encode($obj)));
}

//反序列化
function dd_unxuliehua($txt) {
	return json_decode(gzuncompress(base64_decode($txt)),1);
}

function add_menu($data){ //$data=array('parent_id'=>72,'node'=>'plug','mod'=>'plugin','act'=>'list','listorder'=>'0','sort'=>'0','title'=>'插件列表','hide'=>0,'sys'=>1);
	global $duoduo;

	if(!isset($data['parent_id'])){ //插件菜单快速添加
		$data['parent_id']=72;
		$data['node']='plug';
		$data['listorder']=0;
		$data['sort']=0;
		$data['hide']=1;
		$data['sys']=0;
	}

	if($data['act']=='' && $data['mod']==''){
		$data['listorder']=$data['sort']+10000;
		unset($data['sort']);
		$menuid=$duoduo->select('menu','id','`node`="'.$data['node'].'" and `mod`="" and `act`=""');
		if($menuid>0){
			return $menuid; //节点已存在;
		}
		$menuid=$duoduo->insert('menu',$data);
		$data=array('role_id'=>1,'menu_id'=>$menuid);
		$duoduo->insert('menu_access',$data);
		return $menuid;
	}
	else{
		$menuid=$duoduo->select('menu','id','`mod`="'.$data['mod'].'" and act="'.$data['act'].'"');
		if($menuid>0){
			return $menuid;
		}
		$menuid=$duoduo->insert('menu',$data);
		$data=array('role_id'=>1,'menu_id'=>$menuid);
		$duoduo->insert('menu_access',$data);
	}
}

function del_menu($mod,$act){
	global $duoduo;
	$id=$duoduo->select('menu','id','`mod`="'.$mod.'" and `act`="'.$act.'"');  //删除导航
	$duoduo->delete('menu','id="'.$id.'" limit 1');
	$duoduo->delete('menu_access','menu_id="'.$id.'" limit 1');
}

function url_html_cache($name,$url,$trigger_time_arr=array()){
	$trigger_time_arr=array('09:30:00','14:30:00','17:30:00');
	$html_dir=DDROOT.'/data/html/'.$name.'/'.dd_crc32($url).'.html';
	$html_url=SITEURL.'/data/html/'.$name.'/'.dd_crc32($url).'.html';

	if(!file_exists($html_dir)){
		$html=dd_get($url);
		create_file($html_dir,$html);
	}
	else{
		$file_time=filemtime($html_dir);
		foreach($trigger_time_arr as $v){
			$trigger_time=strtotime(date('Ymd'.' '.$v));
			if(TIME>$trigger_time && $file_time<=$trigger_time){
				$html=dd_get($url);
				create_file($html_dir,$html);
			}
		}
	}
	return $html_url;
}

function l($mod,$act,$arr=array()){
	$url=SITEURL.'/index.php?mod='.$mod.'&act='.$act;
	if(!empty($arr)){
		$url.='&'.arr2param($arr);
	}
	return $url;
}

function p($mod,$act,$arr=array()){
	$url='';
	if(WJT==1){
		foreach($arr as $k=>$v){
			$url.=rawurlencode($v).'-';
		}
		$url=$mod.'/'.$act.'-'.$url;
		$url=SITEURL.'/'.str_del_last($url).'.html';
	}
	else{
		$url=SITEURL.'/plugin.php?mod='.$mod.'&act='.$act;
		if(!empty($arr)){
			$url.=arr2param($arr);
		}
	}
	return $url;
}

function include_mod($mod,$duoduo,$new=1){ //new表示是否实例化
	include(DDROOT.'/mod/'.$mod.'/fun.class.php');
	$dd_mod_class_name='dd_'.$mod.'_class';
	$$dd_mod_class_name=new $dd_mod_class_name($duoduo);
	return $$dd_mod_class_name;
}
function act_tao_view() {
	global $duoduo, $ddTaoapi;
	include DISCUZ_ROOT.'/../duoduo/comm/Taoapi.php';
	include DISCUZ_ROOT.'/../duoduo/comm/ddTaoapi.class.php';
	$ddTaoapi = new ddTaoapi();
	//$webset      = $duoduo->webset;
	$webset =
		array(
			'fxbl'                =>
			array(
				100 => '0.8',
				50  => '0.7',
				20  => '0.6',
				0   => '0.5',
			),
			'sign'                =>
			array(
				'open'     => '0',
				'money'    => '0',
				'jifenbao' => '0',
				'jifen'    => '0',
			),
			'baobei'              =>
			array(
				'shai_jifen'       => '2',
				'share_jifen'      => '1',
				'hart_jifen'       => '1',
				'shai_s_time'      => '2011-10-01',
				'word_num'         => '80',
				'comment_word_num' => '50',
				'share_level'      => '0',
				'comment_level'    => '0',
				'cat'              =>
				array(
					1   => '上装',
					2   => '下装',
					3   => '鞋子',
					4   => '包包',
					5   => '配饰',
					6   => '美妆',
					7   => '内衣',
					8   => '家居',
					9   => '数码',
					999 => '其他',
				),
				're_tao_cid'       => '1',
			),
			'comment_interval'    => '86400',
			'chanet'              =>
			array(
				'name' => 'a0504030301',
				'pwd'  => '',
				'wzid' => '431726',
				'key'  => '2a784eee44480173',
			),
			'static'              =>
			array(
				'index' =>
				array(
					'random' => '0',
				),
			),
			'tixian_limit'        => '10',
			'txxz'                => '10',
			'user'                =>
			array(
				'jihuo'          => '0',
				'autoreg'        => '0',
				'shoutu'         => '0',
				'reg_between'    => '0',
				'reg_money'      => '0',
				'reg_jifenbao'   => '0',
				'reg_jifen'      => '0',
				'reg_level'      => '0',
				'up_avatar'      => '1',
				'auto_increment' => '1',
				'limit_ip'       => '',
			),
			'taobao_nick'         => '飞翔的波斯猫',
			'taobao_session'      =>
			array(
				'value'         => '',
				'refresh_token' => '',
				'day'           => '20121220',
				'auto'          => '0',
				'time'          => 0,
			),
			'wujiumiaoapi'        =>
			array(
				'open'              => '0',
				'key'               => '1006060',
				'secret'            => 'c8e8aa3ebe08032ea930f0fe462f5bff',
				'pagesize'          => '20',
				'cache_time'        => '0',
				'shield_merchantId' => '',
				'del_cache_time'    => '',
			),
			'tao_report_interval' => '1200',
			'jifenbl'             => '0',
			'tgbl'                => '0.1',
			'taoapi'              =>
			array(
				'm2j'                   => '0',
				'pagesize'              => '20',
				'goods_comment'         => '0',
				'trade_check'           => '1',
				's8'                    => '0',
				'freeze'                => '0',
				'freeze_sday'           => '2012-12-16 16:15:59',
				'freeze_limit'          => '0',
				'ju_commission_rate'    => '0.01',
				'tmall_commission_rate' => '0.005',
				'shield'                => '0',
				'cache_time'            => '10',
				'cache_monitor'         => '0',
				'errorlog'              => '0',
				'taobao_search_pid'     => '25328448_2922415_11006570',
				'taobao_chongzhi_pid'   => '25328448_2922415_10004886',
				'fanlitip'              => '0',
				'goods_show'            => '1',
				'sort'                  => 'commissionNum_desc',
				'promotion'             => '0',
				'jssdk_key'             => '21141544',
				'jssdk_secret'          => '433bd2b2450a9a67fd7a5b0530b90377',
			),
			'hotword'             =>
			array(
				0 => '热卖',
				1 => '新款',
				2 => '秒杀',
				3 => '减肥',
				4 => '内衣',
				5 => '丰胸',
				6 => '衬衣',
				7 => '短袖',
				8 => '连衣裙',
				9 => '电风扇',
			),
			'webclose'            => '0',
			'webclosemsg'         => '网站升级中。。。',
			'email'               => 'email',
			'qq'                  => 'qq',
			'liebiao'             => '1',
			'level'               =>
			array(
				0   => '普通会员',
				20  => '黄金会员',
				50  => '白金会员',
				100 => '钻石会员',
			),
			'mallfxbl'            =>
			array(
				100 => '0.8',
				50  => '0.7',
				20  => '0.6',
				0   => '0.5',
			),
			'smtp'                =>
			array(
				'type' => '1',
				'host' => '',
				'name' => '',
				'pwd'  => '',
			),
			'sql_debug'           => '0',
			'hytxjl'              => '0',
			'tgurl'               => 'http://tryanderror.cn/duoduo/index.php?',
			'searchlimit'         => '0',
			'linktech'            =>
			array(
				'name' => '',
				'pwd'  => '',
				'wzbh' => '',
			),
			'duomai'              =>
			array(
				'uid'  => '10440',
				'wzid' => '52244',
				'wzbh' => '001',
				'key'  => '35ad3d58d228787714d72e1ded84d40a',
			),
			'gzip'                => '0',
			'shop'                =>
			array(
				'open'   => '1',
				'slevel' => '11',
				'elevel' => '20',
			),
			'yiqifa'              =>
			array(
				'uid'  => '',
				'wzid' => '',
				'name' => '',
				'key'  => '',
			),
			'yiqifaapi'           =>
			array(
				'open'              => '0',
				'key'               => '13399929765611312',
				'secret'            => '4ff6a7f2d44ef876d15eabffe1c799ee',
				'pagesize'          => '20',
				'cache_time'        => '0',
				'shield_merchantId' => '100016',
			),
			'tuan'                =>
			array(
				'open'     => '0',
				'cid'      => '1',
				'autoget'  => '2',
				'autogdel' => '1',
				'shownum'  => '6',
				'listnum'  => '9',
				'mall_cid' => '21',
			),
			'ucenter'             =>
			array(
				'open'          => '0',
				'UC_APPID'      => '',
				'UC_KEY'        => '',
				'UC_API'        => '',
				'UC_DBCHARSET'  => '',
				'UC_CHARSET'    => '',
				'UC_DBHOST'     => '',
				'UC_DBUSER'     => '',
				'UC_DBPW'       => '',
				'UC_DBNAME'     => '',
				'UC_DBTABLEPRE' => '',
			),
			'spider'              =>
			array(
				'sosospider'  => '100',
				'baiduspider' => '20',
				'yahoo'       => '100',
				'bingbot'     => '100',
				'googlebot'   => '100',
				'ia_archiver' => '100',
				'youdaobot'   => '100',
				'sohu'        => '100',
				'msnbot'      => '100',
				'slurp'       => '100',
				'sogou'       => '100',
				'QihooBot'    => '100',
			),
			'seo'                 =>
			array(
				'spider_limit' => '0',
			),
			'fxb'                 =>
			array(
				'open' => '0',
				'name' => '多多返现宝',
			),
			'tao_report_time'     => '1371141560',
			'tuan_goods_time'     => '1371140944',
			'tao_cache_time'      => '1374588537',
			'login_tip'           => '1',
			'taobao_pid'          => '25328448',
			'jiesuan_date'        => '201208',
			'phpwind'             =>
			array(
				'open'    => '0',
				'key'     => '',
				'url'     => '',
				'charset' => '',
			),
			'yinxiangma'          =>
			array(
				'open'        => '0',
				'private_key' => '',
				'public_key'  => '',
			),
			'bshare_code'         => '<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#uuid=c196de18-8f38-410e-8ae0-834dd0ec2c86&amp;style=3&amp;fs=4&amp;textcolor=#fff&amp;bgcolor=#F60&amp;text=分享到..."></script>',
			'paipai_report_time'  => '1371140944',
			'paipaifxbl'          =>
			array(
				100 => '0.8',
				50  => '0.7',
				20  => '0.6',
				0   => '0.5',
			),
			'bshare'              =>
			array(
				'user'      => 'anzhongxiao@126.com',
				'pwd'       => 'an4659862',
				'uuid'      => 'c196de18-8f38-410e-8ae0-834dd0ec2c86',
				'secretKey' => '158d59b4-0e48-4240-8ff9-de000aa0b4e2',
			),
			'collect'             =>
			array(
				'curl'              => '1',
				'file_get_contents' => '2',
				'fsockopen'         => '3',
			),
			'tao_zhe'             =>
			array(
				'keyword'                 => '热卖',
				'cid'                     => '16',
				'coupon_type'             => '1',
				'shop_type'               => 'all',
				'sort'                    => 'commissionRate_desc',
				'start_coupon_rate'       => '1000',
				'end_coupon_rate'         => '9000',
				'start_credit'            => '1heart',
				'end_credit'              => '5goldencrown',
				'start_commission_rate'   => '1000',
				'end_commission_rate'     => '9000',
				'start_commission_volume' => '',
				'end_commission_volume'   => '',
				'start_commission_num'    => '',
				'end_commission_num'      => '',
				'start_volume'            => '',
				'end_volume'              => '',
				'page_size'               => '16',
				'ajax_load_num'           => '5',
			),
			'sql_log'             => '0',
			'yiqifa_cache_time'   => '1347281665',
			'corrent_time'        => '0',
			'authorize'           => '10d1+zxLLkWBb0fYsasPjTHNGAPRcZISwpqdxzNv11BusjjSbhHRK6QnwT/tRB8zZfBlSbBQ/+gj8n0Dx9dkzzxIlZxUfl3Vlcrjuz/3yfXAgBnTLh30aNeCRuByuAJlOAEdXLvgu+hP3KmOs7VKUg7wCfWSOEkFugqQYMatSM/SrrX0OCHry+sRwpx1bGCpgIJ+yO+ZYT5EMTuYYGwZKbRN7HBsoI5MADCXps2I0ArFhO5FjIOX82fanrZwSJUZ9A',
			'shop_count'          =>
			array(
				'c3423b50b6bc6f096c8adb67d138a03f' =>
				array(
					'count' => 123,
					'time'  => 1344958234,
				),
				'b3238ee9a748de831d373d2cb67eb896' =>
				array(
					'count' => 36,
					'time'  => 1343919212,
				),
				'345860b0cc5bf16991899d57d15e9b05' =>
				array(
					'count' => 0,
					'time'  => 1344959071,
				),
				'26463dfff3cfa230ece11a054330fd1d' =>
				array(
					'count' => '131',
					'time'  => 1355972422,
				),
				'cba0c3c4eba6ea656323750c80c35510' =>
				array(
					'count' => 1,
					'time'  => 1346215972,
				),
				'ddbc652ae832177d9ea36c40b4982040' =>
				array(
					'count' => 1,
					'time'  => 1346216605,
				),
				'1081f1dcbe8c6f15da37dc330ff28279' =>
				array(
					'count' => 0,
					'time'  => 1346429307,
				),
				'15e58b831c48b54374c20ad80729f2c9' =>
				array(
					'count' => 0,
					'time'  => 1346882387,
				),
				'c622a8583962dafc67f0df71a3902ee9' =>
				array(
					'count' => 0,
					'time'  => 1346882390,
				),
				'9d9d07719dcf3a029bd9c71ccc233243' =>
				array(
					'count' => 0,
					'time'  => 1346882392,
				),
				'6a4389c47e5116359a6cb88d16f9231d' =>
				array(
					'count' => 0,
					'time'  => 1346882392,
				),
				'92d072dcd68592a552157a15d9d86069' =>
				array(
					'count' => 0,
					'time'  => 1346882393,
				),
				'cd405da34b6a1e01f4cf38dc830ec8f6' =>
				array(
					'count' => 2,
					'time'  => 1346882394,
				),
				'20233a79e8a58c9a15ff381fc85b8585' =>
				array(
					'count' => 1,
					'time'  => 1346882395,
				),
				'bdbd221a0d0e8e7084bd57ee83d8f362' =>
				array(
					'count' => 0,
					'time'  => 1346882395,
				),
				'a8227e987bfbf21877b728b1313b05a5' =>
				array(
					'count' => 0,
					'time'  => 1346882397,
				),
				'cafa1e0950af3db7056cf85ddcf7a1fe' =>
				array(
					'count' => 16,
					'time'  => 1347013694,
				),
				'3c585a0d110870e379197d5f4acb6102' =>
				array(
					'count' => 0,
					'time'  => 1346882400,
				),
				'9bc5a0e8027145ce11161820efb9a9d9' =>
				array(
					'count' => 0,
					'time'  => 1347983694,
				),
				'dc0f8f7ea1eef59212b1c93890fbb0b6' =>
				array(
					'count' => 1,
					'time'  => 1348408611,
				),
				'd7e4f0a1be5271c549f7280bec16ab3a' =>
				array(
					'count' => 0,
					'time'  => 1348650799,
				),
				'5462da8bb8f268bec9c82b7c5339d5af' =>
				array(
					'count' => 1,
					'time'  => 1348675819,
				),
				'2864125ec77653f0820745bde18777e2' =>
				array(
					'count' => '1',
					'time'  => 1374588537,
				),
			),
			'banquan'             => 'Copyright ©2008-2012&nbsp;&nbsp; <a href="http://soft.duoduo123.com" target="_blank">多多返利建站系统</a>&nbsp;&nbsp;&nbsp;<a href="index.php?mod=about&amp;act=index" target="_blank">关于我们</a>',
			'email_notice'        =>
			array(
				'dd' => '1',
			),
			'paipai'              =>
			array(
				'open'           => '0',
				'userId'         => '12245',
				'qq'             => '332439180',
				'appOAuthID'     => '700028903',
				'secretOAuthKey' => '0cQC1gfECGxeLXvS',
				'accessToken'    => '164cb25e20b6415e684000650fb62cf1',
				'keyWord'        => '女装',
				'pageSize'       => '20',
				'sort'           => '11',
				'cache_time'     => '0',
				'errorlog'       => '0',
			),
			'sms'                 =>
			array(
				'name'   => 'an4659862',
				'pwd'    => 'aaaaaa',
				'newpwd' => 'aaaaaa',
				'mobile' => '',
				'check'  => '0',
			),
			'qq_meta'             => '',
			'tgfz'                => '50',
			'tixian'              =>
			array(
				'tblimit'     => '1000',
				'tbtxxz'      => '1000',
				'limit'       => '10',
				'txxz'        => '10',
				'hytxjl'      => '0',
				'ddpay'       => '0',
				'need_alipay' => '1',
			),
			'appkey'              =>
			array(
				0 =>
				array(
					'key'    => '21141544',
					'secret' => '433bd2b2450a9a67fd7a5b0530b90377',
					'num'    => '100',
				),
			),
		);
	//$dduser      = $duoduo->dduser;
	$dduser = array(
		'name'  => '',
		'id'    => 0,
		'level' => 0,
	);
	//$tao_id_arr  = include(DDROOT.'/data/tao_ids.php');
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
	//$shield_cid  = include(DDROOT.'/data/shield_cid.php');
	$shield_cid = array(0 => 50012829, 1 => 50003114, 2 => 50012831, 3 => 50012832, 4 => 50012830, 5 => 50006275, 6 => 50019617, 7 => 50019618, 8 => 50019619, 9 => 50019620, 10 => 50019621, 11 => 50019622, 12 => 50019623, 13 => 50019624, 14 => 50019625, 15 => 50019626, 16 => 50019627, 17 => 50019628, 18 => 50019629, 19 => 50019630, 20 => 50019631, 21 => 50019636, 22 => 50019637, 23 => 50019638, 24 => 50019639, 25 => 50019640, 26 => 50019641, 27 => 50019642, 28 => 50019643, 29 => 50019644, 30 => 50019692, 31 => 50019693, 32 => 50019645, 33 => 50019646, 34 => 50019698, 35 => 50019699, 36 => 50019700, 37 => 50019647, 38 => 50019651, 39 => 50019652, 40 => 50019653, 41 => 50019654, 42 => 50019655, 43 => 50019656, 44 => 50019657, 45 => 50019658, 46 => 50019659, 47 => 50019660, 48 => 50019661, 49 => 50019662, 50 => 50019663, 51 => 50019664, 52 => 50019665, 53 => 50020206, 54 => 50020205, 55 => 50050327, 2813);
	//$virtual_cid = include(DDROOT.'/data/virtual_cid.php');
	$virtual_cid = array('goods' => array(0 => 150401, 1 => 150402, 2 => 50011814, 3 => 150406), 'shop' => array(1103, 1041, 1102, 35, 36));
	if(empty($iid)) {
		$iid = isset($_GET['iid']) ? (float)$_GET['iid'] : '';
	}
	if(empty($keyword)) {
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
	}
	$promotion_name = $_GET['promotion_name'] ? $_GET['promotion_name'] : '促销打折';
	$price_name     = '一&nbsp;口&nbsp;价';

	$is_url  = 0;
	$is_mall = 0;
	$is_ju   = 0;
	$url     = '';

	function reg_taobao_url($url) {
		if(preg_match('/(taobao\.com|tmall\.com)/', $url) == 1) {
			return 1;
		} else {
			return 0;
		}
	}

	if(reg_taobao_url($keyword) == 1) {
		$is_url = 1;
		$url    = $keyword;
		$iid    = (float)get_tao_id($keyword, $tao_id_arr);
		if($iid == 0) {
			error_html('请使用标准淘宝商品网址搜索！');
		}

		$ju_url  = 'http://a.m.taobao.com/i'.$iid.'.htm';
		$ju_html = file_get_contents($ju_url);
		if($ju_html == '') { //个别主机不能采集淘宝手机页面
			$ju_url  = 'http://ju.taobao.com/tg/home.htm?item_id='.$iid;
			$ju_html = dd_get($ju_url);
			if($ju_html != '' && strpos($ju_html, '<input type="hidden" name="item_id" value="'.$iid.'"') !== FALSE) {
				$is_juhuasuan = 2; //一般网页
			}
		} elseif(strpos($ju_html, '<a name="'.$iid.'"></a>') !== FALSE) {
			$is_juhuasuan = 1; //手机网页
		}

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
		} elseif(strpos($keyword, 'tmall.com') !== FALSE) {
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
			die('erroraaa');
			error_html('直接搜索淘宝商品网址即可查询返利', 5);
		}
	}
	$data['iid']        = $iid;
	$data['outer_code'] = $dduser['id'];
	$data['all_get']    = 1; //商品没有返利也获取商品内容
	$data['goods_type'] = $goods_type;
	$data['ju_price']   = $ju_price;

	if(TAOTYPE == 1) {
		$data['fields'] = 'iid,detail_url,num_iid,title,nick,type,cid,pic_url,seller_cids,num,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,item_img';
		if(WEBTYPE == 1) {
			$data['fields'] .= ',desc';
		}
		$goods       = $ddTaoapi->taobao_item_get($data);
		$allow_fanli = 1;
	} else {
		$data['fields'] = 'iid,detail_url,num_iid,title,nick,type,cid,pic_url,num,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,seller_credit_score,shop_click_url,click_url,volume,stuff_status,has_invoice,auction_point';
		if(WEBTYPE == 1) {
			$data['fields'] .= ',desc';
		}
		$goods       = $ddTaoapi->items_detail_get($data);
		$allow_fanli = 1; //$ddTaoapi->taobao_taobaoke_rebate_authorize_get($iid);
	}


	if($goods['title'] == '' || $goods['num'] == 0 || ($webset['taoapi']['shield'] == 1 && in_array($goods['cid'], $shield_cid))) {
		error_html('商品不存在或已下架或者是违禁商品。<a target="_blank" href="http://item.taobao.com/item.htm?id='.$iid.'">去淘宝确认</a>', -1, 1);
	}

	$jssdk_items_convert['method']      = 'taobao.taobaoke.widget.items.convert';
	$jssdk_items_convert['outer_code']  = (int)$dduser['id'];
	$jssdk_items_convert['user_level']  = (int)$dduser['level'];
	$jssdk_items_convert['num_iids']    = $iid;
	$jssdk_items_convert['allow_fanli'] = $allow_fanli;
	$jssdk_items_convert['cid']         = $goods['cid'];
	$jssdk_items_convert['tmall_fxje']  = (float)$goods['tmall_fxje'];
	$jssdk_items_convert['ju_fxje']     = (float)$goods['ju_fxje'];
	$jssdk_items_convert['goods_type']  = $goods_type;

	$nick = $goods['nick'];

	//include(DDROOT.'/mod/tao/shopinfo.act.php'); //店铺信息

	$shop=$ddTaoapi->taobao_shop_get($nick);

	if($shop==104){
		error_html('掌柜不存在！');
	}
	else{
		$jssdk_shops_convert['method']='taobao.taobaoke.widget.shops.convert';
		$jssdk_shops_convert['outer_code']=(int)$dduser['id'];
		$jssdk_shops_convert['user_level']=(int)$dduser['level'];
		$jssdk_shops_convert['seller_nicks']=$nick;
		$jssdk_shops_convert['list']=(int)$list;
		foreach($shop as $k=>$v){
			$jssdk_shops_convert[$k]=$v;
		}
	}

	$parameter['shop']=$shop;
	$parameter['jssdk_shops_convert']=$jssdk_shops_convert;
	//////
	if(WEBTYPE == 1 && TAOTYPE == 2) {
		$Tapparams['cid']          = $goods['cid']; //当前cid热卖商品
		$Tapparams['page_size']    = 6;
		$Tapparams['start_credit'] = '1crown';
		$Tapparams['end_credit']   = '5goldencrown';
		$Tapparams['start_price']  = '20';
		$Tapparams['end_price']    = '5000';
		$Tapparams['sort']         = 'commissionNum_desc';
		$Tapparams['outer_code']   = $dduser['id'];
		$goods2                    = $ddTaoapi->taobao_taobaoke_items_get($Tapparams);
	}

	$comment_url = "http://rate.taobao.com/detail_rate.htm?&auctionNumId=".$iid."&showContent=2&currentPage=1&ismore=1&siteID=7&userNumId=";

	//include(DDROOT.'/plugin/tao_coupon.php');


	function tao_coupon_view($shop_title,$goods_price){
		$str='';
		$d = iconv("UTF-8","gbk//IGNORE",$shop_title);
		$e=urlencode($d);
		$url="http://taoquan.taobao.com/coupon/coupon_list.htm?key_word=".$e;
		$listcontent =iconv("gbk", "utf-8//IGNORE", dd_get($url));
		$preg = "/<p class=\"coupon-num\">&yen;(.*)元<\/p>/";
		preg_match_all( $preg, $listcontent, $num);//获取优惠券面值
		$preg = "/<p class=\"cond\">使用条件：订单满(.*).00元<\/p>/";
		preg_match_all( $preg, $listcontent, $cond);//获取使用条件
		$preg = "/a href=\"combo\/between.htm\?(.*)&shopTitle/";
		preg_match_all($preg,$listcontent,$url);  //获取优惠券地址码
		$a= $cond[1];
		arsort($a);
		foreach($a as $k=>$v){
			$b=$cond[1][$k];
			$d=$num[1][$k];
			$u=$url[1][$k];
		}

		$str='<div class="shopitem_main_r_5"><span>优&nbsp;惠&nbsp;券：';
		if($num[1][$k]>0){
			$str.='【<a style="color:#F60;" href="http://ecrm.taobao.com/shopbonusapply/buyer_apply.htm?'.$url[1][$k].'" target="_blank" title="点击免费领取优惠券后购买更便宜" >满'.$cond[1][$k].'减'.$num[1][$k].'元';
			if($goods_price<$cond[1][$k]){
				$str.='(需凑单)';
			}
			$str.='</a>】&nbsp;</span><a  href="'.u('tao','coupon',array('q'=>$shop_title)).'" target="_blank" title="查看该卖家更多优惠券">查看更多优惠券</a>  &nbsp;';
		}
		else{
			$str.='暂&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;无&nbsp;&nbsp;';
		}
		$str.='</span> </div>';
		return $str;
	}
	$plugin_set=dd_get_cache('plugin');
	if($plugin_set['tao_coupon']==1){
		$tao_coupon_str=tao_coupon_view($shop['title'],$goods['price']);
	}
	/////////

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

	unset($duoduo);

	return $parameter;
}

?><?php
if($keyword != '') {
	$parameter = act_tao_view();
	extract($parameter);
	$css[] = TPLURL."/css/view.css";
	$js[]  = "js/md5.js";
	$js[]  = "js/jssdk.js";
	$js[]  = "js/jQuery.autoIMG.js";
	//include(TPLPATH.'/header.tpl.php');
}

?>
<?php
include template(IDENTIFIER.':taobaoindex');