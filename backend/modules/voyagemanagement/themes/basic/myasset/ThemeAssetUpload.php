<?php
namespace app\modules\voyagemanagement\themes\basic\myasset;

use yii\web\AssetBundle;

class ThemeAssetUpload extends AssetBundle
{

	public $sourcePath = '@app/modules/voyagemanagement/themes/basic/static';
	public $css = [
			//'css/jedate.css'
	];

	public $js = [
			'js/uploadPreview.js'
	];
	
	public $depends = [
// 			'backend\views\myasset\PublicAsset'
			'app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset',
	];
}