<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\views\myasset\LoginAsset;

LoginAsset::register($this);

$this->title = 'User Login';
$this->params['breadcrumbs'][] = $this->title;

$baseUrl = $this->assetBundles[LoginAsset::className()]->baseUrl . '/';

?>

	<header id="header">
		<h1 id="logo" class="l"><img src="<?= $baseUrl ?>/img/logo.png"><?= \Yii::t('app', '泛网邮轮管理系统');?></h1>
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
									'autofocus'=>'autofocus','placeholder' =>\Yii::t('app', 'Username')])
								?>
							</p>
							<p>
								<img src="<?= $baseUrl ?>img/login-pw.png">
								<?= Html::activePasswordInput($model, 'password',['maxlength'=>20,'required'=>'required',
									'oninvalid'=>'setCustomValidity("'. \Yii::t('app', 'Password Can\'t be empty').'")',
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
