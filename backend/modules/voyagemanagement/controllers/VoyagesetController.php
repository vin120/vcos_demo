<?php

namespace app\modules\voyagemanagement\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;
use app\modules\voyagemanagement\models\VCVoyage;
use app\modules\voyagemanagement\models\VCVoyageI18n;
use yii\db\Query;
use app\modules\voyagemanagement\models\VCVoyagePort;
use app\modules\voyagemanagement\models\VCVoyageCabin;



class VoyagesetController extends Controller
{
	public function actionIndex()
	{
		$_voyage_name = '';
		$_s_time = '';
		$_e_time = '';
		$where_voyage_name = [];
		$where_s_time = [];
		$where_e_time = [];
		if($_POST){
			$voyage_name = isset($_POST['voyage_name']) ? $_POST['voyage_name'] : '';
			$s_time = isset($_POST['s_time']) ? $_POST['s_time'] : '';
			$e_time = isset($_POST['e_time']) ? $_POST['e_time'] : '';
			
			if($s_time!=''){
				$s_time = Helper::GetCreateTime($s_time);
			}
			if($e_time!=''){
				$e_time = Helper::GetCreateTime($e_time);
			}
			$_voyage_name = $voyage_name;
			$_s_time = $s_time;
			$_e_time = $e_time;
			
			if($voyage_name != ''){
				$where_voyage_name = ['like','voyage_name',$voyage_name];
			}
			
			if($s_time != ''){
				$where_s_time = ['>','a.start_time',$s_time];;
			}

			if($e_time != ''){
				$where_e_time = ['<','a.end_time',$e_time];
			}
		}
		
		$query  = new Query();
		$voyage = $query->select(['a.id','a.voyage_code','a.start_time','a.end_time','b.voyage_name'])
				->from('v_c_voyage a')
				->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
				->where(['b.i18n'=>'en'])
				->andWhere($where_voyage_name)
				->andWhere($where_s_time)
				->andWhere($where_e_time)
				->limit(2)
				->all();
		
		
		
		$query  = new Query();
		$count = $query->from('v_c_voyage a')
				->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
				->where(['b.i18n'=>'en'])
				->andWhere($where_voyage_name)
				->andWhere($where_s_time)
				->andWhere($where_e_time)
				->count();
	
		return $this->render("index",['voyage_pag'=>1,'voyage'=>$voyage,'count'=>$count,'voyage_name'=>$_voyage_name,'s_time'=>$_s_time,'e_time'=>$_e_time]);
	}

	//航线分页
	public function actionGetvoyagepage()
	{
		$pag = isset($_GET['pag'])?$_GET['pag']==1?0:($_GET['pag']-1)*2:0;
		$voyage_name = isset($_GET['voyage_name']) ? $_GET['voyage_name'] : '';
		$s_time = isset($_GET['s_time']) ? $_GET['s_time'] : '';
		$e_time = isset($_GET['e_time']) ? $_GET['e_time'] : '';

		$where_voyage_name = [];
		$where_s_time = [];
		$where_e_time = [];
		
		
		if($voyage_name != ''){
			$where_voyage_name = ['like','voyage_name',$voyage_name];
		}
		
		if($s_time != ''){
			$where_s_time = ['>','a.start_time',$s_time];;
		}

		if($e_time != ''){
			$where_e_time = ['<','a.end_time',$e_time];
		}
		
		$query  = new Query();
		$result = $query->select(['a.id','a.voyage_code','a.start_time','a.end_time','b.voyage_name'])
				->from('v_c_voyage a')
				->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
				->where(['b.i18n'=>'en'])
				->andWhere($where_voyage_name)
				->andWhere($where_s_time)
				->andWhere($where_e_time)
				->offset($pag)
				->limit(2)
				->all();
		

		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
	}

