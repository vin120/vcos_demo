<?php
/**
 * Created by PhpStorm.
 * User: leijiao
 * Date: 16/3/15
 * Time: 下午4:58
 */

namespace travelagent\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use travelagent\components\Helper;
use travelagent\components\CreateMember;

class BookingticketController  extends BaseController
{
	public $layout = "myloyout.php";
	public $enableCsrfValidation = false;
	
	public function actionBookingticket(){
		
		$query  = new Query();
		$result = $query->select(['a.voyage_code','a.ticket_price','a.start_time','a.end_time','b.voyage_name','b.i18n'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en'])
		->limit(2)
		->all(); 
		
		$query  = new Query();
		$count = $query->select(['a.*'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en'])
		->count();
		return $this->render("booking_ticket",['result'=>$result,'count'=>$count,'booking_ticke_pag'=>1]);
	}
	
	//通过ajax搜索内容
	public function actionBookingticketsearch()
	{
		$sailing_date = Yii::$app->request->post('sailing_date','');
		$route_name = Yii::$app->request->post('route_name','');
		$route_code = Yii::$app->request->post('route_code','');
		
		if($sailing_date!=''){
			$sailing_date = Helper::GetCreateTime($sailing_date);
		}
		
		$where_sailing_data = [];
		$where_route_name = [];
		$where_route_code = [];
	
		if($sailing_date != ''){
			$where_sailing_data = ['=','a.start_time',$sailing_date];
		}
	
		if($route_name != ''){
			$where_route_name = ['like','b.voyage_name',$route_name];
		}
	
		if($route_code != ''){
			$where_route_code = ['like','a.voyage_code',$route_code];
		}
	
		$query  = new Query();
		$result = $query->select(['a.voyage_code','a.ticket_price','a.start_time','a.end_time','b.voyage_name','b.i18n'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en'])
		->andWhere($where_sailing_data)
		->andWhere($where_route_name)
		->andWhere($where_route_code)
		->limit(2)
		->all();
	
		$query  = new Query();
		$count = $query->select(['*'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en'])
		->andWhere($where_sailing_data)
		->andWhere($where_route_name)
		->andWhere($where_route_code)
		->count();
	
		$arr = array();
		$arr['result'] = $result;
		$arr['count'] = $count;
		//$result['count'] = $count;
		if($arr){
			echo json_encode($arr);
		}else{
			echo 0;
		}
	}
	
	
	//分页
	public function actionGetbookingticketpage(){
	
		$pag = isset($_POST['pag']) ? $_POST['pag']==1 ? 0 :($_POST['pag']-1) * 2 : 0;
	
		$sailing_date_hidden = Yii::$app->request->post('sailing_date_hidden','');
		$route_name_hidden = Yii::$app->request->post('route_name_hidden','');
		$route_code_hidden = Yii::$app->request->post('route_code_hidden','');
		
		if($sailing_date_hidden!=''){
			$sailing_date = Helper::GetCreateTime($sailing_date_hidden);
		}
	
		$where_sailing_data = [];
		$where_route_name = [];
		$where_route_code = [];
	
		if($sailing_date_hidden != ''){
			$where_sailing_data = ['=','a.start_time',$sailing_date_hidden];
		}
	
		if($route_name_hidden != ''){
			$where_route_name = ['like','b.voyage_name',$route_name_hidden];
		}
	
		if($route_code_hidden != ''){
			$where_route_code = ['like','a.voyage_code',$route_code_hidden];
		}
	
	
		$query  = new Query();
		$result = $query->select(['a.voyage_code','a.ticket_price','a.start_time','a.end_time','b.voyage_name','b.i18n'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en'])
		->andWhere($where_sailing_data)
		->andWhere($where_route_name)
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

	public function actionInputmode(){
		$voyage_code = isset($_GET['code'])?$_GET['code']:'';
		return $this->render("input_mode",['code'=>$voyage_code]);
	}
	
	
	public function actionAdduestinfo(){
		$voyage_code = isset($_GET['code'])?$_GET['code']:'';
		$query  = new Query();
		$result = $query->select(['a.country_code','b.country_name'])
		->from('v_c_country a')
		->join('LEFT JOIN','v_c_country_i18n b','a.country_code=b.country_code')
		->where(['b.i18n'=>'en','a.status'=>'1'])
		->all();
		return $this->render("add_uest_info",['code'=>$voyage_code,'country_result'=>$result]);
	}
	
	
	public function actionGetcountrydata(){
		$query  = new Query();
		$result = $query->select(['a.country_code','b.country_name'])
		->from('v_c_country a')
		->join('LEFT JOIN','v_c_country_i18n b','a.country_code=b.country_code')
		->where(['b.i18n'=>'en','a.status'=>'1'])
		->all();
		
		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
	}
	
	public function actionGetpassportdate(){
		$voyage_code = isset($_POST['code'])?$_POST['code']:'';
		$query  = new Query();
		$result = $query->select(['start_time','end_time'])
		->from('v_c_voyage')
		->where(['voyage_code'=>$voyage_code])
		->one();
		
		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
		
	}
	
	public function actionPassportcheckmembership(){
		$passport = isset($_POST['passport'])?$_POST['passport']:'';
		
		$query  = new Query();
		$result = $query->select(['a.mobile_number','a.email','a.full_name','a.last_name','a.first_name','a.gender','a.birthday','a.country_code','a.passport_number','a.birth_place','b.date_issue','b.date_expire'])
		->from('v_membership a')
		->join('LEFT JOIN','v_m_passport b','a.passport_number=b.passport_number')
		->where(['a.passport_number'=>$passport])
		->one();
		
		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
		
	}
	
	public function actionNamegenderbirthcheckmembership(){
		$full_name = isset($_POST['full_name'])?$_POST['full_name']:'';
		$gender = isset($_POST['gender'])?$_POST['gender']:"";
		$birth = isset($_POST['birth'])?$_POST['birth'].' 00:00:00':'';
		
		$query  = new Query();
		$result = $query->select(['a.full_name','a.last_name','a.first_name','a.gender','a.birthday','a.country_code','a.passport_number','a.birth_place','b.date_issue','b.date_expire'])
		->from('v_membership a')
		->join('LEFT JOIN','v_m_passport b','a.passport_number=b.passport_number')
		->where(['a.full_name'=>$full_name,'a.gender'=>$gender,'a.birthday'=>$birth])
		->one();
		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
		
		
	}

	
	//房间
	
	public function actionChooseandreservation(){
		$success = 0;
		$voyage_code = isset($_GET['code'])?$_GET['code']:'';
		
		//获取cabin_type
		$query  = new Query();
		$all_data = $query->select(['b.type_code','c.type_name','count(a.cabin_name) count','e.check_num'])
				->from('v_c_voyage_cabin a')
				->join('LEFT JOIN','v_c_cabin_type b','a.cabin_type_id=b.id')
				->join('LEFT JOIN','v_c_cabin_type_i18n c','b.type_code=c.type_code')
				->join('LEFT JOIN','v_c_voyage d','a.voyage_id=d.id')
				->join('LEFT JOIN','v_c_cabin_pricing e','a.cabin_type_id=e.cabin_type_id')
				->where(['a.cabin_status'=>'1','b.type_status'=>'1','e.voyage_code'=>$voyage_code,'d.voyage_code'=>$voyage_code])
				->groupBy('b.type_code')
				->all();
		//var_dump($all_data);	exit;
		$query  = new Query();
		$order_data = $query->select(['count(cabin_type_code) count','cabin_type_code'])
					->from('v_voyage_order_detail')
					->where(['voyage_code'=>$voyage_code])
					->groupBy('cabin_type_code')
					->all();
	   //var_dump($order_data);exit;
		return $this->render("choose_and_reservation",['code'=>$voyage_code,'all_data'=>$all_data,'order_data'=>$order_data]);
	}
	

	
	public function actionSurchargecabinassignments()
	{
		$voyage_code = isset($_GET['code'])?$_GET['code']:'';
		
		$query  = new Query();
		$shore = $query->select(['c.se_name','c.se_info','c.se_code'])
		->from('v_c_shore_excursion a')
		->join('LEFT JOIN','v_c_shore_excursion_lib b','a.sh_id=b.id')
		->leftJoin('v_c_shore_excursion_lib_i18n c','b.se_code=c.se_code ')
		->where(['c.i18n'=>'en','a.status'=>'1','a.voyage_code'=>$voyage_code])
		->all();
		
		
		
		$query  = new Query();
		$surcharge = $query->select(['c.cost_name','c.cost_desc','c.cost_id'])
		->from('v_c_surcharge a')
		->join('LEFT JOIN','v_c_surcharge_lib b','a.cost_id=b.id')
		->leftJoin('v_c_surcharge_lib_i18n c','b.id=c.cost_id')
		->where(['c.i18n'=>'en','a.status'=>'1','a.voyage_code'=>$voyage_code])
		->all();

		return $this->render("surcharge_cabinassignments",['code'=>$voyage_code,'shore'=>$shore,'surcharge'=>$surcharge]);
	}
	
	
	//订单开始-start--------------------------------------------------------------------
	//下单保存数据
	/***
	 *  shore_excursion shore_id:user_passport,user_passport/shore_id:user_passport,user_passport
	 *  Insurance 
	 * 
	 */
	public function actionOrdersave(){
		$last_name = isset($_POST['last_name'])?explode(',', $_POST['last_name']):'';
		$first_name = isset($_POST['first_name'])?explode(',',$_POST['first_name']):'';
		$full_name = isset($_POST['full_name'])?explode(',',$_POST['full_name']):'';
		$passport = isset($_POST['passport'])?explode(',',$_POST['passport']):'';
		$gender = isset($_POST['gender'])?explode(',',$_POST['gender']):'';
		$nationalify = isset($_POST['nationalify'])?explode(',',$_POST['nationalify']):'';
		$email = isset($_POST['email'])?explode(',',$_POST['email']):'';
		$phone = isset($_POST['phone'])?explode(',',$_POST['phone']):'';
		$birth = isset($_POST['birth'])?explode(',',$_POST['birth']):'';
		$birth_place = isset($_POST['birth_place'])?explode(',',$_POST['birth_place']):'';
		$issue = isset($_POST['issue'])?explode(',',$_POST['issue']):'';
		$expiry = isset($_POST['expiry'])?explode(',',$_POST['expiry']):'';
		$shore_excursion = isset($_POST['shore_excursion'])?$_POST['shore_excursion']:'';
		$insurance = isset($_POST['insurance'])?$_POST['insurance']:'';
		$room = isset($_POST['room'])?$_POST['room']:'';
		$voyage_code = isset($_POST['voyage_code'])?$_POST['voyage_code']:'';
		
		$agent_name = Yii::$app->user->identity->travel_agent_admin;
		$time = date('Y-m-d H:i:s',time());
		
		
		
		//生成订单号
		$order_serial_number = Helper::createOrderno();
		
		//查询该条航线费用：
		$query  = new Query();
		$voyage = $query->select(['id','start_time','voyage_code','ticket_price','ticket_taxes','harbour_taxes','cruise_code'])
		->from('v_c_voyage')
		->where(['voyage_code'=>$voyage_code])
		->one();
		
		//Helper::GetCreateTime
		$connecton = Yii::$app->db;
		$transaction = $connecton->beginTransaction();
		try{
			$query  = new Query();
			$cabin_price = $query->select(['a.*','b.type_code'])
			->from('v_c_cabin_pricing a')
			->join('LEFT JOIN','v_c_cabin_type b','a.cabin_type_id=b.id')
			->where(['a.voyage_code'=>$voyage['voyage_code']])
			->all();
			
			$query  = new Query();
			$surcharge = $query->select(['b.id','b.cost_price'])
			->from('v_c_surcharge a')
			->join('LEFT JOIN','v_c_surcharge_lib b','a.cost_id=b.id')
			->where(['a.status'=>'1','a.voyage_code'=>$voyage['voyage_code']])
			->all();
			$surcharge_arr = array();
			foreach ($surcharge as $v){
				$surcharge_arr[$v['id']] = $v['cost_price'];
			}
			
			//优惠方式
			$query  = new Query();
			$strategy = $query->select(['p_w_id','p_price','p_where'])
			->from('v_c_preferential_strategy ')
			->where(['voyage_code'=>$voyage['voyage_code'],'status'=>'1'])
			->all();
			
			$this->Membershipsave($connecton,$agent_name,$last_name,$first_name,$full_name,$passport,$gender,$nationalify,$email,$phone,$birth,$birth_place,$issue,$expiry);
			
			$this->Travelagentmembershipsave($connecton,$agent_name,$last_name,$first_name,$full_name,$passport,$gender,$nationalify,$email,$phone,$birth,$birth_place,$issue,$expiry);
			
			$this->Voyageordersave($connecton,$order_serial_number,$surcharge_arr,$cabin_price,$agent_name,$voyage,$shore_excursion,$insurance,$room,$passport,$birth,$strategy);
			
			$this->Orderadditionalprice($connecton,$order_serial_number,$surcharge_arr,$passport,$voyage,$shore_excursion,$insurance);
			
			$this->Orderdetail($connecton,$order_serial_number,$cabin_price,$agent_name,$voyage,$room,$passport);
			
			//exit;
			$transaction->commit();
			$success = 1;
		}catch (Exception $e){
			$transaction->rollBack();
			$success = 0;
		}
		if($success==1){
			echo json_encode($order_serial_number);
		}else{
			echo 0;
		}
	}
	
	
	//order_membership_save
	/***
	 * 存在跳过，不存在新增
	 * 判断护照号
	 */
	protected function Membershipsave($connecton,$agent_name,$last_name,$first_name,$full_name,$passport,$gender,$nationalify,$email,$phone,$birth,$birth_place,$issue,$expiry){
		$time = date('Y-m-d H:i:s',time());
		$sql_data = 'INSERT INTO `v_membership` (m_code,last_name,first_name,full_name,passport_number,gender,country_code,email,mobile_number,birthday,birth_place,create_by,create_time) VALUES ';
		$date_data = 'INSERT INTO `v_m_passport` (passport_number,date_issue,date_expire,full_name,last_name,first_name,gender,birthday,birth_place,country_code) VALUES ';
		$sql_data_where = '';
		$date_data_where = '';
		foreach ($passport as $k=>$v){
			//查询是否存在该护照号
			$sql = "SELECT count(*) count FROM `v_membership` WHERE passport_number='$v'";
			$count = $connecton->createCommand($sql)->queryOne();
			if($count['count']==0){
				$m_code = CreateMember::createMemberNumber();
				$sql_data_where .= '("'.$m_code.'","'.$last_name[$k].'","'.$first_name[$k].'","'.$full_name[$k].'","';
				$sql_data_where .= $v.'","'.$gender[$k].'","'.$nationalify[$k].'","'.$email[$k].'","';
				$sql_data_where .= $phone[$k].'","'.Helper::GetCreateTime($birth[$k]).'","'.$birth_place[$k].'","';
				$sql_data_where .= $agent_name.'","'.$time.'"),';
				
				$date_data_where .= '("'.$v.'","'.Helper::GetCreateTime($issue[$k]).'","'.Helper::GetCreateTime($expiry[$k]).'","';
				$date_data_where .= $full_name[$k].'","'.$last_name[$k].'","'.$first_name[$k].'","'.$gender[$k].'","'.Helper::GetCreateTime($birth[$k]).'","';
				$date_data_where .= $birth_place[$k].'","'.$nationalify[$k].'"),';
			}
		}
		$sql_data_sql = $sql_data.trim($sql_data_where,',');
		$date_data_sql = $date_data.trim($date_data_where,',');
		if($sql_data_where!=''){ $connecton->createCommand($sql_data_sql)->execute();}
		if($date_data_where != '') {$connecton->createCommand($date_data_sql)->execute();}
		
	}
	
	
	//order_travelagent_membership_save
	/***
	 * 存在则修改，不存在则新增
	 * 判断护照号
	 */
	protected function Travelagentmembershipsave($connecton,$agent_name,$last_name,$first_name,$full_name,$passport,$gender,$nationalify,$email,$phone,$birth,$birth_place,$issue,$expiry){
		$time = date('Y-m-d H:i:s',time());
		
		$sql_insert = 'INSERT INTO `v_travelagent_membership` (full_name,last_name,first_name,gender,birthday,birth_place,country_code,passport_num,date_issue,date_expire,email,phone,create_by,create_time) VALUES ';
		$sql_insert_where = '';
		foreach ($passport as $k=>$v){
			//查询是否存在该护照号
			$sql = "SELECT count(*) count FROM `v_travelagent_membership` WHERE passport_num='$v' AND create_by='$agent_name'";
			$count = Yii::$app->db->createCommand($sql)->queryOne();
			if($count['count']==0){
				$sql_insert_where .= '("'.$full_name[$k].'","'.$last_name[$k].'","'.$first_name[$k].'","';
				$sql_insert_where .= $gender[$k].'","'.Helper::GetCreateTime($birth[$k]).'","'.$birth_place[$k].'","'.$nationalify[$k].'","';
				$sql_insert_where .= $v.'","'.Helper::GetCreateTime($issue[$k]).'","'.Helper::GetCreateTime($expiry[$k]).'","';
				$sql_insert_where .= $email[$k].'","'.$phone[$k].'","'.$agent_name.'","'.$time.'"),';
			}else{
				$sql_update = 'UPDATE `v_travelagent_membership` SET ';
				$sql_update .= 'full_name="'.$full_name[$k].'",last_name="'.$last_name[$k].'",first_name="'.$first_name[$k].'",';
				$sql_update .= 'gender="'.$gender[$k].'",birthday="'.Helper::GetCreateTime($birth[$k]).'",birth_place="'.$birth_place[$k].'",';
				$sql_update .= 'country_code="'.$nationalify[$k].'",date_issue="'.Helper::GetCreateTime($issue[$k]).'",date_expire="'.Helper::GetCreateTime($expiry[$k]).'",';
				$sql_update .= 'email="'.$email[$k].'",phone="'.$phone[$k].'" ';
				$sql_update .= " WHERE passport_num='$v' AND create_by='$agent_name'";
				
				$connecton->createCommand($sql_update)->execute();
			}
		}
		$sql_insert = $sql_insert.trim($sql_insert_where,',');
		//var_dump($sql_insert);
		if($sql_insert_where != '') $connecton->createCommand($sql_insert)->execute();
			
	}
	
	
	//voyage_order_save
	/***
	 * 一个订单一条数据
	 */
	protected function Voyageordersave($connecton,$order_serial_number,$surcharge_arr,$cabin_price,$agent_name,$voyage,$shore_excursion,$insurance,$room,$passport,$birth,$strategy){
		$user_num = count($passport);
		
		
		//封装人员年龄
		//护照号=》年龄
		$passport_age = array();
		foreach ($passport as $k=>$v){
			$birth_date = Helper::GetCreateTime($birth[$k]);
			$age = Helper::Getage($birth_date);
			$passport_age[$v] = $age;
		}
		
		//var_dump($passport_age);exit;
		
		//房间总价
		// aa:aa,bb,12/ggg:cc,dd
		$room_total = 0;
		$room_arr = ''; 
		$room = explode('/', $room);
		
		foreach ($room as $v){
			$room_ex = explode(':', $v);
			if(isset($room_ex[1])){
				$room_only_num = explode(',', $room_ex[1]);			//护照号
				$room_arr .= $room_ex[0].':'.count($room_only_num).'/';
			}
		}
		$room_arr = trim($room_arr,'/');
		//var_dump($room_arr);exit;
		//var_dump($room_arr);
		
		//房间类型遍历
		$cabin_type_arr = array();
		foreach ($cabin_price as $v){
			$cabin_type_arr[$v['type_code']] = $v['check_num'].'-'.$v['bed_price'].'-'.$v['2_empty_bed_preferential'].'-'.$v['3_4_empty_bed_preferential'];
			//$cabin_type_arr[$v['type_code']] = $v['check_num'].'-'.$v['bed_price'].'-'.$v['last_bed_price'].'-'.$v['2_empty_bed_preferential'].'-'.$v['3_4_empty_bed_preferential'];
		}
			
		//var_dump($cabin_type_arr);exit;
		
		$room_arr = explode('/', $room_arr);
		
		foreach ($room_arr as $v){
			//var_dump($v);
			$type_code_str = explode(':', $v);
			$type_code = $type_code_str[0];
			$user_number = $type_code_str[1];
			//var_dump($type_code_str);exit;
			$data_only = explode('-',$cabin_type_arr[$type_code]);
			
			//判断当前房间类型是否有乘客
			//判断该房间是否满人
			if($data_only[0] == $user_number){
				$room_total += (float)$data_only[1] * (int)$user_number;
			}else{
				//判断该房间入住人数：2比较
				if($data_only[0] >2){
					//3或4人间
					$empty_num = (int)$data_only[0] - (int)$user_number;
					if((int)$user_number >= 2){
						//剩余按3/4优惠算
						$room_total += (((float)$data_only[1] * (int)$user_number) + ($empty_num * (float)$data_only[1] * (float)$data_only[3]/100));
					}else{
						//一人占三/四人间，-》有一个按2优惠算，剩余按3/4优惠算
						$room_total += (((float)$data_only[1] * (int)$user_number) + (1 * (float)$data_only[1] * (float)$data_only[2]/100) + (($empty_num-1) * (float)$data_only[1] * (float)$data_only[3]/100));                                             
					}
					
				}else{
					//1或2人间
					$empty_num = (int)$data_only[0] - (int)$user_number;
					$room_total += ((float)$data_only[1] * (int)$user_number) + ((int)$empty_num * (float)$data_only[1] * (float)$data_only[2]/100);
				}
			}
			
		}	
		
		//var_dump($room_total);
		
		//税价格
		$ticket_taxes = $voyage['ticket_taxes'];
		$ticket_taxes = $room_total * (float)($ticket_taxes/100);
		
		//var_dump($ticket_taxes);
		
		
		//港口费（人头算）
		$harbour_taxes = $voyage['harbour_taxes'];
		$harbour_taxes_total  = (int)$harbour_taxes * $user_num;
		
		
		
		//附加费(保险)
		// aa/bb/cc:4/dd:2,4/12:2
		$surcharge_total = 0;
		
		$insurance = explode('/', $insurance);
		foreach ($insurance as $v){
			$in_data = explode(':', $v);
			if(isset($in_data[1])){
				$in_data_only = explode(',', $in_data[1]);
				foreach ($in_data_only as $val){
					$surcharge_total += (int)$surcharge_arr[$val];
				}
			}
		}
		
		//观光路线
		// 001:dd,12/01:bb,cc/002:aa
		$shore_price_total = 0;
		$shore_excursion = explode('/', $shore_excursion);
		foreach ($shore_excursion as $v){
			//001:dd,12
			$only_shore = explode(':', $v);
			if(isset($only_shore[1])){
				$sql = "SELECT price FROM `v_c_shore_excursion_lib` WHERE se_code='$only_shore[0]'";
				$sh_price = $connecton->createCommand($sql)->queryOne();
				$only_num = explode(',', $only_shore[1]);
				$only_num = count($only_num);
				
				$shore_price_total += ((float)$sh_price['price'] * (int)$only_num);
			}
		}
		
		$total_pay_price = $room_total + $ticket_taxes + $harbour_taxes_total + $surcharge_total + $shore_price_total;
		$additional_price = $surcharge_total + $shore_price_total;
		$time = date('Y-m-d H:i:s',time());
		$sql = "INSERT INTO `v_voyage_order` (cruise_code,voyage_code,order_serial_number,order_type,travel_agent_name,create_order_time,total_pay_price,total_ticket_price,total_tax_pric,total_port_expenses,total_additional_price,source_code,source_type) VALUES ";
		$sql .= "('{$voyage['cruise_code']}','{$voyage['voyage_code']}','{$order_serial_number}','2','{$agent_name}','{$time}','{$total_pay_price}','{$room_total}','{$ticket_taxes}','{$harbour_taxes_total}','{$additional_price}','{$agent_name}','1')";
		
		$connecton->createCommand($sql)->execute();
		
	}
	
	//order_additional_price
	/***
	 * 1码头税，2附加费， 3观光路线  -》 单个人有几条添加几条数据
	 */
	protected function Orderadditionalprice($connecton,$order_serial_number,$surcharge_arr,$passport,$voyage,$shore_excursion,$insurance){
		
		
		//码头税
		//港口费（人头算）
		$user_harbour_taxes = $voyage['harbour_taxes'];
		
		//附加费
		//var_dump($surcharge_arr);
		// test1/test2:2/test3:2,4/12:4/test4/test5/test6
		$insurance = explode('/', $insurance);
		$insurance_arr = array();
		foreach ($insurance as $v){
			$val = 0;
			$in_ex = explode(':', $v);
			if(isset($in_ex[1])){
				$val_ex = explode(',', $in_ex[1]);
				foreach ($val_ex as $vv){
					$val .= $vv.'-'.(int)$surcharge_arr[$vv].',';
				}
				$val = trim($val,',');
			}
			//护照号：附加费总和
			$insurance_arr[$in_ex[0]] = $val;
		}
		//var_dump($insurance_arr);
		
		//观光路线
		$shore_excursion_arr = array();
		//var_dump($shore_excursion);
		// 001:test3,12/01:test2,test4,test5/002:test1,test6
		$user_shore_excursion = explode('/', $shore_excursion);
		foreach ($user_shore_excursion as $v){
			$user_shore_ex = explode(':', $v);
			$sql = "SELECT price FROM `v_c_shore_excursion_lib` WHERE se_code='$user_shore_ex[0]'";
			$sh_price = $connecton->createCommand($sql)->queryOne();
			if(isset($user_shore_ex[1])){
				$passport_only = explode(',', $user_shore_ex[1]);
				foreach ($passport_only as $vv){
					$shore_excursion_arr[$vv] = $user_shore_ex[0].'-'.$sh_price['price'];
				}
			}
			
		}
		//var_dump($shore_excursion_arr);
		
		
		//拼接sql
		foreach ($passport as $user){
			
			//码头税
			$sql = "INSERT INTO `v_voyage_order_additional_price` (voyage_code,order_serial_number,passport_number,price_type,additional_price) VALUES ";
			$sql .= "('{$voyage['voyage_code']}','{$order_serial_number}','{$user}','1','{$user_harbour_taxes}')";
			$connecton->createCommand($sql)->execute();
			
			//附加费（保险费）
			$curr_in = $insurance_arr[$user];
			if($curr_in != 0){
				$sql = "INSERT INTO `v_voyage_order_additional_price` (voyage_code,order_serial_number,passport_number,price_type,additional_price_id,additional_price) VALUES ";
				$curr_in = explode(',', $curr_in);
				foreach ($curr_in as $v){
					$only_in = explode('-', $v);
					
					$sql .= "('{$voyage['voyage_code']}','{$order_serial_number}','{$user}','2','{$only_in[0]}','{$only_in[1]}'),";
					
				}
				$sql = trim($sql,',');
				$connecton->createCommand($sql)->execute();
				
			}/*else{
				$sql = "INSERT INTO `v_voyage_order_additional_price` (voyage_code,order_serial_number,passport_number,price_type,additional_price) VALUES ";
				$sql .= "('{$voyage['voyage_code']}','{$order_serial_number}','{$user}','2','0')";
				//$connecton->createCommand($sql)->execute();
			}*/
			
			//观光路线（每个人只能有一条观光路线）
			$only_shore = $shore_excursion_arr[$user];
			$only_shore = explode('-', $only_shore);
			$sql = "INSERT INTO `v_voyage_order_additional_price` (voyage_code,order_serial_number,passport_number,price_type,additional_price_id,additional_price) VALUES ";
			$sql .= "('{$voyage['voyage_code']}','{$order_serial_number}','{$user}','3','{$only_shore[0]}','{$only_shore[1]}')";
			$connecton->createCommand($sql)->execute();
		}
		
		
	}
	
	//order_detail
	/****
	 * 几间房几条数据
	 */
	protected function Orderdetail($connecton,$order_serial_number,$cabin_price,$agent_name,$voyage,$room,$passport){
		
		$time = date('Y-m-d H:i:s',time());
		//var_dump($room);
		// 002:ABC002,ABC001/002:ABC004,ABC003/004:ABC005,12,ABC006 
		//房间类型遍历
		$cabin_type_arr = array();
		foreach ($cabin_price as $v){
			$cabin_type_arr[$v['type_code']] = $v['check_num'].'-'.$v['bed_price'].'-'.$v['2_empty_bed_preferential'].'-'.$v['3_4_empty_bed_preferential'];
		}
		
		$room_arr = explode('/', $room);
		$user_name_arr = ['one','two','three','four']; 
		foreach ($room_arr as $val){
			$room_ex = explode(':', $val);
			//根据cabin_type_code获取随机房间号
			$sql = "select cabin_name from v_voyage_order_detail where voyage_code='{$voyage['voyage_code']}' AND cabin_type_code='{$room_ex[0]}'";
			$room_name_in = $connecton->createCommand($sql)->queryAll();
			$room_name_in_str = '';
			foreach ($room_name_in as $v){
				$room_name_in_str += $v['cabin_name'].',';
			}
			$room_name_in_str = trim($room_name_in_str,',');
			if($room_name_in_str!=''){
				$room_name_in_where = " AND a.cabin_name not in(".$room_name_in_str.") ";
			}else{
				$room_name_in_where = '';
			}
			
			//获取房间号
			$sql = "select a.cabin_name from `v_c_voyage_cabin` a 
			LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id
			WHERE a.voyage_id='{$voyage['id']}' AND b.type_code='{$room_ex[0]}' AND a.cabin_status='1' 
			".$room_name_in_where." limit 1";
			$room_name = $connecton->createCommand($sql)->queryOne();
			
			
			//var_dump($sql);
			//判断人数
			$room_num = explode(',', $room_ex[1]);
			$num_total = count($room_num);
			
			//税收,房价	
			$cabin_price = 0; 
			
			//判断房间是否住满
			$data_only = explode('-', $cabin_type_arr[$room_ex[0]]);
			if($data_only[0] == $num_total){
				$cabin_price += (float)$data_only[1] * (int)$num_total;
			}else{
				//判断该房间入住人数：2比较
				if($data_only[0] >2){
					//3或4人间
					$empty_num = (int)$data_only[0] - (int)$num_total;
					if((int)$num_total >= 2){
						//剩余按3/4优惠算
						$cabin_price += (((float)$data_only[1] * (int)$num_total) + ($empty_num * (float)$data_only[1] * (float)$data_only[3]/100));

					}else{
						//一人占三/四人间，-》有一个按2优惠算，剩余按3/4优惠算
						$cabin_price += (((float)$data_only[1] * (int)$num_total) + (1 * (float)$data_only[1] * (float)$data_only[2]/100) + (($empty_num-1) * (float)$data_only[1] * (float)$data_only[3]/100));
						
					}
						
				}else{
					//1或2人间
					$empty_num = (int)$data_only[0] - (int)$num_total;
					$cabin_price += (((float)$data_only[1] * (int)$num_total) + ((int)$empty_num * (float)$data_only[1] * (float)$data_only[2]/100));
					
				}
			}
			
			//税
			$tax_price = ((float)$voyage['ticket_taxes']/100) * (float)$cabin_price;
			
			//封装床位入住名称
			$set_name = '';
			$set_val = '';
			foreach ($room_num as $k=>$v){
				$set_name .=  'passport_number_'.$user_name_arr[$k].',';
				$set_val .= "'".$v."',";
			}
			$set_name = trim($set_name,',');
			$set_val = trim($set_val,',');
			
			$sql = "INSERT INTO `v_voyage_order_detail` (order_serial_number,voyage_code,cabin_type_code,cabin_name,check_in_number,cabin_price,tax_price,".$set_name.",assign_cabin_status,status,create_time) VALUES ";
			$sql .= "('{$order_serial_number}','{$voyage['voyage_code']}','{$room_ex[0]}','{$room_name['cabin_name']}','{$num_total}','{$cabin_price}','{$tax_price}',$set_val,'1','0','{$time}')";
			
			//var_dump($sql);
			$connecton->createCommand($sql)->execute();
		}
		
	}
	
	//订单完成-end--------------------------------------------------------------------
	
	
	
	
	
	public function actionOrderinformation(){
		
		$order_number = isset($_GET['order_number'])?$_GET['order_number']:'';
		
		$sql = "select d.travel_agent_name,d.total_pay_price,d.total_ticket_price,d.total_tax_pric,d.total_port_expenses,d.total_additional_price,a.cabin_name,a.check_in_number,a.cabin_price,a.tax_price,a.passport_number_one,a.passport_number_two,a.passport_number_three,a.passport_number_four,c.type_name from `v_voyage_order_detail` a
		LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_code = b.type_code
		LEFT JOIN `v_c_cabin_type_i18n` c ON b.type_code = c.type_code
		LEFT JOIN `v_voyage_order` d ON a.order_serial_number = d.order_serial_number
		where a.order_serial_number = '".$order_number."' AND a.status=0";
		$detail_data=\Yii::$app->db->createCommand($sql)->queryAll();
		$room_field = ['one','two','three','four'];
		$order_total_result = array();
		foreach ($detail_data as $v){
			for($i=0;$i<$v['check_in_number'];$i++){
				$passport_field = 'passport_number_'.$room_field[$i];
				$sql = "SELECT last_name,first_name,date_issue,date_expire FROM `v_travelagent_membership` WHERE passport_num='{$v[$passport_field]}' AND create_by='{$v['travel_agent_name']}'";
				$user_data=\Yii::$app->db->createCommand($sql)->queryOne();
				$order_only_result = array();
				$order_only_result['type_name'] = $v['type_name'];
				$order_only_result['cabin_name'] = $v['cabin_name'];
				$order_only_result['last_name'] = $user_data['last_name'];
				$order_only_result['first_name'] = $user_data['first_name'];
				$order_only_result['passport_num'] = $v[$passport_field];
				$order_only_result['date_issue'] = $user_data['date_issue'];
				$order_only_result['date_expire'] = $user_data['date_expire'];
				$order_total_result[] = $order_only_result;
			}
		}
		//var_dump($order_total_result);
		$order_price_total = array();
		$order_price_total['order_number'] = $order_number;
		$order_price_total['total_pay_price'] = $detail_data[0]['total_pay_price'];
		$order_price_total['cabin_price'] = $detail_data[0]['total_ticket_price'];
		$order_price_total['tax'] = $detail_data[0]['total_tax_pric'];
		$order_price_total['port'] = $detail_data[0]['total_port_expenses'];
		$order_price_total['surcharge'] = $detail_data[0]['total_additional_price'];
		//exit;
		
		return $this->render("order_information",['order_price_total'=>$order_price_total,'order_total_result'=>$order_total_result]);
	}
	
	
	
	
	public function actionPayment(){
		$order_number = isset($_GET['order_number'])?$_GET['order_number']:"";
		$total_pay_price = isset($_GET['total_pay_price'])?$_GET['total_pay_price']:"";
		$travel_agent_name = Yii::$app->user->identity->travel_agent_admin;
		$sql = "SELECT current_amount FROM `v_travel_agent` WHERE  travel_agent_admin = '{$travel_agent_name}' limit 1";
		$user_balance_price = \Yii::$app->db->createCommand($sql)->queryOne();
		
		return $this->render("payment",['order_number'=>$order_number,'total_pay_price'=>$total_pay_price,'user_balance_price'=>$user_balance_price['current_amount']]);
		
	}
	
	//验证代理商支付密码
	public function actionCheckagentpaypass(){
		$password = isset($_POST['password'])?$_POST['password']:'';
		$travel_agent_name = Yii::$app->user->identity->travel_agent_admin;
		$sql = "SELECT pay_password FROM `v_travel_agent` WHERE  travel_agent_admin = '{$travel_agent_name}' limit 1";
		$agent_pass = \Yii::$app->db->createCommand($sql)->queryOne();
		if($password != $agent_pass['pay_password']){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	//数据保存，支付状态改变，余额扣除
	public function actionPaymentgopay(){
		$travel_agent_name = Yii::$app->user->identity->travel_agent_admin;
		$password = isset($_POST['password'])?$_POST['password']:'';
		$order_num = isset($_POST['order_num'])?$_POST['order_num']:'';
		$pay_price = isset($_POST['pay_price'])?$_POST['pay_price']:'0';
		
		$transaction =\Yii::$app->db->beginTransaction();
		try {
			//余额扣除
			$sql = "UPDATE `v_travel_agent` SET current_amount=current_amount-{$pay_price} WHERE travel_agent_admin='{$travel_agent_name}' AND pay_password='{$password}'";
			\Yii::$app->db->createCommand($sql)->execute();
			
			//根据订单号查订单基本信息
			$sql = "SELECT cruise_code,voyage_code,travel_agent_name FROM `v_voyage_order` WHERE order_serial_number='{$order_num}'";
			$order_detail = \Yii::$app->db->createCommand($sql)->queryOne();
			
			$field_name = ['passport_number_one','passport_number_two','passport_number_three','passport_number_four'];
			
			$sql = "SELECT cabin_type_code,cabin_name,check_in_number,passport_number_one,passport_number_two,passport_number_three,passport_number_four FROM `v_voyage_order_detail` WHERE order_serial_number='{$order_num}'";
			$order_room = \Yii::$app->db->createCommand($sql)->queryAll();
			
			$sql_ticket = "INSERT INTO `v_c_voyage_ticket` (cruise_code,voyage_code,travel_agent_name,order_serial_number,m_code,cabin_type_code,cabin_id,cabin_name,cabin_bed_index,ticket_type,additional_change,shore_excursion) VALUES ";
			$where_str = '';
			foreach ($order_room as $v){
				//查询用户在会员表中的m_code
				for($i=0;$i<$v['check_in_number'];$i++){
					//m_code查询
					$sql = "SELECT m_code FROM `v_membership` WHERE passport_number='{$v[$field_name[$i]]}'";
					$m_code =  \Yii::$app->db->createCommand($sql)->queryOne();
					//cabin_id查询
					$sql = "SELECT a.id FROM `v_c_voyage_cabin` a 
					LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id
					LEFT JOIN `v_c_voyage` c ON a.voyage_id=c.id
					WHERE a.cabin_name='{$v['cabin_name']}' AND b.type_code='{$v['cabin_type_code']}' AND c.voyage_code='{$order_detail['voyage_code']}' LIMIT 1";
					$cabin_id = \Yii::$app->db->createCommand($sql)->queryOne();
					//附加费，保险查询
					$sql = "SELECT price_type,additional_price_id FROM `v_voyage_order_additional_price` WHERE order_serial_number='{$order_num}' AND passport_number='{$v[$field_name[$i]]}' AND price_type!=1";
					$add_price = \Yii::$app->db->createCommand($sql)->queryAll();
					$shore_ids = '';
					$add_ids = '';
					foreach ($add_price as $vv){
						if($vv['price_type'] == 2){$add_ids .= $vv['additional_price_id'].',';}
						if($vv['price_type'] == 3){$shore_ids .= $vv['additional_price_id'].',';}
					}
					$shore_ids = $shore_ids!=''?trim($shore_ids,','):null;
					$add_ids = $add_ids!=''?trim($add_ids,','):null;
					$bed_index = ($i+1);
					$where_str .= "('{$order_detail['cruise_code']}','{$order_detail['voyage_code']}','{$order_detail['travel_agent_name']}','{$order_num}','{$m_code['m_code']}','{$v['cabin_type_code']}','{$cabin_id['id']}','{$v['cabin_name']}','{$bed_index}','1','{$add_ids}','{$shore_ids}'),";
				}
				
			}
			$where_str = trim($where_str,',');
			$sql_ticket = $sql_ticket.$where_str;
			\Yii::$app->db->createCommand($sql_ticket)->execute();
			
			
			//订单表支付状态修改
			$time = date('Y-m-d H:i:s',time());
			$sql = "UPDATE `v_voyage_order` SET pay_type='2',pay_time='{$time}',pay_status='1' WHERE order_serial_number='{$order_num}'";
			\Yii::$app->db->createCommand($sql)->execute();
			
			$transaction->commit();
			echo 1;
		} catch(Exception $e) {
			$transaction->rollBack();
			echo 0;
		}
		
		
	}
	
	
	
	
	//手动导入
	public function actionDataimport(){
		$voyage_code = isset($_GET['code'])?$_GET['code']:'';
		return $this->render("data_import",['code'=>$voyage_code]);
		
	}
	
	//验证时是否重复购票
	public function actionCheckrepeatbuyticket(){
		$voyage_code = isset($_POST['code'])?$_POST['code']:'';
		$passport = isset($_POST['passport'])?$_POST['passport']:'';
		
		$query  = new Query();
		$count = $query->select(['*'])
		->from('v_voyage_order_additional_price')
		->where(['voyage_code'=>$voyage_code,'passport_number'=>$passport])
		->count();
		if((int)$count > 0){
			echo 1;				
		}else{echo 0;}
		
	}
	
	
	
	
	
}