<?php
$this->title = 'Voyage Management';


use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetUeditor;
ThemeAsset::register($this);
ThemeAssetUeditor::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>


<style>
	#desc { display: inline-block; width: 50%; vertical-align: top; }
</style>
<script type="text/javascript">
var shore_excursion_ajax_url = "<?php echo Url::toRoute(['shoreexcursioncodecheck']);?>";
</script>
<script type="text/javascript" src="<?php echo $baseUrl;?>js/My97DatePicker/WdatePicker.js"></script>
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['shoreexcursion']);?>"><?php echo yii::t('app','Shore Excursion')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Shore_excursion_edit')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class="write">

		<?php
			$form = ActiveForm::begin([
				'action' => ['shoreexcursionedit','code'=>$shore_excursion_result['se_code']],
				'method'=>'post',
				'id'=>'shore_excursion_val',
				'options' => ['class' => 'shore_excursion_edit'],
				'enableClientValidation'=>false,
				'enableClientScript'=>false
			]); 
		?>
		
		<div class="check_save_div">
			<input type="hidden" id="id" name="id" value="<?php echo $shore_excursion_result['id']?>" />
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Tour Code')?>:</span>
					<input type="text" maxlength="16" id='code' name='code' value="<?php echo $shore_excursion_result['se_code']?>"></input>
					
				</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Tour Name')?>:</span>
					<input type="text" maxlength="16" id="name" name="name" value="<?php echo $shore_excursion_result['se_name']?>"></input>
				</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Price')?>:</span>
					<input type="text" maxlength="10" id="price" name="price" onkeyup="value=value.replace(/[^\d.]/g,'')" onafterpaste="value=value.replace(/[^\d.]/g,'')" value="<?php echo $shore_excursion_result['price']?>"></input>
					
				</label>
			</p>
			
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Date')?>:</span>
					<?php $date =  isset($shore_excursion_result['date'])?$shore_excursion_result['date']:'';
						if(isset($shore_excursion_result['date'])){
							$date = explode(' ', $date);
							$year = $date[0];
							$year = explode('-', $year);
							$date = $year[2].'/'.$year[1].'/'.$year[0].' '.$date[1];
						}
					?>
					<input type="text" name="date_of_entry" value="<?php echo $date;?>" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss ',lang:'en'})" class="Wdate" id="date_of_entry"></input>
					
				</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Status')?>:</span>
					<select name="state" id="state" class='input_select'>
						<option value='1' <?php echo $shore_excursion_result['status']==1?"selected='selected'":'';?>><?php echo yii::t('app','Avaliable')?></option>
						<option value='0' <?php echo $shore_excursion_result['status']==0?"selected='selected'":'';?>><?php echo yii::t('app','Unavaliable')?></option>
					</select>
				</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Describe')?>:</span>
					<textarea id="desc" name="desc"><?php echo $shore_excursion_result['se_info']?></textarea>
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

<script type="text/javascript">
window.onload = function(){ 
	UE.getEditor('desc');

}
</script>
