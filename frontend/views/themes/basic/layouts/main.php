<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

use app\views\themes\basic\myasset\ThemeAsset;
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<!-- header start -->
<header id="header">
		<div class="container clearfix">
			<div id="logo" class="l">
				<h1>
					<span class="imgBox"><img src="<?=$baseUrl ?>images/logo.png"></span>
					<span>订票中心</span>
				</h1>
			</div>
			<div class="r">
				<?php if(!isset(Yii::$app->user->identity->id)) {?>
				<a href="<?php echo Url::toRoute(['site/login'])?>">登录</a>|
				<?php }else {?>
				<a href="<?php echo Url::toRoute(['site/logout'])?>">退出</a>|
				<?php }?>
				<a href="<?php echo Url::toRoute(['/route/register'])?>">注册</a>
			</div>
			<nav id="mainNav" class="r">
				<ul>
					<li><a href="#">首页</a></li>
					<li><a href="#">航线</a></li>
					<li class="active"><a href="<?php echo Url::toRoute(['/route/index']);?>">路线</a></li>
					<li><a href="#">价目表</a></li>
					<li><a href="#">优惠</a></li>
					<li><a href="#">客房</a></li>
					<li><a href="#">购物</a></li>
					<li><a href="#">餐饮</a></li>
					<li><a href="#">娱乐</a></li>
				</ul>
			</nav>
			
		</div>
	</header>
<!-- header end -->
<!-- main start -->
<main id="main">
    
    <!-- content start -->
    <?= $content ?>
    <!-- content end -->
</main>

<!-- main end -->

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
