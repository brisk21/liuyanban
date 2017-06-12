<?php 
date_default_timezone_set('Asia/Shanghai');//时区
$mysqli = new mysqli('127.0.0.1','root','','php3');
if($mysqli ->connect_errno > 0){
	echo "数据库链接失败，错误信息为：".mysqli_connect_error();
	exit;
}
$mysqli -> query("SET NAMES UTF8");//设置编码格式，防止在mysql中显示乱码
?>