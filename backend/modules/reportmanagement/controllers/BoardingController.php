<?php
namespace app\modules\reportmanagement\controllers;
use Yii;
use yii\web\Controller;
use app\modules\reportmanagement\components\Helper;

class BoardingController extends Controller
{
    public function actionReport()
    {
		$time = date("Y-m",time());
    	$sql = " SELECT a.`voyage_code` , b.`voyage_name` FROM `v_c_voyage` a  LEFT JOIN `v_c_voyage_i18n` b ON a.`voyage_code` = b.`voyage_code` WHERE  `start_time` LIKE '$time%'  ORDER BY a.`id` DESC";
    	$voyage = Yii::$app->db->createCommand($sql)->queryAll();
    	
    	if($voyage) {
    		$voyage_code = $voyage['0']['voyage_code'];
    	}else {
    		$voyage_code = '';
    	}
    	
    	$sql = " SELECT a.port_code ,b.port_name FROM `v_c_voyage_port` a LEFT JOIN `v_c_port_i18n` b ON a.port_code=b.port_code WHERE a.`voyage_code`='$voyage_code'";
    	$port = Yii::$app->db->createCommand($sql)->queryAll();
    	return $this->render('report',['voyage'=>$voyage,'port'=>$port]);
    }
    
    //ajax获取航线
    public function actionGetvoyage()
    {
    	$time = Yii::$app->request->get('date');
    	$sql = " SELECT a.`voyage_code` , b.`voyage_name` FROM `v_c_voyage` a  LEFT JOIN `v_c_voyage_i18n` b ON a.`voyage_code` = b.`voyage_code` WHERE  `start_time` LIKE '$time%'  ORDER BY a.`id` DESC";
    	$voyage = Yii::$app->db->createCommand($sql)->queryAll();
    	echo json_encode($voyage);
    }
    
    //ajax获取港口
    public function actionGetport()
    {
    	$voyage_code = Yii::$app->request->get('voyage_code');
    	$sql = " SELECT a.id,a.port_code ,b.port_name FROM `v_c_voyage_port` a LEFT JOIN `v_c_port_i18n` b ON a.port_code=b.port_code WHERE a.`voyage_code`='$voyage_code'";
    	$port = Yii::$app->db->createCommand($sql)->queryAll();
    	echo json_encode($port);
    }
    
