<?php
namespace app\modules\orgmanagement\models;


use Yii;
class seletedata 
{
public function mydata(){
	$data['employee_status']=array(0=>'Waiting for the upload',1=>'Have a boat',2=>'In the holiday');//船员状态
	$data['marrystatus']=array(0=>'unmarried',1=>'married',2=>'divorced',3=>'death of a spouse');//婚姻状况
	$data['healthstatus']=array(0=>'health',1=>'general',2=>'poor');//健康状况
	$data['bloodtype']=array(0=>'A',1=>'B',2=>'AB',3=>'O');//血型
	$data['educat']=array(0=>'Under the high school',1=>'Technical secondary school',2=>'college',3=>'Undergraduate course',4=>'A master is degree',5=>'Dr.');//'学历
	$data['cardtype']=array(0=>'passport',1=>'Id card',2=>'Other certificates');//'证件类型
	$data['employee_type']=array(0=>'Freedom of the crew',1=>'The crew of lease',2=>'Outside the crew ');//'船员类型
	$data['employeesource']=array(0=>'Fresh graduates recruitment',1=>'Social recruitment',2=>'The internal recruitment');//员工来源
	$data['employee_job_status']=array(0=>'internship',1=>'The trial',2=>'positive',3=>'departure');//在职状态
	$data['politicalstatus']=array(0=>'The crowd ',1=>'League member',2=>'The party member',3=>'The democratic parties');//政治面貌
	return $data;
}
public function paging($sql,$count_sql){
	$db = Yii::$app->db;
	
	

	//如果post过来的内容为空，则使用默认值
	$_name = '';
	$_code = '';
	
	$_verification = '-1';
	$_isPage = 1;	//判断是否点击分页按钮(首页,1，2,..  1:表示点击查询按钮，2表示点击分页按钮)
	
	//分页
	$pageSize = 7 ;
	$page = isset($_POST['page']) ? $_POST['page'] : 1;
	$page_s = $page == 1 ? 0 : ($page-1) * $pageSize ;
	
	//$page = isset($_POST['page']) ? $_POST['page'] == 1 ? 0 : ($_POST['page']-1)*10 : 0;
	
	
	if($_POST)
	{
	
	
		/*
		 SELECT * FROM vcos_member WHERE cn_name LIKE %$member_name% OR last_name LIKE %$member_name% OR first_name LIKE %$member%
		 AND member_code LIKE %$member_code%
		 AND sex = $sex
		 AND member_verification = $member_verification
		 */
	
	
	
		$isPage = (isset($_POST['isPage'])) ? $_POST['isPage'] : '1';
	
	
	
	
		$_isPage = $isPage;
	
		//如果post的内容不为默认值，拼接字符串进行模糊查询
	
	
	}
	
	//如果是点击查询按钮，重置页码为第一页
	if($_isPage == '1')
	{
		$page = 1;
		$page_s = 0;
	}
    
	/* $count_sql .= " ORDER BY employee_id ASC "; */
	$count = $db->createCommand($count_sql)->queryAll();
    $count=sizeof($count);
    $maxcount=$count;
	$count = ceil( $count / $pageSize );
	if ($count==0){
		$count=1;
	
	}
	$sql .= " LIMIT $page_s , $pageSize ";/* ORDER BY employee_id ASC */
    
	$pagedata = $db->createCommand($sql)->queryAll();
    $data=array('pagedata'=>$pagedata,'count'=>$count,'maxcount'=>$maxcount,'verification'=>$_verification,'page'=>$page,'isPage'=>$_isPage,
			
	);
	return $data;
}
 /* report分页 */

  
}