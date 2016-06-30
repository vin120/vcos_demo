<?php
$this->title = 'Agent Ticketing';


use travelagent\views\myasset\PublicAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

PublicAsset::register($this);
$baseUrl = $this->assetBundles[PublicAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>

<!-- main content start -->
<div id="orderInformation" class="mainContent">
	<div id="topNav">
		<?php echo yii::t('app','Agent Ticketing')?>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Reservation')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Input mode')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Data Import')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Data Verification')?></a>
		<span>>></span>
		<a href="#"><?php echo yii::t('app','Confirm the Order Information')?></a>
	</div>
	<div id="mainContent_content" class="pBox">
		<table>
			<thead>
				<tr>
					<th><?php echo yii::t('app','No.')?></th>
					<th><?php echo yii::t('app','Cabin Type')?></th>
					<th><?php echo yii::t('app','Room')?></th>
					<th><?php echo yii::t('app','Last Name')?></th>
					<th><?php echo yii::t('app','First Name')?></th>
					<th><?php echo yii::t('app','Passport No.')?></th>
					<th><?php echo yii::t('app','Date Of Issue')?></th>
					<th><?php echo yii::t('app','Date Of Expiry')?></th>
					<th>....</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($order_total_result as $k=>$v){?>
				<tr>
					<td><?php echo ($k+1);?></td>
					<td><?php echo $v['type_name']?></td>
					<td><?php echo $v['cabin_name']?></td>
					<td><?php echo $v['last_name']?></td>
					<td><?php echo $v['first_name']?></td>
					<td><?php echo $v['passport_num']?></td>
					<td><?php echo $v['date_issue']?></td>
					<td><?php echo $v['date_expire']?></td>
					<td>....</td>
				</tr>
			<?php }?>
			</tbody>
		</table>
		<h2>Costs Information</h2>
		<div class="infoBox">
			<div class="pBox">
				<ul>
					<li><span>Total cabin price:</span><span>￥<?php echo sprintf("%.2f", $order_price_total['cabin_price'])?></span></li>
					<li><span>Total Tax:</span><span>￥<?php echo sprintf("%.2f", $order_price_total['tax'])?></span></li>
					<li><span>Total Port:</span><span>￥<?php echo sprintf("%.2f", (float)$order_price_total['port'])?></span></li>
					<li><span>Total surcharge:</span><span>￥<?php echo sprintf("%.2f", $order_price_total['surcharge'])?></span></li>
				</ul>
			</div>
			<div class="pBox">
				<span>Total Price:</span>
				<span class="point">￥<?php echo sprintf("%.2f", $order_price_total['total_pay_price'])?></span>
			</div>
		</div>
		<div class="btnBox2">
			<!-- <input type="button" value="PREVIOUS" class="btn2"></input> -->
			<input type="button" id="order_next" value="CONFIRM TO PAY" class="btn1"></input>
		</div>
	</div>
</div>
<!-- main content end -->

<script type="text/javascript">
window.onload = function(){
	$("#order_next").on('click',function(){
		location.href="<?php echo Url::toRoute(['payment','order_number'=>$order_price_total['order_number'],'total_pay_price'=>$order_price_total['total_pay_price']])?>";
	});
	
}
</script>


