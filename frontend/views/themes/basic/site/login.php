<?php
$this->title = 'login';

use app\views\themes\basic\myasset\ThemeAsset;
use app\views\themes\basic\myasset\SelectroomThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

ThemeAsset::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<style>



</style>
<div id="selectRoom" class="main">
<?php $form = ActiveForm::begin(['id' => 'login-form','action'=>['login']]) ?>
<div class="loginBox"  style="display: block !important">
	<h3>会员登录预定</h3>
	<div class="loginForm">
		<p>
			<label>
				<span>登录名：</span>
				<input type="text" name="LoginForm[username]" placeholder="用户名/卡号/手机/邮箱">
			</label>
			<span class="wrong">
				登录名不能为空
			</span>
		</p>
		<p>
			<label>
				<span>密码：</span>
				<input type="password" name="LoginForm[password]">
			</label>
			<a href="#" class="color">忘记密码？</a>
		</p>
	</div>
	<p class="autoLogin">
		<label>
			<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" value="1" name="LoginForm[rememberMe]"></span>
			<span>30天内自动登录</span>
		</label>
		<a href="<?php echo Url::toRoute(['register'])?>" class="color r">免费注册</a>
	</p>
	<!-- <p class="wrong">
		登录名或密码错误
	</p> -->
	<label></label>
	<p class="btnBox">
		<input type="submit" value="登录" class="btn2">
	</p>
	<!-- <a href="#" class="close">×</a> -->
</div>
<?php ActiveForm::end(); ?>
</div>

