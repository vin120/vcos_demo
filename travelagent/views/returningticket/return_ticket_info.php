<?php
$this->title = 'Agent Ticketing';
use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';
?>
<!-- main content start -->
<div id="retuenTicketInfo" class="mainContent">
    <div id="topNav">
	    <?php echo yii::t('app','Agent Ticketing')?>&nbsp;&gt;&gt;&nbsp;
	    <a href="#"><?php echo yii::t('app','Ticket Center')?></a>
    </div>
    <div id="mainContent_contentinfo" class="pBox">
		<!-- 请用ajax提交 -->
		<div class="pBox infoBox">
			<h2><?php echo \Yii::t('app','The Order Information')?>:</h2>
			<p>
				<span><?php echo date('Y-m-d D', time());?></span>
				<span class="r"><?php echo \Yii::t('app','Order Number')?>:<?php echo isset($_GET['id'])?$_GET['id']:''?></span>
			</p>
			<table id="ticket_center_table">
				<thead>
					<tr>
						<th><input type=checkbox id="mycheck"></input></th>
						<th><?php echo yii::t('app','No.')?></th>
						<th><?php echo yii::t('app','Room Code')?></th>
						<th><?php echo yii::t('app','Room Price')?></th>
						<th><?php echo yii::t('app','Status')?></th>
						<th><?php echo yii::t('app','Name')?></th>
						<th><?php echo yii::t('app','PassportNum')?></th>
						<th><?php echo yii::t('app','Additional Price')?></th>
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
						<td rowspan="<?php echo sizeof($v['member'][$k])?>"><input type=checkbox name="ids[]" value="<?php echo $v['id']?>" class="checkall"></input></td>
						<td rowspan="<?php  echo sizeof($v['member'][$k])?>"><?php echo $k+1?></td>
						<td rowspan="<?php echo sizeof($v['member'][$k])?>"><?php echo $v['cabin_type_code']?></td>
						<td rowspan="<?php echo sizeof($v['member'][$k])?>"><?php echo $v['cabin_price']?></td>
						<td rowspan="<?php echo sizeof($v['member'][$k])?>">
						<?php if($v['status']==0){
							echo "normal";
						}
						elseif ($v['status']==1){
							echo "cancel";
						}
						elseif ($v['status']==2){
							echo "In the processing";
						}
						elseif ($v['status']==3){
							echo "complete";
						}
						?>
						</td>
						<?php }?>
						
						<td><?php echo $vv['m_name']?></td>
						<td><?php echo $vv['passport_number']?></td>
						<td><?php echo isset($vv['additional_price'])?$vv['additional_price']:0?></td>
					</tr>
					<?php }?>
					<?php endforeach;?>
					<?php }?>
				<?php endforeach;?>
				<?php }?>
				</tbody>
			</table>
		</div>
		
		<div class="pBox infoBox">
			<h2>Costs Information</h2>
			<ul>
				<li><span><?php echo yii::t('app','TotalRoom Price')?>:</span><span class="point">￥<?php echo empty($v['member'][$k])?0:$totalroomprice?></span></li><!-- 房间总价 -->
				<li><span><?php echo yii::t('app','Taxes  Price')?>:</span><span class="point">￥<?php echo empty($v['member'][$k])?0:$tax_price?></span></li><!-- 税收费 -->
				<li><span><?php echo yii::t('app','Surcharge  Price')?>:</span><span class="point">￥<?php echo empty($v['member'][$k])?0:$surcharge?></span></li><!-- 附加费 -->
				<li><span><?php echo yii::t('app','Quayage  Price')?>:</span><span class="point">￥<?php echo empty($v['member'][$k])?0:$quayage?></span></li><!-- 码头税 -->
				<li><span><?php echo yii::t('app','Total  Price')?>:</span><span class="point">￥<?php echo empty($v['member'][$k])?0:($totalroomprice+$tax_price+$surcharge+$quayage)?></span></li>
			</ul>
		</div>
			<div class="btnBox2">
				<input type="button" id="back" value="<?php echo yii::t('app','Back')?>" class="btn2"></input>
				<input type="button" value="<?php echo yii::t('app','Refund')?>" id="refund" class="btn1"></input>
			</div>
	</div>
</div>
<!-- main content end -->
	<input type="hidden" value="<?php echo isset($_GET['id'])?$_GET['id']:''?>" id="order_serial_number"/>
<script>
	window.onload=function(){
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
							location.href="<?php echo Url::toRoute(['returning_ticket']);?>";
					         }
				         else if(tt==1){
							alert("Option success");
							location.href="<?php echo Url::toRoute(['returning_ticket']);?>";
					         }
				         else if(tt==2){
							alert("Please Choose...");
					         }
		                
		          } 
			});
		}
</script>




