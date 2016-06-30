<?php

namespace app\modules\voyagemanagement\controllers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\voyagemanagement\components\Helper;
use app\modules\voyagemanagement\models\seletedata;
use app\modules\voyagemanagement\models\VCSurcharge;
use app\modules\voyagemanagement\models\VCSurchargeI18n;
use app\modules\voyagemanagement\models\VCCabinCategory;
class CabincategoryController extends Controller
{
	public $enableCsrfValidation = false;
	public function actionCabincategory(){
		/* 船舱大类 */
		$db=\Yii::$app->db;
		/* 删除 */
		$code=isset($_GET['code'])?$_GET['code']:'';
		if ($code!=''){
			$transaction =\Yii::$app->db->beginTransaction();
			try {
				$command = \Yii::$app->db->createCommand("delete from v_c_cabin_big_class where id=$code")->execute();
				$command2 = \Yii::$app->db->createCommand("delete from v_c_cabin_big_class_i18n where class_id=$code")->execute();
				$transaction->commit();
				Helper::show_message(yii::t('app', "Option success"),Url::toRoute(["cabincategory"]));
				//return $this->redirect("travel_agent?massage=success");
			} catch(Exception $e) {
				$transaction->rollBack();
				Helper::show_message(yii::t('app', "Option fail"),Url::toRoute(["cabincategory"]));
				//return $this->redirect("travel_agent?massage=fail");
				exit;
			}
		}
		$sql="select *,c.id from v_c_cabin_big_class c join v_c_cabin_big_class_i18n ci on ci.class_id=c.id where i18n='en'";
		$class_name=isset($_POST['class_name'])?$_POST['class_name']:'';
		if ($_POST&&$class_name!=''){
		$sql .= " AND (ci.class_name LIKE '%{$class_name}%')";
		}
		$selectdata=new seletedata();
		$data=$selectdata->paging($sql, $sql);
		$data['class_name']=$class_name;
		/*船舱归类  */
		$classsql="select * from v_c_cabin_big_class_i18n where i18n='en'";
		$typesql="select *,ct.id from (v_c_cabin_type_i18n cti left join v_c_cabin_type ct on ct.type_code=cti.type_code left join v_c_cabin_category cc on cc.cabin_type_id=ct.id) left join v_c_cabin_big_class_i18n cbi on cbi.class_id=cc.class_id where  cti.i18n='en'";
		$classify_name=isset($_POST['classify_name'])?$_POST['classify_name']:'';
		$t=isset($_POST['t'])?$_POST['t']:'';
		if ($t==1){
			if ($classify_name!=''){
				$typesql .= " AND (cti.type_name LIKE '%{$classify_name}%')";
			}
		}
		$typesql.="  order by cti.id ";
		$typedata = \Yii::$app->db->createCommand($typesql)->queryAll();
		$classinfo = \Yii::$app->db->createCommand($classsql)->queryAll();
		$data['typedata']=$typedata;
		$data['classinfo']=$classinfo;
		if ($t==1){
		$data['t']=$t;
		$data['classify_name']=$classify_name;
		}
		
		return $this->render("cabin_category",$data);
	}
	public function actionCabincategoryoption(){
		$db=\Yii::$app->db;
		if ($_POST){
			$class_id=isset($_POST['class_id'])?$_POST['class_id']:'';
			$price=$_POST['price'];//v_c_cabin_big_class数据
			$price=sprintf("%.2f", $price);
			$status=$_POST['status'];
			$class_name=$_POST['class_name'];//v_c_cabin_big_class_i18n数据
			$i18n='en';
			$transaction=$db->beginTransaction();
            try{
            	if ($class_id==''){//没有id就插入数据
            	$cbsql="insert into v_c_cabin_big_class(price,status) values('$price',$status)";
            	$cb= \Yii::$app->db->createCommand($cbsql)->execute();
	            $class_id=$db->getLastInsertID();
                $cisql="insert into v_c_cabin_big_class_i18n(class_id,class_name,i18n) values('$class_id','$class_name','$i18n')";
                $ci= \Yii::$app->db->createCommand($cisql)->execute();
            	}
            	else {//有id就更新数据
                $cbupdatesql="update v_c_cabin_big_class set price='$price',status=$status where id=$class_id";
                $ciupdatesql="update v_c_cabin_big_class_i18n set class_name='$class_name',i18n='$i18n' where class_id=$class_id";
                $cbupdate= \Yii::$app->db->createCommand($cbupdatesql)->execute();
                $ciupdate= \Yii::$app->db->createCommand($ciupdatesql)->execute();
            	}
                $transaction->commit();
	    		Helper::show_message(yii::t('app', 'Option success  '), Url::toRoute(['cabincategory']));
            }catch(Exception $e){
                $transaction->rollBack();
                Helper::show_message(yii::t('app', 'Option failed  '),Url::toRoute(['cabincategory']));
            }
			}
			$c_id=isset($_GET['class_id'])?$_GET['class_id']:'';
			$data=array();
			if ($c_id!=''){
			$sqldata="select * from v_c_cabin_big_class_i18n ci join v_c_cabin_big_class cb on ci.class_id=cb.id where cb.id=$c_id";
			$data= \Yii::$app->db->createCommand($sqldata)->queryAll();
			}
		return $this->render("cabincategory_option",array('data'=>$data));
	}
	public function actionTypeclass(){//船舱归类ajax查询
		$type_name=isset($_POST['name'])?$_POST['name']:'';
		$sqldata="select *,ct.id from (v_c_cabin_type_i18n cti left join v_c_cabin_type ct on ct.type_code=cti.type_code left join v_c_cabin_category cc on cc.cabin_type_id=ct.id) left join v_c_cabin_big_class_i18n cbi on cbi.class_id=cc.class_id where  cti.i18n='en'";
		if ($type_name!=''){
			$sqldata .= " AND (cti.type_name LIKE '%{$type_name}%')";
		}
		$data= \Yii::$app->db->createCommand($sqldata)->queryAll();
		echo json_encode($data);
	}
	public function actionSettypeclass(){//船舱归类设置分类
		$class_id=isset($_POST['class_id'])?$_POST['class_id']:'';
		$classval=isset($_POST['checkbox'])?$_POST['checkbox']:'';
		
		if ($classval==''){
			Helper::show_message(yii::t('app', "Please Select..."),Url::toRoute(['cabincategory','t'=>1]));
			exit;
		}
		// $classval=substr($classval,0,strlen($classval)-1);
		//$classarray=explode("/",$classval);
	for ($i=0;$i<sizeof($classval);$i++){
	    	$cid=$classval[$i];
	    	$sql="select * from v_c_cabin_category where cabin_type_id=$cid";
	    	$mydata= \Yii::$app->db->createCommand($sql)->queryAll();
	   	if (sizeof($mydata)>0){
	    	  $sqlupdate="update v_c_cabin_category set class_id=$class_id where cabin_type_id=$cid";
	    	}
	    	else{
	    	$sqlupdate="insert into v_c_cabin_category(cabin_type_id,class_id) values($cid,$class_id)";
	    	}
	    	$transaction=\Yii::$app->db->beginTransaction();
	    	try{
	    	$insertorupdate= \Yii::$app->db->createCommand($sqlupdate)->execute();
	    	$transaction->commit();
	    	Helper::show_message(yii::t('app', "Option Success"),Url::toRoute(['cabincategory','t'=>1]));
	    	}catch(Exception $e){
	    		$transaction->rollBack();
	    		Helper::show_message(yii::t('app', "Option Fail"),Url::toRoute(['cabincategory','t'=>1]));
	    	}
	    }   
		/* $sqldata="select * from (v_c_cabin_type_i18n cti left join v_c_cabin_type ct on ct.type_code=cti.type_code left join v_c_cabin_category cc on cc.cabin_type_id=ct.id) left join v_c_cabin_big_class_i18n cbi on cbi.class_id=cc.class_id where  cti.i18n='en'";
		$data= \Yii::$app->db->createCommand($sqldata)->queryAll();
		echo json_encode($data);  */
	}
	public function actionGetcabinclasspage(){
		$typeclass_name=isset($_POST['typeclass_name'])?$_POST['typeclass_name']:'';
		$pag =isset($_POST['num'])?$_POST['num']==1?0:($_POST['num']-1)*7:0;
		$sqldata="select *,ct.id from (v_c_cabin_type_i18n cti left join v_c_cabin_type ct on ct.type_code=cti.type_code left join v_c_cabin_category cc on cc.cabin_type_id=ct.id) left join v_c_cabin_big_class_i18n cbi on cbi.class_id=cc.class_id where  cti.i18n='en'";
		if ($typeclass_name!=''){
			$sqldata .= " AND (cti.type_name LIKE '%{$typeclass_name}%')";
		}
		$sqldata.=" order by cti.id limit $pag,7";
		$result = Yii::$app->db->createCommand($sqldata)->queryAll();
		
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}
	
}