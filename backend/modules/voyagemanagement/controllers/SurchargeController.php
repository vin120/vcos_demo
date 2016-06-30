<?php

namespace app\modules\voyagemanagement\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;
use app\modules\voyagemanagement\models\seletedata;
use app\modules\voyagemanagement\models\VCSurchargeLib;
use app\modules\voyagemanagement\models\VCSurchargeLibI18n;
class SurchargeController extends Controller
{
	public $enableCsrfValidation = false;
	public function actionSurchargeconfig(){
		$db=\Yii::$app->db;
		/* 删除 */
		$del_id=isset($_GET['code'])?$_GET['code']:'';
		if ($del_id!=''){
			$transaction=$db->beginTransaction();
			try{
			$command= \Yii::$app->db->createCommand("delete from v_c_surcharge_lib  where id=$del_id")->execute();
			$command2= \Yii::$app->db->createCommand("delete from v_c_surcharge_lib_i18n  where cost_id=$del_id")->execute();
			$transaction->commit();
			Helper::show_message(\Yii::t('app','Delete success'), Url::toRoute(['surchargeconfig']));
			
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message(\Yii::t('app','Delete fail'),Url::toRoute(['surchargeconfig']));
			}
			}
		
	
			$sql="select *,s.id from v_c_surcharge_lib_i18n si right join v_c_surcharge_lib s on si.cost_id=s.id where si.i18n='en'";
		
		$selectdata=new seletedata();
		$data=$selectdata->paging($sql, $sql);
		return $this->render("surcharge_config",$data);
	}
	public function actionSurchargeoption(){
		$db=\Yii::$app->db;
		if ($_POST){
			$sid=isset($_POST['sid'])?$_POST['sid']:'';
			$surcharge=new VCSurchargeLib();
			$surchargei18n=new VCSurchargeLibI18n();
			//$sdata['voyage_code']=$_POST['voyage_code'];
			$sdata['cost_price']=$_POST['cost_price'];//表v_c_surcharge的数据
			$sidata['cost_name']=$_POST['cost_name'];//表v_c_surcharge的数据
			$sidata['cost_desc']=$_POST['cost_desc'];
			
			if (!is_numeric($sdata['cost_price'])){
			Helper::show_message("Price must be number",Url::toRoute(['surchargeconfig']));
			exit;
			}
			if ($sid==''){//没有sid就插入数据
					//事务处理
    		$transaction=$db->beginTransaction();
            try{
            	$sidata['i18n']="en";//插入时设置
			     $_surcharge = clone $surcharge;
			     $_surcharge->setAttributes($sdata);
			     $_surcharge->save();//插入数据
	             $sidata['cost_id']=$db->getLastInsertID();
              
                $_surchargei18n = clone $surchargei18n;
                $_surchargei18n->setAttributes($sidata);
                $_surchargei18n->save();//插入数据
                $transaction->commit();
	    		Helper::show_message(\Yii::t('app','Save success'), Url::toRoute(['surchargeconfig']));
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(\Yii::t('app','Save failed'),Url::toRoute(['surchargeconfig']));
            }
			}
			else{//有sid就更新数据
				
				$transaction=$db->beginTransaction();
				try{
				VCSurchargeLib::updateAll($sdata,['id'=>$sid]);
				VCSurchargeLibI18n::updateAll($sidata,["cost_id"=>$sid,"i18n"=>"en"]);
				$transaction->commit();
				Helper::show_message(\Yii::t('app','Update success  '), Url::toRoute(['surchargeconfig']));
				}catch(Exception $e){
					$transaction->rollBack();
					Helper::show_message(\Yii::t('app','Update fail  '),Url::toRoute(['surchargeconfig']));
				}
			}
		}
		$id=isset($_GET['id'])?$_GET['id']:'';
		$surchargeinfo=array();
		if ($id!=''){
		$sql="select *,s.id from v_c_surcharge_lib_i18n si  left join v_c_surcharge_lib s on si.cost_id=s.id where i18n='en' and si.cost_id=$id";
		$surchargeinfo=Yii::$app->db->createCommand($sql)->queryAll();
		}
		return $this->render("surcharge_option",array("surchargeinfo"=>$surchargeinfo));
	}
}