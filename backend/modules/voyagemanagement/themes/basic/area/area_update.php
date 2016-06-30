<?php
$this->title = 'Voyage Management';


use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<style type="text/css">
	.write label span { width: 160px; }
</style>
<script type="text/javascript">
var area_ajax_url = "<?php echo Url::toRoute(['areacodecheck']);?>";
</script>

<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['area']);?>"><?php echo yii::t('app','Area')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Area_add')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class=" write">

		<?php
			$form = ActiveForm::begin([
					'action' => ['areaupdate'],
					'method'=>'post',
					'id'=>'area_val',
					'options' => ['class' => 'area_update'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
					<input type="hidden" name="id" id="id" value="<?php echo empty($result)?'':$result['id'];?>" />
					<input type="hidden" name="old_code" id="old_code" value="<?php echo empty($result)?'':$result['area_code'];?>" />
				<div class="check_save_div">
					
					<p>
						<label>
							<span class='max_l'><?php echo yii::t('app','Area Code')?>:</span>
							<input type="text" maxlength="16" id="code" name="code" value="<?php echo empty($result)?'':$result['area_code'];?>"></input>
						</label>
					</p>
					<p>
						<label>
							<span class='max_l'><?php echo yii::t('app','Area Name')?>:</span>
							<input type="text" maxlength="16" id="name" name="name" value="<?php echo empty($result)?'':$result['area_name'];?>"></input>
						</label>
					</p>
					<p>
						<label>
							<span class='max_l'><?php echo yii::t('app','Status')?>:</span>
							<select name="state" id="state" class='input_select'>
								<option value='1' <?php echo empty($result)?'':($result['status']==1?"selected='selected'":'');?>><?php echo yii::t('app','Avaliable')?></option>
								<option value='0' <?php echo empty($result)?'':($result['status']==0?"selected='selected'":'');?>><?php echo yii::t('app','Unavaliable')?></option>
							</select>
						</label>
					</p>
					
				</div>
				<div class="btn">
					<input style="cursor:pointer" type="submit" value="<?php echo yii::t('app','SAVE')?>"></input>
					
				</div>
		<?php 
		ActiveForm::end(); 
		?>

	</div>
        
    </div>
</div>
<!-- content end -->

