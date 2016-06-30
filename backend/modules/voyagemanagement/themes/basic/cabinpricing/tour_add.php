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
var get_tour_data_ajax_url = "<?php echo Url::toRoute(['gettourdata']);?>";
</script>

<!-- content start -->
<div class="r content" id="user_content">
    <div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['cabinpricing']);?>"><?php echo yii::t('app','Cabin Pricing')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Tour_add')?></a></div>
    
    <div class="searchResult">
        
        <div id="service_write" class=" write">

		<?php
			$form = ActiveForm::begin([
					'action' => ['touradd'],
					'method'=>'post',
					'id'=>'tour_val',
					'options' => ['class' => 'tour_add'],
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]); 
		?>
		
		
				<div id="tour_add_voyage">
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
							$really_arr[$k] = $v['sh_id'];
 						}?>
					<p>
						<label>
							<span class='max_l' style="height:30px;position: absolute;"><?php echo yii::t('app','Tour')?>:</span>
							<span id="tour_data_list" style="max-height: 500px;position: relative;left:200px;">
							<?php foreach ($tour_result as $k=>$v){?>
							<?php if(!in_array($v['id'], $really_arr)){?>
							<span style="display: block;height:30px;text-align:left;width:200px;"><input style="margin-right:10px;" type="checkbox" name="tour[]" value="<?php echo $v['id'];?>" /><?php echo $v['se_name']?></span>
							<?php }}?>
							</span>
						</label>
					</p>
			</div>
		<div class="btn">
			<input type="submit" style="cursor:pointer" value="<?php echo yii::t('app','SAVE')?>"></input>
			<!-- <input class="cancle" type="button" value="<?php // echo yii::t('app','CANCLE')?>"></input> -->
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
	$("form#tour_val").submit(function(){
		var length = $("#tour_data_list input[type='checkbox']:checked").length;
		if(length==0){
			Alert("Uncheck tour");return false;
			}
	});
	
}
</script>
