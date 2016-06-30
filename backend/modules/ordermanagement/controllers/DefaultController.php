<?php

namespace app\modules\ordermanagement\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    var $menu_name='123';

    public function actionIndex()
    {
        return $this->render('index');
    }
}
