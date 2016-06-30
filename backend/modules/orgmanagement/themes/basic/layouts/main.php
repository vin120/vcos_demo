<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

use app\modules\orgmanagement\themes\basic\myasset\ThemeAsset;
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

$module = Yii::$app->controller->module->id;
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$permissionName = $module.'/'.$controller.'/'.$action;
?>
<?php 
$user = false;
if($permissionName == 'org/user/index'||$permissionName=='org/user/option_user'){
	$user = true;
}
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
    <div class="l" id="title">
        <img src="<?=$baseUrl ?>images/logo.png">
        <h1><?= \Yii::t('app', 'Org Management') ?></h1>
    </div>
    <div class="r" id="user">
        <div class="l" id="user_img">
            <img src="<?=$baseUrl ?>images/user_img.png">
        </div>
        <div class="r">
                    <span><?= Yii::$app->user->identity->username;?></span>
                    <a href="javascript:window.opener=null;window.open('','_self');window.close();"><?= \Yii::t('app', 'Exit') ?></a>
        </div>
    </div>
</header>
<!-- header end -->
<!-- main start -->
<main id="main">
    <!-- asideNav start -->
    <aside id="asideNav" class="l">

        <!-- ------------------------------------------ -->
        <nav id="asideNav_open">
	<!-- 一级 -->
	<ul>
		<li class="close">
			<a href="#"><img src="<?=$baseUrl ?>images/routeManage_icon.png"><?= \Yii::t('app', 'Org Manage') ?></a>
		
		</li>
		<!-- 二级 -->
		<ul style="display: block;">
        <li><a href="#"><?= \Yii::t('app', 'Cruise') ?></a></li>
        <li><a href="<?php echo Url::toRoute(['org/org']);?>"><?= \Yii::t('app', 'Org') ?></a></li>
        <li class="<?php echo ($user ? 'active':'')?>"><a href="<?php echo Url::toRoute(['user/index']);?>"><?= \Yii::t('app', 'User') ?></a></li>
		<li><a href="<?php echo Url::toRoute(['roles/roles']);?>"><?= \Yii::t('app', 'Roles') ?></a></li>
		<li><a href="<?php echo Url::toRoute(['useroperation/useroperation']);?>"><?= \Yii::t('app', 'User operation') ?></a></li>
     </ul>
	</ul>
	<a href="#" id="closeAsideNav"><span>《</span></a>
</nav>
<nav id="asideNav_close">
	<ul>
		<li><img src="<?=$baseUrl ?>images/routeManage_icon.png"></li>
		<a href="#" id="openAsideNav"><span>《</span></a>
	</ul>
</nav>
        <!--  ----------------------  -->
       
    </aside>
    <!-- asideNav end -->
    <!-- content start -->
    <?= $content ?>
    <!-- content end -->
</main>
<!-- main end -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
