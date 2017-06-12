<?php
session_start();
include('config.php');
include('input.class.php');
$input = new Input();
$id = $input->get('id');
$replies = $input -> post('replies');
var_dump($replies);
$sql = "UPDATE lyb SET reply='{$replies}' WHERE id = '{$id}'";
var_dump($sql);
$is = $mysqli->query($sql);
if($is == true){
	header('location:index.php');
}else{
	echo "回复失败";
}
?>
