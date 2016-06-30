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
var get_surcharge_data_ajax_url = "<?php echo Url::toRoute(['getsurchargedata']);?>";
</script>

<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['cabinpricing']);?>"><?php echo yii::t('app','Cabin Pricing')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Surcharge_add')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class=" write">

		<?php
			$form = ActiveForm::begin([
					'action' => ['surchargeadd'],
					'method'=>'post',
					'id'=>'surcharge_val',
					'options' => ['class' => 'surcharge_add'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
		
		
				<div id="surcharge_add_voyage">
					<p>
						<label>
							<span class='max_l'><?php echo yii::t('app','Route No.')?>:</span>
							<select id="vayage" name="voyage" class="input_select">
							<?php foreach ($voyage_result as $k=>$v){?>
								<option value="<?php echo $v['voyage_code']?>"><?php echo $v['voyage_name']?></option>
							<?php }?>
							</select>
							
						</label>
						<span class='tips'></span>
					</p>
					<?php 
						$really_arr = array();
						foreach ($really_result as $k=>$v){
							$really_arr[$k] = $v['cost_id'];
 						}?>
					<p>
						<label>
							<span class='max_l' style="height:30px;position: absolute;"><?php echo yii::t('app','Surcharge')?>:</span>
							<span id="surcharge_data_list" style="max-height: 500px;position: relative;left:200px;">
							<?php foreach ($surcharge_result as $k=>$v){?>
							<?php if(!in_array($v['id'], $really_arr)){?>
							<span style="display: block;height:30px;text-align:left;width:200px;"><input style="margin-right:10px;" type="checkbox" name="su[]" value="<?php echo $v['id'];?>" /><?php echo $v['cost_name']?></span>
							<?php }}?>
							</span>
						</label>
					</p>
			</div>
		<div class="btn">
			<input type="submit" style="cursor:pointer" value="<?php echo yii::t('app','SAVE')?>"></input>
			<!-- <input class="cancle" type="button" value="<?php //echo yii::t('app','CANCLE')?>"></input> -->
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
	$("form#surcharge_val").submit(function(){
		var length = $("#surcharge_data_list input[type='checkbox']:checked").length;
		if(length==0){
			Alert("Uncheck surcharge");return false;
			}
	});
	
}
</script>