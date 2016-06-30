<?php

namespace app\modules\orgmanagement\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\orgmanagement\models\seletedata;
use app\modules\orgmanagement\models\VDepartment;
use app\modules\orgmanagement\models\VCCountryI18n;
use app\modules\orgmanagement\models\VEmployee;
use app\modules\orgmanagement\models\VEmploymentProfiles;
use app\modules\orgmanagement\components\Helper;
use app\modules\orgmanagement\components\CreateMember;

class UserController extends Controller
{
	public $enableCsrfValidation = false;
    public function actionIndex()
    {
    	/* 批量删除 */
    	if ($_POST){
    		$ids=isset($_POST['ids'])?$_POST['ids']:'';
    		$seleteselect=isset($_POST['seleteselect'])?$_POST['seleteselect']:'';
    		if (!empty($ids)&&$seleteselect!=''){
    			$ids=implode('\',\'',$ids);
    			$sqldeleteall="delete from v_employee where employee_code in('$ids')";
    			$sqldeleteall2="delete from v_employment_profiles where employee_code in('$ids')";
    			$transaction =\Yii::$app->db->beginTransaction();
    			try {
    				$command= \Yii::$app->db->createCommand($sqldeleteall)->execute();
    				$command2= \Yii::$app->db->createCommand($sqldeleteall2)->execute();
    				$transaction->commit();
    				Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["index"]));
    				//return $this->redirect("travel_agent?massage=success");
    			} catch(Exception $e) {
    				$transaction->rollBack();
    				Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["index"]));
    				//return $this->redirect("travel_agent?massage=fail");
    			}
    		}
    	}
    	/* 删除 */
    	$code=isset($_GET['code'])?$_GET['code']:'';
    	if ($code!=''){
    		$transaction =\Yii::$app->db->beginTransaction();
    		try {
    			$command = \Yii::$app->db->createCommand("delete from v_employee where employee_code='$code'")->execute();
    			$command2 = \Yii::$app->db->createCommand("delete from v_employment_profiles where employee_code='$code'")->execute();
    			$transaction->commit();
    			Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["index"]));
    			//return $this->redirect("travel_agent?massage=success");
    		} catch(Exception $e) {
    			$transaction->rollBack();
    			Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["index"]));
    			//return $this->redirect("travel_agent?massage=fail");
    			exit;
    		}
    	}
    	
    	$departmentsql="select * from v_department";
    	$departmentinfo= \Yii::$app->db->createCommand($departmentsql)->queryAll();
    	$db=\Yii::$app->db;
    	$employee_code=isset($_POST['employee_code'])?$_POST['employee_code']:'';
    	$full_name=isset($_POST['full_name'])?$_POST['full_name']:'';
    	$department_id=isset($_POST['department_id'])?$_POST['department_id']:'';
    	$sql="select *,ve.employee_code from (v_employee ve join v_employment_profiles vep on ve.employee_code=vep.employee_code) left join v_department vd on vd.department_id=vep.department_id where ve.employee_id>0";
    	if ($employee_code!=''){
    		$sql .= " AND (ve.employee_code LIKE '%{$employee_code}%')";
    	}
    	if ($full_name!=''){
    		$sql .= " AND (ve.full_name LIKE '%{$full_name}%')";
    	}
    	if ($department_id!=''){
    		$sql .= " AND vep.department_id=$department_id";
    	}
    	$selectdata=new seletedata();
    	$data=$selectdata->paging($sql, $sql);
    	$data['employee_code']=$employee_code;
    	$data['full_name']=$full_name;
    	$data['department_id']=$department_id;
    	$data['departmentinfo']=$departmentinfo;
        return $this->render('index',$data);
    }
    public function actionOption_user(){
    	$db = \Yii::$app->db;
    	$departmentsql="select * from v_department";
    	$departmentinfo= \Yii::$app->db->createCommand($departmentsql)->queryAll();
    	$countrysql="select * from v_c_country_i18n";
    	$countryinfo= \Yii::$app->db->createCommand($countrysql)->queryAll();
    	$selete=new seletedata();
    	$data=$selete->mydata();
    	$employee_job_status=$data['employee_job_status'];
    	$politicalstatus=$data['politicalstatus'];
    	$marrystatus=$data['marrystatus'];
    	$healthstatus=$data['healthstatus'];
    	$bloodtype=$data['bloodtype'];
    	$educat=$data['educat'];
    	$cardtype=$data['cardtype'];
    	$employee_type=$data['employee_type'];
    	$employeesource=$data['employeesource'];
    	$employee_status=$data['employee_status'];
    	$employee_code=isset($_GET['id'])?$_GET['id']:'';
    	$info=array();
    	$userinfo=array();
    	if ($employee_code!=''){
    		$sql="select *,ve.employee_status from v_employee ve join v_employment_profiles vep on vep.employee_code=ve.employee_code where ve.employee_code='$employee_code'";
    		$info= \Yii::$app->db->createCommand($sql)->queryAll();
    		$usersql="select * from user where employee_code='$employee_code'";
    		$userinfo= \Yii::$app->db->createCommand($usersql)->queryAll();
    	}
    	return $this->render("option_user",array(
    			'employee_job_status' =>$employee_job_status,
				'politicalstatus' =>$politicalstatus,
				'marrystatus'=> $marrystatus,
				'healthstatus'=> $healthstatus,
    			'bloodtype'=>$bloodtype,
    			'educat' =>$educat,
    			'cardtype'=> $cardtype,
    			'employee_type'=> $employee_type,
    			'employeesource'=>$employeesource,
				'employee_status'=>$employee_status,
				'countryinfo'=>$countryinfo,
    			'departmentinfo'=>$departmentinfo,
    			'info'=>$info,
    			'userinfo'=>$userinfo,
    					));
    }
    public function actionUser_addorinsert(){
    	$data['employee_card_number']=$_POST['employee_card_number'];
    	$data['employee_status']=$_POST['employee_status'];
    	$data['full_name']=$_POST['full_name'];
    	$data['first_name']=$_POST['first_name'];
    	$data['last_name']=$_POST['last_name'];
    	$data['country_code']=$_POST['country_code'];
    	$data['political_status']=$_POST['political_status'];
    	$data['gender']=$_POST['gender'];
    	$data['date_of_birth']=Helper::GetCreateTime($_POST['date_of_birth']);
    	$data['birth_place']=$_POST['birth_place'];
    	$data['card_type']=$_POST['card_type'];
    	$data['other_card_number']=$_POST['other_card_number'];
    	$data['resident_id_card']=$_POST['resident_id_card'];
    	$data['marry_status']=$_POST['marry_status'];
    	$data['health_status']=$_POST['health_status'];
    	$data['height']=$_POST['height'];
    	$data['weight']=$_POST['weight'];
    	$data['shoe_size']=$_POST['shoe_size'];
    	$data['blood_type']=$_POST['blood_type'];
    	$data['working_life']=$_POST['working_life'];
    	$data['major']=$_POST['major'];
    	$data['education']=$_POST['education'];
    	$data['foreign_language']=$_POST['foreign_language'];
    	$data['mailing_address']=$_POST['mailing_address'];
    	$data['dormitory_num']=$_POST['dormitory_num'];
    	$data['telephone_num']=$_POST['telephone_num'];
    	$data['mobile_num']=$_POST['mobile_num'];
    	$data['emergency_contact']=$_POST['emergency_contact'];
    	$data['emergency_contact_phone']=$_POST['emergency_contact_phone'];
 		$user_username=$data['full_name'];//插入会员数据
 		$user_m_status=$_POST['m_status'];
 		$user_createat=time();
 		$user_auth_key=Yii::$app->getSecurity()->generateRandomString();
 		$password_hash = Yii::$app->getSecurity()->generatePasswordHash($_POST['password_hash']);
 		$password_md5=md5($_POST['password_hash']);
 		$email=$_POST['email'];
    	$isemployee_code=isset($_POST['employee_code'])?$_POST['employee_code']:'';
    	if ($isemployee_code==''){
    		$data['employee_code']=CreateMember::createMemberNumber();
    	}
    	else{
    		$data['employee_code']=$isemployee_code;
    	}
    	$employee_code=$data['employee_code'];//v_employment_profiles数据
    	$department_id=$_POST['department_id'];
    	$date_of_entry=Helper::GetCreateTime($_POST['date_of_entry']);
    	$employee=new VEmployee();
    	$employeep=new VEmploymentProfiles();
    	$transaction =\Yii::$app->db->beginTransaction();
    	try {
    	if ($isemployee_code==''){//插入
    	$_employee = clone $employee;
    	$_employee->setAttributes($data);
    	$_employee->save();
    	/*  */
    	
    	$sql="insert into v_employment_profiles(employee_code,department_id,date_of_entry) values('$employee_code',$department_id,'$date_of_entry')";
    	$command = \Yii::$app->db->createCommand($sql)->execute();
    	if ($user_m_status==1){
    	$user = \Yii::$app->db->createCommand("insert into user(username,m_status,employee_code,created_at,auth_key,password_hash,password_md,email) values('$user_username','$user_m_status','$employee_code','$user_createat','$user_auth_key','$password_hash','$password_md5','$email')")->execute();
    		}
    	}
    		else{//更新
    		VEmployee::updateAll($data,"employee_code='$isemployee_code'");
    		$updatesql="update v_employment_profiles set department_id='$department_id',date_of_entry='$date_of_entry' where employee_code='$isemployee_code'";
    		$command = \Yii::$app->db->createCommand($updatesql)->execute();
    		$sqlu="select * from user where employee_code='$isemployee_code'";
    		$udata = \Yii::$app->db->createCommand($sqlu)->queryAll();
    		if(!empty($udata)&&$user_m_status==2){
    			$user = \Yii::$app->db->createCommand("update user set m_status=$user_m_status where employee_code='$employee_code'")->execute();
    		}
    		if($user_m_status==1){
    		if (empty($udata)){
    			$user = \Yii::$app->db->createCommand("insert into user(username,m_status,employee_code,created_at,auth_key,password_hash,password_md,email) values('$user_username','$user_m_status','$employee_code','$user_createat','$user_auth_key','$password_hash','$password_md5','$email')")->execute();
    		
    		}
    		else{
    			$user = \Yii::$app->db->createCommand("update user set m_status=$user_m_status,updated_at='$user_createat',auth_key='$user_auth_key',password_hash='$password_hash',password_md='$password_md5',email='$email' where employee_code='$employee_code'")->execute();
    		}
    		}
    		}
    	$transaction->commit();
    	Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["index"]));
    	} catch(Exception $e) {
    		$transaction->rollBack();
    		Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["index"]));
    		//return $this->redirect("travel_agent?massage=fail");
    		exit;
    	}
    	
    	
    }
}
