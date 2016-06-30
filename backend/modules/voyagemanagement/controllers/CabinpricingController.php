<?php

namespace app\modules\voyagemanagement\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;

class CabinpricingController extends Controller
{
	public function actionCabinpricing(){
		$sql = "SELECT a.voyage_code,b.voyage_name,b.i18n FROM `v_c_voyage` a LEFT JOIN `v_c_voyage_i18n` b ON a.voyage_code=b.voyage_code  WHERE b.i18n='en'";
		$voyage_result = Yii::$app->db->createCommand($sql)->queryAll();
		$voyage_code = $voyage_result[0]['voyage_code'];
		$sql = "SELECT a.*,c.type_name FROM `v_c_cabin_pricing` a LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id LEFT JOIN `v_c_cabin_type_i18n` c ON b.type_code=c.type_code  WHERE a.voyage_code='$voyage_code'";
		$cabin_pricing_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		return $this->render("cabin_pricing",['cabin_pricing_result'=>$cabin_pricing_result,'voyage_result'=>$voyage_result]);
	}
	/*
	public function  actionGet_cabin_pricing_page(){
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		$voyage_code = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		$sql = "SELECT a.*,c.type_name FROM `v_c_cabin_pricing` a LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id LEFT JOIN `v_c_cabin_type_i18n` c ON b.type_code=c.type_code  WHERE a.voyage_code='$voyage_code' limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}*/
	
	/**ajax get cabin-pricing**/
	public function actionGetcabinpricinglist(){
		$voyage = isset($_GET['voyage'])?$_GET['voyage']:'0';
		
		$sql = "SELECT a.*,c.type_name FROM `v_c_cabin_pricing` a LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id LEFT JOIN `v_c_cabin_type_i18n` c ON b.type_code=c.type_code  WHERE a.voyage_code='$voyage'";
		$cabin_pricing_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		if($cabin_pricing_result){
			echo json_encode($cabin_pricing_result);
		}else{
			echo 0;
		}
		
	}
	
	/**ajax get preferential-policies**/
	public function actionGetpreferentialpolicieslist(){
		$voyage = isset($_GET['voyage'])?$_GET['voyage']:'0';
		$sql = "SELECT a.*,c.strategy_name FROM `v_c_preferential_strategy` a LEFT JOIN `v_c_preferential_way` b ON a.p_w_id=b.id LEFT JOIN `v_c_preferential_way_i18n` c ON b.id=c.p_w_id  WHERE c.i18n='en' AND a.status=1 AND b.status=1 AND a.voyage_code = '$voyage'";
		$policies_result = Yii::$app->db->createCommand($sql)->queryAll();
	
		if($policies_result){
			echo json_encode($policies_result);
		}else{
			echo 0;
		}
	}
	
	/**ajax get surcharge**/
	public function actionGetsurchargelist(){
		$voyage = isset($_GET['voyage'])?$_GET['voyage']:'0';
		$sql = "SELECT a.id,c.cost_name FROM `v_c_surcharge` a LEFT JOIN `v_c_surcharge_lib` b ON a.cost_id=b.id LEFT JOIN `v_c_surcharge_lib_i18n` c ON b.id=c.cost_id WHERE a.status=1 AND b.status =1 AND c.i18n = 'en' AND a.voyage_code='$voyage'";
		$surcharge_result = Yii::$app->db->createCommand($sql)->queryAll();
		if($surcharge_result){
			echo json_encode($surcharge_result);
		}else{
			echo 0;
		}
	
	}
	
	/**ajax get tour-route**/
	public function actionGettourroutelist(){
		$voyage = isset($_GET['voyage'])?$_GET['voyage']:'0';
		$sql = "SELECT a.id,c.se_name FROM `v_c_shore_excursion` a LEFT JOIN `v_c_shore_excursion_lib` b ON a.sh_id=b.id LEFT JOIN `v_c_shore_excursion_lib_i18n` c ON b.se_code=c.se_code WHERE a.status=1 AND b.status =1 AND c.i18n = 'en' AND a.voyage_code='$voyage'";
		$tour_result = Yii::$app->db->createCommand($sql)->queryAll();
		if($tour_result){
			echo json_encode($tour_result);
		}else{
			echo 0;
		}
	
	
	}
	
	
	
	
	
	
	
	
	
