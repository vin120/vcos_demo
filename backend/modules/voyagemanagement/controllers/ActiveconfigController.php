<?php

namespace app\modules\voyagemanagement\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;
use app\modules\voyagemanagement\models\VCActive;
use app\modules\voyagemanagement\models\VCActiveI18n;
use app\modules\voyagemanagement\models\VCActiveDetail;
use app\modules\voyagemanagement\models\VCActiveDetailI18n;
use yii\db\Query;

class ActiveconfigController extends Controller
{

	public function actionActiveconfig()
	{
		if(isset($_GET['active_id'])){
			$active_id = $_GET['active_id'];
			VCActive::deleteAll(['active_id'=>$active_id]);
			VCActiveI18n::deleteAll(['active_id'=>$active_id]);
			Helper::show_message('Delete successful ', Url::toRoute(['activeconfig']));
		}

		if(isset($_POST['ids'])){
			$ids = implode(',', $_POST['ids']);
			VCActive::deleteAll("active_id in ($ids)");
			VCActiveI18n::deleteAll("active_id in ($ids)");
			Helper::show_message('Delete successful ', Url::toRoute(['activeconfig']));
		}
		
		$query  = new Query();
		$actives = $query->select(['v_c_active.*','v_c_active_i18n.name','v_c_active_i18n.i18n'])
				->from('v_c_active')
				->join('LEFT JOIN','v_c_active_i18n','v_c_active.active_id=v_c_active_i18n.active_id')
				->where(['v_c_active_i18n.i18n'=>'en'])
				->limit(2)
				->all();
				
		$count = VCActive::find()->count();
		return $this->render("active_config",['actives'=>$actives,'count'=>$count,'active_page'=>1]);
	}


	//活动分页
	public function actionGetactivepage()
	{
		$pag = isset($_GET['pag']) ? $_GET['pag']==1 ? 0 :($_GET['pag']-1) * 2 : 0;
		
		$query  = new Query();
		$result = $query->select(['a.*','b.name'])
				->from('v_c_active a')
				->join('LEFT JOIN','v_c_active_i18n b','a.active_id=b.active_id')
				->where(['b.i18n'=>'en'])
				->offset($pag)
				->limit(2)
				->all();

		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
	}
	
	//详细活动分页
	public function actionGetactiveconfigpage()
	{
		$pag = isset($_GET['pag']) ? $_GET['pag']==1 ? 0 :($_GET['pag']-1) * 2 : 0;
		$active_id = isset($_GET['active_id']) ? $_GET['active_id'] : '';
		$query  = new Query();
		$result = $query->select(['a.id','a.day_from','a.day_to','b.detail_title','b.detail_desc'])
				->from('v_c_active_detail a')
				->join('LEFT JOIN','v_c_active_detail_i18n b','a.id=b.active_detail_id')
				->where(['b.i18n'=>'en','a.active_id'=>$active_id])
				->offset($pag)
				->limit(2)
				->all();

		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
	}
	
	
	//Active Config Add
	public function actionActiveconfigadd()
	{	
		if(isset($_POST)){
			$name = isset($_POST['name']) ? $_POST['name'] : '';
			$active_select = isset($_POST['active_select']) ? $_POST['active_select'] : '';
			if($name != '' && $active_select != ''){
				$transaction = Yii::$app->db->beginTransaction();
				try{
					$vcactive = new VCActive();
					$vcactive->status = $active_select;
					$vcactive->save();
					$last_active_id = Yii::$app->db->getLastInsertID();
						
					$vcactivei18n = new VCActiveI18n();
					$vcactivei18n->active_id = $last_active_id;
					$vcactivei18n->name = $name;
					$vcactivei18n->i18n = 'en';
					$vcactivei18n->save();
					
					Helper::show_message('Save successful', Url::toRoute(['activeconfigedit'])."&active_id=".$last_active_id);
					$transaction->commit();
				}catch (Exception $e){
					$transaction->rollBack();
					Helper::show_message('Save failed', Url::toRoute(['activeconfigadd']));
				}
			}
		}
		return $this->render("active_config_add");
	}


