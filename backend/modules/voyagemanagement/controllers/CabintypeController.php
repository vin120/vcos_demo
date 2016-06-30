<?php

namespace app\modules\voyagemanagement\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;
use app\modules\voyagemanagement\models\VCCabinType;
use app\modules\voyagemanagement\models\VCCabinTypeI18n;
use app\modules\voyagemanagement\models\VCCabinTypeGraphic;
use app\modules\voyagemanagement\models\VCCabinTypeGraphicI18n;

class CabintypeController extends Controller
{

	//cabin type
	public function actionCabintype(){
		if(isset($_GET['code'])){
			$code = isset($_GET['code'])?$_GET['code']:'';
			$sql = "SELECT id FROM `v_c_cabin_type` WHERE type_code='{$code}'";
			$id = Yii::$app->db->createCommand($sql)->queryOne();
			$id = $id['id'];
			//var_dump($id);exit;
			//判断是否其他地方正在使用当前船舱类型
			$sql = "select t1.num1,t2.num2,t3.num3,t4.num4 from
			(select count(*) num1 from `v_c_cabin_type_graphic` WHERE type_id='{$id}') t1,
			(select count(*) num2 from `v_c_cabin_lib` WHERE cabin_type_id='{$id}') t2,
			(select count(*) num3 from `v_c_cabin_pricing` WHERE cabin_type_id='{$id}') t3,
			(select count(*) num4 from `v_c_voyage_cabin` WHERE cabin_type_id='{$id}') t4";
			
			$counts = Yii::$app->db->createCommand($sql)->queryOne();
			$count_num = (int)$counts['num1']+(int)$counts['num2']+(int)$counts['num3']+(int)$counts['num4'];
			
			if($count_num>0){
				Helper::show_message('Delete failed,This type is being used ');
			}else{
				$sql = "DELETE FROM `v_c_cabin_type_attr_relation` WHERE type_id=".$id;
				Yii::$app->db->createCommand($sql)->execute();
				$sql = "DELETE FROM `v_c_cabin_type` WHERE type_code = '{$code}'";
				$count = Yii::$app->db->createCommand($sql)->execute();
				$sql = "DELETE FROM `v_c_cabin_type_i18n` WHERE type_code = '{$code}'";
				Yii::$app->db->createCommand($sql)->execute();
				
				if($count>0){
					Helper::show_message('Delete the success ', Url::toRoute(['cabintype']));
				}else{
					Helper::show_message('Delete failed ');
				}
			}
		}
		/*if(isset($_POST['ids'])){
			$ids = implode('\',\'', $_POST['ids']);
			$sql = "DELETE FROM `v_c_cabin_type` WHERE type_code in ('$ids')";
			$count = Yii::$app->db->createCommand($sql)->execute();
			$sql = "DELETE FROM `v_c_cabin_type_i18n` WHERE type_code in ('$ids')";
			Yii::$app->db->createCommand($sql)->execute();
			if($count>0){
				Helper::show_message('Delete the success ', Url::toRoute(['cabin_type']));
			}else{
				Helper::show_message('Delete failed ');
			}
		}*/
		$where = '';
		$w_name = '';
		$w_state = 2;
		
		if(isset($_POST['w_submit'])){
			$w_name = isset($_POST['w_name'])?$_POST['w_name']:'';
			$w_state = isset($_POST['w_state'])?$_POST['w_state']:2;
			if($w_name!=''){
				$where .= "b.type_name like '%{$w_name}%' AND ";
			}
			if($w_state!=2){
				$where .= "a.type_status=".$w_state." AND ";
			}
			$where = trim($where,'AND ');
		}
		if($where==''){$where = 1;}
		
		$sql = "SELECT count(*) count FROM `v_c_cabin_type` a LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code WHERE b.i18n='en' AND ".$where;
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		$sql = "SELECT a.*,b.type_name,b.floor,b.i18n FROM `v_c_cabin_type` a LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code WHERE b.i18n='en' AND ".$where." limit 2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("cabin_type",['w_name'=>$w_name,'w_state'=>$w_state,'cabin_type_result'=>$result,'cabin_type_count'=>$count['count'],'cabin_type_pag'=>1]);
	}
	
