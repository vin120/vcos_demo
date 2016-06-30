<?php

namespace travelagent\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;

class ReturningticketController  extends BaseController
{
	public $layout = "myloyout";
	public $enableCsrfValidation = false;
	public function actionReturningticket()
	{
		$query  = new Query();
		$order = $query->select(['a.order_serial_number','a.voyage_code','a.total_pay_price','a.create_order_time','a.pay_status','b.voyage_name'])
				->from('v_voyage_order a')
				->leftjoin('v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
				->where(['b.i18n'=>'en','a.pay_status'=>1])
				->all();
		return $this->render('returningticket',['order'=>$order]);
	}
	public function actionReturnticketpage(){
		$pag = isset($_POST['pag']) ? $_POST['pag']==1 ? 0 :($_POST['pag']-1) * 2 : 0;
		$query  = new Query();
		$result =  $query->select(['a.order_serial_number','a.voyage_code','a.total_pay_price','a.create_order_time','a.pay_status','b.voyage_name'])
		->from('v_voyage_order a')
		->leftjoin('v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en','a.pay_status'=>1])
		->offset($pag)
		->limit(2)
		->all();
		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
	}
	public function actionReturnticketinfo(){
		$order_serial_number=isset($_GET['id'])?$_GET['id']:'';
		$ordersql="select * from v_voyage_order where order_serial_number='$order_serial_number'";
		$orderinfo=\Yii::$app->db->createCommand($ordersql)->queryOne();
		$member = [];
		$sql = "SELECT passport_number_one,passport_number_two,passport_number_three,passport_number_four,cabin_price,tax_price FROM v_voyage_order_detail WHERE order_serial_number ='$order_serial_number'";
		$passport = Yii::$app->db->createCommand($sql)->queryAll();
		$totalroomprice=0;
		foreach ($passport as $key=>$row ){
			$totalroomprice=$totalroomprice+$row['cabin_price'];//房间总价
			$tmp = $row['passport_number_one'];
			$sql="select m.*,a.additional_price,a.price_type from v_voyage_order_detail d 
			left join v_membership m on m.passport_number=d.passport_number_one 
			left join v_voyage_order_additional_price a on d.order_serial_number=a.order_serial_number and d.passport_number_one=a.passport_number and a.price_type=2
			where m.passport_number='$tmp'";
			
			
			$info1 = Yii::$app->db->createCommand($sql)->queryOne();
			if(!empty($info1)){
				$member[$key][]=$info1;
			}
			$tmp = $row['passport_number_two'];
			$sql="select m.*,a.additional_price,a.price_type from v_voyage_order_detail d
			left join v_membership m on m.passport_number=d.passport_number_two
			left join v_voyage_order_additional_price a on d.order_serial_number=a.order_serial_number and d.passport_number_two=a.passport_number  and a.price_type=2
			where  m.passport_number='$tmp'";
			$info2 = Yii::$app->db->createCommand($sql)->queryOne();
			if(!empty($info2)){
				$member[$key][]=$info2;
			}
			$tmp = $row['passport_number_three'];
			$sql="select m.*,a.additional_price,a.price_type from v_voyage_order_detail d
			left join v_membership m on m.passport_number=d.passport_number_three
			left join v_voyage_order_additional_price a on d.order_serial_number=a.order_serial_number and d.passport_number_three=a.passport_number and a.price_type=2
			where  m.passport_number='$tmp'";
			$info3 = Yii::$app->db->createCommand($sql)->queryOne();
			if(!empty($info3)){			
				$member[$key][]=$info3;
			}
			
			$tmp = $row['passport_number_four'];
			$sql="select m.*,a.additional_price,a.price_type from v_voyage_order_detail d
			left join v_membership m on m.passport_number=d.passport_number_four
			left join v_voyage_order_additional_price a on d.order_serial_number=a.order_serial_number and d.passport_number_four=a.passport_number and a.price_type=2
			where m.passport_number='$tmp'";
			$info4= Yii::$app->db->createCommand($sql)->queryOne();
			if(!empty($info4)){				
				$member[$key][]=$info4;
			}
		}
		
		$sql="select * from v_voyage_order_detail where order_serial_number='$order_serial_number'";
		$data=\Yii::$app->db->createCommand($sql)->queryAll();
		for($i=0;$i<sizeof($data);$i++){
			$data[$i]['member'] = $member;
		}
	
		return $this->render("returnticketinfo",['data'=>$data,'totalroomprice'=>$totalroomprice,'orderinfo'=>$orderinfo]);
	}
	public function actionReturnticket(){
		
	
		$ids=[];
		$ids=isset($_POST['value'])?$_POST['value']:'';
	
	 		if($ids!=''){
			$ids=implode('\',\'',$ids);
			$sql="update v_voyage_order_detail set status=2 where id in('$ids')";
			$transaction =\Yii::$app->db->beginTransaction();
			try {
				$command2= \Yii::$app->db->createCommand($sql)->execute();
				$transaction->commit();
				echo 1;
			} catch(Exception $e) {
				$transaction->rollBack();
				echo 0;
			}
		}
		else{
			echo 2;
		} 
	}
}