<?php

namespace app\modules\travelagentmanagement;

use Yii;
use yii\base\Theme;
class Travelagent extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\travelagentmanagement\controllers';

    public $layout="@app/modules/travelagentmanagement/themes/basic/layouts/main.php";

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme = new Theme([
            'basePath' => '@app/modules/travelagentmanagement/themes/basic',
            'pathMap' => ['@app/modules/travelagentmanagement/views'=>'@app/modules/travelagentmanagement/themes/basic'],
            'baseUrl' => '@app/modules/travelagentmanagement/themes/basic',
        ]);
    }
}