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
				<input type="text"></input>
			</label>
			
			<label>
				<span><?php echo yii::t('app','Status')?>:</span>
				<select>
					<option><?php echo yii::t('app','All')?></option>
				</select>
			</label>
		</p>
		<p>
			<label>
				<span><?php echo yii::t('app','Agent Name')?>:</span>
				<input type="text"></input>
			</label>
			<label>
				<span><?php echo yii::t('app','Voyage Code')?>:</span>
				<input type="text"></input>
			</label>
			<span class="btn"><input type="button" value="SEARCH"></input></span>
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
					<td><?php echo $value['pay_status']?></td>
					<td>
						<a href="<?php echo Url::toRoute(['order/free_order_detail'])?>&order_serial_number=<?php echo $value['order_serial_number']?>"><img src="<?=$baseUrl ?>images/write.png" class="btn1"></a>
						<a href="#"><img src="<?=$baseUrl ?>images/delete.png" class="btn2"></a>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		<p class="records">Records:<span><?php echo sizeof($order)?></span></p>
		<div class="btn">
			<input type="button" id="savechangeclick" value="Add"></input>
			<input type="button" value="Del Selected"></input>
		</div>
	</div>
</div>
<!-- content end -->

