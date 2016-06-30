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
	</ul>
	<div class="tab_content">
		<!-- first tab -->	
		<div class="active">
			<div id="service_write" class="pop-ups write">
				<p>
					<label>
						<span><?php echo yii::t('app','Cabin Type')?>:</span>
						<select id="changetypecode">
						<?php foreach ($cabin_type as $k=>$v):?>
						<option value="<?php echo $v['type_code']?>" <?php echo $v['type_code']==$_GET['cabin_type_code']?"selected='selected'":''?>><?php echo $v['type_code']?></option>
						<?php endforeach;?>
						</select>
					</label>
				</p>
				<p>
					<label>
						<span><?php echo yii::t('app','Room No')?>:</span>
						<select id="changecabinname">
						<option value="<?php echo isset($_GET['cabin_name'])?$_GET['cabin_name']:''?>"><?php echo isset($_GET['cabin_name'])?$_GET['cabin_name']:''?>(own)</option>
							<?php foreach ($changcabin as $k=>$v):?>
							<option value="<?php echo $v['cabin_name']?>"><?php echo $v['cabin_name']?></option>
							<?php endforeach;?>
						</select>
					</label>
				</p>
				<div class="pop-ups write">
					<p>
						<h4>Price:</h4>
					</p>
					
					<p>
						<span><?php echo yii::t('app','Cabin Price')?>:<?php $cabin_price=isset($_GET['cabin_price'])?$_GET['cabin_price']:0; echo $cabin_price;?></span>
					</p>
					<p>
						<span><?php echo yii::t('app','Taxes')?>: <?php $tax_price=isset($_GET['tax_price'])?$_GET['tax_price']:0; echo $tax_price;?></span>
					</p>
					<p>
						<span><?php echo yii::t('app','Port Expenses')?>:<?php 
						if ($price){
							$t=0;
							$port=0;
							foreach ($price as $k=>$v){
								if($v['price_type']==1){
									$t=1;
									$port=isset($v['additional_price'])?$v['additional_price']:0;
									echo $port;
								}
							}
							if ($t==0){
								$port=0;
								echo $port;
							}
						}
						else{
							$port=0;
							echo $port;
						}
						?></span>
					</p>
					<p>
						<span><?php echo yii::t('app','Additional Price')?>:<?php 
						if ($price){
							$additional=0;
							$t=0;
							foreach ($price as $k=>$v){
								if($v['price_type']==2){
									$t=1;
									$additional=isset($v['additional_price'])?$v['additional_price']:0;
									echo $additional;
								}
							}
							if ($t==0){
								$additional=0;
								echo $additional;
							}
						}
						else{
						$additional=0;
						echo $additional;
						}
						?></span>
					</p>
					<p>
						<span><?php echo yii::t('app','Total Price')?>: <?php echo $cabin_price+$tax_price+$port+$additional; ?></span>
					</p>
				</div>
				<p>
					<label>
						<span>Description:</span>
						<textarea></textarea>
					</label>
				</p>
				<div class="btn">
				<input type="button" id="savechangeclick" value=submit></input>
				<input type="button" value="clear"></input>
		</div>
			</div>
		</div>
		<!-- first tab end -->
		<!-- second tab  -->
		<div>
			<!-- 会员信息 -->
			<div id="memberInfo">
				<h3>Booking person</h3>
				<div class="form">
					<p>
						<label>
							<span><?= \Yii::t('app', 'ID Card') ?>:</span>
							<input type="text" value="<?php
							echo $member['resident_id_card'];
							?>"  name="resident_id_card"  id="resident_id_card" ></input>
						</label>
					

						
						<label>
							<span><?= \Yii::t('app', 'MemeberCard No.') ?>:</span>
							<input type="text" value="<?php
							echo $member['smart_card_number'];
							?>" name="smart_card_number" id="smart_card_number" ></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Membership Grade') ?>:</span>
							<select name="vip_grade" id="vip_grade">
							    <option></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								
							</select>
						</label>
					</p>
					<p>
							<label>
							<span><?= \Yii::t('app', 'Memeber Code') ?>:</span>
							<input readonly="true" style="background-color:#E5E5E5;border:#B9B9B9 1px solid" type="text" name="m_code" id="m_code" value="<?php
							echo $member['m_code'];
							?>" ></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Country') ?>:</span>
							<select name="country_code" id="country_code">
							<option></option>
								<?php  

                            foreach ($country as $row) {

							?>

							<!-- 国家编号 -->

							<!-- 国家名字 -->
								<option value="<?php echo $row['country_code']; ?>"><?php echo $row['country_name']; ?></option>
							<?php
								   }
								   ?>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Membership Status') ?>:</span>
							<select name="member_verification" id="member_verification">
								<option><?= \Yii::t('app', 'inactive') ?></option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Chinese Name') ?>:</span>
							<input type="text" name="m_name" value="<?php
							echo $member['m_name'];
							?>" id="m_name"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Nation') ?>:</span>
							<select >
								<option><?= \Yii::t('app', 'The han nationality') ?> </option>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Balance') ?>:</span>
							<input type="text" name="balance" value="<?php
							echo $member['balance'];
							?>" id="balance"></input>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'First Name') ?>:</span>
							<input type="text" name="first_name"value="<?php
							echo $member['first_name'];
							?>" id="first_name"></input>	
						</label>
						<label>
							<span><?= \Yii::t('app', 'Landline Telephone') ?>:</span>
							<input type="text" name="fixed_telephone" value="<?php
							echo $member['fixed_telephone'];
							?>" id="fixed_telephone"></input>
						</label>
						<!-- <label class="error" id="mylinephone">手机格式不正确</label> -->
						<label>
							<span><?= \Yii::t('app', 'Integral') ?>:</span>
							<!-- 积分 -->
							<input type="text" name="points" value="<?php
							echo $member['points'];
							?>" id="points" ></input>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Last Name') ?>:</span>
							<input type="text" name="last_name"value="<?php
							echo $member['last_name'];
							?>" id="last_name"></input>

						
						</label>
						<label>
							<span><?= \Yii::t('app', 'Phone No.') ?>:</span>
							<input type="text" name="mobile_number" value="<?php
							echo $member['mobile_number'];
							?>" id="mobile_number"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Verify Phone No.') ?>:</span>
							<select>
								<option><?= \Yii::t('app', 'ID Card') ?><?= \Yii::t('app', 'No validation') ?> </option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Birthday') ?>:</span>

							
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy ',lang:'en'})" class="Wdate"  value="<?php
							echo date("d/m/Y",strtotime($member['birthday']));
							?>"  name="birthday" id="birthday"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'E-mail') ?>:</span>
							<input type="email" style="width: 184px;height:24px" name="email" value="<?php
							echo $member['email'];
							?>" id="email"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Verity E-mail') ?>:</span>
							<select>
								<option><?= \Yii::t('app', 'No validation') ?> </option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Gender') ?>:</span>
							<select name="gender" id="gender">
								<option value="M">M</option>
								<option value="F">F</option>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Login Name') ?>:</span>
							<input type="text" disabled="disabled"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Registration IP') ?>:</span>
							<input type="text" disabled="disabled"></input>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Birthplace') ?>:</span>
							<input type="text" name="birth_place" value="<?php
							echo $member['birth_place'];
							?>" id="birth_place"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Password') ?>:</span>
							<input type="password" style="width: 184px;height:24px" name="m_password" value="<?php
							echo $member['m_password'];
							?>" id="m_password"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Registration Date') ?>:</span>
							
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss',lang:'en'})" class="Wdate" value="<?php
							echo date('d/m/Y H:i:s',strtotime($member['create_time']));?>"
							 name="create_time" id="create_time"></input>
						</label>
					</p>
				</div>
				<h3><?= \Yii::t('app', 'Passport') ?></h3>
				<div class="form">
					<p>
						<label>
							<span><?= \Yii::t('app', 'Passport No') ?>:</span>
							<input type="text" readonly="true" style="background-color:#E5E5E5;border:#B9B9B9 1px solid" name="passport_number" value="<?php
							echo $member['passport_number'];
							?>" id="passport_number">
						</label>
						<label>
							<span><?= \Yii::t('app', 'Issuing Country') ?>:</span>
							<select name="post_country_code" id="post_country_code">
							<option></option>

							<?php  

                            foreach ($country as $row) {

							?>
      
								<option value="<?php echo $row['country_code']; ?>"><?php echo $row['country_name']; ?></option>

							<?php
								   }
								   ?>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Issue Place') ?>:</span>
							<input type="text" name="place_issue" value="<?php
							echo $member['place_issue'];?>" id="place_issue" >
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Issue Date') ?>:</span>


							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy ',lang:'en'})" class="Wdate"  value="<?php
							echo date("d/m/Y",strtotime($member['date_issue']));?>" name="date_issue" id="date_issue">
						</label>
						<label>
							<span><?= \Yii::t('app', 'Closing Date') ?>:</span>

							
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',lang:'en'})" class="Wdate"  value="<?php
							echo date("d/m/Y",strtotime($member['date_expire']));?>"   name="date_expire" id='date_expire'>
						</label>
					</p>
				</div>
				<div class="btn">
					<input type="button" value="Save" id="member_edit_save" style="width: 80px;text-align: center;cursor:pointer;">
					<input type="button" value="Back" id="back" >
					
				</div>
			</div>
		</div>
		<!-- second tab  end-->
	</div>
