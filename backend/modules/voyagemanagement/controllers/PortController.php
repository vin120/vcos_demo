<?php

namespace app\modules\voyagemanagement\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;
use app\modules\voyagemanagement\models\VCPort;
use app\modules\voyagemanagement\models\VCPortI18n;

class PortController extends Controller
{

	//port
	public function actionPort()
	{
		if(isset($_GET['code'])){
			$code = isset($_GET['code'])?$_GET['code']:'';
			$sql = "DELETE FROM `v_c_port` WHERE port_code = '{$code}'";
			$count = Yii::$app->db->createCommand($sql)->execute();
			$sql = "DELETE FROM `v_c_port_i18n` WHERE port_code = '{$code}'";
			Yii::$app->db->createCommand($sql)->execute();
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['port']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
		if(isset($_POST['ids'])){
			$ids = implode('\',\'', $_POST['ids']);
			$sql = "DELETE FROM `v_c_port` WHERE port_code in ('$ids')";
			$count = Yii::$app->db->createCommand($sql)->execute();
			$sql = "DELETE FROM `v_c_port_i18n` WHERE port_code in ('$ids')";
			Yii::$app->db->createCommand($sql)->execute();
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['port']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
		$where = '';
		$w_name = '';
		$w_code = '';
		$w_state = 2;
		if(isset($_POST['w_submit'])){
			$w_name = isset($_POST['w_name'])?$_POST['w_name']:'';
			$w_code = isset($_POST['w_code'])?$_POST['w_code']:'';
			$w_state = isset($_POST['w_state'])?$_POST['w_state']:2;
			if($w_name!=''){
				$where .= "b.port_name like '%{$w_name}%' AND ";
			}
			if($w_code!=''){
				$where .= "a.country_code like '%{$w_code}%' AND ";
			}
			if($w_state!=2){
				$where .= "a.status=".$w_state." AND ";
			}
			$where = trim($where,'AND ');
			
		}
		if($where==''){$where = 1;}
		
		$sql = "SELECT count(*) count FROM `v_c_port` a LEFT JOIN `v_c_port_i18n` b ON a.port_code=b.port_code WHERE b.i18n='en' AND ".$where;
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		$sql = "SELECT a.*,b.port_name,b.i18n FROM `v_c_port` a LEFT JOIN `v_c_port_i18n` b ON a.port_code=b.port_code WHERE b.i18n='en' AND ".$where." limit 2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("port",['w_name'=>$w_name,'w_code'=>$w_code,'w_state'=>$w_state,'port_result'=>$result,'port_count'=>$count['count'],'port_pag'=>1]);
	}
	
	
	//port_add
	public function actionPortadd(){
		$db = Yii::$app->db;
		$port = new VCPort();
		$port_language = new VCPortI18n();
		if($_POST){
			$code = isset($_POST['code'])?$_POST['code']:'';
			$code_chara = isset($_POST['code_chara'])?$_POST['code_chara']:'';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$country_code = isset($_POST['country_code'])?$_POST['country_code']:'';
			 
			$port->port_code = $code;
			$port->port_short_code = $code_chara;
			$port->country_code = $country_code;
			$port->status = $state;
			 
			$port_language->port_code = $code;
			$port_language->port_name = $name;
			$port_language->i18n = 'en';
			 
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$port->save();
				$port_language->save();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['port']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
		$sql = "SELECT country_code FROM `v_c_country` WHERE status=1";
		$country_result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("port_add",['country_result'=>$country_result]);
	}
	
	
	//port_edit
	public function actionPortedit(){
		$db = Yii::$app->db;
		$old_code=$_GET['code'];
		if($_POST){
			$code = isset($_POST['code'])?$_POST['code']:'';
			$code_chara = isset($_POST['code_chara'])?$_POST['code_chara']:'';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$country_code = isset($_POST['country_code'])?$_POST['country_code']:'';
	
			 
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$sql = "UPDATE `v_c_port` set port_code='$code',port_short_code='$code_chara',status='$state',country_code='$country_code' WHERE port_code='$old_code'";
				Yii::$app->db->createCommand($sql)->execute();
				$sql = "UPDATE `v_c_port_i18n` set port_code='$code',port_name='$name',i18n='en' WHERE port_code='$old_code'";
				Yii::$app->db->createCommand($sql)->execute();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['port']));
				 
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
	
	
		$sql = "SELECT a.*,b.port_name,b.i18n FROM `v_c_port` a LEFT JOIN `v_c_port_i18n` b ON a.port_code=b.port_code WHERE b.i18n='en' AND a.port_code = '$old_code'";
		$result = Yii::$app->db->createCommand($sql)->queryOne();
		$sql = "SELECT country_code FROM `v_c_country` WHERE status=1";
		$country_result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("port_edit",['port_result'=>$result,'country_result'=>$country_result]);
	}
	
	
	
	//port name check
	//act==1:edit  act==2:add
	public function actionPortcodecheck(){
		$code = isset($_GET['code'])?$_GET['code']:'';
		$act = isset($_GET['act'])?$_GET['act']:2;
		$id = isset($_GET['id'])?$_GET['id']:'';
		if($act == 1){
			//edit
			$sql = "SELECT count(*) count FROM `v_c_port` WHERE port_code='$code' AND id!=$id";
			$result = Yii::$app->db->createCommand($sql)->queryOne();
			$count = $result['count'];
		}else{
			//add
			$count = VCPort::find()->where(['port_code' => $code])->count();
		}
		if($count==0){
			echo 0;
		}else{
			echo 1;
		}
	}
	
	//港口分页
	public function actionGetportpage(){
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		$w_name = isset($_GET['w_name'])?$_GET['w_name']:'';
		$w_code = isset($_GET['w_code'])?$_GET['w_code']:'';
		$w_state = isset($_GET['w_state'])?$_GET['w_state']:2;
		$where = '';
		if($w_name!=''){
			$where .= "b.port_name like '%{$w_name}%' AND ";
		}
		if($w_code!=''){
			$where .= "a.country_code like '%{$w_code}%' AND ";
		}
		if($w_state!=2){
			$where .= "a.status=".$w_state." AND ";
		}
		$where = trim($where,'AND ');
		if($where==''){$where=1;}
		
		$sql = "SELECT a.*,b.port_name,b.i18n FROM `v_c_port` a LEFT JOIN `v_c_port_i18n` b ON a.port_code=b.port_code WHERE b.i18n='en' AND ".$where." limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	
	
	
	
}