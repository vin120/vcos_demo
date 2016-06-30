<?php
$this->title = 'Agent Ticketing';
use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';

?>
<!-- main content start -->
<div id="refundApplication" class="mainContent">
    <div id="topNav">
    <?php echo yii::t('app','Agent Ticketing')?>&nbsp;&gt;&gt;&nbsp;
    <a href="#"><?php echo yii::t('app','Refund Ticket')?></a>
    </div>
    <div id="mainContent_content">
		<!-- 请用ajax提交 -->
		<div class="pBox">
			<table>
				<thead>
					<tr>
						<th><?php echo yii::t('app','No.')?></th>
						<th><?php echo yii::t('app','Order Number')?></th>
						<th><?php echo yii::t('app','Route ID')?></th>
						<th><?php echo yii::t('app','Route Name')?></th>
						<th><?php echo yii::t('app','Order Price')?></th>
						<th><?php echo yii::t('app','Order Time')?></th>
						<th><?php echo yii::t('app','Status')?></th>
						<th><?php echo yii::t('app','Operation')?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($order as $key=>$value):?>
					<tr>
						<td><?php echo $key+1?></td>
							<td><?php echo $value['order_serial_number']?></td>
							<td><?php echo $value['voyage_code']?></td>
							<td><?php echo $value['voyage_name']?></td>
							<td>￥<?php echo $value['total_pay_price']?></td>
							<td><?php echo $value['create_order_time']?></td>
							<td><?php echo $value['pay_status'] == 0 ? yii::t('app','To Be Paid') : yii::t('app','Finished')  ?></td>
						<td><button class="btn1" onclick="hrefinfo('<?php echo $value['order_serial_number'] ?>')"><img src="<?=$baseUrl?>images/return.png"></button></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- main content end -->

<script type="text/javascript">
function hrefinfo(id){
	location.href="<?php echo Url::toRoute(['return_ticket_info']);?>&id="+id;
}
</script>



