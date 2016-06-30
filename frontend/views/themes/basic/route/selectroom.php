<?php
$this->title = 'selectroom';

use app\views\themes\basic\myasset\ThemeAsset;
use app\views\themes\basic\myasset\SelectroomThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);
SelectroomThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';
$selectroom_baseUrl = $this->assetBundles[SelectroomThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<style>
.hidden{display:none;}
</style>
<script>
var save_session_cabins = "<?php echo Url::toRoute(['savesessioncabins']);?>";
</script>
<div id="selectRoom" class="main">
	<div class="container box">
		<div class="route">
			<div class="routeInfo">
				<span>编号：<?php echo $voyage_result['voyage_code']?>-<?php echo $voyage_result['voyage_name']?></span>
				<label>
					<input type="checkbox" name="">
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
						<span class="title">产品分配</span>
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
		</div>
		<div>
			<div class="roomType clearfix">
					<span class="title">
						选择舱房类型
					</span>
					<ul class="tabTitle rooms">
						<?php foreach ($bigcabin_result as $k=>$row){?>
							<li <?php if($k==0){echo "class='active'";}?> big_id="<?php echo $row['id']?>">
								<span class="name"><?php echo $row['class_name']?></span>
								<span class="price"><em>￥<?php echo $row['price']?></em>起</span>
							</li>
						<?php }?>
					</ul>
					<a href="<?php echo Url::toRoute(['fillinfo']).'&voyage_code='.$voyage_result['voyage_code'];?>" onclick="return nextCheck()" class="nextBtn r disabled">下一步</a>
					<div class="info r title_sum_price hidden">
						<span>总价：<em class="price">￥11111</em></span>
						<span>人均：￥111</span>
					</div>
					<div class="info r title_sum_number hidden">
						<span>入住：成人1人，儿童1人</span>
						<span>房间：1间</span>
					</div>
					<div class="info r title_error">
						<p>请在下方选择入住人数进行预定</p>
					</div> 
				</div>
			<div class="tabContent roomList">
			<!-- foreach start -->
			<?php foreach ($cabin_result as $k=>$row){?>
				<div>
					<h3><?php echo $row['name']?></h3>
					<?php if(!empty($row['child'])){?>
					<ul class="active box">
					<?php foreach($row['child'] as $key=>$value){?>
					<li>
						<div class="clearfix">
							<div class="l selectRoom">
								<div>
									<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
									<span class="roomName"><?php echo $value['type_name']?></span>
									<div class="link">
										<div class="infoBtn">
											<a href="#">详情介绍</a>
										</div>
										<div class="preferential">
											<a href="#">入住优惠</a>
											<div class="perfer">入住优惠。。。</div>
										</div>
									</div>
								</div>
								<div class="info">
									<p>最少成人数：<?php echo $value['live_number']?>人</p>
									<p>可入住人数：<?php echo $value['beds']?>人</p>
								</div>
								<div class="price">
									<span><em>￥<?php echo $value['bed_price']?></em>/人起</span>
								</div>
								
							</div>
							<div class="r selectNum clearfix tr_table_cabin" type_code="<?php echo $value['type_code']?>" bed_price="<?php echo $value['bed_price']?>" bed_2_price="<?php echo $value['last_bed_price']?>" bed_child="<?php echo $children_pre['p_price']?>" bed_2_child="<?php echo $children_pre['s_p_price']?>" bed_empty="<?php echo $value['2_empty_bed_preferential']?>" bed_2_empty="<?php echo $value['3_4_empty_bed_preferential']?>" > 
								<table class="l">
									<thead>
										<tr>
											<th>第1、2人价格</th>
											<th>第3、4人价格</th>
											<th>入住人数</th>
											<th>房间数</th>
										</tr>
									</thead>
									<tbody   room_num="<?php echo $value['room_num']?>" min_adult="<?php echo $value['live_number']?>" bed_num="<?php echo $value['check_num']?>">
										<tr>
											<td>成人：<em>￥<?php echo $value['bed_price']?></em></td>
											<td>成人：<em>￥<?php echo $value['last_bed_price']?></em></td>
											<td>
												<span class="inputNum" op='adult'>
													<span class="disabled">-</span>
													<input type="text" readonly="readonly" name="" value="0">
													<span>+</span>
												</span>
											</td>
											<td>
												<span class="inputNum" op="sum">
													<span class="disabled">-</span>
													<input type="text" readonly="readonly" name="" value="0">
													<span class="disabled">+</span>
												</span>
											</td>
										</tr>
										<tr>
											<td>儿童：<em>￥<?php echo (float)$value['bed_price']*(float)$children_pre['p_price']/100;?></em></td>
											<td>儿童：<em>￥<?php echo (float)$value['last_bed_price']*(float)$children_pre['s_p_price']/100;?></em></td>
											<td> 
												<span class="inputNum" op="children">
													<span class="disabled">-</span>
													<input type="text" readonly="readonly" name="" value="0">
													<span class="disabled">+</span>
												</span>
											</td>
											<td>
												<span>仅剩<em><?php echo $value['room_num']?></em>间</span>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="r btnBox cabin_price_show hidden">
									<!-- <p>原价：<del>￥11111</del></p> -->
									<p class="price" style="margin-top: 30px;">总价：<em>￥123</em></p>
									<p>人均：￥111</p>
								</div>
								<a style="cursor: pointer;color:blue" class="delete color hidden">清除</a>
								
								<div class="r btnBox error_tips  hidden">
									<p class="point" style="color:red">每间舱房必须入住<em><?php echo $value['live_number']?></em>名成人，请修改</p>
								</div>
								
								<div class="r btnBox tips">
									<p class="point">请先选择入住人数</p>
								</div>
								
							</div>
						</div>
						<div class="roomInfo clearfix">
							<ul class="imgList l">
								<img src="img/room.jpg">
							</ul>
							<div class="info r">
								<table>
									<tr>
										<th>舱型名称</th>
										<td>内舱房</td>
									</tr>
									<tr>
										<th>可住人数</th>
										<td>2-2人</td>
									</tr>
									<tr>
										<th>房型面积</th>
										<td><?php echo $value['room_area']?>平方米</td>
									</tr>
									<tr>
										<th>所在楼层</th>
										<td>-</td>
									</tr>
									<tr>
										<th>窗型</th>
										<td>无窗</td>
									</tr>
									<tr>
										<th>设施</th>
										<td>两张单人床（1米*2米）（可合并为双人大床，另外有部分房间还配有1-2张拉伸式折叠床），无窗，小酒吧，保险箱，电视机，电话，带淋雨、吹风机与化妆区的独立卫生间，24小时客舱服务。</td>
									</tr>
									<tr>
										<th>礼宾待遇</th>
										<td>24小时客房服务</td>
									</tr>
								</table>
							</div>
						</div>
					</li>
					
					<?php }?>
					
					</ul>
					<?php }?>
				</div>
				
				<?php }?>
				<!-- foreach end -->
			</div>
		</div>
	</div>
	
	<div class="shadow"></div>
	<form action='<?php echo Url::to(['site/login']);?>' method="post" >
	<div class="loginBox">
		<h3>会员登录预定</h3>
		<div class="loginForm">
			<p>
				<label>
					<span>登录名：</span>
					<input type="text" name="name" placeholder="用户名/卡号/手机/邮箱">
				</label>
				<span class="wrong">
					登录名不能为空
				</span>
			</p>
			<p>
				<label>
					<span>密码：</span>
					<input type="password" name="password">
				</label>
				<a href="#" class="color">忘记密码？</a>
			</p>
		</div>
		<p class="autoLogin">
			<label>
				<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
				<span>30天内自动登录</span>
			</label>
			<a href="<?php echo Url::toRoute(['register'])?>" class="color r">免费注册</a>
		</p>
		<!-- <p class="wrong">
			登录名或密码错误
		</p> -->
		<p class="btnBox">
			<input type="submit" value="登录" class="btn2">
			<a href="<?php echo Url::toRoute(['fillinfonologin']).'&voyage_code='.$voyage_result['voyage_code'];?>" onclick="return savejson()"><input type="button" value="不登录，直接预定" class="btn1"></a>
		</p>
		<a href="#" class="close">×</a>
	</div>
	</form>
</div>
