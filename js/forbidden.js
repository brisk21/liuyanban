window.onload=function(){
	document.onkeydown=function(){
	var e=window.event||arguments[0];
	if(e.keyCode==123){
		alert("你好帅啊，密码啊8874812");
		return false;
	}else if((e.ctrlKey)&&(e.shiftKey)&&(e.keyCode==73)){
		alert("你好帅啊，密码啊874154");
		return false;
	}
	};
	document.oncontextmenu=function(){
		alert("你好啊，密令是12345");
		return false;
	}
}