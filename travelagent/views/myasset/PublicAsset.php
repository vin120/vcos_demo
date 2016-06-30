<?php
namespace travelagent\views\myasset;

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
        'css/page.css',
    ];

    public $js = [
        'js/jquery-2.2.3.min.js',
        'js/My97DatePicker/WdatePicker.js',
        'js/public.js',
    	'js/jqPaginator.js',
    	'js/addGuestInfo.js',
    	'js/template.js',
    	'js/js_session.js',
    	'js/surchargeAndCabinAssignments.js'
    ];

    //依赖关系
    public $depends = [
    ];

}
