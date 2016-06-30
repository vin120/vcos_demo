<?php

namespace app\modules\ordermanagement\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use app\modules\ordermanagement\components\Helper;
use app\modules\ordermanagement\models\VMembership;
use app\modules\ordermanagement\models\VMPassport;
use app\modules\ordermanagement\models\FinishData;

class OrderController extends Controller
{
	public $enableCsrfValidation = false;
    public function actionAgentorder()
    {   
    	$status=array(0=>'not pay',1=>'cancel',2=>'complete',3=>'failure');
    	$query  = new Query();
    	$order = $query->select(['order_serial_number','voyage_code','create_order_time','pay_time','travel_agent_name','total_pay_price','order_status','pay_status'])
		    	->from('v_voyage_order')
		    	->all();
    	
    	for ($i=0;$i<sizeof($order);$i++){//状态判断
    	$t=strtotime($order[$i]['pay_time'])-strtotime($order[$i]['create_order_time']);
    	$t=$t/60;
    	if ($t<45&&$order[$i]['pay_status']==0&&$order[$i]['order_status']==0){
    		$order[$i]['status']=yii::t('app',"not pay");
    	}
    	elseif ($order[$i]['order_status']==1){
    		$order[$i]['status']=yii::t('app',"cancel");
    	}
    	elseif ($order[$i]['pay_status']==1){
    		$order[$i]['status']=yii::t('app',"complete");
    	}
    	elseif ($t>=45&&$order[$i]['pay_status']==0&&$order[$i]['order_status']==0){
    		$order[$i]['status']=yii::t('app',"failure");
    	}
    	}
    	return $this->render('agentorder',['order'=>$order,'status'=>$status]);
    }
    public function actionGetorderpage(){//订单分页
    	$pag=isset($_POST['pag'])?($_POST['pag']-1)*2:0;
    	$t=isset($_POST['t'])?$_POST['t']:'0';
    	$order_serial_number=isset($_POST['order_serial_number'])?$_POST['order_serial_number']:'';
    	$status=isset($_POST['status'])?$_POST['status']:'100';
    	$travel_agent_name=isset($_POST['travel_agent_name'])?$_POST['travel_agent_name']:'';
    	$voyage_code=isset($_POST['voyage_code'])?$_POST['voyage_code']:'';
    	$sql="select * from v_voyage_order where id>0";
    	if ($t==1){
    	if ($order_serial_number!=''){
    		$sql .= " AND (order_serial_number LIKE '%{$order_serial_number}%')";
    	}
    	 if ($status!='100'){
    	 	if ($status==0){
    	 		$sql .= " AND pay_status='0' and order_status='0' and TIMESTAMPDIFF(MINUTE,create_order_time,pay_time)<45";
    	 	}
    	 	elseif ($status==1){
    	 		$sql .=" and order_status='1'";
    	 	}
    	 	elseif ($status==2){
    	 		$sql .=" and pay_status='1'";
    	 	}
    	 	elseif ($status==3){
    	 		$sql .=" and pay_status='0' and order_status='0' and TIMESTAMPDIFF(MINUTE,create_order_time,pay_time)>=45";
    	 	}
    	
    	}
    	if ($travel_agent_name!=''){
    		$sql .= " AND (travel_agent_name LIKE '%{$travel_agent_name}%')";
    	}
    	if ($voyage_code!=''){
    		$sql .= " AND (voyage_code LIKE '%{$voyage_code}%')";
    	} 
    	}
    	$countdata=\Yii::$app->db->createCommand($sql)->queryAll();
    	$sql.=" limit $pag,2";
    	$order=\Yii::$app->db->createCommand($sql)->queryAll();
    	for ($i=0;$i<sizeof($order);$i++){//状态判断
    		$t=strtotime($order[$i]['pay_time'])-strtotime($order[$i]['create_order_time']);
    		$t=$t/60;
    		if ($t<45&&$order[$i]['pay_status']==0&&$order[$i]['order_status']==0){
    			$order[$i]['status']=yii::t('app',"not pay");
    		}
    		elseif ($order[$i]['order_status']==1){
    			$order[$i]['status']=yii::t('app',"cancel");
    		}
    		elseif ($order[$i]['pay_status']==1){
    			$order[$i]['status']=yii::t('app',"complete");
    		}
    		elseif ($t>=45&&$order[$i]['pay_status']==0&&$order[$i]['order_status']==0){
    			$order[$i]['status']=yii::t('app',"failure");
    		}
    	}
    	if ($order){
    		
    		$count=sizeof($countdata);
    		$order['count']=$count;
    		echo json_encode($order);
    	}
    	else{
    		echo 0;
    	}
    }
    
