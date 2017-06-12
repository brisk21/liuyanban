<?php
use Snipworks\SMTP\Email;
include('./public/email.php');
header("Content-type:text/html;charset=utf-8");
include ('input.class.php');
include ('ip.class.php');
include ('config.php');

$ip = new Getip();
$ipadress = $ip ->getIP();
$ipsearch = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=85.192.162.173');
//$ipsearch = file_get_contents(‘http://ip.taobao.com/service/getIpInfo.php?ip='.$ipadress);
	//利用淘宝的IP库进行查询
$result = json_decode(trim($ipsearch), true);

$language = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
$zh = strstr($language, 'zh');
if((!empty($result['data']['country_id']) && $result['data']['country_id'] !== 'CN') || !$zh)
{
	$alert = "<script type=\"text/javascript\">alert('Sorry,your message did not send success.I just checked your message have the ADs or other unable contents.');</script>";
	echo $alert;
	header("refresh:1;url=index.php");//1s跳转	
	exit;
}


$input = new Input();
//利用htmlspecialchars()对html代码转义
$content = htmlspecialchars( $input -> post('content'));
$user = htmlspecialchars( $input -> post('user'));
$Emails = htmlspecialchars( $input -> post('Emails'));
$showhidden = $input -> post('showhidden');

if(trim($content) == "" || trim($user) == ""){
	echo "用户名和密码不能同时为空，请返回重新输入内容。";
	exit;
}

$t = time();
$sql = "INSERT INTO lyb (`user`,`content`,`intime`,`email`,`chose`,`ipadress`,`state`) value ('{$user}','{$content}','{$t}','{$Emails}','{$showhidden}','{$ipadress}',0)";				
$is = $mysqli -> query($sql);
if($is == false){
	echo "数据插入失败";
}
//var_dump($sql);
if(trim($Emails) !== '' && $is == true || $showhidden == 0){
	/**********************send mail start**************************************/	
	$subject = $_POST['user'];	
	$email = $_POST['Emails'];	
	$content = $_POST['content'];
	$mail = new Email('smtp.163.com', 25);
	$mail->setProtocol(Email::TLS); //SSL 或者 TLS 都可以. 或者你有其他的协议也可以 
	$mail->setLogin('brisklan@163.com', 'wbs1076963452');//第二个参数为密码，必须是客户端授权的密码。
	$mail->addTo('1076963452@qq.com', ''); //接收邮件的地址和姓名，姓名可选
	$mail->setFrom('brisklan@163.com','网站留言板(PC)'); //发送邮件的邮箱，名字可选
	$mail->setSubject($user);
	$mail->setMessage($content.'====>>留言者邮件地址：'.$Emails."IP地址：".$ipadress, false); //参数2设置为false时保留格式，设置为true时以html文档方式发送，排版乱套。
	$x=$mail->send();
	/***********************send mail end************************************/
	
	//header('refresh:5;rul=index.php'); 
	echo "<script> alert('留言已提交，等待审核结果！');parent.location.href='index.php'; </script>";
	exit;
}elseif($is == true){
	echo "<script> alert('留言已提交，等待审核结果！');parent.location.href='index.php'; </script>";
	//header('location:index.php');
	exit;
}else{
	echo "留言失败!请到http://weibingsheng.cn/mail发送邮件给管理员weibingsheng@yahoo.com";
}

?>