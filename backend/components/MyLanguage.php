<?php

namespace backend\components;

use Yii;
/**
 * Description of MyLanguage
 *
 * @author Rock.Lei
 */
class MyLanguage {
    
    public static function setLanguage()
    {
        $cookies = Yii::$app->request->cookies;

        if(isset($_GET['lang'])&&$_GET['lang']!="")   //通过lang参数识别语言   
        {

            Yii::$app->language=$_GET['lang'];

            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'language',
                'value' => $_GET['lang'],
                'expire'=>time()+3600*12
            ]));

        }elseif(isset($cookies['language']))   //通过$_COOKIE['lang']识别语言
        {
            $language = $cookies->getValue('language', 'en-US');//设置默认值
            Yii::$app->language=$language;
        }else{
            //通过系统或浏览器识别语言
            $lang=explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
            Yii::$app->language= 'en-US';//strtolower(str_replace('-','_',$lang[0]));
        }
    }
}