<?php 
define('ROOT_PATH', __DIR__);
define('PACKAGE_DIR', ROOT_PATH.'/package');
require PACKAGE_DIR.'/Autoload.php';
require ROOT_PATH.'/functions.php';
echo "<pre>";
new Autoload();
try {
	new \app\Index();
} catch (\Exception $e) {
	json_error($e->getMessage());
}