    //获取会员信息
    public function actionGetmemberinfo()
    {
    	$voyage_code = Yii::$app->request->get('voyage_code');
    	$port_id = Yii::$app->request->get('port_id');
    	$member_type = Yii::$app->request->get('member_type');
    	$bording_type = Yii::$app->request->get('bording_type');
    	$member = array();
    	
    	if(isset($voyage_code) && isset($port_id)){
    		
			$sql = " SELECT c.port_name FROM `v_c_voyage_boarding_recode` a  
					LEFT JOIN `v_c_voyage_port` b ON a.voyage_port_id = b.id 
					LEFT JOIN `v_c_port_i18n` c ON b.port_code = c.port_code
					WHERE a.voyage_port_id='$port_id' AND a.voyage_code='$voyage_code'";
			
    		$port = Yii::$app->db->createCommand($sql)->queryOne();
    		
    		if($bording_type != '-1'){
    			//已经上过船的
    			$sql = " SELECT * FROM `v_c_voyage_boarding_recode` WHERE `voyage_code`='$voyage_code' AND voyage_port_id='$port_id' AND person_type='$member_type' AND gangway_type='$bording_type' LIMIT 2 ";
    			$member = Yii::$app->db->createCommand($sql)->queryAll();
    			
    			//总记录条数
    			$sql = " SELECT count(*) as count FROM `v_c_voyage_boarding_recode` WHERE `voyage_code`='$voyage_code' AND voyage_port_id='$port_id' AND person_type='$member_type' AND gangway_type='$bording_type'";
    			$total = Yii::$app->db->createCommand($sql)->queryOne();
    			
    			$count = count($member);
    			for($i = 0;$i < $count;$i++) {
    				$sql = " SELECT * FROM `v_membership` WHERE `passport_number`='".$member[$i]['passport_number']."' ";
    				$membership = Yii::$app->db->createCommand($sql)->queryOne();
    				$member[$i]['member_name'] = $membership['full_name'];
    				
    				$sql = " SELECT cabin_name FROM `v_c_voyage_ticket` WHERE `passport`='".$member[$i]['passport_number']."'";
    				$cabin = Yii::$app->db->createCommand($sql)->queryOne();
    				
    				if($member[$i]['person_type'] == 1){
    					$member[$i]['member_type'] = '会员';
    				}else if ($member[$i]['person_type'] == 2){
    					$member[$i]['member_type'] = '船员';
    				}else if ($member[$i]['person_type'] == 3){
    					$member[$i]['member_type'] = '访客';
    				}
    				
    				if($membership['gender'] == "M"){
    					$member[$i]['gender'] = "Male";
    				}else {
    					$member[$i]['gender'] = "Female";
    				}
    				if($member[$i]['gangway_type'] == '1'){
    					$member[$i]['gangway_type'] = "登船";
    				}else if($member[$i]['gangway_type'] == '2') {
    					$member[$i]['gangway_type'] = "下船";
    				}
    				
    				$member[$i]['port_name'] = $port['port_name'];
    				$member[$i]['cabin_name'] = $cabin['cabin_name'];
    				$member[$i]['total'] = $total['count'];
    			}
    			
    		} else {
    			
    			//买了票但是没上过船的
    			$sql = " SELECT * FROM `v_c_voyage_boarding_recode`";
    			$boarding_member = Yii::$app->db->createCommand($sql)->queryAll();
    			
    			$members_passport = "";
    			
    			foreach ($boarding_member as $row){
    				$members_passport .= "'".$row['passport_number']."',";
    			}
				$members_passport = rtrim($members_passport,",");
				
				$sql = " SELECT * FROM `v_c_voyage_ticket` WHERE `passport` NOT IN ($members_passport) AND `voyage_code`='$voyage_code' AND `status`='1' LIMIT 2";
				$member = Yii::$app->db->createCommand($sql)->queryAll();
				
				
				$sql = " SELECT count(*) as count FROM `v_c_voyage_ticket` WHERE `passport` NOT IN ($members_passport) AND `voyage_code`='$voyage_code' AND `status`='1' LIMIT 2";
				$total = Yii::$app->db->createCommand($sql)->queryOne();
				
				$count = count($member);
				for($i = 0;$i < $count;$i++) {
					$sql = " SELECT * FROM `v_membership` WHERE `passport_number`='".$member[$i]['passport']."' ";
					$membership = Yii::$app->db->createCommand($sql)->queryOne();
					$member[$i]['member_name'] = $membership['full_name'];
					$member[$i]['passport_number'] = $member[$i]['passport'];
					$member[$i]['member_type'] = '会员';
					
					if($membership['gender'] == "M"){
						$member[$i]['gender'] = "Male";
					}else {
						$member[$i]['gender'] = "Female";
					}
					$member[$i]['boarding_time'] = '---';
					$member[$i]['gangway_type'] = '---';
					$member[$i]['gangway_number'] = '---';
					$member[$i]['port_name'] = '---';
					$member[$i]['total'] = $total['count'];
				}
    		}
    	}
    	
    	echo json_encode($member);
    }
    
    
    
