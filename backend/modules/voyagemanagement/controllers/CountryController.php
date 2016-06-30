<?php

namespace app\modules\voyagemanagement\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;
use app\modules\voyagemanagement\models\VCCountry;
use app\modules\voyagemanagement\models\VCCountryI18n;

class CountryController extends Controller
{
	//country
	public function actionCountry()
	{
		if(isset($_GET['code'])){
			$code = isset($_GET['code'])?$_GET['code']:'';
			$sql = "DELETE FROM `v_c_country` WHERE country_code = '{$code}'";
			$count = Yii::$app->db->createCommand($sql)->execute();
			$sql = "DELETE FROM `v_c_country_i18n` WHERE country_code = '{$code}'";
			Yii::$app->db->createCommand($sql)->execute();
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['country']));
			}else{
				Helper::show_message('Delete failed ');
			}
	
			//return $this->redirect(['country']);
		}
		if(isset($_POST['ids'])){
			$ids = implode('\',\'', $_POST['ids']);
			$sql = "DELETE FROM `v_c_country` WHERE country_code in ('$ids')";
			$count = Yii::$app->db->createCommand($sql)->execute();
			$sql = "DELETE FROM `v_c_country_i18n` WHERE country_code in ('$ids')";
			Yii::$app->db->createCommand($sql)->execute();
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['country']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
		//筛选
		$where = '';
		$w_c_name = '';
		$w_a_name = '';
		$w_state = 2;
		$w_2_code = '';
		$w_3_code = '';
		if(isset($_POST['w_submit'])){
			$w_c_name = isset($_POST['w_c_name'])?$_POST['w_c_name']:'';
			$w_a_name = isset($_POST['w_a_name'])?$_POST['w_a_name']:'';
			$w_state = isset($_POST['w_state'])?$_POST['w_state']:2;
			$w_2_code = isset($_POST['w_2_code'])?$_POST['w_2_code']:'';
			$w_3_code = isset($_POST['w_3_code'])?$_POST['w_3_code']:'';
			if($w_c_name!=''){
				$where .= "b.country_name like '%{$w_c_name}%' AND ";
			}
			if($w_a_name!=''){
				$where .= "c.area_name like '%{$w_a_name}%' AND ";
			}
			if($w_state!=2){
				$where .= "a.status=".$w_state." AND ";
			}
			if($w_2_code!=''){
				$where .= "a.country_code like '%{$w_2_code}%' AND ";
			}
			if($w_3_code!=''){
				$where .= "a.counry_short_code like '%{$w_3_code}%' AND ";
			}
			$where = trim($where,'AND ');
		}
		if($where==''){$where=1;}
		
		$sql = "SELECT count(*) count FROM `v_c_country` a LEFT JOIN `v_c_country_i18n` b ON a.country_code=b.country_code LEFT JOIN `v_c_area_i18n` c ON a.area_code=c.area_code WHERE b.i18n='en' AND c.i18n='en' AND ".$where;
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		$sql = "SELECT a.*,b.country_name,b.i18n,c.area_name FROM `v_c_country` a LEFT JOIN `v_c_country_i18n` b ON a.country_code=b.country_code LEFT JOIN `v_c_area_i18n` c ON a.area_code=c.area_code WHERE b.i18n='en' AND c.i18n='en' AND ".$where." limit 2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("country",['w_c_name'=>$w_c_name,'w_a_name'=>$w_a_name,'w_state'=>$w_state,'w_2_code'=>$w_2_code,'w_3_code'=>$w_3_code,'country_result'=>$result,'country_count'=>$count['count'],'country_pag'=>1]);
	}
	
	//country_add
	public function actionCountryadd(){
		$db = Yii::$app->db;
		$country = new VCCountry();
		$country_language = new VCCountryI18n();
		if($_POST){
			$code = isset($_POST['code'])?$_POST['code']:'';
			$code_chara = isset($_POST['code_chara'])?$_POST['code_chara']:'';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$area_code = isset($_POST['area_code'])?$_POST['area_code']:'';
	
			$country->country_code = $code;
			$country->counry_short_code = $code_chara;
			$country->area_code = $area_code;
			$country->status = $state;
	
			$country_language->country_code = $code;
			$country_language->country_name = $name;
			$country_language->i18n = 'en';
	
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$country->save();
				$country_language->save();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['country']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
		$sql = "SELECT * FROM `v_c_area` a LEFT JOIN `v_c_area_i18n` b ON a.area_code = b.area_code WHERE b.i18n ='en'";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("country_add",['area_result'=>$result]);
	}
	
	//country_edit
	public function actionCountryedit(){
		$db = Yii::$app->db;
		$old_code=$_GET['code'];
		if($_POST){
			$code = isset($_POST['code'])?$_POST['code']:'';
			$code_chara = isset($_POST['code_chara'])?$_POST['code_chara']:'';
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$area_code = isset($_POST['area_code'])?$_POST['area_code']:'';
	
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$sql = "UPDATE `v_c_country` set country_code='$code',counry_short_code='$code_chara',area_code='$area_code',status='$state' WHERE country_code='$old_code'";
				Yii::$app->db->createCommand($sql)->execute();
				$sql = "UPDATE `v_c_country_i18n` set country_code='$code',country_name='$name',i18n='en' WHERE country_code='$old_code'";
				Yii::$app->db->createCommand($sql)->execute();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['country']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
		 
		 
		 
		$sql = "SELECT a.*,b.country_name,b.i18n FROM `v_c_country` a LEFT JOIN `v_c_country_i18n` b ON a.country_code=b.country_code WHERE b.i18n='en' AND a.country_code = '$old_code'";
		$result = Yii::$app->db->createCommand($sql)->queryOne();
		$sql = "SELECT * FROM `v_c_area` a LEFT JOIN `v_c_area_i18n` b ON a.area_code = b.area_code WHERE b.i18n ='en'";
		$area_result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("country_edit",['country_result'=>$result,'area_result'=>$area_result]);
	}
	
	//验证code数据是否唯一
	//act : 1表示编辑  2：表示添加
	public function actionCountrycodecheck(){
		$code = isset($_GET['code'])?$_GET['code']:'';
		$act = isset($_GET['act'])?$_GET['act']:2;
		$id = isset($_GET['id'])?$_GET['id']:'';
		if($act == 1){
			//edit
			$sql = "SELECT count(*) count FROM `v_c_country` WHERE country_code='$code' AND id!=$id";
			$result = Yii::$app->db->createCommand($sql)->queryOne();
			$count = $result['count'];
		}else{
			//add
			$count = VCCountry::find()->where(['country_code' => $code])->count();
		}
		if($count==0){
			echo 0;
		}else{
			echo 1;
		}
		 
	}
	
	//国家分页
	public function actionGetcountrypage(){
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		$where = '';
		$w_c_name = isset($_GET['w_c_name'])?$_GET['w_c_name']:'';
		$w_a_name = isset($_GET['w_a_name'])?$_GET['w_a_name']:'';
		$w_state = isset($_GET['w_state'])?$_GET['w_state']:2;
		$w_2_code = isset($_GET['w_2_code'])?$_GET['w_2_code']:'';
		$w_3_code = isset($_GET['w_3_code'])?$_GET['w_3_code']:'';
		if($w_c_name!=''){
			$where .= "b.country_name like '%{$w_c_name}%' AND ";
		}
		if($w_a_name!=''){
			$where .= "c.area_name like '%{$w_a_name}%' AND ";
		}
		if($w_state!=2){
			$where .= "a.status=".$w_state." AND ";
		}
		if($w_2_code!=''){
			$where .= "a.country_code like '%{$w_2_code}%' AND ";
		}
		if($w_3_code!=''){
			$where .= "a.counry_short_code like '%{$w_3_code}%' AND ";
		}
		$where = trim($where,'AND ');
		
		if($where==''){$where=1;}
		$sql = "SELECT a.*,b.country_name,b.i18n,c.area_name FROM `v_c_country` a LEFT JOIN `v_c_country_i18n` b ON a.country_code=b.country_code LEFT JOIN `v_c_area_i18n` c ON a.area_code=c.area_code WHERE b.i18n='en' AND c.i18n='en' AND ".$where." limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
		 
	}
	
	
	
	
}