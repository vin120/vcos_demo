<?php
namespace app\modules\orgmanagement\themes\basic\myasset;

use yii\web\AssetBundle;

class ThemeAssetOrgWrite extends AssetBundle
{

	public $sourcePath = '@app/modules/orgmanagement/themes/basic/static';
	public $css = [
		
	];

	public $js = [
		'js/organization_write.js',
	];
	
	public $depends = [
// 			'backend\views\myasset\PublicAsset'
			'app\modules\orgmanagement\themes\basic\myasset\ThemeAsset',
	];
}