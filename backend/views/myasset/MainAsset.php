<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\views\myasset;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $sourcePath = '@app/views/static';
    public $css = [
        'css/index.css',
    ];
    public $js = [
    ];
    public $depends = [
        'backend\views\myasset\PublicAsset'
    ];
}