    public function actionAgentorderdetail()
    {
    	$order_serial_number = Yii::$app->request->get('order_serial_number');
    	
    	$query  = new Query();
    	$order = $query->select(['voyage_code','travel_agent_name','total_pay_price'])
		    	->from('v_voyage_order')
		    	->where(['order_serial_number'=>$order_serial_number])
		    	->one();
    	
    	$member = array();
		$sql = "SELECT passport_number_one,passport_number_two,passport_number_three,passport_number_four,cabin_price,tax_price FROM v_voyage_order_detail WHERE order_serial_number ='$order_serial_number'";
		$passport = Yii::$app->db->createCommand($sql)->queryAll();
		$totalroomprice=0;
		$tax_price=0;
		$surcharge=0;
		$quayage=0;
		foreach ($passport as $key=>$row ){
			$totalroomprice=$totalroomprice+$row['cabin_price'];//房间总价
			$tax_price=$tax_price+$row['tax_price'];//税收
			$tmp1 = $row['passport_number_one'];
			$tmp2 = $row['passport_number_two'];
			$tmp3 = $row['passport_number_three'];
			$tmp4 = $row['passport_number_four'];
			$quayagesql1="select additional_price from v_voyage_order_detail d left join v_voyage_order_additional_price a on a.order_serial_number=d.order_serial_number and a.passport_number=d.passport_number_one and a.price_type=1 where a.passport_number='$tmp1'";
			$quayagesql2="select additional_price from v_voyage_order_detail d left join v_voyage_order_additional_price a on a.order_serial_number=d.order_serial_number and a.passport_number=d.passport_number_two and a.price_type=1 where a.passport_number='$tmp2'";
			$quayagesql3="select additional_price from v_voyage_order_detail d left join v_voyage_order_additional_price a on a.order_serial_number=d.order_serial_number and a.passport_number=d.passport_number_three and a.price_type=1 where a.passport_number='$tmp3'";
			$quayagesql4="select additional_price from v_voyage_order_detail d left join v_voyage_order_additional_price a on a.order_serial_number=d.order_serial_number and a.passport_number=d.passport_number_four and a.price_type=1 where a.passport_number='$tmp4'";
			$quayage1 = Yii::$app->db->createCommand($quayagesql1)->queryOne();//码头税
			$quayage2 = Yii::$app->db->createCommand($quayagesql2)->queryOne();//码头税
			$quayage3 = Yii::$app->db->createCommand($quayagesql3)->queryOne();//码头税
			$quayage4 = Yii::$app->db->createCommand($quayagesql4)->queryOne();//码头税
			$quayage=$quayage+$quayage1['additional_price']+$quayage2['additional_price']+$quayage3['additional_price']+$quayage4['additional_price'];
			$tmp = $row['passport_number_one'];
			//$sql = "SELECT * FROM v_membership WHERE passport_number='$tmp'";
			$sql="select m.*,a.additional_price,a.price_type from v_voyage_order_detail d
			left join v_membership m on m.passport_number=d.passport_number_one
			left join v_voyage_order_additional_price a on d.order_serial_number=a.order_serial_number and d.passport_number_one=a.passport_number and a.price_type=2
			where m.passport_number='$tmp'";	
			$info1 = Yii::$app->db->createCommand($sql)->queryOne();
			if(!empty($info1)){
				$surcharge=$surcharge+$info1['additional_price'];
				$member[$key][]=$info1;
			}
			$tmp = $row['passport_number_two'];
			//$sql = "SELECT * FROM v_membership WHERE passport_number='$tmp'";
			$sql="select m.*,a.additional_price,a.price_type from v_voyage_order_detail d
			left join v_membership m on m.passport_number=d.passport_number_two
			left join v_voyage_order_additional_price a on d.order_serial_number=a.order_serial_number and d.passport_number_two=a.passport_number  and a.price_type=2
			where  m.passport_number='$tmp'";
			$info2 = Yii::$app->db->createCommand($sql)->queryOne();
			if(!empty($info2)){
			$surcharge=$surcharge+$info2['additional_price'];
				$member[$key][]=$info2;
			}
			$tmp = $row['passport_number_three'];
			//$sql = "SELECT * FROM v_membership WHERE passport_number='$tmp'";
			$sql="select m.*,a.additional_price,a.price_type from v_voyage_order_detail d
			left join v_membership m on m.passport_number=d.passport_number_three
			left join v_voyage_order_additional_price a on d.order_serial_number=a.order_serial_number and d.passport_number_three=a.passport_number and a.price_type=2
			where  m.passport_number='$tmp'";
			$info3 = Yii::$app->db->createCommand($sql)->queryOne();
			if(!empty($info3)){
			$surcharge=$surcharge+$info3['additional_price'];
			$member[$key][]=$info3;
			}
			$tmp = $row['passport_number_four'];
			//$sql = "SELECT * FROM v_membership WHERE passport_number='$tmp'";
			$sql="select m.*,a.additional_price,a.price_type from v_voyage_order_detail d
			left join v_membership m on m.passport_number=d.passport_number_four
			left join v_voyage_order_additional_price a on d.order_serial_number=a.order_serial_number and d.passport_number_four=a.passport_number and a.price_type=2
			where m.passport_number='$tmp'";
			$info4= Yii::$app->db->createCommand($sql)->queryOne();
			if(!empty($info4)){
			$surcharge=$surcharge+$info4['additional_price'];
			$member[$key][]=$info4;
			}
		}
	
			$sql="select * from v_voyage_order_detail where order_serial_number='$order_serial_number'";
			$data=\Yii::$app->db->createCommand($sql)->queryAll();
			for($i=0;$i<sizeof($data);$i++){
				$data[$i]['member'] = $member;
	}
    	return $this->render('agentorderdetail',['order_serial_number'=>$order_serial_number,'order'=>$order,'data'=>$data,'surcharge'=>$surcharge,'quayage'=>$quayage]);
    }
    
    
    public function actionCabindetail()
    {
    	$cabin_typesql="select type_code from v_c_cabin_type";
    	$cabin_type=\Yii::$app->db->createCommand($cabin_typesql)->queryAll();
    	$order_serial_number=isset($_GET['order_serial_number'])?$_GET['order_serial_number']:'';
    	$voyage_code=isset($_GET['voyage_code'])?$_GET['voyage_code']:'';
    	$cabin_type_code=isset($_GET['cabin_type_code'])?$_GET['cabin_type_code']:'';
    	$cabin_name=isset($_GET['cabin_name'])?$_GET['cabin_name']:'';
    	$descsql="select `description` from `v_voyage_order_detail` where voyage_code='$voyage_code' and cabin_type_code='$cabin_type_code' and cabin_name='$cabin_name'";
    	$descinfo=\Yii::$app->db->createCommand($descsql)->queryOne();//描述
    	/* 会员信息 */
    	$membernumsql="select check_in_number,passport_number_one,passport_number_two,passport_number_three,passport_number_four from v_voyage_order_detail where voyage_code='$voyage_code' and cabin_name='$cabin_name' and cabin_type_code='$cabin_type_code'";
    	$membernum=\Yii::$app->db->createCommand($membernumsql)->queryOne();
    	$memberinfo=[];
    	$passport_number_one=$membernum['passport_number_one'];
    	$passport_number_two=$membernum['passport_number_two'];
    	$passport_number_three=$membernum['passport_number_three'];
    	$passport_number_four=$membernum['passport_number_four'];
    	if (!empty($passport_number_one)){
    	$membersql="select m.*,p.date_expire,p.country_code as post_country_code ,p.date_issue,p.place_issue from v_membership m join v_m_passport p on m.passport_number=p.passport_number where m.passport_number='$passport_number_one'";
    	$member=\Yii::$app->db->createCommand($membersql)->queryOne();
    	$memberinfo[]=$member;
    	}
    	if (!empty($passport_number_two)){
    		$membersql="select m.*,p.date_expire,p.country_code as post_country_code ,p.date_issue,p.place_issue from v_membership m join v_m_passport p on m.passport_number=p.passport_number where m.passport_number='$passport_number_two'";
    		$member=\Yii::$app->db->createCommand($membersql)->queryOne();
    		$memberinfo[]=$member;
    	}
    	if (!empty($passport_number_three)){
    		$membersql="select m.*,p.date_expire,p.country_code as post_country_code ,p.date_issue,p.place_issue from v_membership m join v_m_passport p on m.passport_number=p.passport_number where m.passport_number='$passport_number_three'";
    		$member=\Yii::$app->db->createCommand($membersql)->queryOne();
    		$memberinfo[]=$member;
    	}
    	if (!empty($passport_number_four)){
    		$membersql="select m.*,p.date_expire,p.country_code as post_country_code ,p.date_issue,p.place_issue from v_membership m join v_m_passport p on m.passport_number=p.passport_number where m.passport_number='$passport_number_four'";
    		$member=\Yii::$app->db->createCommand($membersql)->queryOne();
    		$memberinfo[]=$member;
    	}
    	$sql = "SELECT b.country_code,b.country_name  FROM
       	v_c_country as a ,v_c_country_i18n as b
     	 WHERE a.country_code=b.country_code";
    	$country= Yii::$app->db->createCommand ($sql)->queryAll();
    	
    	/* 换房选择 */
    	$ordercabinsql="select cabin_name from v_voyage_order_detail where voyage_code='$voyage_code' and cabin_type_code='$cabin_type_code'";
    	$ordercabin=\Yii::$app->db->createCommand($ordercabinsql)->queryAll();
    	$order_cabin=[];
    	foreach ($ordercabin as $k=>$v){
    		$order_cabin[]=$v['cabin_name'];
    	}
    	$voyage_idsql="select id from v_c_voyage where voyage_code='$voyage_code'";
    	$voyage_id=\Yii::$app->db->createCommand($voyage_idsql)->queryOne();
    	$voyage_id=$voyage_id['id'];
    	$order_cabin=implode('\',\'',$order_cabin);
    	$changcabinsql="select distinct vc.cabin_name, vt.type_code,vc.cabin_name 
    	from v_c_voyage_cabin vc 
    	join v_c_cabin_type vt on vc.cabin_type_id=vt.id
    	join v_c_voyage v on v.id=vc.voyage_id 
    	join v_voyage_order_detail vod on vod.voyage_code=v.voyage_code and vod.cabin_type_code=vt.type_code
    	where vc.voyage_id='$voyage_id' and vt.type_code='$cabin_type_code' and vc.cabin_name not in('$order_cabin')";
    	$changcabin=\Yii::$app->db->createCommand($changcabinsql)->queryAll();
    	return $this->render('cabindetail',['changcabin'=>$changcabin,'cabin_type'=>$cabin_type,'member'=>$member,'country'=>$country,'membernum'=>$membernum,'memberinfo'=>$memberinfo,'descinfo'=>$descinfo]);
    } 
    public function actionSavechangeroom(){//房间号码修改
    	$changetypecode=isset($_POST['changetypecode'])?$_POST['changetypecode']:'';//要改变的code
     	$changecabinname=isset($_POST['changecabinname'])?$_POST['changecabinname']:'';//要改变的name
   		$cabin_type_code=isset($_POST['cabin_type_code'])?$_POST['cabin_type_code']:'';//原先的code
    	$cabin_name=isset($_POST['cabin_name'])?$_POST['cabin_name']:'';//原先的name
     	$voyage_code=isset($_POST['voyage_code'])?$_POST['voyage_code']:'';
     	$description=$_POST['description'];
    	$sql="update v_voyage_order_detail set cabin_type_code='$changetypecode',cabin_name='$changecabinname',description='$description' where voyage_code='$voyage_code' and cabin_type_code='$cabin_type_code' and cabin_name='$cabin_name'";
    	$cabinsql="select id from v_c_cabin_type where type_code='$cabin_type_code'";
    	$cabin= \Yii::$app->db->createCommand($cabinsql)->queryOne();
    	$cabin_id=$cabin['id'];//原先的id

    	$vticketsql="update v_c_voyage_ticket set cabin_name='$changecabinname' and cabin_type_code='$changetypecode' where voyage_code='$voyage_code' and cabin_type_code='$cabin_type_code' and cabin_name='$cabin_name'";//ticket表的房间号跟着改变
    	$transaction =\Yii::$app->db->beginTransaction();
    	try {
    		$command2= \Yii::$app->db->createCommand($sql)->execute();
    		$command3= \Yii::$app->db->createCommand($vticketsql)->execute();
    		$transaction->commit();
    		echo 1;
    	} catch(Exception $e) {
    		$transaction->rollBack();
    		echo 0;
    	}
    }
    public function actionMemberedit(){
    	$m_code=$_POST['m_code'];
    	$data['resident_id_card']=isset($_POST['resident_id_card'])?$_POST['resident_id_card']:'';
    	$data['smart_card_number']=isset($_POST['smart_card_number'])?$_POST['smart_card_number']:'';
    	$data['vip_grade']=isset($_POST['vip_grade'])?$_POST['vip_grade']:'';
    	$data['country_code']=isset($_POST['country_code'])?$_POST['country_code']:'';
    	$data['member_verification']=isset($_POST['member_verification'])?$_POST['member_verification']:'';
    	$data['m_name']=isset($_POST['m_name'])?$_POST['m_name']:'';
    	$data['balance']=isset($_POST['balance'])?$_POST['balance']:'';
   		$data['first_name']=isset($_POST['first_name'])?$_POST['first_name']:'';
     	$data['fixed_telephone']=isset($_POST['fixed_telephone'])?$_POST['fixed_telephone']:'';
    	$data['points']=isset($_POST['points'])?$_POST['points']:'';
    	$data['last_name']=isset($_POST['last_name'])?$_POST['last_name']:'';
    	$data['mobile_number']=isset($_POST['mobile_number'])?$_POST['mobile_number']:'';
    	$data['birthday']=Helper::GetCreateTime($_POST['birthday']);
   		$data['email']=isset($_POST['email'])?$_POST['email']:'';
    	$data['gender']=isset($_POST['gender'])?$_POST['gender']:'';
    	$data['birth_place']=isset($_POST['birth_place'])?$_POST['birth_place']:'';
    	$data['m_password']=isset($_POST['m_password'])?$_POST['m_password']:'';
    	$data['create_time']=Helper::GetCreateTime($_POST['create_time']);
     	$data['passport_number']=isset($_POST['passport_number'])?$_POST['passport_number']:'';
    //	$data['post_country_code']=isset($_POST['post_country_code'])?$_POST['post_country_code']:'';
     	$data_p['date_issue']=Helper::GetCreateTime($_POST['date_issue']);
     	$data_p['date_expire']=Helper::GetCreateTime($_POST['date_expire']);
     	$data_p['place_issue']=isset($_POST['place_issue'])?$_POST['place_issue']:''; 
     	$data_p['country_code']=isset($_POST['post_country_code'])?$_POST['post_country_code']:'';
    	$transaction =\Yii::$app->db->beginTransaction();
    	try {
    		VMembership::updateAll($data,'m_code=:m_code',[':m_code'=>$m_code]);
    		VMPassport::updateAll($data_p,'passport_number=:passport_number',[':passport_number'=>$data['passport_number']]);
    		$transaction->commit();
    		echo 1;
    	} catch(Exception $e) {
    		$transaction->rollBack();
    		echo 0;
    	}
    }
    
    
    
    
    //-----------start
    public function actionReturnroom(){
    	$ids = isset($_GET['ids'])?$_GET['ids']:'';
    	$order_serial_number = isset($_GET['order_serial_number'])?$_GET['order_serial_number']:'';
    	$query  = new Query();
    	$order_result = $query->select(['order_serial_number','voyage_code','travel_agent_name'])
    	->from('v_voyage_order')
    	->where(['order_serial_number'=>$order_serial_number])
    	->one();
    	
    	$sql = "SELECT a.id,c.type_code,c.type_name,a.cabin_name,a.cabin_price,a.tax_price,d.harbour_taxes,a.check_in_number,a.passport_number_one,a.passport_number_two,a.passport_number_three,a.passport_number_four FROM `v_voyage_order_detail` a
    	LEFT JOIN `v_c_cabin_type` b ON a.cabin_type_code = b.type_code
    	LEFT JOIN `v_c_cabin_type_i18n` c ON b.type_code=c.type_code
    	LEFT JOIN `v_c_voyage` d ON a.voyage_code=d.voyage_code
    	WHERE a.id in ({$ids})";
    	$data = \Yii::$app->db->createCommand($sql)->queryAll();
    	$user_field = ['one','two','three','four'];
    	$data_arr = array();
    	foreach ($data as $v){
    		$user_passports = '';
    		for ($i=0;$i<$v['check_in_number'];$i++){
    			$passport = 'passport_number_'.$user_field[$i];
    			$user_passports .= "'".$v[$passport]."',";
    		}
    		$user_passports = trim($user_passports,',');
    		//港口
    		$sql = "SELECT sum(additional_price) port_price FROM `v_voyage_order_additional_price` WHERE price_type=1 AND passport_number in ({$user_passports}) AND order_serial_number='{$order_serial_number}'";
    		$port_data = \Yii::$app->db->createCommand($sql)->queryOne();
    		//附加费
    		$sql = "SELECT sum(additional_price) add_price FROM `v_voyage_order_additional_price` WHERE price_type in (2,3) AND passport_number in ({$user_passports}) AND order_serial_number='{$order_serial_number}'";
    		$add_data = \Yii::$app->db->createCommand($sql)->queryOne();
    		$v['port_price'] = $port_data['port_price'];
    		$v['add_price'] = $add_data['add_price'];
    		$v['total_price'] = (float)$v['cabin_price'] + (float)$v['tax_price'] + (float)$port_data['port_price'] + (float)$add_data['add_price'];
    		$data_arr[] = $v;
    	}
    	//var_dump($data_arr);exit;
    	return $this->render('returnroom',['order_result'=>$order_result,'data_arr'=>$data_arr]);
    	 
    }
    
    
    
