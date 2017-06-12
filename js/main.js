function checkInput(){
	var oContent = document.getElementById('content').value;
	var oUser = document.getElementById('username').value;
	var oCode = document.getElementById('inputCode').value;
	var oemail = document.getElementById('Emails');
	var ochoseHidden = document.getElementById('choseHidden');	
	if( oContent == '' ||  oUser == ''){
		alert("留言内容和用户名不能为空，请重新输入");		
	}else if(oCode == ''){
		alert("请输入验证码");
	}if(ochoseHidden.checked && oemail.value == "" ){	
		alert("选择不显示到留言区,请填写邮箱地址。");
	}/* else{
		document.getElementById('Form').action="save.php";
	} */
}
