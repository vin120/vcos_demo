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
<script>
var save_session_cabins_noperson_info = "<?php echo Url::toRoute(['savesessioncabinsnopersoninfo']);?>";
var clear_session_cabins_noperson_info = "<?php echo Url::toRoute(['clearsessioncabinsnopersoninfo']);?>";
var check_passport_info = "<?php echo Url::toRoute(['checkpassportinfo']);?>";
var voyage_code = "<?php echo $voyage_result['voyage_code']?>";
</script>
<div id="fillInfo" class="main">
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
									<input type="text" name="contact_name" value="<?php echo isset($session_cabins_person_info_basic['name'])?$session_cabins_person_info_basic['name']:'';?>">
								</label>
							</p>
							<p>
								<label>
									<span class="name">Email</span>
									<input type="text" name="contact_email" value="<?php echo isset($session_cabins_person_info_basic['email'])?$session_cabins_person_info_basic['email']:'';?>">
								</label>
							</p>
							<p>
								<label>
									<span class="name">手机号码</span>
									<input type="text" name="contact_phone" value="<?php echo isset($session_cabins_person_info_basic['phone'])?$session_cabins_person_info_basic['phone']:'';?>">
								</label>
							</p>
						</div>
					</div>
					<input type="hidden" value="<?php echo isset(Yii::$app->user->identity->id)?1:0;?>" name="is_login" />
					<div class="box">
					<?php foreach ($cabins_arr as $num=>$row){?>
					<div class="cabins_class" type_code="<?php echo $row['type_code'] ?>" >
						<h2><?php echo $cabins_type_name[$row['type_code']]?></h2>
						<?php for($i=0;$i<$row['adult'];$i++){?>
						<div class="formBox adult_person_div">
							<div class="title">
								<h3>乘客<?php echo ($i+1)?><em class="color1">(成人)</em></h3>
								<div class="selectBox">
									<label class="r">
										<span class="checkbox"><span class="icon-checkmark"></span><input <?php echo isset($session_cabins_person_info[$row['type_code']][$i]['keep_contact'])?($session_cabins_person_info[$row['type_code']][$i]['keep_contact']==1?"checked='checked'":""):"";?> type="checkbox" name="keep_contact[]"></span>
										<span>保存到常用旅客</span>
									</label>
								</div>
							</div>
							<div class="content">
								<p>
									<span class="name"><span>中文姓名</span></span>
									<span class="input"><input type="text" name="full_name[]" class="halfWidth" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['full_name'])?$session_cabins_person_info[$row['type_code']][$i]['full_name']:'';?>"></span>
									<a href="#" class="color halfWidth" style="margin-right: -1px;">填写范例</a>
									
								</p>
								<p>
									<span class="name"><span>英文姓名</span></span>
									<span class="input">
										<input type="text" name="last_name[]" placeholder="姓/Last Name" class="halfWidth" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['last_name'])?$session_cabins_person_info[$row['type_code']][$i]['last_name']:'';?>" >
										<input type="text" name="first_name[]" placeholder="名/First Name" class="halfWidth" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['first_name'])?$session_cabins_person_info[$row['type_code']][$i]['first_name']:'';?>" >
									</span>
								</p>
								<p>
									<span class="name"><span class="must">性别</span></span>
									<span class="input">
										<label class="halfWidth">
											<input type="radio" class="sex" <?php echo isset($session_cabins_person_info[$row['type_code']][$i]['sex'])?($session_cabins_person_info[$row['type_code']][$i]['sex']==1?"checked='checked'":""):"checked='checked'";?> name="<?php echo $row['type_code'];?>_sex_<?php echo $i;?>[]" value="1">
											<span>男</span>
										</label>
										<label class="halfWidth">
											<input type="radio" class="sex" <?php echo isset($session_cabins_person_info[$row['type_code']][$i]['sex'])?($session_cabins_person_info[$row['type_code']][$i]['sex']==2?"checked='checked'":""):"";?> name="<?php echo $row['type_code'];?>_sex_<?php echo $i;?>[]" value="2">
											<span>女</span>
										</label>
									</span>
								</p>
								<p>
									<span class="name"><span>出生日期</span></span>
									<span class="input"><input type="text" name="birth[]"  readonly value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['birth'])?$session_cabins_person_info[$row['type_code']][$i]['birth']:'01/01/1980';?>" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',minDate: '1901-01-01', maxDate: '1998-07-16'})"></span>
								</p>
								<p>
									<span class="name"><span>手机号</span></span>
									<span class="input"><input type="text" name="phone[]" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['phone'])?$session_cabins_person_info[$row['type_code']][$i]['phone']:'';?>" ></span>
								</p>
								<p>
									<span class="name"><span>国籍</span></span>
									<span class="input"><input type="text" name="nationality[]" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['nationality'])?$session_cabins_person_info[$row['type_code']][$i]['nationality']:'';?>" ></span>
								</p>
								<p>
									<span class="name">护照</span>
									<span class="input">
										<input type="text" class="passport_check" name="paper_num[]" placeholder="证件号码" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['paper_num'])?$session_cabins_person_info[$row['type_code']][$i]['paper_num']:'';?>">
									</span>
								</p>
								<p>
									<span class="name">证件有效期</span>
									<span class="input">
										<input type="text" name="paper_date[]" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',minDate: '%y-#{%M+6}-%d', maxDate: '#{%y+20}-#{%M+6}-%d'})"  value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['paper_date'])?$session_cabins_person_info[$row['type_code']][$i]['paper_date']:'';?>" >
									</span>
								</p>
								<p>
									<span class="name">出生地</span>
									<input type="text" name="birth_place[]" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['birth_place'])?$session_cabins_person_info[$row['type_code']][$i]['birth_place']:'';?>" >
								</p>
								<p>
									<span class="name">签发地</span>
									<input type="text" name="issue_place[]" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['issue_place'])?$session_cabins_person_info[$row['type_code']][$i]['issue_place']:'';?>" >
								</p>
							</div>
						</div>
						<?php }?>
						<?php if((int)$row['children'] >0){
							for($j=0;$j<$row['children'];$j++){ $i=((int)$j+(int)$row['adult']+1);?>
						<div class="formBox children_person_div" >
							<div class="title">
								<h3>乘客<?php echo $i?><em class="color1">(儿童)</em></h3>
								<div class="selectBox">
									<label class="r">
										<span class="checkbox"><span class="icon-checkmark"></span><input type="checkbox" <?php echo isset($session_cabins_person_info[$row['type_code']][$i]['keep_contact'])?($session_cabins_person_info[$row['type_code']][$i]['keep_contact']==1?"checked='checked'":""):"";?> name="c_keep_contact[]"></span>
										<span>保存到常用旅客</span>
									</label>
								</div>
							</div>
							<div class="content">
								<p>
									<span class="name"><span>中文姓名</span></span>
									<span class="input"><input type="text" name="c_full_name[]" class="halfWidth" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['full_name'])?$session_cabins_person_info[$row['type_code']][$i]['full_name']:'';?>"></span>
									<a href="#" class="color halfWidth">填写范例</a>
								</p>
								<p>
									<span class="name"><span>英文姓名</span></span>
									<span class="input">
										<input type="text" name="c_last_name[]" placeholder="姓/Last Name" class="halfWidth" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['last_name'])?$session_cabins_person_info[$row['type_code']][$i]['last_name']:'';?>">
										<input type="text" name="c_first_name[]" placeholder="名/First Name" class="halfWidth" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['first_name'])?$session_cabins_person_info[$row['type_code']][$i]['first_name']:'';?>">
									</span>
								</p>
								<p>
									<span class="name"><span class="must">性别</span></span>
									<span class="input">
										<label class="halfWidth">
											<input type="radio" class="c_sex" <?php echo isset($session_cabins_person_info[$row['type_code']][$i]['sex'])?($session_cabins_person_info[$row['type_code']][$i]['sex']==1?"checked='checked'":""):"checked='checked'";?>  name="<?php echo $row['type_code'];?>_c_sex_<?php echo $j;?>[]" value='1'>
											<span>男</span>
										</label>
										<label class="halfWidth">
											<input type="radio" class="c_sex" <?php echo isset($session_cabins_person_info[$row['type_code']][$i]['sex'])?($session_cabins_person_info[$row['type_code']][$i]['sex']==2?"checked='checked'":""):"";?> name="<?php echo $row['type_code'];?>_c_sex_<?php echo $j;?>[]" value='2'>
											<span>女</span>
										</label>
									</span>
								</p>
								<p>
									<span class="name"><span>出生日期</span></span>
									<span class="input"><input type="text" name="c_birth[]"  readonly value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['birth'])?$session_cabins_person_info[$row['type_code']][$i]['birth']:'17/04/2007';?>" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',minDate: '1998-07-17',maxDate: '%y-#{%M-5}-%d'})"></span>
								</p>
								<p>
									<span class="name"><span>手机号</span></span>
									<span class="input"><input type="text" name="c_phone[]" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['phone'])?$session_cabins_person_info[$row['type_code']][$i]['phone']:'';?>"></span>
								</p>
								<p>
									<span class="name"><span>国籍</span></span>
									<span class="input"><input type="text" name="c_nationality[]" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['nationality'])?$session_cabins_person_info[$row['type_code']][$i]['nationality']:'';?>"></span>
								</p>
								<p>
									<span class="name">护照号</span>
									<span class="input">
										<input type="text" class="passport_check" name="c_paper_num[]" placeholder="证件号码"  value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['paper_num'])?$session_cabins_person_info[$row['type_code']][$i]['paper_num']:'';?>">
									</span>
								</p>
								<p>
									<span class="name">证件有效期</span>
									<span class="input">
										<input type="text" name="c_paper_date[]" readonly onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',minDate: '%y-#{%M+6}-%d', maxDate: '#{%y+20}-#{%M+6}-%d'})" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['paper_date'])?$session_cabins_person_info[$row['type_code']][$i]['paper_date']:'';?>" >
									</span>
								</p>
								<p>
									<span class="name">出生地</span>
									<input type="text" name="c_birth_place[]" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['birth_place'])?$session_cabins_person_info[$row['type_code']][$i]['birth_place']:'';?>" >
								</p>
								<p>
									<span class="name">签发地</span>
									<input type="text" name="c_issue_place[]" value="<?php echo isset($session_cabins_person_info[$row['type_code']][$i]['issue_place'])?$session_cabins_person_info[$row['type_code']][$i]['issue_place']:'';?>" >
								</p>
								
							</div>
						</div>
						<?php }}?>
						</div>
					<?php }?>
					</div>
					</form>
					<div class="btnBox clearfix">
						<a href="<?php echo Url::toRoute(['selectroom']).'&voyage_code='.$voyage_result['voyage_code'];?>" class="btn1 l"><上一步</a>
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
							<!-- <tr>
								<td>儿童优惠<em>减</em></td>
								<td>1份</td>
								<td>-￥4799</td>
							</tr>
							<tr>
								<td>日本免签船舶观光上陆许可证（适用邮轮，上海送签）</td>
								<td>3份</td>
								<td>已含</td>
							</tr> -->
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
	
	<div class="shadow"></div>
	<div class="loginBox">
		<h3>会员登录预定</h3>
		<div class="loginForm">
			<p>
				<label>
					<span>登录名：</span>
					<input type="text" name="username" placeholder="用户名/卡号/手机/邮箱">
				</label>
				<span class="wrong">
					
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
				<span class="checkbox"><span class="icon-checkmark"></span><input value="1" type="checkbox" name="checked"></span>
				<span>30天内自动登录</span>
			</label>
			<a href="<?php echo Url::toRoute(['/route/register'])?>" class="color r">免费注册</a>
		</p>
		<!-- <p class="wrong">
			登录名或密码错误
		</p> -->
		<p class="btnBox">
			<input type="button" value="登录" class="btn2">
		</p>
		<a href="#" class="close">×</a>
	</div>
	
