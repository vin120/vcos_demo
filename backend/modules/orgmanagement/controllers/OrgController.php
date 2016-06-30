<?php

namespace app\modules\orgmanagement\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\orgmanagement\components\Helper;
use app\modules\orgmanagement\components\BuildTreeArray;

class OrgController extends Controller
{
	
	public function actionOrg(){
		$sql = "SELECT department_id,department_name,parent_department_id FROM `v_department` ORDER BY parent_department_id";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
				
		$buildTree = new BuildTreeArray($result,'department_id','parent_department_id','department_name',0);
		$data = $buildTree->getDevTree();
// 		$data = self::sortOut($result);
		//echo '<pre>';
		//var_dump($data);exit;
		return $this->render("org",['data'=>$data]);
	}
	
	
	
	
	public function actionOrgadd(){
		$result = array();
		if(isset($_GET['id'])){
			$sql = "SELECT * FROM `v_department` WHERE department_id=".$_GET['id'];
			$result = Yii::$app->db->createCommand($sql)->queryOne();
		}
		if($_POST){
			$dep_id = isset($_POST['dep_id'])?$_POST['dep_id']:'';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$desc = isset($_POST['desc'])?trim($_POST['desc']):'';
			$dep = isset($_POST['dep'])?$_POST['dep']:1;
			$parent_id = isset($_POST['parent_id'])?$_POST['parent_id']:'';
			if($dep==1){$parent_id=0;}
			if($dep_id!=''){
				$sql = "UPDATE `v_department` set department_name='$name',parent_department_id='$parent_id',remark='$desc' WHERE department_id= ".$dep_id;
			}else{
				$sql = "INSERT INTO `v_department` (department_name,parent_department_id,remark) VALUES ('$name','$parent_id','$desc')";
			}
			$transaction =\Yii::$app->db->beginTransaction();
			try {
				$command= \Yii::$app->db->createCommand($sql)->execute();
				$transaction->commit();
				Helper::show_message(yii::t('app', "save success"),Url::toRoute(["org"]));
				//return $this->redirect("travel_agent?massage=success");
			} catch(Exception $e) {
				$transaction->rollBack();
				Helper::show_message(yii::t('app', "save fail"),Url::toRoute(["org"]));
				//return $this->redirect("travel_agent?massage=fail");
			}
			
		}
		return $this->render("org_add",['result'=>$result]);
	}
	
	public function actionGetorgdata(){
		$sql = "SELECT department_id,department_name,parent_department_id FROM `v_department`";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$buildTree = new BuildTreeArray($result,'department_id','parent_department_id','department_name',0);
		$linkagese_data = $buildTree->getLinkageselData();
		
		if($linkagese_data){
			echo $linkagese_data;
		}else{
			echo 0;
		}
	}
	
	
	public function actionOrgdelete(){
		$data = isset($_GET['data'])?$_GET['data']:'';
		$data = trim($data,',');
		
		$sql = "DELETE FROM `v_department` WHERE department_id in ($data)";
		$count = \Yii::$app->db->createCommand($sql)->execute();
		$sql = "DELETE FROM `v_department` WHERE parent_department_id in ($data)";
		\Yii::$app->db->createCommand($sql)->execute();
		
		if($count){
			echo 1;
		}else{
			echo 0;
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}