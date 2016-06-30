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
<style type="text/css">
		#service_write{background-color: #fff;}
		#service_write select { width: 170px; height: 24px;}
		/* 页面排版 */
		.issueTicket_info .form { padding: 1em; border: 1px solid #e0e9f4; background: #fff; }
		.issueTicket_info label span { display: inline-block; width: 120px; text-align: right; }
		.issueTicket_info select { width: 184px; height: 24px; }
		.issueTicket_info .lineSelect select { width: 478px; }
		.issueTicket_info .table { width: 48%; margin-bottom: 1em; }
		.issueTicket_info .btn { margin-top: 1em; }
		#memberInfo label span { width: 140px; }
		/* 校验 */
		.write p { overflow: hidden; }
		.write label { width: 324px; }
		.write label:first-child { float: left; margin-left: 10%; }
		.write label + label { float: right; margin-right: 20%; }
		.write label span { width: 140px; }
		 input.point { outline-color: red; border: 2px solid red; }
		 span.point { width: auto; position: absolute; background: red; padding: 4px 10px; color: #fff; font-weight: bolder; }
    	 span.point:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent red transparent transparent; }
	 	 .selectWidth { width: 164px; }
	</style>
<!-- content start -->
<div class="r content">
	<div class="topNav"><?php echo yii::t('app','Order Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Agent Order')?></a>
	&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Agent OrderDetail')?></a>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app','Cabin Detail')?></a>
	<div class="tab">
	<ul class="tab_title">
		<li class="active"><?php echo yii::t('app','Order Information')?></li>
		<?php for ($i=1;$i<=$membernum['check_in_number'];$i++){?>
		<li><?php echo yii::t('app','Passenger '.$i)?></li>
		<?php }?>
	</ul>
	<div class="tab_content">
		<!-- first tab -->	
		<div class="active">
			<div id="service_write" class="pop-ups write">
				<p>
					<label>
						<span><?php echo yii::t('app','Cabin Type')?>:</span>
						<input type="text" disabled="disabled" value="<?php echo $_GET['cabin_type_code']?>" id="changetypecode"/>
						<!-- <select id="changetypecode">
						<php foreach ($cabin_type as $k=>$v):?>
						<option value="<php echo $v['type_code']>" <php echo $v['type_code']==$_GET['cabin_type_code']?"selected='selected'":''?>><php echo $v['type_code']?></option>
						<php endforeach;?>
						</select> -->
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
						<span><?php echo yii::t('app','Port Expenses')?>:<?php  echo isset($_GET['quayage'])?$_GET['quayage']:0?></span>
					</p>
					<p>
						<span><?php echo yii::t('app','Additional Price')?>:<?php echo isset($_GET['surcharge'])?$_GET['surcharge']:0?></span>
					</p>
					<p>
						<span><?php echo yii::t('app','Total Price')?>: <?php echo $cabin_price+$tax_price+$_GET['quayage']+$_GET['surcharge']; ?></span>
					</p>
				</div>
				<p>
					<label>
						<span>Description:</span>
						<textarea id="description"><?php echo $descinfo['description'] ?></textarea>
					</label>
				</p>
				<div class="btn">
				<input type="button" id="savechangeclick" value="<?php echo yii::t('app','submit')?>"></input>
				<input type="button" id="returnchangeclick" value="<?php echo yii::t('app','clear')?>"></input>
		</div>
			</div>
		</div>
		<!-- first tab end -->
		<!-- second tab  -->
		<?php foreach ($memberinfo as $k=>$v):?>
		<div class="issueTicket_info">
			<!-- 会员信息 -->
			<div id="memberInfo<?php echo $k?>">
				<h3><?php echo yii::t('app','Booking person')?></h3>
				<div class="form">
					<p>
						<label>
							<span><?= \Yii::t('app', 'ID Card') ?>:</span>
							<input type="text" value="<?php
							echo $v['resident_id_card'];
							?>"  name="resident_id_card"  id="resident_id_card<?php echo $k?>" />
						</label>
					

						
						<label>
							<span><?= \Yii::t('app', 'Card No.') ?>:</span>
							<input type="text" value="<?php
							echo $v['smart_card_number'];
							?>" name="smart_card_number" id="smart_card_number<?php echo $k?>" />
						</label>
						<label>
							<span><?= \Yii::t('app', 'Grade') ?>:</span>
							<select name="vip_grade" id="vip_grade<?php echo $k?>">
							    <option value="0" <?php echo $v['vip_grade']==0?"selected='selected'":''?>>0</option>
								<option value="1" <?php echo $v['vip_grade']==1?"selected='selected'":''?>>1</option>
								<option value="2" <?php echo $v['vip_grade']==2?"selected='selected'":''?>>2</option>
								<option value="3" <?php echo $v['vip_grade']==3?"selected='selected'":''?>>3</option>
								
							</select>
						</label>
					</p>
					<p>
							<label>
							<span><?= \Yii::t('app', 'Memeber Code') ?>:</span>
							<input disabled="disabled" type="text" name="m_code" id="m_code<?php echo $k?>" value="<?php
							echo $v['m_code'];
							?>" />
						</label>
						<label>
							<span><?= \Yii::t('app', 'Country') ?>:</span>
							<select name="country_code" id="country_code<?php echo $k?>">
								<?php  

                            foreach ($country as $row) {

							?>

							<!-- 国家编号 -->

							<!-- 国家名字 -->
								<option value="<?php echo $row['country_code']; ?>" <?php echo $row['country_code']==$v['country_code']?"selected='selected'":'' ?>><?php echo $row['country_name']; ?></option>
							<?php
								   }
								   ?>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Status') ?>:</span>
							<select name="member_verification" id="member_verification<?php echo $k?>">
								<option><?= \Yii::t('app', 'inactive') ?></option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Name') ?>:</span>
							<input type="text" name="m_name" value="<?php
							echo $v['m_name'];
							?>" id="m_name<?php echo $k?>"/>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Nation') ?>:</span>
							<select >
								<option><?= \Yii::t('app', 'The han nationality') ?> </option>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Balance') ?>:</span>
							<input type="text" name="balance" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php
							echo $v['balance'];
							?>" id="balance<?php echo $k?>"/>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'First Name') ?>:</span>
							<input type="text" name="first_name"value="<?php
							echo $v['first_name'];
							?>" id="first_name<?php echo $k?>"/>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Landline Phone') ?>:</span>
							<input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" name="fixed_telephone" value="<?php
							echo $v['fixed_telephone'];
							?>" id="fixed_telephone<?php echo $k?>"/>
						</label>
						<!-- <label class="error" id="mylinephone">手机格式不正确</label> -->
						<label>
							<span><?= \Yii::t('app', 'Integral') ?>:</span>
							<!-- 积分 -->
							<input type="text" name="points" value="<?php
							echo $v['points'];
							?>" id="points<?php echo $k?>" />
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Last Name') ?>:</span>
							<input type="text" name="last_name"value="<?php
							echo $v['last_name'];
							?>" id="last_name<?php echo $k?>"/>

						
						</label>
						<label>
							<span><?= \Yii::t('app', 'Phone No.') ?>:</span>
							<input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" name="mobile_number" value="<?php
							echo $v['mobile_number'];
							?>" id="mobile_number<?php echo $k?>"/>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Verify Phone') ?>:</span>
							<select>
								<option><?= \Yii::t('app', 'ID Card') ?><?= \Yii::t('app', 'No validation') ?> </option>
							</select>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Birthday') ?>:</span>

							
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy ',lang:'en'})" class="Wdate"  value="<?php
							echo date("d/m/Y",strtotime($v['birthday']));
							?>"  name="birthday" id="birthday<?php echo $k?>"/>
						</label>
						<label>
							<span><?= \Yii::t('app', 'E-mail') ?>:</span>
							<input type="text"  name="email" value="<?php
							echo $v['email'];
							?>" id="email<?php echo $k?>"/>
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
							<select name="gender" id="gender<?php echo $k?>">
								<option value="M" <?php echo $v['gender']=='M'?"selected='selected'":''?>>M</option>
								<option value="F" <?php echo $v['gender']=='F'?"selected='selected'":''?>>F</option>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Login Name') ?>:</span>
							<input type="text" disabled="disabled"/>
						</label>
						<label>
							<span><?= \Yii::t('app', 'IP') ?>:</span>
							<input type="text" disabled="disabled"></input>
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Birthplace') ?>:</span>
							<input type="text" name="birth_place" value="<?php
							echo $v['birth_place'];
							?>" id="birth_place<?php echo $k?>"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Password') ?>:</span>
							<input type="password" style="width: 184px;height:24px" name="m_password" value="<?php
							echo $v['m_password'];
							?>" id="m_password<?php echo $k?>"></input>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Registration') ?>:</span>
							
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy HH:mm:ss',lang:'en'})" class="Wdate" value="<?php
							echo date('d/m/Y H:i:s',strtotime($v['create_time']));?>"
							 name="create_time" id="create_time<?php echo $k?>"></input>
						</label>
					</p>
				</div>
				<h3><?= \Yii::t('app', 'Passport') ?></h3>
				<div class="form">
					<p>
						<label>
							<span><?= \Yii::t('app', 'Passport No') ?>:</span>
							<input type="text" disabled="disabled" name="passport_number" value="<?php
							echo $v['passport_number'];
							?>" id="passport_number<?php echo $k?>">
						</label>
						<label>
							<span><?= \Yii::t('app', 'Issuing Country') ?>:</span>
							<select name="post_country_code" id="post_country_code<?php echo $k?>">
							<?php  

                            foreach ($country as $row) {

							?>
      
								<option value="<?php echo $row['country_code']; ?>" <?php echo $row['country_code']==$v['post_country_code']?"selected='selected'":'' ?>><?php echo $row['country_name']; ?></option>

							<?php
								   }
								   ?>
							</select>
						</label>
						<label>
							<span><?= \Yii::t('app', 'Issue Place') ?>:</span>
							<input type="text" name="place_issue" value="<?php
							echo $v['place_issue'];?>" id="place_issue<?php echo $k?>" >
						</label>
					</p>
					<p>
						<label>
							<span><?= \Yii::t('app', 'Issue Date') ?>:</span>


							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy ',lang:'en'})" class="Wdate"  value="<?php
							echo date("d/m/Y",strtotime($v['date_issue']));?>" name="date_issue" id="date_issue<?php echo $k?>">
						</label>
						<label>
							<span><?= \Yii::t('app', 'Closing Date') ?>:</span>

							
							<input type="text" onfocus="WdatePicker({dateFmt:'dd/MM/yyyy',lang:'en'})" class="Wdate"  value="<?php
							echo date("d/m/Y",strtotime($v['date_expire']));?>"   name="date_expire" id='date_expire<?php echo $k?>'>
						</label>
					</p>
				</div>
				<div class="btn">
					<input type="button" value="<?php echo yii::t('app','Save')?>" onclick="saveditmember('<?php echo $k?>');" style="width: 80px;text-align: center;cursor:pointer;">
					<input type="button" value="<?php echo yii::t('app','Back')?>" class="back" >
					
				</div>
			</div>
		</div>
		<?php endforeach;?>
		<!-- second tab  end-->
	</div>
