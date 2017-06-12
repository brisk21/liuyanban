<?php 
define('APP_PATH',dirname(__FILE__));
class upload{
	function getFullFileName($filename){
		return $filepath = '/Uploads/files/'.$filename;		
	}
	function up($form_name){
		$file = $_FILES[$form_name];		
		$result = array();
		$result['error'] = 0;		
		//处理错误
		if( $file['error'] > 0 ){
			$result['error'] =$file['error'];
			return $result;
		}
		//获取文件后缀,并转为小写
		$ext = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
		//var_dump($ext);
		if($ext =="mp3" || $ext == "wav"){
			//拼接生成文件名
			$filename = date('YmdHms',microtime(true)).".".$ext;
			//文件大小
			$result['size'] = $file['size'];
			//type
			$result['type'] = $ext;
			//文件名
			$result['filename'] = $filename;
			//网站路径
			$result['full_filename'] = $this->getFullFileName($filename);
			//硬盘路径
			$result['disk_filename'] = APP_PATH.$result['full_filename'];
			
			//将文件移动到指定目录
			$is = move_uploaded_file($file['tmp_name'],$result['disk_filename']);
			
			if(!$is){
				$result['error'] = -1;
			}
			return $result;
		}else{
			echo "The file is unable to upload ,please choose the type of 'mp3' or 'mp4' audio files.";
			header("refresh:3;url=record.html");
		}
		
	}
}
?>