	//获取船舱类型
	public function actionGetcabintype(){
		$voyage_code = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		//all
		$sql = "SELECT a.id,a.beds,b.type_name FROM `v_c_cabin_type` a LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code WHERE a.type_status=1 AND b.i18n='en'";
		//$all_result = Yii::$app->db->createCommand($sql)->queryAll();
		//未存在记录的船舱类型
		$sql = "SELECT a.id,a.beds,b.type_name FROM `v_c_cabin_type` a 
		LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code 
		WHERE a.type_status=1 AND b.i18n='en' AND a.id not in(select cabin_type_id from `v_c_cabin_pricing` c WHERE c.voyage_code='{$voyage_code}')";
		$other_result = Yii::$app->db->createCommand($sql)->queryAll();
		$result = array();
		//$result['all_result'] = $all_result;
		$result['other_result'] = $other_result;
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	
	//船舱定价提交表单入库
	public function actionCabinpricingsubmit(){
		$db = Yii::$app->db;
		$res = 0;
		$sub_id = isset($_GET['sub_id'])?$_GET['sub_id']:0;
		$voyage_code = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		$cabin_type_id = isset($_GET['cabin_type_id'])?$_GET['cabin_type_id']:'0';
		//$check_num = isset($_GET['check_num'])?$_GET['check_num']:'0';
		$bed_price = isset($_GET['bed_price'])?$_GET['bed_price']:'0';
		$last_bed_price = isset($_GET['last_bed_price'])?$_GET['last_bed_price']:'0';
		$t_2_sates = isset($_GET['t_2_sates'])?$_GET['t_2_sates']:'0';
		$t_3_sates = isset($_GET['t_3_sates'])?$_GET['t_3_sates']:'0';
		
		$sql = "SELECT beds FROM `v_c_cabin_type` WHERE id='{$cabin_type_id}' limit 1";
		$cabin_type_result = Yii::$app->db->createCommand($sql)->queryOne();
			
		$check_num = $cabin_type_result['beds'];
		
		if($sub_id != 0){
			$sql = "UPDATE `v_c_cabin_pricing` set voyage_code='$voyage_code',cabin_type_id='$cabin_type_id',check_num='$check_num',bed_price='$bed_price',last_bed_price='$last_bed_price',2_empty_bed_preferential='$t_2_sates',3_4_empty_bed_preferential='$t_3_sates' WHERE id=".$sub_id;
		}else{
			$sql = "INSERT INTO `v_c_cabin_pricing` (voyage_code,cabin_type_id,check_num,bed_price,last_bed_price,2_empty_bed_preferential,3_4_empty_bed_preferential) VALUES ('$voyage_code','$cabin_type_id','$check_num','$bed_price','$last_bed_price','$t_2_sates','$t_3_sates')";
		}
		
		//事务处理
		$transaction=$db->beginTransaction();
		try{
			Yii::$app->db->createCommand($sql)->execute();
			$transaction->commit();
			$res = 1;
		}catch(Exception $e){
			$transaction->rollBack();
			$res =0;
		}
		
		echo $res;
	}
	
	//船舱定价删除
	public function actionCabinpricingdelete(){
		if(isset($_GET['id'])){
			$id = isset($_GET['id'])?$_GET['id']:'0';
			$sql = "DELETE FROM `v_c_cabin_pricing` WHERE id = '{$id}'";
			$count = Yii::$app->db->createCommand($sql)->execute();
				
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['cabinpricing']));
			}else{
				Helper::show_message('Delete failed ', Url::toRoute(['cabinpricing']));
			}
		}
		
	}
	
	//获取船舱定价单条记录
	public function actionGetcabinpricingdata(){
		$id = isset($_GET['id'])?$_GET['id']:'0';
		$sql = "SELECT a.*,c.type_name FROM `v_c_cabin_pricing` a 
				LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id
				LEFT JOIN `v_c_cabin_type_i18n` c ON b.type_code=c.type_code WHERE  c.i18n='en' AND a.id=".$id;
		$result = Yii::$app->db->createCommand($sql)->queryOne();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	
	//获取优惠政策
	public function actionGetstrategydata(){
		$voyage_code = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		$sql = "SELECT a.id,b.strategy_name FROM `v_c_preferential_way` a LEFT JOIN `v_c_preferential_way_i18n` b ON a.id=b.p_w_id WHERE b.i18n='en' AND a.status=1";
		//$strategy_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT a.id,b.strategy_name FROM `v_c_preferential_way` a 
				LEFT JOIN `v_c_preferential_way_i18n` b ON a.id=b.p_w_id 
				WHERE b.i18n='en' AND a.status=1 AND a.id not in (select p_w_id from `v_c_preferential_strategy` c WHERE c.voyage_code='{$voyage_code}')";
		$no_strategy_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$arr = array();
		//$arr['strategy_result'] = $strategy_result; 
		$arr['no_strategy_result'] = $no_strategy_result;
		if($arr){
			echo json_encode($arr);
		}  else {
			echo 0;
		}
	}
	
	//船舱定价-》优惠政策数据保存
	public function actionPreferentialpoliciessubmit(){
		$db = Yii::$app->db;
		$res = 0;
		$sub_id = isset($_GET['sub_id'])?$_GET['sub_id']:0;
		$voyage_code = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		$strategy = isset($_GET['strategy'])?$_GET['strategy']:'0';
		$price = isset($_GET['price'])?$_GET['price']:'0';
		$s_price = isset($_GET['s_price'])?$_GET['s_price']:'0';
		//$s_where = isset($_GET['s_where'])?$_GET['s_where']:'';
		
		$sql = "SELECT p_where FROM `v_c_preferential_way` WHERE id=".$strategy." LIMIT 1";
		$way_result = Yii::$app->db->createCommand($sql)->queryOne();
		$s_where = $way_result['p_where'];
		
		if($sub_id != 0){
			$sql = "UPDATE `v_c_preferential_strategy` set voyage_code='$voyage_code',p_w_id='$strategy',p_price='$price',s_p_price='$s_price',p_where='$s_where' WHERE id=".$sub_id;
		}else{
			$sql = "INSERT INTO `v_c_preferential_strategy` (voyage_code,p_w_id,p_price,s_p_price,p_where) VALUES ('$voyage_code','$strategy','$price','$s_price','$s_where')";
		}
		
		//事务处理
		$transaction=$db->beginTransaction();
		try{
			Yii::$app->db->createCommand($sql)->execute();
			$transaction->commit();
			$res = 1;
		}catch(Exception $e){
			$transaction->rollBack();
			$res =0;
		}
		
		echo $res;
	}
	
	
	
	//获取船舱定价-》优惠政策单条数据
	public function actionGetpreferentialpoliciesdata(){
		$id = isset($_GET['id'])?$_GET['id']:'0';
		$sql = "SELECT a.*,c.strategy_name FROM `v_c_preferential_strategy` a 
				LEFT JOIN `v_c_preferential_way` b ON a.p_w_id=b.id
				LEFT JOIN `v_c_preferential_way_i18n` c ON b.id=c.p_w_id WHERE c.i18n='en' AND a.id=".$id;
		$result = Yii::$app->db->createCommand($sql)->queryOne();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	//船舱定价-》优惠政策删除
	public function actionPreferentialpoliciesdelete(){
		if(isset($_GET['id'])){
			$id = isset($_GET['id'])?$_GET['id']:'0';
			$sql = "DELETE FROM `v_c_preferential_strategy` WHERE id = '{$id}'";
			$count = Yii::$app->db->createCommand($sql)->execute();
		
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['cabin_pricing']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
	}
	
	
	//船舱定价-》附加费添加页面
	public function actionSurchargeadd(){
		$db = Yii::$app->db;
		if($_POST){
			$voyage_code = isset($_POST['voyage'])?$_POST['voyage']:0;
			$su = isset($_POST['su'])?$_POST['su']:'';
			$data = '';
			foreach ($su as $k=>$v){
				$data .= '("'.$voyage_code.'","'.$v.'"),';
			}
			$data = trim($data,',');
			$sql = "INSERT INTO `v_c_surcharge` (voyage_code,cost_id) VALUES ".$data;
			//事务处理
			$transaction=$db->beginTransaction();
			try{Yii::$app->db->createCommand($sql)->execute();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['cabinpricing']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
		
		$sql = "SELECT a.voyage_code,b.voyage_name,b.i18n FROM `v_c_voyage` a LEFT JOIN `v_c_voyage_i18n` b ON a.voyage_code=b.voyage_code  WHERE b.i18n='en'";
		$voyage_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT cost_id FROM `v_c_surcharge` WHERE voyage_code='{$voyage_result[0]['voyage_code']}'";
		$really_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT a.id,b.cost_name FROM `v_c_surcharge_lib` a LEFT JOIN `v_c_surcharge_lib_i18n` b ON a.id=b.cost_id WHERE a.status=1 AND b.i18n='en'";
		$surcharge_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		return $this->render("surcharge_add",['really_result'=>$really_result,'voyage_result'=>$voyage_result,'surcharge_result'=>$surcharge_result]);
	}
	
	
	//船舱定价-》附加费删除
	public function actionSurchargedelete(){
		if(isset($_GET['id'])){
			$id = isset($_GET['id'])?$_GET['id']:'0';
			$sql = "DELETE FROM `v_c_surcharge` WHERE id = '{$id}'";
			$count = Yii::$app->db->createCommand($sql)->execute();
		
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['cabinpricing']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
	}
	
	
	//船舱定价-》观光路线添加页面
	public function actionTouradd(){
		$db = Yii::$app->db;
		if($_POST){
			//var_dump($_POST);exit;
			$voyage_code = isset($_POST['voyage'])?$_POST['voyage']:0;
			$tour = isset($_POST['tour'])?$_POST['tour']:'';
			$data = '';
			foreach ($tour as $k=>$v){
				$data .= '("'.$voyage_code.'","'.$v.'"),';
			}
			$data = trim($data,',');
			$sql = "INSERT INTO `v_c_shore_excursion` (voyage_code,sh_id) VALUES ".$data;
			//事务处理
			$transaction=$db->beginTransaction();
			try{Yii::$app->db->createCommand($sql)->execute();
			$transaction->commit();
			Helper::show_message('Save success  ', Url::toRoute(['cabinpricing']));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
	
		$sql = "SELECT a.voyage_code,b.voyage_name,b.i18n FROM `v_c_voyage` a LEFT JOIN `v_c_voyage_i18n` b ON a.voyage_code=b.voyage_code  WHERE b.i18n='en'";
		$voyage_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT a.id,b.se_name FROM `v_c_shore_excursion_lib` a LEFT JOIN `v_c_shore_excursion_lib_i18n` b ON a.se_code=b.se_code WHERE a.status=1 AND b.i18n='en'";
		$tour_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT sh_id FROM `v_c_shore_excursion` WHERE voyage_code='{$voyage_result[0]['voyage_code']}'";
		$really_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		return $this->render("tour_add",['really_result'=>$really_result,'voyage_result'=>$voyage_result,'tour_result'=>$tour_result]);
	}
	
	
	//船舱定价-》观光路线
	public function actionTourdelete(){
		if(isset($_GET['id'])){
			$id = isset($_GET['id'])?$_GET['id']:'0';
			$sql = "DELETE FROM `v_c_shore_excursion` WHERE id = '{$id}'";
			$count = Yii::$app->db->createCommand($sql)->execute();
		
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['cabinpricing']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}
	}
	
	
	//船舱定价-》船舱定价 改变航线获取船舱定价
	public function actionCabinpricingto(){
		$voyage = isset($_GET['voyage'])?$_GET['voyage']:0;
		$sql = "SELECT a.*,c.type_name FROM `v_c_cabin_pricing` a LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id LEFT JOIN `v_c_cabin_type_i18n` c ON b.type_code=c.type_code  WHERE a.voyage_code='$voyage'";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	//船舱定价-》优惠政策 改变航线获取优惠政策
	public function actionPreferentialpoliciesto(){
		$voyage = isset($_GET['voyage'])?$_GET['voyage']:0;
		$sql = "SELECT a.*,c.strategy_name FROM `v_c_preferential_strategy` a LEFT JOIN `v_c_preferential_way` b ON a.p_w_id=b.id LEFT JOIN `v_c_preferential_way_i18n` c ON b.id=c.p_w_id  WHERE c.i18n='en' AND a.status=1 AND b.status=1 AND a.voyage_code = '$voyage'";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	//船舱定价-》附加费改变航线获取附加费
	public function actionSurchargeto(){
		$voyage = isset($_GET['voyage'])?$_GET['voyage']:0;
		$sql = "SELECT a.id,c.cost_name FROM `v_c_surcharge` a LEFT JOIN `v_c_surcharge_lib` b ON a.cost_id=b.id LEFT JOIN `v_c_surcharge_lib_i18n` c ON b.id=c.cost_id WHERE a.status=1 AND b.status =1 AND c.i18n = 'en' AND a.voyage_code='$voyage'";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	//船舱定价-》观光路线改变航线获取观光路线
	public function actionTourto(){
		$voyage = isset($_GET['voyage'])?$_GET['voyage']:0;
		$sql = "SELECT a.id,c.se_name FROM `v_c_shore_excursion` a LEFT JOIN `v_c_shore_excursion_lib` b ON a.sh_id=b.id LEFT JOIN `v_c_shore_excursion_lib_i18n` c ON b.se_code=c.se_code WHERE a.status=1 AND b.status =1 AND c.i18n = 'en' AND a.voyage_code='$voyage'";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	
	//船舱定价-》附加费添加页面航线改变获取 附加费已选值 及附加费库
	public function actionGetsurchargedata(){
		$voyage = isset($_GET['voyage'])?$_GET['voyage']:'';
		
		$sql = "SELECT cost_id FROM `v_c_surcharge` WHERE voyage_code='{$voyage}'";
		$really_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT a.id,b.cost_name FROM `v_c_surcharge_lib` a LEFT JOIN `v_c_surcharge_lib_i18n` b ON a.id=b.cost_id WHERE a.status=1 AND b.i18n='en'";
		$surcharge_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$arr = array();
		$arr['really'] = $really_result;
		$arr['result'] = $surcharge_result;
		if($arr){
			echo json_encode($arr);
		}  else {
			echo 0;
		}
		
	}
	
	//船舱定价-》观光路线添加页面航线改变获取 观光路线已选值及观光路线库
	public function actionGettourdata(){
		$voyage = isset($_GET['voyage'])?$_GET['voyage']:'';
		
		$sql = "SELECT sh_id FROM `v_c_shore_excursion` WHERE voyage_code='{$voyage}'";
		$really_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$sql = "SELECT a.id,b.se_name FROM `v_c_shore_excursion_lib` a LEFT JOIN `v_c_shore_excursion_lib_i18n` b ON a.se_code=b.se_code WHERE a.status=1 AND b.i18n='en'";
		$tour_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$arr = array();
		$arr['really'] = $really_result;
		$arr['result'] = $tour_result;
		if($arr){
			echo json_encode($arr);
		}  else {
			echo 0;
		}
	}
	
	
	
	
	
}