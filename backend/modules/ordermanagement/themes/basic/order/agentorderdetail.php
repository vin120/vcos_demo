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
.returticket{
background-color: #3f7fcf;
}
</style>
<!-- content start -->
<div class="r content">
	<div class="topNav"><?php echo yii::t('app','Order Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Agent Order')?></a>
	&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Agent OrderDetail')?></a>
	</div>
	<div class="search">
		<p>
			<label>
				<span><?php echo yii::t('app','Voyage Code')?> : <?php echo $order['voyage_code']?></span>
			</label>
			<label>
				<span><?php echo yii::t('app','Order Serial Number')?> : <?php echo $order_serial_number?></span>
			</label>
			<label>
				<span><?php echo yii::t('app','Price')?> : <?php echo $order['total_pay_price']?></span>
			</label>
		</p>
		<p>
			<label>
				<span><?php echo yii::t('app','Agent Name')?> : <?php echo $order['travel_agent_name']?></span>
			</label>
		</p>
	</div>
	<div class="searchResult">
	<table id="ticket_center_table">
				<thead>
					<tr>
						<th><input type=checkbox id="mycheck"></input></th>
						<th><?php echo yii::t('app','No.')?></th>
						<th><?php echo yii::t('app','Room Type')?></th>
						<th><?php echo yii::t('app','Room NO.')?></th>
						<th><?php echo yii::t('app','Room Price')?></th>
						<th><?php echo yii::t('app','Status')?></th>
						<th><?php echo yii::t('app','Name')?></th>
						<th><?php echo yii::t('app','PassportNum')?></th>
						<th><?php echo yii::t('app','Additional Price')?></th>
						<th><?php echo yii::t('app','Option')?></th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($data)){?>
				<?php foreach($data as $k=>$v):?>
				<?php if (!empty($v['member'][$k])){?>
				<?php foreach($v['member'][$k] as $num=>$vv):?>
				<?php if($vv != null&& $vv['price_type']!=1){?>
					<tr>
					<?php if($num==0){?>
						<td rowspan="<?php echo sizeof($v['member'][$k])?>"><input type="checkbox" state="<?php echo $v['status']?>"  name="ids[]" value="<?php echo $v['id']?>" class="checkall"></input></td>
						<td rowspan="<?php  echo sizeof($v['member'][$k])?>"><?php echo $k+1?></td>
						<td rowspan="<?php echo sizeof($v['member'][$k])?>"><?php echo $v['cabin_type_code']?></td>
						<td rowspan="<?php echo sizeof($v['member'][$k])?>"><?php echo $v['cabin_name']?></td>
						<td rowspan="<?php echo sizeof($v['member'][$k])?>"><?php echo $v['cabin_price']?></td>
						<td rowspan="<?php echo sizeof($v['member'][$k])?>">
						<?php if($v['status']==0){
							echo yii::t('app',"normal");
						}
						elseif ($v['status']==1){
							echo yii::t('app',"cancel");
						}
						elseif ($v['status']==2){
							echo yii::t('app',"In the processing");
						}
						elseif ($v['status']==3){
							echo yii::t('app',"complete");
						}
						?>
						</td>
						<?php }?>
						
						<td><?php echo $vv['m_name']?></td>
						<td><?php echo $vv['passport_number']?></td>
						<td><?php echo isset($vv['additional_price'])?$vv['additional_price']:0?></td>
						<?php if($num==0){?>
						<td  rowspan="<?php echo sizeof($v['member'][$k])?>"><div class="btn"><input  type="button" onclick="seainfo('<?php echo (isset($_GET['order_serial_number'])?$_GET['order_serial_number']:'').','.$v['cabin_price'].','.$v['tax_price'].','.$v['voyage_code'].','.$v['cabin_type_code'].','.$v['cabin_name']?>');" value="edit"></div></td>
						<?php }?>
					</tr>
					<?php }?>
					<?php endforeach;?>
					<?php }?>
				<?php endforeach;?>
				<?php }?>
				</tbody>
			</table>
		<p></p>
		<div class="btn">
			<input type="button" value=打印申请></input>
			<input type="button" id="returnroom" value="退票"></input>
			<input type="button" value="销票"></input>
			<input type="button" value="打印发票"></input>
		</div>
	</div>
