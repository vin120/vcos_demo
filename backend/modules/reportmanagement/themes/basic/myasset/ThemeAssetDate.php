<?php
namespace app\modules\reportmanagement\themes\basic\myasset;

use yii\web\AssetBundle;

class ThemeAssetDate extends AssetBundle
{

	public $sourcePath = '@app/modules/reportmanagement/themes/basic/static';
	public $css = [
		
	];

	public $js = [
		'js/My97DatePicker/WdatePicker.js'
	];
	
	public $depends = [
// 			'backend\views\myasset\PublicAsset'
			'app\modules\reportmanagement\themes\basic\myasset\ThemeAsset',
	];
}