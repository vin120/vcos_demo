<?php

namespace app\modules\travelagentmanagement\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
//use app\modules\travelagentmanagement\components\Helper;
use app\modules\travelagentmanagement\models\VTravelAgent;
use app\modules\travelagentmanagement\models\VTravelAgentType;
use app\modules\travelagentmanagement\models\seletedata;
use app\modules\travelagentmanagement\components\Helper;
use app\modules\travelagentmanagement\components\CreateMember;

class AgentController extends Controller
{
	public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }
    //Travel Agent
    public function actionTravel_agent(){
  
    	/* 批量删除 */
    	if ($_POST){
    		$ids=isset($_POST['ids'])?$_POST['ids']:'';
    		$seleteselect=isset($_POST['seleteselect'])?$_POST['seleteselect']:'';
    		if (!empty($ids)&&$seleteselect!=''){
    			$ids=implode('\',\'',$ids);
    			$sqldeleteall="delete from v_travel_agent where travel_agent_id in('$ids')";
    			$transaction =\Yii::$app->db->beginTransaction();
    			try {
    				$command2= \Yii::$app->db->createCommand($sqldeleteall)->execute();
    				$transaction->commit();
    				Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["travel_agent"]));
    				//return $this->redirect("travel_agent?massage=success");
    			} catch(Exception $e) {
    				$transaction->rollBack();
    				Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["travel_agent"]));
    				//return $this->redirect("travel_agent?massage=fail");
    			}
    		}
    	}
    	/* 删除 */
    	$code=isset($_GET['code'])?$_GET['code']:'';
    	if ($code!=''){
    		$transaction =\Yii::$app->db->beginTransaction();
    		try {
    			$command = \Yii::$app->db->createCommand("delete from v_travel_agent where travel_agent_id=$code")->execute();
    			$transaction->commit();
    			Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["travel_agent"]));
    			//return $this->redirect("travel_agent?massage=success");
    		} catch(Exception $e) {
    			$transaction->rollBack();
    			Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["travel_agent"]));
    			//return $this->redirect("travel_agent?massage=fail");
    			exit;
    		}
    	}
    	
    	$count = VTravelAgent::find()->count();
    	$sql = "SELECT a.*,b.travel_agent_level FROM `v_travel_agent` a LEFT JOIN `v_travel_agent_type` b ON a.travel_agent_level=b.id  where a.travel_agent_id>0";
    	//$result = Yii::$app->db->createCommand($sql)->queryAll();
    	$travel_agent_code=isset($_POST['travel_agent_code'])?$_POST['travel_agent_code']:'';
    	$travel_agent_name=isset($_POST['travel_agent_name'])?$_POST['travel_agent_name']:'';
    	$travel_agent_status=isset($_POST['travel_agent_status'])?$_POST['travel_agent_status']:'2';
    	if($_POST){
    	    if ($travel_agent_code!==''){
    	    	$sql .= " AND (a.travel_agent_code LIKE '%{$travel_agent_code}%')";
    	    }
    	    if ($travel_agent_name!=''){
    	    	$sql .= " AND (a.travel_agent_name LIKE '%{$travel_agent_name}%')";
    	    }
    	    if ($travel_agent_status!='2'){
    	    	$sql .= " AND (a.travel_agent_status=$travel_agent_status)";
    	    }
    	}
    	$sql.=" order by a.travel_agent_id ";
    	$selectdata=new seletedata();
    	$data=$selectdata->paging($sql, $sql);
    	$data['travel_agent_code']=$travel_agent_code;
    	$data['travel_agent_name']=$travel_agent_name;
    	$data['travel_agent_status']=$travel_agent_status;
    	return $this->render("travel_agent",$data);
    }
    //Travel Agent page
    public function actionGet_travel_agent_page(){
    	$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
    	$sql = "SELECT a.*,b.travel_agent_level FROM `v_travel_agent` a LEFT JOIN `v_travel_agent_type` b ON a.travel_agent_level=b.id  WHERE a.travel_agent_status=1 limit $pag,2";
    	$result = Yii::$app->db->createCommand($sql)->queryAll();
    	if($result){
    		echo json_encode($result);
    	}  else {
    		echo 0;
    	}
    }
    
    
    //type_config
    public function actionType_config(){
    	/* 批量删除 */
    	if ($_POST){
    		$ids=isset($_POST['ids'])?$_POST['ids']:'';
    		$seleteselect=isset($_POST['seleteselect'])?$_POST['seleteselect']:'';
    		if (!empty($ids)&&$seleteselect!=''){
    			$ids=implode('\',\'',$ids);
    			$sqldeleteall="delete from v_travel_agent_type where id in('$ids')";
    			$transaction =\Yii::$app->db->beginTransaction();
    			try {
    				$command2= \Yii::$app->db->createCommand($sqldeleteall)->execute();
    				$transaction->commit();
    			
    				Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["type_config"]));
    				//return $this->redirect("type_config?massage=success");
    			} catch(Exception $e) {
    				$transaction->rollBack();
    				Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["type_config"]));
    				//return $this->redirect("type_config?massage=fail");
    			}
    		}
    	}
    	/* 删除 */
    	$code=isset($_GET['code'])?$_GET['code']:'';
    	if ($code!=''){
    		$transaction =\Yii::$app->db->beginTransaction();
    		try {
    			$command = \Yii::$app->db->createCommand("delete from v_travel_agent_type where id=$code")->execute();
    			$transaction->commit();
    			Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["type_config"]));
    			//return $this->redirect("type_config?massage=success");
    		} catch(Exception $e) {
    			$transaction->rollBack();
    			Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["type_config"]));
    			//return $this->redirect("type_config?massage=fail");
    			exit;
    		}
    	}
    	$sql = "SELECT a.*,b.travel_agent_level travel_agent_higher_level FROM `v_travel_agent_type` a LEFT JOIN `v_travel_agent_type` b ON a.travel_agent_higher_level_id = b.id where a.id>0 ";
    	$sqlcount = "SELECT a.*,b.travel_agent_level travel_agent_higher_level FROM `v_travel_agent_type` a LEFT JOIN `v_travel_agent_type` b ON a.travel_agent_higher_level_id = b.id where a.id>0 ";
    	$travel_agent_level=isset($_POST['travel_agent_level'])?$_POST['travel_agent_level']:'';
    	$status=isset($_POST['status'])?$_POST['status']:'2';
    	if ($_POST){
    		if ($travel_agent_level!=''){
    			$sql.=" and a.travel_agent_level='$travel_agent_level'";
    			$sqlcount.=" and a.travel_agent_level='$travel_agent_level'";
    		}
    		if ($status!=2){
    			$sql.=" and a.status='$status'";
    			$sqlcount.=" and a.status='$status'";
    		}
    	}
    	$sql.=" order by a.id limit 7";
    	$result = Yii::$app->db->createCommand($sql)->queryAll();
    	$countquery = Yii::$app->db->createCommand($sqlcount)->queryAll();
    	$count=sizeof($countquery);
    	return $this->render("type_config",['type_config_result'=>$result,'type_config_count'=>$count,'type_config_pag'=>1,'travel_agent_level'=>$travel_agent_level,'status'=>$status]);
    }
    //代理商等级获取
    public function actionFind_agent_type(){
    	$sql = "SELECT * FROM `v_travel_agent_type` WHERE status=1";
    	$result = Yii::$app->db->createCommand($sql)->queryAll();
    	if($result){
    		echo json_encode($result);
    	}  else {
    		echo 0;
    	}
    }
    //代理商等级分页
    public function actionGet_type_config_page(){
    	$tts=isset($_GET['tts'])?$_GET['tts']:'';
    	$ttsarray=explode(",",$tts);
    	$travel_agent_level=isset($ttsarray[1])?$ttsarray[1]:'';
    	$status=isset($ttsarray[2])?$ttsarray[2]:'';
    	$pag = isset($ttsarray[0])?$ttsarray[0]==1?0:($ttsarray[0]-1)*7:0;
    	$sql = "SELECT a.*,b.travel_agent_level travel_agent_higher_level FROM `v_travel_agent_type` a LEFT JOIN `v_travel_agent_type` b ON a.travel_agent_higher_level_id = b.id where a.id>0 ";
    	if ($travel_agent_level!=''){
    		$sql.=" and a.travel_agent_level='$travel_agent_level'";
    	}
    	if ($status!=2){
    		$sql.=" and a.status='$status'";
    	}
    	$sql.=" order by a.id limit $pag,7";
    	$result = Yii::$app->db->createCommand($sql)->queryAll();
    
    	if($result){
    		echo json_encode($result);
    	}  else {
    		echo 0;
    	}
    } 
    //代理商等级保存
    public function actionSave_travel_agent_level(){
    	$level = isset($_GET['level'])?$_GET['level']:'';
    	$higher_level = isset($_GET['higher_level'])?$_GET['higher_level']:0;
    	$state = isset($_GET['state'])?$_GET['state']:0;
    	$travel_agent_level =new VTravelAgentType();
    	$travel_agent_level->travel_agent_level=$level;
    	$travel_agent_level->travel_agent_higher_level_id=$higher_level;
    	$travel_agent_level->status=$state;
    	$result = $travel_agent_level->save();
    	
    	if($result){
    		echo 1;
    	}else{
    		echo 0;
    	} 	
    }
    /* 添加代理商 */
    public function actionTravel_agent_add(){ //增加代理商
    
    	$sql="select * from v_travel_agent_type where status=1";
    	$sql1="select * from v_c_country_i18n";
    	$gradeinfo = Yii::$app->db->createCommand($sql)->queryAll();
    	$contryinfo = Yii::$app->db->createCommand($sql1)->queryAll();
    	if ($_POST){
    		$travel_agent_name=$_POST['travel_agent_name'];
    		$travel_agent_address=$_POST['travel_agent_address'];
    		$travel_agent_phone=$_POST['travel_agent_phone'];
    		$travel_agent_post_code=$_POST['travel_agent_post_code'];
    		$travel_agent_email=$_POST['travel_agent_email'];
    		$travel_agent_fax=$_POST['travel_agent_fax'];
    		$travel_agent_bank_holder=$_POST['travel_agent_bank_holder'];
    		$travel_agent_account_bank=$_POST['travel_agent_account_bank'];
    		$travel_agent_account=$_POST['travel_agent_account'];
    		$travel_agent_contact_name=$_POST['travel_agent_contact_name'];
    		$travel_agent_contact_phone=$_POST['travel_agent_contact_phone'];
    		$travel_agent_admin=$_POST['travel_agent_admin'];
    		$travel_agent_password=$_POST['travel_agent_password'];
    		$pay_password=$_POST['pay_password'];
    		$sort_order=$_POST['sort_order'];
    		$travel_agent_status=$_POST['travel_agent_status'];
    		$contract_start_time=Helper::GetCreateTime($_POST['contract_start_time']);
    		$contract_end_time=Helper::GetCreateTime($_POST['contract_end_time']);
    		$country_code=$_POST['country_code'];
    		$city_code=isset($_POST['city_code'])?$_POST['city_code']:'';
    		$is_online_booking=$_POST['is_online_booking'];
    		$commission_percent=$_POST['commission_percent'];
    		$travel_agent_level=$_POST['travel_agent_level'];
    		$superior_travel_agent_code=$_POST['superior_travel_agent_code'];
    	   if(!is_numeric($travel_agent_phone)||!is_numeric($travel_agent_account)||!is_numeric($travel_agent_fax)||!is_numeric($travel_agent_admin)||!is_numeric($travel_agent_post_code)){
    	   	Helper::show_message(yii::t('vcos', "Option fail"),Url::toRoute(["travel_agent"]));
    	   }
    		$travel_agent_code=CreateMember::createMemberNumber();
    		$transaction =\Yii::$app->db->beginTransaction();
    		try {
    			$command = \Yii::$app->db->createCommand("insert into v_travel_agent(travel_agent_code,travel_agent_name,travel_agent_address,travel_agent_phone,travel_agent_post_code,travel_agent_email,travel_agent_fax,travel_agent_bank_holder,travel_agent_account_bank,travel_agent_account,travel_agent_contact_name,travel_agent_contact_phone,travel_agent_admin,travel_agent_password,pay_password,sort_order,travel_agent_status,contract_start_time,contract_end_time,country_code,city_code,is_online_booking,commission_percent,travel_agent_level,superior_travel_agent_code) values('$travel_agent_code','$travel_agent_name','$travel_agent_address','$travel_agent_phone','$travel_agent_post_code','$travel_agent_email','$travel_agent_fax','$travel_agent_bank_holder','$travel_agent_account_bank','$travel_agent_account','$travel_agent_contact_name','$travel_agent_contact_phone','$travel_agent_admin','$travel_agent_password','$pay_password','$sort_order','$travel_agent_status','$contract_start_time','$contract_end_time','$country_code','$city_code','$is_online_booking','$commission_percent','$travel_agent_level','$superior_travel_agent_code')")->execute();
    			$transaction->commit();
    			Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["travel_agent"]));
    			
    			//return $this->redirect("travel_agent?massage=success");
    		} catch(Exception $e) {
    			$transaction->rollBack();
    			Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["travel_agent"]));
    			//return $this->redirect("travel_agent?massage=fail");
    			exit;
    		}
    	}
    	
    	return $this->render("travel_agent_add",array("gradeinfo"=>$gradeinfo,'contryinfo'=>$contryinfo));
    }
    public function actionTravel_agent_edit(){//代理商编辑
    	$travel_agent_id=isset($_GET['id'])?$_GET['id']:'';
    	$ageninfo=array();
    	$sql2="select * from v_travel_agent where travel_agent_id=$travel_agent_id";//自身数据
    	$ageninfo = Yii::$app->db->createCommand($sql2)->queryAll();
    	$travel_agent_levelid=$ageninfo[0]['travel_agent_level'];//代理商父级链接id
    	$sql="select * from v_travel_agent_type where status=1";//类型表数据
    	$sql1="select * from v_c_country_i18n";
    	$contry=$ageninfo[0]['country_code'];//国家数据
    	$sql3="select * from v_c_city where country_code='$contry'";
    	$sql5="select travel_agent_level,travel_agent_name,travel_agent_code,travel_agent_id from v_travel_agent where travel_agent_level=(select travel_agent_higher_level_id from v_travel_agent_type where id=$travel_agent_levelid)";//父级代理商
    	$superinfo=Yii::$app->db->createCommand($sql5)->queryAll();/* 父级代理商 */
    	$gradeinfo = Yii::$app->db->createCommand($sql)->queryAll();
    	$contryinfo = Yii::$app->db->createCommand($sql1)->queryAll();
    	$cityinfo = Yii::$app->db->createCommand($sql3)->queryAll();
    	if ($_POST){
    		$model=new VTravelAgent();
    		$agid=$_POST['agid'];
    		$travel_agent_code=$_POST['travel_agent_code'];
    		$travel_agent_name=$_POST['travel_agent_name'];
    		$travel_agent_address=$_POST['travel_agent_address'];
    		$travel_agent_phone=$_POST['travel_agent_phone'];
    		$travel_agent_post_code=$_POST['travel_agent_post_code'];
    		$travel_agent_email=$_POST['travel_agent_email'];
    		$travel_agent_fax=$_POST['travel_agent_fax'];
    		$travel_agent_bank_holder=$_POST['travel_agent_bank_holder'];
    		$travel_agent_account_bank=$_POST['travel_agent_account_bank'];
    		$travel_agent_account=$_POST['travel_agent_account'];
    		$travel_agent_contact_name=$_POST['travel_agent_contact_name'];
    		$travel_agent_contact_phone=$_POST['travel_agent_contact_phone'];
    		$travel_agent_admin=$_POST['travel_agent_admin'];
    		$travel_agent_password=$_POST['travel_agent_password'];
    		$pay_password=$_POST['pay_password'];
    		$sort_order=$_POST['sort_order'];
    		$travel_agent_status=$_POST['travel_agent_status'];
    
    		$contract_start_time=Helper::GetCreateTime($_POST['contract_start_time']);
    		$contract_end_time=Helper::GetCreateTime($_POST['contract_end_time']);
    		$country_code=$_POST['country_code'];
    		$city_code=isset($_POST['city_code'])?$_POST['city_code']:'';
    		$is_online_booking=$_POST['is_online_booking'];
    		$commission_percent=$_POST['commission_percent'];
    		$travel_agent_level=$_POST['travel_agent_level'];
    		$superior_travel_agent_code=$_POST['superior_travel_agent_code'];
    		if ($travel_agent_status==0){//子代理商全都为不可用
    			Helper::cate($agid);
    		}
    		if(!is_numeric($travel_agent_phone)||!is_numeric($travel_agent_account)||!is_numeric($travel_agent_fax)||!is_numeric($travel_agent_admin)||!is_numeric($travel_agent_post_code)){
    			Helper::show_message(yii::t('app', "Option fail"),"travel_agent");//数字验证
    		}
    		$transaction =\Yii::$app->db->beginTransaction();
    		try {
    			$command = \Yii::$app->db->createCommand("update  v_travel_agent set travel_agent_code='$travel_agent_code',travel_agent_name='$travel_agent_name',travel_agent_address='$travel_agent_address',travel_agent_phone='$travel_agent_phone',travel_agent_post_code='$travel_agent_post_code',travel_agent_email='$travel_agent_email',travel_agent_fax='$travel_agent_fax',travel_agent_bank_holder='$travel_agent_bank_holder',travel_agent_account_bank='$travel_agent_account_bank',travel_agent_account='$travel_agent_account',travel_agent_contact_name='$travel_agent_contact_name',travel_agent_contact_phone='$travel_agent_contact_phone',travel_agent_admin='$travel_agent_admin',travel_agent_password='$travel_agent_password',pay_password='$pay_password',sort_order='$sort_order',travel_agent_status='$travel_agent_status',contract_start_time='$contract_start_time',contract_end_time='$contract_end_time',country_code='$country_code',city_code='$city_code',is_online_booking='$is_online_booking',commission_percent='$commission_percent',travel_agent_level='$travel_agent_level',superior_travel_agent_code='$superior_travel_agent_code' where travel_agent_id=$agid")->execute();
    			$transaction->commit();
    			//return $this->redirect("travel_agent?massage=success");
    			Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["travel_agent"]));
    		} catch(Exception $e) {
    			$transaction->rollBack();
    			Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["travel_agent"]));
    			//return $this->redirect("travel_agent?massage=fail");
    			exit;
    		}
    	}
      
    	return $this->render("travel_agent_edit",array("gradeinfo"=>$gradeinfo,'contryinfo'=>$contryinfo,'ageninfo'=>$ageninfo,'cityinfo'=>$cityinfo,'superinfo'=>$superinfo));
    }
    public function actionType_config_add(){//代理商类型增加
    	
    	if ($_POST){
    	
    		$travel_agent_level=$_POST['travel_agent_level'];
    		$travel_agent_higher_level_id=$_POST['travel_agent_higher_level_id'];
    		$status=$_POST['status'];
    		$higher_level_id=$travel_agent_higher_level_id;
    		$transaction =\Yii::$app->db->beginTransaction();
    		try {
    			$command = \Yii::$app->db->createCommand("insert into v_travel_agent_type(travel_agent_level,travel_agent_higher_level_id,status) values('$travel_agent_level','$higher_level_id','$status')")->execute();
    			$transaction->commit();
    			Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["type_config"]));
    			//return $this->redirect("type_config?massage=success");
    		} catch(Exception $e) {
    			$transaction->rollBack();
    			Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["type_config"]));
    			//return $this->redirect("type_config?massage=fail");
    			exit;
    		}
    	}
    	$sql="select * from v_travel_agent_type ";
    	$travel_agent_typeinfo = Yii::$app->db->createCommand($sql)->queryAll();
    return $this->render("type_config_add",array("travel_agent_typeinfo"=>$travel_agent_typeinfo));
    }
    public function actionType_config_edit(){//代理商类型编辑
    	if ($_POST){
    		$model=new VTravelAgentType();
    		$sid= $_POST['id'];
    		$model->id=$sid;
    		$travel_agent_level=$_POST['travel_agent_level'];
    		$travel_agent_higher_level_id=$_POST['travel_agent_higher_level_id'];
    		$status=$_POST['status'];
    		if ($model->validate()){
    			$transaction =\Yii::$app->db->beginTransaction();
    			try {
    				$command = \Yii::$app->db->createCommand("update v_travel_agent_type set travel_agent_level='$travel_agent_level',travel_agent_higher_level_id='$travel_agent_higher_level_id',status='$status' where id=$sid")->execute();
    				$transaction->commit();
    				Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["type_config"]));
    				//return $this->redirect("type_config?massage=success");
    			} catch(Exception $e) {
    				$transaction->rollBack();	
    				Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["type_config"]));
    				//return $this->redirect("type_config?massage=fail");
    				exit;
    			}	
    		}
    		else {
    			$errors = $model->errors;
    		}
    	/* 	$travel_agent_level=$_POST['travel_agent_level'];
    		$travel_agent_higher_level_id=$_POST['travel_agent_higher_level_id'];
    		$status=$_POST['status']; */
    	
    	
    	}
    	$id=isset($_GET['id'])?$_GET['id']:'';
    	$travelinfo=array();
    	if ($id!=''){
    		$sql1="select * from v_travel_agent_type where id=$id";
    		$travelinfo = Yii::$app->db->createCommand($sql1)->queryAll();
    	}
    	$sql="select * from v_travel_agent_type";
    	$travel_agent_typeinfo = Yii::$app->db->createCommand($sql)->queryAll();
    	return $this->render("type_config_edit",array("travel_agent_typeinfo"=>$travel_agent_typeinfo,'travelinfo'=>$travelinfo));
    }
    
    public function actionRecharge(){//充值
    	$travel_agent_id=isset($_POST['travel_agent_id'])?$_POST['travel_agent_id']:'';
    	$current=isset($_POST['current_amount'])?$_POST['current_amount']:'';
    	$proty_agent_id=isset($_POST['proty_agent_id'])?$_POST['proty_agent_id']:'';
    	if ($_POST){
    		if ($proty_agent_id==''){
    		$recharge_time=date('Y-m-d H:i:s',time());
    		if ($travel_agent_id!=''){
    			$recharge=$_POST['recharge'];
    			$remarks=$_POST['remarks'];
    			$current_amount=$current+$recharge;
    			$recharge=sprintf("%.2f", $recharge);
    			$current_amount=sprintf("%.2f", $current_amount);
    			$transaction =\Yii::$app->db->beginTransaction();
    			try {
    				$command = \Yii::$app->db->createCommand("update v_travel_agent set current_amount='$current_amount' where travel_agent_id=$travel_agent_id")->execute();
    				$command = \Yii::$app->db->createCommand("insert into v_agent_recharge(remarks,recharge_time,recharge_amount,agent_id) values('$remarks','$recharge_time','$recharge',$travel_agent_id)")->execute();
    				$transaction->commit();
    				Helper::show_message(yii::t('vcos', "Option success"),Url::toRoute(["recharge"]));
    				//return $this->redirect("type_config?massage=success");
    			} catch(Exception $e) {
    				$transaction->rollBack();
    				Helper::show_message(yii::t('vcos', "Option fail"),Url::toRoute(["recharge"]));
    				//return $this->redirect("type_config?massage=fail");
    				exit;
    			}
    		}
    		else{
    			Helper::show_message(yii::t('vcos', "Option fail"),Url::toRoute(["recharge"]));
    			exit;
    		}
    	}
    	else{
    	$travel_agent_name=isset($_POST['travel_agent_name'])?$_POST['travel_agent_name']:'';
    	$current_amount=isset($_POST['current_amount'])?$_POST['current_amount']:'';
    	$sql="select *,u.username from v_agent_recharge a left join v_travel_agent t on a.agent_id=t.travel_agent_id left join user u on u.id=a.admin_id  where a.agent_id='$proty_agent_id' order by a.recharge_time DESC";
    	$selectdata=new seletedata();
    	$data=$selectdata->paging($sql, $sql);
    	$data['travel_agent_name']=$travel_agent_name;
    	$data['proty_agent_id']=$proty_agent_id;
    	$data['current_amount']=$current_amount;
    	return $this->render("recharge",$data);
    	}
	    }
	    else{
	    	return $this->render("recharge");
	    }
	    }
   /* grade中ajax获取数据 */ 
    public function actionTravel_grade(){
    	$grade=isset($_POST['sortid'])?$_POST['sortid']:0;
    	$agent_id=isset($_POST['agent_id'])?$_POST['agent_id']:0;
    	if ($grade!=0){
    		$sqlsuper="select travel_agent_higher_level_id from v_travel_agent_type where id=$grade";
    		$gradesuper = Yii::$app->db->createCommand($sqlsuper)->queryAll();
    		$gradesuper=$gradesuper[0]['travel_agent_higher_level_id'];
    		$sql="select travel_agent_name,travel_agent_id from v_travel_agent where travel_agent_level=$gradesuper";
    		if($agent_id!=0){
    			$sql.=" and travel_agent_id <> $agent_id";
    		} 
    		$gradeinfo = Yii::$app->db->createCommand($sql)->queryAll();
    		if (sizeof($gradeinfo)==0){
    			echo json_encode(array(1=>'no'));
    		}
    		else {
    			echo json_encode($gradeinfo);
    			
    		}
    		
    	}
    	if($grade==0){
    		echo json_encode(array(1=>'no'));
    	}
    }
    /*contry中ajax获取数据 */
    public function actionTravel_contrycity(){
    	$country_code=isset($_GET['sortid'])?$_GET['sortid']:'';
    	$sql="select * from v_c_city where country_code='$country_code'";
    	$cityinfo = Yii::$app->db->createCommand($sql)->queryAll();
       echo json_encode($cityinfo);
    	}
    public function actionTravel_recharge(){  /*充值中ajax获取数据 */
    	$sql="select * from v_travel_agent where travel_agent_id>0";
    	$travel_agent_code=isset($_POST['code'])?$_POST['code']:'';
    	$travel_agent_name=isset($_POST['name'])?$_POST['name']:'';
    	$travel_agent_status=isset($_POST['status'])?$_POST['status']:'2';
    	
    	if ($travel_agent_code!=''){
    	$sql .= " AND (travel_agent_code LIKE '%{$travel_agent_code}%')";
    	}
    	if ($travel_agent_name!=''){
    		$sql .= " AND (travel_agent_name LIKE '%{$travel_agent_name}%')";
    	}
    	if ($travel_agent_status!='2'){
    		$sql .= " AND travel_agent_status=$travel_agent_status";
    	}
    	$sql .=" limit 6 ";
    	$data = Yii::$app->db->createCommand($sql)->queryAll();
        echo json_encode($data);
    }	
   public function actionTravel_agen_recharge(){
   	$agent_id=isset($_POST['agenid'])?$_POST['agenid']:'';
   	if ($agent_id!=''){
   	$sql="select * from v_travel_agent where travel_agent_id=$agent_id";
   	$data = Yii::$app->db->createCommand($sql)->queryAll();
   	echo json_encode($data);
   	}
   }
   public function actionAgentstatus(){//aja判断父级状态
   	$code=$_POST['code'];
   	$agent_status=$_POST['agent_status'];
  if ($agent_status==1){//想改变为可用父亲一定要可用
  	if($code==''){
  		echo json_encode(array(0=>1));
  	}
  	else{
  	$sql="select travel_agent_status from v_travel_agent where travel_agent_id='$code'";
  	$status = Yii::$app->db->createCommand($sql)->queryAll();
  	if($status[0]['travel_agent_status']==0){
  		echo json_encode(array(0=>0));//父级为不可用时，前段页面就提示不能更改为不可以用
  	}
  	else{
  		echo json_encode(array(0=>1));//父级为可用时，前段页面不处理；
  	}
  	}
  }
  else{
  	echo json_encode(array(0=>1));//父级为可用时，前段页面不处理；
  }
 /*   	if ($travel_agent_status==0){
   		Helper::cate($superior_travel_agent_code);
   	} */
   }
   public function actionAgentstatus1(){//aja判断父级状态
   	$is_code=$_POST['code'];
   	
   	$psql="select travel_agent_id from v_travel_agent where travel_agent_level=(select travel_agent_higher_level_id from v_travel_agent_type where id=$is_code)";
   	$hid = Yii::$app->db->createCommand($psql)->queryAll();
 $agent_status=$_POST['agent_status'];
   	if ($agent_status==1){//想改变为可用父亲一定要可用
   		if(sizeof($hid)==0){
   			echo json_encode(array(0=>1));
   		}
   		else{
   			$code=$hid[0]['travel_agent_id'];
   			$sql="select travel_agent_status from v_travel_agent where travel_agent_id='$code'";
   			$status = Yii::$app->db->createCommand($sql)->queryAll();
   			if($status[0]['travel_agent_status']==0){
   				echo json_encode(array(0=>0));//父级为不可用时，前段页面就提示不能更改为不可以用
   			}
   			else{
   				echo json_encode(array(0=>1));//父级为可用时，前段页面不处理；
   			}
   		}
   	}
   	else{
   		echo json_encode(array(0=>1));//父级为可用时，前段页面不处理；
   	}
   	/*   	if ($travel_agent_status==0){
   	 Helper::cate($superior_travel_agent_code);
   	 } */
   }
   public function actionType_statuscheck(){
   	$status=$_POST['status'];
   	$type_id=$_POST['type_id'];
   	if($status==0){
   		$sql="select * from v_travel_agent where travel_agent_level=$type_id";
   		$agentdata = Yii::$app->db->createCommand($sql)->queryAll();
   		if (!empty($agentdata)){
   			echo json_encode(array(0=>0));
   		}
   		else {
   			echo json_encode(array(0=>1));
   		}
   	}
   	else{
   		echo json_encode(array(0=>1));
   	}
   }
   public function actionCheckadmincount(){//帐号查重
   	$admin_count=$_POST['admin_count'];
   	$ageid=isset($_POST['agid'])?$_POST['agid']:'';
   	$sql="select * from v_travel_agent where travel_agent_admin='$admin_count'";
   	if ($ageid!=''){
   	$sql.=" and travel_agent_id<>$ageid";
   	}
   	$agentdata = Yii::$app->db->createCommand($sql)->queryAll();
   	if (!empty($agentdata)){
   		echo json_encode(array(0=>0));
   	}
   	else {
   		echo json_encode(array(0=>1));
   	}
   }
}  
    