</div>
<!-- content end -->
<script type="text/javascript" src="<?php echo $baseUrl?>js/jquery-2.2.3.min.js"></script>
<script>

	window.onload=function(){
		$("#returnchangeclick").click(function(){/* orderinformation取消按钮 */
			location.href="<?php echo Url::toRoute(['agentorder']);?>";
			});
		$(".back").click(function(){//会员取消按钮
			location.href="<?php echo Url::toRoute(['agentorder']);?>";
			});
		/* 数据校验 */
			$("input[type=text]").each(function(index){//输入框不能为空
			$(this).focus(function(){
				$(this).removeClass("point");
				$(this).siblings("span").eq(1).remove();
				});
	    	});
		/* *****  */
		$("#savechangeclick").click(function(){
			var changetypecode=$("#changetypecode").val();
			var changecabinname=$("#changecabinname").val();
			var description=$("#description").val();
			var cabin_type_code='<?php echo $_GET['cabin_type_code']?>';
			var cabin_name='<?php echo $_GET['cabin_name']?>';
			var voyage_code='<?php echo $_GET['voyage_code']?>';
		         $.ajax({  
		             url: "<?php echo Url::toRoute(['savechangeroom']);?>",
		             data:{changetypecode:changetypecode,changecabinname:changecabinname,cabin_type_code:cabin_type_code,cabin_name:cabin_name,voyage_code:voyage_code,description:description},
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
						location.href="<?php echo Url::toRoute(['agentorderdetail']);?>&order_serial_number="+'<?php echo $_GET['order_serial_number']?>';
			        	}
		        	else{
		        		alert('Option Fail');	
		        		location.href="<?php echo Url::toRoute(['agentorderdetail']);?>&order_serial_number="+'<?php echo $_GET['order_serial_number']?>';
			        	}
		         }  
			});

	}
	function saveditmember(num){
			/* 数据校验 */
			var t=1;
	    	$("#memberInfo"+num+" input[type=text]").not("input[disabled=disabled]").each(function(index){//输入框不能为空
	    		if($(this).val()==''){
	    			if(!$(this).hasClass("point")) {
	    				$(this).addClass("point");
	                	$(this).parent().append("<span class='point'><?php echo yii::t('app','A required field cannot be empty...')?></span>");
	    			}
	    			t=0;
	    		}
	    	});
	    	var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
				 var email= $("#memberInfo"+num+" #email"+num).val();//邮箱验证
				 if(!reg.test(email)){
						if(!$("#memberInfo"+num+" #email"+num).hasClass("point")) {
		    				$("#memberInfo"+num+" #email"+num).addClass("point");
		                	$("#memberInfo"+num+" #email"+num).parent().append("<span class='point'><?php echo yii::t('app','Email address format is not correct ...')?></span>");
		    			}
		    			t=0;
				 }
	    	/* *************** */
	    	if(t==1){
			var resident_id_card=$("#resident_id_card"+num).val();
			var smart_card_number=$("#smart_card_number"+num).val();
			var vip_grade=$("#vip_grade"+num).val();
			var country_code=$("#country_code"+num).val();
			var member_verification=$("#member_verification"+num).val();
			var m_name=$("#m_name"+num).val();
			var balance=$("#balance"+num).val();
			var first_name=$("#first_name"+num).val();
			var fixed_telephone=$("#fixed_telephone"+num).val();
			var points=$("#points"+num).val();
			var last_name=$("#last_name"+num).val();
			var mobile_number=$("#mobile_number"+num).val();
			var birthday=$("#birthday"+num).val();
			var email=$("#email"+num).val();
			var gender=$("#gender"+num).val();
			var birth_place=$("#birth_place"+num).val();
			var m_password=$("#m_password"+num).val();
			var create_time=$("#create_time"+num).val();
			var passport_number=$("#passport_number"+num).val();
			var post_country_code=$("#post_country_code"+num).val();
			var place_issue=$("#place_issue"+num).val();
			var date_issue=$("#date_issue"+num).val();
			var date_expire=$("#date_expire"+num).val();
			var m_code=$("#m_code"+num).val();
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
					location.href="<?php echo Url::toRoute(['agentorderdetail']);?>&order_serial_number="+'<?php echo $_GET['order_serial_number']?>';
		        	}
	        	else{
	        		alert('Option Fail');
	        		location.href="<?php echo Url::toRoute(['agentorderdetail']);?>&order_serial_number="+'<?php echo $_GET['order_serial_number']?>';
		        	}
	         	} 
			}
		}
</script>
