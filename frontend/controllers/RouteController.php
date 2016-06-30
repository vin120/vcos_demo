<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use frontend\components\Helper;
use frontend\models\LoginForm;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
//use app\extensions\smtp;



class RouteController extends Controller
{
	public $enableCsrfValidation = false;
	
	
	public function actionIndex(){
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
		
		return $this->render('selectroom',['voyage_result'=>$voyage_result,'bigcabin_result'=>$bigcabin_result,'cabin_result'=>$cabin_all_arr,'children_pre'=>$children_pre]);
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
		
		return $this->render('fillinfo',['voyage_result'=>$voyage_result]);
		
		
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
		$shore = $query->select(['c.se_name','c.se_info','c.se_code'])
		->from('v_c_shore_excursion a')
		->join('LEFT JOIN','v_c_shore_excursion_lib b','a.sh_id=b.id')
		->leftJoin('v_c_shore_excursion_lib_i18n c','b.se_code=c.se_code ')
		->where(['c.i18n'=>'en','a.status'=>'1','a.voyage_code'=>$voyage])
		->all();
		
		$query  = new Query();
		$surcharge = $query->select(['c.cost_name','c.cost_desc','c.cost_id','b.cost_price'])
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
		
		//var_dump($cabins_room);exit;
		
		$sql = "SELECT a.type_code,b.type_name FROM `v_c_cabin_type` a LEFT JOIN `v_c_cabin_type_i18n` b ON a.type_code=b.type_code
		WHERE a.type_code in ({$type_code}) order by field(a.type_code,{$type_code})";
		
		$cabins_result = Yii::$app->db->createCommand($sql)->queryAll();
		
		$cabins_type_name = array();
		foreach ($cabins_result as $row){
			$cabins_type_name[$row['type_code']] = $row['type_name'];
		}
		
		
		//
	
		//var_dump($person_arr);
		
		//exit;
		
		
		return $this->render('additional',['voyage_result'=>$voyage_result,'shore'=>$shore,'surcharge'=>$surcharge,'person_arr'=>$person_arr,'cabins_arr'=>$cabins_arr,'cabins_type_name'=>$cabins_type_name,'cabins_room_num'=>$cabins_room_num]);
	}
	
	
	//数组对象转数组（支持多维）
	public function object_to_array($obj){
		$_arr = is_object($obj) ? get_object_vars($obj) :$obj;
		foreach ($_arr as $key=>$val){
			$val = (is_array($val) || is_object($val)) ? $this->object_to_array($val):$val;
			$arr[$key] = $val;
		}
		return $arr;
	}
	
	
	
	public function actionPay(){
	
		$voyage = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
	
		//该航线信息
		$query  = new Query();
		$voyage_result = $query->select(['a.id','a.voyage_code','b.voyage_name'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en','a.voyage_code'=>$voyage])
		->one();
		return $this->render('pay',['voyage_result'=>$voyage_result]);
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
	
	
	public function actionFillinfonologin(){
		
		$voyage = isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
		
		//该航线信息
		$query  = new Query();
		$voyage_result = $query->select(['a.id','a.voyage_code','b.voyage_name'])
		->from('v_c_voyage a')
		->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
		->where(['b.i18n'=>'en','a.voyage_code'=>$voyage])
		->one();
		
		session_start();
		$data_arr = $_SESSION['cabins_data'];
		$data_arr = json_decode($data_arr);
		
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
		
		return $this->render('fillinfo_nologin',['voyage_result'=>$voyage_result,'cabins_arr'=>$cabins_arr,'cabins_type_name'=>$cabins_type_name]);
	}
	
	
	public function actionSavesessioncabins(){
		$data_arr = isset($_POST['data_arr'])?$_POST['data_arr']:'';
		
		session_start();
		$_SESSION['cabins_data']=$data_arr;
		
		//$data_arr = json_decode($data_arr);
		//var_dump($_SESSION['cabins_data']);exit;
		
		
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
	
	public function actionSendmail(){
		
		$mail = Yii::$app->mailer->compose();
        $mail->setTo('384097528@qq.com');
        $mail->setSubject("test test");
        $mail->setHtmlBody("liangwenzhen，，，iang苛百異要");
        if($mail->send()){
            echo "success";
        }else {
            echo "false";
        }
	
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}