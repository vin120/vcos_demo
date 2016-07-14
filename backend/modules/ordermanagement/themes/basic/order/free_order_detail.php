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
	<div class="topNav"><?php echo yii::t('app','Order Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="<?php echo Url::toRoute(['order/free_order'])?>"><?php echo yii::t('app','Free Order')?></a>
	&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Free Order Detail')?></a>
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
		<table>
			<thead>
				<tr>
					<th><input type="checkbox"></input></th>
					<th><?php echo yii::t('app','Cabin Type')?></th>
					<th><?php echo yii::t('app','Room No.')?></th>
					<th><?php echo yii::t('app','Total Price')?></th>
					<th><?php echo yii::t('app','Status')?></th>
					<th><?php echo yii::t('app','Passenger Name')?></th>
					<th><?php echo yii::t('app','Passport')?></th>
					<th><?php echo yii::t('app','Shore Excursion')?></th>
					<th><?php echo yii::t('app','Operate')?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($order_detail as $row ):?>
				<tr>
					<td><input type="checkbox"></input></td>
					<td><?php echo $row['type_name']?></td>
					<td><?php echo $row['cabin_name']?></td>
					<td><?php echo $row['cabin_price']?></td>
					<td><?php echo $row['status']?></td>
					<td>傻鳗</td>
					<td>E12345</td>
					<td>Plan A</td>
					<td>
						<a href="<?php echo Url::toRoute(['order/cabin_detail'])?>"><img src="<?=$baseUrl ?>images/write.png" class="btn1"></a>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		<p></p>
		<div class="btn">
			<input type="button" value=打印申请></input>
			<input type="button" value="退票"></input>
			<input type="button" value="销票"></input>
			<input type="button" value="打印发票"></input>
		</div>
	</div>
</div>
<!-- content end -->
