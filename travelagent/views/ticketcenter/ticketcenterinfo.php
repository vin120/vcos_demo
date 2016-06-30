<?php
$this->title = 'Agent Ticketing';
use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use travelagent\views\myasset\TicketCenterInfoAsset;
PublicAsset::register($this);
TicketCenterInfoAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';

?>
<!-- main content start -->
<div id="orderPay" class="mainContent">
    <div id="topNav">
	    <?php echo yii::t('app','Agent Ticketing')?>&nbsp;&gt;&gt;&nbsp;
	    <a href="#"><?php echo yii::t('app','Ticket Center')?></a>&nbsp;&gt;&gt;&nbsp;
	    <a href="#"><?php echo yii::t('app','Ticket CenterInfo')?></a>
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
						<th><?php echo yii::t('app','No.')?></th>
						<th><?php echo yii::t('app','Room Code')?></th>
						<th><?php echo yii::t('app','Room Price')?></th>
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
						<td rowspan="<?php  echo sizeof($v['member'][$k])?>"><?php echo $k+1?></td>
						<td rowspan="<?php echo sizeof($v['member'][$k])?>"><?php echo $v['cabin_type_code']?></td>
						<td rowspan="<?php echo sizeof($v['member'][$k])?>"><?php echo $v['cabin_price']?></td>
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
				<li><span><?php echo yii::t('app','TotalRoom Price')?>:</span><span class="point">￥<?php echo empty($totalroomprice)?0:$totalroomprice?></span></li><!-- 房间总价 -->
				<li><span><?php echo yii::t('app','Taxes  Price')?>:</span><span class="point">￥<?php echo empty($orderinfo['total_tax_pric'])?0:$orderinfo['total_tax_pric']?></span></li><!-- 税收费 -->
				<li><span><?php echo yii::t('app','Surcharge  Price')?>:</span><span class="point">￥<?php echo empty($orderinfo['total_additional_price'])?0:$orderinfo['total_additional_price']?></span></li><!-- 附加费 -->
				<li><span><?php echo yii::t('app','Quayage  Price')?>:</span><span class="point">￥<?php echo empty($orderinfo['total_port_expenses'])?0:$orderinfo['total_port_expenses']?></span></li><!-- 码头税 -->
				<li><span><?php echo yii::t('app','Total  Price')?>:</span><span class="point">￥<?php echo empty($orderinfo['total_pay_price'])?0:$orderinfo['total_pay_price']?></span></li>
			</ul>
		</div>
			<div class="btnBox2">
				<input type="button" id="back" value="<?php echo yii::t('app','Back')?>" class="btn2"></input>
				<input type="button" value="<?php echo yii::t('app','PAY')?>" id="pay" class="btn1"></input>
				<input type="button" value="<?php echo yii::t('app','Cancel The Order')?>" id="cancelorder" class="btn1"></input>
			</div>
	</div>
	<div class="shadow"></div>
	<div class="popups prompt">
		<h3><?php echo yii::t('app','Prompt')?><a href="#" class="r close">&#10006;</a></h3>
		<div class="pBox">
			<p><?php echo yii::t('app','Do you want to cancel the order?')?></p>
			<p class="btnBox">
				<input type="button" value="<?php echo yii::t('app','YES')?>" id="submitcancelorder" class="btn1"></input>
				<input type="button" value="<?php echo yii::t('app','NO')?>" class="btn2 close"></input>
			</p>
		</div>
	</div>
</div>
<!-- main content end -->
	<input type="hidden" value="<?php echo isset($_GET['id'])?$_GET['id']:''?>" id="order_serial_number"/>
<script>
	window.onload=function(){
		$("#back").click(function(){
			location.href="<?php echo Url::toRoute(['ticketcenter']);?>";
			});
		$("#pay").click(function(){
			location.href="<?php echo Url::toRoute(['bookingticket/payment']);?>&order_serial_number="+"<?php echo isset($_GET['id'])?$_GET['id']:''?>&total_pay_price="+"<?php echo isset($orderinfo['total_pay_price'])?$orderinfo['total_pay_price']:''?>";
			});
		$("#cancelorder").on("click",function() {
			new PopUps($(".prompt"));
		});
		$("#submitcancelorder").click(function(){
		       var order_serial_number=$("#order_serial_number").val();
		         $.ajax({  
		             url: "<?php echo Url::toRoute(['cancelorder']);?>",
		             data:{order_serial_number:order_serial_number},
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
		        	if(tt==1){
						Alert('Cancel Success');
						$(".cancel_but").click(function(){
						location.href="<?php echo Url::toRoute(['ticketcenter']);?>";
						});
			        	}
		        	else{
		        		Alert('Cancel Fail');	
		        		$(".cancel_but").click(function(){
		        		location.href="<?php echo Url::toRoute(['ticketcenter']);?>";	
		        		});
			        	}
		         }  
			});
		}
</script>




