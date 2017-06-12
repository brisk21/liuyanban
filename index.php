<?php
session_start();
include ('config.php');
include ('input.class.php');
include ('page.class.php');
/*******显示留言内容*********/
$input =new Input();
/*************显示分页效果********************/
//每页显示条数
$pageTotal = 8;
$p = $input->get('p');
if($p < 1){
	$p = 1;
}
//数据偏移量
$offset = ($p-1) * $pageTotal;
//获取数据总量
$countSql = "SELECT COUNT(*) as total FROM lyb where state=1 ";
$result = $mysqli->query($countSql);
$row = $result->fetch_array();
//获取数据总量
$total = $row['total'];
$page = new page($total,$pageTotal,$p);
$sql = "SELECT * FROM lyb where state=1 and chose=1 order by id desc limit $offset,$pageTotal";
//执行语句，并将结果赋值到$mysqli_result这个变量
$mysqli_result = $mysqli->query($sql);
//声明一个数组变量
$rows = array();
while($row = $mysqli_result->fetch_array()){
	$rows[] = $row;
}
/***********admin***************/
$sid =(int) $input->session('sid');
if($input->session('sid')){
	$sql = "SELECT * FROM lybadmin WHERE  sid='{$sid}'";
	$result = $mysqli->query($sql);
	$user = $result->fetch_array(MYSQLI_ASSOC);	
}

?>
<!doctype html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="留言板，php留言板，php留言">
	<title>留言板</title>
	<!--<link rel="stylesheet" type="text/css" href="http://weibingsheng.cn/blog/public/bootstrap/css/bootstrap.css"/>-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>	
	<style type="text/css">
		body{background:rgba(113, 34, 112, 0.11)}.container{margin-top: 5px;}.input-message input{padding:10px;margin:5px;margin-left:0}.panel{margin-top:10px}#checkCode{font-family:Arial;font-style:italic;color:#00f;background:rgba(180,199,180,.76);font-size:30px;border:0;letter-spacing:3px;font-weight:bolder;cursor:pointer;width:100px;height:30px;text-align:center;vertical-align:middle}.btn{margin:0}.info{font-size:10px;overflow:hidden}.reply{background: rgba(230, 226, 235, 0.35);font-size:12px;}.choses span{margin-left:10px;}.content{word-wrap: break-word;}
	</style>
</head>
<body onload="createCode();">
	<div class="container" id="main">
		<div class="row  input-message">		
			<div class="form-group col-xs-12">
				<form action="save.php" method="post" id="Form">
					<textarea name="content" class="form-control" id="content" placeholder="请输入留言内容" rows="5"></textarea>
					<input type="text" name="user"class="form-control" id="username" placeholder="请输入留言标题" />
					<input type="text" name="Emails"class="form-control" id="Emails" onblur="checkmail()" placeholder="邮箱地址(选填)" />
					<input type="text" id="inputCode" onblur="validateCode();" placeholder="请输入验证码" />
					<spane id="checkCode" onclick="createCode();">验证码</spane>
					<div class="input-group choses">
						<span><input type="radio" calss="chose" name="showhidden" checked="true" value="1"/>显示到留言区<span>
						<span><input type="radio" class="chose" name="showhidden" value="0"  id="choseHidden" />不显示到留言区</span>
					</div>					
					<input type="submit"  class="btn  btn-info pull-right" value="发表" onfocus="checkInput();" />							
				</form>
				
			</div>			
		</div>
		<div class="row show">
			<div class="col-xs-12">
				<?php 				
				
				foreach($rows as $value){if(!$value['content'] == '' && $value['chose'] == 1 || $input -> session('sid')) :?>
				<div class="panel panel-info">
					<div class="panel-heading">
						<?php echo $value['user'];?>
					</div>
					<div class="panel-body content">
						<?php if($value['email'] == "lanlan@brisk.com"):?>
						<audio controls="controls" class="form-control">
						  <source src="/lyb2<?php echo $value['content'];?> " type="audio/wav">
						  <source src="/lyb2<?php echo $value['content'];?> "type="audio/mpeg">
							您的浏览器不支持H5音频输出。
						</audio>					
						<?php endif;?>
						<?php if($value['email'] !== "lanlan@brisk.com") echo $value['content']; ?>
						<?php if($input->session('sid')) :?>
						<span class="glyphicon glyphicon-remove"></span>  <a onclick="return confirm('确定删除该留言吗？')"  href="delete.php?id=<?php echo $value['id'];?>">删除</a>
						<form action="reply.php?id=<?php echo $value['id'];?>" method="post" >
							<input name="replies" id="reply"  ></input>							
							<input type="submit" class="btn btn-info" value="回复" />
						</form>	
						<?php endif;?>		
						
						<?php if(!$value['reply'] == ''){?>
						<div class="well-sm  reply">	
						<?php	echo 'Reply:'.$value['reply'];?>
						</div> 
						<?php };?>
							
					</div>
					<div class="panel-footer info">
						<span class="pull-left">标题:<?php echo $value['user'];?></span>
						<span class="pull-right"><?php echo  date('Y-m-d H:i',$value['intime']);?></span>
					</div>
					
				</div>			
				<?php endif;}; ?>
				
			</div>
		</div>
		<div class="pagination text-center">
			<li><?php echo $page->showpage();?></li>
		</div>
		<div class="well text-center">
		<?php if($input->session('sid')){?>
			<div><a href="check.php">审核留言</a></div>
			<p>兰兰</p>
			欢迎：<?php $admin = 'login'; echo $user['suser']; ?>,<a href="login.php?action=loginout">退出登录</a>
			
		<?php }else{ ?>
			<input type="button"  value="管理员登录" onclick="login();" />
		<?php } ?>			
			<label for="record" style="margin-left:15px"></label>
			<input type="button"  value="发送语音" onclick="record();" />
		</div>
		
	</div>
	<script src="js/main.js"></script>
	<script src="js/code.js"></script>
	<script type="text/javascript">
	function login(){		
		window.location.href="login.php";
	}	
	function record(){
		window.location.href="record.html";
	}
	function checkmail(){
		var mailCheck = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;	
		var oemail = document.getElementById('Emails').value;
		if(!mailCheck.test(oemail)){		
			return alert(oemail+"此邮箱格式不对哦，请确认重新输入");
		}
	}
	</script>
</body>
</html>