<?php
include ('input.class.php');
include ('config.php');
session_start();

$input = new Input();
$action = $input->get('action');
if( $action=='loginout' ){
	session_unset();
	header('location:index.php');
	exit;
}

if( $input->get('action')=='check'){
	$auser = $input->post('auser');
	$apassword = md5($input->post('apassword'));
	if(trim($auser)=='' || trim($apassword)==''){
		echo "用户名和密码不能为空。";
		exit;
	}	
	$sql = "SELECT * FROM lybadmin WHERE suser='{$auser}' and spassword='{$apassword}'";
	$result = $mysqli->query($sql);
	$user = $result->fetch_array(MYSQLI_ASSOC);
	if($user == true){		
		$_SESSION['sid'] = $user['sid'];
		header('location:check.php');
		exit;
	}else{
		echo "用户名或密码错误";
		exit;
	}
}
?>
 <!DOCTYPE HTML>
 <html lang="en-US">
 <head>
 	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>管理员登录</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>	
	<style type="text/css">
	body{background:rgba(113, 34, 112, 0.11)}.btn{margin-top:10px;}	
	</style>
 </head>
 <body>
 	<div class="container">
		<div class="row col-md-4"></div>
		<div class="row col-md-4">
			<div class="form-group">
				<form action="login.php?action=check" method='post'>
					<label >用户</label><input type="text" name='auser' class="form-control" placeholder="请输入管理员用户名" />
					<label >密码</label><input type="password" class="form-control" name='apassword' placeholder="请输入管理员密码" />
					<input type="submit" class="btn btn-info" value="登录" />
				</form>
			</div>
		</div>
		<div class="row col-md-4"></div>
	</div>
 </body>
 </html>