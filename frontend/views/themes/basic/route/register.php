<?php
$this->title = 'register';

use app\views\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<style>
	.error_text{width:150px !important;color:red;text-align:left !important;margin-left:10px;}
</style>
<div id="signup" class="main">
	<form action="" method="post">
	<div class="container box">
		<h2>会员注册</h2>
		<div class="box formBox">
			<div class="step">
				<ul>
					<li class="active">
						<span class="num">1</span>
						<span class="title">填写</span>
					</li>
					<li>
						<span class="num">2</span>
						<span class="title">验证</span>
					</li>
					<li>
						<span class="num">3</span>
						<span class="title">注册成功</span>
					</li>
				</ul>
			</div>
			<p>
				<label>
					<span>手机号：</span>
					<input type="text" id="phone" name="phone" placeholder="可用做登录名" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')" >
					
				</label>
			</p>
			<p>
				<label>
					<span>Email：</span>
					<input type="text" name="email" id="email" placeholder="可用作登录名">
				</label>
			</p>
			<p>
				<label>
					<span>密码：</span>
					<input type="password" name="password" id="password" placeholder="8-20位字母、数字和符号">
				</label>
			</p>
			<p>
				<label>
					<span>确认密码：</span>
					<input type="password" name="s_password" id="s_password" placeholder="再次输入密码">
				</label>
			</p>
			<p>
				<label>
					<span>验证码：</span>
					<input type="text" name="verification_code" placeholder="输入验证码">
					<a href="<?php echo Url::toRoute(['sendmail']);?>"><input type="button" name="get_ver_code" id="get_ver_code" value="点击获取邮箱验证码" /></a>
				</label>
			</p>
			<div class="btnBox">
				<input type="button" style="background:#ccc" id="next_but" value="下一步，验证" class="btn2 disabled">
			</div>
		</div>
		
	</div>
	</form>
</div>



<script type="text/javascript">
window.onload = function(){
	var success = 1;
	$("form input[type='text'],form input[type='password']").focus(function(){
		$(this).parent().find("span.error_text").remove();
	});
	$("form input[name='phone']").blur(function(){
		//验证手机号
		var phone = $(this).val();
		if(phone==''){$(this).after('<span class="error_text">请输入手机号</span>');success=0;return false;}
		if(!(/^1[3|4|5|7|8]\d{9}$/.test(phone))){
			$(this).after('<span class="error_text">手机号码格式不正确</span>');success=0;return false;
		}
		var phone_is_exist = 0;
		$.ajax({
		    url:"<?php echo Url::toRoute(['checkphone']);?>",
		    type:'post',
		    async:false,
		    data:'phone='+phone,
		 	dataType:'json',
		 	success:function(data){
		 		phone_is_exist = data;
			}
			
		});
		if(phone_is_exist>0){
			$(this).after('<span class="error_text">手机号码已经存在，请更换</span>');success=0;return false;
		}
		
	});
	$("form input[name='email']").blur(function(){
		//验证邮箱
		var email = $(this).val();
		if(email==''){$(this).after('<span class="error_text">请输入邮箱</span>');success=0;return false;}
		var Regex = /^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/;  
	　　	if (!Regex.test(email)){
			$(this).after('<span class="error_text">邮箱格式不正确</span>');success=0;return false;
		}

	　　	var email_is_exist = 0;
		$.ajax({
		    url:"<?php echo Url::toRoute(['checkemail']);?>",
		    type:'post',
		    async:false,
		    data:'email='+email,
		 	dataType:'json',
		 	success:function(data){
		 		email_is_exist = data;
			}
			
		});
		if(email_is_exist>0){
			$(this).after('<span class="error_text">邮箱已经存在，请更换</span>');success=0;return false;
		}
	});
	$("form input[name='password']").blur(function(){
		var password = $(this).val();
		if(password == ''){
			$(this).after('<span class="error_text">填写密码</span>');success=0;return false;
		}
		var length = password.length;
		if(length>20 || length <8){
			$(this).after('<span class="error_text">密码长度为8-20个字符</span>');success=0;return false;
		}
	});
	$("form input[name='s_password']").blur(function(){
		var s_password = $(this).val();
		if(s_password == ''){
			$(this).after('<span class="error_text">再次输入密码</span>');success=0;return false;
		}
		var password = $("form input[name='password']").val();
		if(password !== s_password){
			$(this).after('<span class="error_text">两次密码不一致</span>');success=0;return false;
		}
	});

	//获取验证码
	$(".form input[name='get_ver_code']").on('click',function(){
		$.ajax({
		    url:"<?php echo Url::toRoute(['sendmail']);?>",
		    type:'post',
		    async:false,
		   // data:'email='+email,
		 	dataType:'json',
		 	success:function(data){
		 		alert(data);
			}
			
		});
	});
	
	
	
	$("#next_but").on("click",function(){
		

	});
}
</script>