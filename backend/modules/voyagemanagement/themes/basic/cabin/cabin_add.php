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
	.check_save_div .cabin_label span.point {margin-left:-258px;margin-top:30px; }
</style>
<script type="text/javascript">
var check_cabin_name_ajax_url = "<?php echo Url::toRoute(['checkcabinname']);?>";
var check_cabin_deck_ajax_url = "<?php echo Url::toRoute(['checkcabindeck']);?>";
</script>

<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['cabin']);?>"><?php echo yii::t('app','Cabin')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Cabin_add')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class=" write">

		<?php
			$form = ActiveForm::begin([
					'action' => ['cabinadd'],
					'method'=>'post',
					'id'=>'cabin_val',
					'options' => ['class' => 'cabin_add'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
		
		
				<div class='check_save_div'>
					<p>
						<label>
							<span class='max_l'><?php echo yii::t('app','Cabin Type')?>:</span>
							<select class="input_select" name="cabin_type_id" id="cabin_type_id">
							<?php foreach ($type_result as $k=>$val){?>
							<option value="<?php echo $val['id']?>"><?php echo $val['type_name']?></option>
							<?php }?>
							</select>
							
						</label>
					</p>
					<p>
						<label>
							<span class='max_l'><?php echo yii::t('app','Deck Num')?>:</span>
							<input type="text" maxlength="2" id="deck" maxlength="9" name="deck" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')"></input>
							
						</label>
					</p>
				<!-- 	
					<p>
						<label>
							<span class='max_l'><//?php //echo yii::t('app','Max Check In')?>:</span>
							<input type="text" id="max" maxlength="1" name="max" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')"></input>
							
						</label>
					</p>
					<p>
						<label>
							<span class='max_l'><//?php //echo yii::t('app','Ieast Aduits Num')?>:</span>
							<input type="text" id="min" maxlength="1" name="min" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')"></input>
							
						</label>
					</p>-->
					<p>
						<label class="cabin_label">
							<span class='max_l'><?php echo yii::t('app','Cabin Name')?>:</span>
							
							<textarea type="text" id="name" name="name"></textarea>
							<span style="color:red;text-align:left;width:95px;"><?php echo yii::t('app','For example')?>：</span>
							<span style="color:red;text-align:left;">2001,2002,2003,</span>
						</label>
					</p>
					<p>
					<label>
							<span class='max_l'><?php echo yii::t('app','Status')?>:</span>
							<select name="state" id="state" class='input_select'>
								<option value='1'><?php echo yii::t('app','Avaliable')?></option>
								<option value='0'><?php echo yii::t('app','Unavaliable')?></option>
							</select>
						</label>
						
					</p>
			</div>
		<div class="btn">
			<input type="submit" style="cursor:pointer" value="<?php echo yii::t('app','SAVE')?>"></input>
		</div>
		<?php 
		ActiveForm::end(); 
		?>

	</div>
        
    </div>
</div>
<!-- content end -->

