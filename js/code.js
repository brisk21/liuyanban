//验证码JavaScript文件
var code;
function createCode() {
	code = "";
	//验证码的长度
	var codeLength = 4; 
	var checkCode = document.getElementById("checkCode");	
	var codeChars = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); 
	for (var i = 0; i < codeLength; i++) {
	  var charNum = Math.floor(Math.random() * 52);
	  code += codeChars[charNum];
	}
	if (checkCode) {
	  checkCode.className = "code";
	  checkCode.innerHTML = code;
	}		
}
function validateCode() {
	var inputCode = document.getElementById("inputCode").value;
	if (inputCode.length <= 0) {
	  return alert("请输入验证码！");
	} else if (inputCode.toUpperCase() != code.toUpperCase()) {
	  return alert("验证码输入有误！");
	  createCode();
	}	
}
	
	
