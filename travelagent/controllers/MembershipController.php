<?php
namespace travelagent\controllers;

use Yii;
use yii\web\Controller;

class MembershipController extends BaseController
{
	public $enableCsrfValidation = false;
	public $layout = 'myloyout';
	public function actionMemberinfo()
	{
	$full_name=isset($_POST['full_name'])?$_POST['full_name']:'';
	$passport_num=isset($_POST['passport_num'])?$_POST['passport_num']:'';
	$sql="select * from v_travelagent_membership where m_id>0";
	
	$datacount=\Yii::$app->db->createCommand($sql)->queryAll();
	$datacount=sizeof($datacount);
	$sql.=" limit 2";
	$data=\Yii::$app->db->createCommand($sql)->queryAll();
     return $this->render("memberinfo",array('data'=>$data,'datacount'=>$datacount));
	}
	public function actionGetmemberpage()//会员数据分页
	{   
		$pag = isset($_POST['pag'])?$_POST['pag']==1?0:($_POST['pag']-1)*2:0;
		$full_name=isset($_POST['full_name'])?$_POST['full_name']:'';
		$passport_num=isset($_POST['passport_num'])?$_POST['passport_num']:'';
		$sql = "select * from v_travelagent_membership where m_id>0";
		if ($full_name!=''){
			$sql.=" AND (full_name LIKE '%{$full_name}%')";
		}
		if ($passport_num!=''){
			$sql.=" AND (passport_num LIKE '%{$passport_num}%')";
		}
		$sql.=" order by m_id limit $pag,2";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}	
	}
	public function actionGetmemberserch()//会员数据查找
	{
		$pag = isset($_POST['pag'])?$_POST['pag']==1?0:($_POST['pag']-1)*2:0;
		$full_name=isset($_POST['full_name'])?$_POST['full_name']:'';
		$passport_num=isset($_POST['passport_num'])?$_POST['passport_num']:'';
		$sql = "select * from v_travelagent_membership where m_id>0";
		if ($full_name!=''){
			$sql.=" AND (full_name LIKE '%{$full_name}%')";
		}
		if ($passport_num!=''){
			$sql.=" AND (passport_num LIKE '%{$passport_num}%')";
		}
		$sql.=" order by m_id";
		$result = Yii::$app->db->createCommand($sql)->queryAll();
		if($result){
			echo json_encode($result);
		}  else {
			echo 0;
		}
	}

}