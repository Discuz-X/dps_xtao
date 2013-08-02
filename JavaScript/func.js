function getMessage() {
	//alert(this.req.responseText);  //简单的输出返回结果的字符串形式
	//alert(this.req.responseXML);   //XML形式，后面就根据你的需要解析这个XML了
}
function getType(o) {
	var _t;
	return ((_t = typeof(o)) == "object" ? o == null && "null" || Object.prototype.toString.call(o).slice(8, -1) : _t).toLowerCase();
}
function extend(destination, source) {
	for(var p in source) {
		if(getType(source[p]) == "array" || getType(source[p]) == "object") {
			destination[p] = getType(source[p]) == "array" ? [] : {};
			arguments.callee(destination[p], source[p]);
		} else {
			destination[p] = source[p];
		}
	}
}
function arrToParam(array) {
	var arr = new Array();
	extend(arr, array);
	var param = '', k;
	for(k in arr) {
		if(arr[k] != '') {
			arr[k] = encodeURIComponent(arr[k]);
			if(param != '') {
				param += '&' + k + '=' + arr[k];
			} else {
				param += k + '=' + arr[k];
			}
		}
	}
	return param;
}
function ErrorLog(method, error_response) {
	if(ERRORLOG == 1) {
		var errorParame = new Array();
		errorParame['method'] = method;
		errorParame['code'] = error_response.code;
		errorParame['msg'] = error_response.msg;
		errorParame['url'] = document.URL;
		url = "comm/jssdk.error.php?" + arrToParam(errorParame);
		js_send(url, 1);
	}
}
function js_send(url) {
	url = SITEURL + url + '&check=' + CHECKCODE;
	var type = arguments[1], method = arguments[2];
	if(type == 1) {
		if(method == 'POST') {
			var a = url.split('?');
			new net.ContentLoader(url, getMessage, 'POST', a[1]);
		} else {
			new net.ContentLoader(url, getMessage);
		}
	} else {
		document.write('<s' + 'cript src="' + url + '"></script>');
	}
}
function json2str(o) {
	var arr = [], fmt = function(s) {
		if(typeof s == 'object' && s != null) return json2str(s);
		return /^(string|number)$/.test(typeof s) ? "'" + s + "'" : s;
	}
	for(var i in o) arr.push("'" + i + "':" + fmt(o[i]));
	return '{' + arr.join(',') + '}';
}
var getCacheurl;
require(['md5'], function (md5) {
	getCacheurl=function (method, parame) {
		var temp = new Array();
		switch(method) {
			case 'taobao.taobaoke.widget.items.convert':
				temp['method'] = 'taobao.taobaoke.widget.items.convert';
				temp['fields'] = parame['fields'];
				temp['num_iids'] = parame['num_iids'];
				break;
			case 'taobao.taobaoke.widget.shops.convert':
				temp['method'] = 'taobao.taobaoke.widget.shops.convert';
				temp['fields'] = parame['fields'];
				temp['seller_nicks'] = parame['seller_nicks'];
				break;
		}
		var cacheKey = md5.hex(arrToParam(temp)), cacheUrl = CACHEURL + '/' + method + '/' + cacheKey.substr(0, 2) + '/' + cacheKey + '.json';
		return cacheUrl;
	}
	//alert(md5.hex);
	//Do something with $ here
}, function (err) {
	//The errback, error callback
	//The error has a list of modules that failed
	var failedId = err.requireModules && err.requireModules[0];
	if (failedId === 'jquery') {
		//undef is function only on the global requirejs object.
		//Use it to clear internal knowledge of jQuery. Any modules
		//that were dependent on jQuery and in the middle of loading
		//will not be loaded yet, they will wait until a valid jQuery
		//does load.
		requirejs.undef(failedId);

		//Set the path to jQuery to local path
		requirejs.config({
			paths: {
				jquery: 'local/jquery'
			}
		});

		//Try again. Note that the above require callback
		//with the "Do something with $ here" comment will
		//be called if this new attempt to load jQuery succeeds.
		require(['jquery'], function () {});
	} else {
		//Some other error. Maybe show message to the user.
	}
});
function saveCache(resp, cacheUrl) {
	if(CACHETIME > 0) {
		var saveCacheUrl = 'index.php?mod=ajax&act=jssdk_cache&json=' + encodeURIComponent(json2str(resp).replace(/'/g, '’‘')) + '&dir=' + encodeURIComponent(cacheUrl);
		js_send(saveCacheUrl, 1, 'POST'); //缓存文件的url比较长，用post传输
	}
}
/*
 * 检测对象是否是空对象(不包含任何可读属性)。 //如你上面的那个对象就是不含任何可读属性
 * 方法只既检测对象本身的属性，不检测从原型继承的属性。
 */
function isOwnEmpty(obj) {
	for(var name in obj) {
		if(obj.hasOwnProperty(name)) {
			return false;
		}
	}
	return true;
};
/*
 * 检测对象是否是空对象(不包含任何可读属性)。
 * 方法既检测对象本身的属性，也检测从原型继承的属性(因此没有使hasOwnProperty)。
 */
function isEmpty(obj) {
	for(var name in obj) {
		return false;
	}
	return true;
};
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function taobaoTaobaokeWidgetItemsConvert(parame) {
	if(parame['allow_fanli'] == 0) {
		ddShowFxje({ddFxje: 0});
		return false;
	}
	if(parame['num_iids'] == '' || typeof parame['num_iids'] == 'undefined') {
		return false;
	}
	var method = 'taobao.taobaoke.widget.items.convert', fields = 'num_iid,nick,title,price,click_url,shop_click_url,item_location,seller_credit_score,pic_url,commission_rate,commission,commission_volume,volume,promotion_price';
	if(typeof parame['fields'] != 'undefined') {
		fields = parame['fields'];
	} else {
		parame['fields'] = fields;
	}
	if(typeof parame['get_num'] == 'undefined') {
		parame['get_num'] = 2;
	}
	if(typeof parame['renminbi'] == 'undefined') {
		parame['renminbi'] = 0;
	}
	if(typeof parame['outer_code'] == 'undefined') {
		parame['outer_code'] = 0;
	}
	if(typeof parame['user_level'] == 'undefined') {
		parame['user_level'] = 0;
	}
	if(typeof parame['promotion_bl'] == 'undefined') {
		parame['promotion_bl'] = 1;
	}
	if(typeof parame['tmall_fxje'] == 'undefined') {
		parame['tmall_fxje'] = 0;
	}
	if(typeof parame['ju_fxje'] == 'undefined') {
		parame['ju_fxje'] = 0;
	}
	var cacheUrl = getCacheurl(method, parame);
	//console.log('taobaoTaobaokeWidgetItemsConvert');
	if(CACHETIME > 0) {
		jQuery.ajax({
			url: cacheUrl,
			type: "GET",
			dataType: 'json',
			success: function(resp) {
				doItemsConvert(resp, parame);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				var apiParame = {method: method, fields: fields, outer_code: parame['outer_code'], num_iids: parame['num_iids'], timestamp: JSSDK_TIME, sign: JSSDK_SIGN};
				getTopApi(apiParame, parame, cacheUrl);
			}
		});
	} else {
		var apiParame = {method: method, fields: fields, outer_code: parame['outer_code'], num_iids: parame['num_iids'], timestamp: JSSDK_TIME, sign: JSSDK_SIGN};
		getTopApi(apiParame, parame, cacheUrl);
	}
}
function getAgain(apiParame, parame, cacheUrl) {
	function foo() {
		getTopApi(apiParame, parame, cacheUrl);
		//alert('5秒到时，二次加载');
	};
	if(typeof parame['get_num_error'] == 'undefined') {
		parame['get_num_error'] = parame['get_num'] + 1;
	}
	parame['get_num_error']--;
	if(parame['get_num_error'] > 0) {
		againProcess = setTimeout(foo, GETAGAINTIME);
		return againProcess;
	}
}
function getTopApi(apiParame, parame, cacheUrl) {
	againProcess = getAgain(apiParame, parame, cacheUrl);
	//console.log(apiParame);
	TOP.api('rest', 'get', apiParame, function(resp) {
		clearInterval(againProcess);
		//console.log(resp);
		if(resp) {
			if(resp.total_results == 0 && parame['get_num'] > 0) { //增加命中率
				parame['get_num']--;
				getTopApi(apiParame, parame, cacheUrl);
				return true; //退出函数，停止以下代码运行
			}
			doItemsConvert(resp, parame);
			if(resp.total_results > 0) {
				saveCache(resp, cacheUrl);
			}
		} else {
			var error_response = {'code': 1, 'msg': 'get fail'}
			ErrorLog(method, error_response);
		}
	});
}
function doItemsConvert(resp, parame) {
	//console.log(resp);
	var ddFxje = 0, promotion_price = 0;
	if(resp.error_response) {
		ErrorLog(parame['method'], resp.error_response);
	} else {//debugObjectInfo(resp.taobaoke_items.taobaoke_item[0]);
		if(resp.total_results == 0) {
			if(parame['tmall_fxje'] > 0) {
				ddFxje = parame['tmall_fxje'];
			} else if(parame['ju_fxje'] > 0) {
				ddFxje = parame['ju_fxje'];
			} else {
				ddFxje = 0;
			}
			var taobaokeItem = {};
			taobaokeItem.ddFxje = ddFxje;
		} else if(resp.total_results == 1) {
			commission = parseFloat(resp.taobaoke_items.taobaoke_item[0].commission);
			commission_rate = parseFloat(resp.taobaoke_items.taobaoke_item[0].commission_rate);
			promotion_price = parseFloat(resp.taobaoke_items.taobaoke_item[0].promotion_price);  //促销价
			price = parseFloat(resp.taobaoke_items.taobaoke_item[0].price);
			taobaokeItem = resp.taobaoke_items.taobaoke_item[0];
			if(promotion_price < price) {
				commission = dataType(promotion_price * commission_rate / 10000, 2);
				taobaokeItem.promotion = 1;
			} else {
				taobaokeItem.promotion = 0;
			}
			if(parame['onlyComm'] == 1) {//只获取佣金即可
				//commission=dataType(commission*MONEYBL,DATA_TYPE);
				ddShowFxje(taobaokeItem);
				return true;
			} else {
				if(parame['goods_type'] == 'ju') {
					ddFxje = parame['ju_fxje'];
				} else if(commission > 0) {
					if(parame['renminbi'] == 0) {
						ddFxje = fenduan(commission, parame['user_level'], fxblArr, MONEYBL);
						ddFxje = dataType(ddFxje, DATA_TYPE);
					} else {
						ddFxje = fenduan(commission, parame['user_level'], fxblArr, 1);
					}
				} else if(parame['tmall_fxje'] > 0) {
					ddFxje = parame['tmall_fxje'];
				}
				taobaokeItem.ddFxje = ddFxje;
			}
		} else {
			var a = resp.taobaoke_items.taobaoke_item;
			var commArr = new Array();
			ddShowFxje(commArr);
		}
		if(ddFxje >= 0) {
			ddShowFxje(taobaokeItem);
		} else {
			ddArrayShowFxje(commArr);
		}
	}
}
function taobaoTaobaokeWidgetShopsConvert(parame) {
	if(typeof parame['admin'] == 'undefined') {
		parame['admin'] = 0;
	}
	if(parame['seller_nicks'] == '' || typeof parame['seller_nicks'] == 'undefined') {
		return 'miss nick';
	} else {
		var method = 'taobao.taobaoke.widget.shops.convert', fields = 'shop_id,seller_nick,user_id,shop_title,click_url,commission_rate,seller_credit,shop_type,total_auction,auction_count';
		if(typeof parame['fields'] !== 'undefined') {
			fields = parame['fields'];
		} else {
			parame['fields'] = fields;
		}
		if(CACHETIME > 0) {
			var cacheUrl = getCacheurl(method, parame);
			$.ajax({
				url: cacheUrl,
				type: "GET",
				dataType: 'json',
				success: function(resp) {
					doShopsConvert(resp, parame);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					var apiParame = {method: method, fields: fields, outer_code: parame['outer_code'], seller_nicks: parame['seller_nicks'], timestamp: JSSDK_TIME, sign: JSSDK_SIGN};
					TOP.api('rest', 'get', apiParame, function(resp) {
						if(isEmpty(resp) == false) {
							doShopsConvert(resp, parame);
							saveCache(resp, cacheUrl);
						} else {
							shopsInfo['level'] = -1;
						}
					});
				}
			});
		} else {
			var apiParame = {method: method, fields: fields, outer_code: parame['outer_code'], seller_nicks: parame['seller_nicks'], timestamp: JSSDK_TIME, sign: JSSDK_SIGN};
			TOP.api('rest', 'get', apiParame, function(resp) {
				console.log(resp);
				if(isEmpty(resp) == false) {
					doShopsConvert(resp, parame);
					//saveCache(resp, cacheUrl);
				} else {
					if(typeof(noShop) == "function") {
						noShop();
					}
				}
			});
		}
	}
}
function doShopsConvert(resp, parame) {
	shopsInfo = new Array();
	j = 0;
	if(resp.error_response) {
		if(parame['admin'] == 1) {
			alert(resp.error_response.msg);
		}
		ErrorLog(parame['method'], resp.error_response);
	} else if(resp.total_results == 0) {
		if(typeof(noShop) == "function") {
			noShop();
		}
	} else {
		var shops = resp.taobaoke_shops.taobaoke_shop;
		//debugObjectInfo(shops[0]);
		for(var i in shops) {
			shopInfo = new Array();
			shopInfo['seller_nick'] = shops[i].seller_nick;
			shopInfo['user_id'] = shops[i].user_id;
			shopInfo['seller_credit'] = shops[i].seller_credit;
			shopInfo['shop_type'] = shops[i].shop_type;
			if(shopInfo['shop_type'] == 'B') {
				shopInfo['level'] = 21;
			} else {
				shopInfo['level'] = shopInfo['seller_credit'];
			}
			if(parame['from'] == 'list') {
			} else {
				shopInfo['auction_count'] = shops[i].auction_count;
				shopInfo['click_url'] = shops[i].click_url;
				shopInfo['commission_rate'] = shops[i].commission_rate;
				if(shopInfo['commission_rate'] > 0) {
					shopInfo['taoke'] = 1;
					shopInfo['fanxianlv'] = shopInfo['commission_rate'];
					shopInfo['fxbl'] = shopInfo['commission_rate'];
				} else {
					shopInfo['taoke'] = 0;
					shopInfo['fxbl'] = 0;
				}
				shopInfo['shop_id'] = shops[i].shop_id;
				shopInfo['shop_title'] = shops[i].shop_title;
				shopInfo['total_auction'] = shops[i].total_auction;
				//shopInfo['jump']="index.php?mod=jump&act=shop&url="+encodeURIComponent(encode64(shopInfo['click_url']))+"&pic="+encodeURIComponent(encode64(parame['logo']))+"&fan="+encodeURIComponent(shopInfo['fxbl'])+"&name="+encodeURIComponent(shopInfo['shop_title'])+"&sid="+shopInfo['shop_id'];
			}
			shopsInfo[j] = shopInfo;
			j++;
		}
		if(i == 0) {
			var shopGet = new Array();
			shopGet['pic_path'] = parame['pic_path'];
			shopGet['logo'] = parame['logo'];
			shopGet['cid'] = parame['cid'];
			shopGet['sid'] = parame['sid'];
			shopGet['item_score'] = parame['item_score'];
			shopGet['service_score'] = parame['service_score'];
			shopGet['delivery_score'] = parame['delivery_score'];
			shopGet['created'] = parame['created'];
			shopGet['title'] = parame['title'];
			shopGet['auction_count'] = shopInfo['auction_count'];
			shopGet['click_url'] = shopInfo['click_url'];
			shopGet['taoke'] = shopInfo['taoke'];
			shopGet['fanxianlv'] = shopInfo['fanxianlv'];
			shopGet['seller_credit'] = shopInfo['seller_credit'];
			shopGet['level'] = shopInfo['seller_credit'];
			shopGet['seller_nick'] = shopInfo['seller_nick'];
			shopGet['total_auction'] = shopInfo['total_auction'];
			shopGet['user_id'] = shopInfo['user_id'];
			shopGet['shop_type'] = shopInfo['shop_type'];
			if(shopGet['shop_type'] == 'B') {
				shopGet['level'] = 21;
			}
			shopInfo['sid'] = parame['sid']; //taobao.taobaoke.widget.shops.convert 返回的店铺id是错误的，所以从新更正
			shopInfo['jump'] = "index.php?mod=jump&act=shop&url=" + encodeURIComponent(encode64(shopGet['click_url'])) + "&pic=" + encodeURIComponent(encode64(shopGet['logo'])) + "&fan=" + encodeURIComponent(shopGet['fanxianlv']) + "&name=" + encodeURIComponent(shopGet['title']) + "&sid=" + shopGet['sid'];
			shopsInfo = shopInfo;
			if(parame['admin'] == 1 || (SHOPOPEN == 1 && shopGet['fanxianlv'] > 0 && ((shopGet['level'] >= SHOPSLEVEL && shopGet['level'] <= SHOPELEVEL) || shopGet['level'] == 21))) {
				var url = 'index.php?mod=ajax&act=addshop&' + arrToParam(shopGet);
				if(parame['admin'] == 1) {
					url = url + '&admin=1';
				}
				js_send(url, 1);
			}
		} else {
			//alert(shopsInfo[3]['seller_nick']);
		}
		ddShowShopInfo(shopsInfo);
	}
}
function taobaoTaobaokeWidgetUrlConvert(parame) {
	var method = 'taobao.taobaoke.widget.url.convert';
	if(typeof parame['outer_code'] == 'undefined') {
		parame['outer_code'] = 0;
	}
	if(CACHETIME > 0) {
		var cacheUrl = getCacheurl(method, parame);
		$.ajax({
			url: cacheUrl,
			type: "GET",
			dataType: 'json',
			success: function(resp) {
				doUrlConvert(resp, parame);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				var apiParame = {method: method, outer_code: parame['outer_code'], url: parame['url'], timestamp: JSSDK_TIME, sign: JSSDK_SIGN};
				TOP.api('rest', 'get', apiParame, function(resp) {
					if(resp) {
						doUrlConvert(resp, parame);
						saveCache(resp, cacheUrl);
					}
				});
			}
		});
	} else {
		var apiParame = {method: method, outer_code: parame['outer_code'], url: parame['url'], timestamp: JSSDK_TIME, sign: JSSDK_SIGN};
		TOP.api('rest', 'get', apiParame, function(resp) {
			if(resp) {
				doUrlConvert(resp, parame);
				saveCache(resp, cacheUrl);
			}
		});
	}
}
function doUrlConvert(resp, parame) {
	if(resp.error_response) {
		ErrorLog(parame['method'], resp.error_response);
	} else {
		var theClickUrl = resp.taobaoke_item.click_url;
		doClickUrl(theClickUrl);
	}
}
/*js/jssdk.js*/
function postForm(action, input) {
	var postForm = document.createElement("form");
	postForm.method = "post";
	postForm.action = action;
	var k;
	for(k in input) {
		if(input[k] != '') {
			var htmlInput = document.createElement("input");
			htmlInput.setAttribute("name", k);
			htmlInput.setAttribute("value", input[k]);
			postForm.appendChild(htmlInput);
		}
	}
	document.body.appendChild(postForm);
	postForm.submit();
	document.body.removeChild(postForm);
}
function u(mod, act, arr) {
	if(!arguments[2]) {
		var arr = new Array()
	}
	var mod_act_url = '';
	if(act == '' && mod == 'index') {
		mod_act_url = '?';
	} else if(act == '') {
		mod_act_url = "?mod=" + mod + "&act=index";
	} else {
		mod_act_url = "?mod=" + mod + "&act=" + act + arr2param(arr);
	}
	return mod_act_url;
}
function arr2param(arr) {
	var param = '', k;
	for(k in arr) {
		if(arr[k] != '') {
			param += '&' + k + '=' + arr[k];
		}
	}
	return param;
}
function getCookie(name) {
	var str = document.cookie.split(";")
	alert(str[0]);
	for(var i = 0; i < str.length; i++) {
		var str2 = str[i].split("=");
		if(str2[0] == name)return unescape(str2[1]);
	}
}
function AddFavorite(sURL, sTitle) {
	try {
		window.external.addFavorite(sURL, sTitle);
	}
	catch(e) {
		try {
			window.sidebar.addPanel(sTitle, sURL, "");
		}
		catch(e) {
			alert("加入收藏失败，您的浏览器不允许，请使用Ctrl+D进行添加");
		}
	}
}
function showLogin() {
	$('#menu_weibo_login').toggle();
}
function showHide(id) {
	$('#' + id).toggle();
}
/*template/default/js/fun.js*/
var errorArr = new Array();
errorArr[1] = '用户名不合法';
errorArr[2] = '包含非法词汇';
errorArr[3] = '密码位数错误或包含非法字符';
errorArr[4] = '账号密码错误';
errorArr[5] = '验证码错误';
errorArr[6] = '用户名已存在';
errorArr[7] = '邮箱格式错误';
errorArr[8] = '邮箱已存在';
errorArr[9] = 'QQ格式错误';
errorArr[10] = '您还没有登陆';
errorArr[11] = '缺少必要参数';
errorArr[12] = '每日每个商城只能评论一次';
errorArr[13] = '该邮箱不存在';
errorArr[14] = '数据超时，请重新尝试';
errorArr[15] = '参数验证失败';
errorArr[16] = '您的兑换申请正在审核中';
errorArr[17] = '不存在该商品';
errorArr[18] = '该商品已下架或加载失败';
errorArr[19] = '您的金额不足';
errorArr[20] = '您的积分不足';
errorArr[21] = '您的等级不足';
errorArr[23] = '非法网址';
errorArr[24] = '该商品加载失败！';
errorArr[25] = '请选择分类';
errorArr[26] = '内容超限';
errorArr[27] = '请添加评论内容';
errorArr[28] = '最多填写5个关键词';
errorArr[29] = '非法网址';
errorArr[30] = '此商品你已经喜欢过了';
errorArr[31] = '此商品已经有人分享过了';
errorArr[32] = 'id错误';
errorArr[33] = '亲，休息休息再评论吧';
errorArr[34] = '密码不相同';
errorArr[35] = '支付宝格式错误';
errorArr[36] = '手机号码格式错误';
errorArr[37] = '支付宝已存在';
errorArr[38] = '您的提现正在审核中';
errorArr[39] = '支付宝不能为空';
errorArr[40] = '真实姓名不能为空';
errorArr[41] = '提现密码错误';
errorArr[42] = '参数错误';
errorArr[43] = '签到关闭';
errorArr[44] = '今天已签到';
errorArr[45] = '该订单不能提交确认';
errorArr[46] = '订单不存在';
errorArr[47] = '订单号错误';
errorArr[48] = '此项不参与兑换';
errorArr[49] = '这不是一个淘宝网址';
errorArr[50] = '注册受限，请不要在短时间内重复注册！';
errorArr[51] = '商品已过期';
errorArr[52] = '今天已达到最大兑换个数，明天再来吧！';
errorArr[53] = '未开始';
errorArr[54] = '此IP禁止登录注册';
errorArr[55] = '此商品包含敏感词语';
errorArr[56] = '此商品已经有人分享过了';
errorArr[57] = '推荐人ID错误';
errorArr[58] = '未选择银行';
errorArr[59] = '银行id错误';
errorArr[60] = '银行账号格式错误';
errorArr[61] = '银行账号已被使用';
errorArr[62] = '财付通格式错误！';
errorArr[63] = '财付通已被使用！';
errorArr[64] = '功能未开启！';
errorArr[65] = '提现工具未选择！';
errorArr[66] = '库存不足！';
errorArr[67] = '验证次数太多，请联系网站管理员！';
errorArr[68] = '该手机已验证，请更换手机号码！';
errorArr[69] = '验证间隔过短，请稍后验证！';
errorArr[101] = 'miss keyword or cid';
errorArr[102] = '商品不存在';
errorArr[103] = '掌柜昵称不能为空！';
errorArr[104] = '昵称不存在或不是掌柜！';
errorArr[201] = '无上传图片';
errorArr[202] = '图片后缀名错误';
errorArr[203] = '图片太大';
errorArr[204] = '图片移动失败';
errorArr[999] = '未知错误，请联系网站管理员';
/*data/error.js*/
var noWordArr = new Array();
noWordArr[0] = '硬币';
noWordArr[1] = '百家乐';
noWordArr[2] = '网赚';
/*data/noWordArr.js*/
// JavaScript Document
function fenduan(val, level, arr) {
	if(typeof arguments[3] != 'undefined') {
		var bili = arguments[3];
	} else {
		var bili = 1;
	}
	var re = 0;
	for(var k in arr) {
		k = parseInt(k);
		if(level >= k) {
			re = val * arr[k + 'a'];
			break;
		}
	}
	if(re == 0) {
		re = val * arr[k + 'a'];
	}
	re *= bili;
	return dataType(re, DATA_TYPE);
}
function dataType(num, type) {  //本来直接用toFixed函数就可以，但是火狐浏览器不行
	if(type == 1) {
		num = parseInt(num);
	} else if(type == 2) {
		num = num * 100;
		num = num.toFixed(0);
		num = Math.round(num) / 100;
	}
	return num;
}
//小发泄：谷歌（火狐）不支持数组的for in 的形式，只支持对象。如果索引是数字，还会强制从最小的数字开始算第一个，不管你当初是怎么设置的，在IE中这些都不会存在。
//IE显示的js错误随便比较简单，但是很方便，谷歌虽然有控制台，但还是麻烦。毕竟很多人只是需要看一些定义方面的错误提示。
//在IE中，看一个A标签的链接，右键一下很简单，谷歌就费老劲了，由于网速慢图片没显示，IE可以手动二次加载，谷歌就没有。
//一个页面如果是post产生的，谷歌就不能查看其源码了（完全不懂为什么这个都做不到），IE好好的。
//还有好多就不说了，支持IE，虽然你们的第六代儿子给我造成了很多麻烦，虽然你们的第12胎都不一定完全支持css3，但相信你们会越做越好。
function setPic(pic, width, height, alt, classname, onerrorPic) {
	pic = decode64(pic);
	writestr = "<img src='" + pic + "' ";
	if(width != 0) {
		writestr += " width=" + width;
	}
	if(height != 0) {
		writestr += " height=" + height;
	}
	writestr = writestr + " alt='" + alt + "' onerror='this.src=\"" + onerrorPic + "\"' class='" + classname + "' />";
	document.write(writestr);
}
function selAll(obj) {
	$(obj).attr("checked", 'true');//全选
}
function selNone(obj) {
	$(obj).removeAttr("checked");//取消全选
}
function selfan(obj) {
	$(obj).each(function() {
		if($(this).attr("checked")) {
			$(this).removeAttr("checked");
		} else {
			$(this).attr("checked", 'true');
		}
	})
}
function parse_str(url) {
	if(url.indexOf('?') > -1) {
		u = url.split("?");
		var param1 = u[1];
	} else {
		var param1 = url;
	}
	var s = param1.split("&"), param2 = {};
	for(var i = 0; i < s.length; i++) {
		var d = s[i].split("=");
		eval("param2." + d[0] + " = '" + d[1] + "';");
	}
	return param2;
}
/*var arr = [];
 for(i in param2){
 arr.push( i + "=" + param2[i]); //根据需要这里可以考虑escape之类的操作
 }
 alert(arr.join("&")) */
function postForm(action, input) {
	var postForm = document.createElement("form");//表单对象
	postForm.method = "post";
	postForm.action = action;
	var k;
	for(k in input) {
		if(input[k] != '') {
			var htmlInput = document.createElement("input");
			htmlInput.setAttribute("name", k);
			htmlInput.setAttribute("value", input[k]);
			postForm.appendChild(htmlInput);
		}
	}
	document.body.appendChild(postForm);
	//alert(document.body.innerHTML)
	postForm.submit();
	document.body.removeChild(postForm);
}
function u(mod, act, arr, wjt) {
	if(!arguments[2]) {
		var arr = new Array();
	}
	if(!arguments[3]) {
		wjt = 0;
	}
	var mod_act_url = '';
	if(act == '' && mod == 'index') {
		mod_act_url = '?';
	} else if(act == '') {
		mod_act_url = "index.php?mod=" + mod + "&act=index";
	} else {
		if(wjt == 1) {
			var str = '';
			for(k in arr) {
				str += '-' + arr[k];
			}
			mod_act_url = mod + '/' + act + str + '.html';
		} else {
			mod_act_url = "index.php?mod=" + mod + "&act=" + act + arr2param(arr);
		}
	}
	return mod_act_url;
}
function arr2param(arr) {
	var param = '', k;
	for(k in arr) {
		if(arr[k] != '') {
			param += '&' + k + '=' + arr[k];
		}
	}
	return param;
}
function getClientHeight() {
	var clientHeight = 0;
	if(document.body.clientHeight && document.documentElement.clientHeight) {
		var clientHeight = (document.body.clientHeight < document.documentElement.clientHeight) ? document.body.clientHeight : document.documentElement.clientHeight;
	} else {
		var clientHeight = (document.body.clientHeight > document.documentElement.clientHeight) ? document.body.clientHeight : document.documentElement.clientHeight;
	}
	return clientHeight;
}
function like(id, htmlId) {
	var $t = $("#" + htmlId), user_hart = parseInt($t.text());
	$.ajax({
		url: u('ajax', 'like'),
		data: {'id': id},
		dataType: 'jsonp',
		jsonp: "callback",
		success: function(data) {
			if(data.s == 0) {
				alert(errorArr[data.id]);
			} else if(data.s == 1) {
				$t.text(user_hart + 1);
			}
		}
	});
}
String.prototype.Trim = function() {
	return this.replace(/(^\s*)|(\s*$)/g, "");
}
//////右下角帮助
function miaovAddEvent(oEle, sEventName, fnHandler) {
	if(oEle.attachEvent) {
		oEle.attachEvent('on' + sEventName, fnHandler);
	} else {
		oEle.addEventListener(sEventName, fnHandler, false);
	}
}
function helpWindows(word, title) {
	$('#miaov_float_layer').remove();
	$("body").append('<div class="float_layer" id="miaov_float_layer"><h2><strong>' + title + '</strong><a id="btn_min" href="javascript:;" class="min"></a><a id="btn_close" href="javascript:;" class="close"></a></h2><div class="content"><div class="wrap">' + word + '</address></div></div></div>');
	var oDiv = document.getElementById('miaov_float_layer'), oBtnMin = document.getElementById('btn_min'), oBtnClose = document.getElementById('btn_close'), oDivContent = oDiv.getElementsByTagName('div')[0];
	var iMaxHeight = 0;
	var isIE6 = window.navigator.userAgent.match(/MSIE 6/ig) && !window.navigator.userAgent.match(/MSIE 7|8/ig);
	oDiv.style.display = 'block';
	iMaxHeight = oDivContent.offsetHeight;
	if(isIE6) {
		oDiv.style.position = 'absolute';
		repositionAbsolute();
		miaovAddEvent(window, 'scroll', repositionAbsolute);
		miaovAddEvent(window, 'resize', repositionAbsolute);
	} else {
		oDiv.style.position = 'fixed';
		repositionFixed();
		miaovAddEvent(window, 'resize', repositionFixed);
	}
	oBtnMin.timer = null;
	oBtnMin.isMax = true;
	oBtnMin.onclick = function() {
		startMove
		(
			oDivContent, (this.isMax = !this.isMax) ? iMaxHeight : 0,
			function() {
				oBtnMin.className = oBtnMin.className == 'min' ? 'max' : 'min';
			}
		);
	};
	oBtnClose.onclick = function() {
		oDiv.style.display = 'none';
	};
};
function startMove(obj, iTarget, fnCallBackEnd) {
	if(obj.timer) {
		clearInterval(obj.timer);
	}
	obj.timer = setInterval
	(
		function() {
			doMove(obj, iTarget, fnCallBackEnd);
		}, 30
	);
}
function doMove(obj, iTarget, fnCallBackEnd) {
	var iSpeed = (iTarget - obj.offsetHeight) / 8;
	if(obj.offsetHeight == iTarget) {
		clearInterval(obj.timer);
		obj.timer = null;
		if(fnCallBackEnd) {
			fnCallBackEnd();
		}
	} else {
		iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);
		obj.style.height = obj.offsetHeight + iSpeed + 'px';
		((window.navigator.userAgent.match(/MSIE 6/ig) && window.navigator.userAgent.match(/MSIE 6/ig).length == 2) ? repositionAbsolute : repositionFixed)()
	}
}
function repositionAbsolute() {
	var oDiv = document.getElementById('miaov_float_layer'), left = document.body.scrollLeft || document.documentElement.scrollLeft, top = document.body.scrollTop || document.documentElement.scrollTop, width = document.documentElement.clientWidth, height = document.documentElement.clientHeight;
	oDiv.style.left = left + width - oDiv.offsetWidth + 'px';
	oDiv.style.top = top + height - oDiv.offsetHeight + 'px';
}
function repositionFixed() {
	var oDiv = document.getElementById('miaov_float_layer'), width = document.documentElement.clientWidth, height = document.documentElement.clientHeight;
	oDiv.style.left = width - oDiv.offsetWidth + 'px';
	oDiv.style.top = height - oDiv.offsetHeight + 'px';
}
//操作cookie
function setCookie(c_name, value, expiredays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" + escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString());
}
//取得cookie
function getCookie(name) {
	var str = document.cookie.split(";")
	for(var i = 0; i < str.length; i++) {
		var str2 = str[i].split("=");
		str2[0] = str2[0].Trim();
		if(str2[0] == name) {
			return unescape(str2[1]);
		}
	}
}
//删除cookie
function delCookie(name) {
	var date = new Date();
	date.setTime(date.getTime() - 10000);
	document.cookie = name + "=n;expire=" + date.toGMTString();
}
//图片自适应大小
function imgAuto(img, maxW, maxH) {
	var oriImg = document.createElement("img");
	oriImg.onload = function() {
		oriImg.height
		if(oriImg.width == 0 || oriImg.height == 0)
			return;
		var oriW$H = oriImg.width / oriImg.height;
		//var maxW$H = maxW / maxH;
		if(oriImg.height > maxH) {
			img.style.height = maxH;
			// img.removeAttribute("width");
			img.style.width = maxH * oriW$H;
		}
		if(img.width > maxW) {
			img.style.width = maxW;
			// img.removeAttribute("height");
			img.style.height = maxW / oriW$H;
		}
		if(maxH) {// if it defined the maxH argument
			if(img.height > 0)
				img.style.marginTop = (maxH - img.height) / 2 + "px";
		}
	};
	oriImg.src = img.src;
	img.style.display = "block";
}
function ajaxPost(url, query) {
	var type = 'json', test = arguments[2];
	if(test == 1) {
		type = 'html';
	}
	$.ajax({
		url: url,
		type: "POST",
		data: query,
		dataType: type,
		success: function(data) {
			if(test == 1) {
				alert(data);
			}
			if(data.s == 0) {
				alert(errorArr[data.id]);
			} else if(data.s == 1) {
				alert('保存成功');
				location.replace(location.href);
			}
		}
	});
}
function ajaxPostForm(form) {
	var query = $(form).serialize(), url = $(form).attr('action'), type = 'json', word = arguments[2], goto = arguments[1];
	if(typeof word == 'undefined') word = '';
	if(typeof goto == 'undefined') goto = '';
	$.ajax({
		url: url,
		type: "POST",
		data: query,
		dataType: 'json',
		success: function(data) {//alert(data);
			if(data.s == 0) {
				alert(errorArr[data.id]);
			} else if(data.s == 1) {
				if(word != '') {
					alert(word);
				}
				if(goto != '') {
					window.location.href = goto;
					return false;
				}
				if(typeof data.g == 'undefined' || data.g == '' || data.g == 0) {
					location.replace(location.href);
				} else {
					window.location.href = data.g;
				}
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.status + '--' + XMLHttpRequest.readyState + '--' + textStatus);
		}
	});
}
function IsUrl(str_url) {
	var strRegex = "^((https|http|ftp|rtsp|mms)?://)"
		+ "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
		+ "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
		+ "|" // 允许IP和DOMAIN（域名）
		+ "([0-9a-z_!~*'()-]+\.)*" // 域名- www.
		+ "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
		+ "[a-z]{2,6})" // first level domain- .com or .museum
		+ "(:[0-9]{1,4})?" // 端口- :80
		+ "((/?)|" // a slash isn't required if there is no file name
		+ "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";
	var re = new RegExp(strRegex);
	//re.test()
	if(re.test(str_url)) {
		return 1;
	} else {
		return 0;
	}
}
function checkForm(t) {
	var subm = 1;
	$(t).find('.required').each(function() {
		var word = $(this).attr('word'), num = $(this).attr('num'), url = $(this).attr('url'), val = $(this).val();
		if(typeof word == 'undefined') {word = '';}
		if(val == '' || val == word) {
			$(this).focus().addClass('red_border');
			if(word != '') {
				alert(word);
			} else {
				alert('此字段必填');
			}
			subm = 0;
			return false;
		}
		if(num == 'y' && isNaN(val)) {
			$(this).focus().addClass('red_border');
			alert('这不是一个数字');
			subm = 0;
			return false;
		}
		if(url == 'y' && IsUrl(val) == 0) {
			$(this).focus().addClass('red_border');
			alert('这不是一个网址（http://开头）');
			subm = 0;
			return false;
		}
	}).blur(function() {
			if($(this).val() != '') {
				$(this).removeClass('red_border');
			}
		});
	if(subm == 0) {
		return false;
	} else {
		return true;
	}
}
function http_pic(pic) {
	if(pic.indexOf("http://") >= 0) {
		return pic;
	} else {
		return '../' + pic;
	}
}
function inArray(val, array) {
	for(var i in array) {
		if(array[i] != '' && val.indexOf(array[i]) >= 0) {
			return val;
		}
	}
	return '';
}
function backToTop() {
	var $backToTopTxt = "返回顶部";
	var $backToTopEle = $('<div class="backToTop"></div>').appendTo($("body")).text($backToTopTxt).attr("title", $backToTopTxt).click(function() {$("html, body").animate({ scrollTop: 0 }, 120);});
	var $backToTopFun = function() {
		var st = $(document).scrollTop(), winh = $(window).height();
		(st > 0) ? $backToTopEle.show() : $backToTopEle.hide();
		//IE6下的定位
		if(!window.XMLHttpRequest) {
			$backToTopEle.css("top", st + winh - 166);
		}
	};
	$(window).bind("scroll", $backToTopFun);
	$backToTopFun();
}
function domStop(id) {  //id外围需要一个position:relative的元素定位，id最好不要有css，只起到单纯的定位作用
	var IO = document.getElementById(id), Y = IO, H = 0, IE6;
	IE6 = window.ActiveXObject && !window.XMLHttpRequest;
	while(Y) {
		H += Y.offsetTop;
		Y = Y.offsetParent
	}
	;
	if(IE6) {
		IO.style.cssText = "position:absolute;top:expression(this.fix?(document" + ".documentElement.scrollTop-(this.javascript||" + H + ")):0)";
	} else {
		IO.style.cssText = "top:0px";
	}
	window.onscroll = function() {
		var d = document,
			s = Math.max(d.documentElement.scrollTop, document.body.scrollTop);
		if(s > H && IO.fix || s <= H && !IO.fix) return;
		if(!IE6) IO.style.position = IO.fix ? "" : "fixed";
		IO.fix = !IO.fix;
	};
	try {
		document.execCommand("BackgroundImageCache", false, true)
	} catch(e) {}
	;
}
function regEmail(email) {
	var reg = /^[-_A-Za-z0-9\.]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/;
	if(reg.test(email)) {
		return true;
	} else {
		return false;
	}
}
function regMobile(str) {
	if(/^1\d{10}$/g.test(str)) {
		return true;
	} else {
		return false;
	}
}
function regAlipay(str) {
	if(regMobile(str) || regEmail(str)) {
		return true;
	} else {
		return false;
	}
}
function regQQ(qq) {
	if((!isNaN(str) && str.length.length > 4 && str.length.length < 15) || regEmail(str)) {
		return true;
	} else {
		return false;
	}
}
function fixDiv(div_id, offsetTop) {
	var offset = arguments[1] ? arguments[1] : 0, Obj = $(div_id), w = Obj.width(), ObjTop = Obj.offset().top, isIE6 = $.browser.msie && $.browser.version == '6.0';
	if(isIE6) {
		$(window).scroll(function() {
			if($(window).scrollTop() <= ObjTop) {
				Obj.css({
					'position': 'relative',
					'top': 0
				});
			} else {
				Obj.css({
					'position': 'absolute',
					'top': $(window).scrollTop() + offsetTop + 'px',
					'z-index': 1
				});
			}
		});
	} else {
		$(window).scroll(function() {
			if($(window).scrollTop() <= ObjTop) {
				Obj.css({
					'position': 'relative',
					'top': 0
				});
			} else {
				Obj.css({
					'position': 'fixed',
					'top': 0 + offsetTop + 'px',
					'z-index': 1,
					'width': w + 'px',
					'overflow': 'hidden'
				});
			}
		});
	}
}
function debugObjectInfo(obj) {
	traceObject(obj);
	function traceObject(obj) {
		var str = '';
		if(obj.tagName && obj.name && obj.id) str = "<table border='1' width='100%'><tr><td colspan='2' bgcolor='#ffff99'>traceObject 　　tag: &lt;" + obj.tagName + "&gt;　　 name = \"" + obj.name + "\" 　　id = \"" + obj.id + "\" </td></tr>";
		else {
			str = "<table border='1' width='100%'>";
		}
		var key = [];
		for(var i in obj) {
			key.push(i);
		}
		key.sort();
		for(var i = 0; i < key.length; i++) {
			var v = new String(obj[key[i]]).replace(/</g, "&lt;").replace(/>/g, "&gt;");
			str += "<tr><td valign='top'>" + key[i] + "</td><td>" + v + "</td></tr>";
		}
		str = str + "</table>";
		writeMsg(str);
	}
	function trace(v) {
		var str = "<table border='1' width='100%'><tr><td bgcolor='#ffff99'>";
		str += String(v).replace(/</g, "&lt;").replace(/>/g, "&gt;");
		str += "</td></tr></table>";
		writeMsg(str);
	}
	function writeMsg(s) {
		traceWin = window.open("", "traceWindow", "height=600, width=800,scrollbars=yes");
		traceWin.document.write(s);
	}
}
function call_user_func(func) { //模拟php的call_user_func，缺点参数不能是对象，有待改进
	var l = arguments.length, s = '', x = '';
	for(var i = 0; i < l; i++) {
		if(isNaN(arguments[i]) == false) {
			x = arguments[i];
		} else {
			x = '"' + arguments[i] + '"';
		}
		if(i == 1) {
			s = s + x;
		} else if(i > 1) {
			s = s + ',' + x;
		}
	}
	eval(func + '(' + s + ')');
}
/*function call_user_func (cb) {  //参数可以是数组，但是被调用的含糊不能含有jquery方法
 // http://kevin.vanzonneveld.net
 // +   original by: Brett Zamir (http://brett-zamir.me)
 // +   improved by: Diplom@t (http://difane.com/)
 // +   improved by: Brett Zamir (http://brett-zamir.me)
 // *     example 1: call_user_func('isNaN', 'a');
 // *     returns 1: true
 var func;
 if (typeof cb === 'string') {
 func = (typeof this[cb] === 'function') ? this[cb] : func = (new Function(null, 'return ' + cb))();
 } else if (Object.prototype.toString.call(cb) === '[object Array]') {
 func = (typeof cb[0] == 'string') ? eval(cb[0] + "['" + cb[1] + "']") : func = cb[0][cb[1]];
 } else if (typeof cb === 'function') {
 func = cb;
 }
 if (typeof func != 'function') {
 throw new Error(func + ' is not a valid function');
 }
 var parameters = Array.prototype.slice.call(arguments, 1);
 return (typeof cb[0] === 'string') ? func.apply(eval(cb[0]), parameters) : (typeof cb[0] !== 'object') ? func.apply(null, parameters) : func.apply(cb[0], parameters);
 }*/
function intval(v) {
	v = parseInt(v);
	return isNaN(v) ? 0 : v;
}
// 获取元素信息
function getPos(e) {
	var l = 0, t = 0, w = intval(e.style.width), h = intval(e.style.height), wb = e.offsetWidth, hb = e.offsetHeight;
	while(e.offsetParent) {
		l += e.offsetLeft + (e.currentStyle ? intval(e.currentStyle.borderLeftWidth) : 0);
		t += e.offsetTop + (e.currentStyle ? intval(e.currentStyle.borderTopWidth) : 0);
		e = e.offsetParent;
	}
	l += e.offsetLeft + (e.currentStyle ? intval(e.currentStyle.borderLeftWidth) : 0);
	t += e.offsetTop + (e.currentStyle ? intval(e.currentStyle.borderTopWidth) : 0);
	return {x: l, y: t, w: w, h: h, wb: wb, hb: hb};
}
// 获取滚动条信息
function getScroll() {
	var t, l, w, h;
	if(document.documentElement && document.documentElement.scrollTop) {
		t = document.documentElement.scrollTop;
		l = document.documentElement.scrollLeft;
		w = document.documentElement.scrollWidth;
		h = document.documentElement.scrollHeight;
	} else if(document.body) {
		t = document.body.scrollTop;
		l = document.body.scrollLeft;
		w = document.body.scrollWidth;
		h = document.body.scrollHeight;
	}
	return { t: t, l: l, w: w, h: h };
}
// 锚点(Anchor)间平滑跳转
function scroller(el, duration, offset) {
	if(typeof el != 'object') { el = document.getElementById(el); }
	if(!el) return;
	var z = this;
	z.el = el;
	z.p = getPos(el);
	if(offset > 0) {
		z.p.y = z.p.y - offset;
	}
	z.s = getScroll();
	z.clear = function() {
		window.clearInterval(z.timer);
		z.timer = null
	};
	z.t = (new Date).getTime();
	z.step = function() {
		var t = (new Date).getTime(), p = (t - z.t) / duration;
		if(t >= duration + z.t) {
			z.clear();
			window.setTimeout(function() {z.scroll(z.p.y, z.p.x)}, 13);
		} else {
			st = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.p.y - z.s.t) + z.s.t;
			sl = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.p.x - z.s.l) + z.s.l;
			z.scroll(st, sl);
		}
	};
	z.scroll = function(t, l) {window.scrollTo(l, t)};
	z.timer = window.setInterval(function() {z.step();}, 13);
}
function randNum(n) {
	var rnd = "";
	for(var i = 0; i < n; i++) {
		rnd += Math.floor(Math.random() * 10);
	}
	return rnd;
}
function getMobileYzm(mobile, n) {
	var rnd = "";
	mobile = String(mobile);
	for(var i = 0; i < n; i = i + 2) {
		var r = Math.floor(Math.random() * 10);
		r = String(r);
		rnd += r + String(mobile.charAt(r));
	}
	return rnd;
}
function iframe(url, width, height) {
	document.write('<iframe id="testframe" scrolling="no" src="' + url + '" width="' + width + '" height="' + height + '" frameborder="0"></iframe>');
}
/*获取模板函数*/
function getTpl(_function) {
	var tpl = _function.toString();
	tpl = tpl.replace('function ' + getFuncName(_function) + '() {/*', '').replace(/\*\/;}$/, '');
	return tpl;
	//alert(tpl.match(/^[\w]+\snav_tpl\(\)\{\s+\/\*([\w\s*\/\\<>'"=#;:$.()]+)\*\/\s+\}$/i)[1]);
}
function getFuncName(_callee) {
	var ie = !-[1, ];
	if(ie == true) {
		var _text = _callee.toString();
		return _text.match(/^function\s*([^\(]+).*\r\n/)[1];
	} else {
		return _callee.prototype.constructor.name;
	}
}
/*循环对象模板*/
function getTplObj(tplName, obj) {
	var tpl = getTpl(tplName), _tpl = '', str = '';
	if(typeof obj[0] == 'undefined') {
		_tpl = tpl;
		for(var j in obj) {
			var pattern = "\{\\$" + j + "\}";
			var reg = new RegExp(pattern, "g");
			_tpl = _tpl.replace(reg, obj[j]);
		}
		return _tpl;
	} else {
		for(i in obj) {
			_tpl = tpl;
			for(var j in obj[i]) {
				var pattern = "\{\\$" + j + "\}";
				var reg = new RegExp(pattern, "g");
				_tpl = _tpl.replace(reg, obj[i][j]);
			}
			str += _tpl;
		}
		return str;
	}
}
$LAB.script(window.jQueryPath).wait(function() {
	jQuery.fn.focusClear = function() {
		inputFocusTime = 0;
		$(this).focus(function() {//alert(inputFocusTime);
			if(new Date().getTime() - inputFocusTime > 100) {
				$(this).val('');
				inputFocusTime = 0;
			}
		});
		$(this)[0].onpaste = function() {
			inputFocusTime = new Date().getTime();
		}
	}
	_jQuery(jQuery);
});
if(typeof getCookie('userlogininfo') != 'undefined') {
	IS_LOGIN = 1;
} else {
	IS_LOGIN = 0;
}
if(!-[1, ] == true) {
	IE = 1;
} else {
	IE = 0;
}
function tao_perfect_click($t) {
	var url = $t.attr('a_jump_click') + '&url=' + encodeURIComponent(encode64($t.attr('href')));
	$t.attr('href', url);
}
/*js/fun.js*/
function addJumpBoxDom(o) {
	$('#ddjumpboxdom').html('<div class="LightBox" id="LightBox"></div><div id="' + o.id + '" show="0" class="jumpbox"><div class="top_left"></div><div class="top_center"></div><div class="top_right"></div><div class="middle_left"></div><div class="middle_center"><div class="close"><a></a></div><p class="title"></p><div class="contain">内容加载中。。。。。。</div></div><div class="middle_right"></div><div class="end_left"></div><div class="end_center"></div><div class="end_right"></div></div>');
}
function jumpBoxInitialize(o) {
	if(o.titlebg == 1) {
		o.titleWord = '<div class="titlebg" style="border:1px solid #FFCC7F; background-color:#FFFFE5; padding:8px; overflow:hidden; width:' + (o.width - 80) + 'px">' + o.title + '</div>';
	} else {
		o.titleWord = o.title;
	}
	if(o.titleWord == '') {
		$('#' + o.id + ' .title').css('margin-bottom', 0);
	}
	$('#' + o.id + ' .title').html(o.titleWord);
	$('#' + o.id + ' .middle_left').css('height', o.height);
	$('#' + o.id + ' .middle_center').css('height', o.height);
	$('#' + o.id + ' .middle_right').css('height', o.height);
	$('#' + o.id).css('width', o.width).css('margin-left', '-' + (o.width / 2) + 'px');
	$('#' + o.id + ' .top_center').css('width', o.width - 16);
	if(o.background != '') {
		$('#' + o.id + ' .middle_center').css('width', o.width - 16).css('background', o.background);
	} else {
		$('#' + o.id + ' .middle_center').css('width', o.width - 16);
	}
	$('#' + o.id + ' .end_center').css('width', o.width - 16);
	$('#' + o.id + ' .middle_center .contain').css('width', o.width - 56);
	$('#' + o.id).attr('show', 1);
	g1 = (getClientHeight() - o.height) / 2;
	g2 = g1 / getClientHeight();
	g2 = Math.round(g2 * 100) - 1;
	$('#' + o.id).css('top', g2 + '%');
	$('#LightBox').css('height', document.body.scrollHeight);
	if($.browser.msie && $.browser.version == "6.0") {
		default_top1 = document.documentElement.scrollTop + 150 + "px";
		$("#" + o.id).css("top", default_top1);
		$(window).scroll(function() {
			default_top2 = document.documentElement.scrollTop + 150 + "px";
			$("#" + o.id).css("top", default_top2);
		})
	}
}
// JavaScript Document
// 创建一个闭包
function _jQuery($) {
	// 插件的定义
	$.fn.jumpBox = function(options) {
		debug(this);
		// build main options before element iteration
		var opts = $.extend({},
			$.fn.jumpBox.defaults, options);
		// iterate and reformat each matched element
		$('body').click(mouseLocation);
		function mouseLocation(e) {
			if(opts.easyClose == 1 && $('#' + opts.id).attr('show') == 1) {
				rightk = (document.body.offsetWidth - 950) / 2;
				rightw = (950 - opts.width) / 2;
				toright = rightk + rightw;
				totop = $('#' + opts.id).attr("offsetTop");
				if(e.pageX < toright || e.pageX > toright + opts.width || e.pageY < totop || e.pageY > totop + opts.height) {
					$('#' + opts.id + ' .close').click();
				}
			}
		}
		return this.each(function() {
			$this = $(this);
			// build element specific options
			var o = $.meta ? $.extend({},
				opts, $this.data()) : opts;
			// update element styles
			/*if(o.debug==1){
			 $.fn.jumpBox.initialize(o);
			 }*/
			$this[o.method](o.bind, function(event) {  // $this[o.method](o.event,function(event) {
				$('#ddjumpboxdom').html('');
				re = 1;
				if(o.reg != '') {
					re = eval(o.reg);
				}
				if(re == 2) {
					return false;
				}
				if(re == 1) {
					if(o.defaultContain == 0) {
						$.fn.jumpBox.load(o);
					}
					$('select').hide();
					$('#' + o.id + ' select').show();
					if(o.button == 1) {
						$(this).attr('disabled', true);
					}
					$.fn.jumpBox.initialize(o);
					ajaxUrl = $(this).attr('href');
					word = $(this).attr('word');
					contain = o.contain;
					$content = $('#' + o.id + ' .contain');
					if(o.jsCode != '') {
						eval(o.jsCode);
					}
					if(ajaxUrl != '' && ajaxUrl != undefined && o.a == 0) {
						$.post(ajaxUrl, function(data) {
							$('#' + o.id + ' .contain').html(data);
						});
					} else if(word != '' && word != undefined) {
						$('#' + o.id + ' .contain').html(word);
					} else if(o.contain != '') {
						$('#' + o.id + ' .contain').html(contain);
					}
					$('#' + o.id).show();
					if(o.LightBox == 'show') {
						bodyHeight = document.body.scrollHeight;
						$('#LightBox').css('height', bodyHeight);
						$('#LightBox').show();
					}
					if($.browser.msie && ($.browser.version == "6.0") && !$.support.style) {
						$('#' + o.id + ' .close').hover(function() {
								$('#' + o.id + ' .close a').css('background', 'url(images/box_config.gif) no-repeat -101px -39px');
							},
							function() {
								$('#' + o.id + ' .close a').css('background', 'url(images/box_config.gif) no-repeat');
							});
					}
					if(o.jsCode2 != '') {
						eval(o.jsCode2);
					}
					if(o.jsScript != '') {
						$.getScript(o.jsScript);
					}
				}
				event.stopPropagation();
				if(o.a == 0) {
					return false;
				}
			});
			$.fn.jumpBox.close(o, $(this));
			//var markup = $this.html();
			//markup = $.fn.hilight.format(markup);
			//$this.html(markup);
		});
	};
	// 私有函数：debugging
	function debug($obj) {
		if(window.console && window.console.log) window.console.log('hilight selection count: ' + $obj.size());
	};
	//初始化div
	$.fn.jumpBox.initialize = function(o) {
		jumpBoxInitialize(o);
	}
	//定义加载dom函数
	$.fn.jumpBox.load = function(o) {
		addJumpBoxDom(o);
	};
	//关闭弹出层
	$.fn.jumpBox.close = function(o, t) {
		cl = '#' + o.id + ' .close';
		ob = '#' + o.id;
		$(cl).live('click',
			function() {
				$(ob).hide();
				$('.LightBox,.jumpbox').hide();
				$('select').show();
				$(ob).attr('show', 0);
				if(o.button == 1) {
					t.attr('disabled', false);
				}
			})
	};
	// 插件的defaults
	$.fn.jumpBox.defaults = {
		id: 'jumpbox',
		title: '',
		titlebg: 0,
		contain: '',
		jsCode: '',
		jsCode2: '',
		jsScript: '',
		LightBox: 'none',
		a: 0,
		easyClose: 0,
		button: 0,
		height: 300,
		width: 576,
		defaultContain: 0,
		bind: 'click',
		background: '',
		reg: '',
		method: 'bind'
	};
	// 闭包结束
};
$(function() {
	$("body").append('<div id="ddjumpboxdom"></div>');
});
function jumpboxClose() {
	$('#LightBox,#jumpbox').hide();
}
function jumpboxOpen(contain, height, width) {
	var domObject = new Object();
	domObject.id = 'jumpbox';
	domObject.title = '';
	domObject.titlebg = 0;
	domObject.height = height;
	domObject.width = width;
	domObject.background = '';
	addJumpBoxDom(domObject);
	jumpBoxInitialize(domObject);
	$('#LightBox,#jumpbox').show();
	if(contain != '') {
		$('#' + domObject.id + ' .contain').html(contain);
	}
}
/*js/jumpbox.js*/
