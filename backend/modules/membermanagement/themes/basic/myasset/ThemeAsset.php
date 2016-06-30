<?php
namespace app\modules\membermanagement\themes\basic\myasset;

use yii\web\AssetBundle;
/**
 * Created by PhpStorm.
 * User: leijiao
 * Date: 16/3/11
 * Time: 上午11:34
 */
class ThemeAsset extends AssetBundle
{

    public $sourcePath = '@app/modules/membermanagement/themes/basic/static';
    public $css = [
        'css/public.css',
       	'css/ticketSystem.css',
       /*  'css/jquery-ui.min.css', */
        'css/validatorAuto.css',
        'css/validator.css',
    ];

    public $js = [
        // 'js/jquery-2.2.2.min.js',
    	
        'js/public.js',
    	// 'js/jquery-ui.min.js',
        // 'js/jquery.validate.js',
    	// 'js/jquery.validate.min.js',
        // 'js/myperson.js',
//     	'js/additional-methods.js',
//     	

        // 'js/formValidator.js',
        // 'js/formValidatorRegex.js',
        // 'js/DateTimeMask.js',
        // 'js/formValidator_min.js',
    ];
}