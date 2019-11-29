<?php 
namespace package;
/**
 * redis
 */
class Redis{
	// 单例
	protected $_redis;
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
		$this->connect = $this->redis->connect($this->config['host'], $this->config['port']);
	}
	/**
	 * 获取redis实例
	 */
	public function getObj(){
		return $this->redis;
	}
}