<?php
namespace app\modules\voyagemanagement\themes\basic\myasset;

use yii\web\AssetBundle;

class ThemeAssetDate extends AssetBundle
{

	public $sourcePath = '@app/modules/voyagemanagement/themes/basic/static';
	public $css = [
		
	];

	public $js = [
		'js/My97DatePicker/WdatePicker.js'
	];
	
	public $depends = [
// 			'backend\views\myasset\PublicAsset'
			'app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset',
	];
}