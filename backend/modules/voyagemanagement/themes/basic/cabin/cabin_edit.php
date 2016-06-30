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
var check_cabin_name_ajax_url = "<?php echo Url::toRoute(['checkcabinname']);?>";
var check_cabin_deck_ajax_url = "<?php echo Url::toRoute(['checkcabindeck']);?>";
</script>

<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['cabin']);?>"><?php echo yii::t('app','Cabin')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Cabin_edit')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class="write">

		<?php
			$form = ActiveForm::begin([
					'action' => ['cabinedit','id'=>$cabin_result['id']],
					'method'=>'post',
					'id'=>'cabin_val',
					'options' => ['class' => 'cabin_edit'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
		<div class='check_save_div'>
		<input type="hidden" name="cabin_id" value="<?php echo $cabin_result['id']?>" id="cabin_id" />
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
					<input type="text" maxlength="2" name="deck" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')" id="deck" name="deck" value="<?php echo $cabin_result['deck_num']?>"></input>
					
				</label>
			</p>
		<!-- 
			<p>
				<label>
					<span class='max_l'><//?php echo yii::t('app','Max Check In')?>:</span>
					<input type="text" maxlength="1" name="deck" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')" id="max" name="max" value="<//?php echo $cabin_result['max_check_in']?>"></input>
					
				</label>
			</p>
			<p>
				<label>
					<span class='max_l'><//?php echo yii::t('app','Ieast Aduits Num')?>:</span>
					<input type="text" maxlength="1" name="deck" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')" id="min" name="min" value="<//?php echo $cabin_result['last_aduits_num']?>"></input>
					
				</label>
			</p> -->	
			<p>
				<label>
					<span class='max_l'><?php echo yii::t('app','Cabin Name')?>:</span>
					
					<input type="text"  id="name" name="name" value="<?php echo $cabin_result['cabin_name'] ?>"/>
				</label>
			</p>
			<p>
			<label>
					<span class='max_l'><?php echo yii::t('app','Status')?>:</span>
					<select name="state" id="state" class='input_select'>
						<option value='1' <?php echo  $cabin_result['status']==1?"selected='seletcted'":'';?>><?php echo yii::t('app','Avaliable')?></option>
						<option value='0' <?php echo  $cabin_result['status']==0?"selected='seletcted'":'';?>><?php echo yii::t('app','Unavaliable')?></option>
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


