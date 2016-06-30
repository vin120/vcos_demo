<?php
$this->title = 'Org Management';


use app\modules\orgmanagement\themes\basic\myasset\ThemeAsset;

use yii\helpers\Url;

ThemeAsset::register($this);
$baseUrl = $this->assetBundles[ThemeAsset::className()]->baseUrl . '/';


//$assets = '@app/modules/membermanagement/themes/basic/static';
//$baseUrl = Yii::$app->assetManager->publish($assets);

?>

	 <script type="text/javascript" src="<?php echo $baseUrl;?>js/jquery-ui.min.js"></script>
	
	  <script type="text/javascript" src="<?php echo $baseUrl;?>js/jquery.validate.js"></script>
	
	 <script type="text/javascript" src="<?php echo $baseUrl;?>js/jquery-2.2.2.min.js"></script>
	  <script type="text/javascript" src="<?php echo $baseUrl;?>js/My97DatePicker/WdatePicker.js"></script>
 	<style type="text/css">
		#issueTicket_info .form { padding: 1em; border: 1px solid #e0e9f4; background: #fff; }
		#issueTicket_info label span { display: inline-block; width: 100px; text-align: right; }
		#issueTicket_info select { width: 184px; height: 24px; }
		#issueTicket_info .lineSelect select { width: 478px; }
		#issueTicket_info .table { width: 48%; margin-bottom: 1em; }
		#issueTicket_info .btn { margin-top: 1em; }
		#memberInfo label span { width: 140px; }
		#member_add_form input.point { outline-color: #fe5d5d; border: 2px solid #fe5d5d; }
		#member_add_form span.point { width: auto; position: absolute; background: #fe5d5d; padding: 4px 10px; color: #fff; font-weight: bolder; }
    	#member_add_form span.point:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent #fe5d5d transparent transparent; }
	</style>
<style>
	#member_add_form input.point { outline-color: #fe5d5d; border: 2px solid #fe5d5d; }
	#member_add_form label.error { width: auto; position: absolute; background: #fe5d5d; padding: 4px 10px; color: #fff; font-weight: bolder; }
    #member_add_form label.error:before { content: ""; position: absolute; left: -10px; top: 4px; width: 0; height: 0; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent #fe5d5d transparent transparent; }
