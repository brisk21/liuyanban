<?php
session_start();
include ('config.php');
include ('input.class.php');
include ('page.class.php');
$input = new Input();

$pageTotal = 8;
$p = $input->get('p');
if($p < 1){
	$p = 1;
}
//数据偏移量
$offset = ($p-1) * $pageTotal;
$countSql = "SELECT COUNT(*) as total FROM lyb where state=0 ";
$result = $mysqli->query($countSql);
$row = $result->fetch_array();
//获取数据总量
$total = $row['total'];
$page = new page($total,$pageTotal,$p);
$sql = "SELECT * FROM lyb where state=0 order by id desc limit $offset,$pageTotal ";
$results = $mysqli->query($sql);

$rows = array();
while($row = $results->fetch_array()){
	$rows[] = $row;
}

//var_dump($rows);
$id = $input->session('sid');
if($id == null){
	header('location:login.php');
}

$aid = $input ->get('aid');
if($aid){
	$sql = "UPDATE lyb SET state=1 WHERE id={$aid}";
	$res = $mysqli ->query($sql);
	if($res){
		
		header("location:check.php");
	}
}

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="留言板，php留言板，php留言">
	<title>留言板</title>
	<!--<link rel="stylesheet" type="text/css" href="http://weibingsheng.cn/blog/public/bootstrap/css/bootstrap.css"/>-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>	
	<style type="text/css">
		body{background:rgba(113, 34, 112, 0.11)}.container{margin-top: 5px;}.input-message input{padding:10px;margin:5px;margin-left:0}.panel{margin-top:10px}#checkCode{font-family:Arial;font-style:italic;color:#00f;background:rgba(180,199,180,.76);font-size:30px;border:0;letter-spacing:3px;font-weight:bolder;cursor:pointer;width:100px;height:30px;text-align:center;vertical-align:middle}.btn{margin:0}.info{font-size:10px;overflow:hidden}.reply{background: rgba(230, 226, 235, 0.35);font-size:12px;}.choses span{margin-left:10px;}
	</style>
</head>
<body>
	<div class="container">
		<div class="row show">
			<div class="col-xs-12">
				<?php foreach($rows as $value):?>
				<div class="panel panel-info">
					<div class="panel-heading">
						<span>标题：</span>	<?php echo $value['user'];?>
						<span style="margin-left:30px;color:blue;">留言IP：</span>	<?php echo $value['ipadress'];?>
						<div class="pull-right"><span class="glyphicon glyphicon-remove"></span>
						<a onclick="return confirm('确定删除该留言吗？')"  href="delete.php?id=<?php echo $value['id'];?>">删除</a></div>
					</div>
					<div class="panel-body">
						<?php  echo $value['content']; ?>						
						<div class="pull-right"><span class="glyphicon glyphicon-ok"></span>
						<a  href="check.php?aid=<?php echo $value['id'];?>">通过</a></div>
						
					</div>				
				</div>			
				<?php endforeach;?>
			</div>
			<div class="pagination text-center">
				<li><?php echo $page->showpage();?></li>
			</div>
		</div>
		<a href="index.php" role="button" class="btn btn-success">返回</a>
	</div>
</body>
</html>