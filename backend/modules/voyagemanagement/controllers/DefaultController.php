<?php

namespace app\modules\voyagemanagement\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;


use app\modules\voyagemanagement\models\VCVoyage;
use app\modules\voyagemanagement\models\VCVoyageI18n;

class DefaultController extends Controller
{
    public function actionIndex()
    {
//        echo 123;exit;
    	return $this->render('index');
    }
    
    
}
