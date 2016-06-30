<?php
$this->title = 'fillinfonologin';

use app\views\themes\basic\myasset\ThemeAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ThemeAsset::register($this);

$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';

//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>
<script>
var save_session_cabins_noperson_info = "<?php echo Url::toRoute(['savesessioncabinsnopersoninfo']);?>";
</script>
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
					<li>
						<span class="num">1</span>
						<span class="title">选择房间</span>
					</li>
					<li class="active">
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
				<form id="person_info_form">
					<div class="formBox box">
						<h3>联系人信息</h3>
						<div class="content">
							<p>
								<label>
									<span class="name">联系人</span>
									<input type="text" name="contact_name">
								</label>
							</p>
							<p>
								<label>
									<span class="name">Email</span>
									<input type="text" name="contact_email">
								</label>
							</p>
							<p>
								<label>
									<span class="name">手机号码</span>
									<input type="text" name="contact_phone">
								</label>
							</p>
						</div>
					</div>
					
					<div class="box">
					<?php foreach ($cabins_arr as $row){?>
					<div class="cabins_class" type_code="<?php echo $row['type_code'] ?>" >
						<h2><?php echo $cabins_type_name[$row['type_code']]?></h2>
						<?php for($i=0;$i<$row['adult'];$i++){?>
						<div class="formBox adult_person_div">
							<div class="title">
								<h3>乘客1<em class="color1">(成人)</em></h3>
								<div class="selectBox">
									<label class="r">
										<span class="checkbox"><span class="icon-checkmark"></span><input checked="true" type="checkbox" name="keep_contact[]"></span>
										<span>保存到常用旅客</span>
									</label>
								</div>
							</div>
							<div class="content">
								<p>
									<span class="name"><span>中文姓名</span></span>
									<span class="input"><input type="text" name="full_name[]" class="halfWidth"></span>
									<a href="#" class="color halfWidth" style="margin-right: -1px;">填写范例</a>
									
								</p>
								<p>
									<span class="name"><span>英文姓名</span></span>
									<span class="input">
										<input type="text" name="last_name[]" placeholder="姓/Last Name" class="halfWidth">
										<input type="text" name="first_name[]" placeholder="名/First Name" class="halfWidth">
									</span>
								</p>
								<p>
									<span class="name"><span class="must">性别</span></span>
									<span class="input">
										<label class="halfWidth">
											<input type="radio" class="sex" checked="checked" name="<?php echo $row['type_code'];?>_sex_<?php echo $i;?>[]" value="1">
											<span>男</span>
										</label>
										<label class="halfWidth">
											<input type="radio" class="sex" name="<?php echo $row['type_code'];?>_sex_<?php echo $i;?>[]" value="2">
											<span>女</span>
										</label>
									</span>
								</p>
								<p>
									<span class="name"><span>出生日期</span></span>
									<span class="input"><input type="text" name="birth[]"  readonly value="01/01/1980" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',minDate: '1980-01-01', maxDate: '2003-12-31'})"></span>
								</p>
								<p>
									<span class="name"><span>手机号</span></span>
									<span class="input"><input type="text" name="phone[]"></span>
								</p>
								<p>
									<span class="name"><span>国籍</span></span>
									<span class="input"><input type="text" name="nationality[]"></span>
								</p>
								<p>
									<span class="name"><span class="must">证件类型</span></span>
									<span class="input adult_choose_type" >
										<label class="writeNow">
											<input type="radio" class="choose" name="<?php echo $row['type_code'];?>_choose_<?php echo $i;?>" value='1'>
											<span>现在输入证件信息</span>
										</label>
										<label class="writeLater">
											<input type="radio" class="choose" checked="checked"  name="<?php echo $row['type_code'];?>_choose_<?php echo $i;?>" value='2'>
											<span>稍后提供</span>
										</label>
									</span>
									
								</p>
								<div class="more box">
									<p>
										<span class="name">证件</span>
										<span class="input">
											<span class="select halfWidth" >
												<select name='paper_type[]'>
													<option value="1">护照</option>
													<option value="2">身份证</option>
													<option value="3">港澳通行证</option>
													<option value="4">台湾通行证</option>
												</select>
											</span>
											<input type="text" name="paper_num[]" placeholder="证件号码" class="halfWidth">
										</span>
									</p>
									<p>
										<span class="name">证件有效期</span>
										<span class="input">
											<input type="text" name="paper_date[]" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',minDate: '%y-#{%M+6}-%d', maxDate: '#{%y+20}-#{%M+6}-%d'})" >
										</span>
									</p>
									<p>
										<span class="name">身份</span>
										<span class="input">
											<span class="select halfWidth">
												<select name='identity_type[]'>
													<option value="1">待确认</option>
													<option value="2">在职人员</option>
													<option value="3">自由职业者</option>
													<option value="4">学生</option>
													<option value="5">退休人员</option>
													<option value="6">学龄前儿童</option>
												</select>
											</span>
										</span>
										<a href="#" class="color halfWidth">选择说明</a>
									</p>
									<p>
										<span class="name">出生地</span>
										<input type="text" name="birth_place[]">
									</p>
									<p>
										<span class="name">签发地</span>
										<input type="text" name="issue_place[]">
									</p>
								</div>
							</div>
						</div>
						<?php }?>
						<?php if((int)$row['children'] >0){
							for($j=0;$j<$row['children'];$j++){
						?>
						<div class="formBox children_person_div" >
							<div class="title">
								<h3>乘客2<em class="color1">(儿童)</em></h3>
								<div class="selectBox">
									<label class="r">
										<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" name="c_keep_contact[]"></span>
										<span>保存到常用旅客</span>
									</label>
								</div>
							</div>
							<div class="content">
								<p>
									<span class="name"><span>中文姓名</span></span>
									<span class="input"><input type="text" name="c_full_name[]" class="halfWidth"></span>
									<a href="#" class="color halfWidth">填写范例</a>
								</p>
								<p>
									<span class="name"><span>英文姓名</span></span>
									<span class="input">
										<input type="text" name="c_last_name[]" placeholder="姓/Last Name" class="halfWidth">
										<input type="text" name="c_first_name[]" placeholder="名/First Name" class="halfWidth">
									</span>
								</p>
								<p>
									<span class="name"><span class="must">性别</span></span>
									<span class="input">
										<label class="halfWidth">
											<input type="radio" class="c_sex" checked="checked"  name="<?php echo $row['type_code'];?>_c_sex_<?php echo $j;?>[]" value='1'>
											<span>男</span>
										</label>
										<label class="halfWidth">
											<input type="radio" class="c_sex" name="<?php echo $row['type_code'];?>_c_sex_<?php echo $j;?>[]" value='2'>
											<span>女</span>
										</label>
									</span>
								</p>
								<p>
									<span class="name"><span>出生日期</span></span>
									<span class="input"><input type="text" name="c_birth[]"  readonly value="01/01/1980" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',minDate: '1980-01-01', maxDate: '2003-12-31'})"></span>
								</p>
								<p>
									<span class="name"><span>手机号</span></span>
									<span class="input"><input type="text" name="c_phone[]"></span>
								</p>
								<p>
									<span class="name"><span>国籍</span></span>
									<span class="input"><input type="text" name="c_nationality[]"></span>
								</p>
								<p>
									<span class="name"><span class="must">证件类型</span></span>
									<span class="input children_choose_type">
										<label class="writeNow">
											<input type="radio" class="c_choose" name="<?php echo $row['type_code'];?>_c_choose_<?php echo $i;?>" value='1'>
											<span>现在输入证件信息</span>
										</label>
										<label class="writeLater">
											<input type="radio" class="c_choose" checked="checked" name="<?php echo $row['type_code'];?>_c_choose_<?php echo $i;?>" value='2'>
											<span>稍后提供</span>
										</label>
									</span>
									
								</p>
								<div class="more box">
									<p>
										<span class="name">证件</span>
										<span class="input">
											<span class="select halfWidth">
												<select  name='c_paper_type[]'>
													<option value="1">护照</option>
													<option value="2">身份证</option>
													<option value="3">港澳通行证</option>
													<option value="4">台湾通行证</option>
												</select>
											</span>
											<input type="text" name="c_paper_num[]" placeholder="证件号码" class="halfWidth">
										</span>
									</p>
									<p>
										<span class="name">证件有效期</span>
										<span class="input">
											<input type="text" name="c_paper_date[]" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',minDate: '%y-#{%M+6}-%d', maxDate: '#{%y+20}-#{%M+6}-%d'})" >
										</span>
									</p>
									<p>
										<span class="name">身份</span>
										<span class="input">
											<span class="select halfWidth">
												<select  name='c_identity_type[]'>
													<option value="1">待确认</option>
													<option value="2">在职人员</option>
													<option value="3">自由职业者</option>
													<option value="4">学生</option>
													<option value="5">退休人员</option>
													<option value="6">学龄前儿童</option>
												</select>
											</span>
										</span>
										<a href="#" class="color halfWidth">选择说明</a>
									</p>
									<p>
										<span class="name">出生地</span>
										<input type="text" name="c_birth_place[]">
									</p>
									<p>
										<span class="name">签发地</span>
										<input type="text" name="c_issue_place[]">
									</p>
								</div>
							</div>
						</div>
						<?php }}?>
						</div>
					<?php }?>
					</div>
					</form>
					<div class="btnBox clearfix">
						<a href="#" class="btn1 l"><上一步</a>
						<a href="<?php echo Url::toRoute(['additional']).'&voyage_code='.$voyage_result['voyage_code'];?>" onclick="return savepersoninfo()" class="btn2 r">下一步></a>
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
					<!-- <div class="add">
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
					</div> -->
					<div class="btnBox">
						<a  onclick="return savepersoninfo()"><input type="button"  value="下一步" class="btn2"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
window.onload = function(){
	
}
</script>