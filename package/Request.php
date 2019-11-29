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
		return strtolower($this->server['REQUEST_URI']);
	}
	/**
	 * 获取get参数
	 */
	public function get($param = ''){
		if ($_GET && !$param) {
			return $_GET;
		}
		if ($_GET && array_key_exists($param, $_GET)) {
			return $_GET[$param];
		}
		return null;
	}
	/**
	 * 获取post参数
	 */
	public function post($param = ''){
		if ($_POST && !$param) {
			return $_POST;
		}
		if ($_POST && array_key_exists($param, $_POST)) {
			return $_POST[$param];
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