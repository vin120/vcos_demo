<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

use app\modules\travelagentmanagement\themes\basic\myasset\ThemeAsset;
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

$module = Yii::$app->controller->module->id;
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$permissionName = $module.'/'.$controller.'/'.$action;
?>
<?php $this->beginPage() ?>
<?php 
$travelAgent = false;
$typeConfig = false;
$recharge = false;
if($permissionName == 'travelagent/agent/travel_agent'||$permissionName=='travelagent/agent/travel_agent_add'||$permissionName=='travelagent/agent/travel_agent_edit' ){
	$travelAgent = true;
}
elseif ($permissionName=='travelagent/agent/type_config'||$permissionName=='travelagent/agent/type_config_add'||$permissionName=='travelagent/agent/type_config_edit'){
	$typeConfig=true;
}
elseif ($permissionName=='travelagent/agent/recharge'){
	$recharge=true;
}
?>
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
        <h1><?= \Yii::t('app', 'Travelagent Management') ?></h1>
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
			<a href="#"><img src="<?=$baseUrl ?>images/routeManage_icon.png"><?= \Yii::t('app', 'Travelagent Manage') ?></a>
		</li>
		<!-- 二级 -->
		<ul style="display: block;">
        <li class="<?php echo ($travelAgent ? 'active':'')?>"><a href="<?php echo Url::toRoute(['agent/travel_agent']);?>"><?= \Yii::t('app', 'Travel Agent') ?></a></li>
         <li class="<?php echo ($typeConfig ? 'active':'')?>"><a href="<?php echo Url::toRoute(['agent/type_config']);?>"><?= \Yii::t('app', 'Type Config') ?></a></li>
       <li class="<?php echo ($recharge ? 'active':'')?>"><a href="<?php echo Url::toRoute(['agent/recharge']);?>"><?= \Yii::t('app', 'Recharge') ?></a></li>
        <li><a href="#"><?= \Yii::t('app', 'Contract') ?></a></li>
         <li><a href="#"><?= \Yii::t('app', 'Sale Report') ?></a></li>

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
