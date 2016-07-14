<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use frontend\components\Helper;
use frontend\components\CreateMember;
use frontend\models\LoginForm;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
//use app\extensions\smtp;



class RouteController extends Controller
{
	public $enableCsrfValidation = false;
	
	public function actionIndex(){
		
		//清空session
		session_start();
		if(isset($_SESSION['cabins_data'])){
			unset($_SESSION['cabins_data']);
		}
		if(isset($_SESSION['cabins_noperson_info_data'])){
			unset($_SESSION['cabins_noperson_info_data']);
		}
		if(isset($_SESSION['additional_data'])){
			unset($_SESSION['additional_data']);
		}
		$query  = new Query();
		$cruise_result = $query->select(['a.cruise_code','b.cruise_name'])
		->from('v_cruise a')
		->join('LEFT JOIN','v_cruise_i18n b','a.cruise_code=b.cruise_code')
		->where(['b.i18n'=>'en'])
		->all();
		
		$query  = new Query();
		$port_result = $query->select(['a.port_code','b.port_name'])
		->from('v_c_port a')
		->join('LEFT JOIN','v_c_port_i18n b','a.port_code=b.port_code')
		->where(['b.i18n'=>'en'])
		->all();
		
		$cruise = '';
		$s_port = '';
		$e_port = '';
		$s_time = '';
		
		$where = '';
		$left_where = '';
		if($_POST){
			
			$cruise = isset($_POST['cruise'])?$_POST['cruise']:'';
			$s_port = isset($_POST['s_port'])?$_POST['s_port']:'';
			$e_port = isset($_POST['e_port'])?$_POST['e_port']:'';
			$s_time = isset($_POST['s_time'])?$_POST['s_time']:'';
			
			if($cruise!=''){
				$where .= " a.cruise_code='{$cruise}' AND";
			}
			if($s_port!='' || $e_port!=''){
				$left_where .= " LEFT JOIN `v_c_voyage_port` e ON a.id=e.voyage_id ";
			}
			if($s_port!=''){
				$where .= " e.ETA is null AND port_code='{$s_port}' AND";
			}
			if($e_port!=''){
				$where .= " e.ETD is null AND port_code='{$s_port}' AND";
			}
			
			if($s_time!=''){
				$s_time = Helper::GetCreateTime($s_time);
				$where .= " a.start_time like '{$s_time}%' AND";
			}
			
			$where = trim($where,'AND');
		}
		if($where==''){
			$where = 1;
		}
		
		$voyage_result_tmp = array();
		$sql = "SELECT a.id,a.voyage_code,a.ticket_price,b.voyage_name,a.start_time,a.end_time,d.map_img FROM `v_c_voyage` a 
				LEFT JOIN `v_c_voyage_i18n` b ON a.voyage_code=b.voyage_code
				LEFT JOIN `v_c_voyage_map` c ON a.id=c.voyage_id
				LEFT JOIN `v_c_voyage_map_i18n` d ON c.id=d.map_id AND d.i18n='en' ".$left_where."
				WHERE ".$where;
		$voyage_result = Yii::$app->db->createCommand($sql)->queryAll();
		foreach ($voyage_result as $row){
			$port = '';
			$sql = "SELECT b.port_name,a.ETA,a.ETD FROM `v_c_voyage_port` a LEFT JOIN `v_c_port_i18n` b ON a.port_code=b.port_code
					WHERE b.i18n='en' AND a.voyage_id='{$row['id']}'";
			$result = Yii::$app->db->createCommand($sql)->queryAll();
			
			foreach ($result as $v){
				if(empty($v['ETA'])){
					$row['s_port']=$v['port_name'];
				}else{
					$port .= $v['port_name'].'、';
				}
			}
			$port = trim($port,'、');
			$row['e_port']=$port;
			
			$voyage_result_tmp[] = $row;
		}
		if($s_time!=''){$s_time = Helper::GetDate($s_time);}
		return $this->render('route',['cruise'=>$cruise,'s_port'=>$s_port,'e_port'=>$e_port,'s_time'=>$s_time,'cruise_result'=>$cruise_result,'port_result'=>$port_result,'voyage_result'=>$voyage_result_tmp]);
	}
	
	
	
