<?php
namespace app\modules\orgmanagement\themes\basic\myasset;

use yii\web\AssetBundle;
/**
 * Created by PhpStorm.
 * User: leijiao
 * Date: 16/3/11
 * Time: 上午11:34
 */
class ThemeAsset extends AssetBundle
{
    //public $sourcePath = '@app/modules/travelagentmanagement/themes/basic/static';
    public $sourcePath = '@app/modules/orgmanagement/themes/basic/static';
    public $css = [
        'css/public.css',
    	'css/agentSystem.css',
//        'css/style_test.css'
    ];

    public $js = [
        'js/jquery-2.2.2.min.js',
        'js/public.js',
    	'js/jqPaginator.js',
    	'js/organization.js',
    	'js/comm.js',
    	'js/linkagesel-min.js',
    	
    ];
}