<?php

namespace travelagent\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class BaseController  extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

//    public function beforeAction_($action)
//    {
//        if (!parent::beforeAction($action)) {
//            return false;
//        }
//        $module = Yii::$app->controller->module->id;
//        $controller = Yii::$app->controller->id;
//        $action = Yii::$app->controller->action->id;
//        $permissionName = $module.'/'.$controller.'/'.$action;
//        if(!\Yii::$app->user->can($permissionName) && Yii::$app->getErrorHandler()->exception === null){
//            throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
//        }
//        return true;
//    }
}