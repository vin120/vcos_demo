<?php
/**
 * Created by PhpStorm.
 * User: leijiao
 * Date: 16/3/15
 * Time: 下午4:58
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class BaseController  extends Controller
{

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $module = Yii::$app->controller->module->id;
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $permissionName = $module.'/'.$controller.'/'.$action;
        if(!\Yii::$app->user->can($permissionName) && Yii::$app->getErrorHandler()->exception === null){
            throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
        }
        return true;
    }
}