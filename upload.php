<?php
include ('config.php');
include ('input.class.php');
include('upload.class.php');
$input = new Input();
$upload = new upload();
$miling = $input ->post('miling');
//验证密令
if($miling !== '921015'){	
	header('location:record.html');
	exit;
}
$file = $input ->post('file');

$result = $upload->up('file');

$arr = [];
if($result['error'] ==0){
	$arr['success'] = true;
	$arr['size'] = $result['size'];	
	$arr['type'] = $result['type'];	
	$arr['file_path'] = $result['full_filename'];	
}else{
	$arr['msg'] = '错误代码：'.$result['error'];
	exit;
}
$path =$arr['file_path']; 
//echo json_encode($arr);
 
if($arr['type'] =="mp3" || $arr['type'] =="wav"){
	$t = time();
	$sql = "INSERT INTO lyb (`user`,`content`,`intime`,`chose`,`state`,`email`) value ('语音留言','{$path}','{$t}',1,0,'lanlan@brisk.com')";				
	$is = $mysqli -> query($sql);
	if($is == false){
	 echo "上传失败";
	}
	header('location:check.php');
}else{
	echo "The file is unable to upload ,please choose the type of 'mp3' or 'mp4' audio files.";
	header('location:record.html');
}
?>
