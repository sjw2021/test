<?php 
error_reporting(E_ALL);
define('ROOT_PATH', __DIR__);
define('PACKAGE_DIR', ROOT_PATH.'/package');
require PACKAGE_DIR.'/Autoload.php';
require ROOT_PATH.'/functions.php';
// 加载类
new Autoload();
$lockFile = ROOT_PATH.'/db.lock';
if (!file_exists($lockFile)) {
	$db = \package\Db::instance();
	$res = $db->query(file_get_contents(ROOT_PATH.'/db.sql'));
	if ($res) {
		file_put_contents($lockFile, '1');
	}else{
		json_error('数据库写入出错');
	}
}
try {
	new \app\Index();
} catch (\Exception $e) {
	json_error($e->getMessage());
}