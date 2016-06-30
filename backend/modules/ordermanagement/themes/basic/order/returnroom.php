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
<style>
	.returnroom_total {margin-top:70px;}
	.returnroom_total .left_span{width:100px;display:inline-block;text-align:right;}
	.returnroom_total textarea{vertical-align:top;width:300px;height:100px;resize:none;}
</style>
<!-- content start -->
<div class="r content">
	<div class="topNav"><?php echo yii::t('app','Order Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="<?php echo Url::toRoute(['order/free_order'])?>"><?php echo yii::t('app','Free Order')?></a>
	&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Free Order Detail')?></a>
	</div>
	<div class="search">
		<p>
			<label>
				<span><?php echo yii::t('app','Voyage Code')?> : <?php echo $order_result['voyage_code']?></span>
			</label>
			<label>
				<span><?php echo yii::t('app','Order Serial Number')?> : <?php echo $order_result['order_serial_number']?></span>
			</label>
			
		</p>
		<p>
			<label>
				<span><?php echo yii::t('app','Agent Code')?> : <?php echo '';?></span>
			</label>
			<label>
				<span><?php echo yii::t('app','Agent Name')?> : <?php echo $order_result['travel_agent_name']?></span>
			</label>
		</p>
	</div>
	<div class="searchResult">
	<table id="ticket_center_table">
				<thead>
					<tr>
						<th><?php echo yii::t('app','No.')?></th>
						<th><?php echo yii::t('app','Room Type')?></th>
						<th><?php echo yii::t('app','Room NO.')?></th>
						<th><?php echo yii::t('app','Room Price')?></th>
						<th><?php echo yii::t('app','Taxes Price')?></th>
						<th><?php echo yii::t('app','Port Expenses')?></th>
						<th><?php echo yii::t('app','Additional Price')?></th>
						<th><?php echo yii::t('app','Total Price')?></th>
						<th><?php echo yii::t('app','Return Price')?></th>
					</tr>
				</thead>
				<tbody>
				<?php $total_price = 0;?>
				<?php foreach ($data_arr as $k=>$v){
					$total_price += (float)$v['total_price'];?>
					<tr room_id="<?php echo $v['id']?>" cabin_type="<?php echo $v['type_code']?>">
						<td><?php echo ($k+1)?></td>
						<td><?php echo $v['type_name']?></td>
						<td><?php echo $v['cabin_name']?></td>
						<td><?php echo sprintf("%.2f",$v['cabin_price'])?></td>
						<td><?php echo sprintf("%.2f",$v['tax_price'])?></td>
						<td><?php echo sprintf("%.2f",$v['port_price'])?></td>
						<td><?php echo sprintf("%.2f",$v['add_price'])?></td>
						<td><?php echo sprintf("%.2f",$v['total_price'])?></td>
						<td><input onafterpaste="this.value=this.value.replace(/[^0-9.]/g,'')" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" type='text' value="<?php echo sprintf("%.2f",$v['total_price'])?>" /></td>
					</tr>
				<?php }?>
				</tbody>
			</table>
		<p></p>
		<div class="returnroom_total">
			<p>
				<label>
					<span class="left_span"><?php echo yii::t('app','Order Price')?>:</span>
					<span><?php echo sprintf("%.2f",$total_price);?></span>
				</label>
			</p>
			<p>
				<label>
					<span class="left_span"><?php echo yii::t('app','Return Price')?>:</span>
					<span><input type='text' id="total_price" disabled='disabled' value="<?php echo sprintf("%.2f",$total_price);?>"></span>
				</label>
			</p>
			<p>
				<label>
					<span class="left_span"><?php echo yii::t('app','Remark')?>:</span>
					<span><textarea name="desc"></textarea></span>
				</label>
			</p>
		
		</div>
		<p></p>
		<div class="btn">
			<input type="button" id="previous_but" value="PREVIOUS"></input>
			<input type="button" style="width:100px;" id="return_ticket" value="RETURN ROOM"></input>
		 </div>
	</div>
</div>
<!-- content end -->
<script>
	window.onload=function(){
		//改变文本框价格时，退款总价改变
		$("table#ticket_center_table tbody input[type='text']").blur(function (){
			var total_price = 0;
			var this_price = parseFloat($(this).val());
			if(this_price == ''){this_price = 0;}
			var old_price = parseFloat($(this).parent().prev().html());
			if(this_price > old_price){$(this).val(old_price.toFixed(2));alert("The refund amount is not greater than the total refund amount ");return false;}
			$("table#ticket_center_table tbody input[type='text']").each(function(){
				var price = $(this).val();
				if(price == ''){price = 0;$(this).val('0.00');}
				total_price += parseFloat(price);
			});

			$("input#total_price").val(total_price.toFixed(2));
			
		});

		$("#return_ticket").on('click',function(){
			var voyage_code = "<?php echo $order_result['voyage_code']?>";
			var order_num = "<?php echo $order_result['order_serial_number']?>";
			var desc = $("textarea[name='desc']").val();
			
			var cabin_type = '';
			var cabin_name = '';
			var return_room_price = '';
			$("table#ticket_center_table tbody tr").each(function(){
				cabin_type += $(this).attr('cabin_type')+',';
				cabin_name += $(this).find("td").eq(2).html()+',';
				return_room_price += $(this).find("input[type='text']").val()+',';
			});
			
			cabin_type = cabin_type.substring(0,cabin_type.length-1);
			cabin_name = cabin_name.substring(0,cabin_name.length-1);
			return_room_price = return_room_price.substring(0,return_room_price.length-1);
			//alert(room_ids);alert(return_room_price);return false;
			$.ajax({
		        url:"<?php echo Url::toRoute(['returnroom_save']);?>",
		        type:'post',
		        async:false,
		        data:'voyage_code='+voyage_code+'&order_num='+order_num+'&cabin_type='+cabin_type+'&cabin_name='+cabin_name+'&return_room_price='+return_room_price+'&desc='+desc,
		     	dataType:'json',
		    	success:function(data){
		    		if(data != 0){
						alert("Refund success ");
						location.href = "<?php echo Url::toRoute(['free_order'])?>";
		    		}else{
		    			alert("Refund failure  ");
			    	}
		        		
		    	}      
		    });

		});

		$("#previous_but").on('click',function(){
			location.href = "<?php echo Url::toRoute(['free_order_detail','order_serial_number'=>$order_result['order_serial_number']])?>";
		});
	}
</script>


