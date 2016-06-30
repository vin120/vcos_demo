<?php

namespace travelagent\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;

class ChangingroomController  extends BaseController
{
	public $layout = "myloyout";
	public $enableCsrfValidation = false;
	public function actionChangeroom()
	{
		$vsql="select * from v_c_voyage";
		$voyageinfo=\Yii::$app->db->createCommand($vsql)->queryAll();
		$sql="select vod.*,v.id from v_voyage_order_detail vod left join v_c_voyage v on v.voyage_code=vod.voyage_code where vod.status=0";
		$data=\Yii::$app->db->createCommand($sql)->queryAll();
		$count=sizeof($data);
		for($i=0;$i<sizeof($data);$i++){
			$voyage_id=$data[$i]['id'];
			$voyage_cabin=$data[$i]['cabin_type_code'];
			$voyage_code=$data[$i]['voyage_code'];
			$ordercabinsql="select cabin_name,cabin_type_code from v_voyage_order_detail where voyage_code='$voyage_code'";
			$ordercabin=\Yii::$app->db->createCommand($ordercabinsql)->queryAll();
			$order_cabin=[];
			foreach ($ordercabin as $k=>$v){
				$order_cabin[]=$v['cabin_name'];
			}
			$order_cabin=implode('\',\'',$order_cabin);
			$changcabinsql="select distinct vc.cabin_name, vt.type_code,vc.cabin_name 
	    	from v_c_voyage_cabin vc 
	    	join v_c_cabin_type vt on vc.cabin_type_id=vt.id
	    	join v_c_voyage v on v.id=vc.voyage_id 
	    	join v_voyage_order_detail vod on vod.voyage_code=v.voyage_code and vod.cabin_type_code=vt.type_code
	    	where vc.voyage_id='$voyage_id' and vt.type_code='$voyage_cabin' and vc.cabin_name not in('$order_cabin')";
			$changcabin=\Yii::$app->db->createCommand($changcabinsql)->queryAll();
			$data[$i]['changcabin']=$changcabin;
		}
		
		return $this->render("changeroom",['data'=>$data,'voyageinfo'=>$voyageinfo,'count'=>$count]);
	}
	public function actionChangeownroom(){
		$cabin_name=isset($_POST['cabin_name'])?$_POST['cabin_name']:'';
		$voyage_code=isset($_POST['voyage_code'])?$_POST['voyage_code']:'';
		$cabin_type_code=isset($_POST['cabin_type_code'])?$_POST['cabin_type_code']:'';
		$owncabin_name=isset($_POST['owncabin_name'])?$_POST['owncabin_name']:'';
		$sql="update v_voyage_order_detail set cabin_name='$cabin_name' where voyage_code='$voyage_code' and cabin_type_code='$cabin_type_code' and cabin_name='$owncabin_name'";
	
		$vticketsql="update v_c_voyage_ticket set cabin_name='$cabin_name' where voyage_code='$voyage_code' and cabin_type_code='$cabin_type_code' and cabin_name='$owncabin_name'";
		$transaction =\Yii::$app->db->beginTransaction();
		try {
			$command2= \Yii::$app->db->createCommand($sql)->execute();
			$command3= \Yii::$app->db->createCommand($vticketsql)->execute();
			$transaction->commit();
			echo 1;
		} catch(Exception $e) {
			$transaction->rollBack();
			echo 0;
		}
	}
	public function actionGetchangeroompage(){
  		$voyage_code=isset($_POST['voyage_code'])?$_POST['voyage_code']:'';
		$cabin_name=isset($_POST['cabin_name'])?$_POST['cabin_name']:'';
  		$pag=isset($_POST['pag'])?($_POST['pag']-1)*2:0;
 		$t=isset($_POST['t'])?$_POST['t']:'0';
 	
		$sql="select vod.*,v.id from v_voyage_order_detail vod left join v_c_voyage v on v.voyage_code=vod.voyage_code where vod.status=0 ";
		if ($t==1){
			if ($voyage_code!=''){
				$sql.=" and vod.voyage_code='$voyage_code'";
			}
			if ($cabin_name!=''){
				$sql.=" and vod.cabin_name='$cabin_name'";
			}
		}
		$countdata=\Yii::$app->db->createCommand($sql)->queryAll();
		$sql.=" limit $pag,2";
		$data=\Yii::$app->db->createCommand($sql)->queryAll();
		if ($data){
		for($i=0;$i<sizeof($data);$i++){
			$voyage_id=$data[$i]['id'];
			$voyage_cabin=$data[$i]['cabin_type_code'];
			$voyage_code=$data[$i]['voyage_code'];
			$ordercabinsql="select cabin_name,cabin_type_code from v_voyage_order_detail where voyage_code='$voyage_code'";
			$ordercabin=\Yii::$app->db->createCommand($ordercabinsql)->queryAll();
			$order_cabin=[];
			foreach ($ordercabin as $k=>$v){
				$order_cabin[]=$v['cabin_name'];
			}
			$order_cabin=implode('\',\'',$order_cabin);
			$changcabinsql="select distinct vc.cabin_name, vt.type_code,vc.cabin_name
			from v_c_voyage_cabin vc
			join v_c_cabin_type vt on vc.cabin_type_id=vt.id
			join v_c_voyage v on v.id=vc.voyage_id
			join v_voyage_order_detail vod on vod.voyage_code=v.voyage_code and vod.cabin_type_code=vt.type_code
			where vc.voyage_id='$voyage_id' and vt.type_code='$voyage_cabin' and vc.cabin_name not in('$order_cabin')";
			$changcabin=\Yii::$app->db->createCommand($changcabinsql)->queryAll();
			$data[$i]['changcabin']=$changcabin;
		}
		$count=sizeof($countdata);
		$data['count']=$count;
		echo json_encode($data);
		}
		else{
			echo 0;
		}
	} 
}