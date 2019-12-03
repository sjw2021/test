<?php 
namespace package;
/**
 * 数据库类
 */
class Db{
	/**
	 * 实例
	 */
	protected static $_db;
	/**
	 * 配置文件
	 */
	protected $config = [
		'host' => '',
		'port' => '',
		'user' => '',
		'password' => '',
		'database' => '',
	];
	protected $connect;
	public function __construct($config = array()){
		$this->config = array_merge($this->config,config('database'),$config);
		$this->connect();
	}
	/**
	 * 单例
	 */
	public static function instance($config = array()){
		if (empty(self::$_db)) {
			self::$_db = new self($config);
		}
		return self::$_db;
	}
	/**
	 * 数据库连接
	 */
	protected function connect(){
		$pdoDsn = $this->config['host'].':'.$this->config['port'];
		// PDO连接
		// $pdoDsn = 'mysql:host='.$this->config['host'].';dbname='.$this->config['database'];
		// $this->connect = new \PDO($pdoDsn,$this->config['user'],$this->config['password']);
		// mysqli连接
		$this->connect = new \mysqli($pdoDsn,$this->config['user'],$this->config['password'],$this->config['database']);
		if ($this->connect->connect_error) {
			throw new \Exception('数据库连接失败:'.$this->connect->connect_error);
		}
		return $this->connect;
	}
	/**
	 * 数据库查询
	 */
	public function query($sql){
		$result = $this->connect->query($sql);
		$data = [];
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		}
		return $data;
	}
	/**
	 * 数据库操作
	 */
	public function execute($sql){
		if ($this->connect->query($sql) !== TRUE) {
			throw new \Exception('数据库操作错误:'.$this->connect->error.',sql为:'.$sql);
		}
	}
	/**
	 * 插入并获取插入的id
	 */
	public function insertGetLastId($sql){
		$this->execute($sql);
		$data = $this->query('select last_insert_id() as last_insert_id');
		if ($data) {
			return $data[0]['last_insert_id'];
		}
		return null;
	}
	/**
	 * 数据库连接释放
	 */
	public function close(){
		$this->connect->close();
	}
	/**
	 * 摧毁
	 */
	public function __destruct(){
		$this->close();
	}
}