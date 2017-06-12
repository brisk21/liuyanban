<?php
class page{
	public $maxPage;	
	function __construct($dataTotal,$pageTotal,$p){
		$this->maxPage = ceil($dataTotal / $pageTotal);
		$this->p = $p;
	}
	function showPage(){	
		$html ="";//用于保存生成的HTML分页
		//获取网址
		$url0=$_SERVER["REQUEST_URI"]; 
		//获取文件名称（不包括后缀）
		$url= pathinfo($url0,PATHINFO_FILENAME); 
		
		for($i=1; $i <= $this->maxPage; $i++){
			if($this ->p == $i){
				$html.= "<span style='color:#f802df;'>[$i]</span>";
			}else{
				//$html.="<a href='index.php?p=$i'>[$i]</a>";
				$html.="<a href='$url.php?p=$i'>[$i]</a>";					
			}			
		}
		return $html;
	}
}
