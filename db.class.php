<?php
/*
	数据库操作类
	提供常用的数据库相关操作
	使用方法：
		$db = new db(数据库IP地址，账号，密码，数据库名称)；
		$db->query($sql) 负责执行一次SQL查询
		$db->close() 手动关闭数据库连接
*/
class db{
	public $host;
	public $user;
	public $passwd;
	public $dbname;
	public $dblink;
	//构造函数，用来传入连接数据库的参数
	function __construct($host,$user,$passwd,$dbname){
		$this->host = $host;
		$this->user = $user;
		$this->passwd = $passwd;
		$this->dbname = $dbname;
		$this->connect();
		$this->dblink->query("set names UTF8");
	}
	//连接数据库并创建一个类属性:$this->dblink
	function connect(){
		$mysqli = new mysqli($this->host,$this->user,$this->passwd,$this->dbname);		
		if($mysqli->connect_error<>0){
			echo "数据库连接失败，错误信息".$mysqli->connect_error;
			exit;
		}
		$this->dblink =$mysqli;
	}
	function query($sql,$resultmode = MYSQLI_STORE_RESULT){
		return $this->dblink->query($sql);
	}
	//手动关数据库，不设置则网页自动关闭
	function close(){
		return $this->dblink->close();
	}
}
?>