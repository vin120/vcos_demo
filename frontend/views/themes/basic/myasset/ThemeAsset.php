<?php
namespace app\views\themes\basic\myasset;

use yii\web\AssetBundle;
/**
 * Created by PhpStorm.
 * User: leijiao
 * Date: 16/3/11
 * Time: 上午11:34
 */
class ThemeAsset extends AssetBundle
{

    public $sourcePath = '@app/views/themes/basic/static';
    public $css = [
        'css/public.css',
    	'css/reset.css',
    	'css/pages.css',
    	'css/style.css',
    ];

    public $js = [
    	'js/My97DatePicker/WdatePicker.js',
    	//'js/phpmailer',
    	'js/jquery-2.2.3.min.js',
    	'js/fillInfo.js',
    	'js/public.js',
    	//'js/js_session.js',
    	'js/additional.js',
    ];
}