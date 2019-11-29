<?php
/**
 * 自动加载类
 */
class Autoload{
	public function __construct(){
		$this->init();
	}
	/**
	 * 初始化
	 */
	public function init(){
		spl_autoload_register(['self','register']);
	}
	/**
	 * 注册
	 */
	public static function register($class){
		// var_dump($class);
		$class = str_replace('\\', '/', $class);
		if (substr($class, 0,1) === '/') {
			$file = ROOT_PATH.$class.'.php';
		}else{
			$file = ROOT_PATH.'/'.$class.'.php';
		}
		if (!file_exists($file)) {
			die("类{$class}不存在");
		}
		require_once $file;
	}
}