<?php
namespace app\modules\controlcenter\controllers;

use backend\controllers\BaseController;
use Yii;


/**
 * Site controller
 */
class DefaultController extends BaseController
{
    public function actionIndex()
    {
        echo 'access control';
//        exit;
        $this->layout = false;
        return $this->render('index');

    }
    public function actionCreatepost()
    {
        echo 'test login. createPost';
        if(\Yii::$app->user->can('createPost') )
        {
            echo 432;
        } else{
        // 检查没有通过的可以跳转或者显示警告
            echo 123;
        }
    }

    public function actionMytest()
    {
        echo 123;
        exit;
    }

    public function actionMemcache()
    {
//        print_r(Yii::$app->view->theme);
        $my_mem = Yii::$app->memcache;

        $key = 'test1';
        $my_data = 'my data test.';

//        $my_mem->set($key, $my_data, 45);

//        sleep(50);

        $data = $my_mem->get($key);

        print_r($data);
//        return $this->render('index');
    }

    public function actionTest()
    {
        $mail = Yii::$app->mailer->compose();

        $mail->setFrom('leijiao2010@163.com');
        $mail->setTo('377972975@qq.com');
        $mail->setSubject('Password reset for ' . \Yii::$app->name);

        if($mail->send())
            echo "success";
        else
            echo "failse";

        exit;
    }
}
