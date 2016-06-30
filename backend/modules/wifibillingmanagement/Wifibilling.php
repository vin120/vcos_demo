<?php

namespace app\modules\wifibillingmanagement;

use Yii;
use yii\base\Theme;
use yii\filters\AccessControl;

class Wifibilling extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\wifibillingmanagement\controllers';

    public $layout = "@app/modules/wifibillingmanagement/themes/basic/layouts/main.php";

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme = new Theme([
            'basePath' => '@app/modules/wifibillingmanagement/themes/basic',
            'pathMap' => ['@app/modules/wifibillingmanagement/views' => '@app/modules/wifibillingmanagement/themes/basic'],
            'baseUrl' => '@app/modules/wifibillingmanagement/themes/basic',
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