	//Active Config Edit
	public function actionActiveconfigedit()
	{
		//获取编辑页面的信息
		$active_id = isset($_GET['active_id']) ? $_GET['active_id'] : '';
		
		$query  = new Query();
		$active = $query->select(['a.active_id','a.status','b.name'])
				->from('v_c_active a')
				->join('LEFT JOIN','v_c_active_i18n b','a.active_id=b.active_id')
				->where(['a.active_id'=>$active_id,'b.i18n'=>'en'])
				->one();
		$count = VCActiveDetail::find()->where(['active_id'=>$active_id])->count();
		
		
		//更新编辑页面的信息
		if(isset($_POST)){
			$name = isset($_POST['name']) ? $_POST['name'] : '';
			$active_select = isset($_POST['active_select']) ? $_POST['active_select'] : '';
			$active_id_post = isset($_POST['active_id']) ? $_POST['active_id'] : '';
			if($name != '' && $active_select != '' && $active_id_post){
				$transaction = Yii::$app->db->beginTransaction();
				try{
					VCActive::updateAll(['status'=>$active_select],['active_id'=>$active_id_post]);
					VCActiveI18n::updateAll(['name'=>$name],['active_id'=>$active_id_post,'i18n'=>'en']);
					Helper::show_message('Save successful', Url::toRoute(['activeconfigedit'])."&active_id=".$active_id_post);
					$transaction->commit();
				}catch (Exception $e){
					$transaction->rollBack();
					Helper::show_message('Save failed', Url::toRoute(['activeconfigedit'])."&active_id=".$active_id_post);
				}
			}
		}
		
		return $this->render("active_config_edit",['active'=>$active,'count'=>$count,'active_config_page'=>1]);
	}

	//ajax获取active_config_edit页面的active_detail内容
	public  function actionGetactiveconfigdetailajax()
	{
		$active_id = isset($_GET['active_id']) ? $_GET['active_id'] : '';
		
		$query  = new Query();
		$active_detail = $query->select(['a.id','a.day_from','a.day_to','b.detail_title','b.detail_desc'])
				->from('v_c_active_detail a')
				->join('LEFT JOIN','v_c_active_detail_i18n b','a.id=b.active_detail_id')
				->where(['a.active_id'=>$active_id,'b.i18n'=>'en'])
				->limit(2)
				->all();
		echo json_encode($active_detail);
	}
	
	
	public function actionActiveconfigdetailadd()
	{
		$active_id = isset($_GET['active_id']) ? $_GET['active_id'] : '';
		$active = VCActive::find()->select(['active_id'])->where(['active_id'=>$active_id])->one();
		if($_POST){
			$day_from = isset($_POST['day_from']) ? $_POST['day_from'] : '';
			$day_to = isset($_POST['day_to']) ? $_POST['day_to'] : '';
			$active_id_post = isset($_POST['active_id']) ? $_POST['active_id'] : '';
			$detail_title = isset($_POST['detail_title']) ? $_POST['detail_title'] : '';
			$detail_desc = isset($_POST['detail_desc']) ? $_POST['detail_desc'] : '';
			
			if($_FILES['photoimg']['error']!=4){
				$result=Helper::upload_file('photoimg', Yii::$app->params['img_save_url'].'voyagemanagement/themes/basic/static/upload/'.date('Ym',time()), 'image', 3);
				$photo=date('Ym',time()).'/'.$result['filename'];
			}
			if(!isset($photo)){
				$photo="";
			}
			if($day_from != '' && $detail_title != ''){
				//事务
				$transaction = Yii::$app->db->beginTransaction();
				try{
					$vcactivedetail_obj = new VCActiveDetail();
					$vcactivedetail_obj->active_id = $active_id_post;
					$vcactivedetail_obj->day_from = $day_from;
					if($day_to !=''){
						$vcactivedetail_obj->day_to = $day_to;
					}
					$vcactivedetail_obj->detail_img = $photo;
					$vcactivedetail_obj->save();

					$last_active_detail_id = Yii::$app->db->getLastInsertID();
					
					$vcactivedetaili18n_obj = new VCActiveDetailI18n();
					$vcactivedetaili18n_obj->active_detail_id = $last_active_detail_id;
					$vcactivedetaili18n_obj->detail_title = $detail_title;
					$vcactivedetaili18n_obj->detail_desc = $detail_desc;
					$vcactivedetaili18n_obj->i18n = 'en';
					$vcactivedetaili18n_obj->save();
					
					$transaction->commit();
					Helper::show_message('Save success ', Url::toRoute(['activeconfigedit'])."&active_id=".$active_id_post);
				}catch(Exception $e){
					$transaction->rollBack();
					Helper::show_message('Save failed  ','#');
				}
			}else{
				Helper::show_message('Save failed  ','#');
			}
		}
		
		return $this->render("active_config_detail_add",['active'=>$active]);
	}
	
