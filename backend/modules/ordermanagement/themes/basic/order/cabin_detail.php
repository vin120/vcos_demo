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
	&nbsp;&gt;&gt;&nbsp;<a href="<?php echo Url::toRoute(['order/free_order_detail'])?>"><?php echo yii::t('app','Free Order Detail')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Cabin Detail')?></a>
	<div class="tab">
	<ul class="tab_title">
		<li class="active"><?php echo yii::t('app','Order Information')?></li>
		<li><?php echo yii::t('app','Passenger 1')?></li>
		<li><?php echo yii::t('app','Passenger 2')?></li>
	</ul>
	<div class="tab_content">
		<!-- first tab -->	
		<div class="active">
			<div id="service_write" class="pop-ups write">
				<p>
					<label>
						<span><?php echo yii::t('app','Cabin Type')?>:</span>
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</label>
				</p>
				<p>
					<label>
						<span><?php echo yii::t('app','Room No')?>:</span>
						<select>
							<option>5001</option>
							<option>2</option>
						</select>
					</label>
				</p>
				<div class="pop-ups write">
					<p>
						<h4>Price:</h4>
					</p>
					<p>
						<span><?php echo yii::t('app','Total Price')?>: 1000</span>
					</p>
					<p>
						<span><?php echo yii::t('app','Cabin Price')?>: 500</span>
					</p>
					<p>
						<span><?php echo yii::t('app','Taxes')?>: 1000</span>
					</p>
					<p>
						<span><?php echo yii::t('app','Port Expenses')?>: 1000</span>
					</p>
					<p>
						<span><?php echo yii::t('app','Additional Price')?>: 1000</span>
					</p>
					
				</div>
				<p>
					<label>
						<span>Description:</span>
						<textarea></textarea>
					</label>
				</p>
			</div>
		</div>
		<!-- first tab end -->
		<!-- second tab  -->
		<div>
			<div>
				<table>
					<thead>
						<tr>
							<th><input type="checkbox"></input></th>
							<th>Offer Name</th>
							<th>Limit Number</th>
							<th>Operate</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox"></input></td>
							<td>半价儿童</td>
							<td>23</td>
							<td>
								<a href="#"><img src="images/write.png" class="btn1"></a>
								<a href="#"><img src="images/delete.png" class="btn2"></a>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="records">Records:<span>26</span></p>
				<div class="btn">
					<input type="button" value="Add"></input>
					<input type="button" value="Del Selected"></input>
				</div>
			</div>
		</div>
		<!-- second tab  end-->
		<!-- third tab  -->
		<div>
			<table>
				<thead>
					<tr>
						<th><input type="checkbox"></input></th>
						<th>Title</th>
						<th>Date</th>
						<th>Operate</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="checkbox"></input></td>
						<td>仁川观光线路A</td>
						<td>2016-05-01</td>
						<td>
							<a href="#"><img src="images/write.png" class="btn1"></a>
							<a href="#"><img src="images/delete.png" class="btn2"></a>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="records">Records:<span>26</span></p>
			<div class="btn">
				<input type="button" value="Add"></input>
				<input type="button" value="Del Selected"></input>
			</div>
		</div>
		<!-- third tab  end-->
	</div>
</div>
<!-- content end -->
