<?php 
namespace app;
/**
 * 主方法
 */
class Index{
	// 有序集合key
	protected $zsetKey = 'test_board';
	// hash的key
	protected $hashKey = 'test_board_hash';
	// 请求实例
	protected $request;
	public function __construct(){
		$this->request = new \package\Request();
		$uri = $this->request->uri();
		if (strpos($uri, '?') !== false) {
			$uri = substr($uri, 0,strpos($uri, '?'));
		}
		if (empty($uri)) {
			return $this->index();
		}
		$arr = explode('/', $uri);
		$this->{$arr[0]}();
	}
	/**
	 * 帖子列表
	 */
	public function index(){
		$data = [];
		$page = intval($this->request->get('page',1));
		$size = intval($this->request->get('size',50));
		$page = $page >= 1 ? $page : 1;
		$count = 0;
		$redis = \package\Redis::instance();
		$count = $redis->zcard($this->zsetKey);
		$data = [
			'count' => $count,
			'page' => $page,
			'size' => $size,
			'max_page' => ceil($count/$size),
			'list' => [],
		];
		if ($data['max_page'] < $page) {
			json_success($data);
		}
		// 分数倒序
		$list = $redis->zrevrangebyscore($this->zsetKey,$page*$size-1,($page-1)*$size);
		foreach ($list as $k => $v) {
			$data['list'][] = $redis->hGetAll($this->hashKey.':'.$v);
		}
		json_success($data);
	}
	/**
	 * 发帖
	 */
	public function add(){
		$params = $this->request->post();
		// 检查参数
		if (empty($params['subject'])) {
			throw new \Exception('参数subject错误');
		}
		if (empty($params['Author'])) {
			throw new \Exception('参数Author错误');
		}
		if (empty($params['Body'])) {
			throw new \Exception('参数Body错误');
		}
		$params['Idate'] = date('Y-m-d H:i:s');
		$params['Ip'] = $this->request->ip();
		// 数据入库
		$db = \package\Db::instance();
		$sql = "INSERT INTO board(subject,Author,Idate,Body,Ip) VALUES ('{$params['subject']}','{$params['Author']}','{$params['Idate']}','{$empty['Body']}','{$params['Ip']}')";
		$lastId = $db->insertGetLastId($sql);
		$params['Id'] = $lastId;
		$params['Replies'] = 0;
		$params['Ndate'] = null;
		// 数据记录进redis
		$redis = \package\Redis::instance();
		$redis->zadd($this->zsetKey,$lastId,$lastId);
		$redis->hMSet($this->hashKey.':'.$lastId,$params);
		json_success(['board_id'=>$lastId]);
	}
	/**
	 * 重载
	 */
	public function __call($method,$args){
		throw new \Exception("请求的方法{$method}不存在");
	}
}