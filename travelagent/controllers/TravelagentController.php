<?php
namespace travelagent\controllers;

use Yii;
use yii\web\Controller;

class TravelagentController  extends BaseController
{
	public $enableCsrfValidation = false;
	public $layout = 'myloyout';
	public function actionAgentinfo()
	{
	
		$travel_agent_id=Yii::$app->user->identity->id;
		$sql="select * from v_travel_agent where travel_agent_id='$travel_agent_id'";
		$data= Yii::$app->db->createCommand($sql)->queryOne();
		return $this->render("agentinfo",array('data'=>$data));
	}
	public function actionCheckpassword()
	{//密码查询
	
		$travel_agent_id=Yii::$app->user->identity->id;
		$password=isset($_POST['pay_password'])?$_POST['pay_password']:'';
		$sql="select pay_password from v_travel_agent where travel_agent_id='$travel_agent_id' and pay_password='$password'";
		$data= Yii::$app->db->createCommand($sql)->queryAll();
		if (!empty($data)){
			echo json_encode(array(0=>1));
		
		}
		else{
			echo json_encode(array(0=>0));
			
		}
		
	}
	public function actionSubmitpaypassword(){//支付密码修改
	$travel_agent_id=Yii::$app->user->identity->id;
	$newpay_password=isset($_POST['newpay_password'])?$_POST['newpay_password']:'';
	$sql="update v_travel_agent set pay_password='$newpay_password' where travel_agent_id='$travel_agent_id'";
	$transaction =\Yii::$app->db->beginTransaction();
	try {
		$command= \Yii::$app->db->createCommand($sql)->execute();
		$transaction->commit();
		echo json_encode(array(0=>1));
		//return $this->redirect("travel_agent?massage=success");
	} catch(Exception $e) {
		$transaction->rollBack();
		echo json_encode(array(0=>0));
		//return $this->redirect("travel_agent?massage=fail");
	}
	
	}
	public function actionSubmitloginpassword(){//登陆密码修改
		$travel_agent_id=Yii::$app->user->identity->id;
		$newlogin_password=isset($_POST['newlogin_password'])?$_POST['newlogin_password']:'';
		$sql="update v_travel_agent set travel_agent_password='$newlogin_password' where travel_agent_id='$travel_agent_id'";
		$transaction =\Yii::$app->db->beginTransaction();
		try {
			$command= \Yii::$app->db->createCommand($sql)->execute();
			$transaction->commit();
			echo json_encode(array(0=>1));
			//return $this->redirect("travel_agent?massage=success");
		} catch(Exception $e) {
			$transaction->rollBack();
			echo json_encode(array(0=>0));
			//return $this->redirect("travel_agent?massage=fail");
		}
	}
	public function actionCheckloginpassword()
	{//登陆密码查询
	$travel_agent_id=Yii::$app->user->identity->id;
	$password=isset($_POST['login_password'])?$_POST['login_password']:'';
	$sql="select travel_agent_password from v_travel_agent where travel_agent_id='$travel_agent_id' and travel_agent_password='$password'";
	$data= Yii::$app->db->createCommand($sql)->queryAll();
	if (!empty($data)){
		echo json_encode(array(0=>1));
	
	}
	else{
		echo json_encode(array(0=>0));
			
	}
	
	}
}