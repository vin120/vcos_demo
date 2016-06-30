<?php
namespace app\modules\voyagemanagement\themes\basic\myasset;

use yii\web\AssetBundle;

class ThemeAssetUeditor extends AssetBundle
{

	public $sourcePath = '@app/modules/voyagemanagement/themes/basic/static';
	public $css = [
		
	];

	public $js = [
		'js/ueditor/ueditor.config.js',
		'js/ueditor/ueditor.all.js',
		
			
	];
	
	public $depends = [
// 			'backend\views\myasset\PublicAsset'
			'app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset',
	];
}