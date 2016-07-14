<?php

namespace app\modules\ordermanagement;

use Yii;
use yii\base\Theme;
class Order extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\ordermanagement\controllers';

    public $layout="@app/modules/ordermanagement/themes/basic/layouts/main.php";

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme = new Theme([
            'basePath' => '@app/modules/ordermanagement/themes/basic',
            'pathMap' => ['@app/modules/ordermanagement/views'=>'@app/modules/ordermanagement/themes/basic'],
            'baseUrl' => '@app/modules/ordermanagement/themes/basic',
        ]);
    }
}