	//cabin type分页
	public function actionGetcabintypepage(){
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		$w_name = isset($_GET['w_name'])?$_GET['w_name']:'';
		$w_state = isset($_GET['w_state'])?$_GET['w_state']:2;
		$where = '';
		if($w_name!=''){
			$where .= "b.type_name like '%{$w_name}%' AND ";
		}
		if($w_state!=2){
			$where .= "a.type_status=".$w_state." AND ";
		}
		$where = trim($where,'AND ');
		if($where==''){$where = 1;}
		$sql = "SELECT a.*,b.type_name,b.floor,b.i18n FROM `v_c_cabin_type` a LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code WHERE b.i18n='en' AND ".$where." limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	
	}
	
	//cabin_type_add
	public function actionCabintypeadd(){
		$db = Yii::$app->db;
		$cabin_type = new VCCabinType();
		$cabin_type_language = new VCCabinTypeI18n();
		if($_POST){
			$att_str = '';
			$att = isset($_POST['att'])?$_POST['att']:'';
			$code = isset($_POST['code'])?addslashes($_POST['code']):'';
			$cruise_code = Yii::$app->params['cruise_code'];
			$state = isset($_POST['state'])?$_POST['state']:'0';
			$name = isset($_POST['name'])?addslashes($_POST['name']):'';
			$live_number = isset($_POST['live_number'])?$_POST['live_number']:'';
			$beds = isset($_POST['beds'])?$_POST['beds']:'';
			$room_min = isset($_POST['room_min'])?$_POST['room_min']:'';
			$room_max = isset($_POST['room_max'])?$_POST['room_max']:'';
			$floor = isset($_POST['floor'])?$_POST['floor']:'';
			$location = isset($_POST['location'])?$_POST['location']:'';
			
			$cabin_type->type_code = $code;
			$cabin_type->type_status = $state;
			$cabin_type->cruise_code = $cruise_code;
			$cabin_type->live_number = $live_number;
			$cabin_type->room_area = $room_min.'-'.$room_max;
			$cabin_type->beds = $beds;
			$cabin_type->location = $location;
			
			$cabin_type_language->type_code = $code;
			$cabin_type_language->type_name = $name;
			$cabin_type_language->floor = $floor;
			$cabin_type_language->i18n = 'en';
			 
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$cabin_type->save();
				$cabin_type_language->save();
				$id = $cabin_type->attributes['id'];
				if($att!=''){
					foreach ($att as $k=>$v){
						if($v!=0)
							$att_str .= '('.$id.','.$v.'),';
					}
					$att_str = trim($att_str,',');
					if($att_str!=''){
						$sql = "INSERT INTO `v_c_cabin_type_attr_relation` (type_id,type_attr_id) VALUES ".$att_str;
						Yii::$app->db->createCommand($sql)->execute();
					}
				}
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['cabintypeedit','code'=>$code]));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
		$sql = "SELECT a.*,b.att_name FROM `v_c_cabin_type_attr` a LEFT JOIN `v_c_cabin_type_attr_i18n` b ON a.id=b.att_id WHERE b.i18n='en'";
		$type_attr = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("cabin_type_add",['type_attr'=>$type_attr]);
	}
	
	//cabin_type_edit
	public function actionCabintypeedit(){
		$db = Yii::$app->db;
		$old_code=$_GET['code'];
		$sql = "SELECT a.*,b.type_name,b.floor,b.i18n FROM `v_c_cabin_type` a LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code WHERE b.i18n='en' AND a.type_code = '$old_code'";
		$result = Yii::$app->db->createCommand($sql)->queryOne();
		
		$sql = "SELECT a.*,b.att_name,c.type_id FROM `v_c_cabin_type_attr` a 
		LEFT JOIN `v_c_cabin_type_attr_i18n` b ON a.id=b.att_id 
		LEFT JOIN `v_c_cabin_type_attr_relation` c ON a.id=c.type_attr_id AND c.type_id=".$result['id']."
		WHERE b.i18n='en'";
		$type_attr = Yii::$app->db->createCommand($sql)->queryAll();
		
		$graphic_count = VCCabinTypeGraphic::find()->andWhere(['type_id' => $result['id']])->count('id');;
		$sql = "SELECT a.*,b.graphic_desc,b.graphic_img FROM `v_c_cabin_type_graphic` a LEFT JOIN `v_c_cabin_type_graphic_i18n` b ON a.id=b.graphic_id WHERE b.i18n='en' AND a.type_id=".$result['id']." Limit 2 ";
		$graphic_result = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("cabin_type_edit",['graphic_pag'=>1,'cabin_type_graphic_count'=>$graphic_count,'graphic_result'=>$graphic_result,'type_attr'=>$type_attr,'cabin_type_result'=>$result]);
	}
	
	//cabin_type_save_edit
	public function actionCabintypesaveedit(){
		$db = Yii::$app->db;
		$old_code=$_GET['code'];
		$att_str = '';
		$att = isset($_POST['att'])?$_POST['att']:'';
		$code = isset($_POST['code'])?addslashes($_POST['code']):'';
		$cruise_code = Yii::$app->params['cruise_code'];
		$state = isset($_POST['state'])?$_POST['state']:'0';
		$name = isset($_POST['name'])?addslashes($_POST['name']):'';
		$live_number = isset($_POST['live_number'])?$_POST['live_number']:'';
		$beds = isset($_POST['beds'])?$_POST['beds']:'';
		$room_min = isset($_POST['room_min'])?$_POST['room_min']:'';
		$room_max = isset($_POST['room_max'])?$_POST['room_max']:'';
		$floor = isset($_POST['floor'])?$_POST['floor']:'';
		$location = isset($_POST['location'])?$_POST['location']:'';
		$room_area = $room_min.'-'.$room_max;
		
		//事务处理
		$transaction=$db->beginTransaction();
		try{
			$sql = "SELECT id FROM `v_c_cabin_type` WHERE type_code='$old_code'";
			$id = Yii::$app->db->createCommand($sql)->queryOne();
			$sql = "DELETE FROM `v_c_cabin_type_attr_relation` WHERE type_id=".$id['id'];
			Yii::$app->db->createCommand($sql)->execute();
			if($att!=''){
				foreach ($att as $k=>$v){
					if($v!=0)
						$att_str .= '('.$id['id'].','.$v.'),';
				}
				$att_str = trim($att_str,',');
				$sql = "INSERT INTO `v_c_cabin_type_attr_relation` (type_id,type_attr_id) VALUES ".$att_str;
				Yii::$app->db->createCommand($sql)->execute();
			}
			$sql = "UPDATE `v_c_cabin_type` set type_code='$code',live_number='$live_number',room_area='$room_area',beds='$beds',location='$location',cruise_code='$cruise_code',type_status='$state' WHERE type_code='$old_code'";
			Yii::$app->db->createCommand($sql)->execute();
			$sql = "UPDATE `v_c_cabin_type_i18n` set type_code='$code',type_name='$name',floor='$floor',i18n='en' WHERE type_code='$old_code'";
			Yii::$app->db->createCommand($sql)->execute();
			
			//修改船舱表入住人数和床位数
			$sql = "UPDATE `v_c_cabin_lib` set max_check_in='$beds',last_aduits_num='$live_number' WHERE cabin_type_id=".$id['id'];
			Yii::$app->db->createCommand($sql)->execute();
			
			//修改船舱价格表床位数
			$sql = "UPDATE `v_c_cabin_pricing` set check_num='{$beds}' WHERE cabin_type_id='{$id['id']}'";
			Yii::$app->db->createCommand($sql)->execute();
			
			$transaction->commit();
			Helper::show_message('Save success  ', Url::toRoute(['cabintypeedit','code'=>$code]));
		}catch(Exception $e){
			$transaction->rollBack();
			Helper::show_message('Save failed  ','#');
		}
	}
	
	
	//cbain_type type_code验证
	public function actionCabintypecodecheck(){
		$code = isset($_GET['code'])?$_GET['code']:'';
		$act = isset($_GET['act'])?$_GET['act']:2;
		$id = isset($_GET['id'])?$_GET['id']:'';
		if($act == 1){
			//edit
			$sql = "SELECT count(*) count FROM `v_c_cabin_type` WHERE type_code='$code' AND id!=$id";
			$result = Yii::$app->db->createCommand($sql)->queryOne();
			$count = $result['count'];
		}else{
			//add
			$count = VCCabinType::find()->where(['type_code' => $code])->count();
		}
		if($count==0){
			echo 0;
		}else{
			echo 1;
		}
	}
	
	
	
	
	//graphic 
	public function actionCabintypegraphicadd(){
		$db = Yii::$app->db;
		$id = isset($_GET['id'])?$_GET['id']:0;
		$graphic = new VCCabinTypeGraphic();
		$graphic_language = new VCCabinTypeGraphicI18n();
		if($_POST){
			$type_id = isset($_POST['type_id'])?$_POST['type_id']:0;
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			if($_FILES['photoimg']['error']!=4){
				$result=Helper::upload_file('photoimg', Yii::$app->params['img_save_url'].'voyagemanagement/themes/basic/static/upload/'.date('Ym',time()), 'image', 3);
				$photo=date('Ym',time()).'/'.$result['filename'];
			}
			
			$graphic->type_id = $type_id;
			$graphic->status = 1;
			
			$graphic_language->graphic_desc = $desc;
			$graphic_language->graphic_img = $photo;
			$graphic_language->i18n = 'en';
			
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$graphic->save();
				$g_id = $graphic->attributes['id'];
				$graphic_language->graphic_id = $g_id;
				$graphic_language->save();
				$sql = "SELECT type_code FROM `v_c_cabin_type` WHERE id=".$type_id;
				$code = Yii::$app->db->createCommand($sql)->queryOne();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['cabintypeedit','code'=>$code['type_code']]));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
			
		}
		return $this->render("cabin_type_graphic_add",['id'=>$id]);
	}
	
	
	
	
	public function actionCabintypegraphicedit(){
		
		$db = Yii::$app->db;
		$id=isset($_GET['id'])?$_GET['id']:0;
		if($_POST){
			$desc = isset($_POST['desc'])?addslashes(trim($_POST['desc'])):'';
			$photo = '';
			if($_FILES['photoimg']['error']!=4){
				$result=Helper::upload_file('photoimg', Yii::$app->params['img_save_url'].'voyagemanagement/themes/basic/static/upload/'.date('Ym',time()), 'image', 3);
				$photo=date('Ym',time()).'/'.$result['filename'];
			}
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				if($photo!=''){
					$sql = "UPDATE `v_c_cabin_type_graphic_i18n` set graphic_desc='$desc',graphic_img='{$photo}',i18n='en' WHERE graphic_id=".$id;
				}else{
					$sql = "UPDATE `v_c_cabin_type_graphic_i18n` set graphic_desc='$desc',i18n='en' WHERE graphic_id=".$id;
				}
				Yii::$app->db->createCommand($sql)->execute();
				$sql = "SELECT type_id FROM `v_c_cabin_type_graphic` WHERE id=".$id;
				$type_id = Yii::$app->db->createCommand($sql)->queryOne();
				$sql = "SELECT type_code FROM `v_c_cabin_type` WHERE id=".$type_id['type_id'];
				$code = Yii::$app->db->createCommand($sql)->queryOne();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['cabintypeedit','code'=>$code['type_code']]));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
		
		
		$sql = "SELECT a.*,b.graphic_desc,b.graphic_img FROM `v_c_cabin_type_graphic` a LEFT JOIN `v_c_cabin_type_graphic_i18n` b ON a.id=b.graphic_id WHERE b.i18n='en' AND a.id = '$id'";
		$result = Yii::$app->db->createCommand($sql)->queryOne();
			
		return $this->render("cabin_type_graphic_edit",['graphic_result'=>$result]);
	}
	
	
	
	public function actionCabintypegraphicdel(){
		$id = isset($_GET['id'])?$_GET['id']:'';
		//事务处理
		$db = Yii::$app->db;
		$transaction=$db->beginTransaction();
		try{
			$sql = "SELECT type_id FROM `v_c_cabin_type_graphic` WHERE id=".$id;
			$type_id = Yii::$app->db->createCommand($sql)->queryOne();
			$sql = "SELECT type_code FROM `v_c_cabin_type` WHERE id=".$type_id['type_id'];
			$type_code = Yii::$app->db->createCommand($sql)->queryOne();
			
			$sql = "DELETE FROM `v_c_cabin_type_graphic` WHERE id = '{$id}'";
			$count = Yii::$app->db->createCommand($sql)->execute();
			$sql = "DELETE FROM `v_c_cabin_type_graphic_i18n` WHERE graphic_id = '{$id}'";
			Yii::$app->db->createCommand($sql)->execute();
			
		}catch(Exception $e){
			$transaction->rollBack();
			Helper::show_message('Save failed  ','#');
		}
		if($count>0){
			Helper::show_message('Delete the success ', Url::toRoute(['cabintypeedit','code'=>$type_code['type_code']]));
		}else{
			Helper::show_message('Delete failed ');
			}
		
	}
	
	
	
	public function actionGetcabintypegraphicpage(){
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		$type_id = isset($_GET['type_id'])?$_GET['type_id']:0;
		$sql = "SELECT a.*,b.graphic_desc,b.graphic_img,b.i18n FROM `v_c_cabin_type_graphic` a LEFT JOIN `v_c_cabin_type_graphic_i18n` b ON a.id=b.graphic_id WHERE a.type_id=".$type_id." AND b.i18n='en' limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}