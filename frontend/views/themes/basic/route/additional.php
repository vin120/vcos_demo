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
<div id="additional" class="main">
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
					<li class="active">
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
			<div class="clearfix">
				<div class="fillForm l">
					<div class="formBox box contains_product">
						<h3>包含产品</h3>
						<p class="title"><span>岸上游</span>（票价已含岸上游，以下路线每人只能选择一条）</p>
						<ul>
							<?php foreach ($shore as $k=>$sh){?>
							<li>
								<div class="item">
									<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
									<span id="<?php echo $sh['se_code']?>" ><?php echo $sh['se_name']?></span>
									<span class="itemBtn r">
										<a href="#" class="color checkDetail">查看详情</a>
										<a href="#" class="color selectDetail">选择乘客</a>
									</span>
								</div>
								<div class="itemContent">
									<div class="detail">
										<!-- <ul>
											<li>a.接驳巴士服务为免费，不提供中途上落客点；</li>
											<li>b.需乘坐接驳巴士的客人，必须在出发前同时提前预订去程及返程上下车点；</li>
											<li>c.不能临时变更上车点，否则导致车位无法安排以及换房卡需要长时间轮候；</li>
											<li>d.不接受在船上临时预订/变更返程接驳巴士下车点。</li>
										</ul> -->
										<?php echo $sh['se_info'];?>
									</div>
									<div class="traveler">
										<ul>
											<?php foreach ($person_arr as $row){
											foreach ($row as $val){?>
											<li>
												<label>
													<span class="checkbox">
														<span class="icon-checkmark"></span>
														<input type="checkbox" name="" value="<?php echo $val['key']?>">
													</span>
													<span><?php echo $val['full_name']?></span>
												</label>
											</li>
											<?php }}?>
										</ul>
									</div>
								</div>
							</li>
							<?php }?>
						</ul>
					</div>
					<div class="formBox box additional_product ">
						<h3>附加产品</h3>
						<p class="title"><span>岸上游</span>（票价已含岸上游，以下路线每人只能选择一条）</p>
						<ul>
							<?php foreach ($surcharge as $k=>$su){?>
							<li>
								<div class="item">
									<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name=""></span>
									<span  id="<?php echo $su['cost_id']?>" ><?php echo $su['cost_name']?></span>
									<span class="price">[<em>￥<?php echo $su['cost_price']?></em>/人]</span>
									<span class="itemBtn r">
										<a href="#" class="color checkDetail">查看详情</a>
										<a href="#" class="color selectTraveler">选择乘客</a>
									</span>
								</div>
								<div class="itemContent">
									<div class="detail">
									<?php echo $su['cost_desc']?>
										<!-- <ul>
											<li>a.接驳巴士服务为免费，不提供中途上落客点；</li>
											<li>b.需乘坐接驳巴士的客人，必须在出发前同时提前预订去程及返程上下车点；</li>
											<li>c.不能临时变更上车点，否则导致车位无法安排以及换房卡需要长时间轮候；</li>
											<li>d.不接受在船上临时预订/变更返程接驳巴士下车点。</li>
										</ul> -->
									</div>
									<div class="traveler">
										<ul>
											<?php foreach ($person_arr as $row){
											foreach ($row as $val){?>
											<li>
												<label>
													<span class="checkbox">
														<span class="icon-checkmark"></span>
														<input type="checkbox" name="" value="<?php echo $val['key']?>">
													</span>
													<span><?php echo $val['full_name']?></span>
												</label>
											</li>
											<?php }}?>
										</ul>
									</div>
								</div>
							</li>
							<?php }?>
						</ul>
					</div>
					<div class="formBox box cabins_distribution">
						<h3>房间分配</h3>
						<table>
							<thead>
								<tr>
									<th>舱房类型</th>
									<th>旅客1</th>
									<th>旅客2</th>
									<th>旅客3</th>
									<th>旅客4</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($person_arr as $code=>$cabin_per){
									for($k=0;$k<$cabins_room_num[$code];$k++){
										$one_num = ($cabins_room_num[$code]>1)?4:(count($cabin_per));
										$two_num = ($cabins_room_num[$code]>1)?0:(4-((int)count($cabin_per)));
									?>
								<tr cabin_type="<?php echo $code;?>">
									<td><?php echo $cabins_type_name[$code]?></td>
									<?php for ($i=0;$i<$one_num;$i++){?>
										<td>
											<span class="select">
												<select name="cabin_per[]">
													<option value="">请选择</option>
												<?php foreach ($cabin_per as $per){?>
													<option value="<?php echo $per['key']?>"><?php echo $per['full_name']?></option>
												<?php }?>
												</select>
											</span>
										</td>
									<?php }?>
									<?php for ($j=0;$j<$two_num;$j++){?>
									<td>
										<span class="select">
											<select  disabled="disabled">
												<option value=''>不可选</option>
											</select>
										</span>
									</td>
									<?php }?>
									
								</tr>
								<?php }}?>
							</tbody>
						</table>
					</div>
					<div class="btnBox clearfix">
						<a href="<?php echo Url::toRoute(['fillinfo']).'&voyage_code='.$voyage_result['voyage_code'];?>" class="btn1 l">上一步</a>
						<a href="<?php echo Url::toRoute(['pay']).'&voyage_code='.$voyage_result['voyage_code'];?>" onclick="return saveaddition()" class="btn2 r">下一步></a>
					</div>
				</div>
				<div class="orderForm r box">
				<?php $count_price = 0; foreach ($cabins_arr as $v){
					$count_price += (float)$v['price'];
				}?>
					<div class="totalPrice">
						<span class="title">总价</span>
						<span class="price r">￥<?php echo $count_price;?></span>
					</div>
					<div class="base">
						<div class="head">
							<span class="title">舱房及包含产品</span>
							<span class="price r">￥<?php echo $count_price;?></span>
						</div>
						<table>
							<?php foreach ($cabins_arr as $v){?>
							<tr>
								<td><?php echo $cabins_type_name[$v['type_code']]?><em>(<?php echo $v['adult']?>成人，<?php echo $v['children']?>儿童)</em></td>
								<td><?php echo $v['room']?>间</td>
								<td>￥<?php echo $v['price']?></td>
							</tr>
							<?php }?>
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
						<a href="<?php echo Url::toRoute(['pay']).'&voyage_code='.$voyage_result['voyage_code'];?>"  onclick="return saveaddition()"><input type="button" value="保存订单" class="btn2"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
