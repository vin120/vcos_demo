<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\views\myasset;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $sourcePath = '@app/views/static';
    public $css = [
        'css/login.css',
    ];
    public $js = [
        'js/jquery-2.2.2.min.js',
        'js/public.js'
    ];
    public $depends = [
        'backend\views\myasset\PublicAsset'
    ];
}