    //分页
    public function actionGetreportpage()
    {
    	$voyage_code = Yii::$app->request->get('voyage_code');
    	$port_id = Yii::$app->request->get('port_id');
    	$member_type = Yii::$app->request->get('member_type');
    	$bording_type = Yii::$app->request->get('bording_type');
    	$page = (Yii::$app->request->get('page')-1)*2;
    	
    	if(isset($voyage_code) && isset($port_id)){
    	
    		$sql = " SELECT c.port_name FROM `v_c_voyage_boarding_recode` a
    		LEFT JOIN `v_c_voyage_port` b ON a.voyage_port_id = b.id
    		LEFT JOIN `v_c_port_i18n` c ON b.port_code = c.port_code
    		WHERE a.voyage_port_id='$port_id' AND a.voyage_code='$voyage_code'";
    			
    		$port = Yii::$app->db->createCommand($sql)->queryOne();
    	
    		if($bording_type != '-1'){
    			//已经上过船的
    			$sql = " SELECT * FROM `v_c_voyage_boarding_recode` WHERE `voyage_code`='$voyage_code' AND voyage_port_id='$port_id' AND person_type='$member_type' AND gangway_type='$bording_type' LIMIT $page,2 ";
    			$member = Yii::$app->db->createCommand($sql)->queryAll();
    			 
    			$count = count($member);
    			for($i = 0;$i < $count;$i++) {
    				$sql = " SELECT * FROM `v_membership` WHERE `passport_number`='".$member[$i]['passport_number']."' ";
    				$membership = Yii::$app->db->createCommand($sql)->queryOne();
    				$member[$i]['member_name'] = $membership['full_name'];
    	
    				$sql = " SELECT cabin_name FROM `v_c_voyage_ticket` WHERE `passport`='".$member[$i]['passport_number']."'";
    				$cabin = Yii::$app->db->createCommand($sql)->queryOne();
    	
    				if($member[$i]['person_type'] == 1){
    					$member[$i]['member_type'] = '会员';
    				}else if ($member[$i]['person_type'] == 2){
    					$member[$i]['member_type'] = '船员';
    				}else if ($member[$i]['person_type'] == 3){
    					$member[$i]['member_type'] = '访客';
    				}
    	
    				if($membership['gender'] == "M"){
    					$member[$i]['gender'] = "Male";
    				}else {
    					$member[$i]['gender'] = "Female";
    				}
    				if($member[$i]['gangway_type'] == '1'){
    					$member[$i]['gangway_type'] = "登船";
    				}else if($member[$i]['gangway_type'] == '2') {
    					$member[$i]['gangway_type'] = "下船";
    				}
    				$member[$i]['port_name'] = $port['port_name'];
    				$member[$i]['cabin_name'] = $cabin['cabin_name'];
    			}
    			 
    		} else {
    			 
    			//买了票但是没上过船的
    			$sql = " SELECT * FROM `v_c_voyage_boarding_recode`";
    			$boarding_member = Yii::$app->db->createCommand($sql)->queryAll();
    			 
    			$members_passport = "";
    			foreach ($boarding_member as $row){
    				$members_passport .= "'".$row['passport_number']."',";
    			}
    			$members_passport = rtrim($members_passport,",");
    	
    			$sql = " SELECT * FROM `v_c_voyage_ticket` WHERE `passport` NOT IN ($members_passport) AND `voyage_code`='$voyage_code' AND `status`='1' LIMIT $page,2";
    			$member = Yii::$app->db->createCommand($sql)->queryAll();
    	
    			$count = count($member);
    			for($i = 0;$i < $count;$i++) {
    				$sql = " SELECT * FROM `v_membership` WHERE `passport_number`='".$member[$i]['passport']."' ";
    				$membership = Yii::$app->db->createCommand($sql)->queryOne();
    				$member[$i]['member_name'] = $membership['full_name'];
    				$member[$i]['passport_number'] = $member[$i]['passport'];
    				$member[$i]['member_type'] = '会员';
    				if($membership['gender'] == "M"){
    					$member[$i]['gender'] = "Male";
    				}else {
    					$member[$i]['gender'] = "Female";
    				}
    				$member[$i]['boarding_time'] = '---';
    				$member[$i]['gangway_type'] = '---';
    				$member[$i]['gangway_number'] = '---';
    				$member[$i]['port_name'] = '---';
    			}
    		}
    	}
    	 
    	echo json_encode($member);
    }
    
    
    public function actionExportexcel()
    {
    	$voyage_code = Yii::$app->request->get('voyage_code');
    	$port_id = Yii::$app->request->get('port_id');
    	$member_type = Yii::$app->request->get('member_type');
    	$bording_type = Yii::$app->request->get('bording_type');
    	$page = (Yii::$app->request->get('page')-1)*2;
    	 
    	if(isset($voyage_code) && isset($port_id)){
    		 
    		$sql = " SELECT c.port_name FROM `v_c_voyage_boarding_recode` a
    		LEFT JOIN `v_c_voyage_port` b ON a.voyage_port_id = b.id
    		LEFT JOIN `v_c_port_i18n` c ON b.port_code = c.port_code
    		WHERE a.voyage_port_id='$port_id' AND a.voyage_code='$voyage_code'";
    		 
    		$port = Yii::$app->db->createCommand($sql)->queryOne();
    		 
    		if($bording_type != '-1'){
    			//已经上过船的
    			$sql = " SELECT * FROM `v_c_voyage_boarding_recode` WHERE `voyage_code`='$voyage_code' AND voyage_port_id='$port_id' AND person_type='$member_type' AND gangway_type='$bording_type' LIMIT $page,2 ";
    			$member = Yii::$app->db->createCommand($sql)->queryAll();
    	
    			$count = count($member);
    			for($i = 0;$i < $count;$i++) {
    				$sql = " SELECT * FROM `v_membership` WHERE `passport_number`='".$member[$i]['passport_number']."' ";
    				$membership = Yii::$app->db->createCommand($sql)->queryOne();
    				$member[$i]['member_name'] = $membership['full_name'];
    				 
    				$sql = " SELECT cabin_name FROM `v_c_voyage_ticket` WHERE `passport`='".$member[$i]['passport_number']."'";
    				$cabin = Yii::$app->db->createCommand($sql)->queryOne();
    				 
    				if($member[$i]['person_type'] == 1){
    					$member[$i]['member_type'] = '会员';
    				}else if ($member[$i]['person_type'] == 2){
    					$member[$i]['member_type'] = '船员';
    				}else if ($member[$i]['person_type'] == 3){
    					$member[$i]['member_type'] = '访客';
    				}
    				 
    				if($membership['gender'] == "M"){
    					$member[$i]['gender'] = "Male";
    				}else {
    					$member[$i]['gender'] = "Female";
    				}
    				if($member[$i]['gangway_type'] == '1'){
    					$member[$i]['gangway_type'] = "登船";
    				}else if($member[$i]['gangway_type'] == '2') {
    					$member[$i]['gangway_type'] = "下船";
    				}
    				$member[$i]['port_name'] = $port['port_name'];
    				$member[$i]['cabin_name'] = $cabin['cabin_name'];
    			}
    	
    		} else {
    	
    			//买了票但是没上过船的
    			$sql = " SELECT * FROM `v_c_voyage_boarding_recode`";
    			$boarding_member = Yii::$app->db->createCommand($sql)->queryAll();
    	
    			$members_passport = "";
    			foreach ($boarding_member as $row){
    				$members_passport .= "'".$row['passport_number']."',";
    			}
    			$members_passport = rtrim($members_passport,",");
    			 
    			$sql = " SELECT * FROM `v_c_voyage_ticket` WHERE `passport` NOT IN ($members_passport) AND `voyage_code`='$voyage_code' AND `status`='1' LIMIT $page,2";
    			$member = Yii::$app->db->createCommand($sql)->queryAll();
    			 
    			$count = count($member);
    			for($i = 0;$i < $count;$i++) {
    				$sql = " SELECT * FROM `v_membership` WHERE `passport_number`='".$member[$i]['passport']."' ";
    				$membership = Yii::$app->db->createCommand($sql)->queryOne();
    				$member[$i]['member_name'] = $membership['full_name'];
    				$member[$i]['passport_number'] = $member[$i]['passport'];
    				$member[$i]['member_type'] = '会员';
    				if($membership['gender'] == "M"){
    					$member[$i]['gender'] = "Male";
    				}else {
    					$member[$i]['gender'] = "Female";
    				}
    				$member[$i]['boarding_time'] = '---';
    				$member[$i]['gangway_type'] = '---';
    				$member[$i]['gangway_number'] = '---';
    				$member[$i]['port_name'] = '---';
    			}
    		}
    	}
    	$data = Helper::CreateExcelReportingList($member);
    	return $data;
    }
    
}
