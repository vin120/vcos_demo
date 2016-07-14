<?php
$this->title = 'pay';

use app\views\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<div id="pay" class="main">
	<div class="container box">
		<div class="route">
			<div class="routeInfo">
				<span>编号：<?php echo $voyage_result['voyage_code']?>-<?php echo $voyage_result['voyage_name']?></span>
				<label>
					<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
					<span>返程</span>
				</label>
			</div>
			<div class="step">
				<ul>
					<li>
						<span class="num">1</span>
						<span class="title">选择房间</span>
					</li>
					<li>
						<span class="num">2</span>
						<span class="title">填写信息</span>
					</li>
					<li>
						<span class="num">3</span>
						<span class="title">附加产品</span>
					</li>
					<li class="active">
						<span class="num">4</span>
						<span class="title">订单支付</span>
					</li>
					<li>
						<span class="num">5</span>
						<span class="title">订票完成</span>
					</li>
				</ul>
			</div>
		</div>
		<div class="orderInfo">
			<div class="box">
				<h3>订单信息</h3>
				<p class="route">
					<span><?php echo substr($voyage_result['start_time'],0,10);?></span>
					<span><?php echo $voyage_result['voyage_code']?> <?php echo $voyage_result['voyage_name']?></span>
					<span>旅游线路：福冈+济州岛岸上观光A线爽翻天购物游</span>
				</p>
				<table>
				<thead>
					<tr>
						<th>房间类型</th>
						<th>房间号</th>
						<th>最多入住</th>
						<th>客舱价格</th>
						<th>客舱1</th>
						<th>客舱2</th>
						<th>客舱3</th>
						<th>客舱4</th>
						<th>总价格</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$room_array = ['one','two','three','four'];
				$cabins_name_arr = array();
				foreach ($cabins_result as $row){
					$cabins_name_arr[$row['cabin_type_code']] = $row['type_name'];
					?>
					<tr>
						<td><?php echo $row['type_name']?></td>
						<td><?php echo $row['cabin_name']?></td>
						<td><?php echo $row['check_num']?>人</td>
						<td><?php echo $row['bed_price']?>/<?php echo $row['last_bed_price']?></td>
						<?php for($i=0;$i<(int)$row['check_num'];$i++){
							$passport = ($row['passport_number_'.$room_array[$i]]==null)?"空床":$row['passport_number_'.$room_array[$i]];
						?>
							<td><?php echo $passport?></td>
						<?php }?>
						<?php for($j=0;$j<(4-(int)$row['check_num']);$j++){?>	
							
							<td>不能入住</td>
						<?php }?>
						<td><?php echo $row['cabin_price']?></td>
					</tr>
				<?php }?>
				</tbody>
				</table>
			</div>
			<div class="box costInfo">
				<h3>费用信息</h3>
				<table>
					<tr class="title">
						<th colspan="3">舱房及包含产品</th>
					</tr>
					<?php foreach ($cabins_big_class as $type=>$row){?>
					<tr>
						<td><?php echo $cabins_name_arr[$type]?>(<?php echo $row['adult']?>成人，<?php echo $row['children']?>儿童)</td>
						<td><?php echo $row['room']?>间</td>
						<td>￥<?php echo $row['price']?></td>
					</tr>
					<tr>
						<td>优惠减(儿童、老年、生日、提前预订等优惠)</td>
						<td></td>
						<td>-￥<?php echo (float)$row['preferential']-(float)$row['price']?></td>
					</tr>
					<?php }?>
					<?php foreach ($shore as $row){?>
					<tr>
						<td><?php echo $row['se_name']?></td>
						<td><?php echo $row['count']?>份</td>
						<td>共￥<?php echo (int)$row['count'] * (float)$row['additional_price']?></td>
					</tr>
					<?php }?>
					<tr>
						<td>税率</td>
						<td><?php echo $voyage_result['ticket_taxes']?>%</td>
						<td>共￥<?php echo $order_result['total_tax_pric']?></td>
					</tr>
					<tr>
						<td>码头税</td>
						<td>￥<?php echo $voyage_result['harbour_taxes']?></td>
						<td>共￥<?php echo $order_result['total_port_expenses']?></td>
					</tr>
					<tr class="title">
						<th colspan="3">附加产品</th>
					</tr>
					<?php foreach ($surcharge as $row){?>
					<tr>
						<td><?php echo $row['cost_name']?></td>
						<td><?php echo $row['count']?>份</td>
						<td>共￥<?php echo (int)$row['count'] * (float)$row['additional_price']?></td>
					</tr>
					<?php }?>
					<tr class="title">
						<th>总价</th>
						<td></td>
						<td class="price">￥<?php echo $order_result['total_pay_price']?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="btnBox clearfix">
			<!-- <a href="#" class="btn1 l">上一步</a> -->
			<a href="<?php echo Url::toRoute(['complete']).'&voyage_code='.$voyage_result['voyage_code'];?>" class="btn2 r">立即支付</a>
		</div>
	</div>
</div>
