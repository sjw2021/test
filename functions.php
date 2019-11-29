<?php 
if (!function_exists('config')) {
	function config($params = ''){
		$config = require ROOT_PATH.'/config.php';
		if (!$config) {
			return null;
		}
		if (!$params) {
			return $config;
		}
		if (strpos($params, '.')) {
			$tempArr = explode('.', $params);
			$temp = $config;
			for ($i=0; $i < count($tempArr); $i++) { 
				if (array_key_exists($tempArr[$i], $temp)) {
					$temp = $temp[$tempArr[$i]];
				}
			}
			return $temp;
		}
		if (array_key_exists($params, $config)) {
			return $config[$params];
		}
		return $config;
	}
}
// 返回json数据
if (!function_exists('json')) {
	function json($list = array(),$msg= ''){
		$data = [
			'code' => 0,
			'msg' => $msg,
			'data' => $list
		];
		echo json_encode($data,JSON_UNESCAPED_UNICODE);
		die();
	}
}
// 返回json错误数据
if (!function_exists('json_error')) {
	function json_error($msg= '',$list=array()){
		json($list,$msg);
	}
}
