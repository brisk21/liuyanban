<?php
include ('config.php');
include ('input.class.php');
$input = new input();


include ('db.class.php');
$db = new db($dbhost,$dbuser,$dbpasswd,$dbname);
include ('page.class.php');

$uid =(int) $input->cookie('id');
if($uid > 0){
	$usql = "SELECT * FROM adminuser WHERE id='$uid'";
	$result = $db->query($usql);
	$user = $result->fetch_array();
	
}
//删除留言
$action = $input->get('action');
if($action == 'delete' && $uid > 0){
	$id = (int)$input->get('id');
	if($id < 1){
		echo "请选择要删除的留言ID";
		exit;
	}
	$sql = "DELETE FROM messages WHERE id='$id'";
	$result = $db->query($sql);
	if(result){
		header("location:index.php");
		exit;
	}else{
		echo "删除失败，请联系高级管理员修复。";
		exit;
	}
	
}



//当前页数
$p = $input->get('p');
if($p < 1){
	$p = 1;
}
$offset = ($p-1) * $pageTotal;//数据偏移量


//获取数据总量
$countSql = "SELECT COUNT(*) as total FROM messages";
$result = $db->query($countSql);
$row = $result->fetch_array();
$total = $row['total'];//获取数据总量

/*********************************/
$page = new page($total,$pageTotal,$p);

//编写查询的SQL语句，获取所有数据
$sql = "SELECT * FROM messages order by id desc limit $offset,$pageTotal";
//执行语句，并将结果赋值到$mysqli_result这个变量
$mysqli_result = $db->query($sql);



$rows = array();//声明一个数组变量
while($row = $mysqli_result->fetch_array()){
	$rows[] = $row;
}
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>留言板</title>
	<link rel="stylesheet" type="text/css" href="lyb.css" media="all" />
</head>
<body>
	<div id="main">
		<div class="write">
			<form action="savemessage.php" method="post">
				<textarea name="content" id="liuyan" class="liuyan" cols="30" rows="10">输入留言内容</textarea><br/>
				<input type="text" class="user" name="user" value="请输入用户名" />
				<input class="btn" type="submit" value="提交留言" />
			</form>
		</div>
			<div class="messages">
			<?php
			//while($row = $mysqli_result->fetch_array()){
			  foreach($rows as $row){
				  $createtime = $row['createtime'];
				  $datetime = date("Y-m-d H:i:s",$createtime);
			?>
				<div class="message">
					<div class="info">
						<span class="user"><?php echo $row['uname'];?>(<?php echo $row['id']?>)</span>
						<span class="delete">
						<?php
						if($uid > 0){
						?>
							<a href="index.php?action=delete&id=<?php echo $row['id'];?>">删除</a>
						<?php
						}
						?>
						</span>
						<span class="time"><?php echo  $datetime; ?></span>
						
					</div>
					<div class="content">
						<?php echo $row['contents'];?>
					</div>
				</div>
			<?php
				}
			?>
		
		</div>
		<div class="adminer">
		<?php 
		if($uid > 0){
		?>
			欢迎：<?php echo $user['user']; ?>,<a href="login.php?action=loginout">退出登录</a>
		<?php
		}else{
		?>
			<a href="login.php">管理员登陆</a>
		<?php
		}
		?>
		
		
		</div>
		<div class="pages">
			 <div class="page">
			 <?php
			 echo $page->showPage();exit;
			 ?>		 
			 </div>			
		</div>		
	</div>
</body>
</html>