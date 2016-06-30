<?php


namespace app\modules\membermanagement\controllers;
use app\modules\membermanagement\models\Country;
use app\modules\membermanagement\models\Membership;
use app\modules\membermanagement\models\Passport;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\modules\membermanagement\models\seletedata;
use app\modules\membermanagement\components\Helper;
use app\modules\membermanagement\components\CreateMember;


header ( "content-type:text/html;charset=utf-8" );



class MemberController extends Controller
{
    public $enableCsrfValidation = false;
    
   /*弹出跳转框
    */ 



   public function  mytrim()
   {
   	
   	   foreach ($_POST as $key => $value) {
   	   	$_POST[$key]=trim($value);//去空格
   	   	$_POST[$key]=htmlspecialchars($_POST[$key]);//专义html,js代码,防止前端代码注入
   	   	$$_POST[$key]=addslashes($_POST[$key]);//  过滤大部分的sql注入
   	   }
   	   
   	   foreach ($_GET as $key => $value) {
   	    $_GET[$key]=trim($value);//去空格
   	   	$_GET[$key]=htmlspecialchars($_GET[$key]);//专义html,js代码,防止前端代码注入
   	   	$_GET[$key]=addslashes($_GET[$key]);//  过滤大部分的sql注入
   	   }
   }





    public function actionIndex()
    {
   
    //	$this->mytrim();
        // 单条删除
      if (isset ( $_GET ['id'] )) {
      $id = trim($_GET ['id']); // 职务表id

      $sql="SELECT b.p_id FROM v_membership as a ,v_m_passport as b WHERE a.passport_number=b.passport_number AND a.m_id='{$id}'";
      $data= Yii::$app->db->createCommand ($sql)->queryOne();                 
      $p_id=$data['p_id'];
      $transaction =\Yii::$app->db->beginTransaction();
      try{
        $Membership=Membership::findOne($id);
        $Membership->delete();

        $Passport=Passport::findOne($p_id);
        $Passport->delete();
        $transaction->commit();
        Helper::show_message(yii::t ( 'app', 'delete success。' ),Url::to(['member/index']));
      } catch(Exception $e){
        $transaction->rollBack();//回滚事务
         Helper::show_message(yii::t ( 'app', 'delete  failure' ),Url::to(['member/index']));
    
      }
    }

    // 多条删除
$seleteselect=isset($_POST['seleteselect'])?$_POST['seleteselect']:'';//判断是否来自按批量删除按钮
if ($seleteselect==1){
    if (isset($_POST['ids'])) {
      $a = count ( $_POST ['ids'] );
      $data=$_POST ['ids'];
      $ids = implode ( '\',\'', $_POST ['ids'] );
      $Passport_id=array();
      foreach ($data as  $value) {
        $Passport_id[]=$value;
      }
      $Passport_ids=implode ( '\',\'', $Passport_id );
      // 事务处理
      $transaction =\Yii::$app->db->beginTransaction();
      try {
        Membership::deleteAll ( "m_id  in('$ids')" ); // 
        Passport::deleteAll ( "p_id  in('$Passport_ids')" );
        $transaction->commit ();
        Helper::show_message(yii::t ( 'app', 'delete success。' ),Url::to(['member/index']));
      } catch ( Exception $e ) {
        $transaction->rollBack ();
        Helper::show_message(yii::t ( 'app', 'delete  failure' ),Url::to(['member/index']));
      }
    }
	}
  $sql = "SELECT b.country_code,b.country_name  FROM v_c_country as a ,v_c_country_i18n as b WHERE a.country_code=b.country_code";
  $country= Yii::$app->db->createCommand ($sql)->queryAll();


  $sql="SELECT a.m_id,a.m_code,a.m_name,a.points,a.gender,b.country_name,c.passport_number  FROM v_membership as a  ,v_c_country_i18n as b  ,v_m_passport as c
    WHERE  a.country_code=b.country_code AND  a.passport_number =c.passport_number";
    	
  $countsql = "SELECT *  FROM v_membership as a  ,v_c_country_i18n as b  ,v_m_passport as c WHERE  a.country_code=b.country_code AND  a.passport_number =c.passport_number";
  $db = Yii::$app->db;
  
  
  
  //如果post过来的内容为空，则使用默认值
  $m_code = '';
  $m_name = '';
  $country_code = '';
  $_verification = '-1';
  $_isPage = 1;	//判断是否点击分页按钮(首页,1，2,..  1:表示点击查询按钮，2表示点击分页按钮)
  
  //分页
  $pageSize = 2 ;
  $page = isset($_POST['page']) ? $_POST['page'] : 1;
  $page_s = $page == 1 ? 0 : ($page-1) * $pageSize ;
  

  if($_POST)
  {
  	$m_code = (isset ( $_POST ['m_code'] )) ? trim ( $_POST ['m_code'] ) : '';
  	$m_name = (isset ( $_POST ['m_name'] )) ? trim ( $_POST ['m_name'] ) : '';
  	$country_code = (isset ( $_POST ['country_code'] )) ? trim ( $_POST ['country_code'] ) : '';
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
  
  
  $Searchdata = array ();
  $Searchdata ['m_code'] = $m_code;
  $Searchdata ['m_name'] = $m_name;
  $Searchdata ['country_code'] = $country_code;

 $search_sql="";
  /* $count_sql .= " ORDER BY employee_id ASC "; */
  if($m_code!=''){
  	$search_sql.=" AND a.m_code like '%{$m_code}%'";
  }
  if($m_name!=''){
  	$search_sql.=" AND a.m_name like '%{$m_name}%'";
  }
  if($country_code!=''){
  	$search_sql.=" AND a.country_code like '%{$country_code}%'";
  }
  $countsql.=$search_sql;
 
  $count = $db->createCommand($countsql)->queryAll();
  $count=sizeof($count);
  $maxcount=$count;
  $count = ceil( $count / $pageSize );
  if ($count==0){
  	$count=1;
  
  }
  $sql .=$search_sql. " LIMIT $page_s , $pageSize ";/* ORDER BY employee_id ASC */
  
  $member = $db->createCommand($sql)->queryAll();
  $data=array('member'=>$member,'count'=>$count,'maxcount'=>$maxcount,'page'=>$page,'isPage'=>$_isPage,
  
  );

  /* report分页 */
    	
  
    $data['country']=$country;
    $data['Searchdata']=$Searchdata;
   
   /*  */
        return $this->render('member',$data);
    }



  public function actionAdd_member()
  {

    $sql = "SELECT b.country_code,b.country_name  FROM v_c_country as a ,v_c_country_i18n as b WHERE a.country_code=b.country_code";
      $country= Yii::$app->db->createCommand ($sql)->queryAll();
      return $this->render('add_member',['country'=>$country]);
    }
   
    public function actionMember_edit()
    {

      $this->mytrim();
       $id=(isset($_GET['id']))?$_GET['id']:'';
       $id=trim($id);
        if($id=='')
        {
          return;
        }
      $sql="SELECT  a.*,b.date_expire ,b.date_issue,b.country_code as passport_country_code,b.place_issue FROM  v_membership as a ,v_m_passport as b WHERE a.passport_number=b.passport_number AND  a.m_id='{$id}'";
        
        $member= Yii::$app->db->createCommand ($sql)->queryOne();
     
   
        $sql="SELECT country_code  FROM v_m_passport

				WHERE  passport_number='{$member['passport_number']}'";
        
        $passport_country= Yii::$app->db->createCommand ($sql)->queryOne();
        
    
    	$sql = "SELECT b.country_code,b.country_name  FROM
       v_c_country as a ,v_c_country_i18n as b
      WHERE a.country_code=b.country_code";
    	$country= Yii::$app->db->createCommand ($sql)->queryAll();
    	return $this->render('member_edit',array(
    	'country'=>$country,
          'member'=>$member,
    	'passport_country'=>$passport_country
    
    	));
    }



    
    


     /*
     *ajax验证邮箱
     *
     */
    
       public function actionMember_email_validate()
    {
       $code='no';
     $email=(isset($_POST['email']))?$_POST['email']:'';
      $email=trim($email);
      if (($email=='')) {
       return;
       
      }
      
      
      if(isset($_POST['id']))
      {
      	$id=trim($_POST['id']);
      	if($id!='')
      	{
      		 
      		$sql = "SELECT a.email  FROM  v_membership  as a
      		WHERE a.m_id!='{$id}'";
      		$Data= Yii::$app->db->createCommand ($sql)->queryAll();
      
      
      		 
      	}
      
      }
      else{
      	
      	$sql = "SELECT a.email  FROM  v_membership  as a";
      	$Data= Yii::$app->db->createCommand ($sql)->queryAll();
      	
      }
     
      foreach ($Data as  $value) {
        if ($email==$value['email']) {
         $code='yes';
         break;
        }

       }


        echo $code;
    
    }


    /*
     *ajax验证mobile
     *
     */
      public function actionMember_mobile_validate()
    {
      	
    	
    	$code='no';
    	$mobile_number=(isset($_POST['mobile_number']))?$_POST['mobile_number']:'';
    	$mobile_number=trim($mobile_number);
    	if (($mobile_number=='')) {
    		return;
    	}
    	
    	
    	if(isset($_POST['id']))
    	{
    		$id=trim($_POST['id']);
    		if($id!='')
    		{
    			
    			$sql = "SELECT a.mobile_number  FROM  v_membership  as a
    					WHERE a.m_id!='{$id}'";
    			$Data= Yii::$app->db->createCommand ($sql)->queryAll();
    		
    			 
    			
    		}
    		
    	}
    	else {
    		
    		$sql = "SELECT a.mobile_number  FROM  v_membership  as a";
    		$Data= Yii::$app->db->createCommand ($sql)->queryAll();
    		
    	}
    	

    	
    	foreach ($Data as  $value) {
    		if ($mobile_number==$value['mobile_number']) {
    			$code='yes';
    			break;
    		}
    	
    	}
    	echo $code;
    }
    
    
    
    /*
     *ajax验证身份证id
     *
     */
    public function actionResident_id_card_validate()
    {
    	$code='no';
    	$resident_id_card=(isset($_POST['id_card']))?$_POST['id_card']:'';
    	$resident_id_card=trim($resident_id_card);
    	if (($resident_id_card=='')) {
    		return;
    	}
    	 
    	 
    	if(isset($_POST['id']))
    	{
    		$id=trim($_POST['id']);
    		if($id!='')
    		{
    			 
    			$sql = "SELECT a.resident_id_card  FROM  v_membership  as a
    			WHERE a.m_id!='{$id}'";
    			$Data= Yii::$app->db->createCommand ($sql)->queryAll();
    		}
    	}
    	else {
    
    		$sql = "SELECT a.resident_id_card  FROM  v_membership  as a";
    		$Data= Yii::$app->db->createCommand ($sql)->queryAll();
    
    	}
    	 
    	foreach ($Data as  $value) {
    		if ($resident_id_card==$value['resident_id_card']) {
    			$code='yes';
    			break;
    		}
    		 
    	}
    	 
    	 
    	echo $code;
    
    
    	 
    	 
 
    
    
    }
    
    
    
    /*
     *ajax验证会员编号
     *
     */
    public function actionMember_code_validate()
    {
    
    
    	$code='no';
    	$m_code=(isset($_POST['m_code']))?$_POST['m_code']:'';
    	$m_code=trim($m_code);
    	if (($m_code=='')) {
    		return;
    	}
    
    
    	if(isset($_POST['id']))
    	{
    		$id=trim($_POST['id']);
    		if($id!='')
    		{
    
    			$sql = "SELECT a.m_code  FROM  v_membership  as a
    			WHERE a.m_id!='{$id}'";
    			$Data= Yii::$app->db->createCommand ($sql)->queryAll();
    
    
    
    		}
    
    	}
    	else {
    
    		$sql = "SELECT a.m_code  FROM  v_membership  as a";
    		$Data= Yii::$app->db->createCommand ($sql)->queryAll();
    
    	}
    
    
    
    	foreach ($Data as  $value) {
    		if ($m_code==$value['m_code']) {
    			$code='yes';
    			break;
    		}
    		 
    	}
    
    
    	echo $code;
    
    }
    
    
    
  
    
    
    /*
     *ajax验证护照编号
     *
     */
    public function actionPassport_number_validate()
    {
    
    
    	$code='no';
    	$passport_number=(isset($_POST['passport_number']))?$_POST['passport_number']:'';
    	$passport_number=trim($passport_number);
    	if (($passport_number=='')) {
    		return;
    	}
    
    
    	if(isset($_POST['id']))
    	{
    		$id=trim($_POST['id']);
    		if($id!='')
    		{
    
    			$sql = "SELECT a.passport_number  FROM  v_membership  as a
    			WHERE a.m_id!='{$id}'";
    			$Data= Yii::$app->db->createCommand ($sql)->queryAll();
    
    
    
    		}
    
    	}
    	else {
    
    		$sql = "SELECT a.passport_number  FROM  v_membership  as a";
    		$Data= Yii::$app->db->createCommand ($sql)->queryAll();
    
    	}
    
    
    	foreach ($Data as  $value) {
    		if ($passport_number==$value['passport_number']) {
    			$code='yes';
    			break;
    		}
    		 
    	}
    
    
    	echo $code;
    
    }
    
    
    /*
     *ajax验证会员卡号
     *
     */
    public function actionMember_card_validate()
    {
    
    
    	$code='no';
    	$smart_card_number=(isset($_POST['smart_card_number']))?$_POST['smart_card_number']:'';
    	$smart_card_number=trim($smart_card_number);
    	if (($smart_card_number=='')) {
    		return;
    	}
    
    
    	if(isset($_POST['id']))
    	{
    		$id=trim($_POST['id']);
    		if($id!='')
    		{
    
    			$sql = "SELECT a.smart_card_number  FROM  v_membership  as a
    			WHERE a.m_id!='{$id}'";
    			$Data= Yii::$app->db->createCommand ($sql)->queryAll();
    		
    
    
    
    		}
    
    	}
    	else {
    
    		$sql = "SELECT a.smart_card_number  FROM  v_membership  as a";
    		$Data= Yii::$app->db->createCommand ($sql)->queryAll();
    
    	}
    
    
    
    	foreach ($Data as  $value) {
    		

    		if ($smart_card_number==$value['smart_card_number']) {
    			$code='yes';
    			echo $value['smart_card_number'];
    			exit();
    			break;
    		}
    		 
    	}
    
    
    	echo $code;
    
    
    
    
    
    
    
    }
    


    

    public function actionMember_add()
    {
    	$this->mytrim();
    	$resident_id_card= (isset ( $_POST ['resident_id_card'] )) ? $_POST ['resident_id_card'] :'';
    	$smart_card_number= (isset ( $_POST ['smart_card_number'] )) ? $_POST ['smart_card_number'] :'';
    	$m_code= (isset ( $_POST ['m_code'] )) ? $_POST ['m_code'] :'';
    	$vip_grade= (isset ( $_POST ['vip_grade'] )) ? $_POST ['vip_grade'] :'';
    	$country_code = (isset ( $_POST ['country_code'] )) ? $_POST ['country_code'] : '';
    	$m_name = (isset ( $_POST ['m_name'] )) ? $_POST ['m_name'] : '';
    	$first_name = (isset ( $_POST ['first_name'] )) ? $_POST ['first_name'] : '';
    	$fixed_telephone = (isset ( $_POST ['fixed_telephone'] )) ? $_POST ['fixed_telephone'] : '';
    	$points = (isset ( $_POST ['points'] )) ? $_POST ['points'] : '';
    	$last_name = (isset ( $_POST ['last_name'] )) ? $_POST ['last_name'] : '';
    	$mobile_number = (isset ( $_POST ['mobile_number'] )) ? $_POST ['mobile_number'] : '';
    	$birthday = (isset ( $_POST ['birthday'] )) ? $_POST ['birthday'] : '';
    	$gender= (isset ( $_POST ['gender'] )) ? $_POST ['gender'] : '';
    	$birth_place = (isset ( $_POST ['birth_place'] )) ? $_POST ['birth_place'] : '';
    	$m_password= (isset ( $_POST ['m_password'] )) ? $_POST ['m_password'] : '';
    	$create_time= (isset ( $_POST ['create_time'] )) ? $_POST ['create_time'] : '';
    	$balance= (isset ( $_POST ['balance'] )) ? $_POST ['balance'] : '';
    	$email= (isset ( $_POST ['email'] )) ? $_POST ['email'] : '';
    	
    	
    	
    	//
    	
    	
    	$Membership=new Membership();
    	 
    	
    	$passport_number = (isset ( $_POST ['passport_number'] )) ? $_POST ['passport_number'] : '';
    	$post_country_code= (isset ( $_POST ['post_country_code'] )) ? $_POST ['post_country_code'] : '';
    	$place_issue= (isset ( $_POST ['place_issue'] )) ? $_POST ['place_issue'] : '';
    	$date_issue= (isset ( $_POST ['date_issue'] )) ? $_POST ['date_issue'] : '';
    	$date_expire= (isset ( $_POST ['date_expire'] )) ? $_POST ['date_expire'] : '';
    	$Membership->resident_id_card=$resident_id_card;
    	$Membership->smart_card_number=$smart_card_number;
    	$Membership->m_code=CreateMember::createMemberNumber();
    	$Membership->passport_number=$passport_number;
    	$Membership->vip_grade=$vip_grade;
    	$Membership->country_code=$country_code;
    	$Membership->m_name=$m_name;
    	$Membership->first_name=$first_name;
    	$Membership->fixed_telephone=$fixed_telephone;
    	$Membership->points=$points;
    	$Membership->last_name=$last_name;
    	$Membership->mobile_number=$mobile_number;
    
    	$Membership->birthday=Helper::GetCreateTime($birthday);
    	$Membership->email=$email;
    	$Membership->gender=$gender;
    	$Membership->birth_place=$birth_place;
    	$Membership->m_password=$m_password;
    	$Membership->create_time=Helper::GetCreateTime($create_time);
    	$Membership->balance=$balance;
          $Passport=new  Passport();
          $Passport->passport_number=$passport_number;
          $Passport->country_code=$post_country_code;
          $Passport->place_issue=$place_issue;
          $Passport->date_issue=Helper::GetCreateTime($date_issue);
          $Passport->date_expire=Helper::GetCreateTime($date_expire);

          $transaction =\Yii::$app->db->beginTransaction();
                    try{

                        $Membership->save();
                        $Passport->save();
                    $transaction->commit();
                     Helper::show_message(yii::t ( 'app', 'add suceess' ),Url::to(['member/index']));
                    
                   
                    
                    
                    } catch(Exception $e){
                    $transaction->rollBack();//回滚事务
                   Helper::show_message(yii::t ( 'app', 'add  failure，请注意格式' ),Url::to(['member/index']));
                  

                    }
  

          
          



	

        $Passport= new  Passport();
        // $Passport->




          Yii::$app->db;
    	$sql = "SELECT b.country_code,b.country_name  FROM
    	 v_c_country as a ,v_c_country_i18n as b
        WHERE a.country_code=b.country_code";
		$country= Yii::$app->db->createCommand ($sql)->queryAll();
	
    	
        return $this->render('add_member',array(
        'country'=>$country



        	));
    }
    
    
    public function actionMember_edit_save()
    {
    	$this->mytrim();
    	
    
    
    	
    	$id = (isset ( $_GET ['id'] )) ? $_GET ['id'] : '';
    	$id=trim($id);
    	
    	


  
    	$resident_id_card= (isset ( $_POST ['resident_id_card'] )) ? $_POST ['resident_id_card'] :'';
    	$smart_card_number= (isset ( $_POST ['smart_card_number'] )) ? $_POST ['smart_card_number'] :'';
    	$m_code= (isset ( $_POST ['m_code'] )) ? $_POST ['m_code'] :'';
    	$vip_grade= (isset ( $_POST ['vip_grade'] )) ? $_POST ['vip_grade'] :'';
    	$country_code = (isset ( $_POST ['country_code'] )) ? $_POST ['country_code'] : '';
    	$m_name = (isset ( $_POST ['m_name'] )) ? $_POST ['m_name'] : '';
    	$first_name = (isset ( $_POST ['first_name'] )) ? $_POST ['first_name'] : '';
    	$fixed_telephone = (isset ( $_POST ['fixed_telephone'] )) ? $_POST ['fixed_telephone'] : '';
    	$points = (isset ( $_POST ['points'] )) ? $_POST ['points'] : '';
    	$last_name = (isset ( $_POST ['last_name'] )) ? $_POST ['last_name'] : '';
    	$mobile_number = (isset ( $_POST ['mobile_number'] )) ? $_POST ['mobile_number'] : '';
    	$birthday = (isset ( $_POST ['birthday'] )) ? $_POST ['birthday'] : '';
    	$gender= (isset ( $_POST ['gender'] )) ? $_POST ['gender'] : '';
    	$birth_place = (isset ( $_POST ['birth_place'] )) ? $_POST ['birth_place'] : '';
    	$m_password= (isset ( $_POST ['m_password'] )) ? $_POST ['m_password'] : '';
    	$create_time= (isset ( $_POST ['create_time'] )) ? $_POST ['create_time'] : '';
    	$balance= (isset ( $_POST ['balance'] )) ? $_POST ['balance'] : '';
    	$email= (isset ( $_POST ['email'] )) ? $_POST ['email'] : '';
    	
    	
    	
    	//
    	
    	$passport_number = (isset ( $_POST ['passport_number'] )) ? $_POST ['passport_number'] : '';
    	$post_country_code= (isset ( $_POST ['post_country_code'] )) ? $_POST ['post_country_code'] : '';
    	$place_issue= (isset ( $_POST ['place_issue'] )) ? $_POST ['place_issue'] : '';
    	$date_issue= (isset ( $_POST ['date_issue'] )) ? $_POST ['date_issue'] : '';
    	$date_expire= (isset ( $_POST ['date_expire'] )) ? $_POST ['date_expire'] : '';
    

    
    	$Membership= Membership::findOne($id);
    	$passport_number1=$Membership->passport_number;

    	
    	$sql="SELECT p_id FROM  v_m_passport where passport_number='{$passport_number1}'";
    	 
    	$p_id= Yii::$app->db->createCommand ($sql)->queryOne();
    	 
    	$p_id=$p_id['p_id'];
    	$Passport= Passport::findOne($p_id);
    
      $Membership->resident_id_card=$resident_id_card;
      $Membership->smart_card_number=$smart_card_number;
      $Membership->m_code=$m_code;
      $Membership->passport_number=$passport_number;
    	$Membership->vip_grade=$vip_grade;
    	$Membership->country_code=$country_code;
    	$Membership->m_name=$m_name;
    	$Membership->first_name=$first_name;
    	$Membership->fixed_telephone=$fixed_telephone;
    	$Membership->points=$points;
    	$Membership->last_name=$last_name;
    	$Membership->mobile_number=$mobile_number;
    	$Membership->birthday=Helper::GetCreateTime($birthday);
    	$day=substr($birthday, 0,2);
    	$month=substr($birthday, 3,2);
    	$year=substr($birthday, 6,4);
    	$time=substr($birthday,10,9);
    	
    	$Membership->email=$email;
    	$Membership->gender=$gender;
    	$Membership->birth_place=$birth_place;
    	$Membership->m_password=$m_password;
  		// echo $create_time;
    	$Membership->create_time=Helper::GetCreateTime($create_time);
    	$Membership->balance=$balance;
    	$Passport->passport_number=$passport_number;
    	$Passport->country_code=$post_country_code;
    	$Passport->place_issue=$place_issue;
    	$Passport->date_issue=Helper::GetCreateTime($date_issue);
    	$Passport->date_expire=Helper::GetCreateTime($date_expire);
    	

    	$transaction =\Yii::$app->db->beginTransaction();
    	try{
    
    		$Membership->save();
    		$Passport->save();
    		$transaction->commit();
      



        Helper::show_message(yii::t ( 'app', 'update sucess' ),Url::to(['member/index']));
      

    
    
    	} catch(Exception $e){
    		$transaction->rollBack();//回滚事务
    		 Helper::show_message(yii::t ( 'app', 'update failure' ),Url::to(['member/index']));
   
    
    	}
    

    exit();
    
    
    }
    
    
    public function actionMember_read()
    {
    
    	$this->mytrim();
    
    	$id=(isset($_GET['id']))?$_GET['id']:'';
    	if($id=='')
    	{
    		return;
    	}
    	$sql="SELECT  a.*,b.date_expire ,b.date_issue,b.place_issue FROM  v_membership as a ,v_m_passport as b
    	WHERE a.passport_number=b.passport_number
    	AND  a.m_id='{$id}'";
    
    	$member= Yii::$app->db->createCommand ($sql)->queryOne();
    	 
    	$sql="SELECT country_code  FROM v_m_passport
    
    	WHERE  passport_number='{$member['passport_number']}'";
    
    	$passport_country= Yii::$app->db->createCommand ($sql)->queryOne();
    
    
    	$sql = "SELECT b.country_code,b.country_name  FROM
       v_c_country as a ,v_c_country_i18n as b
      WHERE a.country_code=b.country_code";
    	$country= Yii::$app->db->createCommand ($sql)->queryAll();
    	return $this->render('member_read',array(
    			'country'=>$country,
    			'member'=>$member,
    			'passport_country'=>$passport_country
    
    	));
    }
    

    

    public function actionRecharge(){//充值
    	$t=isset($_POST['t'])?$_POST['t']:'';
    	$code=isset($_POST['proty_m_code'])?$_POST['proty_m_code']:'';
    	$m_code=isset($_POST['m_code'])?$_POST['m_code']:'';
    	$balance=isset($_POST['balance'])?$_POST['balance']:'';
    	$member_name2=isset($_POST['member_name2'])?$_POST['member_name2']:'';
    	if ($_POST){
    		$recharge_time=date('Y-m-d H:i:s',time());
    		if ($code==''){
    			
    			$recharge_amount=$_POST['recharge'];
    			$remarks=$_POST['remarks'];
    			$balance=$recharge_amount+$balance;
    			$recharge_amount=sprintf("%.2f", $recharge_amount);
    			$balance=sprintf("%.2f", $balance);
    			$transaction =\Yii::$app->db->beginTransaction();
    			try {
    				$command = \Yii::$app->db->createCommand("update v_membership set balance='$balance' where m_code='$m_code'")->execute();
    				$comman = \Yii::$app->db->createCommand("insert into v_membership_recharge(m_code,recharge_time,recharge_amount,remarks) values('$m_code','$recharge_time','$recharge_amount','$remarks')")->execute();
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
    	
    	if ($code!=''){
    	$sql="select * from v_membership_recharge mr left join v_membership m on mr.m_code=m.m_code where mr.m_code='$code'  order by mr.recharge_time DESC";
    	$selectdata=new seletedata();
    	$data=$selectdata->paging($sql, $sql);
    	$data['code']=$code;
    	$data['balance']=$balance;
    	$data['member_name2']=$member_name2;
    	return $this->render("recharge",$data);
    	}
    }
    else{
    	return $this->render("recharge");
    }
    }
    public function actionTravel_recharge(){  /*充值中ajax获取数据 */
    	$sql="select * from v_membership where m_id>0";
    	$m_code=isset($_POST['code'])?$_POST['code']:'';
    	$m_name=isset($_POST['name'])?$_POST['name']:'';
    	 
    	if ($m_code!=''){
    		$sql .= " AND (m_code LIKE '%{$m_code}%')";
    	}
    	if ($m_name!=''){
    		$sql .= " AND (m_name LIKE '%{$m_name}%')";
    	}
    	$sql .=" limit 6 ";
    	$data = Yii::$app->db->createCommand($sql)->queryAll();
    	foreach ($data as $k=>$v){
    		$v['m_name']=yii::t('vcos', $v['m_name']);
    	}
    	echo json_encode($data);
    }
    public function actionMember_recharge(){
    	$m_id=isset($_POST['memberid'])?$_POST['memberid']:'';
    	if ($m_id!=''){
    		$sql="select * from v_membership where m_id=$m_id";
    		$data = Yii::$app->db->createCommand($sql)->queryAll();
    		foreach ($data as $k=>$v){
    			$v['m_name']=yii::t('vcos', $v['m_name']);
    		}
    		echo json_encode($data);
    	}
    }



}
