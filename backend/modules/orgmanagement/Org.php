<?php

namespace app\modules\orgmanagement;
use yii\base\Theme;
use yii\filters\AccessControl;

class Org extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\orgmanagement\controllers';
    public $layout="@app/modules/orgmanagement/themes/basic/layouts/main.php";
    public function init()
    {
        parent::init();
        \Yii::$app->view->theme = new Theme([
        		'basePath' => '@app/modules/orgmanagement/themes/basic',
        		'pathMap' => ['@app/modules/orgmanagement/views'=>'@app/modules/orgmanagement/themes/basic'],
        		'baseUrl' => '@app/modules/orgmanagement/themes/basic',
        ]);
        // custom initialization code goes here
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