    //退票保存
    Public function actionReturnroomsave(){
    	$success = 0;
    	$voyage_code = isset($_POST['voyage_code'])?$_POST['voyage_code']:'';
    	$order_num = isset($_POST['order_num'])?$_POST['order_num']:'';
    	$cabin_type = isset($_POST['cabin_type'])?$_POST['cabin_type']:'';
    	$cabin_name = isset($_POST['cabin_name'])?$_POST['cabin_name']:'';
    	$return_room_price = isset($_POST['return_room_price'])?$_POST['return_room_price']:'';
    	$desc = isset($_POST['desc'])?addslashes($_POST['desc']):'';
    	 
    	$cabin_type = explode(',', $cabin_type);
    	$cabin_name = explode(',', $cabin_name);
    	$return_room_price = explode(',', $return_room_price);
    	 
    	$connecton = Yii::$app->db;
    	$transaction = $connecton->beginTransaction();
    	try{
    		$where = '';
    		$cabin_name_in = '';
    		$sql = "INSERT INTO `v_c_voyage_return_ticket_record` (order_serial_number,voyage_code,cabin_type_code,cabin_name,return_price,remark) VALUES ";
    		foreach ($cabin_type as $k=>$v){
    			$cabin_name_in .= "'".$cabin_name[$k]."',";
    			$where .= "('{$order_num}','{$voyage_code}','{$v}','{$cabin_name[$k]}','{$return_room_price[$k]}','{$desc}'),";
    			 
    		}
    		$cabin_name_in = trim($cabin_name_in,',');
    		$where = trim($where,',');
    		$sql = $sql.$where;
    		\Yii::$app->db->createCommand($sql)->execute();
    
    		//改变状态
    		$sql = "UPDATE `v_voyage_order_detail` SET status='3' WHERE order_serial_number='{$order_num}' AND voyage_code='{$voyage_code}' AND cabin_name in ($cabin_name_in)";
    		\Yii::$app->db->createCommand($sql)->execute();
    
    		$sql = "UPDATE `v_c_voyage_ticket` SET status='2' WHERE order_serial_number='{$order_num}' AND voyage_code='{$voyage_code}' AND cabin_name in ($cabin_name_in)";
    		\Yii::$app->db->createCommand($sql)->execute();
    
    		$transaction->commit();
    		$success = 1;
    	}catch (Exception $e){
    		$transaction->rollBack();
    		$success = 0;
    	}
    	 
    	echo $success;
    }
    
    //---------end
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
