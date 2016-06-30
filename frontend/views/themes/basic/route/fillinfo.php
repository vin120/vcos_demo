<?php
$this->title = 'fillinfo';

use app\views\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<div id="fillInfo" class="main">
	<div class="container box">
		<div class="route">
			<div class="routeInfo">
				<span>编号：CTS1219-106-青岛-福冈-济州-青岛，4晚5天</span>
				<label>
					<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
					<span>返程</span>
				</label>
			</div>
			<div class="step">
				<ul>
					<li class="active">
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
					<li>
						<span class="num">5</span>
						<span class="title">订票完成</span>
					</li>
				</ul>
			</div>
			<div class="clearfix">
				<div class="fillForm l">
					
					<div class="box">
						<h2>内舱家庭房</h2>
						<div class="formBox">
							<div class="title">
								<h3>乘客1<em class="color1">(成人)</em></h3>
								<div class="selectBox">
									<a href="#" class="color"><i class="icon-chevron-down"></i>选择常用旅客</a>
									<label class="r">
										<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
										<span>保存到常用旅客</span>
									</label>
								</div>
								<ul class="selectList">
									<li>
										<label>
											<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
											<span>张三</span>
										</label>
									</li>
									<li>
										<label>
											<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
											<span>李四</span>
										</label>
									</li>
									<li>
										<label>
											<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
											<span>诸葛孔明</span>
										</label>
									</li>
								</ul>
							</div>
							<div class="content">
								<p>
									<span class="name"><span>中文姓名</span></span>
									<span class="input"><input type="text" name="" class="halfWidth"></span>
									<a href="#" class="color halfWidth">填写范例</a>
									<span class="wrong">中文姓名不能为空</span>
								</p>
								<p>
									<span class="name"><span>英文姓名</span></span>
									<span class="input">
										<input type="text" name="" placeholder="姓/Last Name" class="halfWidth">
										<input type="text" name="" placeholder="名/First Name" class="halfWidth">
									</span>
								</p>
								<p>
									<span class="name"><span class="must">性别</span></span>
									<span class="input">
										<label class="halfWidth">
											<input type="radio" name="">
											<span>男</span>
										</label>
										<label class="halfWidth">
											<input type="radio" name="">
											<span>女</span>
										</label>
									</span>
								</p>
								<p>
									<span class="name"><span>出生日期</span></span>
									<span class="input"><input type="text" name=""></span>
								</p>
								<p>
									<span class="name"><span>手机号</span></span>
									<span class="input"><input type="text" name=""></span>
								</p>
								<p>
									<span class="name"><span>国籍</span></span>
									<span class="input"><input type="text" name=""></span>
								</p>
								<p>
									<span class="name"><span class="must">证件类型</span></span>
									<span class="input">
										<label class="writeNow">
											<input type="radio" name="1">
											<span>现在输入证件信息</span>
										</label>
										<label class="writeLater">
											<input type="radio" name="1">
											<span>稍后提供</span>
										</label>
									</span>
									
								</p>
								<div class="more box">
									<p>
										<span class="name">证件</span>
										<span class="input">
											<span class="select halfWidth">
												<select>
													<option></option>
												</select>
											</span>
											<input type="text" name="" placeholder="证件号码" class="halfWidth">
										</span>
									</p>
									<p>
										<span class="name">证件有效期</span>
										<span class="input">
											<input type="text" name="">
										</span>
									</p>
									<p>
										<span class="name">身份</span>
										<span class="input">
											<span class="select halfWidth">
												<select>
													<option></option>
												</select>
											</span>
										</span>
										<a href="#" class="color halfWidth">选择说明</a>
									</p>
									<p>
										<span class="name">出生地</span>
										<input type="text" name="">
									</p>
									<p>
										<span class="name">签发地</span>
										<input type="text" name="">
									</p>
								</div>
							</div>
						</div>
						<div class="formBox">
							<div class="title">
								<h3>乘客2<em class="color1">(儿童)</em></h3>
								<div class="selectBox">
									<a href="#" class="color"><i class="icon-chevron-down"></i>选择常用旅客</a>
									<label class="r">
										<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
										<span>保存到常用旅客</span>
									</label>
								</div>
								<ul class="selectList">
									<li>
										<label>
											<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
											<span>张三</span>
										</label>
									</li>
									<li>
										<label>
											<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
											<span>李四</span>
										</label>
									</li>
									<li>
										<label>
											<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
											<span>诸葛孔明</span>
										</label>
									</li>
								</ul>
							</div>
							<div class="content">
								<p>
									<span class="name"><span>中文姓名</span></span>
									<span class="input"><input type="text" name="" class="halfWidth"></span>
									<a href="#" class="color halfWidth">填写范例</a>
									<span class="wrong">中文姓名不能为空</span>
								</p>
								<p>
									<span class="name"><span>英文姓名</span></span>
									<span class="input">
										<input type="text" name="" placeholder="姓/Last Name" class="halfWidth">
										<input type="text" name="" placeholder="名/First Name" class="halfWidth">
									</span>
								</p>
								<p>
									<span class="name"><span class="must">性别</span></span>
									<span class="input">
										<label class="halfWidth">
											<input type="radio" name="">
											<span>男</span>
										</label>
										<label class="halfWidth">
											<input type="radio" name="">
											<span>女</span>
										</label>
									</span>
								</p>
								<p>
									<span class="name"><span>出生日期</span></span>
									<span class="input"><input type="text" name=""></span>
								</p>
								<p>
									<span class="name"><span>手机号</span></span>
									<span class="input"><input type="text" name=""></span>
								</p>
								<p>
									<span class="name"><span>国籍</span></span>
									<span class="input"><input type="text" name=""></span>
								</p>
								<p>
									<span class="name"><span class="must">证件类型</span></span>
									<span class="input">
										<label class="writeNow">
											<input type="radio" name="1">
											<span>现在输入证件信息</span>
										</label>
										<label class="writeLater">
											<input type="radio" name="1">
											<span>稍后提供</span>
										</label>
									</span>
									
								</p>
								<div class="more box">
									<p>
										<span class="name">证件</span>
										<span class="input">
											<span class="select halfWidth">
												<select>
													<option></option>
												</select>
											</span>
											<input type="text" name="" placeholder="证件号码" class="halfWidth">
										</span>
									</p>
									<p>
										<span class="name">证件有效期</span>
										<span class="input">
											<input type="text" name="">
										</span>
									</p>
									<p>
										<span class="name">身份</span>
										<span class="input">
											<span class="select halfWidth">
												<select>
													<option></option>
												</select>
											</span>
										</span>
										<a href="#" class="color halfWidth">选择说明</a>
									</p>
									<p>
										<span class="name">出生地</span>
										<input type="text" name="">
									</p>
									<p>
										<span class="name">签发地</span>
										<input type="text" name="">
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="btnBox clearfix">
						<a href="#" class="btn1 l"><上一步</a>
						<a href="#" class="btn2 r">下一步></a>
					</div>
				</div>
				<div class="orderForm r box">
					<div class="totalPrice">
						<span class="title">总价</span>
						<span class="price r">￥18000</span>
					</div>
					<div class="base">
						<div class="head">
							<span class="title">舱房及包含产品</span>
							<span class="price r">￥17595</span>
						</div>
						<table>
							<tr>
								<td>内舱家庭房<em>(2成人，1儿童)</em></td>
								<td>1间</td>
								<td>￥22394</td>
							</tr>
							<tr>
								<td>儿童优惠<em>减</em></td>
								<td>1份</td>
								<td>-￥4799</td>
							</tr>
							<tr>
								<td>日本免签船舶观光上陆许可证（适用邮轮，上海送签）</td>
								<td>3份</td>
								<td>已含</td>
							</tr>
						</table>
					</div>
					<div class="add">
						<div class="head">
							<span class="title">附加产品</span>
							<span class="price r">￥405</span>
						</div>
						<table>
							<tr>
								<td>平安携程境外邮轮短线保险 经典型</td>
								<td>3份</td>
								<td>￥390</td>
							</tr>
							<tr>
								<td>配送费</td>
								<td></td>
								<td>￥15</td>
							</tr>
						</table>
					</div>
					<div class="btnBox">
						<input type="button" value="保存订单" class="btn2">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>