<?php

namespace app\modules\orgmanagement\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\orgmanagement\components\Helper;

class RolesController extends Controller
{
	
	public function actionRoles(){
		if(isset($_GET['name'])){
			
			$sql = "DELETE FROM `auth_item` WHERE name='{$_GET['name']}'";
			$count = Yii::$app->db->createCommand($sql)->execute();
			$sql = "DELETE FROM `auth_item_child` WHERE parent='{$_GET['name']}'";
			Yii::$app->db->createCommand($sql)->execute();
				
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['roles']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
		if($_POST){
			$ids = implode('\',\'', $_POST['ids']);
			$sql = "DELETE FROM `auth_item` WHERE name in ('$ids')";
			$count = Yii::$app->db->createCommand($sql)->execute();
			$sql = "DELETE FROM `auth_item_child` WHERE parent in ('$ids')";
			Yii::$app->db->createCommand($sql)->execute();
				
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['roles']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
		$sql = "SELECT count(*) count FROM `auth_item` WHERE type=1";
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		$sql = "SELECT name FROM `auth_item` WHERE type=1 limit 2";
		$roles_result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("roles",['roles_result'=>$roles_result,'roles_count'=>$count['count'],'roles_pag'=>1]);
	}
	
	public function actionGetrolespage(){
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		
		$sql = "SELECT name FROM `auth_item` WHERE type=1 limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	public function actionRolesadd(){
		$db = Yii::$app->db;
		if($_POST){
			$item_list = isset($_POST['item_list'])?trim($_POST['item_list'],','):'';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$time = time();
			$sql = "INSERT INTO `auth_item` (name,type,description,created_at,updated_at) VALUES ('{$name}','1','{$name}','{$time}','{$time}')";
			
			
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				Yii::$app->db->createCommand($sql)->execute();
				$item_list = explode(',', $item_list);
				foreach ($item_list as $v){
					if($v!=''){
						$sql = "INSERT INTO `auth_item_child` (parent,child) VALUES ('{$name}','{$v}')";
						Yii::$app->db->createCommand($sql)->execute();
					}
				}
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['roles']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
		$sql = "SELECT name,description FROM `auth_item` WHERE type=2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("roles_add",['result'=>$result]);
	}
	
	
	public function actionRolesedit(){
		$db = Yii::$app->db;
		$old_name = isset($_GET['name'])?$_GET['name']:'';
		if($_POST){
			$item_list = isset($_POST['item_list'])?trim($_POST['item_list'],','):'';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$time = time();
			//var_dump($_POST);exit;
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$sql = "DELETE FROM `auth_item_child` WHERE parent='{$old_name}'";
				Yii::$app->db->createCommand($sql)->execute();
				$sql = "UPDATE `auth_item` set name='{$name}',description='{$name}',updated_at='{$time}' WHERE name='{$old_name}' ";
				Yii::$app->db->createCommand($sql)->execute();
				$item_list = explode(',', $item_list);
				foreach ($item_list as $v){
					if($v!=''){
						$sql = "INSERT INTO `auth_item_child` (parent,child) VALUES ('{$name}','{$v}')";
						Yii::$app->db->createCommand($sql)->execute();
					}
				}
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['roles']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
			
		}
		$sql = "select a.name,a.description,a.type,b.parent from `auth_item` a  LEFT JOIN auth_item_child b ON a.`name`=b.child AND b.`parent`='{$old_name}' WHERE a.type=2";
		$roles_result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("roles_edit",['roles_result'=>$roles_result,'roles_name'=>$old_name]);
	}
	
	public function actionCheckrolesnameonly(){
		$name = isset($_GET['name'])?$_GET['name']:'';
		
		$sql = "SELECT count(*) count FROM `auth_item` WHERE name='{$name}'";
		
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		if($count['count']==0){
			echo 1;
		}else{
			echo 0;
		}
		
		
	}
	
	
}