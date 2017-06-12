<?php
use Snipworks\SMTP\Email;
include('email.php');
header("Content-type:text/html;charset=utf-8");
$sendTo = $_POST['sendto'];
//$toNme = $_POST['toname'];
//$sendFrom = $_POST['sendfrom'];

$subject = $_POST['subject'];
$sendName = $_POST['sendname'];
$content = $_POST['content'];


$mail = new Email('smtp.163.com', 25);
$mail->setProtocol(Email::TLS); //SSL 或者 TLS 都可以. 或者你有其他的协议也可以 
$mail->setLogin('brisklan@163.com', 'wbs1076963452');//第二个参数为密码，必须是客户端授权的密码。
$mail->addTo($sendTo, ''); //接收邮件的地址和姓名，姓名可选
$mail->setFrom('brisklan@163.com',$sendName); //发送邮件的邮箱，名字可选
$mail->setSubject($subject);
$mail->setMessage($content, false); //参数2设置为false时保留格式，设置为true时以html文档方式发送，排版乱套。

$x=$mail->send();

?>

<?php if($x == true):?>
<script type="text/javascript">	
		setTimeout(function(){
			alert("发送成功");
			window.history.back();		
		},300);				
</script>
<?php endif;?>
<?php if($x == false):?>
<script type="text/javascript">	
		setTimeout(function(){
			alert("发送失败，请联系管理员QQ：1076963452");
			window.history.back();		
		},1000);				
</script>
<?php endif;?>

