<?php
session_start();
include('config.php');
include('input.class.php');

$input = new Input();
$id = $input->get('id');
$sql = "DELETE FROM lyb WHERE id='{$id}'";
$is = $mysqli->query($sql);
if($is == true){
	header('location:check.php');
}else{
	echo "删除失败，请联系代码维护员";
}
?>