	public function actionVoyageadd()
	{
		if($_POST){
			$voyage_name = isset($_POST['voyage_name']) ? $_POST['voyage_name'] : '';
			$voyage_code = isset($_POST['voyage_code']) ? $_POST['voyage_code'] : '';
			$area_code = isset($_POST['area']) ? $_POST['area'] : '';
			$cruise_code = isset($_POST['cruise']) ? $_POST['cruise'] : '';
			$s_time = isset($_POST['s_time']) ? $_POST['s_time'] : '';
			$e_time = isset($_POST['e_time']) ? $_POST['e_time'] : '';
			$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
			$s_book_time = isset($_POST['s_book_time']) ? $_POST['s_book_time'] : '';
			$e_book_time = isset($_POST['e_book_time']) ? $_POST['e_book_time'] : '';
			$ticket_price = isset($_POST['ticket_price']) ? $_POST['ticket_price'] : 0;
			$ticket_taxes = isset($_POST['ticket_taxes']) ? $_POST['ticket_taxes'] : 0;
			$harbour_taxes = isset($_POST['harbour_taxes']) ? $_POST['harbour_taxes'] : 0;
			$deposit_ratio = isset($_POST['deposit_ratio']) ? $_POST['deposit_ratio'] : 0;
			
			if($s_time!=''){
				$s_time = Helper::GetCreateTime($s_time);
			}
			if($e_time!=''){
				$e_time = Helper::GetCreateTime($e_time);
			}
			if($s_book_time!=''){
				$s_book_time = Helper::GetCreateTime($s_book_time);
			}
			if($e_book_time!=''){
				$e_book_time = Helper::GetCreateTime($e_book_time);
			}
			
			$pdf_path = '';
			$allowsize = 3*1024*1024;
			if(isset($_FILES['pdf'])){
				if($_FILES['pdf']['error'] != 1){
					if($_FILES['pdf']['error'] != 4){
						if($_FILES['pdf']['type'] == 'application/pdf'){
							$result=Helper::upload_file('pdf', Yii::$app->params['img_save_url'].'voyagemanagement/themes/basic/static/upload/'.date('Ym',time()), 'pdf', 3);
							$pdf_path=date('Ym',time()).'/'.$result['filename'];
						}else {
							Helper::show_message('Wrong Format','#');
							die;
						}
					}
				}else{
					Helper::show_message('You have uploaded file size is more than the size of the server configuration');
					die;
				}
			}
		

			if($voyage_name != '' && $voyage_code != '' && $ticket_price != '' && $ticket_taxes != '' && $harbour_taxes != '' && $deposit_ratio != ''){
				//事务处理
				$transaction=Yii::$app->db->beginTransaction();
				try{
					Yii::$app->db->createCommand()->insert('v_c_voyage', [
						'voyage_code'=>$voyage_code,
						'cruise_code'=>$cruise_code,
						'start_time'=>$s_time,
						'end_time'=>$e_time,
						'status'=>1,
						'area_code'=>$area_code,
						'pdf_path'=>$pdf_path,
						'start_book_time'=>$s_book_time,
						'stop_book_time'=>$e_book_time,
						'ticket_price'=>$ticket_price,
						'ticket_taxes'=>$ticket_taxes,
						'harbour_taxes'=>$harbour_taxes,
						'deposit_ratio'=>$deposit_ratio,
					])->execute();
					
					$last_active_id = Yii::$app->db->getLastInsertID();
					
					Yii::$app->db->createCommand()->insert('v_c_voyage_i18n', [
						'voyage_code'=>$voyage_code,
						'voyage_name'=>$voyage_name,
						'voyage_desc'=>$desc,
						'i18n'=>'en',
					])->execute();

					$transaction->commit();
					Helper::show_message('Save success  ', Url::toRoute(['voyageedit'])."&voyage_id=".$last_active_id);
					
				}catch(Exception $e){
					$transaction->rollBack();
					Helper::show_message('Save failed  ',Url::toRoute(['voyageadd']));
				}
			}else{
				Helper::show_message('Save failed  ','#');
			}
		}

		$query  = new Query();
		$area = $query->select(['a.area_code','b.area_name'])
				->from('v_c_area a')
				->join('LEFT JOIN','v_c_area_i18n b','a.area_code=b.area_code')
				->where(['b.i18n'=>'en','a.status'=>'1'])
				->all();
		
		
		$query  = new Query();
		$cruise = $query->select(['a.cruise_code','b.cruise_name'])
				->from('v_cruise a')
				->join('LEFT JOIN','v_cruise_i18n b','a.cruise_code=b.cruise_code')
				->where(['b.i18n'=>'en','a.status'=>'1'])
				->all();

		return $this->render('voyage_add',['area'=>$area,'cruise'=>$cruise]);
	}
	
	
	public function actionVoyageedit()
	{
		if($_POST){
			$voyage_name = isset($_POST['voyage_name']) ? $_POST['voyage_name'] : '';
			$voyage_code = isset($_POST['voyage_code']) ? $_POST['voyage_code'] : '';
			$area_code = isset($_POST['area']) ? $_POST['area'] : '';
			$cruise_code = isset($_POST['cruise']) ? $_POST['cruise'] : '';
			$s_time = isset($_POST['s_time']) ? $_POST['s_time'] : '';
			$e_time = isset($_POST['e_time']) ? $_POST['e_time'] : '';
			$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
			$s_book_time = isset($_POST['s_book_time']) ? $_POST['s_book_time'] : '';
			$e_book_time = isset($_POST['e_book_time']) ? $_POST['e_book_time'] : '';
			$ticket_price = isset($_POST['ticket_price']) ? $_POST['ticket_price'] : 0;
			$ticket_taxes = isset($_POST['ticket_taxes']) ? $_POST['ticket_taxes'] : 0;
			$harbour_taxes = isset($_POST['harbour_taxes']) ? $_POST['harbour_taxes'] : 0;
			$deposit_ratio = isset($_POST['deposit_ratio']) ? $_POST['deposit_ratio'] : 0;
			$voyage_id = isset($_POST['voyage_id']) ? $_POST['voyage_id'] : '';
			
			
			if($s_time!=''){
				$s_time = Helper::GetCreateTime($s_time);
			}
			if($e_time!=''){
				$e_time = Helper::GetCreateTime($e_time);
			}
			if($s_book_time!=''){
				$s_book_time = Helper::GetCreateTime($s_book_time);
			}
			if($e_book_time!=''){
				$e_book_time = Helper::GetCreateTime($e_book_time);
			}
			
			
			$pdf_path = VCVoyage::find()->where(['id'=>$voyage_id])->one()['pdf_path'];
			
			
			$allowsize = 3*1024*1024;
			if(isset($_FILES['pdf'])){
				if($_FILES['pdf']['error'] != 1){
					if($_FILES['pdf']['error'] != 4){
						if($_FILES['pdf']['type'] == 'application/pdf'){
							$result=Helper::upload_file('pdf', Yii::$app->params['img_save_url'].'voyagemanagement/themes/basic/static/upload/'.date('Ym',time()), 'pdf', 3);
							$pdf_path=date('Ym',time()).'/'.$result['filename'];
						}else {
							Helper::show_message('Wrong Format','#');
							die;
						}
					}
				}else{
					Helper::show_message('You have uploaded file size is more than the size of the server configuration');
					die;
				}
			}
			
			
			if($voyage_name != '' && $voyage_code != '' && $ticket_price != '' && $ticket_taxes != '' && $harbour_taxes != '' && $deposit_ratio != '' ){
				//事务
				$transaction=Yii::$app->db->beginTransaction();
				try{
					$vcvoyage_obj = VCVoyage::findOne(['id'=>$voyage_id]);
					$vcvoyage_obj->cruise_code = $cruise_code;
					$vcvoyage_obj->start_time = $s_time;
					$vcvoyage_obj->end_time = $e_time;
					$vcvoyage_obj->area_code = $area_code;
					$vcvoyage_obj->pdf_path = $pdf_path;
					$vcvoyage_obj->start_book_time = $s_book_time;
					$vcvoyage_obj->stop_book_time = $e_book_time;
					$vcvoyage_obj->ticket_price = $ticket_price;
					$vcvoyage_obj->ticket_taxes = $ticket_taxes;
					$vcvoyage_obj->harbour_taxes = $harbour_taxes;
					$vcvoyage_obj->deposit_ratio = $deposit_ratio;
					$vcvoyage_obj->save();
					
					$vcvoyagei18n_obj = VCVoyageI18n::findOne(['voyage_code'=>$voyage_code]);
					$vcvoyagei18n_obj->voyage_name = $voyage_name;
					$vcvoyagei18n_obj->voyage_desc = $desc;
					$vcvoyagei18n_obj->save();
				
					$transaction->commit();
					Helper::show_message('Save success', Url::toRoute(['voyageedit'])."&voyage_id=".$voyage_id);
				}catch(Exception $e){
					$transaction->rollBack();
					Helper::show_message('Save failed',Url::toRoute(['voyageedit'])."&voyage_id=".$voyage_id);
				}
			}else{
				Helper::show_message('Save failed',Url::toRoute(['voyageedit'])."&voyage_id=".$voyage_id);
			}
		}
		

		
		$voyage_id = isset($_GET['voyage_id'])?$_GET['voyage_id'] : '';
		
		$query  = new Query();
		$voyage = $query->select(['a.*','b.voyage_name','b.voyage_desc'])
				->from('v_c_voyage a')
				->join('LEFT JOIN','v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
				->where(['a.id'=>$voyage_id,'b.i18n'=>'en','a.status'=>'1'])
				->one();
		
		
		$query  = new Query();
		$area = $query->select(['a.area_code','b.area_name'])
				->from('v_c_area a')
				->join('LEFT JOIN','v_c_area_i18n b','a.area_code=b.area_code')
				->where(['b.i18n'=>'en','a.status'=>'1'])
				->all();
		

		$query  = new Query();
		$cruise = $query->select(['a.cruise_code','b.cruise_name'])
				->from('v_cruise a')
				->join('LEFT JOIN','v_cruise_i18n b','a.cruise_code=b.cruise_code')
				->where(['b.i18n'=>'en','a.status'=>'1'])
				->all();
		
		$count = VCVoyagePort::find()->where(['voyage_id'=>$voyage_id])->count();
		
		return $this->render('voyage_edit',['voyage'=>$voyage,'area'=>$area,'cruise'=>$cruise,'voyage_port_page'=>1,'count'=>$count]);
	}
	
	
	
	//voyage port ajax 
	public function actionGetvoyageportajax()
	{
		$voyage_id = isset($_GET['voyage_id'])?$_GET['voyage_id'] : '';
		
		$query  = new Query();
		$voyage_port = $query->select(['*'])
				->from('v_c_voyage_port')
				->where(['voyage_id'=>$voyage_id])
				->limit(2)
				->all();
		
		$query  = new Query();
		$port = $query->select(['a.port_code','b.port_name'])
				->from('v_c_port a')
				->join('LEFT JOIN','v_c_port_i18n b','a.port_code=b.port_code')
				->where(['b.i18n'=>'en','a.status'=>'1'])
				->all();
		
		foreach($port as $port_row){
			foreach ($voyage_port as $key => $value ) {
				if($port_row['port_code'] === $value['port_code']) {
					$voyage_port[$key]['port_name'] = $port_row['port_name'];
				}
			}
		}
		$count = VCVoyagePort::find()->where(['voyage_id'=>$voyage_id])->count();
		
		$port = array();
		$port['count'] = $count;
		$port['result'] = $voyage_port;
		
		if($port){
			echo json_encode($port);
		}else{
			echo 0;
		}
		
	}
	
	//active ajax
	public function actionGetactiveajax()
	{
		$voyage_id = isset($_GET['voyage_id'])?$_GET['voyage_id'] : '';
		
		$query  = new Query();
				$active_result = $query->select(['a.active_id','b.name'])
				->from('v_c_active a')
				->join('LEFT JOIN','v_c_active_i18n b','a.active_id=b.active_id')
				->where(['a.status'=>1,'b.i18n'=>'en'])
				->all();
		
		
		$query  = new Query();
		$curr_active_result = $query->select(['a.id','c.name'])
				->from('v_c_voyage_active a')
				->leftJoin('v_c_active b','a.curr_active_id=b.active_id')
				->leftJoin('v_c_active_i18n c','b.active_id=c.active_id')
				->where(['b.status'=>1,'c.i18n'=>'en','a.voyage_id'=>$voyage_id])
				->limit(1)
				->one();
		
		$arr = [];
		$arr['active'] = $active_result;
		$arr['curr_active'] = $curr_active_result;
		if($arr){
			echo json_encode($arr);
		}else{
			echo 0;
		}
		
	}
	
	//map ajax
	public function actionGetvoyagemapajax()
	{
		$voyage_id = isset($_GET['voyage_id'])?$_GET['voyage_id'] : '';
		
		$query  = new Query();
		$map_result = $query->select(['*'])
				->from('v_c_voyage_map a')
				->join('LEFT JOIN','v_c_voyage_map_i18n b','a.id=b.map_id')
				->where(['a.voyage_id'=>$voyage_id])
				->limit(1)
				->one();
		
		
		$arr = [];
		$arr['map_result'] = $map_result;
		if($arr){
			echo json_encode($arr);
		}else{
			echo 0;
		}
	}
	
	//cabin ajax
	public function actionGetcabinajax()
	{
		
		$voyage_id = isset($_GET['voyage_id'])?$_GET['voyage_id'] : '';
		$query  = new Query();
		$cabin_type_result = $query->select(['a.id','b.type_name'])
				->from('v_c_cabin_type a')
				->join('LEFT JOIN','v_c_cabin_type_i18n b','a.type_code=b.type_code')
				->where(['b.i18n'=>'en','a.type_status'=>'1'])
				->all();
		
		$query  = new Query();
		$cabin_result = $query->select(['id','cabin_name','max_check_in','last_aduits_num'])
				->from('v_c_cabin_lib')
				->where(['status'=>1,'cabin_type_id'=>$cabin_type_result[0]['id'],'deck_num'=>1])
				->all();
		
		$query  = new Query();
		$really_cabin_result = $query->select(['cabin_lib_id','cabin_name','max_check_in','last_aduits_num'])
				->from('v_c_voyage_cabin')
				->where(['deck_num'=>1,'cabin_type_id'=>$cabin_type_result[0]['id'],'voyage_id'=>$voyage_id])
				->all();
		
		$cruise_code = Yii::$app->params['cruise_code'];
		
		
		$query  = new Query();
		$cruise_result = $query->select(['deck_number'])
				->from('v_cruise')
				->where(['cruise_code'=>$cruise_code])
				->one();
		
		$arr =  [];
		$arr['cabin_result'] = $cabin_result;
		$arr['cabin_type_result'] = $cabin_type_result;
		$arr['really_cabin_result'] = $really_cabin_result;
		$arr['cruise_result'] = $cruise_result;
		if($arr){
			echo json_encode($arr);
		}else{
			echo 0;
		}
	}
	
	
	//return ajax
	public function actionGetreturnrouteajax()
	{
		$voyage_id = isset($_GET['voyage_id'])?$_GET['voyage_id'] : '';
		
		$query  = new Query();
		$curr_return_voyage_result = $query->select(['a.id','c.voyage_name'])
				->from('v_c_return_voyage a')
				->leftJoin('v_c_voyage b','a.return_voyage_id=b.id')
				->leftJoin('v_c_voyage_i18n c','b.voyage_code=c.voyage_code')
				->where(['b.status'=>1,'c.i18n'=>'en','a.voyage_id'=>$voyage_id])
				->limit(1)
				->one();
		
		$query  = new Query();
		$voyage_return = $query->select(['a.id','b.voyage_name'])
				->from('v_c_voyage a')
				->leftJoin('v_c_voyage_i18n b','a.voyage_code=b.voyage_code')
				->where(['a.status'=>1,'b.i18n'=>'en'])
				->all();
		
		$arr = [];
		$arr['curr_return_voyage_result'] = $curr_return_voyage_result;
		$arr['voyage_return'] = $voyage_return;
		
		if($arr){
			echo json_encode($arr);
		}else{
			echo 0;
		}
	}
	

	//港口分页
	public function actionGetvoyageportpage()
	{
		$pag = isset($_GET['pag']) ? $_GET['pag']==1 ? 0 :($_GET['pag']-1) * 2 : 0;
		$voyage_id = isset($_GET['voyage_id']) ?$_GET['voyage_id'] :'';
		
		
		$query  = new Query();
		$result = $query->select(['*'])
				->from('v_c_voyage_port')
				->where(['voyage_id'=>$voyage_id])
				->offset($pag)
				->limit(2)
				->all();
		
		
		$query  = new Query();
		$port = $query->select(['a.port_code','b.port_name'])
				->from('v_c_port a')
				->leftJoin('v_c_port_i18n b','a.port_code=b.port_code')
				->where(['a.status'=>1,'b.i18n'=>'en'])
				->all();
		
		
		
		foreach($port as $port_row){
			foreach ($result as $key => $value ) {
				if($port_row['port_code'] === $value['port_code']) {
					$result[$key]['port_name'] = $port_row['port_name'];
				}
			}
		}
		
	

		if($result){
			echo json_encode($result);
		}else{
			echo 0;
		}
	}

	//港口删除
	public function actionVoyageeditdelete()
	{
		//单项删除
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$voyage_id = $_GET['voyage_id'];
			VCVoyagePort::deleteAll(['id'=>$id]);
			Helper::show_message('Delete successful', Url::toRoute(['voyageedit'])."&voyage_id=".$voyage_id);
		}
		
		//选中删除
		if(isset($_POST['ids'])){
			$ids = implode(',', $_POST['ids']);
			$voyage_id = $_POST['voyage_id'];
			VCVoyagePort::deleteAll("id in ($ids)");
			Helper::show_message('Delete successful ', Url::toRoute(['voyageedit'])."&voyage_id=".$voyage_id);
		}
	}

	
	//港口添加
	public function actionVoyageportadd()
	{
		$voyage_id = isset($_GET['voyage_id']) ? $_GET['voyage_id'] : '';
		$voyage = VCVoyage::find()->where(['id'=>$voyage_id])->one();
		
		if($_POST){
			$order_no = isset($_POST['order_no']) ? $_POST['order_no'] : '';
			$port_code = isset($_POST['port_code']) ? $_POST['port_code'] : '';
			$ETA = isset($_POST['s_time']) ? $_POST['s_time'] : '';
			$ETD = isset($_POST['e_time']) ? $_POST['e_time'] : '';
			$voyage_id_post = isset($_POST['voyage_id']) ? $_POST['voyage_id'] : '';
			
			if($ETA!=''){
				$ETA = Helper::GetCreateTime($ETA);
			}
			if($ETD!=''){
				$ETD = Helper::GetCreateTime($ETD);
			}
 
			if($order_no != '' && $port_code != '' ){
				$count = VCVoyagePort::find()->where(['order_no'=>$order_no,'voyage_id'=>$voyage_id_post])->count();
				if($count <= 0){
					$vcvoyageport_obj = new VCVoyagePort();
					$vcvoyageport_obj->voyage_id = $voyage_id_post;
					$vcvoyageport_obj->port_code = $port_code;
					$vcvoyageport_obj->order_no = $order_no;
					if($ETD != ''){
						$vcvoyageport_obj->ETD = $ETD;
					}else{
						$vcvoyageport_obj->ETD = null;
					}
					if($ETA != ''){
						$vcvoyageport_obj->ETA = $ETA;
					}else{
						$vcvoyageport_obj->ETA = null;
					}
					$vcvoyageport_obj->save();
					
					Helper::show_message('Save success  ', Url::toRoute(['voyageedit'])."&voyage_id=".$voyage_id_post);
				}else{
					Helper::show_message('Save failed , Num '.$order_no .' Exists ', Url::toRoute(['voyageedit'])."&voyage_id=".$voyage_id_post);
				}
			}
		}
		
		$query  = new Query();
		$port = $query->select(['a.port_code','b.port_name'])
				->from('v_c_port a')
				->join('LEFT JOIN','v_c_port_i18n b','a.port_code=b.port_code')
				->where(['a.status'=>1,'b.i18n'=>'en'])
				->all();

		return $this->render('voyage_port_add',['port'=>$port,'voyage'=>$voyage]);
	}

	
	//港口编辑
	public function actionVoyageportedit()
	{
		$voyage_id = isset($_GET['voyage_id']) ? $_GET['voyage_id'] : '';
		$voyage = VCVoyage::find()->where(['id'=>$voyage_id])->one();

		$port_id = isset($_GET['port_id']) ? $_GET['port_id'] : '';
		$voyage_port = VCVoyagePort::find()->where(['voyage_id'=>$voyage_id,'id'=>$port_id])->one();
		
		
		if($_POST){
			$order_no = isset($_POST['order_no']) ? $_POST['order_no'] : '';
			$port_code = isset($_POST['port_code']) ? $_POST['port_code'] : '';
			$ETA = isset($_POST['s_time']) ? $_POST['s_time'] : '';
			$ETD = isset($_POST['e_time']) ? $_POST['e_time'] : '';
			$voyage_id_post = isset($_POST['voyage_id']) ? $_POST['voyage_id'] : '';
			$port_id = isset($_POST['port_id']) ? $_POST['port_id'] : '';
			
			if($ETA!=''){
				$ETA = Helper::GetCreateTime($ETA);
			}
			if($ETD!=''){
				$ETD = Helper::GetCreateTime($ETD);
			}
			
			
			
			if($order_no != '' && $port_code != '' ){
				$exist = VCVoyagePort::find()->where(['order_no'=>$order_no,'voyage_id'=>$voyage_id_post])->andWhere(['!=','id',$port_id])->one();
				
				if(!$exist){
					$vcvoyageport_obj = VCVoyagePort::findOne(['voyage_id'=>$voyage_id_post,'id'=>$port_id]);
					$vcvoyageport_obj->order_no = $order_no;
					$vcvoyageport_obj->port_code = $port_code;
					if($ETD !=''){
						$vcvoyageport_obj->ETD = $ETD;
					}else{
						$vcvoyageport_obj->ETD = null;
					}
					if($ETA != ''){
						$vcvoyageport_obj->ETA = $ETA;
					}else{
						$vcvoyageport_obj->ETA = null;
					}
					$vcvoyageport_obj->save();
					Helper::show_message('Save success  ', Url::toRoute(['voyageedit'])."&voyage_id=".$voyage_id_post."&port_id=".$port_id);
				}else{
					Helper::show_message('Save failed , Num '.$order_no .' Exists ', Url::toRoute(['voyageedit'])."&voyage_id=".$voyage_id_post."&port_id=".$port_id);
				}
			}
		}

		$query  = new Query();
		$port = $query->select(['a.port_code','b.port_name'])
				->from('v_c_port a')
				->join('LEFT JOIN','v_c_port_i18n b','a.port_code=b.port_code')
				->where(['a.status'=>1,'b.i18n'=>'en'])
				->all();

		return $this->render('voyage_port_edit',['port'=>$port,'voyage'=>$voyage,'voyage_port'=>$voyage_port]);
	}
	
	

