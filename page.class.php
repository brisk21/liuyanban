<?php

class page{
	public $maxPage;
	
	function __construct($dataTotal,$pageTotal,$p){
		$this->maxPage = ceil($dataTotal / $pageTotal);
		$this->p = $p;
	}
	function showPage(){	
		$html ="";//用于保存生成的HTML分页
		for($i=1; $i <= $this->maxPage; $i++){
			if($this ->p == $i){
				$html.= "<span style='color:yellow;'>[$i]</span>";
			}else{
				$html.="<a href='index.php?p=$i'>[$i]</a>	";
			}			
		}
		return $html;
	}
}