<?php 
define('ROOT_PATH', __DIR__);
define('PACKAGE_DIR', ROOT_PATH.'/package');
require_once PACKAGE_DIR.'/Autoload.php';
require_once ROOT_PATH.'/functions.php';
echo "<pre>";
// print_r(get_declared_classes());
// // // new mysqli();
// // new PDO();
// // new mysqli('localhost','root','123456','test');
// exit;
new Autoload();
try {
	// $db =  \package\Db::instance();
	// $sql = "SELECT * FROM board ORDER BY Idate DESC";
	// $result = $db->query($sql);
	// var_dump($result);
	$redis = \package\Redis::instance();
	$redis->zadd();
} catch (\Exception $e) {
	var_dump($e->getMessage());
}