<?php
namespace backend\views\myasset;

use yii\web\AssetBundle;
/**
 * Created by PhpStorm.
 * User: leijiao
 * Date: 16/3/11
 * Time: 上午11:34
 */
class PublicAsset extends AssetBundle
{

    public $sourcePath = '@app/views/static';
    public $css = [
        'css/public.css',
    ];

    public $js = [
    ];

    //依赖关系
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

//    //定义按需加载JS方法，注意加载顺序在最后
//    public static function addScript($view, $jsfile) {
//        $baseUrl = $view->assetBundles[ThemeAsset::className()]->baseUrl . '/';
//        $view->registerJsFile($jsfile, [ThemeAsset::className(), 'depends' => 'backend\views\ThemeAsset']);
//    }
//
//    //定义按需加载css方法，注意加载顺序在最后
//    public static function addCss($view, $cssfile) {
//        $baseUrl = $view->assetBundles[PublicAsset::className()]->baseUrl . '/';
//        $view->registerCssFile($cssfile, [PublicAsset::className(), 'depends' => 'backend\views\ThemeAsset']);
//    }

}
