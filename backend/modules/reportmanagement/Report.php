<?php

namespace app\modules\reportmanagement;
use yii\base\Theme;
use yii\filters\AccessControl;

class Report extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\reportmanagement\controllers';
    public $layout="@app/modules/reportmanagement/themes/basic/layouts/main.php";
    public function init()
    {
        parent::init();
        \Yii::$app->view->theme = new Theme([
            'basePath' => '@app/modules/reportmanagement/themes/basic',
            'pathMap' => ['@app/modules/reportmanagement/views'=>'@app/modules/reportmanagement/themes/basic'],
            'baseUrl' => '@app/modules/reportmanagement/themes/basic',
        ]);
        // custom initialization code goes here
    }

    public function behaviors_()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }
}
