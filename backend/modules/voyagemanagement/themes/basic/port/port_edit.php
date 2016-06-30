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
<script type="text/javascript">
var port_ajax_url = "<?php echo Url::toRoute(['portcodecheck']);?>";
</script>
<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['port']);?>"><?php echo yii::t('app','Port')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Port_edit')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class="write">

		<?php
			$form = ActiveForm::begin([
				'action' => ['portedit','code'=>$port_result['port_code']],
				'method'=>'post',
				'id'=>'port_val',
				'options' => ['class' => 'port_edit'],
				'enableClientValidation'=>false,
				'enableClientScript'=>false
			]); 
		?>
		
		<div class='check_save_div'>
			<input type="hidden" id="id" name="id" value="<?php echo $port_result['id']?>" />
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Port Code')?>:</span>
					<input type="text" maxlength="16" id='code' name='code' value="<?php echo $port_result['port_code']?>"></input>
					
				</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Port Code(2 character)')?>:</span>
					<input type="text" maxlength="2" id="code_chara" name="code_chara" value="<?php echo $port_result['port_short_code']?>"></input>
					
				</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Country Code')?>:</span>
					<select name="country_code" id="country_code" class='input_select'>
						<?php foreach ($country_result as $k=>$row){?>
						<option <?php if($port_result['country_code']==$row['country_code']){echo "selected='selected'";}?> value="<?php echo $row['country_code']?>"><?php echo $row['country_code']?></option>
						<?php }?>
					</select>
				</label>
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Port Name')?>:</span>
					<input type="text" id="name" maxlength="16" name="name" value="<?php echo $port_result['port_name']?>"></input>
					
				</label>
				
			</p>
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Status')?>:</span>
					<select name="state" id="state" class='input_select'>
						<option value='1' <?php echo $port_result['status']==1?"selected='selected'":'';?>><?php echo yii::t('app','Avaliable')?></option>
						<option value='0' <?php echo $port_result['status']==0?"selected='selected'":'';?>><?php echo yii::t('app','Unavaliable')?></option>
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