</div>

<script type="text/javascript">
window.onload = function(){
	$(".selectBox .checkbox input").on('click',function() {
		var is_login = $("input[name='is_login']").val();
		if ($(this).prop("checked") && (parseInt(is_login) == 0)) {
			<?php if(!isset(Yii::$app->user->identity->id)) {?>
			
				$(".shadow").show();
				$(".loginBox").show();
				$(this).removeClass('checked');
				$(this).siblings("span").css("display","none");
				return false;
			<?php }?>
			 
		}
	});

	// 点击关闭登录弹窗
	$(".loginBox .close").on("click",function() {
		$(".shadow").hide();
		$(".loginBox").hide();
	});


	$(document).on('click',".loginBox input[type='button']:first-child",function(){
		
		var username = $(this).parents(".loginBox").find("input[name='username']").val();
		var password = $(this).parents(".loginBox").find("input[name='password']").val();
		var checked = $(this).parents(".loginBox").find("input[name='checked']").is(':checked');
		var _csrf = '<?php echo Yii::$app->request->csrfToken?>';
		
		if(checked == true){var check="&LoginForm[rememberMe]=1";}else{var check='';}
		$.ajax({
		    url:"<?php echo Url::toRoute(['site/login']);?>",
		    type:'post',
		    async:false,
		    data:'LoginForm[username]='+username+'&LoginForm[password]='+password+check+'&_csrf='+_csrf+'&act=3',
		 	dataType:'json',
		 	success:function(data){
			 	if(data == false){
					$(".wrong").html('登录失败，账号或密码错误');
			 	}else{
			 		$("input[name='is_login']").val('1');
			 		$(".shadow").hide();
					$(".loginBox").hide();
				}
		 		
			}
			
		});
		
	});
}
</script>