	public function actionActiveconfigdetailedit()
	{
		
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$active_id = isset($_GET['active_id']) ? $_GET['active_id'] : '';
		
		$query  = new Query();
		$active_detail = $query->select(['a.id','a.active_id','a.day_from','a.day_to','a.detail_img','b.detail_title','b.detail_desc'])
				->from('v_c_active_detail a')
				->join('LEFT JOIN','v_c_active_detail_i18n b','a.id=b.active_detail_id')
				->where(['a.id'=>$id,'b.i18n'=>'en','a.active_id'=>$active_id])
				->one();

		if(isset($_POST)){
			$day_from = isset($_POST['day_from']) ? $_POST['day_from'] : '';
			$day_to = isset($_POST['day_to']) ? $_POST['day_to'] : '';
			$detail_title = isset($_POST['detail_title']) ? $_POST['detail_title'] : '';
			$detail_desc = isset($_POST['detail_desc']) ? $_POST['detail_desc'] : '';
			$active_id_post = isset($_POST['active_id']) ? $_POST['active_id'] : '';
			$active_detail_id = isset($_POST['active_detail_id']) ? $_POST['active_detail_id'] :'';
			
			if(isset($_FILES['photoimg'])){
				if($_FILES['photoimg']['error']!=4){
					$result=Helper::upload_file('photoimg', Yii::$app->params['img_save_url'].'voyagemanagement/themes/basic/static/upload/'.date('Ym',time()), 'image', 3);
					$photo=date('Ym',time()).'/'.$result['filename'];
				}
				if(!isset($photo)){
					$photo=null;
				}
			}
			
			if($day_from != '' && $detail_title != '' && $active_detail_id !=''){
				$transaction = Yii::$app->db->beginTransaction();
				try{
					$vcactivedetail_obj = VCActiveDetail::findOne($active_detail_id);
					$vcactivedetail_obj->day_from = $day_from;
					$vcactivedetail_obj->detail_img = $photo;
					if($day_to != ''){
						$vcactivedetail_obj->day_to = $day_to;
					}
					$vcactivedetail_obj->save();

					$vcactivedetaili18n_obj = VCActiveDetailI18n::find()->where(['active_detail_id'=>$active_detail_id,'i18n'=>'en'])->one();
					$vcactivedetaili18n_obj->detail_title = $detail_title;
					$vcactivedetaili18n_obj->detail_desc = $detail_desc;
					$vcactivedetaili18n_obj->save();
					
					Helper::show_message('Save successful', Url::toRoute(['activeconfigedit'])."&active_id=".$active_id_post);
					$transaction->commit();
				}catch (Exception $e){
					$transaction->rollBack();
					Helper::show_message('Save failed', Url::toRoute(['activeconfigedit'])."&active_id=".$active_id_post);
				}
			}
		}
		
		return $this->render("active_config_detail_edit",['active_detail'=>$active_detail]);
	}
	
	//Delete Active Config Detail
	public function actionActiveconfigdetaildelete()
	{
		//单项删除
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$active_id = $_GET['active_id'];
			VCActiveDetail::deleteAll(['id'=>$id]);
			VCActiveDetailI18n::deleteAll(['active_detail_id'=>$id]);
			Helper::show_message('Delete successful', Url::toRoute(['activeconfigedit'])."&active_id=".$active_id);
		}
		
		//选中删除
		if(isset($_POST['ids'])){
			$ids = implode(',', $_POST['ids']);
			$active_id = $_POST['active_id'];
			VCActiveDetail::deleteAll("id in ($ids)");
			VCActiveDetailI18n::deleteAll("active_detail_id in ($ids)");
			VCActive::deleteAll("active_id in ($ids)");
			VCActiveI18n::deleteAll("active_id in ($ids)");
		
			Helper::show_message('Delete successful ', Url::toRoute(['activeconfigedit'])."&active_id=".$active_id);
		}
	}
	
}