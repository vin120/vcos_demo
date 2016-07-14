<?php
$this->title = 'Voyage Management';


use app\modules\voyagemanagement\themes\basic\myasset\ThemeAsset;
use app\modules\voyagemanagement\themes\basic\myasset\ThemeAssetDate;
ThemeAsset::register($this);
ThemeAssetDate::register($this);
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\voyagemanagement\components\Helper;

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<style type="text/css">
	.write p { overflow: hidden; }
	.write label { width: 324px; }
	.write label:first-child { float: left; margin-left: 10%; }
	.write label + label { margin-right: -170px; }
	.write label span { width: 140px; }
	.shortLabel { margin-right: 84px; }
</style>

<!-- content start -->
<div class="r content">
<div class="topNav"><?php echo yii::t('app','Voyage Manage')?>&nbsp;&gt;&gt;&nbsp;
    <a href="<?php echo Url::toRoute(['index']);?>"><?php echo yii::t('app','Voyage Set')?></a>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Voyage_set_port_add')?></a></div>
	<div class="write">
	<?php
		$form = ActiveForm::begin([
			'action' => ['voyageportedit'],
			'method'=>'post',
			'id'=>'voyage_port_edit',
			'options' => ['class' => 'voyage_port_edit'],
			'enableClientValidation'=>false,
			'enableClientScript'=>false
		]);
	?>
	<input type="hidden" id="voyage_id" name="voyage_id" value="<?php echo $voyage['id'];?>"></input>
	<input type="hidden" id="port_id" name="port_id" value="<?php echo $voyage_port['id']?>"></input>
		<div>
			<p>
				<label class="shortLabel">
					<span><?php echo yii::t('app','Num')?>:</span>
					<select id="order_no" name="order_no" class='input_select'>
						<?php for($i=1;$i<=100;$i++){ ?>
                       		<option value="<?php echo $i;?>" <?php if($voyage_port['order_no'] == $i){echo "selected='selected'";} ?> ><?php echo $i?></option>
                        <?php } ?>
					</select>
				</label>
			</p>
			<p>
				<label class="shortLabel">
					<span><?php echo yii::t('app','Port')?>:</span>
					<select id="port_code" name="port_code" class='input_select'>
						<?php foreach($port as $row){?>
						<option id="<?php echo $row['port_code']?>" value="<?php echo $row['port_code'] ?>" <?php if($voyage_port['port_code'] === $row['port_code']){echo "selected='selected'";}?> ><?php echo $row['port_name'] ;?> </option>
						<?php } ?>
					</select>
				</label>
				<label>
					<input type="checkbox" id="terminal" name="terminal" ><?php echo yii::t('app','Terminal')?></input> 
				</label>
			</p>
			<p>
				<label>
					<span><?php echo yii::t('app','Arrival Time')?>:</span>
					<input type="text" id="s_time" name="s_time" placeholder="<?php echo yii::t('app','please choose')?>"  value="<?php echo empty($voyage_port['ETA'])?"":Helper::GetDate($voyage_port['ETA']);?>" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss ',lang:'en',maxDate:'#F{$dp.$D(\'e_time\')}'})" class="Wdate"></input>
				</label>
			</p>
			<p>
				<label>
					<span><?php echo yii::t('app','Departure Time')?>:</span>
					<input type="text" id="e_time" name="e_time" placeholder="<?php echo yii::t('app','please choose')?>"  value="<?php echo empty($voyage_port['ETD'])?"":Helper::GetDate($voyage_port['ETD']);?>" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss ',lang:'en',minDate:'#F{$dp.$D(\'s_time\')}',startDate:'#F{$dp.$D(\'s_time\',{d:+1})}'})" class="Wdate"></input>
				</label>
			</p>
		</div>
		<div class="btn">
			<input type="submit" value="<?php echo yii::t('app','SAVE')?>"></input>
			<input type="button" value="<?php echo yii::t('app','CANCLE')?>"></input>
		</div>
		<?php 
			ActiveForm::end(); 
		?>
	</div>
</div>
<!-- content end -->


<script type="text/javascript">
window.onload = function(){
	var order_no = $("#order_no").val();
	if(order_no == 1){
		$("#terminal").attr("disabled",'disabled');
		$("#s_time").attr("disabled",'disabled');
		$("#e_time").removeAttr('disabled');
		$("#e_time").val('<?php echo date('d/m/Y H:i:s',time())?>');
	}else{
		$("#terminal").removeAttr('disabled');
		$("#s_time").removeAttr('disabled');
	}
	
	$("#order_no").on('change',function(){
		order_no = $(this).val();
		if(order_no == 1){
			$("#terminal").removeAttr('checked');
			$("#terminal").attr("disabled",'disabled');
			$("#s_time").attr("disabled",'disabled');
			$("#s_time").val('');
			$("#e_time").removeAttr('disabled');
			$("#e_time").val('<?php echo date('d/m/Y H:i:s',time())?>');
		}else{
			$("#terminal").removeAttr('disabled');
			$("#s_time").removeAttr('disabled');
			$("#s_time").val('<?php echo date('d/m/Y H:i:s',time())?>');
		}
	});
	
	$("input#terminal").on('click',function(){
		if($(this).is(":checked")){
			$("#e_time").attr("disabled",'disabled');
			$("#s_time").removeAttr('disabled');
			$("#e_time").val('');
		}else{
			$("#e_time").removeAttr('disabled');
			$("#e_time").val('<?php echo date('d/m/Y H:i:s',time())?>');
		}
	});
	
	var e_time = $('#e_time').val();
	if(e_time ==''){
		$("#terminal").attr("checked",'checked');
		$("#e_time").attr("disabled",'disabled');
	}
}
</script>