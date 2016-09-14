/**
 * 注册页面的事件
 */

//注册点击状态转换
function ChangeButton(){
	if($("#ck").is(':checked')==true){
		$("#submit").attr("disabled", false);
	}else{
		$("#submit").attr("disabled", true);
	}
}
//自动切换焦点
function GoNext(v){
	var reg = /^[\u4e00-\u9fa5]{1}$/;
	var str = $("#hz" + v).val();
	if (v < 4){
		if (reg.test(str)){
			var n = v + 1;
			$("#hz" + n).focus();
		}
	}
}
//键盘事件
function keyEvent(e,v){
	var keynum;
	if (e.keyCode != ''){//IE
		keynum = e.keyCode;
	}else if(e.which != ''){//firefox;opera
		keynum = e.which;
	}
	if (keynum == 37){//←
		if (v == 1){
			$("#hz4").focus();
		}else{
			var n = v - 1;
			$("#hz" + n).focus();
		}
	}else if (keynum == 39){//→
		if (v == 4){
			$("#hz1").focus();
		}else{
			var n = v + 1;
			$("#hz" + n).focus();
		}
	}else if (keynum == 8){//Backspace
		if (v >= 1){
			var n = (v-1)<=1 ? 1 : (v-1);
			$("#hz" + n).focus();
		}
	}
}
//改变验证码
function ChangeYzm(){
	var path = "./Lib/yzm.php?rnd=" + 10*Math.random();
	var bs_path = "./Lib/base_yzm.php?rnd=" + Math.random();
	$("#base").attr("src", path);
	$("#base_yzm").attr("src", bs_path);
}
//点击填充事件
function Fillin(e){
	var e = e || window.event; 
	//元素相对父元素位置
	var x = e.offsetX || e.clientX - document.body.offsetLeft;
	var y = e.offsetY || e.clientY - document.body.offsetTop;
	//显示坐标
	$("#mp_x").text(x);
	$("#mp_y").text(y);
	//获取对应的文字序号
	var val = GetPosi(x)+(GetPosi(y)-1)*3-1;
	//填充
	DoFillin(val);
}
//填充函数
function DoFillin(val){
	var data = {
		'method' : 'session_basecode',
	};
	$.ajax({
    	content : document.body,
    	data : data,
    	type : "POST",
    	url : './public/get_code.php',
    	success : function(b){
    		var b_arr = b.split("");
    		for (i=1;i<5;i++){
    			var hz_val = $("#hz" + i).val();
				var n = i+1;
				if(n > 4) n = 4;
    			if (hz_val == ''){
    				$("#hz" + i).val(b_arr[val]);
    				$("#hz" + n).focus();
    				break;
    			}
    			if ($("#hz" + n).val() != ''){
    				$("#hz" + n).focus();
    			}
    		}
    	}
    });
}
//获取相对的坐标
function GetPosi(val){
	if(val<=60){
		return 1;
	}else if(val<=120){
		return 2;
	}else if(val<=180){
		return 3;
	}
}
//注册信息检查
function CheckWords(type){
	var reg = /^[\u4E00-\u9FA5\uf900-\ufa2d\w]{1,}$/;
	if (type == 'u_word'){
		var uname = $("#u_name").val();
		if(reg.test(uname)){
			$("#user_err").text('');
		}else{
			$("#user_err").html('用户名中只能有字母、数字、下划线!');
		}
		var data = {
				'name' : uname,
		};
		$.ajax({
			content: document.body,
			type: "GET",
			data: data,
			url: 'index.php?do=reg',
			success: function(b){
				if(b == 'can'){
					$("#u_name").attr("style","");
					$("#name_info").attr("class", 'right glyphicon glyphicon-ok');
				}else if(b == 'cant'){
					$("#name_info").attr("class", "wrong glyphicon glyphicon-remove");
				}
			}
		});
		
	}else if(type == 'p_word'){
		var pwd = $("#pwd").val();
		if(reg.test(pwd)){
			$("#pwd_err").text('');
			if(pwd.length > 16){
				$("#pwd_err").html('');
				$("#pwd_err").html('密码最多不超过16位!');
			}
		}else{
			$("#pwd_err").text('密码只能有字母、数字!');
		}
	}else if(type == 'rp_word'){
		var re_pwd = $("#re_pwd").val();
		var pwd = $("#pwd").val();
		if(re_pwd.length < 6 ){
			$("#repwd_err").html('密码最少为6位!');
		}else if(re_pwd.length > 16){
			$("#repwd_err").html('');
			$("#repwd_err").html('密码最多不超过16位!');
		}
		if(reg.test(re_pwd)){
			$("#repwd_err").text('');
			if(re_pwd != pwd){
				$("#repwd_err").text('密码不一致!');
			}else if(re_pwd == pwd){
				$("#repwd_err").html('');
			}
		}
	}
}


//获取验证码
function GetYzm(){
	$('#myYzm').dialog({
	    autoOpen: false,
	    width: 600,
	    buttons: {
	        "Ok": function () {
	            $(this).dialog("close");
	        },
	        "Cancel": function () {
	            $(this).dialog("close");
	        }
	    }
	});
}
function SumitYzm(){
	var str1 = $("#hz1").val();
	var str2 = $("#hz2").val();
	var str3 = $("#hz3").val();
	var str4 = $("#hz4").val();
	var str = str1 + str2 + str3 + str4;
	$("#yzm").val(str);
	$("#myYzm").modal("hide");
}

//用户注册
function DoReg(){
	var uname = $("#u_name").val();//用户名
    var pwd = $("#pwd").val();//密码
    var re_pwd = $("#re_pwd").val();//验证密码
    var yzm = $("#yzm").val();//验证码
    var err1 = $("#user_err").html(); 
    var err2 = $("#pwd_err").html(); 
    var err3 = $("#repwd_err").html();
    var err_name = $("#name_info").attr("class");
    if (!uname || !pwd || !re_pwd || !yzm){
    	alert("请填写数据");return false;
    }else if (err1 != ''){
    	alert("用户名错误！");return false;
    }else if(err2 != ''){
    	alert("密码错误！");return false;
    }else if(err3 != ''){
    	alert("密码不一致！");return false;
    }else if(err_name == 'wrong glyphicon glyphicon-remove'){
    	$("#user_err").html('用户名重复！');
    	$("#u_name").attr("style","border-color: red;")
    	$("#u_name").focus();return false;
    }
    var data = {
    	'uname' : uname,
    	'pwd'   : pwd,
    	're_pwd': re_pwd,
    	'yzm'   : yzm,
    };
    $.ajax({
    	content : document.body,
    	data : data,
    	type : "POST",
    	url : 'index.php?do=reg',
    	success : function(b){
    		if (b == 'ok'){
        		alert("注册成功!");
        		window.location.href="index.php";
    		}else if(b == '验证码错误!'){
    			$("#yzm_err").text(b);return false;
    		}else if(b == '密码不一致!'){
    			alert(b);return false;
    		}
    	}
    });
}

//微博登录

//注册协议模态框
$('#myModal').modal('toggle');
