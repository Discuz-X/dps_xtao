<?php

require_once dirname(__FILE__).'/../taobao-sdk/TopSdk.php'; //将入口文件载入
require_once dirname(__FILE__).'/../taobao-sdk/top/request/TaobaokeItemsGetRequest.php';

class items_service {

	public $appkey;
	public $secreckey;
	public $pid;
	public $items_dao;

	public function search($params, $pageNo = 1, $pageSize = 20) {

		if(empty($this->appkey) || empty($this->secreckey) || empty($this->pid)) {
			return NULL;
		}

		$c            = new TopClient;
		$c->appkey    = $this->appkey;
		$c->secretKey = $this->secreckey;
		$req          = new TaobaokeItemsGetRequest;
		$req->setPageNo($pageNo);
		$req->setPageSize($pageSize);
		$req->setPid($this->pid);
		//$req->setFields("num_iid,title,pic_url,price,click_url,commission_num,commission");
		$req->setFields($params['fields']);
		//关键字
		$keyword = iconv("GBK", "UTF-8", $params['keyword']);
		$req->setKeyword($keyword);
		//佣金比例
		$req->setStartCommissionRate($params['startCommissionRate']);
		$req->setEndCommissionRate($params['endCommissionRate']);
		//30天累计成交量
		$req->setStartCommissionNum($params['startCommissionNum']);
		$req->setEndCommissionNum($params['endCommissionNum']);
		//价格
		$req->setStartPrice($params['startPrice']);
		$req->setEndPrice($params['endPrice']);
		//排序
		$req->setSort($params['sort']);


		$resp = $c->execute($req);

		//var_dump($resp);

		$items = array();
		foreach($resp->taobaoke_items->taobaoke_item as $key => $item) {
			//把标题转换成中文
			$item->title = iconv("UTF-8", "GBK", $item->title);
			//把对象转换成数组，对中文内容进行编码，
			$it = $this->object_to_array($item);
			//把数组转换成json格式并编码，便于页面显示并回传
			$item->jsonstr         = urlencode(json_encode($it));
			$item->commission_rate = $item->commission_rate / 100.0;
			$items[]               = $item;
		}

		return array('totalcount' => $resp->total_results, 'items' => $items);
	}

	public function insert($items, $fid, $type = 0) {
		$effect_count = 0;
		for($i = 0; $i < count($items); $i++) {
			//对接收到的数据进行解码，其实就是对jsonstr进行反编码
			$item = urldecode($items[$i]);
			//从json转换成数组
			$item = json_decode($item, TRUE);
			foreach($item as $key => $value) {
				//对数组中所有内容进行解码
				$item[$key] = urldecode($value);
			}
			//关联栏目id
			$item['fid']  = $fid;
			$item['type'] = $type;
			//随机生成喜欢数量
			$item['like_count'] = rand(100, 300);
			/* if(C::t('#tkb#items')->insert($item)>0){
				$effect_count++;
			} */

			if($this->items_dao->insert($item) > 0) {
				$effect_count++;
			}
		}

		return $effect_count;
	}

	public function delete($ids) {
		$effect_count = 0;
		foreach($ids as $id) {
			/* if(C::t('#tkb#items')->delete($id)>0){
				$effect_count++;
			} */
			if($this->items_dao->delete($id) > 0) {
				$effect_count++;
			}
		}

		return $effect_count;
	}

	function delete_all() {
		return $this->items_dao->delete_all();
	}

	public function  get_items_rand($fid, $type, $limit = 4) {
		return $this->items_dao->get_items_rand($fid, $type, $limit);
	}

	public function  get_items_by_type($fid, $type, $offset, $limit) {
		return $this->items_dao->get_items_by_type($fid, $type, $offset, $limit);
	}

	public function  get_items_count_by_type($fid, $type) {
		return $this->items_dao->get_items_count_by_type($fid, $type);
	}

	public function  get_item($id) {
		return $this->items_dao->get_item($id);
	}

	public function object_to_array($obj) {
		$_arr = is_object($obj) ? get_object_vars($obj) : $obj;
		foreach($_arr as $key => $val) {
			$val       = (is_array($val) || is_object($val)) ? $this->object_to_array($val) : $val;
			$arr[$key] = urlencode($val);
		}

		return $arr;
	}

	public function get_selected_forum() {

	}

	public function  redirect($url, $message) {
		echo <<<EOF
			<script>
EOF;
		if(!empty($message)) {
			echo <<<EOF
			alert('$message');
EOF;
		}
		echo <<<EOF
				window.location.href='$url';
			</script>;
EOF;
		exit();
	}

}

?>