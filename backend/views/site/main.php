<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */


use yii\helpers\Url;

use backend\views\myasset\MainAsset;

MainAsset::register($this);

$this->title = \Yii::t('app', 'VCOS');
$this->params['breadcrumbs'][] = $this->title;

$baseUrl = $this->assetBundles[MainAsset::className()]->baseUrl . '/';


?>

<header id="header">
	<h1 class="l" id="logo"><img src="<?=$baseUrl ?>img/logo.png"><?= \Yii::t('app', '泛网邮轮管理系统');?></h1>
	<div class="r" id="nav">
		<div>
			<a href="#" class='module'>
				<img src="<?=$baseUrl ?>img/news.png">
				<?= \Yii::t('app', 'Msg') ?>(<span>5</span>)
			</a>
			<a href="#" class='module'>
				<img src="<?=$baseUrl ?>img/set.png">
				<?= \Yii::t('app', 'Set') ?>
			</a>
			<a href="<?= Url::toRoute('site/logout') ?>" class='module'>
				<img src="<?=$baseUrl ?>img/logout.png">
				<?= \Yii::t('app', 'Logout') ?>
			</a>
		</div>
		<div class="user r">
			<div>
				<img src="<?=$baseUrl ?>img/user.png">
				<span><?= Yii::$app->user->identity->username;?></span>
			</div>
			<span class="time"><?= gmdate("d/m/Y l") ?></span>
		</div>
	</div>
</header>
<main id="main">
	<div class="container">
		<div class="page">
			<div>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/5.png">
					<span><?= \Yii::t('app', 'Admin') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/13.png">
					<span><?= \Yii::t('app', 'Voyage') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/1.png">
					<span><?= \Yii::t('app', 'Ticket') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/2.png">
					<span><?= \Yii::t('app', 'Membership') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/6.png">
					<span><?= \Yii::t('app', 'Travelagent') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/4.png">
					<span><?= \Yii::t('app', 'Scheduling') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/7.png">
					<span><?= \Yii::t('app', 'Material') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/8.png">
					<span><?= \Yii::t('app', 'M_Platform') ?></span>
				</a>
			</div>
			<div>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/9.png">
					<span><?= \Yii::t('app', 'Mall') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/10.png">
					<span><?= \Yii::t('app', 'Guest Room') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/11.png">
					<span><?= \Yii::t('app', 'POSSet') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/12.png">
					<span><?= \Yii::t('app', 'Search') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/3.png">
					<span><?= \Yii::t('app', 'Baggage') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/14.png">
					<span><?= \Yii::t('app', 'BasicSet') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/15.png">
					<span><?= \Yii::t('app', 'Report') ?></span>
				</a>
				<a href="#" class='module'>
					<img src="<?=$baseUrl ?>img/16.png">
					<span><?= \Yii::t('app', 'Logs') ?></span>
				</a>
			</div>
		</div>
		<div class="pageNum">
<!--			<a href="#" class="current">1</a>-->
<!--			<a href="#">2</a>-->
<!--			<a href="#">3</a>-->
		</div>
	</div>
</main>
<footer id="footer">
	<p></p>
</footer>
