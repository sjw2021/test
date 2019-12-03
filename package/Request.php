<?php 
namespace package;
/**
 * 请求类
 */
class Request{
	// 服务信息
	protected $server;
	public function __construct(){
		$this->server = $_SERVER;
	}
	/**
	 * 方法名
	 */
	public function method(){
		return strtolower($this->server['REQUEST_METHOD']);
	}
	/**
	 * 请求的uri
	 */
	public function uri(){
		$uri = strtolower($this->server['REQUEST_URI']);
		if (strpos($uri, '/index.php') === 0) {
			$uri = substr($uri, 0,10);
		}
		return ltrim($uri,'/');
	}
	/**
	 * 获取get参数
	 */
	public function get($param = '',$default = null){
		if (!$param) {
			return $_GET;
		}
		if (array_key_exists($param, $_GET)) {
			return $_GET[$param];
		}else{
			return $default;
		}
		return null;
	}
	/**
	 * 获取post参数
	 */
	public function post($param = '',$default = null){
		if (!$param) {
			return $_POST;
		}
		if (array_key_exists($param, $_POST)) {
			return $_POST[$param];
		}else{
			return $default;
		}
		return null;
	}
	/**
	 * 获取ip
	 */
	public function ip(){
		return $_SERVER['REMOTE_ADDR'];
	}
	/**
	 * 重载
	 */
	public function __call($method,$args){
		throw new \Exception("方法{$method}不存在");
	}
	/**
	 * 静态重载
	 */
	public static function __callStatic($method,$args){
		var_dump($method,$args);exit;
		return (new self())->$method($args);
	}
}