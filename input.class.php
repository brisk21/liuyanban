<?php
class Input{
	function post($name){
		if( array_key_exists($name,$_POST) == true){
			$value = $_POST[$name];
			return $value;
		}else{
			return null;
		}
	}
	function get($name){
		if( array_key_exists($name,$_GET) == true){
			$value = $_GET[$name];
			return $value;
		}else{
			return null;
		}
	}
	function session($name){
		if( array_key_exists($name,$_SESSION) == true){
			$value = $_SESSION[$name];
			return $value;
		}else{
			return null;
		}
	}
	function cookie($key){
		if(isset($_COOKIE[$key])){
			$value = $_COOKIE[$key];
		}else{
			$value = NULL;
		}
		$execValue = strip_tags($value);
		return $execValue;
	}
} 

?>