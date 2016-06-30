<?php
$this->title = 'additional';

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
					<span>2015-12-19</span>
					<span>CTS1219-106 青岛-福冈-济州青岛，4晚5天</span>
					<span>旅游线路：福冈+济州岛岸上观光A线爽翻天购物游</span>
				</p>
				<table>
					<tr>
						<th>房间类型</th>
						<th>最多入住</th>
						<th>客舱价格</th>
						<th>客舱1</th>
						<th>客舱2</th>
						<th>客舱3</th>
						<th>客舱4</th>
						<th>总价格</th>
					</tr>
					<tr>
						<td>标准内舱房SB2</td>
						<td>2人</td>
						<td>2700/2700</td>
						<td>张三</td>
						<td>拼舱用户</td>
						<td>不能入住</td>
						<td>不能入住</td>
						<td>2700</td>
					</tr>
				</table>
			</div>
			<div class="box costInfo">
				<h3>费用信息</h3>
				<table>
					<tr class="title">
						<th colspan="3">舱房及包含产品</th>
					</tr>
					<tr>
						<td>内舱家庭房（2成人，1儿童）</td>
						<td>1间</td>
						<td>￥22394</td>
					</tr>
					<tr>
						<td>儿童优惠减</td>
						<td>1份</td>
						<td>-￥2799</td>
					</tr>
					<tr>
						<td>日本免签船舶观光上陆许可证（适用邮轮，上海送签）</td>
						<td>3份</td>
						<td>￥405</td>
					</tr>
					<tr class="title">
						<th colspan="3">附加产品</th>
					</tr>
					<tr>
						<td>平安携程境外邮轮短线保修 经典型</td>
						<td>3份</td>
						<td>￥390</td>
					</tr>
					<tr>
						<td>配送费</td>
						<td></td>
						<td>￥15</td>
					</tr>
					<tr class="title">
						<th>总价</th>
						<td></td>
						<td class="price">￥18000</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="btnBox clearfix">
			<a href="#" class="btn1 l">上一步</a>
			<a href="<?php echo Url::toRoute(['complete']).'&voyage_code='.$voyage_result['voyage_code'];?>" class="btn2 r">立即支付</a>
		</div>
	</div>
</div>