</div>
<!-- content end -->
<script type="text/javascript" src="<?php echo $baseUrl?>js/jquery-2.2.3.min.js"></script>
<script>

	window.onload=function(){
		$("#savechangeclick").click(function(){
			var changetypecode=$("#changetypecode").val();
			var changecabinname=$("#changecabinname").val();
			var cabin_type_code='<?php echo $_GET['cabin_type_code']?>';
			var cabin_name='<?php echo $_GET['cabin_name']?>';
			var voyage_code='<?php echo $_GET['voyage_code']?>';
		         $.ajax({  
		             url: "<?php echo Url::toRoute(['savechangeroom']);?>",
		             data:{changetypecode:changetypecode,changecabinname:changecabinname,cabin_type_code:cabin_type_code,cabin_name:cabin_name,voyage_code:voyage_code},
		             type: 'POST',  
		             dataType: 'json',  
		             timeout: 3000,  
		             beforeSend: LoadFunction, //加载执行方法      
		             error: erryFunction,  //错误执行方法      
		             success: succFunction //成功执行方法      
		         })  
		         function LoadFunction() {  
		             $("#list").html('加载中...');  
		         }  
		         function erryFunction() {  
		             alert("error");  
		         }  
		         function succFunction(tt) {
			       
		        	if(tt==1){
						alert('Option Success');
						location.href="<?php echo Url::toRoute(['free_order_detail']);?>&order_serial_number="+'<?php echo $_GET['order_serial_number']?>';
			        	}
		        	else{
		        		alert('Option Fail');	
		        		location.href="<?php echo Url::toRoute(['free_order_detail']);?>&order_serial_number="+'<?php echo $_GET['order_serial_number']?>';
			        	}
		         }  
			});
		$("#member_edit_save").click(function(){
			var resident_id_card=$("#resident_id_card").val();
			var smart_card_number=$("#smart_card_number").val();
			var vip_grade=$("#vip_grade").val();
			var country_code=$("#country_code").val();
			var member_verification=$("#member_verification").val();
			var m_name=$("#m_name").val();
			var balance=$("#balance").val();
			var first_name=$("#first_name").val();
			var fixed_telephone=$("#fixed_telephone").val();
			var points=$("#points").val();
			var last_name=$("#last_name").val();
			var mobile_number=$("#mobile_number").val();
			var birthday=$("#birthday").val();
			var email=$("#email").val();
			var gender=$("#gender").val();
			var birth_place=$("#birth_place").val();
			var m_password=$("#m_password").val();
			var create_time=$("#create_time").val();
			var passport_number=$("#passport_number").val();
			var post_country_code=$("#post_country_code").val();
			var place_issue=$("#place_issue").val();
			var date_issue=$("#date_issue").val();
			var date_expire=$("#date_expire").val();
			var m_code=$("#m_code").val();
	         $.ajax({
	             url: "<?php echo Url::toRoute(['memberedit']);?>",
	             data:{
	            resident_id_card:resident_id_card,
	            smart_card_number:smart_card_number,
	            vip_grade:vip_grade,
	            country_code:country_code,
	            member_verification:member_verification,
	            m_name:m_name,
	            balance:balance,
	            first_name:first_name,
	            fixed_telephone:fixed_telephone,
	            points:points,
	            last_name:last_name,
	            mobile_number:mobile_number,
	            birthday:birthday,
	            email:email,
	            gender:gender,
	            birth_place:birth_place,
	            m_password:m_password,
	            create_time:create_time,
	            passport_number:passport_number,
	            post_country_code:post_country_code,
	            place_issue:place_issue,
	            date_issue:date_issue,
	            date_expire:date_expire,
	            m_code:m_code,
		             },
	             type: 'POST',  
	             dataType: 'json',  
	             timeout: 3000,  
	             beforeSend: LoadFunction, //加载执行方法      
	             error: erryFunction,  //错误执行方法      
	             success: succFunction //成功执行方法      
	         })  
	         function LoadFunction() {  
	             $("#list").html('加载中...');  
	         }  
	         function erryFunction() {  
	             alert("error");  
	         }  
	         function succFunction(tt) {
		       
	        	if(tt==1){
					alert('Option Success');
					location.href="<?php echo Url::toRoute(['free_order_detail']);?>&order_serial_number="+'<?php echo $_GET['order_serial_number']?>';
		        	}
	        	else{
	        		alert('Option Fail');	
	        		location.href="<?php echo Url::toRoute(['free_order_detail']);?>&order_serial_number="+'<?php echo $_GET['order_serial_number']?>';
		        	}
	         } 
			});
	}
	
</script>
