<?php


namespace app\modules\membermanagement;

use Yii;
use yii\base\Theme;
// use yii\helpers\Url;

class Member extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\membermanagement\controllers';

    public $layout="@app/modules/membermanagement/themes/basic/layouts/main.php";

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme = new Theme([
            'basePath' => '@app/modules/membermanagement/themes/basic',
            'pathMap' => ['@app/modules/membermanagement/views'=>'@app/modules/membermanagement/themes/basic'],
            'baseUrl' => '@app/modules/membermanagement/themes/basic',
        ]);
    }
}