	public function actionSelectroom(){
		$voyage = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		
		$cabins_data = '';
		session_start();
		if(isset($_SESSION['cabins_data'])){
			$cabins_data = $_SESSION['cabins_data'];
			$cabins_data = json_decode($cabins_data);
			$cabins_data = $this->object_to_array($cabins_data);
		}
		//var_dump($cabins_data);exit;
		
		//该航线信息
		$query  = new Query();
		$voyage_result = $query->select(['a.id','a.voyage_code','b.voyage_name'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en','a.voyage_code'=>$voyage])
		->one();
		
		//舱房大类
		$query  = new Query();
		$bigcabin_result = $query->select(['a.id','a.price','b.class_name'])
		->from('v_c_cabin_big_class a')
		->join('LEFT JOIN','v_c_cabin_big_class_i18n b','a.id=b.class_id')
		->where(['b.i18n'=>'en'])
		->all();
		
		//var_dump($bigcabin_result);exit;
		$children_age = \Yii::$app->params['children_age'];
		$children_age = 'age<='.$children_age;
		
		//儿童优惠
		$query  = new Query();
		$children_pre = $query->select(['p_price','s_p_price'])
		->from('v_c_preferential_strategy')
		->where(['voyage_code'=>$voyage,'p_where'=>$children_age])
		->limit(1)
		->one();
		
		$cabin_all_arr = array();
		foreach ($bigcabin_result as $rows){
			//获取第一个大分类的舱房
			$query  = new Query();
			$cabin_result = $query->select(['a.*','c.*','d.type_name','e.check_num','e.bed_price','e.last_bed_price','e.2_empty_bed_preferential','e.3_4_empty_bed_preferential'])
			->from('v_c_cabin_category a')
			->join('LEFT JOIN','v_c_cabin_big_class b','a.class_id=b.id')
			->join('LEFT JOIN','v_c_cabin_type c','a.cabin_type_id=c.id')
			->join('LEFT JOIN','v_c_cabin_type_i18n d','c.type_code=d.type_code')
			->join('LEFT JOIN','v_c_cabin_pricing e','a.cabin_type_id=e.cabin_type_id')
			->where(['b.id'=>$rows['id'],'e.voyage_code'=>$voyage])
			->all();
			
			$cabin_result_tmp = array();
			//查询房间剩余数
			foreach ($cabin_result as $row){
				$sql = "select t1.count1,t2.count2
						from
						(select count(*) count1 from `v_c_voyage_cabin` where voyage_id='{$voyage_result['id']}' AND cabin_type_id='{$row['cabin_type_id']}') t1,
						(select count(*) count2 from `v_voyage_order_detail` where voyage_code='{$voyage_result['voyage_code']}' AND cabin_type_code ='{$row['type_code']}') t2";
				$count = Yii::$app->db->createCommand($sql)->queryOne();
				
				$value = (int)$count['count1'] - (int)$count['count2'];
				$row['room_num'] = $value;
				$cabin_result_tmp[] = $row;
			}
			$cabin_all_arr[$rows['id']]['name'] = $rows['class_name'];
			$cabin_all_arr[$rows['id']]['child'] = $cabin_result_tmp;
		
		}
		//var_dump($cabin_all_arr);exit;
		
		return $this->render('selectroom',['session_cabins_data'=>$cabins_data,'voyage_result'=>$voyage_result,'bigcabin_result'=>$bigcabin_result,'cabin_result'=>$cabin_all_arr,'children_pre'=>$children_pre]);
	}
	
	
	
	public function actionClearsessioncabinsnopersoninfo(){
		session_start();
		if(isset($_SESSION['additional_data'])){
			unset ($_SESSION['additional_data']);
		}
		
	}
	
	
	public function actionCheckpassportinfo(){
		$voyage_code = isset($_POST['voyage_code'])?$_POST['voyage_code']:'';
		$passport = isset($_POST['passport'])?$_POST['passport']:'';
		
		//附加表中验证
		$sql = "SELECT count(*) count FROM `v_voyage_order_additional_price` WHERE voyage_code='{$voyage_code}' AND passport_number='{$passport}'";
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		if($count['count']==0){
			echo 1;
		}else{
			echo 0;
		}
	}

	
	
	public function actionAdditional(){
		
		$voyage = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		
		//该航线信息
		$query  = new Query();
		$voyage_result = $query->select(['a.id','a.voyage_code','b.voyage_name'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en','a.voyage_code'=>$voyage])
		->one();
		
		$query  = new Query();
		$shore = $query->select(['a.id','b.price','c.se_name','c.se_info','c.se_code'])
		->from('v_c_shore_excursion a')
		->join('LEFT JOIN','v_c_shore_excursion_lib b','a.sh_id=b.id')
		->leftJoin('v_c_shore_excursion_lib_i18n c','b.se_code=c.se_code ')
		->where(['c.i18n'=>'en','a.status'=>'1','a.voyage_code'=>$voyage])
		->all();
		
		
		$query  = new Query();
		$surcharge = $query->select(['a.id','c.cost_name','c.cost_desc','c.cost_id','b.cost_price'])
		->from('v_c_surcharge a')
		->join('LEFT JOIN','v_c_surcharge_lib b','a.cost_id=b.id')
		->leftJoin('v_c_surcharge_lib_i18n c','b.id=c.cost_id')
		->where(['c.i18n'=>'en','a.status'=>'1','a.voyage_code'=>$voyage])
		->all();
		
		//获取乘客
		session_start();
		$person = $_SESSION['cabins_noperson_info_data'];
		$person = json_decode($person);
		
		
		
		$person_arr = $this->object_to_array($person[1]->cabins);
		
		//获取船舱
		$data_arr = $_SESSION['cabins_data'];
		$data_arr = json_decode($data_arr);
		
		$type_code = '';
		$cabins_arr = array();
		$cabins_room_num = array();
		foreach ($data_arr as $row){
			$ret = array();
			foreach ($row as $key => $value) {
				if (gettype($value) == "array" || gettype($value) == "object"){
					$ret[$key] =  objarray_to_array($value);
				}else{
					$ret[$key] = $value;
				}
			}
			$cabins_arr[] = $ret;
			$type_code .= "'".$ret['type_code']."',";
			$cabins_room_num[$ret['type_code']] = $ret['room'];
		}
		$type_code = trim($type_code,',');
		
		$sql = "SELECT a.type_code,b.type_name,a.live_number FROM `v_c_cabin_type` a LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code
		WHERE a.type_code in ({$type_code}) order by field(a.type_code,{$type_code})";
		
		$cabins_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$cabins_type_name = array();
		$cabins_type_live_num = array();
		foreach ($cabins_result as $row){
			$cabins_type_name[$row['type_code']] = $row['type_name'];
			$cabins_type_live_num[$row['type_code']] = $row['live_number'];
		}
		
		
		
		return $this->render('additional',['cabins_type_live_num'=>$cabins_type_live_num,'voyage_result'=>$voyage_result,'shore'=>$shore,'surcharge'=>$surcharge,'person_arr'=>$person_arr,'cabins_arr'=>$cabins_arr,'cabins_type_name'=>$cabins_type_name,'cabins_room_num'=>$cabins_room_num]);
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
	
	
	public function actionClearsessioncabins(){
		session_start();
		if(isset($_SESSION['cabins_noperson_info_data'])){
			unset ($_SESSION['cabins_noperson_info_data']);
		}
		if(isset($_SESSION['additional_data'])){
			unset ($_SESSION['additional_data']);
		}
		
	}
	
	
	
	public function actionFillinfo(){
		
		$voyage = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		
		//该航线信息
		$query  = new Query();
		$voyage_result = $query->select(['a.id','a.voyage_code','b.voyage_name'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en','a.voyage_code'=>$voyage])
		->one();
		
		session_start();
		if(!isset($_SESSION['cabins_data'])){
			return $this->redirect(Url::toRoute(['/route/index']));
		}
		$data_arr = $_SESSION['cabins_data'];
		$data_arr = json_decode($data_arr);
		
		
		$cabins_person_info = '';
		$cabins_person_info_basic = '';
		if(isset($_SESSION['cabins_noperson_info_data'])){
			$cabins_person_info = $_SESSION['cabins_noperson_info_data'];
			$cabins_person_info = json_decode($cabins_person_info);
			$cabins_person_info_basic = $this->object_to_array($cabins_person_info[0]->contact);
			$cabins_person_info = $this->object_to_array($cabins_person_info[1]->cabins);
		}
		
		
		$type_code = '';
		$cabins_arr = array();
		foreach ($data_arr as $row){
			$ret = array();  
		    foreach ($row as $key => $value) {  
			    if (gettype($value) == "array" || gettype($value) == "object"){  
			            $ret[$key] =  objarray_to_array($value);  
			    }else{  
			        $ret[$key] = $value;  
			    } 
		    }
		    $cabins_arr[] = $ret;
		    $type_code .= "'".$ret['type_code']."',";

		}
		$type_code = trim($type_code,',');
		
		$sql = "SELECT a.type_code,b.type_name FROM `v_c_cabin_type` a LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code
				WHERE a.type_code in ({$type_code}) order by field(a.type_code,{$type_code})";
		
		$cabins_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$cabins_type_name = array();
		foreach ($cabins_result as $row){
			$cabins_type_name[$row['type_code']] = $row['type_name'];
		}
		
		return $this->render('fillinfo',['session_cabins_person_info'=>$cabins_person_info,'session_cabins_person_info_basic'=>$cabins_person_info_basic,'voyage_result'=>$voyage_result,'cabins_arr'=>$cabins_arr,'cabins_type_name'=>$cabins_type_name]);
	}
	
	
	public function actionSavesessioncabins(){
		$data_arr = isset($_POST['data_arr'])?$_POST['data_arr']:'';
		
		session_start();
		$_SESSION['cabins_data']=$data_arr;
		
	}
	
	//未登陆预订保存session
	public function actionSavesessioncabinsnopersoninfo(){
		
		$data_arr = isset($_POST['data_arr'])?$_POST['data_arr']:'';
		
		session_start();
		$_SESSION['cabins_noperson_info_data']=$data_arr;
	}
	
	
	public function actionRegister(){
		
		return $this->render('register');
	}
	
	public function actionCheckphone(){
		$phone = isset($_POST['phone'])?$_POST['phone']:"";
		$sql = "SELECT count(*) count FROM `booking_user` WHERE phone ='{$phone}'";
		$count = Yii::$app->db->createCommand($sql)->queryOne();
		
		echo $count['count'];
	}
	public function actionCheckemail(){
		$email = isset($_POST['email'])?$_POST['email']:"";
		$sql = "SELECT count(*) count FROM `booking_user` WHERE email ='{$email}'";
		$count = Yii::$app->db->createCommand($sql)->queryOne();
	
		echo $count['count'];
	}
	
	public function actionSaveregister(){
		$phone = isset($_POST['phone'])?trim($_POST['phone']):'';
		$email = isset($_POST['email'])?trim($_POST['email']):'';
		$password = isset($_POST['password'])?trim($_POST['password']):'';
		if($password != '888888'){
			$password = md5($password);
		}
		$time = date('Y-m-d H:i:s',time());
		$sql = "INSERT INTO `booking_user` (phone,email,password,regtime) VALUES ('{$phone}','{$email}','{$password}','{$time}')";
		$count = Yii::$app->db->createCommand($sql)->execute();
		if($count){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function actionSendmail(){
		
		$mail = Yii::$app->mailer->compose();
        $mail->setTo('204612491@qq.com');
        $mail->setSubject("test test");
        $mail->setHtmlBody("liangwenzhen，");
        
		$success = $mail->send();
		var_dump($success);
        if($success){
            echo "true";
        }else {
            echo "false";
        }
	
	}
	
	public function actionPay(){
		$db = Yii::$app->db;
		$order_number = isset($_GET['order_number'])?$_GET['order_number']:'';
		$voyage_code = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		
		$query  = new Query();
		$voyage_result = $query->select(['a.id','a.voyage_code','b.voyage_name','a.start_time','a.ticket_taxes','a.harbour_taxes'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en','a.voyage_code'=>$voyage_code])
		->one();
		
		//舱房信息
		$sql = "SELECT a.cabin_type_code,a.check_in_number,d.type_name,c.check_num,c.bed_price,c.last_bed_price,c.2_empty_bed_preferential,c.3_4_empty_bed_preferential,a.cabin_name,a.passport_number_one,a.passport_number_two,a.passport_number_three,a.passport_number_four,a.cabin_price FROM `v_voyage_order_detail` a 
			   LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_code=b.type_code
			   LEFT JOIN `v_c_cabin_type_i18n` d ON b.type_code=d.type_code AND d.i18n = 'en'
			   LEFT JOIN `v_c_cabin_pricing` c ON b.id = c.cabin_type_id AND c.voyage_code='{$voyage_code}'
			   WHERE order_serial_number='{$order_number}'";
		$cabins_result = $db->createCommand($sql)->queryAll();
		
		$room_arry = ['one','two','three','four'];
		$cabins_big_class = array();
		foreach ($cabins_result  as $k=>$row){
			$adult = 0;
			$children = 0;
			$room = 0;
			$price = 0;
 			$preferential = 0;
			
			if(isset($cabins_big_class[$row['cabin_type_code']])){
				$adult = $cabins_big_class[$row['cabin_type_code']]['adult'];
				$children = $cabins_big_class[$row['cabin_type_code']]['children'];
				$room = $cabins_big_class[$row['cabin_type_code']]['room'];
				$price = $cabins_big_class[$row['cabin_type_code']]['price'];
				$preferential = $cabins_big_class[$row['cabin_type_code']]['preferential'];	//房间净费用，z(不包括优惠)
			}else{
				$cabins_big_class[$row['cabin_type_code']]['adult'] = 0;
				$cabins_big_class[$row['cabin_type_code']]['children'] = 0;
				$cabins_big_class[$row['cabin_type_code']]['room'] = 0;
				$cabins_big_class[$row['cabin_type_code']]['price'] = 0;
				$cabins_big_class[$row['cabin_type_code']]['preferential'] = 0;
			}
			$child_num = 0;
			for($i=0;$i<(int)$row['check_in_number'];$i++){
				$passport = 'passport_number_'.$room_arry[$i];
				if($row[$passport] != null){
					$sql = "SELECT full_name FROM `v_membership` WHERE passport_number='{$row[$passport]}'";
					$passport_name = $db->createCommand($sql)->queryOne();
					$cabins_result[$k][$passport] = $passport_name['full_name'];
				}
			}
			
			$bed_num = $row['check_num'];
			$room_price_all = 0;
			if((int)$bed_num>2){
				//判断乘客数
				if((int)$row['check_in_number']>2){
					$first_tep_bed = 2*(float)$row['bed_price'];
					$last_tep_bed = ((int)$row['check_in_number']-2)*(float)$row['last_bed_price'];
					$first_bed  = (float)$first_tep_bed + (float)$last_tep_bed;
					$last_bed = ((int)$bed_num-(int)$row['check_in_number'])*(float)$row['last_bed_price']*(float)((float)$row['3_4_empty_bed_preferential']/100);
				}else{
					$first_bed = (int)$row['check_in_number']*(float)$row['bed_price'];
					$tep_first_bed = (2-(int)$row['check_in_number'])*(float)$row['bed_price']*(float)((float)$row['2_empty_bed_preferential']/100);;
					$tep_last_tep = ((int)$bed_num-2)*(float)$row['last_bed_price']*(float)((float)$row['3_4_empty_bed_preferential']/100);
					$last_bed = (float)$tep_first_bed + (float)$tep_last_tep;
				}
				
			}else{
				//只有一二号床位
				$first_bed = (int)$row['check_in_number']*(float)$row['bed_price'];
				$last_bed = ((int)$bed_num-(int)$row['check_in_number'])*(float)$row['bed_price']*((float)$row['2_empty_bed_preferential']/100);
			}
			
			
			$children = (int)$children +  (int)$child_num;
			$adult = (int)$adult + ((int)$row['check_in_number'] - (int)$child_num);
			$room =  (int)$room + 1;
			$price = (float)$price + (float)$row['cabin_price'];
			$preferential = (float)$first_bed + (float)$last_bed;
			
			$cabins_big_class[$row['cabin_type_code']]['adult'] = $adult;
			$cabins_big_class[$row['cabin_type_code']]['children'] = $children;
			$cabins_big_class[$row['cabin_type_code']]['room'] = $room;
			$cabins_big_class[$row['cabin_type_code']]['price'] = $price;
			$cabins_big_class[$row['cabin_type_code']]['preferential'] = $preferential;
			
			
		}
		
		//订单信息
		$sql = "SELECT preferential_price,total_pay_price,total_tax_pric,total_port_expenses FROM `v_voyage_order` WHERE order_serial_number='{$order_number}'";
		$order_result = $db->createCommand($sql)->queryOne();
		
	
		//观光路线
		$sql = "SELECT d.se_name,a.additional_price,count(a.additional_price_id) count FROM `v_voyage_order_additional_price` a 
		LEFT JOIN `v_c_shore_excursion` b ON a.additional_price_id=b.id
		LEFT JOIN `v_c_shore_excursion_lib` c ON b.sh_id=c.id
		LEFT JOIN `v_c_shore_excursion_lib_i18n` d ON c.se_code=d.se_code
		WHERE d.i18n='en' AND b.status='1' AND b.voyage_code='{$voyage_code}' 
		AND a.price_type='3' AND a.order_serial_number='{$order_number}'
		GROUP BY a.additional_price_id";
		$shore = $db->createCommand($sql)->queryAll();
		
		//附加产品
		$sql = "SELECT c.cost_name,d.additional_price,count(d.additional_price_id) count FROM `v_voyage_order_additional_price` d 
		LEFT JOIN `v_c_surcharge` a ON d.additional_price_id=a.id
		LEFT JOIN `v_c_surcharge_lib` b ON a.cost_id=b.id
		LEFT JOIN `v_c_surcharge_lib_i18n` c ON b.id=c.cost_id
		WHERE d.price_type='2' AND d.order_serial_number='{$order_number}' 
		AND c.i18n='en' AND a.status='1' AND a.voyage_code='{$voyage_code}'
		GROUP BY d.additional_price_id";
		$surcharge = $db->createCommand($sql)->queryAll();
		
		
		return $this->render('pay',['shore'=>$shore,'cabins_big_class'=>$cabins_big_class,'voyage_result'=>$voyage_result,'surcharge'=>$surcharge,'cabins_result'=>$cabins_result,'order_result'=>$order_result]);
	
	}
	
	
	public function actionComplete(){
	
		$voyage = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
	
		//该航线信息
		$query  = new Query();
		$voyage_result = $query->select(['a.id','a.voyage_code','b.voyage_name'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en','a.voyage_code'=>$voyage])
		->one();
		return $this->render('complete',['voyage_result'=>$voyage_result]);
	
	}
	
	
	
	//订单保存
	public function actionSaveorder(){
		$db = Yii::$app->db;
		$voyage = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		$order_number = Helper::createOrderno();			//订单号
		//该航线信息
		$query  = new Query();
		$voyage_result = $query->select(['a.id','a.cruise_code','a.voyage_code','b.voyage_name','a.start_time','a.ticket_taxes','a.harbour_taxes'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en','a.voyage_code'=>$voyage])
		->one();
		
// 		$cruise_code = Yii::$app->params['cruise_code'];	//邮轮获取
		
		
		/***************session获取开始******************/
		
		session_start();
		//获取附加产品，包含产品，房间分配session
		$addition = $_SESSION['additional_data'];
		$addition = json_decode($addition);
		$addition = $this->object_to_array($addition);
		
		//包含产品
		$contains_product = $addition[0]['additional']['contains_product'];
		//附加产品
		$additional_product = $addition[0]['additional']['additional_product'];
		//船舱
		$cabins_distribution = $addition[0]['additional']['cabins_distribution'];
		
		
		//乘客信息
		$cabins_person_info = $_SESSION['cabins_noperson_info_data'];
		$cabins_person_info = json_decode($cabins_person_info);
		$cabins_person_info = $this->object_to_array($cabins_person_info);
		
		//船房信息
		$cabins_data = $_SESSION['cabins_data'];
		$cabins_data = json_decode($cabins_data);
		$cabins_data = $this->object_to_array($cabins_data);
		
		/******************session获取结束**********************/
				
		//封装乘客护照号键值对数组
		$key_passport_array = array();
		foreach ($cabins_person_info[1]['cabins'] as $row_type){
			foreach ($row_type  as $val ){
				$key_passport_array[$val['key']] = $val['paper_num'];
			}
		}
		
		$connecton = Yii::$app->db;
		$transaction = $connecton->beginTransaction();
		try{
		
			//计算费用，按每间船房算 (需判断，1：开航日期是否是生日:2：儿童是否符合儿童年龄优惠，3：成人是否符合老年优惠,4：是否提前订票优惠)
			$cabins_price_pre = $this->Cabinssingleprice($connecton,$voyage_result,$cabins_distribution,$cabins_person_info);
			
			$cabin_person_preferential =  $cabins_price_pre['cabin_person_preferential'];
			$cabins_single_price = $cabins_price_pre['cabin_type_price'];
			
			
			//录入旅客优惠详情表 `v_voyage_order_preferential_detail`
			$this->Orderpreferentialdetail($connecton,$order_number,$key_passport_array,$cabin_person_preferential);
			
			//录入会员表  `v_membership` `v_m_passport`
			$this->Membershipsave($connecton,$cabins_person_info);
			
			//录入联系表 `v_order_contact_info`
			$this->Ordercontactinfo($connecton,$order_number,$cabins_person_info);
			
			//录入常用联系人表 `v_user_commonly_passenger` (判断乘客是否有勾选保存到常用旅客)
			$this->Usercommonlypassenger($connecton,$cabins_person_info);
			
			
			//录入订单表 `v_voyage_order`
			$this->Voyagaeorder($connecton,$cabins_data,$contains_product,$additional_product,$cabins_single_price,$voyage_result,$order_number);
			
			
			// 录入订单 附加费表 `v_voyage_order_additional_price`
			$this->Orderadditionalprice($connecton,$order_number,$voyage_result,$contains_product,$additional_product,$key_passport_array);
			
			
			//录入订单房间表 `v_voyage_order_detail`
			$this->Voyageorderdetail($connecton,$order_number,$voyage_result,$cabins_distribution,$key_passport_array,$cabins_single_price);
			
			$transaction->commit();
			$success = 1;
		}catch (Exception $e){
			$transaction->rollBack();
			$success = 0;
		}
		if($success == 1){
			//清空session
			unset($_SESSION['additional_data']);
			unset($_SESSION['cabins_noperson_info_data']);
			unset($_SESSION['cabins_data']);
			return $this->redirect(Url::toRoute(['/route/pay','order_number'=>$order_number,'voyage_code'=>$voyage_result['voyage_code']]));
		}else{
			return $this->redirect(Url::toRoute(['/route/addition']));
		}
		
		
	}
	
	
	protected function Cabinssingleprice($connecton,$voyage_result,$cabins_distribution,$cabins_person_info){
		$children_age = Yii::$app->params['children_age'];
		$old_age = Yii::$app->params['old_age'];
		$ADT = Yii::$app->params['ADT'];
		
		/**判断是否是提前购票开始**/
		$curr_time_is_advance = 0;
		$startdate=strtotime(date('Y-m-d',time()));
		$enddate=strtotime(substr($voyage_result['start_time'],0,10));
		$days=round(($enddate-$startdate)/3600/24);
		if((int)$days >= (int)$ADT){
			$curr_time_is_advance = 1;
		}
		/**判断是否是提前购票结束**/
		
		//查询优惠
		$sql = "SELECT p_price,p_where FROM `v_c_preferential_strategy` WHERE voyage_code='{$voyage_result['voyage_code']}' ";
		$preferential_result = $connecton->createCommand($sql)->queryAll();
		//封装优惠数组
		$preferential_array = array();
		$preferential_array['old'] = 0;
		$preferential_array['children'] = 0;
		$preferential_array['birthday'] = 0;
		$preferential_array['adt'] = 0;
		foreach ($preferential_result as $row){
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
		//封装每个乘客优惠详情
		$cabin_person_preferential = array();
		//循环每间房
		foreach ($cabins_distribution as $cabin_key=>$row){
				
			//查询舱房价格
			$sql = "SELECT a.* FROM `v_c_cabin_pricing` a LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_id=b.id  WHERE b.type_code='{$row['cabin_type']}' AND a.voyage_code='{$voyage_result['voyage_code']}'";
			$pricing_result = $connecton->createCommand($sql)->queryOne();
				
			$cabin_info = array();
			$start_ship = substr($voyage_result['start_time'],5,5); 	//开航日期 03-31
			foreach ($cabins_person_info[1]['cabins'][$row['cabin_type']] as $cabin){
				if(in_array($cabin['key'], $row['person_key'])){
					$person = (int)$cabin['person'];
					$birth = Helper::GetCreateTime($cabin['birth']);	//2016-03-31
					$age = Helper::Getage($birth);
					//区分成人or儿童
					if($person == 1){
						//成人
						$cabin_info[$cabin['key']]['per'] = '1';
						//判断年龄优惠
						if((int)$age >= (int)$old_age){
							$cabin_info[$cabin['key']]['age'] = '1';
						}else{
							$cabin_info[$cabin['key']]['age'] = '0';
						}
							
					}else if($person == 2){
						//儿童
						if((int)$age <= (int)$children_age){
							$cabin_info[$cabin['key']]['per'] = '2';
							//判断年龄优惠
							$cabin_info[$cabin['key']]['age'] = '1';
						}else{
							$cabin_info[$cabin['key']]['per'] = '1';
							//判断年龄优惠
							if((int)$age >= (int)$old_age){
								$cabin_info[$cabin['key']]['age'] = '1';
							}else{
								$cabin_info[$cabin['key']]['age'] = '0';
							}
						}
							
					}
					//判断是否是生日
					if($start_ship == substr($birth,5,5)){
						$cabin_info[$cabin['key']]['birthday'] = '1';
					}else{
						$cabin_info[$cabin['key']]['birthday'] = '0';
					}
					//判断预订优惠
					if((int)$curr_time_is_advance == 1){
						$cabin_info[$cabin['key']]['adt'] = '1';
					}else{
						$cabin_info[$cabin['key']]['adt'] = '0';
					}
				}
				
				
			}
				
			//var_dump($cabin_info);exit;
			$bed_num = $pricing_result['check_num'];
			$th_1_price = $pricing_result['bed_price'];
			$th_3_price = $pricing_result['last_bed_price'];
			$th_1_empty = (float)$pricing_result['2_empty_bed_preferential']/100;
			$th_3_empty = (float)$pricing_result['3_4_empty_bed_preferential']/100;
			
			//先判断是否有提前预订(若有提前预订则全部成员按一二床位算)
			$price_sum = 0;		//房间总价
			$other_price_num = 0;	//其他优惠价
			$person_sum = count($cabin_info);			//房间总入住人数
			$no_person_bed = (int)$bed_num - (int)$person_sum;	//空床数
			if($curr_time_is_advance == 1){
				foreach ($cabin_info as $c_k=>$c_val){
					$price_sum_only = (float)$th_1_price;
					//年龄优惠
					if((int)$c_val['per']==1){
						if((int)$c_val['age']==1){
							$price_sum_only = (float)$price_sum_only*(float)$preferential_array['old'];
						}
					}else if((int)$c_val['per']==2){
						if((int)$c_val['age']==1){
							$price_sum_only = (float)$price_sum_only*(float)$preferential_array['children'];
						}
					}
					
					//生日优惠
					if((int)$c_val['birthday']==1){
						$price_sum_only = (float)$price_sum_only*(float)$preferential_array['birthday'];
					}
						
					//预订提前优惠
					if((int)$c_val['adt']==1){
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
				foreach ($cabin_info as $c_k=>$c_val){
					if((int)$c_val['per']==1){
						$adult += 1;
					}else if((int)$c_val['per']==2){
						$child += 1;
					}
				}
		
				foreach ($cabin_info as $c_k=>$c_val){
					$curr_price = 0;
					$price_sum_only = 0;
					if(((int)$c_val['per']==1) && ((int)$c_val['birthday']==0) && ((int)$c_val['age']==0) && ((int)$c_val['adt']==0) ){
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
						if((int)$c_val['per']==1){
							$price_sum_only += (float)$th_1_price;
							$curr_price = (float)$th_1_price;
								
							if((int)$c_val['age']==1){
								$price_sum_only = (float)$price_sum_only * (float)$preferential_array['old'];
							}
								
						}else if((int)$c_val['per']==2){
							if((int)$c_val['birthday']==1){
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
								
							if((int)$c_val['age']==1){
								$price_sum_only = (float)$price_sum_only * (float)$preferential_array['children'];
							}
						}
		
						//生日优惠
						if((int)$c_val['birthday']==1){
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
			
			$cabin_type_price[$cabin_key]['cabin_type'] = $row['cabin_type'];
			$cabin_type_price[$cabin_key]['price'] = $price_sum;
			$cabin_type_price[$cabin_key]['other'] = $other_price_num;
			
			$cabin_person_preferential[] = $cabin_info;
		}
		
		$cabins_price_pre = array();
		$cabins_price_pre['cabin_person_preferential'] = $cabin_person_preferential;
		$cabins_price_pre['cabin_type_price'] = $cabin_type_price;
		
		return $cabins_price_pre;
	}
	
	
	//录入订单优惠详情表 `v_voyage_order_preferential_detail`
	protected function Orderpreferentialdetail($connecton,$order_number,$key_passport_array,$cabin_person_preferential){
		
		$sql = "INSERT INTO `v_voyage_order_preferential_detail` (order_serial_number,passport,preferential_type) VALUES ";
		$sql_val = '';
		foreach ($cabin_person_preferential as $row){
			foreach ($row as $key=>$val){
				//老年优惠
				if(((int)$val['age'] == 1) && ((int)$val['per'] == 1)){
					$sql_val .= "('{$order_number}','{$key_passport_array[$key]}','2'),";
				}
				//儿童优惠
				if(((int)$val['age'] == 1) && ((int)$val['per'] == 2)){
					$sql_val .= "('{$order_number}','{$key_passport_array[$key]}','1'),";
				}
				//生日优惠
				if((int)$val['birthday'] == 1){
					$sql_val .= "('{$order_number}','{$key_passport_array[$key]}','4'),";
				}
				//提前订票优惠
				if((int)$val['adt'] == 1){
					$sql_val .= "('{$order_number}','{$key_passport_array[$key]}','3'),";
				}
			}
		}
		$sql  = $sql.trim($sql_val,',');
		if($sql_val!=''){$connecton->createCommand($sql)->execute();}
		
	}
	
	//录入订单表 `v_voyage_order`
	protected function Voyagaeorder($connecton,$cabins_data,$contains_product,$additional_product,$cabins_single_price,$voyage_result,$order_number){
		$time = date('Y-m-d H:i:s',time());
		$room_price_sum = 0;		//房间总价
		$preferential_price_sum = 0;		//优惠总价
		$person_sum = 0;			//总人数
		foreach ($cabins_data as $row){
			$person_sum += ((int)$row['adult']+(int)$row['children']);
		}
		foreach ($cabins_single_price as $row){
			$room_price_sum += (float)$row['price'];
			$preferential_price_sum += (float)$row['other'];
		}
		
		$total_tax_pric_sum = (float)$room_price_sum * ($voyage_result['ticket_taxes']/100);	//税价
		
		$harbour_taxes_price_sum = $voyage_result['harbour_taxes'] * (int)$person_sum;       //港口费
		
		$contains_price_sum = 0;    //包含产品总价
		foreach ($contains_product as $row){
			$contains_price_sum += (float)$row['shore_price']*((int)count($row['person_key']));
		}
		
		$additional_price_sum = 0;	//保险（附加费）
		foreach ($additional_product as $row){
			$additional_price_sum += (float)$row['surcharge_price']*((int)count($row['person_key']));
		}
		$addition_sum = (float)$contains_price_sum + (float)$additional_price_sum;
		$order_price_sum = (float)$room_price_sum + (float)$total_tax_pric_sum + (float)$harbour_taxes_price_sum + (float)$addition_sum;
		
		
		if(isset(Yii::$app->user->id)){
			$user_id = Yii::$app->user->id;
			$sql = "INSERT INTO `v_voyage_order` (cruise_code,voyage_code,order_serial_number,order_type,create_order_time,total_pay_price,preferential_price,total_ticket_price,total_tax_pric,total_port_expenses,total_additional_price,pay_status,order_status,source_code,source_type) VALUES ";
			$sql .= "('{$voyage_result['cruise_code']}','{$voyage_result['voyage_code']}','{$order_number}','1','{$time}','{$order_price_sum}','{$preferential_price_sum}','{$room_price_sum}','{$total_tax_pric_sum}','{$harbour_taxes_price_sum}','{$addition_sum}','0','0','{$user_id}','0')";
		}else{
			$sql = "INSERT INTO `v_voyage_order` (cruise_code,voyage_code,order_serial_number,order_type,create_order_time,total_pay_price,preferential_price,total_ticket_price,total_tax_pric,total_port_expenses,total_additional_price,pay_status,order_status,source_type) VALUES ";
			$sql .= "('{$voyage_result['cruise_code']}','{$voyage_result['voyage_code']}','{$order_number}','1','{$time}','{$order_price_sum}','{$preferential_price_sum}','{$room_price_sum}','{$total_tax_pric_sum}','{$harbour_taxes_price_sum}','{$addition_sum}','0','0','0')";
		}
		
		$connecton->createCommand($sql)->execute();
		
	}
	
	//会员表 `v_membership` `v_m_passport`
	protected function Membershipsave($connecton,$cabins_person_info){
		$time = date('Y-m-d H:i:s',time());
		$sql_data = 'INSERT INTO `v_membership` (m_code,last_name,first_name,full_name,passport_number,gender,mobile_number,birthday,birth_place,create_by,create_time) VALUES ';
		$date_data = 'INSERT INTO `v_m_passport` (passport_number,date_expire,full_name,last_name,first_name,gender,birthday,birth_place) VALUES ';
		$sql_data_where = '';
		$date_data_where = '';
		$time = date('Y-m-d H:i:s',time());
		foreach ($cabins_person_info[1]['cabins'] as $row){
			foreach ($row as $val){
				//查询是否存在该护照号
				$sql = "SELECT count(*) count FROM `v_membership` WHERE passport_number='".$val['paper_num']."'";
				$count = $connecton->createCommand($sql)->queryOne();
				if($count['count']==0){
					$m_code = CreateMember::createMemberNumber();
					$sex = ($val['sex']==2)?"F":"M";
					$birth = Helper::GetCreateTime($val['birth']);
					$sql_data_where .= "('{$m_code}','{$val['last_name']}','{$val['first_name']}','{$val['full_name']}','{$val['paper_num']}','{$sex}','{$val['phone']}','{$birth}','{$val['birth_place']}',null,'{$time}'),";
					
					$date_expire = Helper::GetCreateTime($val['paper_date']);
					$date_data_where .= "('{$val['paper_num']}','{$date_expire}','{$val['full_name']}','{$val['last_name']}','{$val['first_name']}','{$sex}','{$birth}','{$val['birth_place']}'),";
				}
			}
		}
		$sql_data_sql = $sql_data.trim($sql_data_where,',');
		$date_data_sql = $date_data.trim($date_data_where,',');
		if($sql_data_where!=''){ $connecton->createCommand($sql_data_sql)->execute();}
		if($date_data_where != '') {$connecton->createCommand($date_data_sql)->execute();}
		
	}
	
	//录入联系表 `v_order_contact_info`
	protected function Ordercontactinfo($connecton,$order_number,$cabins_person_info){
		$contact = $cabins_person_info[0]['contact'];
		$sql = "INSERT INTO `v_order_contact_info` (order_serial_number,contact_name,contact_email,contact_phone) VALUES ";
		$sql .= "('{$order_number}','{$contact['name']}','{$contact['email']}','{$contact['phone']}')";
		$connecton->createCommand($sql)->execute();
	}
	
	//录入常用联系人表 `v_user_commonly_passenger`
	protected function Usercommonlypassenger($connecton,$cabins_person_info){
		$user_id = isset(Yii::$app->user->id)?Yii::$app->user->id:'';
		$sql = "INSERT INTO `v_user_commonly_passenger` (user_id,membership_id) VALUES ";
		$membership_sql = '';
		foreach ($cabins_person_info[1]['cabins'] as $key=>$row){
			foreach ($row as $val){
				$m_sql = "SELECT m_id FROM `v_membership` WHERE passport_number='{$val['paper_num']}'";
				$membership = $connecton->createCommand($m_sql)->queryOne();
				
				if(isset($membership['m_id']) && $user_id!=''){
					//判断该登录者是否存在该常用旅客
					$sql_user = "SELECT count(*) count FROM `v_user_commonly_passenger` WHERE user_id='{$user_id}' AND membership_id='{$membership['m_id']}'";
					$count = $connecton->createCommand($sql_user)->queryOne();
					if($count['count']==0){
						$membership_sql .= "('{$user_id}','{$membership['m_id']}'),";
					}
				}
			}
		}
		$sql = $sql.trim($membership_sql,',');
		if($membership_sql!=''){$connecton->createCommand($sql)->execute();}
		
	}
	
	//订单附加费表  `v_voyage_order_additional_price`
	protected function Orderadditionalprice($connecton,$order_number,$voyage_result,$contains_product,$additional_product,$key_passport_array){
		//循环乘客录入码头税
		$sql = "INSERT INTO `v_voyage_order_additional_price` (voyage_code,order_serial_number,passport_number,price_type,additional_price) VALUES ";
		foreach ($key_passport_array as $key=>$row){
			$sql .= "('{$voyage_result['voyage_code']}','{$order_number}','{$row}','1','{$voyage_result['harbour_taxes']}'),";
		}
		$sql = trim($sql,',');
	    $connecton->createCommand($sql)->execute();
		
		$sql = "INSERT INTO `v_voyage_order_additional_price` (voyage_code,order_serial_number,passport_number,price_type,additional_price_id,additional_price) VALUES ";
		//循环包含产品录入观光路线
		$contains_sql = '';
		foreach ($contains_product as $row){
			foreach ($row['person_key'] as $val){
				$contains_sql .= "('{$voyage_result['voyage_code']}','{$order_number}','{$key_passport_array[$val]}','3','{$row['shore_code']}','{$row['shore_price']}'),";
		
			}
		}
		$contains_sql = trim($contains_sql,',');
	   
		//循环附加产品录入附加费
		$addition_sql = '';
		foreach ($additional_product as $row){
			foreach ($row['person_key'] as $val){
				$addition_sql .= "('{$voyage_result['voyage_code']}','{$order_number}','{$key_passport_array[$val]}','2','{$row['surcharge_code']}','{$row['surcharge_price']}'),";
			}
		}
		$addition_sql = trim($addition_sql,',');
		
	
		$sql .= $contains_sql.','.$addition_sql;
		$sql = trim($sql,',');
		$connecton->createCommand($sql)->execute();
	}
	
	//录入订单房间表 `v_voyage_order_detail`
	protected function Voyageorderdetail($connecton,$order_number,$voyage_result,$cabins_distribution,$key_passport_array,$cabins_single_price){
		$user_name_arr = ['one','two','three','four'];
		$time = date('Y-m-d H:i:s',time());
		$sql_data = '';
		foreach ($cabins_distribution as $k=>$row){
			$set_str = '';
			$val_str = '';
			$live_num = 0;
			for($i=0;$i<count($row['person_key']);$i++){
				if(!empty($row['person_key'][$i])){
					$set_str .= "passport_number_".$user_name_arr[$i].',';
					$val_str .= "'".$key_passport_array[$row['person_key'][$i]]."',";
					++$live_num;
				}
			}
		
			//根据cabin_type_code获取随机房间号
			$sql = "select cabin_name from v_voyage_order_detail where voyage_code='{$voyage_result['voyage_code']}' AND cabin_type_code='{$row['cabin_type']}'";
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
			WHERE a.voyage_id='{$voyage_result['id']}' AND b.type_code='{$row['cabin_type']}' AND a.cabin_status='1'
			".$room_name_in_where." limit 1";
			$room_name = $connecton->createCommand($sql)->queryOne();
		
		
// 			$live_num = count($row['person_key']);
			$cabin_price = $cabins_single_price[$k]['price'];
			$tax_price = (float)$cabin_price * ((float)$voyage_result['ticket_taxes']/100);
			$sql = "INSERT INTO `v_voyage_order_detail` (order_serial_number,voyage_code,cabin_type_code,cabin_name,check_in_number,cabin_price,tax_price,".$set_str."assign_cabin_status,status,create_time) VALUES ";
			$sql .= "('{$order_number}','{$voyage_result['voyage_code']}','{$row['cabin_type']}','{$room_name['cabin_name']}','{$live_num}','{$cabin_price}','{$tax_price}',".$val_str."'1','0','{$time}')";
			$connecton->createCommand($sql)->execute();
		}
		
		
	}
	
	
	
	
	public function actionSavesessionadditional(){
		$data_arr = isset($_POST['data_arr'])?$_POST['data_arr']:'';
		
		session_start();
		$_SESSION['additional_data']=$data_arr;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}