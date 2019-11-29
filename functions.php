<?php 
if (!function_exists('config')) {
	function config($params = ''){
		$config = require_once ROOT_PATH.'/config.php';
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