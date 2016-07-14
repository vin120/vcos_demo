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
use yii\helpers\Url;

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
		if(isset($_SESSION['person_info'])){
			unset($_SESSION['person_info']);
		}
		if(isset($_SESSION['cabins_info'])){
			unset($_SESSION['cabins_info']);
		}
		if(isset($_SESSION['additional_info'])){
			unset($_SESSION['additional_info']);
		}
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
		
		$uset_info_result = '';
		if(isset($_SESSION['person_info'])){
			$data = $_SESSION['person_info'];
			$data = json_decode($data);
			$data = $this->object_to_array($data);
			$uset_info_result = $data[0]['person_info'];
		}
		return $this->render("add_uest_info",['uset_info_result'=>$uset_info_result,'code'=>$voyage_code,'country_result'=>$result]);
	}
	
	/**验证session中是否已经存在该护照号**/
	public function actionChecksessionpassport(){
		$passport = isset($_GET['passport'])?$_GET['passport']:'';
		$success = 1;
		if(isset($_SESSION['person_info'])){
			$data = $_SESSION['person_info'];
			$data = json_decode($data);
			$data = $this->object_to_array($data);
			foreach ($data[0]['person_info'] as $row){
				if($row['passport'] == $passport){
					$success = 0;break;
				}
			}
		}
		echo $success;
		
	}
	
	/***验证session中是否存在同姓名性别生日的乘客***/
	public function actionChecksessionnamegenderbirth(){
		$full_name = isset($_POST['full_name'])?$_POST['full_name']:'';
		$gender = isset($_POST['gender'])?$_POST['gender']:'';
		$birth = isset($_POST['birth'])?$_POST['birth']:'';
		$success = 1;
		if(isset($_SESSION['person_info'])){
			$data = $_SESSION['person_info'];
			$data = json_decode($data);
			$data = $this->object_to_array($data);
			foreach ($data[0]['person_info'] as $row){
				if(($row['full_name'] == $full_name) && ($row['gender'] == $gender) && ($row['birth'] == $birth) ){
					$success = 0;break;
				}
			}
		}
		echo $success;
		
	}
	
	/**获取session中乘客信息*/
	public function actionGetsessionpersoninfo(){
		$passport = isset($_GET['passport'])?$_GET['passport']:'';
		
		$persion_info = array();
		if(isset($_SESSION['person_info'])){
			$data = $_SESSION['person_info'];
			$data = json_decode($data);
			$data = $this->object_to_array($data);
			foreach ($data[0]['person_info'] as $row){
				if($row['passport'] == $passport){
					$persion_info = $row;break;
				}
			}
		}
		if(!empty($persion_info)){
			echo json_encode($persion_info);
		}else{
			echo 0;
		}
	}
	
	public function actionDelsessionpersoninfo(){
		
		$passport = isset($_GET['passport'])?$_GET['passport']:'';
		$success = 0;
		if(isset($_SESSION['person_info'])){
			$data = $_SESSION['person_info'];
			$data = json_decode($data);
			$data = $this->object_to_array($data);
			foreach ($data[0]['person_info'] as $k=>$row){
				if($row['passport'] == $passport){
					$success = 1;
					unset($data[0]['person_info'][$k]);
				}
			}
			$data = json_encode($data);
			$_SESSION['person_info'] = $data;
		
		}
		
		echo $success;
		
	}
	
	public function actionSavesessionadduestinfo(){
		$json_str = isset($_POST['json_str'])?$_POST['json_str']:'';
		$passport = isset($_POST['passport'])?$_POST['passport']:'';
		$act_op = isset($_POST['act_op'])?(int)trim($_POST['act_op']):2;	//区分是添加还是编辑保存，1：编辑2：添加
		if($act_op == 2){
			if(isset($_SESSION['person_info'])){
				$data = $_SESSION['person_info'];
				$data = json_decode($data);
				$data = $this->object_to_array($data);
				
				$json_data = json_decode($json_str);
				$json_data = $this->object_to_array($json_data);
				$data[0]['person_info'][] = $json_data;
				
				$data = json_encode($data);
				$_SESSION['person_info'] = $data;
				
			}else{
				$data = '[{"person_info":['.$json_str.']}]';
				$_SESSION['person_info'] = $data;
			}
		}else if($act_op == 1){
			//编辑
			$json_data = json_decode($json_str);
			$json_data = $this->object_to_array($json_data);
			
			
			$data = $_SESSION['person_info'];
			$data = json_decode($data);
			$data = $this->object_to_array($data);
			foreach ($data[0]['person_info'] as $k=>$row){
				if($row['passport'] == $passport){
					unset($data[0]['person_info'][$k]);
					$data[0]['person_info'][$k] = $json_data;
					break;
				}
			}
			$data = json_encode($data);
			$_SESSION['person_info'] = $data;
		}
		
	}
	
	public function actionSavejsonchooseandreservation(){
		$json_str = isset($_POST['json_str'])?trim($_POST['json_str'],','):'';
		if(isset($_SESSION['cabins_info'])){
			unset($_SESSION['cabins_info']);
		}
		$json_str = '[{"cabins_info":['.$json_str.']}]';
		$_SESSION['cabins_info'] = $json_str;
	
	}
	
	public function actionDeljsonchooseandreservation(){
		$cabin_types = isset($_POST['cabin_types'])?trim($_POST['cabin_types'],','):'';
		$cabin_types = explode(',', $cabin_types);
		if(isset($_SESSION['cabins_info'])){
			$cabins_info = json_decode($_SESSION['cabins_info']);
			$cabins_info = $this->object_to_array($cabins_info);
			//var_dump($cabins_info);exit;
			foreach ($cabins_info[0]['cabins_info'] as $k=>$row){
				if(in_array($row['type'], $cabin_types)){
					unset($cabins_info[0]['cabins_info'][$k]);
				}
			}
		
			$cabins_info = json_encode($cabins_info);
			$_SESSION['cabins_info'] = $cabins_info;
			
		}
		
	}
	
	//数组对象转数组（支持多维）
	public function object_to_array($obj){
		$_arr = is_object($obj) ? get_object_vars($obj) :$obj;
		$arr = array();
		foreach ($_arr as $key=>$val){
			$val = (is_array($val) || is_object($val)) ? $this->object_to_array($val):$val;
			$arr[$key] = $val;
		}
		
		return $arr;
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
		$all_data = $query->select(['b.type_code','c.type_name','count(a.cabin_name) count','e.check_num','b.live_number'])
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
	   $cabins_info  = array();
	   if(isset($_SESSION['cabins_info'])){
	   		$cabins_info = $_SESSION['cabins_info'];	
	   		$cabins_info = json_decode($cabins_info);
	   		$cabins_info = $this->object_to_array($cabins_info);
	   		$cabins_info = $cabins_info[0]['cabins_info'];
	   }
				
		return $this->render("choose_and_reservation",['cabins_info'=>$cabins_info,'code'=>$voyage_code,'all_data'=>$all_data,'order_data'=>$order_data]);
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
		
		$person_info = array();
		$person_info = $_SESSION['person_info'];
		$person_info = json_decode($person_info);
		$person_info = $this->object_to_array($person_info);
		$person_info = $person_info[0]['person_info'];
		$cabins_info = array();
		$cabins_info = $_SESSION['cabins_info'];
		$cabins_info = json_decode($cabins_info);
		$cabins_info = $this->object_to_array($cabins_info);
		$cabins_info = $cabins_info[0]['cabins_info'];
		

		return $this->render("surcharge_cabinassignments",['cabins_info'=>$cabins_info,'person_info'=>$person_info,'code'=>$voyage_code,'shore'=>$shore,'surcharge'=>$surcharge]);
	}
	
	public function actionSavesessionadditional(){
		$additional_json = isset($_POST['additional_json'])?$_POST['additional_json']:'';
		if(isset($_SESSION['additional_info'])){
			unset($_SESSION['additional_info']);
		}
		$_SESSION['additional_info'] = $additional_json;
		
	}
	
	
	//订单开始-start--------------------------------------------------------------------
	//下单保存数据
	/***
	 *  shore_excursion shore_id:user_passport,user_passport/shore_id:user_passport,user_passport
	 *  Insurance 
	 * 
	 */
	public function actionOrdersave(){
		
		$voyage_code = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		$agent_name = Yii::$app->user->identity->travel_agent_admin;
		$time = date('Y-m-d H:i:s',time());
		
		//生成订单号
		$order_serial_number = Helper::createOrderno();
		
		//获取session信息
		$person_info = array();
		$person_info = $_SESSION['person_info'];
		$person_info = json_decode($person_info);
		$person_info = $this->object_to_array($person_info);
		$person_info = $person_info[0]['person_info'];
		
		$cabins_info = array();
		$cabins_info = $_SESSION['cabins_info'];
		$cabins_info = json_decode($cabins_info);
		$cabins_info = $this->object_to_array($cabins_info);
		$cabins_info = $cabins_info[0]['cabins_info'];
		
		$additional_info = array();
		$additional_info = $_SESSION['additional_info'];
		$additional_info = json_decode($additional_info);
		$additional_info = $this->object_to_array($additional_info);
		
		$shore_info = $additional_info[0]['additional_json'][0]['shore'];
		$insurance_info = $additional_info[0]['additional_json'][1]['insurance'];
		$room_info = $additional_info[0]['additional_json'][2]['cabins'];
		
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
			->from('v_c_preferential_strategy')
			->where(['voyage_code'=>$voyage['voyage_code'],'status'=>'1'])
			->all();
			
			
			$this->Membershipsave($connecton,$agent_name,$person_info);
			
			$this->Travelagentmembershipsave($connecton,$agent_name,$person_info);

			//封装每个乘客的优惠详情
			$person_preferential = $this->Encapsulationpersonpreferential($voyage,$person_info);
			
			//录入旅客优惠详情表 `v_voyage_order_preferential_detail`
			$this->Orderpreferentialdetail($connecton,$order_serial_number,$person_preferential);
			
			//先计算每个房间所用费用
			$cabin_type_price = $this->Cabinssingleprice($connecton,$voyage,$strategy,$room_info,$person_info,$person_preferential);
			
			$this->Voyageordersave($connecton,$order_serial_number,$person_info,$cabin_type_price,$shore_info,$insurance_info,$agent_name,$voyage,$surcharge_arr);
			
			$this->Orderadditionalprice($connecton,$order_serial_number,$person_info,$shore_info,$insurance_info,$voyage);
			
			$this->Orderdetail($connecton,$order_serial_number,$room_info,$cabin_type_price,$agent_name,$voyage);
			
			$transaction->commit();
			$success = 1;
		}catch (Exception $e){
			$transaction->rollBack();
			$success = 0;
		}
		
		if($success == 1){
			//清空session
			unset($_SESSION['person_info']);
			unset($_SESSION['cabins_info']);
			unset($_SESSION['additional_json']);
			return $this->redirect(Url::toRoute(['/bookingticket/orderinformation','order_number'=>$order_serial_number]));
		}else{
			return $this->redirect(Url::toRoute(['/bookingticket/surchargecabinassignments','code'=>$voyage['voyage_code']]));
		}
	}
	
	
	//order_membership_save
	/***
	 * 存在跳过，不存在新增
	 * 判断护照号
	 */
	protected function Membershipsave($connecton,$agent_name,$person_info){
		$time = date('Y-m-d H:i:s',time());
		$sql_data = 'INSERT INTO `v_membership` (m_code,last_name,first_name,full_name,passport_number,gender,country_code,email,mobile_number,birthday,birth_place,create_by,create_time) VALUES ';
		$date_data = 'INSERT INTO `v_m_passport` (passport_number,date_issue,date_expire,full_name,last_name,first_name,gender,birthday,birth_place,country_code) VALUES ';
		$sql_data_where = '';
		$date_data_where = '';
		foreach ($person_info as $k=>$v){
			//查询是否存在该护照号
			$sql = "SELECT count(*) count FROM `v_membership` WHERE passport_number='".$v['passport']."'";
			$count = $connecton->createCommand($sql)->queryOne();
			if($count['count']==0){
				$m_code = CreateMember::createMemberNumber();
				$sql_data_where .= '("'.$m_code.'","'.$v['last_name'].'","'.$v['first_name'].'","'.$v['full_name'].'","';
				$sql_data_where .= $v['passport'].'","'.$v['gender'].'","'.$v['nationalify'].'","'.$v['email'].'","';
				$sql_data_where .= $v['phone'].'","'.Helper::GetCreateTime($v['birth']).'","'.$v['birth_place'].'","';
				$sql_data_where .= $agent_name.'","'.$time.'"),';
				
				$date_data_where .= '("'.$v['passport'].'","'.Helper::GetCreateTime($v['issue']).'","'.Helper::GetCreateTime($v['expiry']).'","';
				$date_data_where .= $v['full_name'].'","'.$v['last_name'].'","'.$v['first_name'].'","'.$v['gender'].'","'.Helper::GetCreateTime($v['birth']).'","';
				$date_data_where .= $v['birth_place'].'","'.$v['nationalify'].'"),';
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
	protected function Travelagentmembershipsave($connecton,$agent_name,$person_info){
		$time = date('Y-m-d H:i:s',time());
		
		$sql_insert = 'INSERT INTO `v_travelagent_membership` (full_name,last_name,first_name,gender,birthday,birth_place,country_code,passport_num,date_issue,date_expire,email,phone,create_by,create_time) VALUES ';
		$sql_insert_where = '';
		foreach ($person_info as $k=>$v){
			//查询是否存在该护照号
			$sql = "SELECT count(*) count FROM `v_travelagent_membership` WHERE passport_num='".$v['passport']."' AND create_by='$agent_name'";
			$count = Yii::$app->db->createCommand($sql)->queryOne();
			if($count['count']==0){
				$sql_insert_where .= '("'.$v['full_name'].'","'.$v['last_name'].'","'.$v['first_name'].'","';
				$sql_insert_where .= $v['gender'].'","'.Helper::GetCreateTime($v['birth']).'","'.$v['birth_place'].'","'.$v['nationalify'].'","';
				$sql_insert_where .= $v['passport'].'","'.Helper::GetCreateTime($v['issue']).'","'.Helper::GetCreateTime($v['expiry']).'","';
				$sql_insert_where .= $v['email'].'","'.$v['phone'].'","'.$agent_name.'","'.$time.'"),';
			}else{
				$sql_update = 'UPDATE `v_travelagent_membership` SET ';
				$sql_update .= 'full_name="'.$v['full_name'].'",last_name="'.$v['last_name'].'",first_name="'.$v['first_name'].'",';
				$sql_update .= 'gender="'.$v['gender'].'",birthday="'.Helper::GetCreateTime($v['birth']).'",birth_place="'.$v['birth_place'].'",';
				$sql_update .= 'country_code="'.$v['nationalify'].'",date_issue="'.Helper::GetCreateTime($v['issue']).'",date_expire="'.Helper::GetCreateTime($v['expiry']).'",';
				$sql_update .= 'email="'.$v['email'].'",phone="'.$v['phone'].'" ';
				$sql_update .= " WHERE passport_num='".$v['passport']."' AND create_by='$agent_name'";
				
				$connecton->createCommand($sql_update)->execute();
			}
		}
		$sql_insert = $sql_insert.trim($sql_insert_where,',');
		//var_dump($sql_insert);
		if($sql_insert_where != '') $connecton->createCommand($sql_insert)->execute();
			
	}
	
	/***
	 * 封装每个乘客的优惠详情
	 */
	protected function Encapsulationpersonpreferential($voyage,$person_info){
		$children_age = Yii::$app->params['children_age'];
		$old_age = Yii::$app->params['old_age'];
		$ADT = Yii::$app->params['ADT'];
		
		/**判断是否是提前购票开始**/
		$curr_time_is_advance = 0;
		$startdate=strtotime(date('Y-m-d',time()));
		$enddate=strtotime(substr($voyage['start_time'],0,10));
		$days=round(($enddate-$startdate)/3600/24);
		if((int)$days >= (int)$ADT){
			$curr_time_is_advance = 1;
		}
		/**判断是否是提前购票结束**/
		
		//封装每个乘客优惠详情
		$start_ship = substr($voyage['start_time'],5,5); 	//开航日期 03-31
		$person_preferential = array();		//per:成人1-儿童2/其他：0无1有
		foreach ($person_info as $row){
			$birth = Helper::GetCreateTime($row['birth']);	//2016-03-31
			$age = Helper::Getage($birth);
			//成人儿童区分,年龄优惠
			if((int)$age > (int)$children_age){
				$person_preferential[$row['passport']]['per'] = '1';
				if((int)$age >= (int)$old_age){
					$person_preferential[$row['passport']]['age'] = '1';
				}else{
					$person_preferential[$row['passport']]['age'] = '0';
				}
			}else{
				$person_preferential[$row['passport']]['per'] = '2';
				$person_preferential[$row['passport']]['age'] = '1';
			}
			//生日优惠
			if($start_ship == substr($birth,5,5)){
				$person_preferential[$row['passport']]['birthday'] = '1';
			}else{
				$person_preferential[$row['passport']]['birthday'] = '0';
			}
			//判断预订优惠
			if((int)$curr_time_is_advance == 1){
				$person_preferential[$row['passport']]['adt'] = '1';
			}else{
				$person_preferential[$row['passport']]['adt'] = '0';
			}
				
		}
		return $person_preferential;
	}
	
	//录入旅客优惠详情表 `v_voyage_order_preferential_detail`
	protected function Orderpreferentialdetail($connecton,$order_serial_number,$person_preferential){
		
		$sql = "INSERT INTO `v_voyage_order_preferential_detail` (order_serial_number,passport,preferential_type) VALUES ";
		$sql_val = '';
		foreach ($person_preferential as $key=>$val){
				//老年优惠
				if(((int)$val['age'] == 1) && ((int)$val['per'] == 1)){
					$sql_val .= "('{$order_serial_number}','{$key}','2'),";
				}
				//儿童优惠
				if(((int)$val['age'] == 1) && ((int)$val['per'] == 2)){
					$sql_val .= "('{$order_serial_number}','{$key}','1'),";
				}
				//生日优惠
				if((int)$val['birthday'] == 1){
					$sql_val .= "('{$order_serial_number}','{$key}','4'),";
				}
				//提前订票优惠
				if((int)$val['adt'] == 1){
					$sql_val .= "('{$order_serial_number}','{$key}','3'),";
				}
			
		}
		$sql  = $sql.trim($sql_val,',');
		if($sql_val!=''){$connecton->createCommand($sql)->execute();}
	}
	
	
	/****
	 * 计算每间舱房费用
	 */
	protected function Cabinssingleprice($connecton,$voyage,$strategy,$room_info,$person_info,$person_preferential){
		$children_age = Yii::$app->params['children_age'];
		$old_age = Yii::$app->params['old_age'];
		$ADT = Yii::$app->params['ADT'];
		
		/**判断是否是提前购票开始**/
		$curr_time_is_advance = 0;
		$startdate=strtotime(date('Y-m-d',time()));
		$enddate=strtotime(substr($voyage['start_time'],0,10));
		$days=round(($enddate-$startdate)/3600/24);
		if((int)$days >= (int)$ADT){
			$curr_time_is_advance = 1;
		}
		/**判断是否是提前购票结束**/
		
		//封装优惠数组
		$preferential_array = array();
		$preferential_array['old'] = 0;
		$preferential_array['children'] = 0;
		$preferential_array['birthday'] = 0;
		$preferential_array['adt'] = 0;
		foreach ($strategy as $row){
			$old_where = 'age>='.$old_age;
			$child_where = 'age<='.$children_age;
			$birthday_where = 'birthday';
			$adt_where = 'ADT>='.$ADT;
		
			if($row['p_where'] == $old_where){
				$preferential_array['old'] = (float)$row['p_price']/100;
			}else if($row['p_where'] == $child_where){
				$preferential_array['children'] = (float)$row['p_price']/100;
			}else if($row['p_where'] == $birthday_where){
				$preferential_array['birthday'] = (float)$row['p_price']/100;
			}else if($row['p_where'] == $adt_where){
				$preferential_array['adt'] = (float)$row['p_price']/100;
			}
		
		}
		//封装每间房价格
		$cabin_type_price = array();
		//循环每间房
		foreach ($room_info as $k=>$row){
			//查询舱房价格
			$sql = "SELECT a.* FROM `v_c_cabin_pricing` a LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id  WHERE b.type_code='{$row['type']}' AND a.voyage_code='{$voyage['voyage_code']}'";
			$pricing_result = $connecton->createCommand($sql)->queryOne();
			
			$bed_num = $pricing_result['check_num'];
			$th_1_price = $pricing_result['bed_price'];
			$th_3_price = $pricing_result['last_bed_price'];
			$th_1_empty = (float)$pricing_result['2_empty_bed_preferential']/100;
			$th_3_empty = (float)$pricing_result['3_4_empty_bed_preferential']/100;
			
			$person_passport = array();
			foreach ($row['pereson'] as $v){
				if(!empty($v)){
					$person_passport[] = $v;
				}
			}
			
			//先判断是否有提前预订(若有提前预订则全部成员按一二床位算)
			$price_sum = 0;		//房间总价
			$other_price_num = 0;	//其他优惠价
			$person_sum = count($person_passport);			//房间总入住人数
			$no_person_bed = (int)$bed_num - (int)$person_sum;	//空床数
			
			if($curr_time_is_advance == 1){
				foreach ($person_passport as $p_row){
					$price_sum_only = (float)$th_1_price;
					//年龄优惠
					if((int)$person_preferential[$p_row]['age'] == 1){
						//判断是儿童优惠还是老年优惠
						if((int)$person_preferential[$p_row]['per'] == 1){	//老年优惠
							$price_sum_only = (float)$price_sum_only*(float)$preferential_array['old'];	
						}else if((int)$person_preferential[$p_row]['per'] == 2){	//儿童优惠
							$price_sum_only = (float)$price_sum_only*(float)$preferential_array['children'];
						}
					}
					
					//生日优惠
					if((int)$person_preferential[$p_row]['birthday'] == 1){
						$price_sum_only = (float)$price_sum_only*(float)$preferential_array['birthday'];
					}
					
					//提前预订优惠
					if((int)$person_preferential[$p_row]['adt'] == 1){
						$price_sum_only = (float)$price_sum_only*(float)$preferential_array['adt'];
					}
					
					$price_sum = ((float)$price_sum + (float)$price_sum_only);
					$other_price_num += ((float)$th_1_price - (float)$price_sum_only);
				}
			}else{
				//判断是否有乘客什么优惠都无，排前面
				$no_prefere = 0;
				$adult = 0;
				$child = 0;
				foreach ($person_passport as $c_val){
					if((int)$person_preferential[$c_val]['per']==1){
						$adult += 1;
					}else if((int)$person_preferential[$c_val]['per']==2){
						$child += 1;
					}
				}
				
				foreach ($person_passport as $p_row){
					$curr_price = 0;
					$price_sum_only = 0;
					
					if(((int)$person_preferential[$p_row]['age']==0) && ((int)$person_preferential[$p_row]['birthday'] == 0) && ((int)$person_preferential[$p_row]['adt'] == 0)){
						$no_prefere += 1;
						if($no_prefere>=2){
							//按三号床位价格计算
							$price_sum_only += (float)$th_3_price;
							$curr_price = (float)$th_3_price;
						}else{
							//按一号床位价格计算
							$price_sum_only += (float)$th_1_price;
							$curr_price = (float)$th_1_price;
						}
					}else{
						//有优惠
						//判断成人还是儿童
						if((int)$person_preferential[$p_row]['per']==1){
							$price_sum_only += (float)$th_1_price;
							$curr_price = (float)$th_1_price;
							
							if((int)$person_preferential[$p_row]['age']==1){
								$price_sum_only = (float)$price_sum_only * (float)$preferential_array['old'];
							}
						}else if((int)$person_preferential[$p_row]['per']==2){
							if((int)$person_preferential[$p_row]['birthday']==1){
								$price_sum_only += (float)$th_1_price;
								$curr_price = (float)$th_1_price;
							}else{
								if($child>=2){
									//三号床
									$price_sum_only += (float)$th_3_price;
									$curr_price = (float)$th_3_price;
								}else{
									//一号床
									$price_sum_only += (float)$th_1_price;
									$curr_price = (float)$th_1_price;
								}
							}
							
							if((int)$person_preferential[$p_row]['age']==1){
								$price_sum_only = (float)$price_sum_only * (float)$preferential_array['children'];
							}
						}
						//生日优惠
						if((int)$person_preferential[$p_row]['birthday']==1){
							$price_sum_only =  (float)$price_sum_only * (float)$preferential_array['birthday'];
						}
					}
					
					$price_sum = ((float)$price_sum + (float)$price_sum_only);
					$other_price_num += ((float)$curr_price - (float)$price_sum_only);
					
				}
			}
			
			
			//计算空房
			if($no_person_bed>0){
				//判断1/2床是否住满
				if((int)$person_sum >= 2){
					//1/2床已经满人，只需计算三号床空床
					$price_sum += ((int)$bed_num - (int)$person_sum)*(float)$th_3_price*(float)$th_3_empty;
				}else{
					//1/2床存在空床
					$price_sum += (2-(int)$person_sum)*(float)$th_1_price*(float)$th_1_empty;
					$price_sum += ((int)$bed_num-2)*(float)$th_3_price*(float)$th_3_empty;
				}
			}
			
			$cabin_type_price[$row['type']]['cabin_type'] = $row['type'];
			$cabin_type_price[$row['type']]['price'] = $price_sum;
			$cabin_type_price[$row['type']]['other'] = $other_price_num;
			
		}
		
		
		return $cabin_type_price;
		
	}
	
	
	//voyage_order_save
	/***
	 * 一个订单一条数据
	 */
	protected function Voyageordersave($connecton,$order_serial_number,$person_info,$cabin_type_price,$shore_info,$insurance_info,$agent_name,$voyage,$surcharge_arr){
		
		$time = date('Y-m-d H:i:s',time());
		$room_price_sum = 0;		//房间总价
		$preferential_price_sum = 0;		//优惠总价
		$person_sum = count($person_info);			//总人数
		
		foreach ($cabin_type_price as $row){
			$room_price_sum += (float)$row['price'];
			$preferential_price_sum += (float)$row['other'];
		}
		
		$total_tax_pric_sum = (float)$room_price_sum * ($voyage['ticket_taxes']/100);	//税价
		
		$harbour_taxes_price_sum = $voyage['harbour_taxes'] * (int)$person_sum;       //港口费
		
		$contains_price_sum = 0;    //包含产品总价
		foreach ($shore_info as $row){
			$sql = "SELECT price FROM `v_c_shore_excursion_lib` WHERE se_code='".$row['type']."'";
			$sh_price = $connecton->createCommand($sql)->queryOne();
			$contains_price_sum += (float)$sh_price['price']*((int)count($row['person_key']));
		}
		
		$additional_price_sum = 0;	//保险（附加费）
		foreach ($insurance_info as $row){
			$additional_price_sum += (float)$surcharge_arr[$row['type']]*((int)count($row['person_key']));
		}
		
		$addition_sum = (float)$contains_price_sum + (float)$additional_price_sum;
		$order_price_sum = (float)$room_price_sum + (float)$total_tax_pric_sum + (float)$harbour_taxes_price_sum + (float)$addition_sum;
		
		$sql = "INSERT INTO `v_voyage_order` (cruise_code,voyage_code,order_serial_number,order_type,travel_agent_name,create_order_time,preferential_price,total_pay_price,total_ticket_price,total_tax_pric,total_port_expenses,total_additional_price,source_code,source_type) VALUES ";
		$sql .= "('{$voyage['cruise_code']}','{$voyage['voyage_code']}','{$order_serial_number}','2','{$agent_name}','{$time}','{$preferential_price_sum}','{$order_price_sum}','{$room_price_sum}','{$total_tax_pric_sum}','{$harbour_taxes_price_sum}','{$addition_sum}','{$agent_name}','1')";
		
		$connecton->createCommand($sql)->execute();
		
	}
	
	//order_additional_price
	/***
	 * 1码头税，2附加费， 3观光路线  -》 单个人有几条添加几条数据
	 */
	protected function Orderadditionalprice($connecton,$order_serial_number,$person_info,$shore_info,$insurance_info,$voyage){
		
		//循环乘客录入码头税
		$sql = "INSERT INTO `v_voyage_order_additional_price` (voyage_code,order_serial_number,passport_number,price_type,additional_price) VALUES ";
		foreach ($person_info as $row){
			$sql .= "('{$voyage['voyage_code']}','{$order_serial_number}','{$row['passport']}','1','{$voyage['harbour_taxes']}'),";
		}
		$sql = trim($sql,',');
		$connecton->createCommand($sql)->execute();
		
		$sql = "INSERT INTO `v_voyage_order_additional_price` (voyage_code,order_serial_number,passport_number,price_type,additional_price_id,additional_price) VALUES ";
		//循环包含产品录入观光路线
		$contains_sql = '';
		foreach ($shore_info as $row){
			$sh_sql = "SELECT a.price,b.id FROM `v_c_shore_excursion_lib` a LEFT JOIN `v_c_shore_excursion` b ON a.id=b.sh_id WHERE a.se_code='".$row['type']."'";
			$sh_price = $connecton->createCommand($sh_sql)->queryOne();
			foreach ($row['person_key'] as $val){
				$contains_sql .= "('{$voyage['voyage_code']}','{$order_serial_number}','{$val}','3','{$sh_price['id']}','{$sh_price['price']}'),";
		
			}
		}
		$contains_sql = trim($contains_sql,',');
		
		//循环附加产品录入附加费
		$addition_sql = '';
		foreach ($insurance_info as $row){
			$su_sql = "SELECT a.cost_price,b.id FROM `v_c_surcharge_lib` a LEFT JOIN `v_c_surcharge` b ON a.id=b.cost_id WHERE a.id='".$row['type']."'";
			$su_price = $connecton->createCommand($su_sql)->queryOne();
			foreach ($row['person_key'] as $val){
				$addition_sql .= "('{$voyage['voyage_code']}','{$order_serial_number}','{$val}','2','{$su_price['id']}','{$su_price['cost_price']}'),";
			}
		}
		$addition_sql = trim($addition_sql,',');
		
		$sql .= $contains_sql.','.$addition_sql;
		$connecton->createCommand($sql)->execute();
		
	}
	
	//order_detail
	/****
	 * 几间房几条数据
	 */
	protected function Orderdetail($connecton,$order_serial_number,$room_info,$cabin_type_price,$agent_name,$voyage){
		
		$user_name_arr = ['one','two','three','four'];
		$time = date('Y-m-d H:i:s',time());
		$sql_data = '';
		foreach ($room_info as $k=>$row){
			$set_str = '';
			$val_str = '';
			$live_num = 0;
			for($i=0;$i<count($row['pereson']);$i++){
				if(!empty($row['pereson'][$i])){
					$set_str .= "passport_number_".$user_name_arr[$i].',';
					$val_str .= "'".$row['pereson'][$i]."',";
					++$live_num;
				}
			}
			
			//根据cabin_type_code获取随机房间号
			$sql = "select cabin_name from v_voyage_order_detail where voyage_code='{$voyage['voyage_code']}' AND cabin_type_code='{$row['type']}'";
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
			WHERE a.voyage_id='{$voyage['id']}' AND b.type_code='{$row['type']}' AND a.cabin_status='1'
			".$room_name_in_where." limit 1";
			$room_name = $connecton->createCommand($sql)->queryOne();
			
			$cabin_price = $cabin_type_price[$row['type']]['price'];
			$tax_price = (float)$cabin_price * ((float)$voyage['ticket_taxes']/100);
			$sql = "INSERT INTO `v_voyage_order_detail` (order_serial_number,voyage_code,cabin_type_code,cabin_name,check_in_number,cabin_price,tax_price,".$set_str."assign_cabin_status,status,create_time) VALUES ";
			$sql .= "('{$order_serial_number}','{$voyage['voyage_code']}','{$row['type']}','{$room_name['cabin_name']}','{$live_num}','{$cabin_price}','{$tax_price}',".$val_str."'1','0','{$time}')";
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