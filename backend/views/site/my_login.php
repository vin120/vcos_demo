<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\views\myasset\LoginAsset;
use yii\helpers\Url;

LoginAsset::register($this);

$this->title = 'User Login';
$this->params['breadcrumbs'][] = $this->title;

$baseUrl = $this->assetBundles[LoginAsset::className()]->baseUrl . '/';

$curr_language = Yii::$app->language;

?>

	<header id="header">
		<h1 id="logo" class="l"><img src="<?= $baseUrl ?>/img/logo.png">  <?= \Yii::t('app', 'Cruise One System');?></h1>
		<div id="mylang">
			<span<?= ($curr_language == 'zh-CN' ? ' class="activate"':'')?> ><a href="<?php echo  Url::current(['lang' => 'zh-CN']); ?>">中文</a></span>
			<span<?= ($curr_language == 'en-US' ? ' class="activate"':'')?>><a href="<?php echo  Url::current(['lang' => 'en-US']); ?>">English</a></span>
		</div>
	</header>
	<main id="main">
		<div class="container">
			<img src="<?= $baseUrl ?>img/login-main-bg.jpg" />
			<div id="loginForm">
				<img src="<?= $baseUrl ?>img/login.png" />
				<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
					<fieldset>
						<legend><?= \Yii::t('app', 'USER LOGIN');?></legend>

						<div>
							<p>
								<img src="<?= $baseUrl ?>img/login-user.png">
								<?=
									Html::activeTextInput($model, 'username',['maxlength'=>20,'required'=>'required',
									'oninvalid'=>'setCustomValidity("'. \Yii::t('app', 'Username Can\'t be empty').'")',
									'oninput'=>'setCustomValidity("")',
									'autofocus'=>'autofocus','placeholder' =>\Yii::t('app', 'Username')])
								?>
							</p>
							<p>
								<img src="<?= $baseUrl ?>img/login-pw.png">
								<?= Html::activePasswordInput($model, 'password',['maxlength'=>20,'required'=>'required',
									'oninvalid'=>'setCustomValidity("'. \Yii::t('app', 'Password Can\'t be empty').'")',
									'oninput'=>'setCustomValidity("")',
									'placeholder'=>\Yii::t('app', 'Password')])?>
							</p>
							<p class="remember">
								<label><?= Html::activeCheckbox($model, 'rememberMe')?></label>
							</p>
						</div>
						<div class="btn">
							<input type="submit" name="login-button" value="<?= \Yii::t('app', 'Login');?>" />
							<input type="reset" value="<?= \Yii::t('app', 'Reset');?>" />
						</div>
					</fieldset>

				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</main>
	<footer id="footer">
		<p></p>
	</footer>
