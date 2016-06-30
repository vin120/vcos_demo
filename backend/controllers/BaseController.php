<?php
/**
 * Created by PhpStorm.
 * User: leijiao
 * Date: 16/3/15
 * Time: 下午4:58
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class BaseController  extends Controller
{
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
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    public function beforeAction_($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;

        //modules
        $permissionName = $controller.'/'.$action;

        if(!\Yii::$app->user->can($permissionName) && Yii::$app->getErrorHandler()->exception === null){
            throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
        }
        return true;
    }
}