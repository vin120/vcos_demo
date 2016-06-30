<?php

namespace app\modules\voyagemanagement\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;

class AreaController extends Controller
{
	public function actionArea(){
		
		if(isset($_GET['code'])){
			$code = isset($_GET['code'])?$_GET['code']:'';
			$sql = "DELETE FROM `v_c_area` WHERE area_code = '{$code}'";
			$count = Yii::$app->db->createCommand($sql)->execute();
			$sql = "DELETE FROM `v_c_area_i18n` WHERE area_code = '{$code}'";
			Yii::$app->db->createCommand($sql)->execute();
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['area']));
			}else{
				Helper::show_message('Delete failed ');
			}
		
		}
		if($_POST){
			$ids = implode('\',\'', $_POST['ids']);
			$sql = "DELETE FROM `v_c_area` WHERE area_code in ('$ids')";
			$count = Yii::$app->db->createCommand($sql)->execute();
			$sql = "DELETE FROM `v_c_area_i18n` WHERE area_code in ('$ids')";
			Yii::$app->db->createCommand($sql)->execute();
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['area']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
		$sql = "SELECT count(*) count FROM `v_c_area`";
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		$sql = "SELECT a.*,b.area_name,b.i18n FROM `v_c_area` a LEFT JOIN `v_c_area_i18n` b ON a.area_code=b.area_code  WHERE b.i18n='en'  limit 2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("area",['area_result'=>$result,'area_count'=>$count['count'],'area_pag'=>1]);
	}
	
	public function actionGetareapage(){
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		
		$sql = "SELECT a.*,b.area_name,b.i18n FROM `v_c_area` a LEFT JOIN `v_c_area_i18n` b ON a.area_code=b.area_code  WHERE b.i18n='en'  limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	
	
	public function actionAreaupdate(){
		$result = array();
		if(isset($_GET['code'])){
			$sql = "SELECT a.*,b.area_name FROM `v_c_area` a LEFT JOIN `v_c_area_i18n` b ON a.area_code=b.area_code WHERE a.area_code='{$_GET['code']}' AND a.status=1";
			$result = Yii::$app->db->createCommand($sql)->queryOne();
		}
		if($_POST){
			//var_dump($_POST);exit;
			$id = isset($_POST['id'])?$_POST['id']:'';
			$old_code = isset($_POST['old_code'])?$_POST['old_code']:'';
			$code = isset($_POST['code'])?$_POST['code']:'';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$state = isset($_POST['state'])?$_POST['state']:'';
			
			if($id!=''){
				$sql = "UPDATE `v_c_area` set area_code='$code',status='$state' WHERE id= ".$id;
				$sql_1 = "UPDATE `v_c_area_i18n` set area_code='$code',area_name='$name',i18n='en' WHERE area_code='$old_code' ";
			}else{
				$sql = "INSERT INTO `v_c_area` (area_code,status) VALUES ('$code','$state')";
				$sql_1 = "INSERT INTO `v_c_area_i18n` (area_code,area_name,i18n) VALUES ('$code','$name','en')";
			}
			$transaction =\Yii::$app->db->beginTransaction();
			try {
				$command= \Yii::$app->db->createCommand($sql)->execute();
				$command= \Yii::$app->db->createCommand($sql_1)->execute();
				$transaction->commit();
				Helper::show_message(yii::t('app', "save success"),Url::toRoute(["area"]));
			} catch(Exception $e) {
				$transaction->rollBack();
				Helper::show_message(yii::t('app', "save fail"),Url::toRoute(["area"]));
			}
				
		}
		return $this->render("area_update",['result'=>$result]);
	}
	
	
	public function actionAreacodecheck(){
		$code = isset($_GET['code'])?$_GET['code']:'';
		$act = isset($_GET['act'])?$_GET['act']:2;
		$id = isset($_GET['id'])?$_GET['id']:'';
		if($act == 1){
			//edit
			$sql = "SELECT count(*) count FROM `v_c_area` WHERE area_code='$code' AND id!=$id";
			$result = Yii::$app->db->createCommand($sql)->queryOne();
			$count = $result['count'];
		}else{
			//add
			$sql = "SELECT count(*) count FROM `v_c_area` WHERE area_code='$code'";
			$result = Yii::$app->db->createCommand($sql)->queryOne();
			$count = $result['count'];
		}
		if($count==0){
			echo 0;
		}else{
			echo 1;
		}
		
	}
}