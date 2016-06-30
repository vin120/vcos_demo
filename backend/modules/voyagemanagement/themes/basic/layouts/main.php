<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

$controller = Yii::$app->controller->id;

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
        <h1><?= \Yii::t('app', 'Voyage Management') ?></h1>
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
        <nav id="asideNav_open">
            <!-- 一级 -->
            <ul>
                <li class="open">
                    <a href="<?php echo Url::toRoute(['default/index']);?>"><img src="<?=$baseUrl ?>images/routeManage_icon.png"><?= \Yii::t('app', 'Voyage Manage') ?><i></i></a>
                </li>
                <!-- 二级 -->
                <ul>
                    <li<?= $controller=='area'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['area/area']);?>"><?= \Yii::t('app', 'Area') ?></a></li>
                    <li<?= $controller=='cruise'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['cruise/cruise']);?>"><?= \Yii::t('app', 'Cruise') ?></a></li>
                    <li<?= $controller=='country'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['country/country']);?>"><?= \Yii::t('app', 'Country') ?></a></li>
                    <li<?= $controller=='port'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['port/port']);?>"><?= \Yii::t('app', 'Port') ?></a></li>
                    <li<?= $controller=='cabintype'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['cabintype/cabintype']);?>"><?= \Yii::t('app', 'Cabin Type') ?></a></li>
                    <li<?= $controller=='cabin'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['cabin/cabin']);?>"><?= \Yii::t('app', 'Cabin') ?></a></li>
                    <li<?= $controller=='activeconfig'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['activeconfig/activeconfig']);?>"><?= \Yii::t('app', 'Active Config') ?></a></li>
                    <li<?= $controller=='surcharge'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['surcharge/surchargeconfig']);?>"><?= \Yii::t('app', 'Surcharge Config') ?></a></li>
                    <li<?= $controller=='shoreexcursion'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['shoreexcursion/shoreexcursion']);?>"><?= \Yii::t('app', 'Shore Excursion') ?></a></li>
                    <li<?= $controller=='voyageset'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['voyageset/index']);?>"><?= \Yii::t('app', 'Voyage Set') ?></a></li>
                    <li<?= $controller=='cabincategory'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['cabincategory/cabincategory']);?>"><?= \Yii::t('app', 'Cabin Category') ?></a></li>
                    <li<?= $controller=='cabinpricing'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['cabinpricing/cabinpricing']);?>"><?= \Yii::t('app', 'Cabin Pricing') ?></a></li>
                    <li<?= $controller=='preferentialway'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['preferentialway/preferentialway']);?>"><?= \Yii::t('app', 'Preferential Way') ?></a></li>
                </ul>
            </ul>
            <a href="#" id="closeAsideNav"><img src="<?=$baseUrl ?>images/asideNav_close.png"></a>
        </nav>
        <nav id="asideNav_close">
            <ul>
                <li><img src="<?=$baseUrl ?>images/routeManage_icon.png"></li>
                <a href="#" id="openAsideNav"><img src="<?=$baseUrl ?>images/asideNav_open.png"></a>
            </ul>
        </nav>
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
