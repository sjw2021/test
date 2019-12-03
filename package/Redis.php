<?php 
namespace package;
/**
 * redis
 */
class Redis{
	// 单例
	protected static $_redis;
	// 配置
	protected $config = [
		'host' => 'localhost',
		'port' => 6379,
		'password' => '',
		'database' => 1,
	];
	// redis
	protected $redis;
	// 连接
	protected $connect;
	public function __construct($config = array()){
		$this->config = array_merge($this->config,config('redis'),$config);
		$this->redis = new \Redis();
		$this->connect();
		$this->select();
	}
	/**
	 * 实例
	 */
	public static function instance($config = array()){
		if (empty(self::$_redis)) {
			self::$_redis = new self($config);
		}
		return self::$_redis;
	}
	/**
	 * 连接
	 */
	public function connect(){
		$this->redis->connect($this->config['host'], $this->config['port']);
		$this->redis->auth($this->config['password']);
	}
	/**
	 * 选择库
	 */
	public function select(){
		$this->redis->select($this->config['database']);
	}
	/**
	 * 获取redis实例
	 */
	public function getObj(){
		return $this->redis;
	}
	/**
	 * get
	 */
	public function get($key){
		return $this->redis->get($key);
	}
	/**
	 * set
	 */
	public function set($key,$value,$second=0){
		if ($second > 0) {
			return $this->redis->set($key,$second,$value);
		}
		return $this->redis->set($key,$value);
	}
	/**
	 * 
	 */
	public function hMSet($key,$params){
		return $this->redis->hmset($key,$params);
	}
	/**
	 * 获取存储在哈希表中指定字段的值。
	 */
	public function hGetAll($key){
		return $this->redis->hgetall($key);
	}
	/**
	 * 向有序集合添加一个或多个成员，或者更新已存在成员的分数
	 */
	public function zadd($key,$score,$member){
		return $this->redis->zadd($key,$score,$member);
	}
	/*
	 * 获取有序集合的成员数
	 */
	public function zcard($key){
		return $this->redis->zcard($key);
	}
	/**
	 * 返回有序集中指定分数区间内的成员，分数从高到低排序
	 */
	public function zrevrangebyscore($key,$max,$min,$withScores = false){
		if ($withScores === fasle) {
			return $this->redis->zrevrangebyscore($key,$max,$min);
		}
		return $this->redis->zrevrangebyscore($key,$max,$min,$withScores);
	}
	public function __call($method,$args){
		return $this->redis->{$method}($args);
	}
}