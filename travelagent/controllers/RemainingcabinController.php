<?php
namespace travelagent\controllers;

use Yii;
use yii\web\Controller;

class RemainingcabinController extends BaseController
{
	public $enableCsrfValidation = false;
	public $layout = 'myloyout';
	public function actionRemaininginfo()
	{
		
		$voyagesql="select vi.voyage_name,v.id from v_c_voyage v join v_c_voyage_i18n vi on vi.voyage_code=v.voyage_code where vi.i18n='en'";
		//$cabintypesql="select * from v_c_cabin_type_i18n where i18n='en'";
		$voyageinfo=\Yii::$app->db->createCommand($voyagesql)->queryAll();
		//$cabintypeinfo=\Yii::$app->db->createCommand($cabintypesql)->queryAll();
		return $this->render("remaininginfo",array('voyageinfo'=>$voyageinfo));
	}
	
	public function actionGetremaininginfo(){//分页
   		$voyage_id=isset($_POST['voyage_id'])?$_POST['voyage_id']:'';
   		$type_code=isset($_POST['type_code'])?$_POST['type_code']:'';
 		$pag=isset($_POST['pag'])?($_POST['pag']-1)*2:0;
 		if($voyage_id!=''){
		$sqlcabin="SELECT count(*) as count,vc.voyage_id,ct.type_code,cti.type_name,vc.deck_num FROM v_c_voyage_cabin vc join v_c_cabin_type ct on vc.cabin_type_id=ct.id join v_c_cabin_type_i18n cti on cti.type_code=ct.type_code  WHERE vc.id>0";
		if($voyage_id!=''){
			$sqlcabin.=" and voyage_id='$voyage_id'";
		}
		if($type_code!=''){
			$sqlcabin.=" and ct.type_code='$type_code'";
		}
		$sqlcabin.=" AND vc.cabin_status = 1 GROUP BY cabin_type_id ";//拼凑sql语句
		$cabin=\Yii::$app->db->createCommand($sqlcabin)->queryAll();//查询出count
		$sqlcabin.=" limit $pag,2";
		$cabininfo=\Yii::$app->db->createCommand($sqlcabin)->queryAll();//分页数据
		
		$voyagesql="select voyage_code from v_c_voyage where id='$voyage_id'";
		$voyage_code=\Yii::$app->db->createCommand($voyagesql)->queryOne();//查询出航线code
		$voyage_code=$voyage_code['voyage_code'];
		$order_detailsql="SELECT count(*) as count,v.id as voyage_id,vod.cabin_type_code FROM v_voyage_order vo left join v_c_voyage v on vo.voyage_code=v.voyage_code join v_voyage_order_detail vod on vo.order_serial_number=vod.order_serial_number  WHERE vod.id>0 ";//有个支付时间不能大于45分钟 GROUP BY vod.cabin_type
		if($voyage_code!=''){
			$order_detailsql.=" and vod.voyage_code = '$voyage_code'";
		}
		$order_detailsql.=" AND vo.order_status = 0 GROUP BY vod.cabin_type_code";
		$order_detail=\Yii::$app->db->createCommand($order_detailsql)->queryAll();
		if(isset($cabininfo[0]['voyage_id'])){
			foreach ($cabininfo as $k=>$v){
				$y=0;
				if (isset($order_detail[0]['voyage_id'])){
				foreach ($order_detail as $key=>$value){
				if($v['type_code']==$value['cabin_type_code']&&$v['voyage_id']==$value['voyage_id']){//获取$quantity的值
					$y=1;
					$quantity=$v['count']-$value['count'];
				}
				}
				}
				if ($y==0){
					$quantity=$v['count']-0;
				}
			$cabininfo[$k]['quantity']=$quantity;
			}
			echo json_encode($cabininfo);
		}
		else{
			echo 0;
		}
 		}
 		else{
 			echo 0;
 		}
	}
	public function actionGetremainingcount(){//获取分页数
		$voyage_id=isset($_POST['voyage_id'])?$_POST['voyage_id']:'';
		$type_code=isset($_POST['type_code'])?$_POST['type_code']:'';
		if($voyage_id!=''){
		$sqlcabin="SELECT vc.deck_num FROM v_c_voyage_cabin vc left join v_c_cabin_type ct on vc.cabin_type_id=ct.id where vc.id>0";
		 if($voyage_id!=''){
		 	$sqlcabin.="  and voyage_id='$voyage_id'";
		 }
		 if($type_code!=''){
		 	$sqlcabin.=" and ct.type_code='$type_code'";
		 }
		$sqlcabin.="  AND vc.cabin_status = 1 GROUP BY cabin_type_id";	// GROUP BY cabin_type_id
		$cabin=\Yii::$app->db->createCommand($sqlcabin)->queryAll();
		if ($cabin){
			echo sizeof($cabin);
		}
		else{
			echo 0;
		}
		}
		else{
			echo 0;
		}
		
	}
	public function actionGetcabintype(){//航线对应的cabin
		$voyage_id=isset($_POST['voyage_id'])?$_POST['voyage_id']:'';
		$sql="select cabin_type_id from v_c_voyage_cabin where voyage_id='$voyage_id' GROUP BY cabin_type_id";
		$cabininfo=\Yii::$app->db->createCommand($sql)->queryAll();
		$cabinarray=[];
		foreach ($cabininfo as $k=>$v){
			$cabinarray[]=$v['cabin_type_id'];
		}
		$cabins = implode ( '\',\'', $cabinarray );
		$cabinsql="select ct.type_code,cti.type_name from v_c_cabin_type ct join v_c_cabin_type_i18n cti on cti.type_code=ct.type_code where ct.id in ('$cabins')";
		$cabinsinfo=\Yii::$app->db->createCommand($cabinsql)->queryAll();
		if($cabinsinfo){
			echo json_encode($cabinsinfo);
		}
		else{
			echo 0;
		}
	}
}