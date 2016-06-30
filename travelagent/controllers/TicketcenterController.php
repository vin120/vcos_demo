<?php
namespace travelagent\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
class TicketcenterController  extends BaseController
{
	public $layout = 'myloyout';
	public $enableCsrfValidation = false;
	
	
	public function actionTicketcenter()
	{
		$query  = new Query();
		$order = $query->select(['a.order_serial_number','a.order_serial_number','a.voyage_code','a.total_pay_price','a.create_order_time','a.pay_status','b.voyage_name'])
				->from('v_voyage_order a')
				->leftjoin('v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
				->where(['b.i18n'=>'en'])
				->limit(2)
				->all();
		$query  = new Query();
		$order_num = $query->select(['order_serial_number'])
				->from('v_voyage_order')
				->all();
				
		$query  = new Query();
		$count = $query->select(['a.order_serial_number','a.voyage_code','a.total_pay_price','a.create_order_time','a.order_status','b.voyage_name'])
				->from('v_voyage_order a')
				->leftjoin('v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
				->where(['b.i18n'=>'en'])
				->count();
	
		return $this->render('ticketcenter',['order'=>$order,'count'=>$count,'order_num'=>$order_num,'pag'=>1]);
	}
	public function actionTicketcenterinfo(){
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
	
		return $this->render("ticketcenterinfo",['data'=>$data,'totalroomprice'=>$totalroomprice,'orderinfo'=>$orderinfo]);
		
	}
	

	public function actionTicketcentersearch()
	{
		$order_no = Yii::$app->request->post('order_no','');
		$route_name = Yii::$app->request->post('route_name','');
		$start_time = Yii::$app->request->post('start_time','');
		$end_time = Yii::$app->request->post('end_time','');
		$route_code = Yii::$app->request->post('route_code','');
		
		
		$where_order_no = array();
		$where_route_name = array();
		$where_start_time = array();
		$where_end_time = array();
		$where_route_code = array();
		
		if($order_no != 'All'){
			$where_order_no = ['=','a.order_serial_number',$order_no];
		}
		
		if($route_name != ''){
			$where_route_name = ['like','b.voyage_name',$route_name];
		}
		
		if($start_time != ''){
			$where_start_time = ['>','a.create_order_time',$start_time];
		}
		
		if($end_time != ''){
			$where_end_time = ['<','a.create_order_time',$end_time];
		}
		
		if($route_code != ''){
			$where_route_code = ['like','a.voyage_code',$route_code];
		}
		
		$query  = new Query();
		$result = $query->select(['a.order_serial_number','a.order_serial_number','a.voyage_code','a.total_pay_price','a.create_order_time','a.pay_status','b.voyage_name'])
		->from('v_voyage_order a')
		->leftjoin('v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en'])
		->andWhere($where_order_no)
		->andWhere($where_route_name)
		->andWhere($where_start_time)
		->andWhere($where_end_time)
		->andWhere($where_route_code)
		->limit(2)
		->all();
		
		
		$query  = new Query();
		$count = $query->select(['*'])
		->from('v_voyage_order a')
		->leftjoin('v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en'])
		->andWhere($where_order_no)
		->andWhere($where_route_name)
		->andWhere($where_start_time)
		->andWhere($where_end_time)
		->andWhere($where_route_code)
		->count();
		
		$result['count'] = $count;
		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
		
		
	}
	
	
	//分页
	public function actionGetticketcenterpage()
	{
		$pag = isset($_POST['pag']) ? $_POST['pag']==1 ? 0 :($_POST['pag']-1) * 2 : 0;
		
		$order_no_hidden = Yii::$app->request->post('order_no_hidden','');
		$route_name_hidden = Yii::$app->request->post('route_name_hidden','');
		$start_time_hidden = Yii::$app->request->post('start_time_hidden','');
		$end_time_hidden = Yii::$app->request->post('end_time_hidden','');
		$route_code_hidden = Yii::$app->request->post('route_code_hidden','');
		
		$where_order_no = array();
		$where_route_name = array();
		$where_start_time = array();
		$where_end_time = array();
		$where_route_code = array();
		
		if($order_no_hidden != 'All'){
			$where_order_no = ['=','a.order_serial_number',$order_no_hidden];
		}
		
		if($route_name_hidden != ''){
			$where_route_name = ['like','b.voyage_name',$route_name_hidden];
		}
		
		if($start_time_hidden != ''){
			$where_start_time = ['>','a.create_order_time',$start_time_hidden];
		}
		
		if($end_time_hidden != ''){
			$where_end_time = ['<','a.create_order_time',$end_time_hidden];
		}
		
		if($route_code_hidden != ''){
			$where_route_code = ['like','a.voyage_code',$route_code_hidden];
		}
		
		$query  = new Query();
		$result = $query->select(['a.order_serial_number','a.order_serial_number','a.voyage_code','a.total_pay_price','a.create_order_time','a.pay_status','b.voyage_name'])
		->from('v_voyage_order a')
		->leftjoin('v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en'])
		->andWhere($where_order_no)
		->andWhere($where_route_name)
		->andWhere($where_start_time)
		->andWhere($where_end_time)
		->andWhere($where_route_code)
		->offset($pag)
		->limit(2)
		->all();
		
		
		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
		
	}
	public function actionCancelorder(){
		$order_serial_number=isset($_POST['order_serial_number'])?$_POST['order_serial_number']:'';
		if($order_serial_number!=''){
			$transaction=\Yii::$app->db->beginTransaction();
			try {
			$commen=\Yii::$app->db->createCommand("update v_voyage_order set order_status=1 where order_serial_number='$order_serial_number'")->execute();
			$transaction->commit();
			echo 1;
			}
			catch (Exception $e){
				$transaction->rollBack();
				echo 0;
			}
			
		}
		else{
			echo 0;
		}
	}
	
}