</style>
<!-- content start -->
		<div class="r content" id="issueTicket_info">
			<div class="topNav"><?php echo yii::t('app', 'Org Manage')?>&nbsp;&gt;&gt;&nbsp;<a href="#"><?php echo yii::t('app', 'User')?></a></div>
			<form action="<?= Url::to(['user_addorinsert']);?>" method="post" id="member_add_form">
			
			<div id="memberInfo">
				<h3><?php echo yii::t('app', 'Base Info')?></h3>
				<div class="form">
			
				<input name="employee_code" type="hidden" value="<?php echo isset($_GET['id'])?$_GET['id']:''?>">
					<p>
						<label>
							<span><?php echo yii::t('app', 'Employee Code')?>:</span>
							<input type="text" style="background-color:#E5E5E5;border:#B9B9B9 1px solid"   readonly="readonly" value="<?php echo isset($_GET['id'])?$_GET['id']:''?>"  id="employee_code" ></input>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Card Number')?>:</span>
							<input type="text"  name="employee_card_number" value="<?php echo isset($info[0]['employee_card_number'])?$info[0]['employee_card_number']:''?>" id="employee_card_number" ></input>
						<span class="point" style="display:none" ><?php echo yii::t('app','Required fields cannot be empty')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Employee Status')?>:</span>
							<select name="employee_status" id="employee_status">
							<?php foreach ($employee_status as $k=>$v):?>				
							<option value="<?=$k?>"  <?= isset($info[0]['employee_status'])&&($k==$info[0]['employee_status'])?"selected='selected'":'' ?>><?php echo yii::t('vcos', $v);?></option>
							<?php endforeach;?>
							</select>
						</label>
					</p>
					<p>
							<label>
							<span><?php echo yii::t('app', 'Employee Name')?>:</span>
							<input type="text" name="full_name" value="<?php echo isset($info[0]['full_name'])?$info[0]['full_name']:''?>" id="full_name" ></input>
					       <span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'First Name')?>:</span>
							<input type="text" name=first_name id="first_name" value="<?php echo isset($info[0]['first_name'])?$info[0]['first_name']:''?>" ></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Last Name')?>:</span>
							<input type="text" name="last_name" id="last_name" value="<?php echo isset($info[0]['last_name'])?$info[0]['last_name']:''?>" ></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Country Code')?>:</span>
							<select name="country_code">
							<?php foreach ($countryinfo as $k=>$v):?>				
							<option value="<?=$v['country_code']?>" <?=isset($info[0]['country_code'])&&($v['country_code']==$info[0]['country_code'])?"selected='selected'":'' ?>><?php echo yii::t('app', $v['country_name'])?></option>
							<?php endforeach;?>
							</select>
						</label>
						<!-- <label>民族
							<span>Nation Code:</span>
							<select name="nation_code">
								<option>1</option>
							</select>
						</label>  -->
						<label>
							<span><?php echo yii::t('app', 'Political Status')?>:</span>
							<select  name="political_status"  id="political_status">
								<?php foreach ($politicalstatus as $k=>$v):?>				
								<option value="<?=$k?>" <?=isset($info[0]['political_status'])&&($k==$info[0]['political_status'])?"selected='selected'":'' ?>><?php echo yii::t('vcos', $v)?></option>
								<?php endforeach;?>
								</select>
						
						</label>
					</p>
					<p>
						<label>
							<span ><?php echo yii::t('app', 'Gender')?>:</span>	
						          <label style="margin-left:25px"> <?php echo yii::t('app', 'M')?></label>
						          <input name="gender" value="M" type="radio" checked='checked'/>		        
						          <label style="margin-left: 85px">   <?php echo yii::t('app', 'F')?></label>
						          <input name="gender" type="radio" value="F"  <?=isset($info[0]['gender'])&&('F'==$info[0]['gender'])?"checked='checked'":'' ?>/>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Card Type')?>:</span>
							<select name="card_type">
						<?php foreach ($cardtype as $k=>$v):?>				
						<option value="<?=$k?>" <?=isset($info[0]['card_type'])&&($k==$info[0]['card_type'])?"selected='selected'":'' ?>><?php echo yii::t('vcos', $v)?></option>
						<?php endforeach;?>
						</select>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Other Card Number')?>:</span>
							<!-- 积分 -->
							<input type="text" name="other_card_number" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php echo isset($info[0]['other_card_number'])?$info[0]['other_card_number']:''?>"  id="other_card_number" ></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Marry Status')?>:</span>
							
							<select name="marry_status">
								<?php foreach ($marrystatus as $k=>$v):?>				
								<option value="<?=$k?>" <?=isset($info[0]['marry_status'])&&($k==$info[0]['marry_status'])?"selected='selected'":'' ?>><?php echo yii::t('vcos', $v)?></option>
								<?php endforeach;?>
						</select>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Health Status')?>:</span>
							
							<select name="health_status">
							<?php foreach ($healthstatus as $k=>$v):?>				
							<option value="<?=$k?>" <?=isset($info[0]['health_status'])&&($k==$info[0]['health_status'])?"selected='selected'":'' ?>><?php echo yii::t('vcos', $v)?></option>
							<?php endforeach;?>
							</select>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Height')?>:</span>
							<input type="text" name="height" value="<?php echo isset($info[0]['height'])?$info[0]['height']:''?>" >
							<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Weight')?>:</span>
							<input type="text"  name="weight" id="weight"  value="<?php echo isset($info[0]['weight'])?$info[0]['weight']:''?>"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Shoe Size')?>:</span>
							<input type="text" name="shoe_size"  id="shoe_size" value="<?php echo isset($info[0]['shoe_size'])?$info[0]['shoe_size']:''?>"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Blood Type')?>:</span>
							<select name="blood_type">
							<?php foreach ($bloodtype as $k=>$v):?>				
							<option value="<?=$k?>" <?=isset($info[0]['blood_type'])&&($k==$info[0]['blood_type'])?"selected='selected'":'' ?>><?php echo yii::t('vcos', $v)?></option>
							<?php endforeach;?>
							</select>
						</label>
					</p>
					<p>
							<label>
							<span><?php echo yii::t('app', 'Mobile Num')?>:</span>
							<input type="text" name="mobile_num"  value="<?php echo isset($info[0]['mobile_num'])?$info[0]['mobile_num']:''?>" id="mobile_num"></input>
						<span class="point" id="mobile_num1" style="display:none"><?php echo yii::t('vcos','Required fields cannot be empty ')?></span>
						<span class="point" id="mobile_num2" style="display:none"><?php echo yii::t('vcos','Mobile phone format is not correct  ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Working Life')?>:</span>
							<input type="text"  NAME="working_life" value="<?php echo isset($info[0]['working_life'])?$info[0]['working_life']:''?>"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Major')?>:</span>
							<input type="text" NAME="major" value="<?php echo isset($info[0]['major'])?$info[0]['major']:''?>"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Education')?>:</span>
							<select name="education">
							<?php foreach ($educat as $k=>$v):?>				
							<option value="<?=$k?>" <?=isset($info[0]['education'])&&($k==$info[0]['education'])?"selected='selected'":'' ?>><?php echo yii::t('vcos', $v)?></option>
							<?php endforeach;?>
							</select>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Foreign Language')?>:</span>
							<input type="text"  autocomplete="off" name="foreign_language"  id="foreign_language" value="<?php echo isset($info[0]['foreign_language'])?$info[0]['foreign_language']:''?>"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Birth Place')?>:</span>
						<input type="text"  name="birth_place" id="birth_place" value="<?php echo isset($info[0]['birth_place'])?$info[0]['birth_place']:''?>"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
					</p>
					<p>
						<label>
							<span><?php echo yii::t('app', 'Date Of Birth')?>:</span>
							<input type="text" name="date_of_birth" value="<?php echo isset($info[0]['date_of_birth'])?date("d/m/Y H:i:s",strtotime($info[0]['date_of_birth'])):''?>" onfocus="WdatePicker({dateFmt:'dd-MM-yyyy HH:mm:ss ',lang:'en'})" class="Wdate"   id="date_of_birth"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Dormitory Num')?>:</span>
							<input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" name="dormitory_num" value="<?php echo isset($info[0]['dormitory_num'])?$info[0]['dormitory_num']:''?>"  id="dormitory_num"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Telephone Num')?>:</span>
						<input type="text"  name="telephone_num" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="<?php echo isset($info[0]['telephone_num'])?$info[0]['telephone_num']:''?>" id="telephone_num"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						
					</p>
					<p>
					<label>
							<span><?php echo yii::t('app', 'Resident Id Card')?>:</span>
						<input type="text"  name="resident_id_card" value="<?php echo isset($info[0]['resident_id_card'])?$info[0]['resident_id_card']:''?>" id="resident_id_card"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Mailing Address')?>:</span>
						<input type="text"  name="mailing_address" value="<?php echo isset($info[0]['mailing_address'])?$info[0]['mailing_address']:''?>" id="mailing_address"></input>
						<span class="point" style="display:none" ><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
							<label>
							<span><?php echo yii::t('app', 'Emergency Contact')?>:</span>
						<input type="text"  name="emergency_contact" value="<?php echo isset($info[0]['emergency_contact'])?$info[0]['emergency_contact']:''?>" id="emergency_contact"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						</p>
						<p>
						<label>
							<span><?php echo yii::t('app', 'Emergency Phone')?>:</span>
						<input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"  name="emergency_contact_phone" value="<?php echo isset($info[0]['emergency_contact_phone'])?$info[0]['emergency_contact_phone']:''?>" id="emergency_contact_phone"></input>
						<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Department')?>:</span>
						<select name="department_id">
							<?php foreach ($departmentinfo as $k=>$v):?>				
							<option value="<?=$v['department_id']?>" <?=isset($info[0]['department_id'])&&($v['department_id']==$info[0]['department_id'])?"selected='selected'":'' ?>><?php echo yii::t('app', $v['department_name'])?></option>
							<?php endforeach;?>
						</select>
						</label>
						<label>
							<span><?php echo yii::t('app', 'Date Of Entry')?>:</span>
							<input type="text" name="date_of_entry" value="<?php echo isset($info[0]['date_of_entry'])?date("d/m/Y H:i:s",strtotime($info[0]['date_of_entry'])):''?>" onfocus="WdatePicker({dateFmt:'dd-MM-yyyy HH:mm:ss ',lang:'en'})" class="Wdate"   id="date_of_entry"></input>
							<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
						</label>
						</p>
						<p>
						<label>
							<span><?php echo yii::t('app', 'Set Member')?>:</span>	
				            <?php echo yii::t('app', 'Yes')?>
				            <input name="m_status" id="m_status" <?=isset($userinfo[0]['m_status'])&&(1==$userinfo[0]['m_status'])?"checked='checked'":'' ?> value="1" type="radio" />		        
				          	<label style="margin-left: 60px">   <?php echo yii::t('app', 'No')?></label>
				            <input name="m_status" type="radio" value="2" <?=!(isset($userinfo[0]['m_status'])&&(1==$userinfo[0]['m_status']))?"checked='checked'":'' ?> />
						</label>
						</p>
				</div>
				<div class="form" id="userinfoform">
				<p>
				<label>
				<span><?php echo yii::t('app', 'UserName')?>:</span>
				<input type="text" name="username" <?php echo isset($userinfo[0]['username'])?"readonly='readonly' style='background-color:#E5E5E5;border:#B9B9B9 1px solid'":''?>  value="<?php echo isset($userinfo[0]['username'])?$userinfo[0]['username']:''?>">
					<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
				</label>
			    <label>
				<span><?php echo yii::t('app', 'PasswordHash')?>:</span>
				<input type="text" name="password_hash" value="<?php echo isset($userinfo[0]['password_hash'])?$userinfo[0]['password_hash']:''?>">
					<span class="point" style="display:none"><?php echo yii::t('app','Required fields cannot be empty ')?></span>
				</label>
				<label>
				<span><?php echo yii::t('app', 'Email')?>:</span>
				<input type="text" name="email" value="<?php echo isset($userinfo[0]['email'])?$userinfo[0]['email']:''?>">
				<span class="point"  style="display:none" id="emailvalidate"><?php echo yii::t('vcos','Email format is not correct')?></span>
				<span class="point"  style="display:none" id="emailvalidate1"><?php echo yii::t('vcos','Email can not be empty')?></span>
				</label>
				</p>
				</div>
				<div class="btn">
					<input type="submit" value="<?php echo yii::t('app', 'Submit')?>" id="member_add" style="width: 80px;text-align: center;cursor:pointer;">
					<input type="button" value="<?php echo yii::t('app', 'Back')?>" id="back" >
				</div>
			</div>
			</form>
			
		</div>
		<!-- content end -->
	<script type="text/javascript">
	
	$(function(){
		 $("input[name=travel_agent_email]").blur(function(){//邮箱判断
			 var reg= new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$");
				 var email= $("input[name=email]").val();//邮箱验证
				 if((!reg.test(email))&&(email!='')){
					$("#emailvalidate").css("display","");
					$(this).addClass("point");
 				 }
			 }).focus(function(){
				  $("#emailvalidate1").css("display","none");
				 $("#emailvalidate").css("display","none");
				 $(this).removeClass("point");
				 });
		var v=$("input[name=m_status]:checked").val();
		if(v==2){
			if($("input[name=username]").val()==''){
				$("input[name=username]").val("-1");
				$("input[name=password_hash]").val("-1");
				$("input[name=email]").val("123312@qq.com");
				}
			$("#userinfoform").css("display","none");
			}
		$("input[name='m_status']").click(function(){
			v=$("input[name=m_status]:checked").val();
			if(v==1){
				if($("input[name=username]").val()==-1){
				$("input[name=username]").val('');
				$("input[name=password_hash]").val('');
				$("input[name=email]").val('');
				}
				$("#userinfoform").css("display","");
				}
			else{
				if($("input[name=username]").val()==''){
				$("input[name=username]").val("-1");
				$("input[name=password_hash]").val("-1");
				$("input[name=email]").val("123312@qq.com");
				}
				$("input[name=username]").removeClass("point");
				$("input[name=password_hash]").removeClass("point");
				$("input[name=email]").removeClass("point");
				$("#userinfoform").css("display","none");
				}
			});
      $("input#back").click(function(){
    	  location.href="<?php echo Url::toRoute(['index']);?>";
          });
      /* 数据 校验 */
       $("input[name=mobile_num]").blur(function(){//电话号码判断
				 var regp= new RegExp("^[1][358][0-9]{9}$");//电话号码验证
 				 var mobile_num= $("input[name=mobile_num]").val();//电话号码验证
 				if((!regp.test(mobile_num))&&(mobile_num!='')){
 					$("#mobile_num2").css("display","");
 					$("#mobile_num1").css("display","none");
 					$(this).addClass("point");
	 				 }				
				 }).focus(function(){
					 $("#mobile_num1").css("display","none");
					 $("#mobile_num2").css("display","none");
					 $(this).removeClass("point");
					 });
 
      $("input[type=text]").each(function(){//聚焦是清除
			$(this).focus(function(){
				 $(this).next().css("display","none");
				 $(this).removeClass("point");
				});
			 });

      $("input[type=submit]").click(function(){
			var t=0;
			 var regp= new RegExp("^[1][358][0-9]{9}$");//电话号码验证
				 var mobile_num= $("input[name=mobile_num]").val();//电话号码验证
				if((!regp.test(mobile_num))&&(mobile_num!='')){
					$("#mobile_num2").css("display","");
					$("#mobile_num1").css("display","none");
					$("input[name=mobile_num]").addClass("point");
					t=1;return false;
 				 }	
				if($("input[email]").val()==''){//邮箱为空时   			
					$("#emailvalidate").css("display","none");
					$("#emailvalidate1").css("display","");
					t=1;
	       			}			
			 $("input[type=text]").each(function(index){	//如果文本框为空值			
					if($(this).val()==''&&index!=0){
						$(this).next().css("display","");
						$(this).addClass("point");
						t=1;return false;
						}
		       			}); 
		$("input[type=text]").each(function (index){
			if($(this).prop("class")=="point"){
				t=1;return false;
				}
  		}); 
	
		if(t==1){
			return false;
  		} 
		    		
			});
		});
		</script>

	


