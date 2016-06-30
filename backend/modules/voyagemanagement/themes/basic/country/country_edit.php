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
	.write select.input_select{ width: 165px; height: 26px; }
</style>
<script type="text/javascript">
var ajax_url = "<?php echo Url::toRoute(['countrycodecheck']);?>";
</script>

<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['country']);?>"><?php echo yii::t('app','Country')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Country_edit')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class="write">

		<?php
			$form = ActiveForm::begin([
					'action' => ['countryedit','code'=>$country_result['country_code']],
					'method'=>'post',
					'id'=>'country_val',
					'options' => ['class' => 'country_edit'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
		
		
		
		<div  class="check_save_div">
		<input type="hidden" id="id" name="id" value="<?php echo $country_result['id']?>" />
			<p>
			<label>
				<span class='max_l'><?php echo yii::t('app','Country Name')?>:</span>
				<input type="text" maxlength="16" id="name" name="name" value="<?php echo $country_result['country_name']?>"></input>
			</label>
			</p>
			<p>
			<label>
				<span class='max_l'><?php echo yii::t('app','Area Name')?>:</span>
				<select class="input_select" id="area_code" name="area_code">
					<?php foreach ($area_result as $row){?>
					<option <?php echo $row['area_code']==$country_result['area_code']?"selected='selected'":''; ?> value="<?php echo $row['area_code']?>"><?php echo $row['area_name']?></option>
					<?php }?>
				</select>
			</label>
			</p>
			<p>
			<label>
				<span class='max_l'><?php echo yii::t('app','Status')?>:</span>
				<select name="state" id="state" class='input_select'>
					<option value='1' <?php echo $country_result['status']==1?"selected='selected'":'';?>><?php echo yii::t('app','Avaliable')?></option>
					<option value='0' <?php echo $country_result['status']==0?"selected='selected'":'';?>><?php echo yii::t('app','Unavaliable')?></option>
				</select>
			</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Code(2 characters)')?>:</span>
					<input type="text" maxlength="2" id='code' name='code' maxlength="2" value="<?php echo $country_result['country_code']?>"></input>
				</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Code(3 characters)')?>:</span>
					<input type="text" maxlength="3" id="code_chara" maxlength="3" name="code_chara" value="<?php echo $country_result['counry_short_code']?>"></input>
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

