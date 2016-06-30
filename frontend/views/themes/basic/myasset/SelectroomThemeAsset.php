<?php
namespace app\views\themes\basic\myasset;

use yii\web\AssetBundle;
/**
 * Created by PhpStorm.
 * User: leijiao
 * Date: 16/3/11
 * Time: 上午11:34
 */
class SelectroomThemeAsset extends AssetBundle
{

    public $sourcePath = '@app/views/themes/basic/static';
    public $css = [
        
    ];

    public $js = [
       'js/selectRoom.js',
    ];

    //依赖关系
    public $depends = [
    		'app\views\themes\basic\myasset\ThemeAsset',
    ];

}
