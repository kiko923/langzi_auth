var interval1,interval2;
function setCookie(name,value)
{
	var exp = new Date();
	exp.setTime(exp.getTime() + 30*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
}
function getqrpic(force){
	force = force || false;
	cleartime();
	var qrsig = getCookie('qrsig');
	var qrimg = getCookie('qrimg');
	if(qrsig!=null && qrimg!=null && force==false){
		$('#qrimg').attr('qrsig',qrsig);
		$('#qrimg').html('<img id="qrcodeimg" onclick="getqrpic(true)" src="data:image/png;base64,'+qrimg+'" title="点击刷新">');
		if( /Android|SymbianOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Windows Phone|Midp/i.test(navigator.userAgent) && navigator.userAgent.indexOf("QQ/") == -1) {
			$('#mobile').show();
		}
		interval1=setInterval(loginload,1000);
// 		interval2=setInterval(qrlogin,3000);
	}else{
	    layer.load();
		var getvcurl='ajax.php?action=getQR&t=' + new Date().getTime();
		$.get(getvcurl, function(d) {
			if(d.code ==200){
			    layer.closeAll();
				setCookie('qrsig',d.qrsig);
				setCookie('qrimg',d.data);
				$('#qrimg').attr('qrsig',d.qrsig);
				$('#qrimg').html('<img id="qrcodeimg" onclick="getqrpic(true)" src="data:image/png;base64,'+d.data+'" title="点击刷新">');
				if( /Android|SymbianOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Windows Phone|Midp/i.test(navigator.userAgent) && navigator.userAgent.indexOf("QQ/") == -1) {
					$('#mobile').show();
				}
				interval1=setInterval(loginload,1000);
				//interval2=setInterval(qrlogin,3000);
			}else{
			    layer.closeAll();
				alert(d.msg);
			}
		}, 'json');
	}
}
// function ptuiCB(code,uin,sid,skey,pskey,pskey2,nick){
// 	var msg='请扫描二维码';
// 	switch(code){
// 		case '0':
// 			$('#login').html('<div class="alert alert-success">QQ验证成功！' + decodeURIComponent(nick) + '</div><br/><a href="../download_get.php?my=install&qq=' + uin + '&r=' + Date.now() + '" target="_blank" class="btn btn-primary">完整安装包</a>&nbsp;<a href="../download_get.php?my=update&qq=' + uin + '&r=' + Date.now() + '" target="_blank" class="btn btn-success">更新包</a><hr/>提示：如果需要全新搭建或之前未搭建过，请下载完整安装包；如果之前搭建过，请下载更新包直接覆盖，数据不会丢失。');
// 			$('#qrimg').hide();
// 			$('#submit').hide();
// 			$('#mobile').hide();
// 			$('#login').attr("data-lock", "true");
// 			//var url="/user/addqq2?uin="+a+"&skey="+b+"&cookie="+c+"&r="+Math.random(1);
// 			//loadScript(url);
// 			break;
// 		case '1':
// 			getqrpic();
// 			//document.getElementById('loginpic').src='/qlogin/captcha.php?do=ptqrshow&appid=549000929&e=2&l=M&s=3&d=72&v=4&daid=147&t='+Math.random(1);
// 			alert('请重新扫描二维码');
// 			msg='请重新扫描二维码';
// 			break;
// 		case '2':
// 			alert('请使用QQ手机版扫描二维码后再点击验证');
// 			msg='使用QQ手机版扫描二维码';
// 			break;
// 		case '3':
// 			alert('扫码成功，请在手机上确认授权登录');
// 			msg='扫码成功，请在手机上确认授权登录';
// 			break;
// 		case '4':
// 			alert('你的QQ未通过验证，请使用购买授权的QQ扫码！');
// 			msg='你的QQ未通过验证，请使用购买授权的QQ扫码！';
// 			break;
// 		case '5':
// 			alert('QQ验证失败，请解除登录异常后重试！');
// 			msg='QQ验证失败，请解除登录异常后重试！';
// 			break;
// 		default:
// 			msg=sid;
// 			break;
// 	}
// 	$('#loginmsg').html(msg);
// }
function loginload(){
	if ($('#login').attr("data-lock") === "true") return;
	var load=document.getElementById('loginload').innerHTML;
	var len=load.length;
	if(len>2){
		load='.';
	}else{
		load+='.';
	}
	document.getElementById('loginload').innerHTML=load;
}
function loadScript(c) {
    layer.load();
    if ($('#login').attr("data-lock") === "true") return;
    var qrsig = $('#qrimg').attr('qrsig');
    c = c || "ajax.php?action=checkQR&qrsig=" + decodeURIComponent(qrsig) + '&t=' + new Date().getTime();
    
    // 使用jQuery的ajax方法来请求检查二维码状态
    $.getJSON(c, function(response) {
        if (response.code == 200) {
            layer.closeAll();
            // 当 code 为 200 时，表示验证成功
            // $('#login').html('<div class="alert alert-success">QQ验证成功！</div>');
            $('#login').html('<div class="alert alert-success">QQ验证成功！' + decodeURIComponent(response.nick) + '</div><br/><a href="../download_get.php?my=install&qq=' + response.uin + '&r=' + Date.now() + '" target="_blank" class="btn btn-primary">完整安装包</a>&nbsp;<a href="../download_get.php?my=update&qq=' + response.uin + '&r=' + Date.now() + '" target="_blank" class="btn btn-success">更新包</a><hr/>提示：如果需要全新搭建或之前未搭建过，请下载完整安装包；如果之前搭建过，请下载更新包直接覆盖，数据不会丢失。');
            $('#qrimg').hide(); // 隐藏二维码
            $('#submit').hide(); // 隐藏提交按钮
            $('#mobile').hide(); // 隐藏手机登录提示
            $('#login').attr("data-lock", "true"); // 锁定登录状态
        } else {
            layer.closeAll();
            // 处理其他返回码
            switch (response.code) {
                case 400:
                    // layer.msg('二维码已失效，请重新扫描');
                    layer.alert('二维码已失效，请重新扫描',{icon:2,closeBtn: 0,btn: ['确定']}, function(){
                    getqrpic(true); // 重新获取二维码
                    layer.closeAll();
                    });
                    break;
                case 2:
                    alert('请使用QQ手机版扫码登录');
                    break;
                case 302:
                    layer.msg('扫码成功，请在手机上确认');
                    break;
                case 4:
                    alert('你的QQ未通过验证，请使用授权的QQ扫码');
                    break;
                case 201:
                    layer.msg('登录成功，获取相关信息失败！');
                    break;
                case 202:
                    layer.msg('请使用QQ手机版扫描二维码后再点击验证',{time:1000});
                    break;
                default:
                    alert('未知错误，请重试');
                    break;
            }
        }
    });
}


function cleartime(){
	clearInterval(interval1);
	clearInterval(interval2);
}
function mloginurl(){
	var imagew = $('#qrcodeimg').attr('src');
	imagew = imagew.replace(/data:image\/png;base64,/, "");
	$('#mlogin').html("正在跳转...");
	$.post("qrcode.php?r="+Math.random(1),{image:imagew}, function(arr) {
		if(arr.code==200) {
			$('#loginmsg').html('跳转到QQ登录后请返回此页面');
			window.location.href='mqqapi://forward/url?version=1&src_type=web&url_prefix='+window.btoa(arr.url);
		}else{
			alert(arr.msg);
		}
		$('#mlogin').html("跳转QQ快捷登录");
	},'json');
}
$(document).ready(function(){
	getqrpic();//加入true则每次都刷新二维码 否则缓存二维码
});