</div>
<!-- content end -->
<script>
   function seainfo(info){
	   var info=info.split(",");
	   location.href="<?php echo Url::toRoute(['cabindetail']);?>&order_serial_number="+info[0]+"&cabin_price="+info[1]+"&tax_price="+info[2]+"&voyage_code="+info[3]+"&cabin_type_code="+info[4]+"&cabin_name="+info[5]+"&surcharge="+"<?php echo empty($v['member'][$k])?0:$surcharge?>"+"&quayage="+"<?php echo empty($v['member'][$k])?0:$quayage?>";
	   }
	window.onload=function(){
		/* 退票按钮 */
		$("table").find("input[type='checkbox']").change(function(){
		
			var a = 1;
			var t=1;
			var val_ids = '';
			var length = $("table#ticket_center_table tbody").find("input[type='checkbox']:checked").length;
			if(length==0){t=0;}
			$("table#ticket_center_table tbody").find("input[type='checkbox']:checked").each(function(){
				
					var state = $(this).attr('state');
					if(state != 2){t=0;$("#returnroom").removeClass("returticket");}
					val_ids += $(this).val()+',';
			});
			if(t==1){
				$("#returnroom").addClass("returticket");
				}
			else{
				$("#returnroom").removeClass("returticket");
				}
			});
		//退票
		$("#returnroom").on('click',function(){
			//判断是是否存在选中
			var a = 1;
			var val_ids = '';
			var length = $("table#ticket_center_table tbody").find("input[type='checkbox']:checked").length;
			if(length==0){alert("Uncheck to refund of the room ");return false;}

			$("table#ticket_center_table tbody").find("input[type='checkbox']:checked").each(function(){
				
					var state = $(this).attr('state');
					if(state != 2){alert("Please select a item you can apply for a refund");a=0;return false;}
					val_ids += $(this).val()+',';
			});
			if(a==0){return false;}
			val_ids = val_ids.substring(0,val_ids.length-1);
			location.href="<?php echo Url::toRoute(['returnroom','order_serial_number'=>$order_serial_number]);?>&ids="+val_ids;
		});
	
		$('#mycheck').click(function(){/* 多选按钮  */
			   if($(this).prop('checked')==true)
	         {
	             $(".checkall").prop("checked",true);
	         }
	         else {
	             $(".checkall").prop("checked",false);
	         }
	  
			});
	
		$("#refund").click(function(){
			var value=[];
			$("#ticket_center_table tbody input").each(function(index,element) {
					if($(this).prop("checked")) {
						value.push($(this).val());
						}
				}); 
			
		          $.ajax({  
		              url:"<?php echo Url::toRoute(['returnticket']);?>",
		              data:{value:value},
		              type: 'POST',  
		              dataType: 'json',  
		              timeout: 3000,  
		              cache: false,  
		              beforeSend: LoadFunction, //加载执行方法      
		              error: erryFunction,  //错误执行方法      
		              success: succFunction //成功执行方法      
		          })  
		          function LoadFunction() {  
		              $("#list").html('加载中...');  
		          }  
		          function erryFunction() {  
		              alert("error");  
		          }  
		          function succFunction(tt) {  
				         if(tt==0){
							alert("Option fail");
							location.href="<?php echo Url::toRoute(['returningticket']);?>";
					         }
				         else if(tt==1){
							alert("Option success");
							location.href="<?php echo Url::toRoute(['returningticket']);?>";
					         }
				         else if(tt==2){
							alert("Please Choose...");
					         }
		                
		          } 
			});
		}
</script>


