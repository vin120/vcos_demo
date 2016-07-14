<?php
$this->title = 'Order Management';

use app\modules\ordermanagement\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<!-- content start -->
<div class="r content">
	<div class="topNav"><?php echo yii::t('app','Order Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Free Order')?></a></div>
	<div class="search">
		<p>
			<label>
				<span><?php echo yii::t('app','Order Num')?> :</span>
				<input type="text" id="order_num" name="order_num"></input>
			</label>
			
			<label>
				<span><?php echo yii::t('app','Status')?>:</span>
				<select id="status" name="status">
					<option value="-1"><?php echo yii::t('app','All')?></option>
					<option value="0"><?php echo yii::t('app','To Be Paid')?></option>
					<option value="1"><?php echo yii::t('app','Paid')?></option>
				</select>
			</label>
		</p>
		<p>
			<label>
				<span><?php echo yii::t('app','Agent Name')?>:</span>
				<input type="text" id="agent_name" name="agent_name"></input>
			</label>
			<label>
				<span><?php echo yii::t('app','Voyage Code')?>:</span>
				<input type="text" id="voyage_code" name="voyage_code"></input>
			</label>
			<span class="btn"><input type="button" id="search" value="SEARCH"></input></span>
		</p>
	</div>
	<div class="searchResult">
		<table>
			<thead>
				<tr>
					<th><?php echo yii::t('app','Num')?></th>
					<th><?php echo yii::t('app','Order Serial Number')?></th>
					<th><?php echo yii::t('app','Voyage Code')?></th>
					<th><?php echo yii::t('app','Agent Name')?></th>
					<th><?php echo yii::t('app','Price')?></th>
					<th><?php echo yii::t('app','Status')?></th>
					<th><?php echo yii::t('app','Operate')?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($order as $key => $value):?>
				<tr>
					<td><?php echo $key+1;?></td>
					<td><?php echo $value['order_serial_number']?></td>
					<td><?php echo $value['voyage_code']?></td>
					<td><?php echo $value['travel_agent_name']?></td>
					<td><?php echo $value['total_pay_price']?></td>
					<td><?php echo $value['pay_status']==0 ? yii::t('app','To Be Paid') : yii::t('app','Paid')?></td>
					<td>
						<a href="<?php echo Url::toRoute(['order/free_order_detail'])?>&order_serial_number=<?php echo $value['order_serial_number']?>"><img src="<?=$baseUrl ?>images/write.png" class="btn1"></a>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		<p class="records">Records:<span>26</span></p>
	</div>
</div>
<!-- content end -->
<script type="text/javascript">
window.onload = function(){
	$("#search").click(function(){
		var order_num=$("input[name=order_num]").val();
		var status=$("select[name=status]").val();
		var agent_name=$("input[name=agent_name]").val();
		var voyage_code=$("input[name=voyage_code]").val();
		
		$.ajax({
			 url:"<?php echo Url::toRoute(['get_order_page']);?>",
             type:'post',
             data:{order_num:order_num,status:status,agent_name:agent_name,voyage_code:voyage_code,},
          	 dataType:'json',
          	 success:function(response){
              	 if(response != 0){
	            	
				}
        	}  
		});
	});
}
</script>



