<?php
include ('config.php');
include ('input.class.php');
$input = new input();
		
include ('db.class.php');
$db = new db($dbhost,$dbuser,$dbpasswd,$dbname);

$action = $input->get('action');
if($action=='loginout'){
	setcookie('id',0,0);
	header('location:index.php');
	exit;
}
//判断是否提交了表单
$submit = $input->post('submit');
if($submit == ''){
	//客户端的账号密码
	$user = $input->post('username');	
	//用MD5加密明文密码
	$passwd = md5( $input->post('password'));
	
	$sql = "SELECT * FROM adminuser WHERE user='$user' and password='$passwd' ";	
	$result = $db->query($sql);
	if($result->num_rows > 0){		
		$row = $result->fetch_array();
		setcookie("id",$row['id'],time()+60*60*24);		
		header("location:index.php");
		exit;
	}else{	
		
	}	
}

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>管理员登录</title>
	<link rel="stylesheet" href="../public/Bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../public/login.css" media="all" />
	<script src="../public/Bootstrap/js/jquery.min.js"></script>
	<script src="../public/Bootstrap/js/bootstrap.min.js"></script>
</head>


<body>
	<div class="container-fluid">
		<div class="col-md-4"></div>
		<div class="col-md-4">
		  <div class="panel panel-success">
			  <div class="panel-heading">管理员登陆</div>
			  <div class="panel-body">
				<form action="./login.php" method="post">
					<div class="form-group">
						<label for="username">用户名：</label>
						<input type="text" class="form-control" name="username" id="exampleInputEmail1" placeholder="请输入用户名">
					</div>
					<div class="form-group">
						<label for="Password1">密码：</label>
						<input type="password" class="form-control" name='password' id="exampleInputPassword1" placeholder="请输入密码">
					</div>			  
						<button type="submit" class="btn btn-default">登陆</button>
				</form>
				<p class="goback"><a href="index.php">返回留言板</a></p>
			  </div>
		 </div>			
		</div>
		<div class="col-md-4"></div>
		
	</div>
</body>
</html>