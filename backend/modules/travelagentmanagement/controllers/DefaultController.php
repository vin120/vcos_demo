<?php

namespace app\modules\travelagentmanagement\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
//use app\modules\travelagentmanagement\components\Helper;
use app\modules\travelagentmanagement\models\VTravelAgent;
use app\modules\travelagentmanagement\models\VTravelAgentType;
use app\modules\travelagentmanagement\models\seletedata;
use app\modules\travelagentmanagement\components\Helper;

class DefaultController extends Controller
{
	public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }
  
}  
    
