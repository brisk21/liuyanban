<?php
//用来保存数据
include ('config.php');
include ('db.class.php');
include ('input.class.php');
$input = new input();
$Content =$input->post("content");
$User = $input->post("user");
$createtime = time();//获取 服务器时间
if($Content=="" or $User==""){
	echo "抱歉！留言内容和用户名不能为空，请返回输入。";	
	exit;
}
$db = new db($dbhost,$dbuser,$dbpasswd,$dbname);
$sql = "INSERT INTO `messages`(`uname`, `createtime`, `contents`) VALUES ('$User','$createtime','$Content')";
//echo $sql;exit;//检查sql是否插入正常
$boolean = $db->query($sql);
//var_dump($boolean);
if($boolean){
	echo "留言成功，正在返回……";	
	header("location:index.php");
}
?>