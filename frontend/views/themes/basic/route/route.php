<?php
$this->title = 'route';

use app\views\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<div id="route" class="main">
	<div class="container">
		<?php
			$form = ActiveForm::begin([
					'method'=>'post',
					'enableClientValidation'=>false,
					'enableClientScript'=>false
			]);
			
		?>
		<div class="search box">
			<label>
				<span>邮轮：</span>
				<span class="select">
				<select name='cruise'>
					<option value=''>请选择</option>
				<?php foreach ($cruise_result as $row){?>
					<option <?php echo  $cruise===$row['cruise_code']?"selected='selected'":"";?> value="<?php echo $row['cruise_code']?>"><?php echo $row['cruise_name']?></option>
				<?php }?>
				</select>
				</span>
			</label>
			<label>
				<span>出发港：</span>
				<span class="select">
				<select name='s_port'>
					<option value=''>请选择</option>
				<?php foreach ($port_result as $row){?>
					<option <?php echo  $s_port===$row['port_code']?"selected='selected'":"";?> value="<?php echo $row['port_code']?>"><?php echo $row['port_name']?></option>
				<?php }?>
				</select>
				</span>
			</label>
			<label>
				<span>目的港：</span>
				<span class="select">
				<select name='e_port'>
					<option value=''>请选择</option>
				<?php foreach ($port_result as $row){?>
					<option <?php echo  $e_port===$row['port_code']?"selected='selected'":"";?> value="<?php echo $row['port_code']?>"><?php echo $row['port_name']?></option>
				<?php }?>
				</select>
				</span>
			</label>
			<label>
				<span>出发时间：</span>
				<span class="select">
				<input type='text' value="<?php echo $s_time;?>" name='s_time' readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',lang:'en'})" />
				</span>
			</label>
			<span class="btnBox">
				<input type="submit" value="搜索" class="btn2">
			</span>
		</div>
		<?php 
		ActiveForm::end(); 
		?>
		<div class="routeList box">
			<ul>
			<?php foreach ($voyage_result as $row){?>
				<li class="clearfix">
					<div class="l">
						<span class="imgBox">
							<img src="<?=$baseUrl ?>images/route.png">
						</span>
					</div>
					<div class="r routeInfo">
							<div class="title">
								<h3><?php echo $row['voyage_name']?></h3>
								<a href="#" class="detailBtn">详情</a>
							</div>
						<div class="detail">
							<p class="colBox">
								<span>出发港口：<?php echo isset($row['s_port'])?$row['s_port']:'';?></span>
								<span>途径港口：<?php echo isset($row['e_port'])?$row['e_port']:'';?></span>
							</p>
							<p class="colBox">
								<span>出发日期：<?php echo $row['start_time']?></span>
								<span>回港日期：<?php echo $row['end_time']?></span>
							</p>
							<p>
								<?php $date=floor((strtotime($row['end_time'])-strtotime($row['start_time']))/86400);
									  $hour=floor((strtotime($row['end_time'])-strtotime($row['start_time']))%86400/3600);
									  //$minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
									  //$second=floor((strtotime($enddate)-strtotime($startdate))%86400%60);
								?>
								<span>全程天数：<?php echo $date.'.'.$hour;?>天</span>
							</p>
							<p>
								<span>最低：<em class="price">￥<?php echo $row['ticket_price']?></em>起</span>
								<a href="<?php echo Url::toRoute(['selectroom']).'&voyage_code='.$row['voyage_code'];?>" class="r btn2">立即预定</a>
							</p>
						</div>
					</div>
				</li>
			<?php }?>
				
			</ul>
		</div>
	</div>
</div>
