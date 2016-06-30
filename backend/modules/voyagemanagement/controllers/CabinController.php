<?php
namespace app\modules\voyagemanagement\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;

class CabinController extends Controller
{
	
	public $enableCsrfValidation = false;
	//cruise
	public function actionCabin(){
		if(isset($_GET['id'])){
			$id = isset($_GET['id'])?$_GET['id']:'';
			$sql = "DELETE FROM `v_c_cabin_lib` WHERE id = '{$id}'";
			$count = Yii::$app->db->createCommand($sql)->execute();
			
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['cabin']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
		if(isset($_POST['ids'])){
			$ids = implode('\',\'', $_POST['ids']);
			$sql = "DELETE FROM `v_c_cabin_lib` WHERE id in ('$ids')";
			$count = Yii::$app->db->createCommand($sql)->execute();
			
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['cabin']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
		
		$where = '';
		$w_name = '';
		$w_p_name = '';
		$w_state = 2;
		if(isset($_POST['w_submit'])){
			$w_name = isset($_POST['w_name'])?$_POST['w_name']:'';
			$w_p_name = isset($_POST['w_p_name'])?$_POST['w_p_name']:'';
			$w_state = isset($_POST['w_state'])?$_POST['w_state']:2;
			if($w_name!=''){
				$where .= "a.cabin_name like '%{$w_name}%' AND ";
			}
			if($w_p_name!=''){
				$where .= "c.type_name like '%{$w_p_name}%' AND ";
			}
			if($w_state!=2){
				$where .= "a.status=".$w_state." AND ";
			}
			$where = trim($where,'AND ');
			
		}
		if($where==''){$where = 1;}
		
		$sql = "SELECT count(*) count FROM `v_c_cabin_lib` a LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id LEFT JOIN `v_c_cabin_type_i18n` c ON b.type_code=c.type_code WHERE b.type_status=1 AND c.i18n='en' AND ".$where;
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		$sql = "SELECT a.*,c.type_name FROM `v_c_cabin_lib` a LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id LEFT JOIN `v_c_cabin_type_i18n` c ON b.type_code=c.type_code WHERE b.type_status=1 AND c.i18n='en' AND ".$where." limit 2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("cabin",['w_name'=>$w_name,'w_p_name'=>$w_p_name,'w_state'=>$w_state,'cabin_result'=>$result,'cabin_count'=>$count['count'],'cabin_pag'=>1]);
			
	}
	
	
	//cruise_add
	public function actionCabinadd(){
		$db = Yii::$app->db;
		if($_POST){
			$cabin_type_id = isset($_POST['cabin_type_id'])?$_POST['cabin_type_id']:'';
			$deck = isset($_POST['deck'])?$_POST['deck']:'0';
// 			$max = isset($_POST['max'])?$_POST['max']:'0';
// 			$min = isset($_POST['min'])?$_POST['min']:'0';
			$name = isset($_POST['name'])?trim($_POST['name']):'0';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$cruise_code = Yii::$app->params['cruise_code'];
			
			
			
			$sql = "SELECT live_number,beds FROM `v_c_cabin_type` WHERE id='{$cabin_type_id}' limit 1";
			$cabin_type_result = Yii::$app->db->createCommand($sql)->queryOne();
			
			$max = $cabin_type_result['beds'];
			$min = $cabin_type_result['live_number'];
			//var_dump($_POST);exit;
			$str = '';
			$name = explode(',', $name);
			foreach ($name as $k=>$v){
				if($v!=''){
					$v = trim($v);
					$str .= "('".$cruise_code."','".$cabin_type_id."','".$v."','".$deck."','".$max."','".$min."','".$state."'),";
				}
			}
			$str = trim($str,',');
			//var_dump($str);exit;
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$sql = "INSERT INTO `v_c_cabin_lib` (cruise_code,cabin_type_id,cabin_name,deck_num,max_check_in,last_aduits_num,status) VALUES ".$str;
				Yii::$app->db->createCommand($sql)->execute();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['cabin']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
		$sql = "SELECT a.id,a.type_code,b.type_name FROM `v_c_cabin_type` a  LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code WHERE a.type_status=1 AND b.i18n = 'en'";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("cabin_add",['type_result'=>$result]);
			
			
	}
	
	
	//cruise_edit
	public function actionCabinedit(){
		$db = Yii::$app->db;
		$id=$_GET['id'];
		if($_POST){
			$cabin_type_id = isset($_POST['cabin_type_id'])?$_POST['cabin_type_id']:'';
			$deck = isset($_POST['deck'])?$_POST['deck']:'0';
// 			$max = isset($_POST['max'])?$_POST['max']:'0';
// 			$min = isset($_POST['min'])?$_POST['min']:'0';
			$name = isset($_POST['name'])?trim($_POST['name']):'0';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$cruise_code = Yii::$app->params['cruise_code'];
			
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$sql = "UPDATE `v_c_cabin_lib` set cruise_code='$cruise_code',cabin_type_id='$cabin_type_id',cabin_name='$name',deck_num='$deck',status='$state' WHERE id=".$id;
				Yii::$app->db->createCommand($sql)->execute();
				
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['cabin']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
	
		$sql = "SELECT a.id,a.type_code,b.type_name FROM `v_c_cabin_type` a  LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code WHERE a.type_status=1 AND b.i18n = 'en'";
		$type_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT * FROM `v_c_cabin_lib` WHERE id=".$id;
		$result = Yii::$app->db->createCommand($sql)->queryOne();
			
		return $this->render("cabin_edit",['cabin_result'=>$result,'type_result'=>$type_result]);
	}
	
	
	public function actionGetcabinpage(){
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		$w_name = isset($_GET['w_name'])?$_GET['w_name']:'';
		$w_p_name = isset($_GET['w_p_name'])?$_GET['w_p_name']:'';
		$w_state = isset($_GET['w_state'])?$_GET['w_state']:2;
		$where = '';
		if($w_name!=''){
			$where .= "a.cabin_name like '%{$w_name}%' AND ";
		}
		if($w_p_name!=''){
			$where .= "c.type_name like '%{$w_p_name}%' AND ";
		}
		if($w_state!=2){
			$where .= "a.status=".$w_state." AND ";
		}
		$where = trim($where,'AND ');
		if($where==''){$where=1;}
		$sql = "SELECT a.*,c.type_name FROM `v_c_cabin_lib` a LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id LEFT JOIN `v_c_cabin_type_i18n` c ON b.type_code=c.type_code WHERE b.type_status=1 AND c.i18n='en' AND ".$where." limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	
	
	//验证房间号是否唯一
	public function actionCheckcabinname(){
		$id = isset($_POST['id'])?$_POST['id']:'';
		$cabin_type = isset($_POST['cabin_type'])?$_POST['cabin_type']:'0';
		$cabin_name = isset($_POST['cabin_name'])?trim($_POST['cabin_name'],','):'';
		$cruise_code = Yii::$app->params['cruise_code'];
		$cabin_name_str = '';
		$cabin_name = explode(',', $cabin_name);
		foreach ($cabin_name as $v){
			$cabin_name_str .= '"'.$v.'",';
		}
		$cabin_name_str = trim($cabin_name_str,',');
		if($id == ''){
			//add
			$sql = "SELECT cabin_name FROM `v_c_cabin_lib` WHERE cabin_type_id='{$cabin_type}' AND cruise_code='{$cruise_code}' AND cabin_name in ({$cabin_name_str})";
		}else{
			//edit
			$sql = "SELECT cabin_name FROM `v_c_cabin_lib` WHERE cabin_type_id='{$cabin_type}' AND cruise_code='{$cruise_code}' AND cabin_name in ({$cabin_name_str}) AND id!='{$id}'";
		}
		
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		
		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
		
	}
	
	
	public function actionCheckcabindeck(){
		$cruise_code = Yii::$app->params['cruise_code'];
		
		$sql = "SELECT deck_number FROM `v_cruise` WHERE cruise_code='{$cruise_code}'";
		$result = Yii::$app->db->createCommand($sql)->queryOne();
		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
		
	}
	
}