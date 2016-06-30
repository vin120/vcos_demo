<?php
$this->title = 'Voyage Management';


use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetUpload;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetUeditor;

ThemeAsset::register($this);
ThemeAssetUpload::register($this);
ThemeAssetUeditor::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
$baseUrl_upload = $this->assetBundles[ThemeAssetUpload::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<style>
	.write label span.btn_img{width:95px;}
	.write label span.btn_img > span{width:90px;}
	#desc { display: inline-block; width: 50%; vertical-align: top; }
</style>
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['cabintype']);?>"><?php echo yii::t('app','Cabin Type')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Graphic_edit')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class="write">

		<?php
			$form = ActiveForm::begin([
					'action' => ['cabintypegraphicedit','id'=>$graphic_result['id']],
					'method'=>'post',
					'id'=>'cabin_type_graphic_val',
					'options' => ['class' => 'cabin_type_graphic_edit','enctype'=>'multipart/form-data'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
		
		
		
		<div class="check_save_div">
		<input type="hidden" id="id" name="id" value="<?php echo $graphic_result['id']?>" />
		<p style="min-height: 90px;">
				<label>
					<span class='max_l'><?php echo yii::t('app','Describe')?>:</span>
					<textarea id='desc' name='desc'><?php echo $graphic_result['graphic_desc']?></textarea>
				</label>
				<span class='tips'></span>
			</p>
			<p style="min-height:130px; ">
				<label>
					<span class='max_l' style="float: left;"><?php echo yii::t('app','Images')?>:</span>
					<span style="width:120px;height:120px;float:left;margin-left:5px;">
					<img id="ImgPr" width="120" height="120" src="<?php echo $baseUrl.'upload/'.$graphic_result['graphic_img'] ?>"/>
					</span>
					<span id="up_btn" class="btn_img" style="position:relative;left:5px;display:block">
						<span><?php echo yii::t('app','choose image')?></span>
						<input id="photoimg" type="file" name="photoimg">
					</span>
				 </label>
				<span class='tips'></span>
			</p>
		</div>
		<div class="btn">
			<input type="submit" value="<?php echo yii::t('app','SAVE')?>"></input>
			
		</div>
		<?php 
		ActiveForm::end(); 
		?>

	</div>
        
    </div>
</div>
<!-- content end -->

<script>
window.onload = function(){
	UE.getEditor('desc');
	$("#photoimg").uploadPreview({ Img: "ImgPr", Width: 120, Height: 120 });
}
</script>
