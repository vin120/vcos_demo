<?php

namespace travelagent\components;

use Yii;
use yii\web\Controller;
//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

class Helper extends Controller
{
	//return 2015-12-14 
	public static function GetCreateTime($time){//时间格式转换
		$year = explode('/', $time);
		$date = $year[2].'-'.$year[1].'-'.$year[0];
		
		return $date;
	}
	
	//return 09/05/2016
	public static function GetDate($time){
		$year = explode('-', $time);
		$date = $year[2].'/'.$year[1].'/'.$year[0];
		return $date;
	}
	

	//return 2015-12-14 12:23:34
	public static function GetNewTime($time){//时间格式转换
		$time = explode(' ', $time);
		$year = explode('/', $time[0]);
		$date = $year[2].'-'.$year[1].'-'.$year[0].' '.$time[1];
	
		return $date;
	}
	
	//return 09/05/2016 12:23:13
	public static function GeNewtDate($time){
		$time = explode(' ', $time);
		$year = explode('-', $time[0]);
		$date = $year[2].'/'.$year[1].'/'.$year[0].' '.$time[1];
		return $date;
	}
	
	public static function createOrderno()
	{
		$my_code = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		 
		$order_sn = $my_code[intval(date('m'))].(intval(date('d')) < 10 ? intval(date('d')) : $my_code[(intval(date('d'))-10)]).date('Y')
		.substr(time(),-5).substr(microtime(),2,5)
		.sprintf('%02d', rand(0, 99));
		 
		return $order_sn;
	}
	
	//return age
	public static function Getage($birthday){
		$age = strtotime($birthday);
		if($age === false){
			return false;
		}
		list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age));
		$now = strtotime("now");
		list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now));
		$age = $y2 - $y1;
		if((int)($m2.$d2) < (int)($m1.$d1))
			$age -= 1;
			return $age;
	
	}
		
	
}