	//航线-》船舱保存
	public function actionVoyagecabinsave(){
		$db = Yii::$app->db;
		if($_POST){
			$cabin_type_id = isset($_POST['cabin_type_id'])?$_POST['cabin_type_id']:'0';
			$cabin_deck = isset($_POST['cabin_deck'])?$_POST['cabin_deck']:'0';
			$voyage_id = isset($_POST['cabin_voyage_id'])?$_POST['cabin_voyage_id']:'0';
			$c_id = isset($_POST['c_id'])?$_POST['c_id']:'';
			$c_name = isset($_POST['c_name'])?$_POST['c_name']:'';
			$c_max= isset($_POST['c_max'])?$_POST['c_max']:'';
			$c_last = isset($_POST['c_last'])?$_POST['c_last']:'';
			$data = '';
			foreach ($c_id as $k=>$v){
				if($v!=''){
					$data .= "(".$voyage_id.",".$cabin_type_id.",".$cabin_deck.",".$v.",".$c_name[$k].",".$c_max[$k].",".$c_last[$k]."),";
				}
			}
			$data = trim($data,',');
			//事务处理
			$transaction=$db->beginTransaction();
			try{
					
				VCVoyageCabin::deleteAll(['voyage_id'=>$voyage_id,'cabin_type_id'=>$cabin_type_id,'deck_num'=>$cabin_deck]);
					
				$sql = "INSERT INTO `v_c_voyage_cabin` (voyage_id,cabin_type_id,deck_num,cabin_lib_id,cabin_name,max_check_in,last_aduits_num) VALUES ".$data;
				Yii::$app->db->createCommand($sql)->execute();
					
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['voyageedit','voyage_id'=>$voyage_id]));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
			
		}
	}
	
	
	
	//航线-》船舱改变类型
	public function actionVoyagecabinchangetypegetcabinlib(){
		$type_id = isset($_GET['type_id'])?$_GET['type_id']:'';
		$deck = isset($_GET['deck'])?$_GET['deck']:'';
		
		$query  = new Query();
		$cabin_result = $query->select(['id','cabin_name','max_check_in','last_aduits_num'])
				->from('v_c_cabin_lib')
				->where(['status'=>1,'cabin_type_id'=>$type_id,'deck_num'=>$deck])
				->all();
		
		$query  = new Query();
		$really_cabin_result = $query->select(['cabin_lib_id','cabin_name','max_check_in','last_aduits_num'])
				->from('v_c_voyage_cabin')
				->where(['cabin_status'=>1,'cabin_type_id'=>$type_id,'deck_num'=>$deck])
				->all();
		
		$result_arr = array();
		$result_arr['cabin_lib'] = $cabin_result;
		$result_arr['really'] = $really_cabin_result;
		if($result_arr){
			echo json_encode($result_arr);
		}else{
			echo 0;
		}
	}
	
	
	//航线-》航线图上传
	public function actionVoyagemap(){
		$db = Yii::$app->db;
		if($_POST){
			
			//var_dump($_POST);exit;
			$map_id = isset($_POST['map_id'])?$_POST['map_id']:'';
			$voyage_map_id = isset($_POST['voyage_map_id'])?$_POST['voyage_map_id']:'0';
				
			$photo = '';
			$photo_data = '';
			if($_FILES['photoimg']['error']!=4){
				$result=Helper::upload_file('photoimg', Yii::$app->params['img_save_url'].'voyagemanagement/themes/basic/static/upload/'.date('Ym',time()), 'image', 3);
				$photo_data=$result['filename'];
			}
			$photo=date('Ym',time()).'/'.$photo_data;
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				if($map_id!=''){
					if($photo_data!=''){
						
						$sql = "UPDATE `v_c_voyage_map_i18n` set map_img='$photo' WHERE map_id='{$map_id}'";
						Yii::$app->db->createCommand($sql)->execute();
					}
				}else{
					$sql = "insert into `v_c_voyage_map` (voyage_id) values ('$voyage_map_id')";
					Yii::$app->db->createCommand($sql)->execute();
					$last_id = Yii::$app->db->getLastInsertID();
					$sql = "insert into `v_c_voyage_map_i18n` (map_id,map_img,i18n) values ($last_id,'$photo','en')";
					Yii::$app->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['voyageedit','voyage_id'=>$voyage_map_id]));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
	}
	
	
	public function actionVoyageactive(){
		$db = Yii::$app->db;
	
		if($_GET){
			$voyage_active_id = isset($_GET['voyage_active_id'])?$_GET['voyage_active_id']:'0';
			$voyage_active = isset($_GET['voyage_active'])?$_GET['voyage_active']:'';
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$sql = "DELETE FROM `v_c_voyage_active` WHERE voyage_id=".$voyage_active_id;
				Yii::$app->db->createCommand($sql)->execute();
				$sql = "INSERT INTO `v_c_voyage_active` (voyage_id,curr_active_id) values ('$voyage_active_id','$voyage_active')";
				Yii::$app->db->createCommand($sql)->execute();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['voyageedit','voyage_id'=>$voyage_active_id]));
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
	}
	
	public function actionReturnvoyage(){
		$db = Yii::$app->db;
	
		if($_GET){
			$return_voyage_id = isset($_GET['return_voyage_id'])?$_GET['return_voyage_id']:'0';
			$return_voyage = isset($_GET['return_voyage'])?$_GET['return_voyage']:'';
			//事务处理
			$transaction=$db->beginTransaction();
			try{
				$sql = "DELETE FROM `v_c_return_voyage` WHERE voyage_id=".$return_voyage_id;
				Yii::$app->db->createCommand($sql)->execute();
				$sql = "INSERT INTO `v_c_return_voyage` (voyage_id,return_voyage_id) values ('$return_voyage_id','$return_voyage')";
				Yii::$app->db->createCommand($sql)->execute();
				$transaction->commit();
				Helper::show_message('Save success  ', Url::toRoute(['voyageedit','voyage_id'=>$return_voyage_id]));
				
			}catch(Exception $e){
				$transaction->rollBack();
				Helper::show_message('Save failed  ','#');
			}
		}
	}
	
	//voyage_set voyage_code验证
	public function actionVoyagesetcodecheck(){
		$code = isset($_GET['code'])?$_GET['code']:'';
		$act = isset($_GET['act'])?$_GET['act']:2;
		$id = isset($_GET['id'])?$_GET['id']:'';
		if($act == 1){
			//edit
			$sql = "SELECT count(*) count FROM `v_c_voyage` WHERE voyage_code='$code' AND id!=$id";
			$result = Yii::$app->db->createCommand($sql)->queryOne();
			$count = $result['count'];
		}else{
			//add
			$count = VCVoyage::find()->where(['voyage_code' => $code])->count();
		}
		if($count==0){
			echo 0;
		}else{
			echo 1;
		}
	}
	

}