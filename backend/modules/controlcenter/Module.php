<?php

namespace app\modules\controlcenter;

use Yii;
use yii\base\Theme;
use yii\filters\AccessControl;

/**
 * Created by PhpStorm.
 * User: leijiao
 * Date: 16/3/10
 * Time: 上午11:50
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\controlcenter\controllers';

    public $layout="@app/modules/controlcenter/themes/basic/layouts/main.php";

    public function init()
    {
        parent::init();
        \Yii::$app->view->theme = new Theme([
            'basePath' => '@app/modules/controlcenter/themes/basic',
            'pathMap' => ['@app/modules/controlcenter/views'=>'@app/modules/controlcenter/themes/basic'],
            'baseUrl' => '@app/modules/controlcenter/themes/basic',
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