<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

use app\modules\reportmanagement\themes\basic\myasset\ThemeAsset;

ThemeAsset::register($this);
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
                    <a href="#"><img src="<?=$baseUrl ?>images/routeManage_icon.png"><?= \Yii::t('app', 'Report Manage') ?><i></i></a>
                </li>
                <!-- 二级 -->
                <ul>
                    <li<?= $controller=='default'? ' class="active"':'' ?>><a href="<?php echo Url::toRoute(['boarding/report']);?>"><?= \Yii::t('app', 'Boarding Report') ?></a></li>
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
