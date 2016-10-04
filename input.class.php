<?php
class input{
	function post($key){
		if(isset($_POST[$key])){
			$value = $_POST[$key];
		}else{
			$value = NULL;
		}				
		$execValue = strip_tags($value);
		return $execValue;
	}	
	function get($key){
		if(isset($_GET[$key])){
			$value = $_GET[$key];
		}else{
			$value = NULL;
		}		
		$execValue = strip_tags($value);
		return $execValue;
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

