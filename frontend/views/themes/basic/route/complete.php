<?php
$this->title = 'complete';

use app\views\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<div id="complete" class="main">
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
					<li>
						<span class="num">4</span>
						<span class="title">订单支付</span>
					</li>
					<li class="active">
						<span class="num">5</span>
						<span class="title">订票完成</span>
					</li>
				</ul>
			</div>
		</div>
		<div class="completePrompt box">
			<img src="<?=$baseUrl ?>images/finish.png">
			<p>恭喜您！青岛-福冈-济州-青岛，4晚5天邮轮旅游订票已完成。</p>
			<input type="button" value="确定" class="btn1">
			<input type="button" value="去完善旅客信息" class="btn2">
		</div>
	</div>
</div>
