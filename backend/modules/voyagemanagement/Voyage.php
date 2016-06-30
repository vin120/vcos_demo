<?php

namespace app\modules\voyagemanagement;

use Yii;
use yii\base\Theme;
use yii\filters\AccessControl;

class Voyage extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\voyagemanagement\controllers';

    public $layout="@app/modules/voyagemanagement/themes/basic/layouts/main.php";

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme = new Theme([
            'basePath' => '@app/modules/voyagemanagement/themes/basic',
            'pathMap' => ['@app/modules/voyagemanagement/views'=>'@app/modules/voyagemanagement/themes/basic'],
            'baseUrl' => '@app/modules/voyagemanagement/themes/basic',
        ]);
    }
    
    public function behaviors()
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
