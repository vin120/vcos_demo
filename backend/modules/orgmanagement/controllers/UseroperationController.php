<?php

namespace app\modules\orgmanagement\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\orgmanagement\components\Helper;

class UseroperationController extends Controller
{
	
	public function actionUseroperation(){
		$sql = "SELECT count(*) count FROM `user` a LEFT JOIN auth_assignment b ON a.id=b.user_id WHERE a.m_status=1";
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		$sql = "SELECT a.id,a.username,b.item_name FROM `user` a LEFT JOIN auth_assignment b ON a.id=b.user_id WHERE a.m_status=1 limit 2";
		$user_result = Yii::$app->db->createCommand($sql)->queryAll();	
	
		$sql = "SELECT name FROM `auth_item` WHERE type=1";
		$role_result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("user_operation",['result'=>$user_result,'role_result'=>$role_result,'user_operation_count'=>$count['count'],'user_operation_pag'=>1]);
	}
	
	public function actionGetuseroperationpage(){
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		
		$sql = "SELECT a.id,a.username,b.item_name FROM `user` a LEFT JOIN auth_assignment b ON a.id=b.user_id WHERE a.m_status=1 limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	
	
	public function actionSaveuseroperation(){
		$query = 1;
		$db = Yii::$app->db;
		$user_data = isset($_GET['user_data'])?trim($_GET['user_data'],','):'';
		$data = isset($_GET['data'])?$_GET['data']:'';
		$time = time();
		//事务处理
		$transaction=$db->beginTransaction();
		try{
			$sql = "DELETE FROM `auth_assignment` WHERE user_id in ($user_data)";
			Yii::$app->db->createCommand($sql)->execute();
			$user_data = explode(',',$user_data);
			foreach ($user_data as $v){
				$sql = "INSERT INTO `auth_assignment` (item_name,user_id,created_at) VALUES ('$data','$v','$time')";
				Yii::$app->db->createCommand($sql)->execute();
			}
			$transaction->commit();
			$query = 1;
		}catch(Exception $e){
			$transaction->rollBack();
			$query = 0;
		}
		
		echo $query;
				
	}
	
	
	
}