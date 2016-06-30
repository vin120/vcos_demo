<?php
namespace app\modules\controlcenter\themes\basic;

use yii\web\AssetBundle;
/**
 * Created by PhpStorm.
 * User: leijiao
 * Date: 16/3/11
 * Time: 上午11:34
 */
class ThemeAsset extends AssetBundle
{
    public function init()
    {
    }

    public $sourcePath = '@app/modules/controlcenter/themes/basic/static';
    public $css = [

        'css/materialize.min.css',
        'css/style_test.css'
    ];

    public $js = [
        'js/materialize.min.js'
    ];
}