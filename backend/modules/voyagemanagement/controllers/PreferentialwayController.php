<?php
namespace app\modules\voyagemanagement\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;

class PreferentialwayController extends Controller
{
	//优惠方式列表
	public function actionPreferentialway(){
		if(isset($_GET['id'])){
			$id = isset($_GET['id'])?$_GET['id']:'';
			$sql = "SELECT count(*) count FROM `v_c_preferential_strategy` WHERE p_w_id=".$id;
			$counts = Yii::$app->db->createCommand($sql)->queryOne();
			if($counts>0){
				Helper::show_message('Delete failed ,The preferential way is being used');
			}else{
				$sql = "DELETE FROM `v_c_preferential_way` WHERE id = '{$id}'";
				$count = Yii::$app->db->createCommand($sql)->execute();
				$sql = "DELETE FROM `v_c_preferential_way_i18n` WHERE p_w_id = '{$id}'";
				Yii::$app->db->createCommand($sql)->execute();
					
				if($count>0){
					Helper::show_message('Delete the success ', Url::toRoute(['preferentialway']));
				}else{
					Helper::show_message('Delete failed ');
				}
			}
		}
		
		$sql = "SELECT count(*) count FROM `v_c_preferential_way` a LEFT JOIN `v_c_preferential_way_i18n` b ON a.id=b.p_w_id WHERE a.status=1 AND b.i18n='en'";
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		$sql = "SELECT a.id,b.strategy_name FROM `v_c_preferential_way` a LEFT JOIN `v_c_preferential_way_i18n` b ON a.id=b.p_w_id WHERE a.status=1 AND b.i18n='en' limit 2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("preferential_way",['way_result'=>$result,'way_count'=>$count['count'],'way_pag'=>1]);
		
	}
	
	public function actionGetwaypage(){
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		$sql = "SELECT a.id,b.strategy_name FROM `v_c_preferential_way` a LEFT JOIN `v_c_preferential_way_i18n` b ON a.id=b.p_w_id WHERE a.status=1 AND b.i18n='en' limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	
	public function actionPreferentialwayadd(){
		$db = Yii::$app->db;
		if($_POST){
			$name = isset($_POST['name'])?trim($_POST['name']):'';
			$p_where = isset($_POST['p_where'])?trim($_POST['p_where']):'';
			
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$sql = "INSERT INTO `v_c_preferential_way` (status,p_where) VALUES ('1','{$p_where}')";
				Yii::$app->db->createCommand($sql)->execute();
				$p_w_id = Yii::$app->db->getLastInsertID();
				$sql = "INSERT INTO `v_c_preferential_way_i18n` (p_w_id,strategy_name,i18n) VALUES ('$p_w_id','$name','en')";
				Yii::$app->db->createCommand($sql)->execute();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['preferentialway']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
		return $this->render("preferential_way_add");
			
	}
	//
	public function actionPreferentialwayedit(){
		$db = Yii::$app->db;
		$id=$_GET['id'];
		if($_POST){
			
			$name = isset($_POST['name'])?trim($_POST['name']):'';
			$p_where = isset($_POST['p_where'])?trim($_POST['p_where']):'';
				
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$sql = "UPDATE `v_c_preferential_way` set p_where='$p_where' WHERE id=".$id;
				Yii::$app->db->createCommand($sql)->execute();
				
				$sql = "UPDATE `v_c_preferential_strategy` set p_where='$p_where' WHERE p_w_id=".$id;
				Yii::$app->db->createCommand($sql)->execute();
				
				$sql = "UPDATE `v_c_preferential_way_i18n` set strategy_name='$name' WHERE i18n='en' AND p_w_id=".$id;
				Yii::$app->db->createCommand($sql)->execute();
		
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['preferentialway']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
		
		$sql = "SELECT * FROM `v_c_preferential_way` a LEFT JOIN `v_c_preferential_way_i18n` b ON a.id=b.p_w_id WHERE  a.id=".$id;
		$result = Yii::$app->db->createCommand($sql)->queryOne();
			
		return $this->render("preferential_way_edit",['way_result'=>$result]);
		
	}
	
	
}